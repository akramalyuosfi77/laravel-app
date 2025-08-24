<?php

namespace App\Livewire\Doctor\Reports\Widgets;

use App\Models\Course;
use App\Models\Project;
use App\Models\Submission;
use Livewire\Component;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Facades\Log;

class CourseStatsWidget extends Component
{
    #[Reactive]
    public $courseId;

    public $studentsCount = 0;
    public $projectsCount = 0;
    public $pendingSubmissionsCount = 0;
    public $discussionsCount = 0;

    public function mount()
    {
        $this->loadStats();
    }

    public function updatedCourseId()
    {
        $this->loadStats();
    }

    public function loadStats()
{
    // 💡 بدلاً من reset()، نقوم بتعيين القيم الافتراضية يدوياً
    // هذا لا يتعارض مع الخاصية التفاعلية
    $this->studentsCount = 0;
    $this->projectsCount = 0;
    $this->pendingSubmissionsCount = 0;
    $this->discussionsCount = 0;

    if (!$this->courseId) {
        return;
    }

    try {
        $course = Course::findOrFail($this->courseId);

        // جلب عدد الطلاب في المقرر باستخدام العلاقة المحسنة
        $this->studentsCount = $course->students()->count();

        // جلب عدد المشاريع المرتبطة بالمقرر
        $this->projectsCount = Project::where('course_id', $this->courseId)->count();

        // جلب عدد التسليمات التي تحتاج تقييم في هذا المقرر
        $this->pendingSubmissionsCount = Submission::whereHas('assignment', function ($query) {
            $query->where('course_id', $this->courseId);
        })->where('status', 'submitted')->count();

        // جلب عدد المناقشات في هذا المقرر
        $this->discussionsCount = $course->discussions()->count();

    } catch (\Exception $e) {
        Log::error('Error loading course stats widget: ' . $e->getMessage());
        $this->dispatch('showToast', message: 'حدث خطأ أثناء تحميل إحصائيات المقرر.', type: 'error');
    }
}

    public function render()
    {
        return view('livewire.doctor.reports.widgets.course-stats-widget');
    }
}
