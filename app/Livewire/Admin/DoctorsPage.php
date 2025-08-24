<?php

namespace App\Livewire\Admin;

use App\Models\Doctor;
use App\Models\User; // <-- [إضافة]
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;   // <-- [إضافة]
use Illuminate\Support\Facades\Log;  // <-- [إضافة]
use App\Livewire\Traits\WithSecureFileUploads;
use Illuminate\Validation\Rule; // <-- [إضافة]

class DoctorsPage extends Component
{
    use WithPagination, WithFileUploads, WithSecureFileUploads;

    // --- خصائص النموذج ---
    public $name, $email, $phone, $password;
    public $profile_image, $old_profile_image;
    public $edit_id = null;
    public $delete_id = null;
    public $showForm = false;

    // --- خصائص البحث ---
    public $search = '';

    protected function rules()
    {
        // قواعد التحقق الديناميكية
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->edit_id ? Doctor::find($this->edit_id)?->user_id : null)],
            'phone' => 'nullable|string|max:20',
            'profile_image' => $this->secureFileUploadRules(2048), // 2MB max
        ];

        // كلمة المرور مطلوبة فقط عند إنشاء دكتور جديد
        if (!$this->edit_id) {
            $rules['password'] = 'required|string|min:8';
        } else {
            $rules['password'] = 'nullable|string|min:8'; // اختيارية عند التعديل
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();
        try {
            // [منطق معقد] استخدام معاملة آمنة لضمان إنشاء المستخدم والدكتور معاً
            DB::transaction(function () {
                // الخطوة 1: إنشاء أو تحديث سجل المستخدم (User)
                $userData = [
                    'name' => $this->name,
                    'role' => 'doctor',
                ];
                // تحديث كلمة المرور فقط إذا تم إدخالها
                if ($this->password) {
                    $userData['password'] = Hash::make($this->password);
                }

                $user = User::updateOrCreate(
                    ['email' => $this->email], // البحث بالإيميل
                    $userData
                );

                // الخطوة 2: إنشاء أو تحديث سجل الدكتور (Doctor) وربطه بالمستخدم
                $doctorData = [
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'user_id' => $user->id,
                ];

                if ($this->profile_image) {
                    if ($this->edit_id && $this->old_profile_image) {
                        Storage::disk('public')->delete($this->old_profile_image);
                    }
                    $doctorData['profile_image'] = $this->profile_image->store('profile_images', 'public');
                }

                Doctor::updateOrCreate(
                    ['user_id' => $user->id], // البحث بمعرف المستخدم
                    $doctorData
                );
            }); // نهاية المعاملة

            $this->closeForm();
            $message = $this->edit_id ? 'تم تحديث بيانات الدكتور بنجاح' : 'تم إضافة الدكتور بنجاح';
            $this->dispatch('showToast', message: $message, type: 'success');

        } catch (\Exception $e) {
            Log::error('Error saving doctor: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ بيانات الدكتور.', type: 'error');
        }
    }

    public function edit($id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            $this->edit_id = $doctor->id;
            $this->name = $doctor->name;
            $this->email = $doctor->email;
            $this->phone = $doctor->phone;
            $this->old_profile_image = $doctor->profile_image;
            $this->profile_image = null;
            $this->password = null; // لا نعرض كلمة المرور القديمة
            $this->showForm = true;
        } catch (\Exception $e) {
            Log::error('Error editing doctor: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على الدكتور المطلوب.', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
    }

    public function delete()
    {
        try {
            DB::transaction(function () {
                $doctor = Doctor::findOrFail($this->delete_id);
                // حذف الصورة من التخزين
                if ($doctor->profile_image) {
                    Storage::disk('public')->delete($doctor->profile_image);
                }
                // حذف سجل المستخدم المرتبط (سيقوم بحذف الدكتور تلقائياً بسبب onDelete('cascade'))
                $doctor->user()->delete();
            });

            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف الدكتور وحسابه بنجاح', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting doctor: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف الدكتور.', type: 'error');
        }
    }

    // --- دوال مساعدة ---
    public function resetForm()
    {
        $this->reset(['name', 'email', 'phone', 'profile_image', 'old_profile_image', 'edit_id', 'password']);
        $this->resetValidation();
    }
    public function openForm() { $this->resetForm(); $this->showForm = true; }
    public function closeForm() { $this->showForm = false; $this->resetForm(); }
    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $doctors = Doctor::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.doctors-page', compact('doctors'));
    }
}
