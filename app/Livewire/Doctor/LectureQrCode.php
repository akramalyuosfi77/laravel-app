<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Lecture;
use Illuminate\Support\Facades\Auth;

class LectureQrCode extends Component
{
    public $lecture;
    public $qrCodeUrl;
    public $remainingMinutes = 0;
    public $isActive = false;

    public function mount($lectureId)
    {
        $this->lecture = Lecture::with('course', 'doctor')->findOrFail($lectureId);
        
        // التحقق من أن المحاضرة تخص الدكتور الحالي
        // بما أن doctor_id في المحاضرة يشير لجدول doctors، يجب أن نتحقق من علاقة الدكتور بالمستخدم الحالي
        if ($this->lecture->doctor->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بالوصول لهذه المحاضرة');
        }

        $this->updateQrStatus();
    }

    public function enableAttendance($durationMinutes = 15)
    {
        // جلب المحاضرة من قاعدة البيانات لضمان التحديث
        $lecture = Lecture::find($this->lecture->id);
        
        if (!$lecture) {
            session()->flash('error', 'المحاضرة غير موجودة');
            return;
        }

        // توليد توكن جديد إذا لم يوجد
        $token = $lecture->qr_token ?? \Str::random(32);
        
        // تحديث مباشر لقاعدة البيانات
        $lecture->update([
            'qr_token' => $token,
            'qr_expires_at' => now()->addMinutes($durationMinutes),
            'attendance_enabled' => true
        ]);

        // تحديث المتغير المحلي
        $this->lecture = $lecture;
        $this->updateQrStatus();
        
        session()->flash('success', 'تم تفعيل الحضور بنجاح! الرمز صالح لمدة ' . $durationMinutes . ' دقيقة.');
    }

    public function disableAttendance()
    {
        $lecture = Lecture::find($this->lecture->id);
        
        if ($lecture) {
            $lecture->update(['attendance_enabled' => false]);
            $this->lecture = $lecture;
        }

        $this->updateQrStatus();
        
        session()->flash('success', 'تم تعطيل الحضور بنجاح!');
    }

    public function refreshStatus()
    {
        // إعادة جلب البيانات من القاعدة للتأكد
        $this->lecture = Lecture::find($this->lecture->id);
        $this->updateQrStatus();
    }

    public $attendances = [];

    // ...

    private function updateQrStatus()
    {
        $this->lecture->refresh();
        $this->isActive = $this->lecture->isQrValid();
        $this->remainingMinutes = round($this->lecture->getRemainingMinutes());
        
        // جلب قائمة الحضور مرتبة من الأحدث للأقدم
        $this->attendances = $this->lecture->attendances()
            ->with('student')
            ->orderBy('created_at', 'desc')
            ->get();
        
        if ($this->isActive && $this->lecture->qr_token) {
            $this->qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($this->lecture->qr_token);
        } else {
            $this->qrCodeUrl = null;
        }
    }

    public function render()
    {
        return view('livewire.doctor.lecture-qr-code');
    }
}

