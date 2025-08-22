<div>
    @section('title', 'تقارير المقررات')

    {{-- الهيدر الرئيسي للصفحة --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">تقارير المقررات</h1>
        <p class="mt-1 text-zinc-500 dark:text-zinc-400">احصل على رؤى تفصيلية حول أداء الطلاب والأنشطة في مقرراتك.</p>
    </div>

    {{-- قسم الفلاتر --}}
    <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 shadow-lg mb-8">
        <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4">اختر مقررًا لعرض تقريره</h3>
        <select wire:model.live="selectedCourseId" class="w-full md:w-1/2 py-3 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
            <option value="">-- اختر المقرر --</option>
            @foreach ($this->doctorCourses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- منطقة عرض التقارير --}}
    <div class="mt-8 space-y-8">
        @if ($selectedCourseId)
        {{-- عرض بطاقة إحصائيات المقرر --}}
        <livewire:doctor.reports.widgets.course-stats-widget :courseId="$selectedCourseId" :key="'stats-'.$selectedCourseId" />
        <livewire:doctor.reports.widgets.course-students-widget :courseId="$selectedCourseId" :key="'students-'.$selectedCourseId" />

    @else
        {{-- رسالة توجيهية للمستخدم --}}
        <div class="bg-zinc-50 dark:bg-zinc-800/50 border border-dashed border-zinc-300 dark:border-zinc-700 p-8 rounded-2xl text-center">
            <p class="text-zinc-600 dark:text-zinc-400 font-semibold">
                يرجى اختيار مقرر من القائمة أعلاه لبدء عرض التقارير.
            </p>
        </div>
    @endif


    </div>
</div>
