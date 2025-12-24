{{-- 📂 ملف: resources/views/layouts/partials/navigation/admin.blade.php --}}
<div class="space-y-1 pt-4 border-t border-zinc-200 dark:border-zinc-700/50">
    <h3 class="px-3 text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{ __('لوحة المسؤول') }}</h3>

    {{-- Dashboard Link --}}
    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
        <x-slot:icon>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </x-slot:icon>
        <span class="font-semibold">{{ __('لوحة التحكم') }}</span>
    </x-nav-link>

    <x-nav-link :href="route('admin.departments')" :active="request()->routeIs('admin.departments') || request()->routeIs('admin.departments.*')">
        <x-slot:icon><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></x-slot:icon>
        {{ __('الأقسام') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.specializations')" :active="request()->routeIs('admin.specializations') || request()->routeIs('admin.specializations.*')">
        <x-slot:icon><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg></x-slot:icon>
        {{ __('التخصصات') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.batches')" :active="request()->routeIs('admin.batches') || request()->routeIs('admin.batches.*')">
        <x-slot:icon><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg></x-slot:icon>
        {{ __('الدفعات') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.courses')" :active="request()->routeIs('admin.courses') || request()->routeIs('admin.courses.*')">
        <x-slot:icon><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></x-slot:icon>
        {{ __('المقررات') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.doctor')" :active="request()->routeIs('admin.doctor') || request()->routeIs('admin.doctor.*')">
        <x-slot:icon><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></x-slot:icon>
        {{ __('الدكاترة') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.Students')" :active="request()->routeIs('admin.Students') || request()->routeIs('admin.Students.*')">
        <x-slot:icon><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg></x-slot:icon>
        {{ __('الطلاب') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.assignments')" :active="request()->routeIs('admin.assignments') || request()->routeIs('admin.assignments.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg></x-slot:icon>
        {{ __('إدارة التكليفات') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.submissions')" :active="request()->routeIs('admin.submissions') || request()->routeIs('admin.submissions.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3" /></svg></x-slot:icon>
        {{ __('إدارة التسليمات') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.projects')" :active="request()->routeIs('admin.projects') || request()->routeIs('admin.projects.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.898 20.572L16.5 21.75l-.398-1.178a3.375 3.375 0 00-2.923-2.923l-1.178-.398h2.356a3.375 3.375 0 002.923-2.923l.398-1.178.398 1.178a3.375 3.375 0 002.923 2.923h2.356l-1.178.398a3.375 3.375 0 00-2.923 2.923z" /></svg></x-slot:icon>
        {{ __('إدارة المشاريع') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.lectures')" :active="request()->routeIs('admin.lectures') || request()->routeIs('admin.lectures.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125v-1.5c0-.621.504-1.125 1.125-1.125H6.75m13.5 0S21 17.625 21 16.5m-13.5 0c0-1.125 0-2.25 0-3.375m0 0h1.125c1.125 0 2.25 0 3.375 0s2.25 0 3.375 0h1.125m-10.125 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125H6.75m10.125 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h.001M4.5 12h15m-15 0c0-1.125 0-2.25 0-3.375m0 0c0-1.125.504-2.25 1.125-2.25H18.375c.621 0 1.125 1.125 1.125 2.25m-15 0c0-1.125 0-2.25 0-3.375M12 3v2.25" /></svg></x-slot:icon>
        {{ __('إدارة المحاضرات') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.announcements')" :active="request()->routeIs('admin.announcements') || request()->routeIs('admin.announcements.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 01-4.5-4.5v-4.5a4.5 4.5 0 014.5-4.5h7.5a4.5 4.5 0 014.5 4.5v1.84M18.75 12.75h-2.25a4.5 4.5 0 00-4.5 4.5v2.25a4.5 4.5 0 004.5 4.5h2.25a4.5 4.5 0 004.5-4.5v-2.25a4.5 4.5 0 00-4.5-4.5z" /></svg></x-slot:icon>
        {{ __('الإعلانات') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.discussions.management')" :active="request()->routeIs('admin.discussions.management') || request()->routeIs('admin.discussions.management.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 01-4.5-4.5v-4.5a4.5 4.5 0 014.5-4.5h7.5a4.5 4.5 0 014.5 4.5v1.84M18.75 12.75h-2.25a4.5 4.5 0 00-4.5 4.5v2.25a4.5 4.5 0 004.5 4.5h2.25a4.5 4.5 0 004.5-4.5v-2.25a4.5 4.5 0 00-4.5-4.5z" /></svg></x-slot:icon>
        {{ __('إدارة المناقشات') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.schedules')" :active="request()->routeIs('admin.schedules') || request()->routeIs('admin.schedules.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M-4.5 12h22.5" /></svg></x-slot:icon>
        {{ __('الجداول الدراسية') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.locations')" :active="request()->routeIs('admin.locations') || request()->routeIs('admin.locations.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg></x-slot:icon>
        {{ __('القاعات والمعامل') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.reports.center')" :active="request()->routeIs('admin.reports.center')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a4 4 0 004 4h10a4 4 0 004-4V7" /><path stroke-linecap="round" stroke-linejoin="round" d="M16 3v4M8 3v4" /></svg></x-slot:icon>
        {{ __('التقارير') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.reports.attendance')" :active="request()->routeIs('admin.reports.attendance')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4-4 4 4M12 3v10" /></svg></x-slot:icon>
        {{ __('الحضور والغياب') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.contact-messages')" :active="request()->routeIs('admin.contact-messages') || request()->routeIs('admin.contact-messages.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg></x-slot:icon>
        {{ __('صندوق الرسائل') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.backup')" :active="request()->routeIs('admin.backup')">
        <x-slot:icon>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
            </svg>
        </x-slot:icon>
        {{ __('النسخ الاحتياطي') }}
    </x-nav-link>

    <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users') || request()->routeIs('admin.users.*')">
        <x-slot:icon>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13.5 3.542a4 4 0 010 5.916"/>
            </svg>
        </x-slot:icon>
        {{ __('إدارة المستخدمين') }}
    </x-nav-link>
</div>
