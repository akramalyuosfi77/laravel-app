<?php

namespace App\Livewire\Student;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Attendance;

class MyAttendancePage extends Component
{
    // خاصية لتخزين بيانات الحضور النهائية التي ستُعرض
    public $attendanceSummary = [];

    // خاصية لتخزين تفاصيل الحضور لمادة معينة عند طلبها
    public $detailsForCourse = null;

    /**
     * دالة mount تُنفذ عند تحميل المكون.
     */
    public function mount()
    {
        $this->calculateAttendanceSummary();
    }

    /**
     * هذه هي الدالة الرئيسية التي تقوم بكل الحسابات.
     */
    public function calculateAttendanceSummary()
    {
        try {
            $student = Auth::user()->student;
            if (!$student) {
                $this->attendanceSummary = [];
                return;
            }

            // 1. جلب المواد الحالية للطالب
            $courses = $student->getCurrentCourses()->get();
            $summary = [];

            foreach ($courses as $course) {
                // 2. جلب كل المحاضرات الخاصة بهذه المادة
                $totalLectures = Lecture::where('course_id', $course->id)->count();

                if ($totalLectures > 0) {
                    // 3. حساب عدد مرات الحضور (present) للطالب في هذه المادة
                    $presentCount = Attendance::where('student_id', $student->id)
                        ->where('status', 'present')
                        ->whereHas('lecture', function ($query) use ($course) {
                            $query->where('course_id', $course->id);
                        })
                        ->count();

                    // 4. حساب النسبة المئوية
                    $percentage = ($presentCount / $totalLectures) * 100;

                } else {
                    $presentCount = 0;
                    $percentage = 100; // إذا لم تكن هناك محاضرات، فنسبة الحضور 100%
                }

                // 5. تجميع البيانات للعرض
                $summary[] = [
                    'course_id' => $course->id,
                    'course_name' => $course->name,
                    'course_code' => $course->code,
                    'total_lectures' => $totalLectures,
                    'present_count' => $presentCount,
                    'absent_count' => $totalLectures - $presentCount,
                    'percentage' => round($percentage),
                ];
            }

            $this->attendanceSummary = $summary;

        } catch (\Exception $e) {
            Log::error('Error calculating attendance summary for student: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حساب سجل الحضور.', type: 'error');
        }
    }

    /**
     * دالة لجلب التفاصيل عند الضغط على زر "عرض التفاصيل".
     *
     * @param int $courseId
     */
    public function showDetails(int $courseId)
    {
        try {
            $student = Auth::user()->student;
            $course = Course::findOrFail($courseId);

            // جلب كل المحاضرات لهذه المادة
            $lectures = Lecture::where('course_id', $courseId)->orderBy('lecture_date', 'desc')->get();

            // جلب سجل حضور الطالب لهذه المحاضرات فقط
            $attendanceRecords = Attendance::where('student_id', $student->id)
                ->whereIn('lecture_id', $lectures->pluck('id'))
                ->pluck('status', 'lecture_id');

            // دمج البيانات معاً
            $details = $lectures->map(function ($lecture) use ($attendanceRecords) {
                return [
                    'lecture_title' => $lecture->title,
                    'lecture_date' => $lecture->lecture_date,
                    // إذا لم يوجد سجل، نعتبره غائباً
                    'status' => $attendanceRecords[$lecture->id] ?? 'absent',
                ];
            });

            $this->detailsForCourse = [
                'course_name' => $course->name,
                'records' => $details,
            ];

        } catch (\Exception $e) {
            Log::error('Error showing attendance details: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء عرض التفاصيل.', type: 'error');
        }
    }

    /**
     * دالة لإغلاق نافذة التفاصيل.
     */
    public function closeDetailsModal()
    {
        $this->detailsForCourse = null;
    }

    public function render()
    {
        return view('livewire.student.my-attendance-page');
    }
}
