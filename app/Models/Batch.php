<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_year',
        'specialization_id',
        'academic_year', // تأكد من وجودها هنا
        'current_semester', // تأكد من وجودها هنا
        'semester',      // تأكد من وجودها هنا
    ];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * Get the specialization that owns the batch.
     */
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    /**
     * Accessor to get the batch's exact start date (e.g., 2025-09-01).
     * @return Carbon
     */
    public function getStartDateAttribute(): Carbon
    {
        // نفترض أن السنة الأكاديمية تبدأ في سبتمبر (الشهر 9)
        return Carbon::create($this->start_year, 9, 1, 0, 0, 0);
    }

    /**
     * Accessor to get the batch's estimated end date.
     * @return Carbon|null
     */
    public function getEndDateAttribute(): ?Carbon
    {
        if ($this->specialization) {
            $durationYears = $this->specialization->numeric_duration;
            if ($durationYears !== null) {
                // تاريخ البداية + مدة التخصص بالسنوات - يوم واحد (لأن المدة تشمل سنة البداية)
                // مثال: 2025-09-01 + 4 سنوات = 2029-09-01. النهاية هي 2029-08-31
                return $this->start_date->addYears($durationYears)->subDay();
            }
        }
        return null;
    }

    /**
     * Accessor to get the current academic status (e.g., "السنة الأولى - الترم الأول").
     * @return string
     */
    public function getAcademicStatusAttribute(): string
    {
        $currentDate = Carbon::now();
        $startDate = $this->start_date;
        $endDate = $this->end_date;

        // إذا لم يتم تحديد تخصص أو مدة، أو لم تبدأ الدفعة بعد
        if (!$this->specialization || $this->specialization->numeric_duration === null || $currentDate->lessThan($startDate)) {
            return 'لم تبدأ بعد';
        }

        // إذا انتهت الدفعة
        if ($endDate && $currentDate->greaterThan($endDate)) {
            return 'تخرج';
        }

        // حساب عدد الأشهر المنقضية منذ بداية الدفعة
        $monthsPassed = $currentDate->diffInMonths($startDate);

        // حساب السنة الأكاديمية الحالية (كل 12 شهر هي سنة)
        $currentAcademicYear = floor($monthsPassed / 12) + 1;

        // حساب الشهر داخل السنة الأكاديمية الحالية (من 0 إلى 11)
        $monthInAcademicYear = $monthsPassed % 12;

        $term = '';
        if ($monthInAcademicYear >= 0 && $monthInAcademicYear <= 2) { // سبتمبر، أكتوبر، نوفمبر
            $term = 'الترم الأول';
        } elseif ($monthInAcademicYear >= 3 && $monthInAcademicYear <= 5) { // ديسمبر، يناير، فبراير
            $term = 'الترم الثاني';
        } else { // مارس - أغسطس (فترة الإجازة)
            $term = 'فترة إجازة';
        }

        return "السنة {$currentAcademicYear} - {$term}";
    }

        /**
     * Get the students for the batch.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

}
