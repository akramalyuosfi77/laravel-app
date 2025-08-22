<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\Assignment; // استيراد موديل التكليف

class NewAssignmentCreated extends Notification
{
    use Queueable;

    protected $assignment;

    public function __construct(Assignment $assignment)
    {
        $this->assignment = $assignment;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'assignment_id' => $this->assignment->id,
            'message' => "تكليف جديد بعنوان '{$this->assignment->title}' في مادة '{$this->assignment->course->name}'.",
            'url' => route('student.assignments'),
            'icon' => 'bi-file-earmark-plus-fill',
        ];
    }
}
