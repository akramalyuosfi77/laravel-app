<?php

namespace App\Livewire\Admin;

use App\Models\Batch;
use App\Models\Specialization;
use App\Models\Department;
use App\Models\Course;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;      // لاستخدام الخصائص المحسوبة
use Illuminate\Support\Facades\Log;      // لتسجيل الأخطاء

class BatchesPage extends Component
{
    use WithPagination;

    // --- خصائص النموذج ---
    public $name, $start_year, $specialization_id;
    public $academic_year, $semester;
    public $edit_id = null;
    public $delete_id = null;
    public $showForm = false;

    // --- خصائص نافذة عرض التفاصيل ---
    public $showViewModal = false;
    public $viewedBatch = null;
    public $viewedCourses = [];
    public $viewedStudents = [];

    // --- خصائص مساعدة للنماذج المتسلسلة ---
    public $selected_department_id_for_form = '';

    // --- خصائص البحث والفلاتر ---
    public $search = '';
    public $filter_specialization_id = '';
    public $filter_department_id = '';

    // --- قواعد التحقق ---
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:2100',
            'specialization_id' => 'required|exists:specializations,id',
            'academic_year' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1|max:2',
        ];
    }

    public function updated($propertyName)
    {
        // عند تغيير القسم في النموذج، قم بإعادة تعيين التخصص المختار
        if ($propertyName === 'selected_department_id_for_form') {
            $this->reset('specialization_id');
        }
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();
        try {
            Batch::updateOrCreate(
                ['id' => $this->edit_id],
                [
                    'name' => $this->name,
                    'start_year' => $this->start_year,
                    'specialization_id' => $this->specialization_id,
                    'academic_year' => $this->academic_year,
                    'semester' => $this->semester,
                ]
            );

            $this->closeForm();
            $message = $this->edit_id ? 'تم تحديث الدفعة بنجاح' : 'تم إضافة الدفعة بنجاح';
            $this->dispatch('showToast', message: $message, type: 'success');
        } catch (\Exception $e) {
            Log::error('Error saving batch: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ الدفعة.', type: 'error');
        }
    }

    public function edit($id)
    {
        try {
            $batch = Batch::findOrFail($id);
            $this->edit_id = $batch->id;
            $this->name = $batch->name;
            $this->start_year = $batch->start_year;
            $this->specialization_id = $batch->specialization_id;
            $this->academic_year = $batch->academic_year;
            $this->semester = $batch->semester;
            $this->selected_department_id_for_form = $batch->specialization->department_id ?? '';
            $this->showForm = true;
        } catch (\Exception $e) {
            Log::error('Error editing batch: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على الدفعة المطلوبة.', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
    }

    public function delete()
    {
        try {
            Batch::findOrFail($this->delete_id)->delete();
            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف الدفعة بنجاح', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting batch: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف الدفعة.', type: 'error');
        }
    }

    /**
     * دالة viewBatch: هذا هو المنطق المعقد الذي يعرض تفاصيل الدفعة.
     * تم تحصينه الآن بـ try-catch.
     */
    public function viewBatch($id)
    {
        try {
            // جلب الدفعة مع علاقاتها الأساسية (التخصص وقسمه، والطلاب)
            $this->viewedBatch = Batch::with(['specialization.department', 'students'])->findOrFail($id);

            // [منطق معقد] جلب المواد المخصصة لهذه الدفعة في مستواها الحالي
            // 1. نبني استعلاماً على جدول المواد (Courses)
            // 2. نربطه (join) بالجدول الوسيط (specialization_course_academic_period) الذي يمثل الخطة الدراسية
            // 3. نربطه (leftJoin) بجدول الدكاترة لجلب اسم الدكتور (استخدمنا leftJoin لأنه قد لا يكون هناك دكتور معين للمادة)
            // 4. نفلتر النتائج لتطابق تخصص الدفعة، وسنتها، وترمها الحالي
            // 5. نختار الحقول التي نريد عرضها فقط، مع تسمية اسم الدكتور باسم مستعار (doctor_name) لتجنب تضارب الأسماء
            $this->viewedCourses = Course::query()
                ->join('specialization_course_academic_period as scap', 'courses.id', '=', 'scap.course_id')
                ->leftJoin('doctors as doc', 'scap.doctor_id', '=', 'doc.id')
                ->where('scap.specialization_id', $this->viewedBatch->specialization_id)
                ->where('scap.academic_year', $this->viewedBatch->academic_year)
                ->where('scap.semester', $this->viewedBatch->semester)
                ->select('courses.name', 'courses.code', 'courses.type', 'courses.description', 'doc.name as doctor_name')
                ->get();

            // تعيين طلاب الدفعة للعرض
            $this->viewedStudents = $this->viewedBatch->students;

            $this->showViewModal = true;
        } catch (\Exception $e) {
            Log::error('Error viewing batch details: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء عرض تفاصيل الدفعة.', type: 'error');
        }
    }

    // --- دوال مساعدة للتحكم في واجهة المستخدم ---
    public function resetForm()
    {
        $this->reset(['name', 'start_year', 'specialization_id', 'academic_year', 'semester', 'edit_id', 'selected_department_id_for_form']);
        $this->resetValidation();
    }
    public function openForm() { $this->resetForm(); $this->showForm = true; }
    public function closeForm() { $this->showForm = false; $this->resetForm(); }
    public function closeViewModal() { $this->showViewModal = false; $this->reset(['viewedBatch', 'viewedCourses', 'viewedStudents']); }

    // --- دوال لإعادة تعيين الترقيم عند البحث أو الفلترة ---
    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterSpecializationId() { $this->resetPage(); }
    public function updatingFilterDepartmentId() { $this->resetPage(); $this->filter_specialization_id = ''; }

    // --- [تحسين الأداء] استخدام الخصائص المحسوبة (Computed Properties) ---

    #[Computed(cache: true)]
    public function departments()
    {
        return Department::orderBy('name')->get();
    }

    #[Computed]
    public function filterSpecializations()
    {
        if (!$this->filter_department_id) {
            return Specialization::orderBy('name')->get();
        }
        return Specialization::where('department_id', $this->filter_department_id)->orderBy('name')->get();
    }

    #[Computed]
    public function formSpecializations()
    {
        if (!$this->selected_department_id_for_form) {
            return collect(); // إرجاع مجموعة فارغة إذا لم يتم اختيار قسم
        }
        return Specialization::where('department_id', $this->selected_department_id_for_form)->orderBy('name')->get();
    }

    public function render()
    {
        // [منطق معقد] بناء استعلام جلب الدفعات مع الفلاتر
        // 1. نبدأ بالدفعة مع علاقاتها الأساسية (لتقليل الاستعلامات لاحقاً)
        // 2. نطبق البحث (when) على عدة حقول، بما في ذلك الحقول في الجداول المرتبطة (orWhereHas)
        // 3. نطبق فلتر التخصص (when)
        // 4. نطبق فلتر القسم (when) عبر علاقة التخصص
        // 5. نرتب ونقسم النتائج إلى صفحات
        $batches = Batch::with(['specialization.department'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('start_year', 'like', '%' . $this->search . '%')
                      ->orWhereHas('specialization', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                      ->orWhereHas('specialization.department', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            })
            ->when($this->filter_specialization_id, fn($q) => $q->where('specialization_id', $this->filter_specialization_id))
            ->when($this->filter_department_id, fn($q) => $q->whereHas('specialization', fn($sq) => $sq->where('department_id', $this->filter_department_id)))
            ->latest('created_at')
            ->paginate(10);

        return view('livewire.admin.batches-page', [
            'batches' => $batches,
            'academicYearsOptions' => range(1, 6),
            'semestersOptions' => [1, 2],
        ]);
    }
}
