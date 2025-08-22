<?php

namespace App\Livewire\Student;

use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use Livewire\Component;

class MySchedulePage extends Component
{
    public $scheduleData = [];
    public $timeSlots = [];
    public $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];

    public function mount()
    {
        $this->generateSchedule();
    }

    public function generateSchedule()
    {
        $student = Auth::user()->student;
        if (!$student || !$student->batch) {
            return;
        }

        // جلب معرفات الخطط الدراسية الخاصة بدفعة الطالب الحالية
        $coursePlanIds = $student->batch->specialization->specializationCourseAcademicPeriods()
            ->where('academic_year', $student->batch->academic_year)
            ->where('semester', $student->batch->semester)
            ->pluck('id');

        // جلب كل المواعيد المرتبطة بهذه الخطط
        $schedules = Schedule::with(['coursePlan.course', 'coursePlan.doctor', 'location'])
            ->whereIn('specialization_course_academic_period_id', $coursePlanIds)
            ->orderBy('start_time')
            ->get();

        // تنظيم البيانات في هيكل مناسب للعرض
        $formattedSchedule = [];
        $timeSlots = [];

        foreach ($schedules as $schedule) {
            $startTime = \Carbon\Carbon::parse($schedule->start_time)->format('h:i A');
            $endTime = \Carbon\Carbon::parse($schedule->end_time)->format('h:i A');
            $timeKey = $startTime . ' - ' . $endTime;

            if (!in_array($timeKey, $timeSlots)) {
                $timeSlots[] = $timeKey;
            }

            $formattedSchedule[$schedule->day_of_week][$timeKey][] = [
                'course_name' => $schedule->coursePlan->course->name,
                'doctor_name' => $schedule->coursePlan->doctor->name ?? 'N/A',
                'location_name' => $schedule->location->name,
                'type' => $schedule->coursePlan->course->type,
            ];
        }

        // فرز الفترات الزمنية
        sort($timeSlots);

        $this->scheduleData = $formattedSchedule;
        $this->timeSlots = $timeSlots;
    }

    public function render()
    {
        return view('livewire.student.my-schedule-page');
    }
}
