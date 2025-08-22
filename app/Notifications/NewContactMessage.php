<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\ContactMessage; // استيراد موديل الرسالة

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
        return ['database']; // حفظ في قاعدة البيانات
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message_id' => $this->contactMessage->id,
            'sender_name' => $this->contactMessage->name,
            'message' => "رسالة تواصل جديدة من '{$this->contactMessage->name}' بعنوان '{$this->contactMessage->subject}'.",
            // لا يوجد رابط محدد لهذه الصفحة حالياً، يمكننا إضافته لاحقاً
             'url' => route('admin.contact-messages'), // 💡 استخدام الرابط الصحيح الذي أنشأناه
            'icon' => 'bi-envelope-fill' // أيقونة مناسبة
        ];
    }
}
