<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'doctor_id',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'datetime', // لتحويل حقل deadline تلقائياً إلى كائن Carbon
    ];

    /**
     * Get the course that owns the assignment.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the doctor who assigned the assignment.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the submissions for the assignment.
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
