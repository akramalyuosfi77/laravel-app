<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'student_id', // المنشئ
        'batch_id',
        'academic_year',
        'semester', // <--- أضف هذا السطر
        'specialization_id',
        'course_id',
        'doctor_id',
         'grade',    // إضافة هذا
        'feedback',
        'supervision_status', // 💡 أضف هذا السطر المهم

    ];

    // العلاقة مع الطالب المنشئ للمشروع
    public function creatorStudent()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // العلاقة مع الدفعة
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    // العلاقة مع التخصص
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function students()
    {
    return $this->belongsToMany(Student::class, 'project_student')
                ->withPivot('is_main_creator', 'membership_status', 'created_at')
                ->withTimestamps();
    }


    // العلاقة مع المادة
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // العلاقة مع الدكتور المشرف <--- أضف هذه العلاقة
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }



    // العلاقة مع الملفات المرفقة
    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

    // العلاقة مع الإعجابات
    public function likes()
    {
        return $this->hasMany(ProjectLike::class);
    }

    // العلاقة مع التعليقات
    public function comments()
    {
        return $this->hasMany(ProjectComment::class);
    }

    // Accessor لحساب عدد الإعجابات
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    // Accessor لحساب عدد التعليقات
    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    // دالة للتحقق مما إذا كان المستخدم الحالي قد أعجب بالمشروع
    public function isLikedByUser($user)
    {
        if (!$user) {
            return false;
        }
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // دالة للتحقق مما إذا كان الطالب مشاركًا في المشروع
    public function isParticipant(Student $student)
    {
        // التحقق مما إذا كان الطالب هو المنشئ
        if ($this->student_id === $student->id) {
            return true;
        }
        // التحقق مما إذا كان الطالب مشاركًا عبر الجدول الوسيط
        return $this->students->contains($student->id);
    }
}
