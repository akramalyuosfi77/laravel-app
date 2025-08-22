<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // علاقة الملف مع المشروع الذي ينتمي إليه
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
