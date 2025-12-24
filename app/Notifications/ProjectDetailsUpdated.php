<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Channels\FcmChannel;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class ProjectDetailsUpdated extends Notification
{
    use Queueable;

    protected $project;
    protected $updaterName;

    public function __construct(Project $project, string $updaterName)
    {
        $this->project = $project;
        $this->updaterName = $updaterName;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        $url = ($notifiable->role === 'doctor') ? route('doctor.projects') : route('student.projects');

        return [
            'project_id' => $this->project->id,
            'message' => "قام '{$this->updaterName}' بتحديث تفاصيل مشروع '{$this->project->title}'.",
            'url' => $url,
            'icon' => 'bi-pencil-square',
        ];
    }

    public function toFcm(object $notifiable): CloudMessage
    {
        $url = ($notifiable->role === 'doctor') ? route('doctor.projects') : route('student.projects');

        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'تحديث تفاصيل المشروع!',
                'body' => "قام '{$this->updaterName}' بتحديث تفاصيل مشروع '{$this->project->title}'.",
            ])
            ->withData([
                'type' => 'project_details_updated',
                'project_id' => (string) $this->project->id,
            ]);
    }
}
