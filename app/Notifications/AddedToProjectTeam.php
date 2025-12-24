<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Models\Project;
use App\Models\Student;
use App\Notifications\Channels\FcmChannel;

class AddedToProjectTeam extends Notification
{
    use Queueable;

    public $project;
    public $inviter;

    public function __construct(Project $project, Student $inviter)
    {
        $this->project = $project;
        $this->inviter = $inviter;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'message' => "قام الطالب '{$this->inviter->name}' بدعوتك للانضمام إلى فريق مشروع '{$this->project->title}'.",
            'url' => route('student.projects'),
            'icon' => 'bi-people-fill'
        ];
    }

    public function toFcm(object $notifiable): CloudMessage
    {
        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'تمت إضافتك لفريق مشروع!',
                'body' => "الطالب '{$this->inviter->name}' دعاك للانضمام إلى فريق مشروع '{$this->project->title}'.",
            ])
            ->withData([
                'project_id' => (string) $this->project->id,
                'type' => 'added_to_project_team',
                'url' => route('student.projects'),
            ]);
    }
}
