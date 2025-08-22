<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'comment',
    ];

    // علاقة التعليق مع المشروع
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // علاقة التعليق مع المستخدم الذي قام بالتعليق
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
