<div class="bg-white dark:bg-zinc-800 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 shadow-md">
    <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4">نظرة عامة على القسم</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        {{-- بطاقة التخصصات --}}
        <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl border border-blue-200 dark:border-blue-800">
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $specializationsCount }}</p>
            <p class="text-sm text-blue-800 dark:text-blue-300 mt-1">تخصص</p>
        </div>
        {{-- بطاقة الدفعات --}}
        <div class="text-center p-4 bg-green-50 dark:bg-green-900/30 rounded-xl border border-green-200 dark:border-green-800">
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $batchesCount }}</p>
            <p class="text-sm text-green-800 dark:text-green-300 mt-1">دفعة</p>
        </div>
        {{-- بطاقة الطلاب --}}
        <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/30 rounded-xl border border-purple-200 dark:border-purple-800">
            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $studentsCount }}</p>
            <p class="text-sm text-purple-800 dark:text-purple-300 mt-1">طالب</p>
        </div>
        {{-- بطاقة الدكاترة --}}
        <div class="text-center p-4 bg-red-50 dark:bg-red-900/30 rounded-xl border border-red-200 dark:border-red-800">
            <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $doctorsCount }}</p>
            <p class="text-sm text-red-800 dark:text-red-300 mt-1">دكتور</p>
        </div>
    </div>
</div>
