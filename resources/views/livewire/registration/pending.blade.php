<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    // No additional logic needed for pending view
}; ?>

{{-- Centered Card Design for Registration Pending --}}
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-zinc-900 dark:via-slate-900 dark:to-zinc-900" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
    <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-xl p-8 md:p-12 max-w-lg w-full mx-4 text-center backdrop-blur-sm bg-opacity-80">
        {{-- Animation (visible on all screens) --}}
        <div class="relative w-full max-w-md mx-auto mb-6" x-show="loaded" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
            <lottie-player
                src="{{ asset('animations/data analysis.json') }}"
                background="transparent"
                speed="1"
                style="width: 100%; height: auto;"
                loop
                autoplay>
            </lottie-player>
        </div>

        <h2 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-blue-700 to-indigo-700 dark:from-slate-100 dark:via-blue-300 dark:to-indigo-300 mb-4">
            الحساب قيد المراجعة
        </h2>
        <p class="text-lg text-slate-600 dark:text-slate-300 mb-6">
            تم إنشاء حسابك بنجاح وهو الآن قيد المراجعة من قبل الإدارة. سيتم إعلامك بمجرد تفعيل حسابك.
        </p>
        <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg" wire:navigate>
            العودة إلى صفحة تسجيل الدخول
        </a>
    </div>
</div>

@push('scripts')
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endpush
