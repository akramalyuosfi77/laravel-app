<?php

namespace App\Livewire\Admin\Reports\Widgets;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Reactive;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

class DepartmentStudentsWidget extends Component
{
    use WithPagination;

    // 💡 سيستقبل إما ID القسم أو ID التخصص
    #[Reactive]
    public $departmentId = null;

    #[Reactive]
    public $specializationId = null;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function export()
    {
        // 💡 نمرر كلا المتغيرين إلى كلاس التصدير
        return Excel::download(new StudentsExport($this->departmentId, $this->specializationId, $this->search), 'students_report.xlsx');
    }

    public function render()
    {
        // 💡 بناء الاستعلام بشكل ديناميكي
        $studentsQuery = Student::query()
            ->with(['batch.specialization'])
            ->when($this->departmentId, function ($query) {
                // إذا كان هناك قسم محدد، قم بالفلترة بناءً عليه
                $query->whereHas('batch.specialization', function ($q) {
                    $q->where('department_id', $this->departmentId);
                });
            })
            ->when($this->specializationId, function ($query) {
                // إذا كان هناك تخصص محدد، قم بالفلترة بناءً عليه
                $query->whereHas('batch', function ($q) {
                    $q->where('specialization_id', $this->specializationId);
                });
            })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('student_id_number', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest();

        return view('livewire.admin.reports.widgets.department-students-widget', [
            'students' => $studentsQuery->paginate(10, ['*'], 'studentsPage'),
        ]);
    }
}
