<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Student; // 💡 1. استيراد موديل الطالب

class NewStudentRegistered extends Notification
{
    use Queueable;

    // 💡 2. خاصية عامة لتخزين بيانات الطالب
    public $student;

    /**
     * Create a new notification instance.
     *
     * 💡 3. تعديل الدالة الإنشائية (constructor) لتستقبل الطالب
     * هذا يسمح لنا بتمرير معلومات الطالب من أي مكان في التطبيق إلى هذا الإشعار.
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Get the notification's delivery channels.
     *
     * 💡 4. تغيير قناة الإرسال إلى 'database'
     * هذا يخبر لارافيل أننا نريد حفظ هذا الإشعار في جدول 'notifications' فقط.
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     * (هذه الدالة لن نستخدمها الآن، ولكن يمكننا تركها للمستقبل)
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * 💡 5. هذه هي أهم دالة! هنا نحدد البيانات التي سيتم حفظها في قاعدة البيانات.
     * سنقوم بإنشاء مصفوفة تحتوي على كل ما نحتاجه لعرض الإشعار لاحقًا.
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'student_id' => $this->student->id,
            'student_name' => $this->student->name,
            'message' => "طالب جديد ({$this->student->name}) قام بالتسجيل وينتظر الموافقة.",
            'url' => route('admin.users'), // الرابط الذي سينتقل إليه المدير عند الضغط على الإشعار
            'icon' => 'bi-person-plus-fill' // أيقونة جميلة من Bootstrap Icons لتمييز نوع الإشعار
        ];
    }
}
