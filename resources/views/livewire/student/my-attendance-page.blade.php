<div>
    @section('title', 'سجل الحضور')

    {{-- 1. هيدر الصفحة --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">سجل الحضور</h1>
        <p class="mt-1 text-zinc-500 dark:text-zinc-400">تابع نسبة حضورك في جميع المواد الدراسية.</p>
    </div>

    {{-- 2. شبكة بطاقات ملخص الحضور --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($attendanceSummary as $summary)
            <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">

                {{-- اسم المادة والرمز --}}
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight">{{ $summary['course_name'] }}</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $summary['course_code'] }}</p>
                    </div>
                    {{-- أيقونة تعبر عن نسبة الحضور --}}
                    <div class="w-12 h-12 rounded-full flex items-center justify-center
                        @if($summary['percentage'] >= 85) bg-green-100 dark:bg-green-900/30 text-green-500 dark:text-green-400
                        @elseif($summary['percentage'] >= 70) bg-yellow-100 dark:bg-yellow-900/30 text-yellow-500 dark:text-yellow-400
                        @else bg-red-100 dark:bg-red-900/30 text-red-500 dark:text-red-400 @endif">
                        <i class="bi bi-bar-chart-line-fill text-2xl"></i>
                    </div>
                </div>

                {{-- شريط النسبة المئوية --}}
                <div class="mt-4">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">نسبة الحضور</span>
                        <span class="text-sm font-bold
                            @if($summary['percentage'] >= 85) text-green-600 dark:text-green-400
                            @elseif($summary['percentage'] >= 70) text-yellow-600 dark:text-yellow-400
                            @else text-red-600 dark:text-red-400 @endif">
                            {{ $summary['percentage'] }}%
                        </span>
                    </div>
                    <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2.5">
                        <div class="h-2.5 rounded-full
                            @if($summary['percentage'] >= 85) bg-green-500
                            @elseif($summary['percentage'] >= 70) bg-yellow-500
                            @else bg-red-500 @endif"
                            style="width: {{ $summary['percentage'] }}%">
                        </div>
                    </div>
                </div>

                {{-- إحصائيات الحضور والغياب --}}
                <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-around text-center">
                    <div>
                        <p class="text-lg font-bold text-zinc-800 dark:text-white">{{ $summary['total_lectures'] }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">إجمالي المحاضرات</p>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-green-600 dark:text-green-400">{{ $summary['present_count'] }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">أيام الحضور</p>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-red-600 dark:text-red-400">{{ $summary['absent_count'] }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">أيام الغياب</p>
                    </div>
                </div>

                {{-- زر عرض التفاصيل --}}
                <div class="mt-5">
                    <button wire:click="showDetails({{ $summary['course_id'] }})" class="w-full px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-colors">
                        <i class="bi bi-list-ul"></i>
                        <span>عرض التفاصيل</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 xl:col-span-3 p-12 text-center bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-dashed border-zinc-300 dark:border-zinc-700">
                <i class="bi bi-person-check text-6xl text-zinc-400"></i>
                <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">لا يوجد سجل حضور بعد</h3>
                <p class="mt-1 text-zinc-500 dark:text-zinc-400">لم يتم تسجيل أي محاضرات في موادك الدراسية حتى الآن.</p>
            </div>
        @endforelse
    </div>

    {{-- 3. نافذة عرض التفاصيل --}}
    @if ($detailsForCourse)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.closeDetailsModal()" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="flex-shrink-0 p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">
                    تفاصيل الحضور: {{ $detailsForCourse['course_name'] }}
                </h2>
                <button wire:click="closeDetailsModal" class="p-2 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="flex-grow p-6 overflow-y-auto">
                <ul class="space-y-3">
                    @forelse ($detailsForCourse['records'] as $record)
                        <li class="flex items-center justify-between p-4 rounded-lg
                            @if($record['status'] == 'present') bg-green-50 dark:bg-green-900/20
                            @elseif($record['status'] == 'excused_absence') bg-yellow-50 dark:bg-yellow-900/20
                            @else bg-red-50 dark:bg-red-900/20 @endif">

                            <div>
                                <p class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $record['lecture_title'] }}</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ \Carbon\Carbon::parse($record['lecture_date'])->format('l, Y-m-d') }}</p>
                            </div>

                            <span class="px-3 py-1 text-sm font-bold rounded-full
                                @if($record['status'] == 'present') bg-green-200 text-green-800 dark:bg-green-500/30 dark:text-green-300
                                @elseif($record['status'] == 'excused_absence') bg-yellow-200 text-yellow-800 dark:bg-yellow-500/30 dark:text-yellow-300
                                @else bg-red-200 text-red-800 dark:bg-red-500/30 dark:text-red-300 @endif">
                                @if($record['status'] == 'present') حاضر
                                @elseif($record['status'] == 'excused_absence') غائب بعذر
                                @else غائب @endif
                            </span>
                        </li>
                    @empty
                        <li class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                            لا توجد محاضرات مسجلة لهذه المادة بعد.
                        </li>
                    @endforelse
                </ul>
            </div>
            <div class="flex-shrink-0 p-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end">
                <button wire:click="closeDetailsModal" class="px-5 py-2.5 bg-zinc-200 hover:bg-zinc-300 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-800 dark:text-zinc-200 rounded-xl font-semibold transition-colors">
                    إغلاق
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
