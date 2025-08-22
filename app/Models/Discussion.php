<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'student_id',
        'title',
        'content',
        'status',
        'best_reply_id',
    ];

    /**
     * علاقة لجلب المادة التي ينتمي إليها النقاش.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * علاقة لجلب الطالب الذي بدأ النقاش.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * علاقة لجلب جميع الردود على هذا النقاش.
     */
    public function replies()
    {
        return $this->hasMany(DiscussionReply::class)->orderBy('created_at', 'asc');
    }

    /**
     * علاقة لجلب الرد الذي تم تمييزه كأفضل إجابة.
     */
    public function bestReply()
    {
        // هذه العلاقة تستخدم hasOne لأن كل نقاش له أفضل إجابة واحدة فقط
        return $this->hasOne(DiscussionReply::class, 'id', 'best_reply_id');
    }
}
