<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Department;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Specialization;
use App\Models\SpecializationCourseAcademicPeriod;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;  // <-- [إضافة]
use Livewire\Attributes\Computed; // <-- [إضافة]
use Carbon\Carbon;                  // <-- [إضافة]

class SchedulesPage extends Component
{
    use WithPagination;

    // --- خصائص النموذج ---
    public $schedule_id;
    public $specialization_course_academic_period_id;
    public $location_id;
    public $day_of_week;
    public $start_time;
    public $end_time;

    // --- خصائص الواجهة ---
    public $showForm = false;
    public $delete_id = null;
    public $search = '';

    // --- خصائص الفلاتر المتسلسلة للنموذج ---
    public $selectedDepartment = null;
    public $selectedSpecialization = null;
    public $selectedCourse = null;

    // --- قواعد التحقق ---
    protected function rules()
    {
        return [
            // يجب اختيار خطة دراسية (مادة+تخصص+سنة+ترم)
            'specialization_course_academic_period_id' => [
                'required',
                'exists:specialization_course_academic_period,id',
                // [قاعدة معقدة] منع تكرار نفس المحاضرة في نفس اليوم والوقت
                Rule::unique('schedules')->where(function ($query) {
                    return $query->where('day_of_week', $this->day_of_week)
                                 ->where('start_time', $this->start_time);
                })->ignore($this->schedule_id),
            ],
            'location_id' => 'required|exists:locations,id',
            'day_of_week' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday',
            'start_time' => [
                'required',
                'date_format:H:i',
                // [قاعدة معقدة] منع حجز نفس القاعة في نفس اليوم والوقت المتداخل
                Rule::unique('schedules')->where(function ($query) {
                    return $query->where('location_id', $this->location_id)
                                 ->where('day_of_week', $this->day_of_week)
                                 ->where(fn($q) => $q->where('start_time', '<', $this->end_time)->where('end_time', '>', $this->start_time));
                })->ignore($this->schedule_id),
            ],
            'end_time' => 'required|date_format:H:i|after:start_time',
        ];
    }

    protected $messages = [
        'specialization_course_academic_period_id.required' => 'يجب اختيار الخطة الدراسية (السنة والترم والدكتور).',
        'specialization_course_academic_period_id.unique' => 'هذه المحاضرة مجدولة بالفعل في هذا اليوم وهذا التوقيت.',
        'start_time.unique' => 'هذه القاعة محجوزة بالفعل في هذا التوقيت. الرجاء اختيار وقت أو قاعة أخرى.',
        'end_time.after' => 'يجب أن يكون وقت الانتهاء بعد وقت البدء.',
    ];

    /**
     * [منطق معقد] دالة للتحقق من تعارض المواعيد للدكتور أو للدفعة.
     * هذه الدالة تمنع حجز دكتور أو دفعة في نفس الوقت في قاعات مختلفة.
     */
    private function checkForConflicts()
    {
        $plan = SpecializationCourseAcademicPeriod::find($this->specialization_course_academic_period_id);
        if (!$plan) return false;

        $conflict = Schedule::where('day_of_week', $this->day_of_week)
            ->where('id', '!=', $this->schedule_id)
            ->where(fn($q) => $q->where('start_time', '<', $this->end_time)->where('end_time', '>', $this->start_time))
            ->whereHas('coursePlan', function ($query) use ($plan) {
                $query->where('doctor_id', $plan->doctor_id) // هل الدكتور مشغول؟
                      ->orWhere(function ($q) use ($plan) { // أو هل الدفعة مشغولة؟
                          $q->where('specialization_id', $plan->specialization_id)
                            ->where('academic_year', $plan->academic_year)
                            ->where('semester', $plan->semester);
                      });
            })
            ->first();

        if ($conflict) {
            $isDoctorConflict = $conflict->coursePlan->doctor_id == $plan->doctor_id;
            $message = $isDoctorConflict ? 'الدكتور لديه محاضرة أخرى في هذا التوقيت.' : 'الدفعة لديها محاضرة أخرى في هذا التوقيت.';
            $this->addError('start_time', $message);
            return true;
        }
        return false;
    }

    public function save()
    {
        $this->validate();
        if ($this->checkForConflicts()) return;

        try {
            Schedule::updateOrCreate(
                ['id' => $this->schedule_id],
                [
                    'specialization_course_academic_period_id' => $this->specialization_course_academic_period_id,
                    'location_id' => $this->location_id,
                    'day_of_week' => $this->day_of_week,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                ]
            );
            $this->closeForm();
            $message = $this->schedule_id ? 'تم تحديث الموعد بنجاح.' : 'تم إضافة الموعد بنجاح.';
            $this->dispatch('showToast', message: $message, type: 'success');
        } catch (\Exception $e) {
            Log::error('Error saving schedule: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ الموعد.', type: 'error');
        }
    }

    public function edit($id)
    {
        try {
            $schedule = Schedule::with('coursePlan.specialization.department')->findOrFail($id);
            $this->schedule_id = $id;
            $this->selectedDepartment = $schedule->coursePlan->specialization->department_id;
            $this->selectedSpecialization = $schedule->coursePlan->specialization_id;
            $this->selectedCourse = $schedule->coursePlan->course_id;
            $this->specialization_course_academic_period_id = $schedule->specialization_course_academic_period_id;
            $this->location_id = $schedule->location_id;
            $this->day_of_week = $schedule->day_of_week;
            $this->start_time = Carbon::parse($schedule->start_time)->format('H:i');
            $this->end_time = Carbon::parse($schedule->end_time)->format('H:i');
            $this->showForm = true;
        } catch (\Exception $e) {
            Log::error('Error editing schedule: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على الموعد المطلوب.', type: 'error');
        }
    }

    public function confirmDelete($id) { $this->delete_id = $id; }

    public function delete()
    {
        try {
            Schedule::findOrFail($this->delete_id)->delete();
            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف الموعد بنجاح.', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting schedule: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف الموعد.', type: 'error');
        }
    }

    // --- دوال مساعدة ---
    public function resetForm() { $this->reset(); $this->resetValidation(); }
    public function openForm() { $this->resetForm(); $this->showForm = true; }
    public function closeForm() { $this->showForm = false; $this->resetForm(); }
    public function updating($property) { if (in_array($property, ['selectedDepartment', 'selectedSpecialization', 'selectedCourse'])) $this->resetValidation(); }
    public function updatedSelectedDepartment() { $this->reset(['selectedSpecialization', 'selectedCourse', 'specialization_course_academic_period_id']); }
    public function updatedSelectedSpecialization() { $this->reset(['selectedCourse', 'specialization_course_academic_period_id']); }
    public function updatedSelectedCourse() { $this->reset('specialization_course_academic_period_id'); }

    // --- [تحسين الأداء] الخصائص المحسوبة ---
    #[Computed(cache: true)]
    public function departments() { return Department::orderBy('name')->get(); }

    #[Computed(cache: true)]
    public function locations() { return Location::orderBy('name')->get(); }

    #[Computed]
    public function specializations() {
        if (!$this->selectedDepartment) return collect();
        return Specialization::where('department_id', $this->selectedDepartment)->orderBy('name')->get();
    }

    #[Computed]
    public function courses() {
        if (!$this->selectedSpecialization) return collect();
        return Course::whereHas('specializations', fn($q) => $q->where('specialization_id', $this->selectedSpecialization))->orderBy('name')->get();
    }

    #[Computed]
    public function coursePlans() {
        if (!$this->selectedCourse) return collect();
        return SpecializationCourseAcademicPeriod::with('doctor')
            ->where('specialization_id', $this->selectedSpecialization)
            ->where('course_id', $this->selectedCourse)
            ->get();
    }

    public function render()
    {
        $schedules = Schedule::with(['coursePlan.course', 'coursePlan.specialization', 'coursePlan.doctor', 'location'])
            ->when($this->search, function ($query) {
                $query->whereHas('coursePlan.course', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                      ->orWhereHas('location', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                      ->orWhereHas('coursePlan.doctor', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.schedules-page', ['schedules' => $schedules]);
    }
}
