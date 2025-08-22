<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\Announcement;

class NewAnnouncementPublished extends Notification
{
    use Queueable;

    protected $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        // الرابط سيكون دائماً لصفحة لوحة التحكم الخاصة بالمستخدم
        $url = route(strtolower($notifiable->role) . '.dashboard');

        return [
            'announcement_id' => $this->announcement->id,
            'message' => "إعلان جديد من '{$this->announcement->user->name}': {$this->announcement->title}",
            'url' => $url,
            'icon' => 'bi-megaphone-fill',
        ];
    }
}
