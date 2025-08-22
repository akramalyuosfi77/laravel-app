<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

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
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => null, // لا يوجد مشروع محدد ليرتبط به
            'message' => "تمت إزالتك من فريق مشروع '{$this->projectName}'.",
            'url' => route('student.projects'),
            'icon' => 'bi-person-x-fill text-red-500',
        ];
    }
}
