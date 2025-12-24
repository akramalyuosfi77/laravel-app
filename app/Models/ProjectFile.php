<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// لا نحتاج لاستيراد Storage هنا بعد الآن، ولكن من الجيد إبقاؤه لو احتجناه مستقبلًا
use Illuminate\Support\Facades\Storage;

class ProjectFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'description',
        'type',
    ];

    /**
     * علاقة الملف مع المشروع الذي ينتمي إليه
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * ✅✅✅ [الحل النهائي والمضمون لمشكلة الرابط] ✅✅✅
     * دالة Accessor لبناء الرابط الكامل للملف باستخدام دالة asset().
     * هذه هي الطريقة الأكثر أمانًا وموثوقية.
     */
    public function getFileUrlAttribute(): string
    {
        // التأكد من أن المسار ليس فارغًا
        if ($this->file_path) {
            // دالة asset() ستقوم ببناء الرابط الكامل والصحيح للملف
            // الموجود داخل مجلد public.
            // مثال: 'storage/submissions/1/file.pdf' -> 'http://your-app.com/storage/submissions/1/file.pdf'
            return asset('storage/' . $this->file_path );
        }

        // إرجاع سلسلة فارغة إذا لم يكن هناك مسار للملف
        return '';
    }
}
