<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CourseGradesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $course;
    protected $search;

    public function __construct(Course $course, $search)
    {
        $this->course = $course;
        $this->search = $search;
    }

    public function collection()
    {
        return $this->course->students()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('student_id_number', 'like', '%' . $this->search . '%');
            })
            ->get();
    }

    public function headings(): array
    {
        $headings = ['الاسم', 'الرقم الجامعي'];
        // إضافة أسماء التكليفات كعناوين للأعمدة
        foreach ($this->course->assignments as $assignment) {
            $headings[] = $assignment->title;
        }
        return $headings;
    }

    public function map($student): array
    {
        $row = [
            $student->name,
            $student->student_id_number,
        ];
        // جلب درجة الطالب في كل تكليف
        foreach ($this->course->assignments as $assignment) {
            $submission = $student->submissions()->where('assignment_id', $assignment->id)->first();
            $row[] = $submission?->grade ?? 'لم يسلم';
        }
        return $row;
    }
}
