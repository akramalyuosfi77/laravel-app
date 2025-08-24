<?php

namespace App\Livewire\Student;

use App\Models\Lecture;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;

class LecturesPage extends Component
{
    use WithPagination;

    // --- خصائص البحث والفلاتر ---
    public $search = '';
    public $filter_course_id = '';

    // --- خصائص الواجهة ---
    public $showViewModal = false;
    public $viewedLecture = null;

    // --- [تحسين الأداء] الخصائص المحسوبة ---

    /**
     * خاصية محسوبة لجلب مواد الطالب مرة واحدة وتخزينها مؤقتاً.
     * هذا يمنع إعادة الاستعلام في كل تحديث للواجهة.
     */


// ... داخل كلاس LecturesPage ...

#[Computed(cache: true)]
public function studentCourses()
{
    try {
        // [تصحيح] نستدعي الدالة التي ترجع استعلاماً ثم ننفذه بـ get()
        return Auth::user()->student?->getCurrentCourses()->get() ?? collect();
    } catch (\Exception $e) {
        Log::error('Error fetching student courses: ' . $e->getMessage());
        return collect();
    }
}



    // --- دوال التحكم ---

    /**
     * عرض تفاصيل المحاضرة في نافذة منبثقة.
     */
    public function viewLecture($id)
    {
        try {
            // [أمان] التأكد من أن الطالب مسجل في مادة هذه المحاضرة قبل عرضها
            $lecture = Lecture::with(['course', 'doctor', 'files'])->findOrFail($id);
            if ($this->studentCourses()->contains('id', $lecture->course_id)) {
                $this->viewedLecture = $lecture;
                $this->showViewModal = true;
            } else {
                $this->dispatch('showToast', message: 'غير مصرح لك بعرض هذه المحاضرة.', type: 'error');
            }
        } catch (\Exception $e) {
            Log::error('Error viewing lecture: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على المحاضرة المطلوبة.', type: 'error');
        }
    }

    /**
     * إغلاق نافذة عرض التفاصيل.
     */
    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewedLecture = null;
    }

    /**
     * إعادة تعيين الترقيم عند تغيير الفلاتر.
     */
    public function updating($property)
    {
        if (in_array($property, ['search', 'filter_course_id'])) {
            $this->resetPage();
        }
    }

    // --- دالة العرض الرئيسية ---

    public function render()
    {
        $student = Auth::user()->student;
        if (!$student) {
            return view('livewire.student.lectures-page', ['lectures' => collect()]);
        }

        // جلب المحاضرات المرتبطة بالمواد التي يدرسها الطالب
        $lectures = Lecture::with(['course', 'doctor'])
            ->whereIn('course_id', $this->studentCourses()->pluck('id'))
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%'))
            ->when($this->filter_course_id, fn($q) => $q->where('course_id', $this->filter_course_id))
            ->latest()
            ->paginate(10);

        return view('livewire.student.lectures-page', ['lectures' => $lectures]);
    }
}
