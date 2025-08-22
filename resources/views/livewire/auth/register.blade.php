<?php

use App\Models\User;
use App\Models\Student;
// 💡 1. استيراد فئة الإشعارات وفئة الإرسال
use App\Notifications\NewStudentRegistered;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// 💡 1. استيراد فئة الإشعارات وفئة الإرسال
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|email|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|min:8|confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    #[Validate('required|string|max:255|unique:students,student_id_number')]
    public string $student_id_number = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'student',
            'is_active' => false,
        ]);

        // 💡 2. قمنا بتخزين الطالب الذي تم إنشاؤه في متغير
        $student = Student::create([
            'user_id' => $user->id,
            'name' => $this->name,
            'student_id_number' => $this->student_id_number,
        ]);

        event(new Registered($user));

        // --- 💡 3. الكود الجديد والمهم لإرسال الإشعار ---
        try {
            // أولاً: نبحث عن كل المستخدمين الذين لديهم دور 'admin'
            $admins = User::where('role', 'admin')->get();

            // ثانياً: نرسل لهم جميعاً إشعارنا الجديد، ونمرر له بيانات الطالب
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new NewStudentRegistered($student));
            }
        } catch (\Exception $e) {
            // في حال حدوث أي خطأ أثناء إرسال الإشعار (مثل مشكلة في الاتصال)،
            // نتجاهله حتى لا نمنع الطالب من إكمال عملية التسجيل.
            // يمكن تسجيل الخطأ للمراجعة لاحقًا.
            \Log::error('Failed to send new student registration notification: ' . $e->getMessage());
        }
        // --- نهاية الكود الجديد ---

        $this->redirect(route('registration.pending'), navigate: true);
    }
}; ?>


<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create your account')" :description="__('Enter your details below to create your account')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            placeholder="John Doe"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Student ID Number -->
        <flux:input
            wire:model="student_id_number"
            :label="__('Student ID Number')"
            type="text"
            required
            placeholder="e.g., 123456789"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="********"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm Password')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="********"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Register') }}</flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
