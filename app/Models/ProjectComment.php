<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;    // استيراد موديل المستخدم
use App\Models\Student;  // استيراد موديل الطالب

class ProjectComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'comment',
    ];

    /**
     * علاقة التعليق مع المشروع الذي ينتمي إليه.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * ✅ [القديمة] علاقة التعليق مع المستخدم (User).
     * هذه العلاقة ستبقى كما هي لضمان عدم تعطل أي أجزاء أخرى من النظام.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ✅✅✅ [الجديدة] علاقة التعليق مع الطالب (Student).
     * هذه هي العلاقة الجديدة التي سيستخدمها الـ API الخاص بتطبيق فلاتر.
     * هي تعمل كـ "اسم مستعار" أو "طريق مختصر" للوصول إلى بيانات الطالب
     * مباشرة من خلال عمود 'user_id'.
     */
    public function student()
    {
        // نخبر لارافل أن هذه العلاقة ترتبط بموديل Student،
        // وأن المفتاح الأجنبي في جدول التعليقات (project_comments) هو 'user_id'،
        // وأن هذا المفتاح يرتبط بعمود 'user_id' في جدول الطلاب (students).
        return $this->belongsTo(Student::class, 'user_id', 'user_id');
    }
}
