<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Models\ContactMessage;
use App\Notifications\Channels\FcmChannel;

class NewContactMessage extends Notification
{
    use Queueable;

    public $contactMessage;

    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message_id' => $this->contactMessage->id,
            'sender_name' => $this->contactMessage->name,
            'message' => "رسالة تواصل جديدة من '{$this->contactMessage->name}' بعنوان '{$this->contactMessage->subject}'.",
            'url' => route('admin.contact-messages'),
            'icon' => 'bi-envelope-fill',
        ];
    }

    public function toFcm(object $notifiable): CloudMessage
    {
        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'رسالة تواصل جديدة!',
                'body' => "من '{$this->contactMessage->name}' بعنوان '{$this->contactMessage->subject}'.",
            ])
            ->withData([
                'message_id' => (string) $this->contactMessage->id,
                'type' => 'new_contact_message',
                'url' => route('admin.contact-messages'),
            ]);
    }
}
