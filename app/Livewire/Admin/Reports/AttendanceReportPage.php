<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Department;
use App\Models\Specialization;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport; // سنقوم بإنشاء هذا الملف لاحقاً

class AttendanceReportPage extends Component
{
    use WithPagination;

    // --- خصائص الفلاتر ---
    public $search = '';
    public $filter_department_id = '';
    public $filter_specialization_id = '';
    public $filter_course_id = '';
    public $filter_status = '';
    public $filter_date_from;
    public $filter_date_to;

    // --- دوال إعادة تعيين الترقيم عند الفلترة ---
    public function updating($property)
    {
        // إذا تغير أي فلتر، أعد الترقيم إلى الصفحة الأولى
        if (in_array($property, ['search', 'filter_department_id', 'filter_specialization_id', 'filter_course_id', 'filter_status', 'filter_date_from', 'filter_date_to'])) {
            $this->resetPage();
        }
    }

    // دالة لإعادة تعيين التخصص والمادة عند تغيير القسم
    public function updatedFilterDepartmentId()
    {
        $this->reset(['filter_specialization_id', 'filter_course_id']);
    }

    // دالة لإعادة تعيين المادة عند تغيير التخصص
    public function updatedFilterSpecializationId()
    {
        $this->reset('filter_course_id');
    }

    // --- [تحسين الأداء] الخصائص المحسوبة لجلب بيانات الفلاتر ---

    #[Computed(cache: true)]
    public function departments()
    {
        return Department::orderBy('name')->get();
    }

    #[Computed]
    public function specializations()
    {
        if (!$this->filter_department_id) {
            return collect();
        }
        return Specialization::where('department_id', $this->filter_department_id)->orderBy('name')->get();
    }

    #[Computed]
    public function courses()
    {
        if (!$this->filter_specialization_id) {
            return collect();
        }
        // جلب المواد المرتبطة بالتخصص المختار
        return Course::whereHas('specializations', fn($q) => $q->where('specializations.id', $this->filter_specialization_id))
            ->orderBy('name')->get();
    }

    /**
     * دالة لتصدير النتائج الحالية إلى ملف Excel.
     */
    public function export()
    {
        // سنقوم بتمرير نفس الفلاتر إلى كلاس التصدير
        $filters = [
            'search' => $this->search,
            'department_id' => $this->filter_department_id,
            'specialization_id' => $this->filter_specialization_id,
            'course_id' => $this->filter_course_id,
            'status' => $this->filter_status,
            'date_from' => $this->filter_date_from,
            'date_to' => $this->filter_date_to,
        ];

        return Excel::download(new AttendanceExport($filters), 'attendance_report.xlsx');
    }

    public function render()
    {
        // بناء الاستعلام الأساسي مع كل العلاقات المطلوبة (لتحسين الأداء)
        $query = Attendance::with([
            'student.batch.specialization.department',
            'lecture.course'
        ]);

        // تطبيق الفلاتر بشكل متسلسل
        $query->when($this->search, function ($q) {
            $q->whereHas('student', fn($sq) => $sq->where('name', 'like', "%{$this->search}%")
                ->orWhere('student_id_number', 'like', "%{$this->search}%"))
              ->orWhereHas('lecture', fn($sq) => $sq->where('title', 'like', "%{$this->search}%"));
        });

        $query->when($this->filter_status, fn($q) => $q->where('status', $this->filter_status));
        $query->when($this->filter_date_from, fn($q) => $q->whereDate('created_at', '>=', $this->filter_date_from));
        $query->when($this->filter_date_to, fn($q) => $q->whereDate('created_at', '<=', $this->filter_date_to));

        // فلاتر متداخلة عبر العلاقات
        $query->when($this->filter_course_id, function ($q) {
            $q->whereHas('lecture', fn($sq) => $sq->where('course_id', $this->filter_course_id));
        });

        $query->when($this->filter_specialization_id, function ($q) {
            $q->whereHas('student.batch', fn($sq) => $sq->where('specialization_id', $this->filter_specialization_id));
        });

        $query->when($this->filter_department_id, function ($q) {
            $q->whereHas('student.batch.specialization', fn($sq) => $sq->where('department_id', $this->filter_department_id));
        });

        // جلب النتائج مع الترتيب والترقيم
        $attendanceRecords = $query->latest()->paginate(15);

        return view('livewire.admin.reports.attendance-report-page', [
            'attendanceRecords' => $attendanceRecords,
        ]);
    }
}
