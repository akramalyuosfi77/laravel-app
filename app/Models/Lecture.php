<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'doctor_id',
        'title',
        'description',
        'lecture_date',
        'qr_token',
        'qr_expires_at',
        'attendance_enabled',
    ];

    protected $casts = [
        'qr_expires_at' => 'datetime',
        'attendance_enabled' => 'boolean',
        'lecture_date' => 'date',
    ];

    /**
     * Get the course that owns the lecture.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the doctor that owns the lecture.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the files for the lecture.
     */
    public function files()
    {
        return $this->hasMany(LectureFile::class);
    }

    /**
     * Get the attendance records for the lecture.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * ✅ توليد QR token فريد للمحاضرة
     */
    public function generateQrToken()
    {
        $this->qr_token = \Str::random(32);
        $this->save();
        return $this->qr_token;
    }

    /**
     * ✅ تفعيل تسجيل الحضور لمدة معينة (بالدقائق)
     */
    public function enableAttendance($durationMinutes = 15)
    {
        if (!$this->qr_token) {
            $this->generateQrToken();
        }
        
        $this->qr_expires_at = now()->addMinutes($durationMinutes);
        $this->attendance_enabled = true;
        $this->save();
        
        return $this;
    }

    /**
     * ✅ تعطيل تسجيل الحضور
     */
    public function disableAttendance()
    {
        $this->attendance_enabled = false;
        $this->save();
        return $this;
    }

    /**
     * ✅ التحقق من صلاحية QR code
     */
    public function isQrValid()
    {
        if (!$this->attendance_enabled) {
            return false;
        }

        if (!$this->qr_token) {
            return false;
        }

        if ($this->qr_expires_at && now()->isAfter($this->qr_expires_at)) {
            return false;
        }

        return true;
    }

    /**
     * ✅ الحصول على الوقت المتبقي لانتهاء QR (بالدقائق)
     */
    public function getRemainingMinutes()
    {
        if (!$this->qr_expires_at) {
            return null;
        }

        return now()->diffInMinutes($this->qr_expires_at, false);
    }
}

