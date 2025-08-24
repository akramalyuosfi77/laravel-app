<?php

namespace App\Livewire\Doctor;

use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Notifications\NewReplyToDiscussion;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class CourseDiscussionsPage extends Component
{
    use WithPagination;

    public Course $course;
    public $selectedDiscussionId;
    public $search = '';
    public $newReplyContent = '';

    protected $listeners = ['discussionSelected' => 'selectDiscussion'];

    public function mount(Course $course)
    {
        // [أمان] التأكد من أن الدكتور الحالي يدرس هذه المادة
        if (!Auth::user()->doctor?->courses()->where('courses.id', $course->id)->exists()) {
            abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة.');
        }
        $this->course = $course;
        $firstDiscussion = $this->getDiscussionsQuery()->first();
        if ($firstDiscussion) {
            $this->selectDiscussion($firstDiscussion->id);
        }
    }

    private function getDiscussionsQuery()
    {
        return Discussion::where('course_id', $this->course->id)
            ->with('student.user')
            ->withCount('replies')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%')
                      ->orWhereHas('student.user', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            })
            ->latest();
    }

    public function selectDiscussion($discussionId)
    {
        $this->selectedDiscussionId = $discussionId;
        $this->reset('newReplyContent');
        $this->resetPage('replies-page');
    }

    public function saveNewReply()
    {
        // [أمان] حماية من الإغراق لمنع إرسال ردود كثيرة بسرعة
        if (RateLimiter::tooManyAttempts('forms:' . Auth::id(), 10)) {
            $this->addError('newReplyContent', 'لقد قمت بإرسال الكثير من الردود. يرجى المحاولة مرة أخرى بعد دقيقة.');
            return;
        }
        $this->validate(['newReplyContent' => 'required|string|min:5']);

        try {
            $reply = DiscussionReply::create([
                'discussion_id' => $this->selectedDiscussionId,
                'user_id' => Auth::id(),
                'content' => $this->newReplyContent,
            ]);

            // إرسال إشعار لصاحب السؤال
            $discussionOwner = $reply->discussion->student->user;
            if ($discussionOwner) {
                Notification::send($discussionOwner, new NewReplyToDiscussion($reply));
            }

            $this->reset('newReplyContent');
            $this->dispatch('showToast', message: 'تم إضافة ردك بنجاح!', type: 'success');
            RateLimiter::hit('forms:' . Auth::id());
        } catch (\Exception $e) {
            Log::error('Error saving new reply from doctor: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ الرد.', type: 'error');
        }
    }

    public function toggleStudentReplies()
    {
        try {
            $this->course->student_replies_enabled = !$this->course->student_replies_enabled;
            $this->course->save();
            $message = $this->course->student_replies_enabled ? 'تم تفعيل ردود الطلاب لهذه المادة.' : 'تم إيقاف ردود الطلاب لهذه المادة.';
            $this->dispatch('showToast', message: $message, type: 'info');
        } catch (\Exception $e) {
            Log::error('Error toggling student replies: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء تغيير حالة الردود.', type: 'error');
        }
    }

    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $discussions = $this->getDiscussionsQuery()->paginate(10);
        $selectedDiscussion = null;
        if ($this->selectedDiscussionId) {
            $selectedDiscussion = Discussion::with(['replies.user.student', 'replies.user.doctor'])->find($this->selectedDiscussionId);
        }

        return view('livewire.doctor.course-discussions-page', [
            'discussions' => $discussions,
            'selectedDiscussion' => $selectedDiscussion,
        ]);
    }
}
