<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Models\Assignment;
use App\Notifications\Channels\FcmChannel;

class NewAssignmentCreated extends Notification
{
    use Queueable;

    protected $assignment;

    public function __construct(Assignment $assignment)
    {
        $this->assignment = $assignment;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'assignment_id' => $this->assignment->id,
            'message' => "تكليف جديد بعنوان '{$this->assignment->title}' في مادة '{$this->assignment->course->name}'.",
            'url' => route('student.assignments'),
            'icon' => 'bi-file-earmark-plus-fill',
        ];
    }

    public function toFcm(object $notifiable): CloudMessage
    {
        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'تكليف جديد!',
                'body' => "تم إضافة تكليف جديد بعنوان '{$this->assignment->title}' في مادة '{$this->assignment->course->name}'.",
            ])
            ->withData([
                'assignment_id' => (string) $this->assignment->id,
                'type' => 'new_assignment',
                'url' => route('student.assignments'),
            ]);
    }
}
