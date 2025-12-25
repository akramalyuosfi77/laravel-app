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
        'academic_year',
        'current_semester',
        'semester',
    ];

    protected $dates = ['created_at', 'updated_at'];

    // --- العلاقات الأساسية (بدون تغيير) ---
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // ✅✅✅ --- [الحل السحري والنهائي هنا - نسخة أكثر مرونة] --- ✅✅✅
    /**
     * علاقة لجلب كل المواد المرتبطة بتخصص هذه الدفعة.
     * لقد قمنا بإزالة شروط السنة والترم لجعلها أكثر مرونة وتضمن جلب البيانات.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses()
    {
        // هذا يخبر Laravel: "اذهب إلى الجدول الوسيط، وابحث عن كل المواد
        // التي يتطابق specialization_id فيها مع التخصص الخاص بهذه الدفعة".
        return $this->belongsToMany(Course::class, 'specialization_course_academic_period', 'specialization_id', 'course_id', 'specialization_id');
    }
    // --- نهاية التعديل ---


    // --- باقي الدوال المساعدة (Accessors) تبقى كما هي بدون تغيير ---
    public function getStartDateAttribute(): Carbon
    {
        return Carbon::create($this->start_year, 9, 1, 0, 0, 0);
    }

    public function getEndDateAttribute(): ?Carbon
    {
        if ($this->specialization) {
            // استخدام try-catch للأمان في حال كان numeric_duration غير موجود
            try {
                $durationYears = $this->specialization->numeric_duration;
                if ($durationYears !== null) {
                    return $this->start_date->addYears($durationYears)->subDay();
                }
            } catch (\Exception $e) {
                // تجاهل الخطأ إذا لم يكن الحقل موجوداً
            }
        }
        return null;
    }

    public function getAcademicStatusAttribute(): string
    {
        try {
            $currentDate = Carbon::now();
            $startDate = $this->start_date;
            $endDate = $this->end_date;

            if (!$this->specialization || !$endDate || $currentDate->lessThan($startDate)) {
                return 'لم تبدأ بعد';
            }

            if ($currentDate->greaterThan($endDate)) {
                return 'تخرج';
            }

            $monthsPassed = $currentDate->diffInMonths($startDate);
            $currentAcademicYear = floor($monthsPassed / 12) + 1;
            $monthInAcademicYear = $monthsPassed % 12;

            $term = '';
            if ($monthInAcademicYear >= 0 && $monthInAcademicYear <= 4) { // تم تعديل النطاق ليكون أكثر مرونة
                $term = 'الترم الأول';
            } else {
                $term = 'الترم الثاني';
            }

            return "السنة {$currentAcademicYear} - {$term}";
        } catch (\Exception $e) {
            return 'حالة غير معروفة';
        }
    }

    /**
     * ✅✅✅ [أعلى معايير الجودة - تزامن الدفعة والطلاب] ✅✅✅
     * يتم استدعاء هذا الجزء عند تشغيل الموديل.
     */
    protected static function booted()
    {
        static::updated(function ($batch) {
            // التحقق مما إذا كانت السنة الدراسية أو الترم قد تغيرا في الدفعة
            // نتحقق من كلا الحقلين (academic_year و semester) لضمان العمل مع أي منهما
            if ($batch->wasChanged(['academic_year', 'semester', 'current_academic_year', 'current_semester'])) {
                
                // جلب القيم الجديدة (دعم الحقول المتعددة)
                $newYear = $batch->academic_year ?? $batch->current_academic_year;
                $newSemester = $batch->semester ?? $batch->current_semester;

                if ($newYear && $newSemester) {
                    // تحديث جميع الطلاب السجلين في هذه الدفعة دفعة واحدة (Mass Update) لضمان الأداء العالي
                    $batch->students()->update([
                        'current_academic_year' => $newYear,
                        'current_semester' => $newSemester,
                    ]);

                    // تسجيل العملية في السجلات للتأكد من المتابعة
                    \Illuminate\Support\Facades\Log::info("Auto-Sync: Students in batch '{$batch->name}' promoted to Year {$newYear} Sem {$newSemester}");
                }
            }
        });
    }
}