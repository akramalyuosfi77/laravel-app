<?php
namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilePage extends Component
{
    use WithFileUploads;

    public $phone;
    public $date_of_birth;
    public $address;
    public $student;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $profile_image;

    public function mount()
    {
        $this->student = Auth::user()->student;
        $this->phone = $this->student->phone;
        $this->date_of_birth = $this->student->date_of_birth;
        $this->address = $this->student->address;
    }

    public function getProfileImageValidationRule()
    {
        return ['nullable', 'image', 'max:2048'];
    }

    public function rules()
    {
        return [
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:255'],
            'profile_image' => $this->getProfileImageValidationRule(),
        ];
    }

    public function updateProfile()
    {
        $this->validate();
        try {
            \DB::transaction(function () {
                $user = auth()->user();
                $student = $user->student;
                $studentData = [
                    'phone' => $this->phone,
                    'date_of_birth' => $this->date_of_birth,
                    'address' => $this->address,
                ];
                if ($this->profile_image) {
                    if ($student->profile_image) {
                        \Storage::disk('public')->delete($student->profile_image);
                    }
                    $studentData['profile_image'] = $this->profile_image->store('profile_images', 'public');
                }
                $student->update($studentData);
            });
            session()->flash('success', 'تم تحديث البيانات بنجاح');
            $this->reset(['profile_image']);
        } catch (\Exception $e) {
            \Log::error('Error updating student profile: ' . $e->getMessage());
            session()->flash('error', 'حدث خطأ أثناء تحديث البيانات.');
        }
    }

    public function changePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
        $user = Auth::user();
        if (!Hash::check($this->current_password, $user->password)) {
            session()->flash('error', 'كلمة المرور الحالية غير صحيحة');
            return;
        }
        $user->password = Hash::make($this->new_password);
        $user->save();
        $this->current_password = $this->new_password = $this->new_password_confirmation = '';
        session()->flash('success', 'تم تغيير كلمة المرور بنجاح');
    }

    public function render()
    {
        return view('livewire.student.profile-page', [
            'student' => $this->student,
        ]);
    }
}
