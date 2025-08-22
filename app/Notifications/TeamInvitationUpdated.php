<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Project;

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

    public function via(object $notifiable): array { return ['database']; }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'message' => $this->message,
            'url' => route('student.projects'),
            'icon' => $this->icon,
        ];
    }
}
