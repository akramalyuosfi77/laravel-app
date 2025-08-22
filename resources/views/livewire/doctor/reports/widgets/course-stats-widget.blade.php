<div class="bg-white dark:bg-zinc-800 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 shadow-md">
    <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4">نظرة عامة على المقرر</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        {{-- بطاقة الطلاب --}}
        <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl border border-blue-200 dark:border-blue-800">
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $studentsCount }}</p>
            <p class="text-sm text-blue-800 dark:text-blue-300 mt-1">طالب</p>
        </div>
        {{-- بطاقة المشاريع --}}
        <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/30 rounded-xl border border-purple-200 dark:border-purple-800">
            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $projectsCount }}</p>
            <p class="text-sm text-purple-800 dark:text-purple-300 mt-1">مشروع</p>
        </div>
        {{-- بطاقة التسليمات --}}
        <div class="text-center p-4 bg-amber-50 dark:bg-amber-900/30 rounded-xl border border-amber-200 dark:border-amber-800">
            <p class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $pendingSubmissionsCount }}</p>
            <p class="text-sm text-amber-800 dark:text-amber-300 mt-1">تسليم معلق</p>
        </div>
        {{-- بطاقة المناقشات --}}
        <div class="text-center p-4 bg-teal-50 dark:bg-teal-900/30 rounded-xl border border-teal-200 dark:border-teal-800">
            <p class="text-3xl font-bold text-teal-600 dark:text-teal-400">{{ $discussionsCount }}</p>
            <p class="text-sm text-teal-800 dark:text-teal-300 mt-1">مناقشة</p>
        </div>
    </div>
</div>
