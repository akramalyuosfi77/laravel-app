<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Models\Project;
use App\Notifications\Channels\FcmChannel;

class NewProjectInteraction extends Notification
{
    use Queueable;

    public $project;
    public $message;
    public $icon;

    public function __construct(Project $project, string $message, string $icon)
    {
        $this->project = $project;
        $this->message = $message;
        $this->icon = $icon;
    }

    public function via(object $notifiable): array
    {
        // القنوات: قاعدة البيانات + FCM
        return ['database', FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        $url = ($notifiable->role === 'doctor') ? route('doctor.projects') : route('student.projects');

        return [
            'project_id' => $this->project->id,
            'message' => $this->message,
            'url' => $url,
            'icon' => $this->icon,
        ];
    }

    // دالة FCM
    public function toFcm(object $notifiable): CloudMessage
    {
        $url = ($notifiable->role === 'doctor') ? route('doctor.projects') : route('student.projects');

        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'تفاعل جديد على المشروع!',
                'body' => $this->message,
            ])
            ->withData([
                'project_id' => (string) $this->project->id,
                'url' => $url,
                'type' => 'project_interaction',
            ]);
    }
}
