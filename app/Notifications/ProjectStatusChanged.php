<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ProjectStatusChanged extends Notification
{
    use Queueable;

    protected $project;
    protected $message;
    protected $icon;

    public function __construct(Project $project, string $message, string $icon)
    {
        $this->project = $project;
        $this->message = $message;
        $this->icon = $icon;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'message' => $this->message,
            'url' => route('student.projects'), // دائماً يوجه الطالب لصفحة مشاريعه
            'icon' => $this->icon,
        ];
    }
}
