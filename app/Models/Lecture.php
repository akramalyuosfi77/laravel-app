<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'doctor_id',
        'title',
        'description',
        'lecture_date',
    ];

    /**
     * Get the course that owns the lecture.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the doctor that owns the lecture.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the files for the lecture.
     */
    public function files()
    {
        return $this->hasMany(LectureFile::class);
    }
}
