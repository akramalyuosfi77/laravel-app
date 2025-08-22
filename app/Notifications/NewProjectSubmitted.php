<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Project; // 💡 استيراد موديل المشروع

class NewProjectSubmitted extends Notification
{
    use Queueable;

    public $project;

    /**
     * Create a new notification instance.
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $studentName = $this->project->creatorStudent->name ?? 'طالب';
        $projectTitle = $this->project->title;

        return [
            'project_id' => $this->project->id,
            'student_name' => $studentName,
            'project_title' => $projectTitle,
            'message' => "قام الطالب '{$studentName}' بتقديم مشروع جديد بعنوان '{$projectTitle}' لإشرافك.",
            // 💡 هذا الرابط سيوجه الدكتور مباشرة لصفحة المشاريع الخاصة به
            'url' => route('doctor.projects'),
            'icon' => 'bi-folder-plus' // أيقونة مناسبة للمشاريع الجديدة
        ];
    }
}
