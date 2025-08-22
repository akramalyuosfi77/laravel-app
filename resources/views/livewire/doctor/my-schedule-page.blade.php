<div>
    @section('title', 'جدولي الدراسي')

    <div class="p-4 sm:p-6 lg:p-8 font-sans bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="max-w-screen-2xl mx-auto">

            {{-- 1. الهيدر الرئيسي المحسّن --}}
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800 dark:text-white">جدولي الدراسي</h1>
                    <p class="mt-2 text-slate-500 dark:text-slate-400">نظرة أسبوعية شاملة على محاضراتك. اليوم هو: <span class="font-semibold text-sky-600 dark:text-sky-400">{{ now()->translatedFormat('l, j F Y') }}</span></p>
                </div>
                <button onclick="window.print()" class="flex items-center gap-2 px-5 py-2.5 bg-sky-600 text-white rounded-lg hover:bg-sky-700 font-semibold transition-all shadow-md hover:shadow-lg active:scale-95">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 2.75C5 1.784 5.784 1 6.75 1h6.5c.966 0 1.75.784 1.75 1.75v3.552c.377.046.74.14 1.095.282.35.14.674.33.96.558a3 3 0 01.895 4.168l-1.096 2.739a.75.75 0 01-1.451-.582l1.096-2.74a1.5 1.5 0 00-.448-2.084l-.001-.001c-.285-.228-.61-.418-.96-.558a.75.75 0 01-.329-1.018c.208-.385.374-.793.488-1.216V2.75A.25.25 0 0013.25 2.5h-6.5a.25.25 0 00-.25.25v6.928c.114.423.28.831.488 1.216a.75.75 0 01-.329 1.018c-.35.14-.675.33-.96.558l-.001.001a1.5 1.5 0 00-.448 2.084l1.096 2.74a.75.75 0 01-1.451-.582l-1.096-2.739a3 3 0 01.895-4.168c.286-.228.61-.418.96-.558.355-.142.718-.236 1.095-.282V2.75zM8.5 14.25a.75.75 0 00-1.5 0v2.5a.75.75 0 001.5 0v-2.5zM11.5 14.25a.75.75 0 00-1.5 0v2.5a.75.75 0 001.5 0v-2.5z" clip-rule="evenodd" /></svg>
                    <span>طباعة الجدول</span>
                </button>
            </div>

            @if(empty($scheduleData ))
                {{-- حالة عدم وجود جدول --}}
                <div class="text-center bg-white dark:bg-slate-800/50 p-12 rounded-2xl border border-dashed border-sky-300 dark:border-slate-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-sky-500 to-indigo-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-12 h-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-slate-800 dark:text-white">الجدول فارغ حالياً</h3>
                    <p class="mt-1 text-slate-500 dark:text-slate-400">لم يتم إسناد أي مواعيد لك في الجدول الدراسي بعد.</p>
                </div>
            @else
                {{-- 3. التصميم الشبكي الجديد للجدول --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
                    @foreach($days as $day )
                        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                            {{-- رأس اليوم --}}
                            <div class="text-center mb-6">
                                <h2 class="text-xl font-bold text-sky-600 dark:text-sky-400">{{ __($day) }}</h2>
                            </div>

                            {{-- قائمة المحاضرات لليوم --}}
                            <div class="space-y-4">
                                @php
                                    // فرز المحاضرات حسب وقت البدء لضمان الترتيب
                                    $dailySchedules = collect($scheduleData[$day] ?? [])->sortBy(function($lectures, $timeSlot) {
                                        return \Carbon\Carbon::parse(explode(' - ', $timeSlot)[0])->format('H:i');
                                    });
                                @endphp

                                @forelse($dailySchedules as $timeSlot => $lectures)
                                    @foreach($lectures as $entry)
                                        {{-- بطاقة المحاضرة --}}
                                        <div class="p-4 rounded-xl border-r-4 {{ $entry['type'] === 'عملى' ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-500' : 'bg-green-50 dark:bg-green-900/20 border-green-500' }}">
                                            {{-- التوقيت --}}
                                            <p class="text-sm font-bold text-center mb-3 pb-2 border-b border-dashed {{ $entry['type'] === 'عملى' ? 'text-blue-600 dark:text-blue-400 border-blue-200 dark:border-blue-800' : 'text-green-600 dark:text-green-400 border-green-200 dark:border-green-800' }}">
                                                {{ $timeSlot }}
                                            </p>

                                            {{-- اسم المادة والرمز --}}
                                            <div class="flex justify-between items-start mb-2">
                                                <h4 class="font-bold text-slate-800 dark:text-slate-100">المادة: {{ $entry['course_name'] }}</h4>
                                            </div>

                                            {{-- تفاصيل التخصص والدفعة --}}
                                            <div class="space-y-1.5 text-xs text-slate-600 dark:text-slate-300">
                                                <div class="flex items-center gap-2">
                                                    <i class="bi bi-mortarboard-fill w-4 text-center text-slate-400"></i>
                                                    <span>التخصص :{{ $entry['specialization_name'] }}</span>
                                                </div>
                                                @if($entry['batch_info'])
                                                    <div class="flex items-center gap-2">
                                                        <i class="bi bi-people-fill w-4 text-center text-slate-400"></i>
                                                        <span>المسوى :{{ $entry['batch_info'] }}</span>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- القاعة --}}
                                            <div class="mt-3 pt-2 border-t border-slate-200 dark:border-slate-700 text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                                <i class="bi bi-geo-alt-fill w-4 text-center"></i>
                                                <span>القاعة {{ $entry['location_name'] }} </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @empty
                                    {{-- حالة عدم وجود محاضرات في اليوم --}}
                                    <div class="text-center text-slate-400 dark:text-slate-500 py-10">
                                        <svg class="w-10 h-10 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <p class="mt-2 text-sm font-semibold">يوم راحة</p>
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
