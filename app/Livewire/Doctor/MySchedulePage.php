<?php

namespace App\Livewire\Doctor;

use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
        try {
            $doctor = Auth::user()->doctor;
            if (!$doctor) {
                return;
            }

            // جلب معرفات الخطط الدراسية المسندة لهذا الدكتور
            $coursePlanIds = $doctor->specializationCourseAcademicPeriods()->pluck('id');

            // جلب كل المواعيد المرتبطة بهذه الخطط مع العلاقات اللازمة
            $schedules = Schedule::with(['location', 'coursePlan.course', 'coursePlan.specialization'])
                ->whereIn('specialization_course_academic_period_id', $coursePlanIds)
                ->orderBy('start_time')
                ->get();

            $formattedSchedule = [];
            $timeSlots = [];

            foreach ($schedules as $schedule) {
                $startTime = Carbon::parse($schedule->start_time)->format('h:i A');
                $endTime = Carbon::parse($schedule->end_time)->format('h:i A');
                $timeKey = $startTime . ' - ' . $endTime;

                if (!in_array($timeKey, $timeSlots)) {
                    $timeSlots[] = $timeKey;
                }

                $batchInfo = 'سنة ' . $schedule->coursePlan->academic_year . ' / ترم ' . $schedule->coursePlan->semester;

                $formattedSchedule[$schedule->day_of_week][$timeKey][] = [
                    'course_name' => $schedule->coursePlan->course->name,
                    'course_code' => $schedule->coursePlan->course->code,
                    'specialization_name' => $schedule->coursePlan->specialization->name,
                    'location_name' => $schedule->location->name,
                    'type' => $schedule->coursePlan->course->type,
                    'batch_info' => $batchInfo,
                ];
            }

            // فرز الفترات الزمنية
            usort($timeSlots, fn($a, $b) => Carbon::parse(explode(' - ', $a)[0]) <=> Carbon::parse(explode(' - ', $b)[0]));

            $this->scheduleData = $formattedSchedule;
            $this->timeSlots = $timeSlots;
        } catch (\Exception $e) {
            Log::error('Error generating doctor schedule: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء تحميل الجدول الدراسي.', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.doctor.my-schedule-page');
    }
}
