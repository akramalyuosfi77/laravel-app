<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Department;
use App\Models\Specialization;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ReportCenter extends Component
{
    public $reportScope = 'university';
    public $selectedDepartmentId = null;
    public $selectedSpecializationId = null;

    // --- [الخصائص المحسوبة] ---

    #[Computed(cache: true)]
    public function departments()
    {
        return Department::orderBy('name')->get();
    }

    // 💡 تم تغيير اسم الدالة لتجنب التعارض
    #[Computed] // 💡 تم إزالة الكاش من هنا مؤقتاً لضمان التحديث
    public function reportSpecializations()
    {
        if (!$this->selectedDepartmentId) {
            return collect();
        }
        return Specialization::where('department_id', $this->selectedDepartmentId)->orderBy('name')->get();
    }

    // --- [دوال التحديث] ---

    /**
     * 💡 هذه هي الدالة السحرية التي ستحل المشكلة.
     * يتم استدعاؤها تلقائياً بواسطة Livewire عند تغيير قيمة $selectedDepartmentId.
     */
    public function updatedSelectedDepartmentId($value)
    {
        // 1. إعادة تعيين اختيار التخصص عند تغيير القسم
        $this->reset('selectedSpecializationId');

        // 2. [الأهم] إجبار Livewire على إعادة حساب قائمة التخصصات
        // هذا السطر يخبر Livewire: "انسَ النتيجة القديمة لـ reportSpecializations"
        unset($this->reportSpecializations);
    }

    public function render()
    {
        return view('livewire.admin.reports.report-center');
    }
}
