<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\Doctor;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed; // <-- [إضافة]
use Illuminate\Support\Facades\Log;  // <-- [إضافة]

class DiscussionsManagementPage extends Component
{
    use WithPagination;

    // --- خصائص الفلاتر ---
    public $search = '';
    public $filter_course_id = '';
    public $filter_student_id = '';
    public $filter_doctor_id = '';

    // --- خصائص الحذف ---
    public $discussion_to_delete_id;
    public $reply_to_delete_id;

    // --- خاصية لعرض تفاصيل النقاش ---
    public $viewing_discussion_id;

    public function updating($property)
    {
        if (in_array($property, ['search', 'filter_course_id', 'filter_student_id', 'filter_doctor_id'])) {
            $this->resetPage();
        }
    }

    public function viewDiscussion($discussionId)
    {
        $this->viewing_discussion_id = $discussionId;
    }

    public function confirmDeleteDiscussion($discussionId)
    {
        $this->discussion_to_delete_id = $discussionId;
    }

    /**
     * دالة deleteDiscussion() المحسّنة.
     * تم تغليفها بـ try-catch لمعالجة الأخطاء.
     */
    public function deleteDiscussion()
    {
        try {
            // عند حذف النقاش، سيتم حذف الردود تلقائياً بسبب onDelete('cascade')
            Discussion::findOrFail($this->discussion_to_delete_id)->delete();
            $this->discussion_to_delete_id = null;
            $this->viewing_discussion_id = null;
            $this->dispatch('showToast', message: 'تم حذف النقاش وجميع ردوده بنجاح.', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting discussion: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف النقاش.', type: 'error');
        }
    }

    public function confirmDeleteReply($replyId)
    {
        $this->reply_to_delete_id = $replyId;
    }

    /**
     * دالة deleteReply() المحسّنة.
     * تم تغليفها بـ try-catch لمعالجة الأخطاء.
     */
    public function deleteReply()
    {
        try {
            DiscussionReply::findOrFail($this->reply_to_delete_id)->delete();
            $this->reply_to_delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف الرد بنجاح.', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting discussion reply: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف الرد.', type: 'error');
        }
    }

    // --- [تحسين الأداء] الخصائص المحسوبة ---
    #[Computed(cache: true)]
    public function courses() { return Course::orderBy('name')->get(); }

    #[Computed(cache: true)]
    public function students() { return Student::orderBy('name')->get(); }

    #[Computed(cache: true)]
    public function doctors() { return Doctor::orderBy('name')->get(); }

    public function render()
    {
        // بناء استعلام المناقشات
        $discussionsQuery = Discussion::with(['student.user', 'course'])
            ->withCount('replies')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%')
                      ->orWhereHas('student.user', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            })
            ->when($this->filter_course_id, fn($q) => $q->where('course_id', $this->filter_course_id))
            ->when($this->filter_student_id, fn($q) => $q->where('student_id', $this->filter_student_id))
            ->when($this->filter_doctor_id, function ($query) {
                // [منطق معقد] فلترة المناقشات بناءً على المواد التي يدرسها الدكتور المختار
                $query->whereHas('course.doctors', fn($q) => $q->where('doctors.id', $this->filter_doctor_id));
            })
            ->latest();

        // جلب النقاش المختار للعرض في المودال
        $viewedDiscussion = null;
        if ($this->viewing_discussion_id) {
            $viewedDiscussion = Discussion::with(['replies.user.student', 'replies.user.doctor'])->find($this->viewing_discussion_id);
        }

        return view('livewire.admin.discussions-management-page', [
            'discussions' => $discussionsQuery->paginate(10),
            'viewedDiscussion' => $viewedDiscussion,
        ]);
    }
}
