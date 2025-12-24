<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // ✅ 1. تم استيراد العلاقة

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'student_id_number',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'address',
        'profile_image',
        'batch_id',
        'specialization_id', // ✅ 2. تمت إضافة مفتاح التخصص هنا
        'current_academic_year',
        'current_semester',
        'status',
        'user_id',
    ];

    /**
     * Get the user that owns the student.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the batch that owns the student.
     */
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * ✅✅✅ [الحل الأساسي هنا] ✅✅✅
     * Get the specialization that owns the student.
     * تعريف العلاقة المفقودة التي تسببت في الخطأ.
     */
    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    /**
     * The projects that the student participates in.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_student')
                    ->withPivot('is_main_creator')
                    ->withTimestamps();
    }

    /**
     * Get the submissions for the student.
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * [مُحسَّن ومُصحَّح]
     * دالة لجلب استعلام المواد الحالية التي يدرسها الطالب.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getCurrentCourses()
    {
        // إذا لم يكن للطالب دفعة أو تخصص، نرجع استعلاماً فارغاً لتجنب الأخطاء
        if (!$this->batch?->specialization_id) {
            return Course::query()->whereRaw('1 = 0'); // استعلام فارغ آمن
        }

        // بناء الاستعلام الصحيح الذي يمر عبر الدفعة والتخصص
        return Course::query()
            ->whereHas('specializations', function ($query) {
                $query->where('specializations.id', $this->batch->specialization_id)
                      ->where('specialization_course_academic_period.academic_year', $this->current_academic_year)
                      ->where('specialization_course_academic_period.semester', $this->current_semester);
            });
    }
}
