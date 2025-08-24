<?php

namespace App\Livewire\Student;

use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Notifications\NewDiscussionStarted;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewReplyToDiscussion;
use App\Livewire\Traits\WithSecureFileUploads;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CourseDiscussionsPage extends Component
{
    use WithPagination, WithFileUploads, WithSecureFileUploads;

    // --- الخصائص الأساسية ---
    public Course $course;
    public $selectedDiscussionId = null;

    // --- خصائص النموذج ---
    public $showNewDiscussionForm = false;
    public $newDiscussionTitle = '';
    public $newDiscussionContent = '';
    public $newDiscussionImage;
    public $newReplyContent = '';

    // --- خصائص البحث ---
    public $search = '';

    // --- قواعد التحقق ---
    // protected function rules()
    // {
    //     return [
    //         'newDiscussionTitle' => 'required|string|min:10|max:255',
    //         'newDiscussionContent' => 'required|string|min:20',
    //         'newReplyContent' => 'required|string|min:5',
    //         'newDiscussionImage' => $this->secureFileUploadRules(2048), // 2MB max
    //     ];
    // }

    protected $messages = [
        'newDiscussionTitle.required' => 'عنوان النقاش مطلوب.',
        'newDiscussionTitle.min' => 'يجب أن يكون عنوان النقاش 10 أحرف على الأقل.',
        'newDiscussionContent.required' => 'محتوى السؤال مطلوب.',
        'newDiscussionContent.min' => 'يجب أن يكون محتوى السؤال 20 حرفًا على الأقل.',
        'newReplyContent.required' => 'محتوى الرد مطلوب.',
        'newReplyContent.min' => 'يجب أن يكون الرد 5 أحرف على الأقل.',
    ];

    public function mount(Course $course)
    {
        $this->course = $course;
    }

    public function openNewDiscussionForm()
    {
        $this->reset(['newDiscussionTitle', 'newDiscussionContent', 'newDiscussionImage']);
        $this->showNewDiscussionForm = true;
        $this->selectedDiscussionId = null;
    }

    // ... داخل كلاس CourseDiscussionsPage الخاص بالطالب ...

public function saveNewDiscussion()
{
    // [تصحيح] نحدد القواعد التي نريد التحقق منها فقط لهذا الإجراء
    $this->validate([
        'newDiscussionTitle' => 'required|string|min:10|max:255',
        'newDiscussionContent' => 'required|string|min:20',
        'newDiscussionImage' => $this->secureFileUploadRules(2048), // 2MB max
    ]);

    try {
        $imagePath = $this->newDiscussionImage ? $this->newDiscussionImage->store('discussion_images', 'public') : null;

        $discussion = Discussion::create([
            'course_id' => $this->course->id,
            'student_id' => Auth::user()->student->id,
            'title' => $this->newDiscussionTitle,
            'content' => $this->newDiscussionContent,
            'image_path' => $imagePath,
        ]);

        $doctors = $discussion->course->doctors->pluck('user')->filter();
        if ($doctors->isNotEmpty()) {
            Notification::send($doctors, new NewDiscussionStarted($discussion));
        }

        $this->showNewDiscussionForm = false;
        $this->selectDiscussion($discussion->id);
        $this->dispatch('showToast', message: 'تم طرح سؤالك بنجاح!', type: 'success');
    } catch (\Exception $e) {
        Log::error('Error saving new discussion: ' . $e->getMessage());
        $this->dispatch('showToast', message: 'حدث خطأ أثناء طرح السؤال.', type: 'error');
    }
}


    public function selectDiscussion($discussionId)
    {
        $this->selectedDiscussionId = $discussionId;
        $this->showNewDiscussionForm = false;
        $this->reset('newReplyContent');
    }

    // ... داخل كلاس CourseDiscussionsPage الخاص بالطالب ...

public function saveNewReply()
{
    if (!$this->selectedDiscussionId) return;

    $throttleKey = 'discussion-reply:' . Auth::id();
    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
        $this->addError('newReplyContent', 'لقد قمت بإرسال الكثير من الردود. يرجى المحاولة مرة أخرى بعد دقيقة.');
        return;
    }

    // [تصحيح] نحدد القاعدة التي نريد التحقق منها فقط لهذا الإجراء
    $this->validate([
        'newReplyContent' => 'required|string|min:5',
    ]);

    try {
        $reply = DiscussionReply::create([
            'discussion_id' => $this->selectedDiscussionId,
            'user_id' => Auth::id(),
            'content' => $this->newReplyContent,
        ]);

        $discussion = $reply->discussion;
        $recipients = collect([$discussion->student->user])
            ->merge($discussion->course->doctors->pluck('user'))
            ->filter()
            ->unique('id')
            ->reject(fn($user) => $user->id === Auth::id());

        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new NewReplyToDiscussion($reply));
        }

        $this->reset('newReplyContent');
        $this->dispatch('showToast', message: 'تم إضافة ردك بنجاح!', type: 'success');
        RateLimiter::hit($throttleKey);
    } catch (\Exception $e) {
        Log::error('Error saving new reply: ' . $e->getMessage());
        $this->dispatch('showToast', message: 'حدث خطأ أثناء إضافة الرد.', type: 'error');
    }
}


    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $discussions = $this->course->discussions()
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->with('student.user')
            ->withCount('replies')
            ->latest()
            ->paginate(10);

        $selectedDiscussion = null;
        if ($this->selectedDiscussionId) {
            // [إصلاح] تم جلب كل العلاقات المطلوبة هنا
            $selectedDiscussion = Discussion::with(['student.user', 'replies.user.student', 'replies.user.doctor'])->find($this->selectedDiscussionId);
        }

        return view('livewire.student.course-discussions-page', [
            'discussions' => $discussions,
            'selectedDiscussion' => $selectedDiscussion,
        ]);
    }
}
