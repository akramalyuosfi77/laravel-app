<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Models\Discussion;
use App\Notifications\Channels\FcmChannel;

class NewDiscussionStarted extends Notification
{
    use Queueable;

    public $discussion;

    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

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
            'url' => route('doctor.courses.discussions', ['course' => $this->discussion->course_id]),
            'icon' => 'bi-patch-question-fill',
        ];
    }

    public function toFcm(object $notifiable): CloudMessage
    {
        $studentName = $this->discussion->student->name ?? 'طالب';
        $courseName = $this->discussion->course->name ?? 'مادة';
        $discussionTitle = $this->discussion->title;

        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'سؤال جديد في النقاش!',
                'body' => "سؤال جديد من '{$studentName}' في مادة '{$courseName}': '{$discussionTitle}'.",
            ])
            ->withData([
                'discussion_id' => (string) $this->discussion->id,
                'course_id' => (string) $this->discussion->course_id,
                'type' => 'new_discussion',
                'url' => route('doctor.courses.discussions', ['course' => $this->discussion->course_id]),
            ]);
    }
}
