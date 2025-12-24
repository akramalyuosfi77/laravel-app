<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full" x-data="{ showSuccess: false }" @profile-updated.window="showSuccess = true; setTimeout(() => showSuccess = false, 3000)">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        
        {{-- Animated Success Banner --}}
        <div 
            x-show="showSuccess"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="mb-6 p-5 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border-2 border-emerald-200 dark:border-emerald-800 rounded-2xl shadow-lg"
            style="display: none;"
        >
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center flex-shrink-0 animate-bounce">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-emerald-900 dark:text-emerald-100 text-lg" style="font-family: 'Questv1', sans-serif;">تم التحديث بنجاح!</h4>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300">تم حفظ معلومات الملف الشخصي بنجاح.</p>
                </div>
            </div>
        </div>

        {{-- Profile Animation Card --}}
        <div class="mb-8 p-6 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-purple-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-3xl shadow-xl relative overflow-hidden">
            {{-- Animated Background Pattern --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-40 h-40 bg-blue-400 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-purple-400 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>
            
            <div class="relative grid md:grid-cols-2 gap-6 items-center">
                {{-- Lottie Animation --}}
                <div class="flex justify-center order-2 md:order-1">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                        <lottie-player
                            src="/animations/Welcome.json"
                            background="transparent"
                            speed="1"
                            style="width: 100%; max-width: 250px; height: auto;"
                            loop
                            autoplay>
                        </lottie-player>
                    </div>
                </div>

                {{-- User Info --}}
                <div class="order-1 md:order-2 text-center md:text-right">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-full text-white text-3xl font-bold shadow-2xl mb-4 ring-4 ring-blue-200 dark:ring-blue-800" style="font-family: 'Questv1', sans-serif;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <h3 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-1" style="font-family: 'Questv1', sans-serif;">
                        {{ auth()->user()->name }}
                    </h3>
                    <p class="text-blue-700 dark:text-blue-300 font-medium mb-3">{{ auth()->user()->email }}</p>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-sm font-bold text-blue-700 dark:text-blue-300">
                            {{ __(ucfirst(auth()->user()->role)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <form wire:submit="updateProfileInformation" class="space-y-6">
            {{-- Name Field --}}
            <div class="group">
                <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3 flex items-center gap-2">
                    <div class="w-6 h-6 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    الاسم الكامل
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input
                        wire:model="name"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                        class="w-full pl-12 pr-4 py-4 border-2 border-zinc-300 dark:border-zinc-600 rounded-2xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-zinc-400 shadow-sm hover:shadow-md"
                        placeholder="أدخل الاسم الكامل"
                    >
                </div>
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-2 animate-pulse">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email Field --}}
            <div class="group">
                <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3 flex items-center gap-2">
                    <div class="w-6 h-6 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    البريد الإلكتروني
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                    <input
                        wire:model="email"
                        type="email"
                        required
                        autocomplete="email"
                        class="w-full pl-12 pr-4 py-4 border-2 border-zinc-300 dark:border-zinc-600 rounded-2xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all placeholder:text-zinc-400 shadow-sm hover:shadow-md"
                        placeholder="example@domain.com"
                    >
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-2 animate-pulse">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror

                {{-- Email Verification Notice --}}
                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div class="mt-4 p-4 bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-200 dark:border-amber-800 rounded-2xl">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-amber-800 dark:text-amber-200 mb-2">
                                    {{ __('بريدك الإلكتروني غير موثق.') }}
                                </p>
                                <button
                                    type="button"
                                    wire:click.prevent="resendVerificationNotification"
                                    class="text-sm font-bold text-amber-700 dark:text-amber-300 hover:text-amber-900 dark:hover:text-amber-100 underline transition-colors"
                                >
                                    {{ __('اضغط هنا لإعادة إرسال رابط التوثيق.') }}
                                </button>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-3 text-sm font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ __('تم إرسال رابط توثيق جديد إلى بريدك الإلكتروني.') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Submit Button --}}
            <div class="flex items-center justify-end pt-4">
                <button
                    type="submit"
                    class="group relative px-10 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 text-white rounded-2xl font-bold transition-all hover:scale-105 shadow-2xl shadow-blue-500/30 hover:shadow-indigo-500/50 flex items-center gap-3 overflow-hidden"
                >
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    
                    <span wire:loading.remove wire:target="updateProfileInformation" class="relative flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        حفظ التغييرات
                    </span>
                    <span wire:loading wire:target="updateProfileInformation" class="relative flex items-center gap-2">
                        <svg class="animate-spin h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        جاري الحفظ...
                    </span>
                </button>
            </div>
        </form>

        {{-- Delete Account Section --}}
        <div class="mt-12 pt-8 border-t-2 border-zinc-200 dark:border-zinc-700">
            <livewire:settings.delete-user-form />
        </div>

        {{-- Lottie Player Script --}}
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    </x-settings.layout>
</section>
