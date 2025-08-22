<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $departmentId;
    protected $specializationId;
    protected $search;

    public function __construct($departmentId, $specializationId, $search)
    {
        $this->departmentId = $departmentId;
        $this->specializationId = $specializationId;
        $this->search = $search;
    }

    public function query()
    {
        return Student::query()
            ->with(['batch.specialization'])
            ->when($this->departmentId, function ($query) {
                $query->whereHas('batch.specialization', fn($q) => $q->where('department_id', $this->departmentId));
            })
            ->when($this->specializationId, function ($query) {
                $query->whereHas('batch', fn($q) => $q->where('specialization_id', $this->specializationId));
            })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('student_id_number', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest();
    }

    public function headings(): array
    {
        return ['الاسم', 'الرقم الجامعي', 'البريد الإلكتروني', 'التخصص', 'الدفعة', 'الحالة'];
    }

    public function map($student): array
    {
        return [
            $student->name,
            $student->student_id_number,
            $student->email,
            $student->batch?->specialization?->name ?? 'N/A',
            $student->batch?->name ?? 'N/A',
            $student->status,
        ];
    }
}
