<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lecture_id',
        'student_id',
        'status',
        'notes',
    ];

    /**
     * Get the lecture that this attendance record belongs to.
     * علاقة "ينتمي إلى" لجلب بيانات المحاضرة المرتبطة.
     */
    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    /**
     * Get the student that this attendance record belongs to.
     * علاقة "ينتمي إلى" لجلب بيانات الطالب المرتبط.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
