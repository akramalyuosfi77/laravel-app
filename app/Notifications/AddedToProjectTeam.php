<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Project;
use App\Models\Student;

class AddedToProjectTeam extends Notification
{
    use Queueable;

    public $project;
    public $inviter; // الطالب الذي أرسل الدعوة

    public function __construct(Project $project, Student $inviter)
    {
        $this->project = $project;
        $this->inviter = $inviter;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'message' => "قام الطالب '{$this->inviter->name}' بدعوتك للانضمام إلى فريق مشروع '{$this->project->title}'.",
            'url' => route('student.projects'), // يوجه الطالب لصفحة المشاريع الخاصة به ليرى الدعوة
            'icon' => 'bi-people-fill' // أيقونة مناسبة للفريق
        ];
    }
}
