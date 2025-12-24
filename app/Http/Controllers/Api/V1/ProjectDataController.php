<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Doctor;
use App\Models\Project;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class ProjectDataController extends Controller
{
    /**
     * دالة مساعدة خاصة للتحقق من التوكن وجلب المستخدم.
     */
    private function _getUserFromToken(Request $request, string $relationsToLoad = '')
    {
        $token = $request->bearerToken();
        if (!$token) return null;

        $accessToken = PersonalAccessToken::findToken($token);
        if (!$accessToken) return null;

        $user = $accessToken->tokenable;

        if ($user && !empty($relationsToLoad)) {
            $user->load($relationsToLoad);
        }

        return $user;
    }

    /**
     * 📚 جلب المواد الدراسية المرتبطة بدفعة الطالب
     */
    public function getCourses(Request $request)
    {
        $user = $this->_getUserFromToken($request, 'student.batch');

        if (!$user || !$user->student) {
            return response()->json(['message' => 'غير مصرح به'], 401);
        }

        $student = $user->student;
        
        // جلب المواد المرتبطة بالدفعة أو التخصص
        $courses = Course::query()
            ->when($student->batch_id, function ($q) use ($student) {
                // يمكنك تخصيص الفلترة حسب batch_id أو specialization_id
                // هنا سنجلب كل المواد للتبسيط، يمكنك تعديلها لاحقاً
                return $q;
            })
            ->select('id', 'name', 'code')
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $courses
        ]);
    }

    /**
     * 👨‍🏫 جلب الدكاترة المرتبطين بمادة معينة
     */
    public function getDoctors(Request $request)
    {
        $user = $this->_getUserFromToken($request, 'student.batch');

        if (!$user || !$user->student) {
            return response()->json(['message' => 'غير مصرح به'], 401);
        }

        $student = $user->student;
        $courseId = $request->query('course_id'); // ✅ جلب معرف المادة من الـ query parameter
        
        // جلب الدكاترة المرتبطين بالمادة المحددة
        $doctors = Doctor::query()
            ->when($courseId, function ($q) use ($courseId) {
                // جلب الدكاترة الذين يدرسون هذه المادة
                return $q->whereHas('courses', function ($query) use ($courseId) {
                    $query->where('courses.id', $courseId);
                });
            })
            ->when(!$courseId && $student->batch && $student->batch->specialization_id, function ($q) use ($student) {
                // إذا لم يتم تحديد مادة، نجلب دكاترة التخصص
                return $q->where('specialization_id', $student->batch->specialization_id);
            })
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $doctors
        ]);
    }

    /**
     * 👥 جلب الطلاب من نفس الدفعة (لدعوتهم للمشروع)
     */
    public function getStudents(Request $request)
    {
        $user = $this->_getUserFromToken($request, 'student.batch');

        if (!$user || !$user->student) {
            return response()->json(['message' => 'غير مصرح به'], 401);
        }

        $currentStudent = $user->student;
        
        // ✅ التحقق من وجود batch_id
        if (!$currentStudent->batch_id) {
            \Log::warning('Student has no batch_id', ['student_id' => $currentStudent->id]);
            return response()->json([
                'status' => true,
                'data' => [],
                'message' => 'الطالب غير مرتبط بدفعة'
            ]);
        }
        
        // جلب طلاب نفس الدفعة (باستثناء الطالب الحالي)
        $students = \App\Models\Student::query()
            ->where('batch_id', $currentStudent->batch_id)
            ->where('id', '!=', $currentStudent->id) // استبعاد الطالب الحالي
            ->select('id', 'name', 'email', 'student_id_number') // ✅ تم التصحيح
            ->orderBy('name')
            ->get();

        \Log::info('Fetched students', [
            'current_student_id' => $currentStudent->id,
            'batch_id' => $currentStudent->batch_id,
            'students_count' => $students->count()
        ]);

        return response()->json([
            'status' => true,
            'data' => $students
        ]);
    }

    /**
     * يجلب المشاريع التي يشارك فيها الطالب حالياً.
     */
    public function getMyProjects(Request $request)
    {
        $user = $this->_getUserFromToken($request, 'student');

        if (!$user || !$user->student) {
            return response()->json(['message' => 'غير مصرح به أو لا يوجد ملف طالب.'], 401);
        }

        $student = $user->student;

        $myProjects = Project::with('course')
            ->whereHas('students', function ($query) use ($student) {
                $query->where('student_id', $student->id)
                      ->where('project_student.membership_status', 'approved');
            })
            ->select('title', 'status', 'course_id')
            ->latest()
            ->get();

        return response()->json($myProjects);
    }
}
