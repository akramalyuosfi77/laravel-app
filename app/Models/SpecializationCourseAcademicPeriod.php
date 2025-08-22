<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SpecializationCourseAcademicPeriod extends Pivot
{
    protected $table = 'specialization_course_academic_period'; // اسم الجدول الوسيط
    public $incrementing = true; // إذا كان لديك primary key auto-incrementing
    protected $fillable = [
        'specialization_id',
        'course_id',
        'academic_year',
        'semester',
        'doctor_id', // أضفنا هذا الحقل
    ];

    // تعريف العلاقات العكسية إذا احتجت إليها
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
