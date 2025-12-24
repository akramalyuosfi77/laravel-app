<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Submission;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Notifications\NewSubmissionReceived;
use Illuminate\Support\Facades\Notification;

class MobileAssignmentsController extends Controller
{
    /**
     * 📋 جلب قائمة التكليفات (Assignments)
     */
    public function index(Request $request)
    {
        // 🔐 التحقق من التوكن
        $student = $this->getStudentFromToken($request);
        if (!$student) return $this->unauthorizedResponse();

        try {
            $filterStatus = $request->query('status'); // pending, submitted, late, graded

            $assignments = Assignment::with(['course:id,name', 'doctor:id,name', 'submissions' => function ($q) use ($student) {
                $q->where('student_id', $student->id)->select('id', 'assignment_id', 'status', 'grade', 'created_at');
            }])
            ->whereIn('course_id', $student->getCurrentCourses()->pluck('id'))
            ->when($filterStatus, function ($query) use ($student, $filterStatus) {
                if ($filterStatus == 'submitted') {
                    $query->whereHas('submissions', fn($q) => $q->where('student_id', $student->id));
                } elseif ($filterStatus == 'pending') {
                    $query->whereDoesntHave('submissions', fn($q) => $q->where('student_id', $student->id))
                          ->where('deadline', '>=', now());
                } elseif ($filterStatus == 'late') {
                    $query->whereDoesntHave('submissions', fn($q) => $q->where('student_id', $student->id))
                          ->where('deadline', '<', now());
                } elseif ($filterStatus == 'graded') {
                    $query->whereHas('submissions', fn($q) => $q->where('student_id', $student->id)->whereNotNull('grade'));
                }
            })
            ->latest('deadline')
            ->get()
            ->map(function ($assignment) use ($student) {
                $submission = $assignment->submissions->first();
                return [
                    'id'          => $assignment->id,
                    'title'       => $assignment->title,
                    'course_name' => $assignment->course->name ?? 'غير محدد',
                    'doctor_name' => $assignment->doctor->name ?? 'غير محدد',
                    'deadline'    => $assignment->deadline->toDateTimeString(),
                    'is_late'     => Carbon::now()->greaterThan($assignment->deadline),
                    'status'      => $submission ? $submission->status : 'pending',
                    'grade'       => $submission ? $submission->grade : null,
                    'submitted_at'=> $submission ? $submission->created_at->toDateTimeString() : null,
                ];
            });

            return response()->json(['status' => true, 'data' => $assignments]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'حدث خطأ: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 👁️ عرض تفاصيل تكليف معين
     */
    public function show(Request $request, $id)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) return $this->unauthorizedResponse();

        try {
            $assignment = Assignment::with(['course', 'doctor'])->findOrFail($id);
            
            // التحقق من أن الطالب مسجل في المادة
            if (!$student->getCurrentCourses()->pluck('id')->contains($assignment->course_id)) {
                return response()->json(['status' => false, 'message' => 'غير مصرح لك بالوصول لهذا التكليف'], 403);
            }

            $submission = Submission::with('files')
                ->where('assignment_id', $id)
                ->where('student_id', $student->id)
                ->first();

            return response()->json([
                'status' => true,
                'data' => [
                    'assignment' => [
                        'id'          => $assignment->id,
                        'title'       => $assignment->title,
                        'description' => $assignment->description,
                        'course_name' => $assignment->course->name ?? '',
                        'doctor_name' => $assignment->doctor->name ?? '',
                        'deadline'    => $assignment->deadline->toDateTimeString(),
                        'files'       => [], // لا توجد ملفات للتكليف حالياً
                    ],
                    'submission' => $submission ? [
                        'id'          => $submission->id,
                        'title'       => $submission->title,
                        'description' => $submission->description,
                        'status'      => $submission->status,
                        'grade'       => $submission->grade,
                        'feedback'    => $submission->feedback,
                        'files'       => $submission->files->map(fn($f) => ['id' => $f->id, 'name' => $f->file_name, 'url' => asset('storage/' . $f->file_path)]),
                        'submitted_at'=> $submission->created_at->toDateTimeString(),
                    ] : null,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'التكليف غير موجود'], 404);
        }
    }

    /**
     * 📤 رفع حل التكليف
     */
    public function submit(Request $request, $id)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) return $this->unauthorizedResponse();

        $assignment = Assignment::find($id);
        if (!$assignment) return response()->json(['status' => false, 'message' => 'التكليف غير موجود'], 404);

        // التحقق من الموعد النهائي
        if (Carbon::now()->greaterThan($assignment->deadline)) {
            return response()->json(['status' => false, 'message' => 'انتهى موعد التسليم'], 400);
        }

        $request->validate([
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'files.*'     => 'nullable|file|max:10240', // 10MB max
        ]);

        try {
            DB::beginTransaction();

            $submission = Submission::updateOrCreate(
                ['assignment_id' => $id, 'student_id' => $student->id],
                [
                    'title'       => $request->title,
                    'description' => $request->description,
                    'status'      => 'submitted'
                ]
            );

            // رفع الملفات
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('submissions', 'public');
                    $submission->files()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize()
                    ]);
                }
            }

            // إشعار الدكتور
            if ($assignment->doctor?->user) {
                Notification::send($assignment->doctor->user, new NewSubmissionReceived($submission));
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'تم تسليم التكليف بنجاح']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Submission Error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'حدث خطأ أثناء التسليم'], 500);
        }
    }

    // --- دوال مساعدة ---

    private function getStudentFromToken(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) return null;
        $accessToken = PersonalAccessToken::findToken($token);
        if (!$accessToken || !$accessToken->tokenable) return null;
        return $accessToken->tokenable->student;
    }

    private function unauthorizedResponse()
    {
        return response()->json(['status' => false, 'message' => 'غير مصرح لك'], 401);
    }
}
