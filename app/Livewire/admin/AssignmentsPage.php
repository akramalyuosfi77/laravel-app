<?php

namespace App\Livewire\Admin;

// استيراد الكلاسات والنماذج الضرورية
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Doctor;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;      // لاستخدام الخصائص المحسوبة التي تحسن الأداء
use Illuminate\Support\Facades\Log;      // لتسجيل أي أخطاء تحدث في الخلفية
use Carbon\Carbon;                       // للتعامل مع التواريخ والأوقات بسهولة

class AssignmentsPage extends Component
{
    // استخدام الـ Traits الأساسية من Livewire
    use WithPagination;

    // --- خصائص النموذج (تربط حقول الإدخال في الواجهة) ---
    public $title, $description, $course_id, $doctor_id, $deadline;
    public $edit_id = null;      // لتخزين ID التكليف عند التعديل
    public $delete_id = null;    // لتخزين ID التكليف عند الحذف
    public $showForm = false;    // للتحكم في إظهار أو إخفاء نموذج الإضافة/التعديل

    // --- خصائص البحث والفلاتر (تربط حقول الفلترة في الواجهة) ---
    public $search = '';
    public $filter_course_id = '';
    public $filter_doctor_id = '';

    /**
     * دالة rules() تحدد قواعد التحقق من صحة البيانات المدخلة.
     * يتم استدعاؤها تلقائياً قبل عملية الحفظ.
     * تحويلها إلى دالة بدلاً من متغير يسمح باستخدام منطق ديناميكي.
     */
    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id', // يجب أن يكون ID المادة موجوداً في جدول courses
            'doctor_id' => 'required|exists:doctors,id', // يجب أن يكون ID الدكتور موجوداً في جدول doctors
            'deadline' => 'required|date|after_or_equal:now', // يجب أن يكون تاريخاً صالحاً وبعد الآن
        ];
    }

    /**
     * دالة updated() تُستدعى تلقائياً عند تغيير قيمة أي خاصية.
     * نستخدمها هنا للتحقق من صحة الحقل فوراً بعد أن يكتب المستخدم فيه.
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * دالة save() تقوم بحفظ (إنشاء أو تعديل) بيانات التكليف.
     * تم تغليفها بـ try-catch لمعالجة الأخطاء بأمان.
     */
    public function save()
    {
        $this->validate(); // أولاً، يتم التحقق من صحة البيانات باستخدام دالة rules()

        try {
            // استخدام updateOrCreate: إذا كان edit_id موجوداً، سيتم تحديث السجل، وإلا سيتم إنشاء سجل جديد.
            Assignment::updateOrCreate(
                ['id' => $this->edit_id],
                [
                    'title' => $this->title,
                    'description' => $this->description,
                    'course_id' => $this->course_id,
                    'doctor_id' => $this->doctor_id,
                    'deadline' => $this->deadline,
                ]
            );

            $this->closeForm(); // إغلاق النموذج بعد الحفظ
            $message = $this->edit_id ? 'تم تحديث التكليف بنجاح' : 'تم إضافة التكليف بنجاح';
            $this->dispatch('showToast', message: $message, type: 'success'); // إرسال إشعار نجاح للواجهة

        } catch (\Exception $e) {
            // في حال حدوث أي خطأ، يتم تسجيله في ملفات الـ log
            Log::error('Error saving assignment: ' . $e->getMessage());
            // وإرسال رسالة خطأ للمستخدم
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ التكليف.', type: 'error');
        }
    }

    /**
     * دالة edit() تقوم بجلب بيانات تكليف معين وتعبئة حقول النموذج بها.
     */
    public function edit($id)
    {
        try {
            $assignment = Assignment::findOrFail($id); // جلب التكليف أو إظهار خطأ إذا لم يكن موجوداً
            $this->edit_id = $assignment->id;
            $this->title = $assignment->title;
            $this->description = $assignment->description;
            $this->course_id = $assignment->course_id;
            $this->doctor_id = $assignment->doctor_id;
            // استخدام Carbon لتنسيق التاريخ بشكل صحيح ليتوافق مع حقل <input type="datetime-local">
            $this->deadline = Carbon::parse($assignment->deadline)->format('Y-m-d\TH:i');
            $this->showForm = true; // إظهار النموذج
        } catch (\Exception $e) {
            Log::error('Error editing assignment: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على التكليف المطلوب.', type: 'error');
        }
    }

    /**
     * دالة confirmDelete() تقوم فقط بتخزين ID التكليف المراد حذفه لفتح نافذة التأكيد.
     */
    public function confirmDelete($id)
    {
        $this->delete_id = $id;
    }

    /**
     * دالة delete() تقوم بالحذف الفعلي للتكليف.
     */
    public function delete()
    {
        try {
            Assignment::findOrFail($this->delete_id)->delete();
            $this->delete_id = null; // إخفاء نافذة التأكيد
            $this->dispatch('showToast', message: 'تم حذف التكليف بنجاح', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting assignment: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف التكليف.', type: 'error');
        }
    }

    // --- دوال مساعدة للتحكم في واجهة المستخدم ---

    public function resetForm()
    {
        $this->reset(['title', 'description', 'course_id', 'doctor_id', 'deadline', 'edit_id']);
        $this->resetValidation();
    }

    public function openForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    // --- دوال لإعادة تعيين الترقيم عند البحث أو الفلترة ---
    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterCourseId() { $this->resetPage(); }
    public function updatingFilterDoctorId() { $this->resetPage(); }

    // --- [تحسين الأداء] استخدام الخصائص المحسوبة (Computed Properties) ---

    /**
     * دالة courses() تجلب قائمة المواد.
     * #[Computed(cache: true)] يعني أن Livewire سيقوم بتخزين النتيجة مؤقتاً (caching).
     * لن يتم استدعاء قاعدة البيانات مرة أخرى إلا إذا تغيرت البيانات، مما يحسن الأداء بشكل كبير.
     */
    #[Computed(cache: true)]
    public function courses()
    {
        return Course::orderBy('name')->get();
    }

    /**
     * دالة doctors() تجلب قائمة الدكاترة بنفس طريقة التخزين المؤقت.
     */
    #[Computed(cache: true)]
    public function doctors()
    {
        return Doctor::orderBy('name')->get();
    }

    /**
     * دالة render() هي المسؤولة عن عرض الواجهة وتمرير البيانات إليها.
     */
    public function render()
    {
        // بناء استعلام جلب التكليفات
        $assignments = Assignment::with(['course', 'doctor']) // with() لجلب العلاقات بكفاءة (Eager Loading)
            ->when($this->search, function ($query) { // تطبيق البحث فقط إذا كان هناك قيمة في $search
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhereHas('course', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                      ->orWhereHas('doctor', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            })
            ->when($this->filter_course_id, fn($q) => $q->where('course_id', $this->filter_course_id)) // تطبيق فلتر المادة
            ->when($this->filter_doctor_id, fn($q) => $q->where('doctor_id', $this->filter_doctor_id)) // تطبيق فلتر الدكتور
            ->latest() // ترتيب النتائج حسب الأحدث
            ->paginate(10); // تقسيم النتائج إلى صفحات

        // تمرير البيانات إلى ملف الـ view
        return view('livewire.admin.assignments-page', [
            'assignments' => $assignments,
        ]);
    }
}
