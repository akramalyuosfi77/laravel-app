<?php

namespace App\Livewire\Doctor;

use App\Models\Attendance;
use App\Models\Lecture;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AttendanceManager extends Component
{
    public Lecture $lecture;
    public $students = [];
    public $attendance_status = []; // مصفوفة لتخزين حالة كل طالب

    /**
     * دالة mount تُنفذ عند تحميل المكون لأول مرة.
     * تقوم بتهيئة البيانات الأساسية.
     */
    public function mount(Lecture $lecture)
    {
        // [أمان] التأكد من أن الدكتور الحالي هو من يملك هذه المحاضرة
        if ($lecture->doctor_id !== Auth::user()->doctor->id) {
            abort(403, 'غير مصرح لك بالوصول لهذه الصفحة.');
        }

        $this->lecture = $lecture;
        $this->loadStudentsAndAttendance();
    }

    /**
     * دالة مخصصة لجلب الطلاب وسجلات الحضور الحالية.
     */
    public function loadStudentsAndAttendance()
    {
        try {
            // 1. جلب كل الطلاب المسجلين في مادة هذه المحاضرة
            // نستخدم العلاقة المحسنة students() الموجودة في مودل Course
// [تحسين] جلب الطلاب الذين لديهم حساب مستخدم مرتبط فقط
$this->students = $this->lecture->course->students()
    ->whereHas('user') // ✅ هذا السطر يضمن وجود علاقة user
    ->with('user')     // ✅ وهذا السطر يقوم بتحميل العلاقة بكفاءة (Eager Loading)
    ->orderBy('name')
    ->get();

            // 2. جلب سجلات الحضور الحالية لهذه المحاضرة وتحويلها إلى مصفوفة سهلة التعامل
            // key = student_id, value = status
            $current_attendance = Attendance::where('lecture_id', $this->lecture->id)
                ->pluck('status', 'student_id');

            // 3. تعبئة مصفوفة attendance_status بالبيانات الحالية أو بالقيمة الافتراضية 'absent'
            foreach ($this->students as $student) {
                $this->attendance_status[$student->id] = $current_attendance[$student->id] ?? 'absent';
            }
        } catch (\Exception $e) {
            Log::error('Error loading students for attendance: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء تحميل قائمة الطلاب.', type: 'error');
        }
    }

    /**
     * هذه هي الدالة التي سيتم استدعاؤها عند الضغط على أزرار الحضور.
     *
     * @param int $studentId
     * @param string $status
     */
    public function updateAttendance(int $studentId, string $status)
    {
        // التحقق من أن الحالة المدخلة هي إحدى القيم المسموح بها
        if (!in_array($status, ['present', 'absent', 'excused_absence'])) {
            return;
        }

        try {
            // استخدام updateOrCreate لتحديث السجل إن كان موجوداً، أو إنشائه إن لم يكن
            Attendance::updateOrCreate(
                [
                    'lecture_id' => $this->lecture->id,
                    'student_id' => $studentId,
                ],
                [
                    'status' => $status,
                ]
            );

            // تحديث الحالة في المصفوفة المحلية لعكس التغيير فوراً في الواجهة
            $this->attendance_status[$studentId] = $status;

        } catch (\Exception $e) {
            Log::error('Error updating attendance: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء تسجيل الحضور.', type: 'error');
        }
    }

    /**
     * دالة لتسجيل كل الطلاب كـ "حاضر" دفعة واحدة.
     */
    public function markAllAsPresent()
    {
        try {
            $student_ids = $this->students->pluck('id');
            $records = [];
            foreach ($student_ids as $student_id) {
                $records[] = [
                    'lecture_id' => $this->lecture->id,
                    'student_id' => $student_id,
                    'status' => 'present',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                // تحديث الواجهة فوراً
                $this->attendance_status[$student_id] = 'present';
            }

            // [تحسين أداء] استخدام upsert لإدخال/تحديث كل السجلات في استعلام واحد
            Attendance::upsert($records, ['lecture_id', 'student_id'], ['status', 'updated_at']);

            $this->dispatch('showToast', message: 'تم تسجيل الجميع كـ "حاضر".', type: 'success');

        } catch (\Exception $e) {
            Log::error('Error marking all as present: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء العملية.', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.doctor.attendance-manager');
    }
}
