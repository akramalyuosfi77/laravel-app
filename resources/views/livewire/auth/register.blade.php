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
{{-- Premium Split-Screen Register Design --}}
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
                    انضم إلينا الآن
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-300 max-w-md">
                    ابدأ رحلتك التعليمية معنا وكن جزءاً من مجتمعنا الأكاديمي
                </p>
            </div>
        </div>
    </div>

    {{-- Right Side: Register Form --}}
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
            <div class="mb-6">
                <h1 class="text-3xl font-black text-zinc-900 dark:text-white mb-2">إنشاء حساب جديد</h1>
                <p class="text-slate-600 dark:text-slate-400">أدخل بياناتك لإنشاء حسابك الطلابي</p>
            </div>

            {{-- Register Form --}}
            <form wire:submit="register" class="space-y-4">
                {{-- Name Input --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                        الاسم الكامل
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input
                            id="name"
                            wire:model="name"
                            type="text"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="أحمد محمد"
                            class="w-full pr-11 pl-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        >
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

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
                            autocomplete="email"
                            placeholder="email@example.com"
                            class="w-full pr-11 pl-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        >
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Student ID Input --}}
                <div>
                    <label for="student_id_number" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                        الرقم الجامعي
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                        </div>
                        <input
                            id="student_id_number"
                            wire:model="student_id_number"
                            type="text"
                            required
                            placeholder="123456789"
                            class="w-full pr-11 pl-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        >
                    </div>
                    @error('student_id_number')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Input --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                        كلمة السر
                    </label>
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
                            autocomplete="new-password"
                            placeholder="••••••••"
                            class="w-full pr-11 pl-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        >
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password Input --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">
                        تأكيد كلمة السر
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <input
                            id="password_confirmation"
                            wire:model="password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                            class="w-full pr-11 pl-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        >
                    </div>
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transition-all hover:scale-[1.02] shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2 mt-6"
                >
                    <span wire:loading.remove wire:target="register">إنشاء الحساب</span>
                    <span wire:loading wire:target="register" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        جاري إنشاء الحساب...
                    </span>
                </button>
            </form>

            {{-- Login Link --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    لديك حساب بالفعل؟
                    <a href="{{ route('login') }}" wire:navigate class="font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                        تسجيل الدخول
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endpush

