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

    // --- خصائص الاختيار ---
    public $selected_course_id = null;
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
     * اختيار مادة معينة لعرض محاضراتها.
     */
    public function selectCourse($id)
    {
        $this->selected_course_id = $id;
        $this->filter_course_id = $id;
        $this->resetPage();
    }

    /**
     * العودة لقائمة المواد.
     */
    public function resetSelection()
    {
        $this->selected_course_id = null;
        $this->filter_course_id = '';
        $this->resetPage();
    }

    /**
     * إعادة تعيين الترقيم عند تغيير الفلاتر.
     */
    public function updating($property)
    {
        if (in_array($property, ['search', 'filter_course_id', 'selected_course_id'])) {
            $this->resetPage();
        }
    }

    // --- دالة العرض الرئيسية ---

    public function render()
    {
        $student = Auth::user()->student;
        if (!$student) {
            return view('livewire.student.lectures-page', [
                'lectures' => collect(),
                'courses' => collect()
            ]);
        }

        $courses = $this->studentCourses;

        // إذا لم يتم اختيار مادة، نعرض المواد أولاً
        if (!$this->selected_course_id && !$this->search) {
            return view('livewire.student.lectures-page', [
                'courses' => $courses,
                'lectures' => collect()
            ]);
        }

        // جلب المحاضرات المرتبطة بالمواد التي يدرسها الطالب بالترتيب
        $lectures = Lecture::with(['course', 'doctor'])
            ->whereIn('course_id', $this->studentCourses()->pluck('id'))
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%'))
            ->when($this->selected_course_id, fn($q) => $q->where('course_id', $this->selected_course_id))
            ->orderBy('lecture_date', 'asc') // ترتيب تصاعدي حسب التاريخ (الأولى فالثانية...)
            ->paginate(12);

        return view('livewire.student.lectures-page', [
            'lectures' => $lectures,
            'courses' => $courses
        ]);
    }
}