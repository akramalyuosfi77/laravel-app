<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\Submission;
use App\Notifications\Channels\FcmChannel;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class NewSubmissionReceived extends Notification
{
    use Queueable;

    public $submission;

    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        $studentName = $this->submission->student->name ?? 'طالب';
        $assignmentTitle = $this->submission->assignment->title ?? 'تكليف';

        return [
            'submission_id' => $this->submission->id,
            'student_name' => $studentName,
            'assignment_title' => $assignmentTitle,
            'message' => "قام الطالب '{$studentName}' بتسليم التكليف '{$assignmentTitle}'.",
            'url' => route('doctor.assignments'),
            'icon' => 'bi-file-earmark-check-fill'
        ];
    }

    public function toFcm(object $notifiable): CloudMessage
    {
        $studentName = $this->submission->student->name ?? 'طالب';
        $assignmentTitle = $this->submission->assignment->title ?? 'تكليف';

        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification([
                'title' => 'تم تسليم تكليف جديد!',
                'body' => "قام الطالب '{$studentName}' بتسليم التكليف '{$assignmentTitle}'.",
            ])
            ->withData([
                'type' => 'new_submission_received',
                'submission_id' => (string) $this->submission->id,
            ]);
    }
}
