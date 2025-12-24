<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\Batch;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class JoinBatch extends Component
{
    public Batch $batch;
    
    // Form Fields
    public $name;
    public $email;
    public $student_id_number;
    public $password;
    public $password_confirmation;

    public function mount(Batch $batch)
    {
        $this->batch = $batch->load('specialization.department');
    }

    public function register()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'student_id_number' => ['required', 'string', 'max:255', 'unique:students'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            DB::transaction(function () {
                // 1. Create User
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'role' => 'student',
                    'is_active' => true, // تفعيل مباشر لأن التسجيل عبر المندوب موثوق
                ]);

                // 2. Create Student Linked to Batch
                Student::create([
                    'user_id' => $user->id,
                    'name' => $this->name,
                    'student_id_number' => $this->student_id_number,
                    'email' => $this->email,
                    'batch_id' => $this->batch->id,
                    'specialization_id' => $this->batch->specialization_id,
                    // استنتاج السنة والترم من الدفعة
                    'current_academic_year' => $this->batch->current_academic_year ?? 1,
                    'current_semester' => $this->batch->current_semester ?? 1,
                    'status' => 'نشط',
                ]);

                // 3. Login & Redirect
                Auth::login($user);
            });

            return redirect()->route('student.dashboard');

        } catch (\Exception $e) {
            $this->addError('email', 'حدث خطأ أثناء التسجيل، يرجى المحاولة مرة أخرى.');
        }
    }

    public function render()
    {
        return view('livewire.auth.join-batch')->layout('components.layouts.app', ['title' => 'الانضمام للدفعة']);
    }
}
