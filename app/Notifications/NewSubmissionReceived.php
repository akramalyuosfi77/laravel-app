<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Submission; // 💡 استيراد موديل التسليم

class NewSubmissionReceived extends Notification
{
    use Queueable;

    public $submission;

    /**
     * Create a new notification instance.
     */
    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database']; // سنحفظه في قاعدة البيانات
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        // جلب البيانات المهمة من العلاقات
        $studentName = $this->submission->student->name ?? 'طالب';
        $assignmentTitle = $this->submission->assignment->title ?? 'تكليف';

        return [
            'submission_id' => $this->submission->id,
            'student_name' => $studentName,
            'assignment_title' => $assignmentTitle,
            'message' => "قام الطالب '{$studentName}' بتسليم التكليف '{$assignmentTitle}'.",
            // 💡 هذا الرابط سيوجه الدكتور مباشرة لصفحة التكليفات الخاصة به
            'url' => route('doctor.assignments'),
            'icon' => 'bi-file-earmark-check-fill' // أيقونة مناسبة
        ];
    }
}
