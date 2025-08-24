<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Specialization;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\SpecializationCourseAcademicPeriod;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed; // <-- [إضافة]
use Illuminate\Support\Facades\DB;   // <-- [إضافة]
use Illuminate\Support\Facades\Log;  // <-- [إضافة]

class CoursesPage extends Component
{
    use WithPagination;

    // --- خصائص النموذج ---
    public $name, $code, $type, $academic_year, $semester, $specialization_id, $description;
    public $doctor_id;
    public $edit_id = null;
    public $delete_id = null;
    public $showForm = false;

    // --- خصائص الفلاتر والواجهة المتسلسلة ---
    public $search = '';
    public $filter_specialization_id = '';
    public $filter_academic_year = '';
    public $filter_semester = '';
    public $filter_department_id = '';
    public $selected_department_id_for_form = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:courses,code,' . $this->edit_id,
            'type' => 'required|string|in:نظرى,عملى',
            'academic_year' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1|max:2',
            'specialization_id' => 'required|exists:specializations,id',
            'description' => 'nullable|string',
            'doctor_id' => 'nullable|exists:doctors,id',
        ];
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'selected_department_id_for_form') {
            $this->reset('specialization_id');
        }
        $this->validateOnly($propertyName);
    }

    /**
     * دالة save() المحسّنة.
     * تستخدم DB::transaction لضمان أن عملية حفظ المادة وبياناتها في الجدول الوسيط
     * تتم كوحدة واحدة لا تتجزأ.
     */
    public function save()
    {
        $this->validate();
        try {
            // بدء معاملة آمنة
            DB::transaction(function () {
                // الخطوة 1: إنشاء أو تحديث المادة في جدول courses
                $course = Course::updateOrCreate(
                    ['id' => $this->edit_id],
                    [
                        'name' => $this->name,
                        'code' => $this->code,
                        'type' => $this->type,
                        'description' => $this->description,
                        // الحقول الأخرى تم نقلها للجدول الوسيط
                    ]
                );

                // الخطوة 2: إنشاء أو تحديث السجل في الجدول الوسيط الذي يربط كل شيء
                SpecializationCourseAcademicPeriod::updateOrCreate(
                    [
                        'course_id' => $course->id,
                        'specialization_id' => $this->specialization_id,
                        'academic_year' => $this->academic_year,
                        'semester' => $this->semester,
                    ],
                    [
                        'doctor_id' => $this->doctor_id,
                    ]
                );
            }); // نهاية المعاملة الآمنة

            $this->closeForm();
            $message = $this->edit_id ? 'تم تحديث المادة بنجاح' : 'تم إضافة المادة بنجاح';
            $this->dispatch('showToast', message: $message, type: 'success');

        } catch (\Exception $e) {
            Log::error('Error saving course: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ المادة.', type: 'error');
        }
    }

    public function edit($id)
    {
        try {
            $course = Course::findOrFail($id);
            $this->edit_id = $course->id;
            $this->name = $course->name;
            $this->code = $course->code;
            $this->type = $course->type;
            $this->description = $course->description;

            // جلب البيانات من الجدول الوسيط
            $pivotEntry = SpecializationCourseAcademicPeriod::where('course_id', $course->id)->first();

            if ($pivotEntry) {
                $this->academic_year = $pivotEntry->academic_year;
                $this->semester = $pivotEntry->semester;
                $this->specialization_id = $pivotEntry->specialization_id;
                $this->doctor_id = $pivotEntry->doctor_id;
                $this->selected_department_id_for_form = $pivotEntry->specialization->department_id ?? '';
            } else {
                // إعادة تعيين الحقول إذا لم يتم العثور على بيانات مرتبطة
                $this->reset(['academic_year', 'semester', 'specialization_id', 'doctor_id', 'selected_department_id_for_form']);
            }

            $this->showForm = true;
        } catch (\Exception $e) {
            Log::error('Error editing course: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على المادة المطلوبة.', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
    }

    /**
     * دالة delete() المحسّنة.
     * تستخدم DB::transaction لضمان حذف المادة وسجلاتها المرتبطة معاً.
     */
    public function delete()
    {
        try {
            DB::transaction(function () {
                // لا حاجة لحذف السجلات من الجدول الوسيط يدوياً
                // لأننا استخدمنا onDelete('cascade') في ملف الـ migration
                // سيقوم لارافيل بحذفها تلقائياً عند حذف المادة.
                Course::findOrFail($this->delete_id)->delete();
            });

            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف المادة بنجاح', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting course: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف المادة.', type: 'error');
        }
    }

    // --- دوال مساعدة ---
    public function resetForm()
    {
        $this->reset(['name', 'code', 'type', 'academic_year', 'semester', 'specialization_id', 'description', 'doctor_id', 'edit_id', 'selected_department_id_for_form']);
        $this->resetValidation();
    }
    public function openForm() { $this->resetForm(); $this->showForm = true; }
    public function closeForm() { $this->showForm = false; $this->resetForm(); }

    // --- دوال إعادة تعيين الترقيم ---
    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterSpecializationId() { $this->resetPage(); }
    public function updatingFilterAcademicYear() { $this->resetPage(); }
    public function updatingFilterSemester() { $this->resetPage(); }
    public function updatingFilterDepartmentId() { $this->resetPage(); $this->filter_specialization_id = ''; }

    // --- [تحسين الأداء] الخصائص المحسوبة ---
    #[Computed(cache: true)]
    public function departments() { return Department::orderBy('name')->get(); }

    #[Computed(cache: true)]
    public function doctors() { return Doctor::orderBy('name')->get(); }

    #[Computed]
    public function filterSpecializations()
    {
        if (!$this->filter_department_id) return Specialization::orderBy('name')->get();
        return Specialization::where('department_id', $this->filter_department_id)->orderBy('name')->get();
    }

    #[Computed]
    public function formSpecializations()
    {
        if (!$this->selected_department_id_for_form) return collect();
        return Specialization::where('department_id', $this->selected_department_id_for_form)->orderBy('name')->get();
    }

    public function render()
    {
        // [منطق معقد] هذا الاستعلام يقوم بجلب البيانات من 4 جداول مختلفة
        // باستخدام leftJoin لضمان عرض المواد حتى لو لم تكن مرتبطة بخطة دراسية بعد.
        $courses = Course::query()
            ->leftJoin('specialization_course_academic_period as scap', 'courses.id', '=', 'scap.course_id')
            ->leftJoin('specializations as s', 'scap.specialization_id', '=', 's.id')
            ->leftJoin('departments as d', 's.department_id', '=', 'd.id')
            ->leftJoin('doctors as doc', 'scap.doctor_id', '=', 'doc.id')
            ->select(
                'courses.*',
                's.name as specialization_name',
                'd.name as department_name',
                'scap.academic_year',
                'scap.semester',
                'doc.name as doctor_name'
            )
            ->when($this->search, function ($query) {
                $query->where('courses.name', 'like', '%' . $this->search . '%')
                      ->orWhere('courses.code', 'like', '%' . $this->search . '%')
                      ->orWhere('s.name', 'like', '%' . $this->search . '%')
                      ->orWhere('doc.name', 'like', '%' . $this->search . '%');
            })
            ->when($this->filter_department_id, fn($q) => $q->where('s.department_id', $this->filter_department_id))
            ->when($this->filter_specialization_id, fn($q) => $q->where('scap.specialization_id', $this->filter_specialization_id))
            ->when($this->filter_academic_year, fn($q) => $q->where('scap.academic_year', $this->filter_academic_year))
            ->when($this->filter_semester, fn($q) => $q->where('scap.semester', $this->filter_semester))
            ->latest('courses.created_at')
            ->paginate(10);

        return view('livewire.admin.courses-page', [
            'courses' => $courses,
            'academicYears' => range(1, 6),
            'semesters' => [1, 2],
        ]);
    }
}
