<?php

namespace App\Livewire\Student;

use App\Models\Assignment;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Computed;

class StudentDashboard extends Component
{
    // --- [تحسين] استخدام الخصائص المحسوبة لتخزين البيانات مؤقتاً ---

    #[Computed(cache: true, key: 'student-dashboard-stats')]
    public function stats()
    {
        try {
            $student = Auth::user()->student;
            if (!$student) return $this->getEmptyStats();

            $currentCourses = $student->getCurrentCourses()->get();
            $submittedAssignmentIds = $student->submissions()->pluck('assignment_id');

            // [تحسين] استعلام أبسط وأكثر وضوحاً للتكاليف المتبقية
            $pendingAssignmentsCount = Assignment::whereIn('course_id', $currentCourses->pluck('id'))
                ->whereNotIn('id', $submittedAssignmentIds)
                ->where('deadline', '>=', now())
                ->count();

            return [
                'currentCoursesCount' => $currentCourses->count(),
                'activeProjectsCount' => $student->projects()->where('status', 'in_progress')->count(),
                'pendingAssignmentsCount' => $pendingAssignmentsCount,
                'myDiscussionsCount' => Discussion::where('student_id', $student->id)->count(),
            ];
        } catch (\Exception $e) {
            Log::error('Error loading student dashboard stats: ' . $e->getMessage());
            return $this->getEmptyStats();
        }
    }

    #[Computed(cache: true, key: 'student-dashboard-activities')]
    public function recentActivities()
    {
        return Auth::user()->notifications()->latest()->take(5)->get();
    }

    #[Computed(cache: true, key: 'student-dashboard-grades')]
    public function gradesChartData()
    {
        try {
            $student = Auth::user()->student;
            if (!$student) return ['labels' => [], 'data' => [], 'feedback' => []];

            $latestGrades = $student->submissions()
                ->whereNotNull('grade')
                ->with('assignment:id,title') // [تحسين] جلب الأعمدة المطلوبة فقط
                ->latest('updated_at')
                ->take(5)
                ->get()
                ->reverse();

            return [
                'labels' => $latestGrades->map(fn($sub) => $sub->assignment->title ?? 'تكليف')->toArray(),
                'data' => $latestGrades->pluck('grade')->toArray(),
                'feedback' => $latestGrades->pluck('feedback')->map(fn($fb) => $fb ?: 'لا يوجد تقييم')->toArray(),
            ];
        } catch (\Exception $e) {
            Log::error('Error loading student grades chart data: ' . $e->getMessage());
            return ['labels' => [], 'data' => [], 'feedback' => []];
        }
    }

    // --- دوال مساعدة ---

    /**
     * دالة مساعدة لإرجاع قيم صفرية في حالة عدم وجود طالب.
     */
    private function getEmptyStats(): array
    {
        return [
            'currentCoursesCount' => 0,
            'activeProjectsCount' => 0,
            'pendingAssignmentsCount' => 0,
            'myDiscussionsCount' => 0,
        ];
    }

    /**
     * دالة لإعادة تحميل كل البيانات عند الحاجة.
     */
    public function refreshDashboard()
    {
        // مسح الكاش للخصائص المحسوبة لإجبارها على إعادة التحميل
        unset($this->stats);
        unset($this->recentActivities);
        unset($this->gradesChartData);

        // إرسال البيانات المحدثة إلى المتصفح
        $this->dispatch('gradesChartUpdated', $this->gradesChartData);
    }

    // --- دالة العرض الرئيسية ---

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
