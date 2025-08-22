<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'title',
        'description',
        'status',
        'grade',
        'feedback',
    ];

    /**
     * Get the assignment that this submission belongs to.
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Get the student who made this submission.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the files for the submission.
     */
    public function files()
    {
        return $this->hasMany(SubmissionFile::class);
    }
}
