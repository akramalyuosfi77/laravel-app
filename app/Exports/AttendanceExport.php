<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $filters;

    // نستقبل الفلاتر من الكنترولر
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * هذه الدالة تحدد رؤوس الأعمدة في ملف Excel.
     */
    public function headings(): array
    {
        return [
            'ID الطالب',
            'اسم الطالب',
            'القسم',
            'التخصص',
            'المادة',
            'عنوان المحاضرة',
            'تاريخ المحاضرة',
            'الحالة',
            'ملاحظات',
        ];
    }

    /**
     * هذه الدالة تقوم بتحويل كل سجل من قاعدة البيانات إلى صف في ملف Excel.
     *
     * @param mixed $attendance
     * @return array
     */
    public function map($attendance): array
    {
        return [
            $attendance->student->student_id_number ?? 'N/A',
            $attendance->student->name ?? 'N/A',
            $attendance->student->batch->specialization->department->name ?? 'N/A',
            $attendance->student->batch->specialization->name ?? 'N/A',
            $attendance->lecture->course->name ?? 'N/A',
            $attendance->lecture->title ?? 'N/A',
            $attendance->lecture->lecture_date ? \Carbon\Carbon::parse($attendance->lecture->lecture_date)->format('Y-m-d') : 'N/A',
            $this->translateStatus($attendance->status),
            $attendance->notes ?? '',
        ];
    }

    /**
     * دالة مساعدة لترجمة الحالة إلى العربية.
     */
    private function translateStatus($status): string
    {
        return match ($status) {
            'present' => 'حاضر',
            'absent' => 'غائب',
            'excused_absence' => 'غائب بعذر',
            default => $status,
        };
    }

    /**
     * هذه هي الدالة الرئيسية التي تجلب البيانات من قاعدة البيانات
     * بناءً على نفس الفلاتر المستخدمة في صفحة العرض.
     */
    public function query()
    {
        $query = Attendance::query()->with([
            'student.batch.specialization.department',
            'lecture.course'
        ]);

        // تطبيق نفس منطق الفلترة تماماً
        $query->when($this->filters['search'], function ($q) {
            $q->whereHas('student', fn($sq) => $sq->where('name', 'like', "%{$this->filters['search']}%")
                ->orWhere('student_id_number', 'like', "%{$this->filters['search']}%"))
              ->orWhereHas('lecture', fn($sq) => $sq->where('title', 'like', "%{$this->filters['search']}%"));
        });

        $query->when($this->filters['status'], fn($q) => $q->where('status', $this->filters['status']));
        $query->when($this->filters['date_from'], fn($q) => $q->whereDate('created_at', '>=', $this->filters['date_from']));
        $query->when($this->filters['date_to'], fn($q) => $q->whereDate('created_at', '<=', $this->filters['date_to']));

        $query->when($this->filters['course_id'], function ($q) {
            $q->whereHas('lecture', fn($sq) => $sq->where('course_id', $this->filters['course_id']));
        });

        $query->when($this->filters['specialization_id'], function ($q) {
            $q->whereHas('student.batch', fn($sq) => $sq->where('specialization_id', $this->filters['specialization_id']));
        });

        $query->when($this->filters['department_id'], function ($q) {
            $q->whereHas('student.batch.specialization', fn($sq) => $sq->where('department_id', $this->filters['department_id']));
        });

        return $query->latest();
    }
}
