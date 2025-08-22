<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Discussion; // 💡 استيراد موديل النقاش

class NewDiscussionStarted extends Notification
{
    use Queueable;

    public $discussion;

    /**
     * Create a new notification instance.
     */
    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $studentName = $this->discussion->student->name ?? 'طالب';
        $courseName = $this->discussion->course->name ?? 'مادة';
        $discussionTitle = $this->discussion->title;

        return [
            'discussion_id' => $this->discussion->id,
            'student_name' => $studentName,
            'course_name' => $courseName,
            'message' => "سؤال جديد من '{$studentName}' في مادة '{$courseName}' بعنوان: '{$discussionTitle}'.",
            // 💡 هذا الرابط سيوجه الدكتور مباشرة لصفحة النقاشات الخاصة بالمادة
            'url' => route('doctor.courses.discussions', ['course' => $this->discussion->course_id]),
            'icon' => 'bi-patch-question-fill' // أيقونة مناسبة للأسئلة
        ];
    }
}
