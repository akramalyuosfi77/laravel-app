<?php

namespace App\Livewire\Doctor\Reports\Widgets;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Reactive;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CourseGradesExport;

class CourseStudentsWidget extends Component
{
    use WithPagination;

    #[Reactive]
    public $courseId;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function export()
    {
        $course = Course::with('assignments')->find($this->courseId);
        if (!$course) return;

        return Excel::download(new CourseGradesExport($course, $this->search), 'grades_report_' . $course->code . '.xlsx');
    }

    public function render()
    {
        $course = Course::with('assignments')->find($this->courseId);

        if (!$course) {
            return view('livewire.doctor.reports.widgets.course-students-widget', [
                'course' => null,
                'students' => collect(),
            ]);
        }

        $students = $course->students() // <-- استخدام العلاقة الجديدة
        ->with(['submissions' => function ($query) use ($course) {
            $query->whereIn('assignment_id', $course->assignments->pluck('id'));
        }])
        ->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('student_id_number', 'like', '%' . $this->search . '%');
        })
        ->paginate(10, ['*'], 'gradesPage');


        return view('livewire.doctor.reports.widgets.course-students-widget', [
            'course' => $course,
            'students' => $students,
        ]);
    }
}
