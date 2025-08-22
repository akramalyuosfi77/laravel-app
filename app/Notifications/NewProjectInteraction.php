<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Project;
use App\Models\User;

class NewProjectInteraction extends Notification
{
    use Queueable;

    public $project;
    public $message;
    public $icon;

    /**
     * Create a new notification instance.
     */
    public function __construct(Project $project, string $message, string $icon)
    {
        $this->project = $project;
        $this->message = $message;
        $this->icon = $icon;
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
    // في app/Notifications/NewProjectInteraction.php

public function toArray(object $notifiable): array
{
    // --- 💡 المنطق الجديد لتحديد الرابط الصحيح ---
    $url = '';
    // $notifiable هو المستخدم الذي سيستقبل الإشعار
    if ($notifiable->role === 'doctor') {
        $url = route('doctor.projects');
    } elseif ($notifiable->role === 'student') {
        $url = route('student.projects');
    }
    // --- نهاية المنطق الجديد ---

    return [
        'project_id' => $this->project->id,
        'message' => $this->message,
        'url' => $url, // 💡 استخدام المتغير الديناميكي $url
        'icon' => $this->icon,
    ];
}

}
