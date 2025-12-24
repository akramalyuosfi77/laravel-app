<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Student;
use App\Models\Course;
use App\Models\ProjectFile;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SupervisionRequestReceived;
use App\Notifications\AddedToProjectTeam;
use App\Notifications\TeamInvitationUpdated;
use App\Notifications\NewProjectInteraction;

class MobileProjectsController extends Controller
{
    /**
     * 📋 جلب قائمة المشاريع (مشاريعي، دعوات، مشاريع الدفعة)
     */
    public function index(Request $request)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) return $this->unauthorizedResponse();

        try {
            // 1. دعوات الانضمام المعلقة
            $invitations = Project::with(['creatorStudent', 'course'])
                ->whereHas('students', fn($q) => $q->where('students.id', $student->id)->where('project_student.membership_status', 'pending'))
                ->latest()
                ->get()
                ->map(fn($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'course_name' => $p->course->name ?? '',
                    'creator_name' => $p->creatorStudent->name ?? '',
                    'created_at' => $p->created_at->toDateTimeString(),
                ]);

            // 2. مشاريعي (التي أنا عضو فيها ومقبول أو مكتملة)
            $myProjects = Project::with(['course', 'doctor', 'students'])
                ->whereHas('students', fn($q) => $q->where('student_id', $student->id)->whereIn('project_student.membership_status', ['approved', 'completed']))
                ->latest()
                ->get()
                ->map(fn($p) => $this->formatProjectList($p, $student));

            // 3. مشاريع الدفعة (للاطلاع - الموافق عليها والمكتملة)
            $batchProjects = Project::with(['course', 'doctor', 'students'])
                ->where('batch_id', $student->batch_id) // ✅ تصفية حسب الدفعة
                ->whereIn('status', ['approved', 'completed'])
                ->whereDoesntHave('students', fn($q) => $q->where('student_id', $student->id)) // استبعاد مشاريعي لتجنب التكرار
                ->latest()
                ->take(20)
                ->get()
                ->map(fn($p) => $this->formatProjectList($p, $student));

            return response()->json([
                'status' => true,
                'data' => [
                    'invitations' => $invitations,
                    'my_projects' => $myProjects,
                    'batch_projects' => $batchProjects, // ✅ تم تغيير الاسم ليكون أوضح
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'حدث خطأ: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 👁️ عرض تفاصيل مشروع معين
     */
    public function show(Request $request, $id)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) return $this->unauthorizedResponse();

        try {
            $project = Project::with(['creatorStudent', 'students', 'course', 'doctor', 'files', 'comments.user', 'likes'])
                ->findOrFail($id);

            // التحقق من الصلاحية (هل هو عام أو الطالب عضو فيه)
            $isMember = $project->students->contains($student->id);
            // السماح بالعرض إذا كان الطالب عضوًا أو المشروع معتمدًا ومن نفس الدفعة
            if (!$isMember && !($project->batch_id == $student->batch_id && in_array($project->status, ['approved', 'completed']))) {
                return response()->json(['status' => false, 'message' => 'غير مصرح لك بعرض هذا المشروع'], 403);
            }

            return response()->json([
                'status' => true,
                'data' => [
                    'id' => $project->id,
                    'title' => $project->title,
                    'description' => $project->description,
                    'status' => $project->status,
                    'course_name' => $project->course->name ?? '',
                    'doctor_name' => $project->doctor->name ?? 'لا يوجد مشرف',
                    'creator_name' => $project->creatorStudent->name ?? '',
                    'is_creator' => $project->student_id == $student->id,
                    'members' => $project->students->map(fn($s) => [
                        'id' => $s->id,
                        'name' => $s->name,
                        'status' => $s->pivot->membership_status,
                    ]),
                    'files' => $project->files->map(fn($f) => [
                        'id' => $f->id,
                        'name' => $f->file_name,
                        'url' => asset('storage/' . $f->file_path),
                        'type' => $f->type,
                        'description' => $f->description,
                    ]),
                    'likes_count' => $project->likes->count(),
                    'is_liked' => $project->likes->where('user_id', $student->user_id)->isNotEmpty(),
                    'comments' => $project->comments->map(fn($c) => [
                        'id' => $c->id,
                        'user_name' => $c->user->name ?? 'مستخدم',
                        'comment' => $c->comment,
                        'created_at' => $c->created_at->diffForHumans(),
                    ]),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'المشروع غير موجود'], 404);
        }
    }

    /**
     * ✏️ تعديل مشروع (للمنشئ فقط)
     */
    public function update(Request $request, $id)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) return $this->unauthorizedResponse();

        try {
            $project = Project::findOrFail($id);

            // التحقق من الملكية
            if ($project->student_id != $student->id) {
                return response()->json(['status' => false, 'message' => 'غير مصرح لك بتعديل هذا المشروع'], 403);
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'course_id' => 'nullable|exists:courses,id',
                'doctor_id' => 'nullable|exists:doctors,id',
                'members' => 'nullable|array', // ✅ أعضاء الفريق
                'members.*' => 'exists:students,id',
                'files.*' => 'nullable|file|max:10240', // ✅ ملفات جديدة
                'files_to_delete' => 'nullable|array', // ✅ ملفات للحذف
                'files_to_delete.*' => 'exists:project_files,id',
            ]);

            DB::beginTransaction();

            // ✅ تحديث البيانات الأساسية
            $updateData = [
                'title' => $request->title,
                'description' => $request->description,
            ];

            if ($request->has('course_id')) {
                $updateData['course_id'] = $request->course_id;
            }

            if ($request->has('doctor_id')) {
                $updateData['doctor_id'] = $request->doctor_id;
                $updateData['supervision_status'] = $request->doctor_id ? 'pending' : null;
            }

            $project->update($updateData);

            // ✅ تحديث أعضاء الفريق
            if ($request->has('members')) {
                $currentMembers = $project->students()->pluck('student_id')->toArray();
                $newMembers = array_unique(array_merge($currentMembers, $request->members, [$student->id]));
                $project->students()->sync($newMembers);
            }

            // ✅ رفع ملفات جديدة
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('project_files', 'public');
                    $project->files()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'type' => 'other',
                    ]);
                }
            }

            // ✅ حذف ملفات قديمة
            if ($request->has('files_to_delete')) {
                $filesToDelete = ProjectFile::whereIn('id', $request->files_to_delete)
                    ->where('project_id', $project->id)
                    ->get();
                
                foreach ($filesToDelete as $file) {
                    Storage::disk('public')->delete($file->file_path);
                    $file->delete();
                }
            }

            DB::commit();

            return response()->json(['status' => true, 'message' => 'تم تحديث المشروع بنجاح']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update Project Error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 🗑️ حذف مشروع (للمنشئ فقط)
     */
    public function destroy(Request $request, $id)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) return $this->unauthorizedResponse();

        try {
            $project = Project::findOrFail($id);

            // التحقق من الملكية
            if ($project->student_id != $student->id) {
                return response()->json(['status' => false, 'message' => 'غير مصرح لك بحذف هذا المشروع'], 403);
            }

            // (اختياري) منع الحذف إذا كان المشروع معتمداً
            // if ($project->status == 'approved') {
            //     return response()->json(['status' => false, 'message' => 'لا يمكن حذف مشروع معتمد'], 400);
            // }

            // حذف الملفات المرتبطة (اختياري، يفضل فعله)
            foreach ($project->files as $file) {
                Storage::disk('public')->delete($file->file_path);
                $file->delete();
            }

            $project->delete();

            return response()->json(['status' => true, 'message' => 'تم حذف المشروع بنجاح']);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'حدث خطأ أثناء الحذف'], 500);
        }
    }

    /**
     * ➕ إنشاء مشروع جديد
     */
    public function store(Request $request)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) return $this->unauthorizedResponse();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'members' => 'nullable|array', // IDs of students
            'files.*' => 'nullable|file|max:10240',
        ]);

        try {
            DB::beginTransaction();

            $project = Project::create([
                'title' => $request->title,
                'description' => $request->description,
                'course_id' => $request->course_id,
                'doctor_id' => $request->doctor_id,
                'student_id' => $student->id,
                'batch_id' => $student->batch_id,
                'status' => 'pending',
                'supervision_status' => $request->doctor_id ? 'pending' : null,
                // قيم افتراضية
                'specialization_id' => $student->batch->specialization_id ?? null,
                'academic_year' => $student->batch->current_academic_year ?? date('Y'),
                'semester' => $student->batch->current_semester ?? 1,
            ]);

            // إضافة المنشئ كعضو
            $project->students()->attach($student->id, ['membership_status' => 'approved']);

            // إضافة الأعضاء (Pending)
            if ($request->has('members')) {
                foreach ($request->members as $memberId) {
                    if ($memberId != $student->id) {
                        $project->students()->attach($memberId, ['membership_status' => 'pending']);
                    }
                }
            }

            // رفع الملفات
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('project_files', 'public');
                    $project->files()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'type' => 'other',
                    ]);
                }
            }

            // إشعارات
            if ($project->doctor?->user) {
                Notification::send($project->doctor->user, new SupervisionRequestReceived($project));
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'تم إنشاء المشروع بنجاح', 'data' => ['id' => $project->id]]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Create Project Error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'حدث خطأ أثناء الإنشاء: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 🤝 قبول/رفض دعوة
     */
    public function respondToInvitation(Request $request, $id)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) return $this->unauthorizedResponse();

        $request->validate(['status' => 'required|in:approved,rejected']);

        try {
            $project = Project::findOrFail($id);
            $project->students()->updateExistingPivot($student->id, ['membership_status' => $request->status]);

            // إشعار للمنشئ
            if ($creator = $project->creatorStudent->user) {
                $decision = ($request->status === 'approved') ? 'وافق' : 'رفض';
                $icon = ($request->status === 'approved') ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
                $message = "{$decision} الطالب '{$student->name}' على دعوتك للانضمام لمشروع '{$project->title}'.";
                Notification::send($creator, new TeamInvitationUpdated($project, $message, $icon));
            }

            return response()->json(['status' => true, 'message' => 'تم تحديث حالة الدعوة']);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'حدث خطأ'], 500);
        }
    }

    /**
     * ❤️ الإعجاب بالمشروع
     */
    public function toggleLike(Request $request, $id)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) return $this->unauthorizedResponse();

        try {
            $project = Project::findOrFail($id);
            $user = $student->user; // نفترض وجود علاقة user في موديل Student أو نستخدم Auth::user() إذا كان متاحاً عبر التوكن

            // بما أننا نستخدم التوكن اليدوي، نحتاج لجلب المستخدم المرتبط بالطالب
            // لكن لحظة، التوكن مرتبط بـ User أصلاً.
            // دعنا نستخدم User من التوكن مباشرة.
            $token = $request->bearerToken();
            $accessToken = PersonalAccessToken::findToken($token);
            $user = $accessToken->tokenable;

            if ($project->isLikedByUser($user)) {
                $project->likes()->where('user_id', $user->id)->delete();
                $liked = false;
            } else {
                $project->likes()->create(['user_id' => $user->id]);
                $liked = true;
                
                // إشعار
                // ... (نفس منطق Livewire)
            }

            return response()->json(['status' => true, 'liked' => $liked, 'count' => $project->likes()->count()]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'حدث خطأ'], 500);
        }
    }

    /**
     * 💬 إضافة تعليق
     */
    public function addComment(Request $request, $id)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) return $this->unauthorizedResponse();

        $request->validate(['comment' => 'required|string|max:1000']);

        try {
            $project = Project::findOrFail($id);
            
            $token = $request->bearerToken();
            $accessToken = PersonalAccessToken::findToken($token);
            $user = $accessToken->tokenable;

            $comment = $project->comments()->create([
                'user_id' => $user->id,
                'comment' => $request->comment
            ]);

            return response()->json([
                'status' => true, 
                'data' => [
                    'id' => $comment->id,
                    'user_name' => $user->name,
                    'comment' => $comment->comment,
                    'created_at' => $comment->created_at->diffForHumans()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'حدث خطأ'], 500);
        }
    }

    // --- دوال مساعدة ---

    private function formatProjectList($p, $student)
    {
        return [
            'id' => $p->id,
            'title' => $p->title,
            'description' => $p->description, // قد نحتاج لقص النص
            'course_name' => $p->course->name ?? '',
            'doctor_name' => $p->doctor->name ?? 'لا يوجد',
            'status' => $p->status,
            'members_count' => $p->students->count(),
            'created_at' => $p->created_at->toDateTimeString(),
            'is_creator' => $p->student_id == $student->id, // ✅ إضافة معرف المنشئ
        ];
    }

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
