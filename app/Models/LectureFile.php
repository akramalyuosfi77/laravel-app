<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectureFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'lecture_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'type',
        'description',
    ];

    /**
     * Get the lecture that owns the file.
     */
    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
