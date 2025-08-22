<div wire:poll.60s="loadAllData">
    {{-- 1. الهيدر والترحيب --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">لوحة التحكم</h1>
        <p class="mt-1 text-zinc-500 dark:text-zinc-400">مرحباً بك د. {{ Auth::user()->name }}، إليك ملخص أنشطتك اليوم.</p>
    </div>

    {{-- 2. بطاقات الإحصائيات بتصميم جديد --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        @php
            $stats = [
                ['label' => 'المواد المسندة', 'value' => $assignedCoursesCount, 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25', 'color' => 'indigo'],
                ['label' => 'مشاريع تحت إشرافك', 'value' => $supervisingProjectsCount, 'icon' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 11.25h6.75M9 15.75h6.75', 'color' => 'blue'],
                ['label' => 'تسليمات بانتظار التقييم', 'value' => $pendingSubmissionsCount, 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'amber'],
                ['label' => 'أسئلة مفتوحة', 'value' => $openDiscussionsCount, 'icon' => 'M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z', 'color' => 'rose'],
            ];
        @endphp

        @foreach ($stats as $stat)
        <div class="relative p-6 bg-white dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-{{$stat['color']}}-500 to-purple-500 opacity-10 dark:opacity-20 rounded-full -z-0"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 flex items-center justify-center bg-{{$stat['color']}}-100 dark:bg-{{$stat['color']}}-900/50 rounded-xl mb-4">
                    <svg class="w-6 h-6 text-{{$stat['color']}}-600 dark:text-{{$stat['color']}}-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                    </svg>
                </div>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm font-medium">{{ $stat['label'] }}</p>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-1">{{ $stat['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- 3. الصف الرئيسي (الرسم البياني والروابط السريعة ) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        {{-- الرسم البياني --}}
        <div class="lg:col-span-2 bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4">معدل تسليمات الطلاب (آخر 7 أيام)</h3>
            <div class="h-64">
                <canvas id="submissionsChart"></canvas>
            </div>
        </div>

        {{-- الروابط السريعة --}}
        <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4">وصول سريع</h3>
            <div class="space-y-3">
                @php
                    $quickLinks = [
                        ['label' => 'إدارة موادي', 'route' => 'doctor.assignments', 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'],
                        ['label' => 'إنشاء تكليف جديد', 'route' => 'doctor.assignments', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['label' => 'متابعة المشاريع', 'route' => 'doctor.projects', 'icon' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 11.25h6.75M9 15.75h6.75'],
                        ['label' => 'نشر إعلان', 'route' => 'doctor.announcements', 'icon' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0'],
                    ];
                @endphp
                @foreach ($quickLinks as $link)
                <a href="{{ route($link['route']) }}" wire:navigate class="flex items-center gap-4 p-3 bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-xl transition-colors">
                    <div class="w-9 h-9 flex items-center justify-center bg-white dark:bg-zinc-900/50 rounded-lg">
                        <svg class="w-5 h-5 text-zinc-500 dark:text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
                        </svg>
                    </div>
                    <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $link['label'] }}</span>
                    <svg class="w-5 h-5 text-zinc-400 dark:text-zinc-500 mr-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- 4. الصف الثاني (آخر الأحداث والطلاب المتفاعلين ) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        {{-- آخر الأحداث --}}
        <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4">آخر الأحداث</h3>
            <ul class="space-y-4">
                @forelse($recentActivities as $activity)
                    <li class="flex items-start gap-4">
                        <div class="w-9 h-9 flex-shrink-0 flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 rounded-lg">
                            <i class="bi {{ $activity->data['icon'] ?? 'bi-bell' }} text-zinc-500 dark:text-zinc-400"></i>
                        </div>
                        <div class="flex-1">
                            <a href="{{ $activity->data['url'] ?? '#' }}" class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:underline">{{ $activity->data['message'] }}</a>
                            <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </li>
                @empty
                    <li class="text-center text-zinc-500 dark:text-zinc-400 py-4">لا توجد أنشطة لعرضها حالياً.</li>
                @endforelse
            </ul>
        </div>

        {{-- الطلاب الأكثر تفاعلاً --}}
        <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4">الطلاب الأكثر تفاعلاً</h3>
            <ul class="space-y-3">
                @forelse($topStudents as $student)
                    <li class="flex items-center gap-4">
                        @if ($student->profile_image)
                            <img src="{{ Storage::url($student->profile_image) }}" alt="{{ $student->name }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-500 dark:text-zinc-300 font-bold">
                                {{ Str::substr($student->name, 0, 1) }}
                            </div>
                        @endif

                        <div class="flex-1">
                            <p class="font-semibold text-zinc-800 dark:text-white">{{ $student->name }}</p>
                        </div>

                        <div class="text-sm font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/50 px-3 py-1 rounded-full">
                            {{ $student->replies_count }} ردود
                        </div>
                    </li>
                @empty
                    <li class="text-center text-zinc-500 dark:text-zinc-400 py-4">لا يوجد تفاعل من الطلاب في ساحات النقاش بعد.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- 5. قسم الإعلانات --}}
    <div>
        <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4">آخر الإعلانات</h3>
        <livewire:shared.announcements-display />
    </div>

    {{-- 💡 سكريبت الرسم البياني --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:init', ( ) => {
            const ctx = document.getElementById('submissionsChart').getContext('2d');
            let chart;

            const createOrUpdateChart = (chartData) => {
                if (chart) {
                    chart.destroy();
                }

                const darkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                const gridColor = darkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
                const labelColor = darkMode ? '#a1a1aa' : '#71717a'; // zinc-400 or zinc-500

                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'عدد التسليمات',
                            data: chartData.data,
                            backgroundColor: 'rgba(79, 70, 229, 0.6)', // Indigo-600 with opacity
                            borderColor: 'rgba(79, 70, 229, 1)', // Indigo-600
                            borderWidth: 2,
                            borderRadius: 8,
                            hoverBackgroundColor: 'rgba(99, 102, 241, 0.8)' // Indigo-500 with opacity
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: labelColor,
                                    stepSize: 1 // عرض الأرقام كأعداد صحيحة
                                },
                                grid: {
                                    color: gridColor
                                }
                            },
                            x: {
                                ticks: {
                                    color: labelColor
                                },
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                rtl: true,
                                xAlign: 'center',
                                yAlign: 'bottom',
                                backgroundColor: '#18181b', // zinc-900
                                titleColor: '#ffffff',
                                bodyColor: '#d4d4d8', // zinc-300
                                cornerRadius: 8,
                                padding: 10
                            }
                        }
                    }
                });
            }

            // استدعاء أولي للرسم البياني
            createOrUpdateChart(@json($submissionsChartData));

            // الاستماع لحدث تحديث البيانات من Livewire
            Livewire.on('submissionsChartUpdated', (event) => {
                createOrUpdateChart(event[0]);
            });

            // تحديث الرسم البياني عند تغيير الوضع المظلم/الفاتح
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                createOrUpdateChart(chart.data);
            });
        });
    </script>
    @endpush
</div>
