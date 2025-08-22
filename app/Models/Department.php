<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * الحقول التي يمكن تعبئتها بشكل جماعي (Mass Assignment)
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * الحقول التي يجب إخفاؤها عند التحويل إلى JSON
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * العلاقات مع النماذج الأخرى
     */

    // مثال: إذا كان القسم له العديد من الطلاب
    // public function students()
    // {
    //     return $this->hasMany(Student::class);
    // }

    // مثال: إذا كان القسم له العديد من المواد
    // public function courses()
    // {
    //     return $this->hasMany(Course::class);
    // }

    /**
     * نطاقات البحث (Scopes) لاستخدامها في الاستعلامات
     */

    /**
     * البحث بالأسماء
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    /**
     * الحصول على أحدث الأقسام
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */




    public function scopeLatestDepartments($query, $limit = 5)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }



        /**
     * Get the specializations for the department.
     */
    public function specializations()
    {
        return $this->hasMany(Specialization::class);
    }

}
