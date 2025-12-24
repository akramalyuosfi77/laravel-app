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

{{-- Premium Split-Screen Login Design --}}
<div class="min-h-screen flex" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
    {{-- Left Side: Animation & Branding --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-zinc-900 dark:via-slate-900 dark:to-zinc-900">
        {{-- Animated Background Orbs --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 right-20 w-96 h-96 bg-blue-400/20 dark:bg-blue-600/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 left-20 w-[500px] h-[500px] bg-indigo-400/20 dark:bg-indigo-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 flex flex-col items-center justify-center w-full p-12">
            {{-- Logo/Brand --}}
            <div class="mb-8 text-center">
                <div class="inline-flex items-center gap-3 px-6 py-3 bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xl mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-blue-700 to-indigo-700 dark:from-slate-100 dark:via-blue-300 dark:to-indigo-300">نظام إدارة متقدم</span>
                </div>
            </div>

            {{-- Animation --}}
            <div class="relative w-full max-w-lg" x-show="loaded" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
                <lottie-player
                    src="{{ asset('animations/Welcome.json') }}"
                    background="transparent"
                    speed="1"
                    style="width: 100%; height: auto;"
                    loop
                    autoplay>
                </lottie-player>
            </div>

            {{-- Welcome Text --}}
            <div class="mt-8 text-center">
                <h2 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-blue-700 to-indigo-700 dark:from-slate-100 dark:via-blue-300 dark:to-indigo-300 mb-3">
                    مرحباً بك مجدداً
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-md">
                    منصة شاملة لإدارة العملية التعليمية بكفاءة واحترافية
                </p>
            </div>
        </div>
    </div>

    {{-- Right Side: Login Form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white dark:bg-zinc-900">
        <div class="w-full max-w-md">
            {{-- Mobile Logo --}}
            <div class="lg:hidden mb-6 text-center">
                <div class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-zinc-800 dark:via-slate-800 dark:to-zinc-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-lg mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-blue-700 to-indigo-700 dark:from-slate-100 dark:via-blue-300 dark:to-indigo-300">نظام إدارة متقدم</span>
                </div>
            </div>

            {{-- Mobile Animation --}}
            <div class="lg:hidden mb-6" x-show="loaded" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                <div class="relative w-full max-w-xs mx-auto">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                    <lottie-player
                        src="{{ asset('animations/Welcome.json') }}"
                        background="transparent"
                        speed="1"
                        style="width: 100%; height: auto;"
                        loop
                        autoplay>
                    </lottie-player>
                </div>
            </div>

            {{-- Form Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-black text-zinc-900 dark:text-white mb-2">تسجيل الدخول</h1>
                <p class="text-slate-600 dark:text-slate-400">أدخل بياناتك للوصول إلى حسابك</p>
            </div>

            {{-- Error Messages --}}
            @if (session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800" role="alert">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium text-red-800 dark:text-red-400">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Session Status --}}
            <x-auth-session-status class="mb-6" :status="session('status')" />

            {{-- Login Form --}}
            <form wire:submit="login" class="space-y-5">
                {{-- Email Input --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                        البريد الإلكتروني
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input
                            id="email"
                            wire:model="email"
                            type="email"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="email@example.com"
                            class="w-full pr-11 pl-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        >
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Input --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                            كلمة السر
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" wire:navigate class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                نسيت كلمة السر؟
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input
                            id="password"
                            wire:model="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full pr-11 pl-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        >
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center">
                    <input
                        id="remember"
                        wire:model="remember"
                        type="checkbox"
                        class="w-4 h-4 text-blue-600 bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600 rounded focus:ring-2 focus:ring-blue-500 transition-all"
                    >
                    <label for="remember" class="mr-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        تذكرني
                    </label>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transition-all hover:scale-[1.02] shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2"
                >
                    <span wire:loading.remove wire:target="login">تسجيل الدخول</span>
                    <span wire:loading wire:target="login" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        جاري تسجيل الدخول...
                    </span>
                </button>
            </form>

            {{-- Register Link --}}
            @if (Route::has('register'))
                <div class="mt-8 text-center">
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        ليس لديك حساب؟
                        <a href="{{ route('register') }}" wire:navigate class="font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                            إنشاء حساب جديد
                        </a>
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endpush
