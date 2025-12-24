<?php

use Livewire\Volt\Component;

new class extends Component {
    public $currentTheme = 'system';

    public function mount()
    {
        // Get current theme from session or default to system
        $this->currentTheme = session('theme', 'system');
    }

    public function setTheme($theme)
    {
        $this->currentTheme = $theme;
        session(['theme' => $theme]);
        
        // Dispatch event for Flux and Alpine.js
        $this->dispatch('theme-changed', theme: $theme);
        $this->js("
            if (window.\$flux) {
                window.\$flux.appearance = '{$theme}';
            }
            
            if ('{$theme}' === 'dark') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else if ('{$theme}' === 'light') {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                localStorage.setItem('theme', 'system');
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        ");
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading="__('Update the appearance settings for your account')">
        
        {{-- Theme Selection Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Light Theme --}}
            <button 
                wire:click="setTheme('light')"
                class="group relative p-6 rounded-2xl border-2 transition-all duration-300 {{ $currentTheme === 'light' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 shadow-xl shadow-blue-500/20' : 'border-slate-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-700 hover:shadow-lg' }}"
            >
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-4 rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2" style="font-family: 'Questv1', sans-serif;">الوضع الفاتح</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">مظهر مشرق ومريح للعين</p>
                    
                    @if($currentTheme === 'light')
                        <div class="mt-4 inline-flex items-center gap-2 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            مفعّل
                        </div>
                    @endif
                </div>
            </button>

            {{-- Dark Theme --}}
            <button 
                wire:click="setTheme('dark')"
                class="group relative p-6 rounded-2xl border-2 transition-all duration-300 {{ $currentTheme === 'dark' ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20 shadow-xl shadow-indigo-500/20' : 'border-slate-200 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-700 hover:shadow-lg' }}"
            >
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-4 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2" style="font-family: 'Questv1', sans-serif;">الوضع الداكن</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">مظهر داكن يريح العين</p>
                    
                    @if($currentTheme === 'dark')
                        <div class="mt-4 inline-flex items-center gap-2 px-3 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            مفعّل
                        </div>
                    @endif
                </div>
            </button>

            {{-- System Theme --}}
            <button 
                wire:click="setTheme('system')"
                class="group relative p-6 rounded-2xl border-2 transition-all duration-300 {{ $currentTheme === 'system' ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 shadow-xl shadow-emerald-500/20' : 'border-slate-200 dark:border-slate-700 hover:border-emerald-300 dark:hover:border-emerald-700 hover:shadow-lg' }}"
            >
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 mb-4 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2" style="font-family: 'Questv1', sans-serif;">حسب النظام</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">يتبع إعدادات جهازك</p>
                    
                    @if($currentTheme === 'system')
                        <div class="mt-4 inline-flex items-center gap-2 px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-full text-xs font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            مفعّل
                        </div>
                    @endif
                </div>
            </button>
        </div>

        {{-- Info Box --}}
        <div class="p-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-blue-900 dark:text-blue-100 mb-1">معلومة</h4>
                    <p class="text-sm text-blue-700 dark:text-blue-300 leading-relaxed">
                        سيتم حفظ اختيارك تلقائياً وتطبيقه على جميع صفحات النظام. يمكنك تغيير المظهر في أي وقت.
                    </p>
                </div>
            </div>
        </div>

        {{-- Theme Switcher Script --}}
        <script>
            // Apply theme on page load
            document.addEventListener('DOMContentLoaded', () => {
                const savedTheme = '{{ $currentTheme }}';
                const localTheme = localStorage.getItem('theme') || savedTheme;
                
                function applyTheme(theme) {
                    if (theme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else if (theme === 'light') {
                        document.documentElement.classList.remove('dark');
                    } else if (theme === 'system') {
                        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    }
                    
                    // Update Flux if available
                    if (window.$flux) {
                        window.$flux.appearance = theme;
                    }
                }
                
                // Apply theme immediately
                applyTheme(localTheme);
            });

            // Listen for Livewire events
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('theme-changed', (event) => {
                    const theme = event.theme;
                    
                    if (theme === 'dark') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    } else if (theme === 'light') {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    } else if (theme === 'system') {
                        localStorage.setItem('theme', 'system');
                        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    }
                    
                    // Update Flux if available
                    if (window.$flux) {
                        window.$flux.appearance = theme;
                    }
                });
            });
        </script>

    </x-settings.layout>
</section>
