<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Student;
use App\Models\Doctor;
use App\Models\Batch;
use App\Models\Specialization;
use App\Models\Course;
use App\Models\SpecializationCourseAcademicPeriod; // استيراد الموديل الجديد
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // لاستخدام المعاملات

class UsersManagement extends Component
{
    use WithPagination;

    public $user_id;
    public $name, $email, $password, $password_confirmation, $role, $is_active;

    // خصائص خاصة بالطلاب
    public $student_id_number, $batch_id, $specialization_id;

    // خصائص خاصة بالدكاترة
    // الآن selected_courses ستخزن IDs من جدول specialization_course_academic_period
    public $selected_specialization_course_academic_periods = [];

    public $showForm = false;
    public $delete_id = null;
    public $showViewModal = false;
    public $viewedUser = null;

    // خصائص للبحث والتصفية
    public $search = '';
    public $filter_role = '';
    public $filter_is_active = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user_id)],
            'role' => ['required', Rule::in(['admin', 'doctor', 'student'])],
            'password' => $this->user_id ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'is_active' => 'boolean',

            // قواعد خاصة بالطلاب
            'student_id_number' => Rule::when($this->role === 'student', ['required', 'string', 'max:255', Rule::unique('students')->ignore($this->user_id ? Student::where('user_id', $this->user_id)->first()->id : null)]),
            'batch_id' => Rule::when($this->role === 'student', 'required|exists:batches,id'),
            'specialization_id' => Rule::when($this->role === 'student', 'required|exists:specializations,id'),

            // قواعد خاصة بالدكاترة
            // selected_specialization_course_academic_periods ستكون مصفوفة من IDs من الجدول الوسيط
            'selected_specialization_course_academic_periods' => Rule::when($this->role === 'doctor', 'array'),
            'selected_specialization_course_academic_periods.*' => Rule::when($this->role === 'doctor', 'exists:specialization_course_academic_period,id'),
        ];
    }

    public function mount()
    {
        $this->is_active = true; // القيمة الافتراضية عند إضافة مستخدم جديد
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        // إعادة تعيين حقول الطالب/الدكتور عند تغيير الدور
        if ($propertyName === 'role') {
            $this->reset(['student_id_number', 'batch_id', 'specialization_id', 'selected_specialization_course_academic_periods']);
        }
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () { // استخدام المعاملات لضمان سلامة البيانات
            // إنشاء/تحديث المستخدم
            $userData = [
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
                'is_active' => $this->is_active == '1' ? true : false,
            ];

            if ($this->password) {
                $userData['password'] = Hash::make($this->password);
            }

            $user = User::updateOrCreate(['id' => $this->user_id], $userData);

            // معالجة بيانات الطالب/الدكتور
            if ($this->role === 'student') {
                Student::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'name' => $this->name,
                        'student_id_number' => $this->student_id_number,
                        'batch_id' => $this->batch_id, // 💡 تأكد من وجود هذا
                        'specialization_id' => $this->specialization_id, // 💡 وتأكد من وجود هذا
                        'user_id' => $user->id,
                    ]
                );

                // التأكد من حذف أي سجل دكتور سابق إذا تم تغيير الدور
                Doctor::where('user_id', $user->id)->delete();
            } elseif ($this->role === 'doctor') {
                $doctor = Doctor::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'name' => $this->name,
                        'email' => $this->email, // تأكد من إضافة هذا الحقل
                        'user_id' => $user->id,
                    ]
                );

                // تحديث عمود doctor_id في جدول specialization_course_academic_period
                // أولاً، قم بإزالة الدكتور من أي سجلات لم تعد مختارة
                SpecializationCourseAcademicPeriod::where('doctor_id', $doctor->id)
                    ->whereNotIn('id', $this->selected_specialization_course_academic_periods)
                    ->update(['doctor_id' => null]);

                // ثم قم بتعيين الدكتور للسجلات المختارة
                SpecializationCourseAcademicPeriod::whereIn('id', $this->selected_specialization_course_academic_periods)
                    ->update(['doctor_id' => $doctor->id]);

                // التأكد من حذف أي سجل طالب سابق إذا تم تغيير الدور
                Student::where('user_id', $user->id)->delete();
            } else { // Admin
                // التأكد من حذف أي سجل طالب أو دكتور سابق إذا تم تغيير الدور إلى مدير
                Student::where('user_id', $user->id)->delete();
                Doctor::where('user_id', $user->id)->delete();
            }
        }); // نهاية المعاملة


        $this->resetForm();
        $this->showForm = false;
        $message = $this->user_id ? 'تم تحديث المستخدم بنجاح' : 'تم إضافة المستخدم بنجاح';
        $this->dispatch('showToast', message: $message, type: 'success');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->is_active = $user->is_active;
        $this->password = ''; // لا نعرض كلمة المرور
        $this->password_confirmation = '';

        // تعبئة بيانات الطالب/الدكتور
        if ($user->role === 'student' && $user->student) {
            $this->student_id_number = $user->student->student_id_number;
            $this->batch_id = $user->student->batch_id;
            $this->specialization_id = $user->student->specialization_id;
        } elseif ($user->role === 'doctor' && $user->doctor) {
            // تعبئة selected_specialization_course_academic_periods
            $this->selected_specialization_course_academic_periods = SpecializationCourseAcademicPeriod::where('doctor_id', $user->doctor->id)
                                                                                                        ->pluck('id')
                                                                                                        ->toArray();
        }

        $this->showForm = true;
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
    }

    public function deleteUser()
    {
         $user = User::findOrFail($this->delete_id);

        // 💡 التحقق من وجود السجل المرتبط قبل الحذف
        if ($user->role === 'doctor' && $user->doctor) {
            $user->doctor->delete();
        } elseif ($user->role === 'student' && $user->student) {
            $user->student->delete();
        }

        // الآن، احذف المستخدم نفسه
        $user->delete();

        $this->delete_id = null;
        $this->dispatch('showToast', message: 'تم حذف المستخدم بنجاح', type: 'success');
    }

    public function toggleActiveStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        $message = $user->is_active ? 'تم تفعيل المستخدم بنجاح.' : 'تم تعطيل المستخدم بنجاح.';
        $this->dispatch('showToast', message: $message, type: 'success');
    }

    public function resetForm()
    {
        $this->reset([
            'user_id', 'name', 'email', 'password', 'password_confirmation', 'role', 'is_active',
            'student_id_number', 'batch_id', 'specialization_id', 'selected_specialization_course_academic_periods',
        ]);
        $this->is_active = true; // إعادة تعيين القيمة الافتراضية
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getFormSpecializationsProperty()
    {
        // يمكنك تخصيص الفلترة حسب الحاجة، هنا جميع التخصصات
        return Specialization::all();
    }

public function getFormBatchesProperty()
{
    if ($this->specialization_id) {
        return Batch::where('specialization_id', $this->specialization_id)->get();
    }
    return Batch::all();
}

    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    public function updatingFilterIsActive()
    {
        $this->resetPage();
    }

    public function updatedSpecializationId($value)
    {
        $this->batch_id = null;
    }

    public function render()
    {
        $users = User::with(['student', 'doctor.specializationCourseAcademicPeriods']) // تحميل العلاقة الجديدة
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->filter_role, function ($query) {
                $query->where('role', $this->filter_role);
            })
            ->when($this->filter_is_active !== '', function ($query) {
                $query->where('is_active', $this->filter_is_active);
            })
            ->latest()
            ->paginate(10);

        $batches = Batch::all();
        $specializations = Specialization::all();
        // جلب جميع سجلات specialization_course_academic_period لعرضها في قائمة الاختيار
        $availableCoursePeriods = SpecializationCourseAcademicPeriod::with(['course', 'specialization'])
                                                                    ->get();

        return view('livewire.admin.users-management', compact('users', 'batches', 'specializations', 'availableCoursePeriods'));
    }
}
