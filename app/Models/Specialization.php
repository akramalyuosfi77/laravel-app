<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'department_id',
        'duration',
    ];

    /**
     * Mutator for description: Encrypts the description before saving.
     * @param string $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Accessor for description: Decrypts the description after retrieving.
     * @param string $value
     * @return string|null
     */
    public function getDescriptionAttribute($value)
    {
        if ($value) {
            try {
                return Crypt::decryptString($value);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return $value;
            }
        }
        return null;
    }

    public function specializationCourseAcademicPeriods()
    {
        return $this->hasMany(SpecializationCourseAcademicPeriod::class);
    }

    /**
     * Get the department that owns the specialization.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    /**
     * Accessor to get the numeric duration from the 'duration' string.
     * Example: "6 سنوات" -> 6
     * @return int|null
     */
    public function getNumericDurationAttribute(): ?int
    {
        if (preg_match('/\d+/', $this->duration, $matches)) {
            return (int) $matches[0];
        }
        return null;
    }

    /**
     * Get the courses for the specialization, including academic period details.
     * هذا يمثل الخطة الدراسية للتخصص.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'specialization_course_academic_period', 'specialization_id', 'course_id')
                    ->withPivot('academic_year', 'semester')
                    ->withTimestamps(); //  timestamps في الجدول الوسيط
    }
}
