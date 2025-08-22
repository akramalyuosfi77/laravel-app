<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'specialization_course_academic_period_id',
        'location_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    /**
     * علاقة لجلب تفاصيل الخطة الدراسية (المادة، التخصص، الدكتور).
     */
    public function coursePlan()
    {
        return $this->belongsTo(SpecializationCourseAcademicPeriod::class, 'specialization_course_academic_period_id');
    }

    /**
     * علاقة لجلب تفاصيل القاعة.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
