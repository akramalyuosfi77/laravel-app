<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Student;
use App\Notifications\Channels\FcmChannel;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class NewStudentRegistered extends Notification
{
    use Queueable;

    public $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'student_id' => $this->student->id,
            'student_name' => $this->student->name,
            'message' => "طالب جديد ({$this->student->name}) قام بالتسجيل وينتظر الموافقة.",
            'url' => route('admin.users'),
            'icon' => 'bi-person-plus-fill'
        ];
    }

    public function toFcm(object $notifiable): CloudMessage
    {
        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'طالب جديد مسجّل!',
                'body' => "طالب جديد ({$this->student->name}) قام بالتسجيل وينتظر الموافقة.",
            ])
            ->withData([
                'type' => 'new_student_registered',
                'student_id' => (string) $this->student->id,
            ]);
    }
}
