<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\DiscussionReply;
use App\Notifications\Channels\FcmChannel;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class NewReplyToDiscussion extends Notification
{
    use Queueable;

    public $reply;

    public function __construct(DiscussionReply $reply)
    {
        $this->reply = $reply;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        $replierName = $this->reply->user->name ?? 'أحدهم';
        $discussionTitle = $this->reply->discussion->title ?? 'سؤالك';

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
            'url' => $url,
            'icon' => 'bi-chat-left-text-fill'
        ];
    }

    public function toFcm(object $notifiable): CloudMessage
    {
        $replierName = $this->reply->user->name ?? 'أحدهم';
        $discussionTitle = $this->reply->discussion->title ?? 'سؤالك';

        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'تم الرد على سؤالك!',
                'body' => "قام '{$replierName}' بالرد على سؤالك: '{$discussionTitle}'.",
            ])
            ->withData([
                'type' => 'new_reply_to_discussion',
                'reply_id' => (string) $this->reply->id,
                'discussion_id' => (string) $this->reply->discussion->id,
            ]);
    }
}
