<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

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
        return ['database'];
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
}
