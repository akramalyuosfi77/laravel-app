{{-- 📂 ملف: resources/views/layouts/partials/navigation/student.blade.php --}}
<div class="space-y-1 pt-4 border-t border-zinc-200 dark:border-zinc-700/50">
    <h3 class="px-3 text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{ __('لوحة الطالب') }}</h3>

    <x-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard') || request()->routeIs('student.dashboard.*')">
        <x-slot:icon><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></x-slot:icon>
        {{ __('لوحة التحكم') }}
    </x-nav-link>

    <x-nav-link :href="route('student.assignments')" :active="request()->routeIs('student.assignments') || request()->routeIs('student.assignments.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg></x-slot:icon>
        {{ __('تكليفاتي') }}
    </x-nav-link>

    <x-nav-link :href="route('student.projects')" :active="request()->routeIs('student.projects') || request()->routeIs('student.projects.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.898 20.572L16.5 21.75l-.398-1.178a3.375 3.375 0 00-2.923-2.923l-1.178-.398h2.356a3.375 3.375 0 002.923-2.923l.398-1.178.398 1.178a3.375 3.375 0 002.923 2.923h2.356l-1.178.398a3.375 3.375 0 00-2.923 2.923z" /></svg></x-slot:icon>
        {{ __('مشاريعي') }}
    </x-nav-link>

    <x-nav-link :href="route('student.lectures')" :active="request()->routeIs('student.lectures') || request()->routeIs('student.lectures.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125v-1.5c0-.621.504-1.125 1.125-1.125H6.75m13.5 0S21 17.625 21 16.5m-13.5 0c0-1.125 0-2.25 0-3.375m0 0h1.125c1.125 0 2.25 0 3.375 0s2.25 0 3.375 0h1.125m-10.125 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125H6.75m10.125 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h.001M4.5 12h15m-15 0c0-1.125 0-2.25 0-3.375m0 0c0-1.125.504-2.25 1.125-2.25H18.375c.621 0 1.125 1.125 1.125 2.25m-15 0c0-1.125 0-2.25 0-3.375M12 3v2.25" /></svg></x-slot:icon>
        {{ __('المحاضرات') }}
    </x-nav-link>

    <x-nav-link :href="route('student.attendance')" :active="request()->routeIs('student.attendance') || request()->routeIs('student.attendance.*')">
    <x-slot:icon>
        {{-- يمكنك استخدام أي أيقونة من Bootstrap Icons أو SVG هنا --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v11.494m-5.747-5.747h11.494M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5-1.125-1.125" />
        </svg>
    </x-slot:icon>
    {{ __('سجل الحضور' ) }}
</x-nav-link>



    <x-nav-link :href="route('student.my-courses')" :active="request()->routeIs('student.my-courses') || request()->routeIs('student.my-courses.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125v-1.5c0-.621.504-1.125 1.125-1.125H6.75m13.5 0S21 17.625 21 16.5m-13.5 0c0-1.125 0-2.25 0-3.375m0 0h1.125c1.125 0 2.25 0 3.375 0s2.25 0 3.375 0h1.125m-10.125 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125H6.75m10.125 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h.001M4.5 12h15m-15 0c0-1.125 0-2.25 0-3.375m0 0c0-1.125.504-2.25 1.125-2.25H18.375c.621 0 1.125 1.125 1.125 2.25m-15 0c0-1.125 0-2.25 0-3.375M12 3v2.25" /></svg></x-slot:icon>
        {{ __('مقرراتي') }}
    </x-nav-link>

    <x-nav-link :href="route('student.my-schedule')" :active="request()->routeIs('student.my-schedule') || request()->routeIs('student.my-schedule.*')">
        <x-slot:icon><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg></x-slot:icon>
        {{ __('جدولي الدراسي') }}
    </x-nav-link>
</div>
