<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Models\Project;
use App\Notifications\Channels\FcmChannel; // 📌 قناة FCM مخصصة

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
        return ['database', FcmChannel::class]; // قاعدة البيانات + FCM
    }

    /**
     * Get the array representation of the notification for DB.
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
            'url' => route('doctor.projects'),
            'icon' => 'bi-folder-plus'
        ];
    }

    /**
     * Prepare the FCM notification.
     */
    public function toFcm(object $notifiable): CloudMessage
    {
        $studentName = $this->project->creatorStudent->name ?? 'طالب';
        $projectTitle = $this->project->title;

        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'تم تقديم مشروع جديد',
                'body' => "قام الطالب '{$studentName}' بتقديم مشروع '{$projectTitle}' لإشرافك.",
            ])
            ->withData([
                'type' => 'new_project_submitted',
                'project_id' => (string) $this->project->id,
            ]);
    }
}
