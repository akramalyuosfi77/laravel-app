<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SubmissionController extends Controller
{
    /**
     * عرض قائمة التسليمات.
     * يمكن فلترتها حسب التكليف، الطالب، أو الحالة.
     * هذه الدالة مفيدة لمدير التطبيق.
     */
    public function index(Request $request)
    {
        $query = Submission::with(['assignment.course', 'student', 'files']);

        // فلترة بناءً على الطالب (مفيد لعرض تسليمات طالب معين)
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->input('student_id'));
        }

        // فلترة بناءً على التكليف (مفيد لعرض كل التسليمات لتكليف معين)
        if ($request->filled('assignment_id')) {
            $query->where('assignment_id', $request->input('assignment_id'));
        }

        // فلترة بناءً على الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $submissions = $query->latest()->get();

        return response()->json($submissions);
    }

    /**
     * تخزين تسليم جديد.
     * هذه هي الدالة الرئيسية التي سيستخدمها الطالب لتقديم تكليف.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'student_id' => 'required|exists:students,id', // في التطبيق الحقيقي، سيتم أخذه من المستخدم المسجل دخوله
            'notes' => 'nullable|string|max:2000',
            'files' => 'required|array|min:1', // يجب أن يكون هناك ملف واحد على الأقل
            'files.*' => 'required|file|mimes:pdf,doc,docx,jpg,png,zip|max:10240', // 10MB max per file
        ]);

        // التأكد من أن الطالب لم يقدم هذا التكليف من قبل
        $existingSubmission = Submission::where('assignment_id', $validatedData['assignment_id'])
                                        ->where('student_id', $validatedData['student_id'])
                                        ->first();

        if ($existingSubmission) {
            throw ValidationException::withMessages([
                'assignment_id' => 'لقد قمت بتسليم هذا التكليف مسبقًا.',
            ]);
        }

        try {
            $submission = Submission::create([
                'assignment_id' => $validatedData['assignment_id'],
                'student_id' => $validatedData['student_id'],
                'notes' => $validatedData['notes'],
                'status' => 'submitted', // الحالة الأولية هي "تم التسليم"
            ]);

            // رفع الملفات وتخزين مساراتها
            foreach ($request->file('files') as $file) {
                $path = $file->store('submissions/' . $submission->id, 'public');
                $submission->files()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                ]);
            }

            return response()->json(['message' => 'تم تقديم التكليف بنجاح.', 'submission' => $submission->load('files')], 201);

        } catch (\Exception $e) {
            Log::error('Error storing submission: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء تقديم التكليف.'], 500);
        }
    }

    /**
     * عرض تفاصيل تسليم معين مع ملفاته.
     */
    public function show(Submission $submission)
    {
        // التأكد من أن المستخدم لديه الصلاحية لرؤية هذا التسليم
        // (إما هو الطالب نفسه أو المدير)
        // if (Auth::id() != $submission->student_id && !Auth::user()->isAdmin()) {
        //     return response()->json(['message' => 'غير مصرح لك.'], 403);
        // }

        return response()->json($submission->load(['assignment.course', 'student', 'files']));
    }

    /**
     * حذف تسليم.
     * يمكن للطالب حذف تسليمه طالما لم يتم تقييمه بعد.
     */
    public function destroy(Submission $submission)
    {
        // التأكد من أن الطالب هو من يحاول الحذف وأن التسليم لم يتم تقييمه
        if ($submission->status === 'graded') {
            return response()->json(['message' => 'لا يمكن حذف تسليم تم تقييمه.'], 403);
        }

        try {
            // حذف الملفات من الـ storage
            foreach ($submission->files as $file) {
                Storage::disk('public')->delete($file->file_path);
            }

            // حذف السجل من قاعدة البيانات (سيتم حذف سجلات الملفات تلقائيًا بسبب علاقة cascade)
            $submission->delete();

            return response()->json(['message' => 'تم حذف التسليم بنجاح.']);

        } catch (\Exception $e) {
            Log::error('Error deleting submission: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء حذف التسليم.'], 500);
        }
    }
}
