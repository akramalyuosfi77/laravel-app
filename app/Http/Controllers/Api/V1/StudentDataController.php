<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Schedule;
use App\Models\Attendance; // <-- تأكد من وجود هذا السطر
use App\Models\Announcement; // <-- تأكد من وجود هذا السطر
use Laravel\Sanctum\PersonalAccessToken;

class StudentDataController extends Controller
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
     * يجلب الواجبات القادمة للطالب.
     */
    public function getAssignments(Request $request)
    {
        $user = $this->_getUserFromToken($request, 'student');
        if (!$user || !$user->student) {
            return response()->json(['message' => 'غير مصرح به أو لا يوجد ملف طالب.'], 401);
        }
        $student = $user->student;
        $courseIds = $student->getCurrentCourses()->pluck('id');
        $assignments = Assignment::whereIn('course_id', $courseIds)
            ->where('deadline', '>', now())
            ->select('title', 'deadline')
            ->orderBy('deadline', 'asc')
            ->get();
        return response()->json($assignments);
    }

    /**
     * يجلب الجدول الدراسي الأسبوعي الكامل للطالب.
     */
    public function getFullSchedule(Request $request)
    {
        $user = $this->_getUserFromToken($request, 'student.batch.specialization');
        if (!$user || !$user->student || !$user->student->batch) {
            return response()->json(['message' => 'غير مصرح به أو بيانات الطالب/الدفعة غير مكتملة.'], 401);
        }
        $student = $user->student;
        $batchAcademicYear = $student->batch->academic_year;
        $batchSemester = $student->batch->semester;
        $coursePlanIds = $student->batch->specialization->specializationCourseAcademicPeriods()
            ->where('academic_year', $batchAcademicYear)
            ->where('semester', $batchSemester)
            ->pluck('id');
        $fullSchedule = Schedule::with(['coursePlan.course', 'coursePlan.doctor', 'location'])
            ->whereIn('specialization_course_academic_period_id', $coursePlanIds)
            ->orderBy('day_of_week')->orderBy('start_time', 'asc')->get()
            ->map(function ($item) {
                $item->start_time = \Carbon\Carbon::parse($item->start_time)->format('H:i:s');
                $item->end_time = \Carbon\Carbon::parse($item->end_time)->format('H:i:s');
                return $item;
            });
        return response()->json($fullSchedule);
    }

    /**
     * يجلب آخر 5 إعلانات موجهة للطالب.
     */
    public function getAnnouncements(Request $request)
    {
        $user = $this->_getUserFromToken($request, 'student.batch.specialization');
        if (!$user || !$user->isStudent() || !$user->student) {
            return response()->json(['message' => 'غير مصرح به أو لا يوجد ملف طالب.'], 401);
        }
        $student = $user->student;
        $query = Announcement::where(function ($q) {
            $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
        });
        $announcements = $query->where(function ($q) use ($student) {
            $q->orWhere('target_type', 'global_all')->orWhere('target_type', 'global_students');
            if ($student->batch && $student->batch->specialization) {
                $departmentId = $student->batch->specialization->department_id;
                $specializationId = $student->batch->specialization_id;
                $courseIds = $student->getCurrentCourses()->pluck('id')->toArray();
                if ($departmentId) {
                    $q->orWhere(fn($subQ) => $subQ->where('target_type', 'department')->where('target_id', $departmentId));
                }
                if ($specializationId) {
                    $q->orWhere(fn($subQ) => $subQ->where('target_type', 'specialization')->where('target_id', $specializationId));
                }
                if (!empty($courseIds)) {
                    $q->orWhere(fn($subQ) => $subQ->where('target_type', 'course')->whereIn('target_id', $courseIds));
                }
            }
        })->latest()->take(5)->select('title', 'content', 'level', 'created_at')->get();
        return response()->json($announcements);
    }

    /**
     * يجلب ملخص الحضور والغياب للطالب في مواده الحالية.
     * (النسخة النهائية والمطابقة لمنطقك الاحترافي)
     */
    public function getAttendanceSummary(Request $request)
    {
        $user = $this->_getUserFromToken($request, 'student');
        if (!$user || !$user->student) {
            return response()->json(['message' => 'غير مصرح به أو لا يوجد ملف طالب.'], 401);
        }
        $student = $user->student;
        $currentCourses = $student->getCurrentCourses()->get();
        $summary = [];
        foreach ($currentCourses as $course) {
            $totalLectures = \App\Models\Lecture::where('course_id', $course->id)->count();
            if ($totalLectures > 0) {
                $attendedCount = Attendance::where('student_id', $student->id)
                    ->where('status', 'present')
                    ->whereHas('lecture', function ($query) use ($course) {
                        $query->where('course_id', $course->id);
                    })
                    ->count();
                $attendancePercentage = round(($attendedCount / $totalLectures) * 100);
            } else {
                $attendancePercentage = 100;
            }
            $summary[] = [
                'course_name' => $course->name,
                'attendance_percentage' => $attendancePercentage,
            ];
        }
        return response()->json($summary);
    }
}
