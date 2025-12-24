<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Models\Announcement;
use App\Notifications\Channels\FcmChannel;

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
        return ['database', FcmChannel::class];
    }

   public function toArray(object $notifiable): array
{
    $url = route(strtolower($notifiable->role) . '.dashboard');
    $userName = $this->announcement->user->name ?? 'المسؤول';

    return [
        'announcement_id' => $this->announcement->id,
        'message' => "إعلان جديد من '{$userName}': {$this->announcement->title}",
        'url' => $url,
        'icon' => 'bi-megaphone-fill',
    ];
}

public function toFcm(object $notifiable): CloudMessage
{
    $userName = $this->announcement->user->name ?? 'المسؤول';

    return CloudMessage::withTarget('token', $notifiable->fcm_token)
        ->withNotification([
            'title' => 'إعلان جديد!',
            'body' => "تم نشر إعلان بعنوان '{$this->announcement->title}' من '{$userName}'.",
        ])
        ->withData([
            'announcement_id' => (string) $this->announcement->id,
            'type' => 'new_announcement',
            'url' => route(strtolower($notifiable->role) . '.dashboard'),
        ]);
}

}
