<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'profile_image',
        'user_id', // ✅ ضروري جدًا


    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    // في App\Models\Doctor.php
        public function courses()
        {
            return $this->belongsToMany(Course::class, 'specialization_course_academic_period')
                        ->withPivot('specialization_id', 'academic_year', 'semester'); // تحديد الأعمدة الإضافية
        }

        // في App\Models\Doctor.php
// أضف هذه العلاقة
    public function specializationCourseAcademicPeriods()
    {
        return $this->hasMany(SpecializationCourseAcademicPeriod::class, 'doctor_id');
    }


}
