<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Project;
use App\Notifications\Channels\FcmChannel;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class TeamInvitationUpdated extends Notification
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
        return ['database', FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'message' => $this->message,
            'url' => route('student.projects'),
            'icon' => $this->icon,
        ];
    }

    public function toFcm(object $notifiable): CloudMessage
    {
        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'تحديث دعوة الفريق!',
                'body' => $this->message,
            ])
            ->withData([
                'type' => 'team_invitation_updated',
                'project_id' => (string) $this->project->id,
            ]);
    }
}
