<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * الحقول التي يمكن تعبئتها بشكل جماعي.
     */
    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'student_replies_enabled', // للتأكد من وجوده
        // لا حاجة لـ specialization_id, academic_year, semester هنا
        // لأنها موجودة في الجدول الوسيط
    ];

    /**
     * التحويلات التلقائية للأنواع.
     */
    protected $casts = [
        'student_replies_enabled' => 'boolean',
    ];

    // =================================================================
    // العلاقات الأساسية (Relationships)
    // =================================================================

    /**
     * علاقة لجلب التخصصات التي تُدرّس فيها هذه المادة.
     * علاقة متعدد إلى متعدد (Many-to-Many).
     */
    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'specialization_course_academic_period')
                    ->withPivot('academic_year', 'semester', 'doctor_id')
                    ->withTimestamps();
    }

    /**
     * علاقة لجلب الدكاترة الذين يدرسون هذه المادة.
     * علاقة متعدد إلى متعدد (Many-to-Many).
     */
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'specialization_course_academic_period')
                    ->withPivot('academic_year', 'semester', 'specialization_id')
                    ->withTimestamps();
    }

    /**
     * علاقة لجلب جميع التكليفات المرتبطة بهذه المادة.
     * علاقة واحد إلى متعدد (One-to-Many).
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * علاقة لجلب جميع المحاضرات المرتبطة بهذه المادة.
     */
    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    /**
     * علاقة لجلب جميع المناقشات المرتبطة بهذه المادة.
     */
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    /**
     * علاقة لجلب جميع المشاريع المرتبطة بهذه المادة.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * علاقة لجلب سجلات الجدول الوسيط (الخطة الدراسية) لهذه المادة.
     */
    public function specializationCourseAcademicPeriods()
    {
        return $this->hasMany(SpecializationCourseAcademicPeriod::class);
    }

    // =================================================================
    // [العلاقة الأهم] لجلب الطلاب
    // =================================================================

    /**
     * 💡 [العلاقة الصحيحة والنهائية]
     * علاقة لجلب "باني الاستعلام" للطلاب الذين يدرسون هذه المادة.
     * هذا هو الحل الصحيح للتعامل مع العلاقات المعقدة عبر الجداول الوسيطة.
     */
    public function students()
    {
        // هذا الاستعلام يبحث عن الطلاب الذين ينتمون إلى دفعات
        // وهذه الدفعات تنتمي إلى تخصصات
        // وهذه التخصصات مرتبطة بهذه المادة في الجدول الوسيط
        return Student::whereIn('batch_id', function ($query) {
            $query->select('id')->from('batches')
                ->whereIn('specialization_id', function ($subQuery) {
                    $subQuery->select('specialization_id')->from('specialization_course_academic_period')
                        ->where('course_id', $this->id);
                });
        });
    }
}
