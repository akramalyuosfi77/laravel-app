<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'file_path',
        'file_name',
        'file_type',
        'description',
    ];

    /**
     * Get the submission that owns the file.
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
