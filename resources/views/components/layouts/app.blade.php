{{--
    الملف: resources/views/layouts/app.blade.php


--}}
@php
    // Ensure theme is set on initial page load
    $theme = session('theme', 'dark');
@endphp

@php
    // Retrieve user role for navigation, handling guests safely
    $role = auth()->check() ? auth()->user()->role : null;
@endphp

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="rtl"
    x-data="{
        theme: localStorage.getItem('theme') || 'dark',
        isSidebarOpen: window.innerWidth >= 1024,
        toggleTheme() {
            this.theme = this.theme === 'light' ? 'dark' : 'light';
            localStorage.setItem('theme', this.theme);
            document.documentElement.className = this.theme;
        },
        toggleSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen;
        }
    }"
    x-init="document.documentElement.className = theme"
    :class="theme"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'المنصة التعليمية' }}</title>

    {{-- Vite يقوم بتضمين ملفات CSS و JS بكفاءة عالية --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>[x-cloak] { display: none !important; }</style>

    @stack('styles')
    @livewireStyles
</head>

<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 transition-colors duration-300">

    {{-- @persist يحافظ على هذا الجزء من الصفحة عند التنقل، مما يعطي سرعة فائقة --}}
    @persist('sidebar')
        <div x-show="isSidebarOpen && window.innerWidth < 1024" @click="isSidebarOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden" x-cloak></div>

        <aside
            id="sidebar"
            class="fixed right-0 top-0 h-full w-80 bg-white dark:bg-zinc-800 shadow-2xl z-50 transform transition-transform duration-300 border-l border-zinc-200 dark:border-zinc-700 flex flex-col"
            :class="{ 'translate-x-0': isSidebarOpen, 'translate-x-full': !isSidebarOpen }"
            x-on:resize.window="if (window.innerWidth >= 1024) isSidebarOpen = true"
        >
            <!-- Header -->
            <header class="flex items-center justify-between p-6 border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-3" wire:navigate>
                    <div class="w-10 h-10 bg-accent rounded-xl flex items-center justify-center shadow-lg"><x-app-logo class="w-6 h-6 text-accent-foreground" /></div>
                    <div>
                        <h1 class="text-lg font-bold text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">المنصة التعليمية</h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">نظام إدارة متقدم</p>
                    </div>
                </a>
                <button @click="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                    <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </header>

            {{-- Theme Selector Row --}}
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900/50">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-zinc-500 dark:text-zinc-400 ml-2">المظهر:</span>
                    
                    {{-- Light Mode Button --}}
                    <button 
                        @click="theme = 'light'; localStorage.setItem('theme', 'light'); document.documentElement.className = 'light';"
                        :class="theme === 'light' ? 'bg-gradient-to-br from-amber-500 to-orange-500 text-white shadow-lg scale-110 ring-2 ring-amber-300' : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-600'"
                        class="group relative p-2.5 rounded-xl transition-all duration-300 hover:scale-105"
                        title="الوضع الفاتح"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    {{-- Dark Mode Button --}}
                    <button 
                        @click="theme = 'dark'; localStorage.setItem('theme', 'dark'); document.documentElement.className = 'dark';"
                        :class="theme === 'dark' ? 'bg-gradient-to-br from-indigo-600 to-purple-600 text-white shadow-lg scale-110 ring-2 ring-indigo-300' : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-600'"
                        class="group relative p-2.5 rounded-xl transition-all duration-300 hover:scale-105"
                        title="الوضع الداكن"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    {{-- System Mode Button --}}
                    <button 
                        @click="theme = 'system'; localStorage.setItem('theme', 'system'); if (window.matchMedia('(prefers-color-scheme: dark)').matches) { document.documentElement.className = 'dark'; } else { document.documentElement.className = 'light'; }"
                        :class="theme === 'system' ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg scale-110 ring-2 ring-emerald-300' : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-600'"
                        class="group relative p-2.5 rounded-xl transition-all duration-300 hover:scale-105"
                        title="حسب النظام"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Notifications Section -->
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                {{-- 🔥 التحسين الأهم: إضافة `lazy` لتحميل المكون بعد الصفحة الرئيسية --}}
                <livewire:user-notifications lazy />
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-4">
                <div class="space-y-1">
                    <h3 class="px-3 text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{ __('المنصة') }}</h3>
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        <x-slot:icon><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></x-slot:icon>
                        <span class="font-semibold">{{ __('الرئيسية') }}</span>
                    </x-nav-link>
                </div>

                {{-- ✅ انظر كم هو نظيف! يتم تضمين القائمة المناسبة فقط --}}
                @auth
                    @if ($role  === 'admin')
                        @include('layouts.partials.navigation.admin')
                    @elseif ($role  === 'doctor')
                        @include('layouts.partials.navigation.doctor')
                    @elseif ($role  === 'student')
                        @include('layouts.partials.navigation.student')
                    @endif
                @endauth
            </nav>

            <!-- Bottom Section -->
            @auth
                <footer class="border-t border-zinc-200 dark:border-zinc-700 p-4 mt-auto flex-shrink-0">
                    <div x-data="{ isUserMenuOpen: false }" class="relative">
                        <button @click="isUserMenuOpen = !isUserMenuOpen" class="w-full flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-zinc-50 to-zinc-100 dark:from-zinc-700/50 dark:to-zinc-800/50 hover:from-zinc-100 hover:to-zinc-200 dark:hover:from-zinc-600 dark:hover:to-zinc-700 transition-all">
                            <div class="w-10 h-10 bg-gradient-to-br from-accent to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                {{ auth()->user()?->initials() }}
                            </div>
                            <div class="flex-1 min-w-0 text-right">
                                <p class="font-bold text-zinc-900 dark:text-white truncate" style="font-family: 'Questv1', sans-serif;">{{ auth()->user()?->name }}</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 truncate">{{ auth()->user()?->email }}</p>
                            </div>
                            <svg class="w-5 h-5 text-zinc-400 transition-transform" :class="{'rotate-180': isUserMenuOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="isUserMenuOpen" @click.away="isUserMenuOpen = false" x-transition x-cloak class="absolute bottom-full right-0 w-full mb-2 bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700">
                            <div class="p-2 space-y-1">
                                <a href="{{ route('settings.profile') }}" class="w-full flex items-center gap-3 p-3 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700" wire:navigate>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>{{ __('الإعدادات') }}</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        <span>{{ __('تسجيل الخروج') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </footer>
            @else
                <footer class="border-t border-zinc-200 dark:border-zinc-700 p-4 mt-auto flex-shrink-0">
                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 p-3 rounded-xl bg-accent text-white font-bold hover:bg-accent/90 transition-all shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>{{ __('تسجيل الدخول') }}</span>
                    </a>
                </footer>
            @endauth
        </aside>
    @endpersist

    <!-- Main Content Area -->
    <div class="transition-all duration-300" :class="isSidebarOpen ? 'lg:mr-80' : 'lg:mr-0'">
        @persist('mobile-header')
        <header class="lg:hidden bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm sticky top-0 z-30 border-b border-zinc-200 dark:border-zinc-700 p-4">
            <div class="flex items-center justify-between">
                <button @click="toggleSidebar()" class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                    <svg class="w-6 h-6 text-zinc-700 dark:text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <a href="{{ route('home') }}" class="flex items-center gap-2" wire:navigate>
                    <div class="w-8 h-8 bg-accent rounded-lg flex items-center justify-center shadow-md"><x-app-logo class="w-5 h-5 text-accent-foreground" /></div>
                </a>
                <div class="flex items-center gap-2">
                    <livewire:user-notifications lazy />
                    <button @click="toggleTheme()" class="p-2 rounded-lg bg-zinc-100 dark:bg-zinc-700 hover:bg-zinc-200 dark:hover:bg-zinc-600 transition-colors">
                        <svg x-show="theme === 'light'" class="w-5 h-5 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg x-show="theme === 'dark'" x-cloak class="w-5 h-5 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>
                </div>
            </div>
        </header>
        @endpersist

       <main class="p-4 sm:p-6 lg:p-8">
            {{ $slot }}
       </main>
    </div>

    @livewireScripts
    @stack('scripts')
        <script>
            // تطبيق الثيم المختار عند كل تحميل للصفحة
            (function() {
                var theme = localStorage.getItem('theme') || 'dark';
                document.documentElement.className = theme;
            })();
        </script>
</body>
</html>