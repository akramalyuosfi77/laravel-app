<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Project;
use App\Notifications\Channels\FcmChannel;
use Kreait\Firebase\Messaging\CloudMessage;
// use Kreait\Laravel\Firebase\Facades\Firebase;

class SupervisionRequestReceived extends Notification
{
    use Queueable;

    public $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'message' => "لديك طلب إشراف جديد على مشروع '{$this->project->title}' من الطالب '{$this->project->creatorStudent->name}'.",
            'url' => route('doctor.projects'),
            'icon' => 'bi-person-check-fill'
        ];
    }

    public function toFcm(object $notifiable): CloudMessage
    {
        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'طلب إشراف جديد!',
                'body' => "لديك طلب إشراف على مشروع '{$this->project->title}' من الطالب '{$this->project->creatorStudent->name}'.",
            ])
            ->withData([
                'type' => 'supervision_request',
                'project_id' => (string) $this->project->id,
            ]);
    }
}
