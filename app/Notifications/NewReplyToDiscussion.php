<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\DiscussionReply; // 💡 استيراد موديل الرد

class NewReplyToDiscussion extends Notification
{
    use Queueable;

    public $reply;

    /**
     * Create a new notification instance.
     */
    public function __construct(DiscussionReply $reply)
    {
        $this->reply = $reply;
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
        $replierName = $this->reply->user->name ?? 'أحدهم';
        $discussionTitle = $this->reply->discussion->title ?? 'سؤالك';

        // 💡 1. تحديد الرابط بناءً على دور المستلم ($notifiable)
        $url = '';
        if ($notifiable->role === 'student') {
            $url = route('student.courses.discussions', ['course' => $this->reply->discussion->course_id]);
        } elseif ($notifiable->role === 'doctor') {
            $url = route('doctor.courses.discussions', ['course' => $this->reply->discussion->course_id]);
        }

        return [
            'reply_id' => $this->reply->id,
            'discussion_id' => $this->reply->discussion->id,
            'replier_name' => $replierName,
            'message' => "قام '{$replierName}' بالرد على سؤالك: '{$discussionTitle}'.",
            'url' => $url, // 💡 2. استخدام الرابط الديناميكي الذي تم إنشاؤه
            'icon' => 'bi-chat-left-text-fill'
        ];
    }

}
