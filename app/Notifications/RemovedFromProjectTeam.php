<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\FcmChannel;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class RemovedFromProjectTeam extends Notification
{
    use Queueable;

    protected $projectName;

    public function __construct(string $projectName)
    {
        $this->projectName = $projectName;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => null,
            'message' => "تمت إزالتك من فريق مشروع '{$this->projectName}'.",
            'url' => route('student.projects'),
            'icon' => 'bi-person-x-fill text-red-500',
        ];
    }

    public function toFcm(object $notifiable): CloudMessage
    {
        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'تمت إزالتك من الفريق!',
                'body' => "تمت إزالتك من فريق مشروع '{$this->projectName}'.",
            ])
            ->withData([
                'type' => 'removed_from_project_team',
                'project_name' => $this->projectName,
            ]);
    }
}
