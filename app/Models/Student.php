<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'profile_image', // تم إضافة هذا السطر
        'batch_id',
        'current_academic_year',
        'current_semester',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the batch that owns the student.
     */
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
     // علاقة الطالب مع المشاريع التي يشارك فيها
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_student')
                    ->withPivot('is_main_creator')
                    ->withTimestamps();
    }

    public function submissions()
{
    return $this->hasMany(Submission::class);
}

   /**
     * دالة مخصصة لجلب المواد التي يدرسها الطالب في الفصل الدراسي الحالي.
     * هذه الدالة لا تعرف علاقة Eloquent قياسية، بل تنفذ استعلامًا مباشرًا ودقيقًا.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
  // ... داخل موديل Student ...

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
        return Course::query()->whereRaw('1 = 0');
    }

    // [تصحيح] بناء الاستعلام الصحيح الذي يمر عبر الدفعة والتخصص
    return Course::query()
        ->whereHas('specializations', function ($query) {
            $query->where('specializations.id', $this->batch->specialization_id)
                  ->where('specialization_course_academic_period.academic_year', $this->current_academic_year)
                  ->where('specialization_course_academic_period.semester', $this->current_semester);
        });
}



}
