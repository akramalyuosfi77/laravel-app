<div>
    <div class="bg-slate-50 dark:bg-slate-900 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- 1. الهيدر الرئيسي للصفحة --}}
            <div class="relative bg-gradient-to-br from-cyan-500 to-sky-600 p-6 md:p-8 rounded-2xl shadow-lg mb-8 overflow-hidden">
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-8 -left-2 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl sm:text-4xl font-bold text-white">جدولي الدراسي</h1>
                    <p class="text-sky-200 font-semibold mt-1">نظرة شاملة ومنظمة على جدول محاضراتك الأسبوعي.</p>
                </div>
            </div>

            {{-- 2. عرض الجدول الدراسي --}}
            @if(empty($scheduleData))
                <div class="text-center py-16 px-6 bg-white dark:bg-slate-800 rounded-2xl shadow-md">
                    <svg class="mx-auto h-12 w-12 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M-4.5 12h22.5" /></svg>
                    <h2 class="mt-4 text-xl font-semibold text-slate-800 dark:text-slate-200">لم يتم إعداد جدولك الدراسي بعد</h2>
                    <p class="mt-1 text-slate-500 dark:text-slate-400">يرجى مراجعة الإدارة أو الانتظار لحين نزول الجدول الرسمي.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5">
                    @foreach($days as $day )
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md p-4 flex flex-col">
                            <h2 class="text-lg font-bold text-center text-slate-800 dark:text-slate-100 mb-4 pb-3 border-b-2 border-slate-200 dark:border-slate-700">{{ __($day) }}</h2>
                            <div class="space-y-3 flex-grow">
                                @php
                                    // Sort lectures by start time for the current day
                                    $daySchedule = collect($scheduleData[$day] ?? [])->sortBy(function ($entry, $timeSlot) {
                                        return strtotime(explode(' - ', $timeSlot)[0]);
                                    });
                                @endphp
                                @forelse($daySchedule as $timeSlot => $entries)
                                    @foreach($entries as $entry)
                                        @php
                                            $isLab = $entry['type'] === 'عملى';
                                            $theme = $isLab
                                                ? ['border' => 'border-blue-500', 'bg' => 'bg-blue-50 dark:bg-blue-900/50', 'icon' => 'M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75']
                                                : ['border' => 'border-green-500', 'bg' => 'bg-green-50 dark:bg-green-900/50', 'icon' => 'M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6a2.25 2.25 0 012.25-2.25h15A2.25 2.25 0 0121.75 6v3.776'];
                                        @endphp
                                        <div class="p-3 rounded-lg border-r-4 {{ $theme['border'] }} {{ $theme['bg'] }}">
                                            <p class="font-bold text-sm text-slate-800 dark:text-slate-100">{{ $entry['course_name'] }}</p>
                                            <p class="text-xs text-slate-600 dark:text-slate-300 mt-1">{{ $entry['doctor_name'] }}</p>
                                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-2 pt-2 border-t border-slate-200 dark:border-slate-600 flex justify-between items-center">
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    {{ $timeSlot }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $theme['icon'] }}" /></svg>
                                                    {{ $entry['location_name'] }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @empty
                                    <div class="flex-grow flex items-center justify-center">
                                        <div class="text-center text-slate-400 dark:text-slate-500">
                                            <svg class="mx-auto h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M22.033 9.432c.34-.34.34-.892 0-1.232L14.82 1.02a1.232 1.232 0 00-1.742 0L.927 13.17a1.232 1.232 0 000 1.742l7.178 7.178a1.232 1.232 0 001.742 0l12.186-12.186z" /><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5" /></svg>
                                            <p class="mt-2 text-sm">يوم راحة</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
