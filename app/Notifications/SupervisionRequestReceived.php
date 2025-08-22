<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Project;

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
        return ['database']; // سنرسله لقاعدة البيانات فقط
    }

    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'message' => "لديك طلب إشراف جديد على مشروع '{$this->project->title}' من الطالب '{$this->project->creatorStudent->name}'.",
            'url' => route('doctor.projects'), // يوجه الدكتور لصفحة المشاريع الخاصة به
            'icon' => 'bi-person-check-fill' // أيقونة مناسبة
        ];
    }
}
