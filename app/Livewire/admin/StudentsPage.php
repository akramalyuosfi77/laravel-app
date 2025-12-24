<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use App\Models\Batch;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Livewire\Traits\WithSecureFileUploads;
use Illuminate\Support\Facades\DB;   // <-- [إضافة]
use Illuminate\Support\Facades\Log;  // <-- [إضافة]
use Livewire\Attributes\Computed; // <-- [إضافة]

class StudentsPage extends Component
{
    use WithPagination, WithFileUploads, WithSecureFileUploads;

    // --- خصائص النموذج ---
    public $name, $student_id_number, $email, $phone, $gender, $date_of_birth, $address, $batch_id, $status;
    public $profile_image, $old_profile_image;
    public $password, $password_confirmation;
    public $edit_id = null;
    public $delete_id = null;
    public $showForm = false;

    // --- خصائص الواجهة المتسلسلة ---
    public $selected_department_id_for_form = '';
    public $selected_specialization_id_for_form = '';

    // --- خصائص البحث والفلاتر ---
    public $search = '';
    public $filter_batch_id = '';
    public $filter_academic_year = '';
    public $filter_semester = '';
    public $filter_status = '';

    // --- خصائص مساعدة ---
    public $inferred_academic_year;
    public $inferred_semester;

    protected function rules()
    {
        // [منطق معقد] قواعد تحقق ديناميكية تتغير بناءً على حالة الإضافة أو التعديل
        return [
            'name' => 'required|string|max:255',
            'student_id_number' => ['required', 'string', 'max:255', Rule::unique('students')->ignore($this->edit_id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->edit_id ? Student::find($this->edit_id)?->user_id : null)],
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|in:ذكر,أنثى',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'profile_image' => $this->secureFileUploadRules(2048),
            'batch_id' => 'required|exists:batches,id',
            'status' => 'required|string|in:نشط,متخرج,موقوف,منسحب',
            'password' => $this->edit_id ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
        ];
    }

    public function save()
    {
        $this->validate();
        try {
            // [منطق مهم] استخدام معاملة آمنة لضمان إنشاء المستخدم والطالب معاً
            DB::transaction(function () {
                $userData = ['name' => $this->name, 'email' => $this->email, 'role' => 'student'];
                if ($this->password) {
                    $userData['password'] = Hash::make($this->password);
                }

                $studentData = [
                    'name' => $this->name,
                    'student_id_number' => $this->student_id_number,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'gender' => $this->gender,
                    'date_of_birth' => $this->date_of_birth,
                    'address' => $this->address,
                    'batch_id' => $this->batch_id,
                    'current_academic_year' => $this->inferred_academic_year,
                    'current_semester' => $this->inferred_semester,
                    'status' => $this->status,
                ];

                if ($this->profile_image) {
                    if ($this->edit_id && $this->old_profile_image) {
                        Storage::disk('public')->delete($this->old_profile_image);
                    }
                    $studentData['profile_image'] = $this->profile_image->store('profile_images', 'public');
                }

                $user = User::updateOrCreate(['email' => $this->email], $userData);
                Student::updateOrCreate(['user_id' => $user->id], $studentData);
            });

            $this->closeForm();
            $message = $this->edit_id ? 'تم تحديث بيانات الطالب بنجاح' : 'تم إضافة الطالب بنجاح';
            $this->dispatch('showToast', message: $message, type: 'success');

        } catch (\Exception $e) {
            Log::error('Error saving student: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ بيانات الطالب.', type: 'error');
        }
    }

    public function edit($id)
    {
        try {
            $student = Student::with('batch.specialization')->findOrFail($id);
            $this->edit_id = $student->id;
            $this->name = $student->name;
            $this->student_id_number = $student->student_id_number;
            $this->email = $student->email;
            $this->phone = $student->phone;
            $this->gender = $student->gender;
            $this->date_of_birth = $student->date_of_birth;
            $this->address = $student->address;
            $this->batch_id = $student->batch_id;
            $this->status = $student->status;
            $this->old_profile_image = $student->profile_image;
            $this->profile_image = null;
            $this->reset(['password', 'password_confirmation']);

            if ($student->batch) {
                $this->selected_department_id_for_form = $student->batch->specialization->department_id ?? null;
                $this->selected_specialization_id_for_form = $student->batch->specialization_id;
                $this->inferred_academic_year = $student->batch->academic_year;
                $this->inferred_semester = $student->batch->semester;
            }
            $this->showForm = true;
        } catch (\Exception $e) {
            Log::error('Error editing student: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على الطالب المطلوب.', type: 'error');
        }
    }

    public function confirmDelete($id) { $this->delete_id = $id; }

    public function delete()
    {
        try {
            DB::transaction(function () {
                $student = Student::findOrFail($this->delete_id);
                if ($student->profile_image) {
                    Storage::disk('public')->delete($student->profile_image);
                }
                // حذف المستخدم المرتبط سيؤدي إلى حذف الطالب تلقائياً
                $student->user()->delete();
            });
            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف الطالب وحسابه بنجاح', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting student: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف الطالب.', type: 'error');
        }
    }

    public function toggleRepresentative($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->is_representative = !$student->is_representative;
            $student->save();
            
            $status = $student->is_representative ? 'تم تعيين الطالب كمندوب' : 'تم إلغاء تعيين الطالب كمندوب';
            $this->dispatch('showToast', message: $status, type: 'success');
        } catch (\Exception $e) {
            Log::error('Error toggling representative: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء تغيير حالة المندوب.', type: 'error');
        }
    }

    // --- دوال مساعدة ---
    public function resetForm() { $this->reset(); $this->resetValidation(); }
    public function openForm() { $this->resetForm(); $this->showForm = true; }
    public function closeForm() { $this->showForm = false; $this->resetForm(); }
    public function updatedSelectedDepartmentIdForForm() { $this->reset(['selected_specialization_id_for_form', 'batch_id', 'inferred_academic_year', 'inferred_semester']); }
    public function updatedSelectedSpecializationIdForForm() { $this->reset(['batch_id', 'inferred_academic_year', 'inferred_semester']); }
    public function updatedBatchId($value) {
        $batch = Batch::find($value);
        $this->inferred_academic_year = $batch?->academic_year;
        $this->inferred_semester = $batch?->semester;
    }
    public function updating($property) { if (str_starts_with($property, 'filter_')) $this->resetPage(); }

    // --- [تحسين الأداء] الخصائص المحسوبة ---
    #[Computed(cache: true)]
    public function departments() { return Department::orderBy('name')->get(); }

    #[Computed(cache: true)]
    public function batches() { return Batch::orderBy('name')->get(); }

    #[Computed]
    public function formSpecializations() {
        if (!$this->selected_department_id_for_form) return collect();
        return Specialization::where('department_id', $this->selected_department_id_for_form)->orderBy('name')->get();
    }

    #[Computed]
    public function formBatches() {
        if (!$this->selected_specialization_id_for_form) return collect();
        return Batch::where('specialization_id', $this->selected_specialization_id_for_form)->orderBy('name')->get();
    }

    public function render()
    {
        $students = Student::with(['batch.specialization.department'])
            ->when($this->search, function ($query) {
                // [إصلاح] تم تصحيح الخطأ المطبعي هنا
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('student_id_number', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhereHas('batch.specialization.department', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            })
            ->when($this->filter_batch_id, fn($q) => $q->where('batch_id', $this->filter_batch_id))
            ->when($this->filter_academic_year, fn($q) => $q->where('current_academic_year', $this->filter_academic_year))
            ->when($this->filter_semester, fn($q) => $q->where('current_semester', $this->filter_semester))
            ->when($this->filter_status, fn($q) => $q->where('status', $this->filter_status))
            ->latest('created_at')
            ->paginate(10);

        return view('livewire.admin.students-page', [
            'students' => $students,
            'academicYearsOptions' => range(1, 6),
            'semestersOptions' => [1, 2],
            'statuses' => ['نشط', 'متخرج', 'موقوف', 'منسحب'],
        ]);
    }
}
