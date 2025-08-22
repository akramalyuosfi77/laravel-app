<?php

namespace App\Livewire\Doctor\Reports;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class CourseReportPage extends Component
{
    // خاصية لتخزين ID المقرر الذي يختاره الدكتور
    public $selectedCourseId = null;

    // [تحسين الأداء] خاصية محسوبة لجلب مقررات الدكتور مرة واحدة فقط
    #[Computed(cache: true)]
    public function doctorCourses()
    {
        // جلب المقررات التي يدرسها الدكتور الحالي فقط
        return Auth::user()->doctor?->courses()->orderBy('name')->get() ?? collect();
    }

    public function render()
    {
        return view('livewire.doctor.reports.course-report-page');
    }
}
