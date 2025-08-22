<?php

namespace App\Livewire\Admin\Reports\Widgets;

use App\Models\Department;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Doctor;
use Livewire\Component;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Facades\Log;

class DepartmentStatsWidget extends Component
{
    #[Reactive]
    public $departmentId;

    public $specializationsCount = 0;
    public $batchesCount = 0;
    public $studentsCount = 0;
    public $doctorsCount = 0;

    public function mount()
    {
        $this->loadStats();
    }

    public function updatedDepartmentId()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->reset(['specializationsCount', 'batchesCount', 'studentsCount', 'doctorsCount']);

        if (!$this->departmentId) {
            return;
        }

        try {
            $department = Department::findOrFail($this->departmentId);

            // --- [الكود المصحح] ---

            // 1. جلب عدد التخصصات (هذه كانت تعمل بشكل صحيح)
            $this->specializationsCount = $department->specializations()->count();

            // 2. جلب عدد الدفعات عبر التخصصات
            // whereHas: ابحث في الدفعات (Batches) التي "لديها" علاقة بالتخصصات (specialization)
            // حيث تكون هذه التخصصات تابعة للقسم الحالي (department_id)
            $this->batchesCount = Batch::whereHas('specialization', function ($query) {
                $query->where('department_id', $this->departmentId);
            })->count();

            // 3. جلب عدد الطلاب عبر الدفعات والتخصصات
            $this->studentsCount = Student::whereHas('batch.specialization', function ($query) {
                $query->where('department_id', $this->departmentId);
            })->count();

            // 4. جلب عدد الدكاترة عبر المواد والتخصصات
            // whereHas: ابحث في الدكاترة (Doctors) الذين "لديهم" علاقة بالمواد (courses)
            // وهذه المواد بدورها لديها علاقة بالتخصصات (specializations) التابعة للقسم الحالي
            $this->doctorsCount = Doctor::whereHas('courses.specialization', function ($query) {
                $query->where('department_id', $this->departmentId);
            })->distinct('doctors.id')->count(); // distinct() لمنع حساب الدكتور أكثر من مرة

            // --- [نهاية الكود المصحح] ---

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("Attempted to load stats for non-existent department ID: {$this->departmentId}");
            $this->dispatch('showToast', message: 'القسم المختار غير موجود.', type: 'error');
        } catch (\Exception $e) {
            Log::error('Error loading department stats widget: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء تحميل إحصائيات القسم.', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.admin.reports.widgets.department-stats-widget');
    }
}
