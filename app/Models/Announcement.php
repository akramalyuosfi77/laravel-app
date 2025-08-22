<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'level',
        'target_type',
        'target_id',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user who created the announcement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    // في app/Models/Announcement.php

// في app/Models/Announcement.php

public function sendNotificationToTargets()
{
    // --- 💡 كود التشخيص ---

    $recipients = collect();
    $targetType = $this->target_type;
    $targetId = $this->target_id;

    switch ($targetType) {
        case 'global_all':
            $recipients = \App\Models\User::where('is_active', true)->get();
            break;
        case 'global_students':
            $recipients = \App\Models\User::where('role', 'student')->where('is_active', true)->get();
            break;
        case 'global_doctors':
            $recipients = \App\Models\User::where('role', 'doctor')->where('is_active', true)->get();
            break;
        case 'department':
            $students = \App\Models\Student::whereHas('batch.specialization', function ($q) use ($targetId) {
                $q->where('department_id', $targetId);
            })->with('user')->get();
            $recipients = $students->pluck('user')->filter();
            break;
        case 'specialization':
            $students = \App\Models\Student::whereHas('batch', function ($q) use ($targetId) {
                $q->where('specialization_id', $targetId);
            })->with('user')->get();
            $recipients = $students->pluck('user')->filter();
            break;
        case 'course':
            $course = \App\Models\Course::find($targetId);
            if ($course) {
                $students = $course->students();
                $recipients = $students->pluck('user')->filter();
            }
            break;
    }


    // إزالة الشخص الذي قام بالنشر من قائمة المستلمين
    $recipientsToSend = $recipients->reject(fn($user) => $user->id === $this->user_id);


    if ($recipientsToSend->isNotEmpty()) {
        \Illuminate\Support\Facades\Notification::send($recipientsToSend, new \App\Notifications\NewAnnouncementPublished($this));
    }
    else {

    }
}


}
