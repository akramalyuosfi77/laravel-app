<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        // 💡 الخطوة 1: محاولة المصادقة بالبريد وكلمة المرور فقط
        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // 💡 الخطوة 2: إذا نجحت المصادقة، تحقق من حالة is_active والدور
        $user = Auth::user();

        if ($user->role === 'student' && !$user->is_active) {
            // إذا كان طالبًا وحسابه غير مفعل
            Auth::logout(); // تسجيل الخروج من الحساب
            Session::invalidate();
            Session::regenerateToken();

            RateLimiter::clear($this->throttleKey()); // مسح محاولات تسجيل الدخول الفاشلة

            // توجيه إلى صفحة الحساب قيد المراجعة
            $this->redirect(route('registration.pending'), navigate: true);
            return; // توقف التنفيذ هنا
        }

        // 💡 الخطوة 3: إذا كان الحساب مفعلًا أو ليس طالبًا، أكمل عملية تسجيل الدخول
        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        // 🔀 توجيه حسب الدور
        $role = $user->role; // استخدم $user بدلاً من Auth::user() مباشرة

        $redirectRoute = match ($role) {
            'admin' => route('admin.dashboard', absolute: false),
            'doctor' => route('doctor.dashboard', absolute: false),
            'student' => route('student.dashboard', absolute: false),
            default => route('welcome', absolute: false), // احتياطي
        };

        $this->redirectIntended(default: $redirectRoute, navigate: true);
    }


    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">

    {{-- 💡 إضافة لعرض رسائل الخطأ من الجلسة --}}
    @if (session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('عنوان الايميل')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@gmail.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('كلمة السر')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('كلمة السر')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('نسيت كلمة السر ?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('تذكرني')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('دخول') }}</flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>
