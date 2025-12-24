<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Submission; // استيراد موديل التسليم

class SubmissionGraded extends Notification
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
        return ['database', 'fcm']; // ✅✅✅ التعديل هنا
    }

    public function toFcm(object $notifiable): \Kreait\Firebase\Messaging\CloudMessage
{
    $assignmentTitle = $this->submission->assignment->title ?? 'تكليف';

    return \Kreait\Firebase\Messaging\CloudMessage::withTarget('token', $notifiable->fcm_token)
        ->withNotification([
            'title' => 'تم تقييم واجبك!',
            'body' => "لقد حصلت على درجة في التكليف: '{$assignmentTitle}'.",
        ])
        ->withData([
            'type' => 'grading',
            'assignment_id' => (string) $this->submission->assignment_id,
        ]);
}

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $assignmentTitle = $this->submission->assignment->title ?? 'تكليف';
        $grade = $this->submission->grade;

        return [
            'submission_id' => $this->submission->id,
            'assignment_title' => $assignmentTitle,
            'grade' => $grade,
            'message' => "تم تقييم تسليمك في '{$assignmentTitle}'. لقد حصلت على درجة {$grade}%.",
            // 💡 هذا الرابط سيوجه الطالب مباشرة لصفحة التكليفات الخاصة به
            'url' => route('student.assignments'),
            'icon' => 'bi-patch-check-fill' // أيقونة مناسبة للنجاح
        ];
    }
}
