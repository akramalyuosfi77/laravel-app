<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
    ];

    // علاقة الإعجاب مع المشروع
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // علاقة الإعجاب مع المستخدم الذي قام بالإعجاب
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
