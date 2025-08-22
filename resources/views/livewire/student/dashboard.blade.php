<div wire:poll.60s="refreshDashboard"> {{-- [تحسين] إضافة wire:poll لتحديث البيانات كل دقيقة --}}

    {{-- 1. الهيدر والترحيب --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">لوحة التحكم</h1>
        <p class="mt-1 text-zinc-500 dark:text-zinc-400">أهلاً بك مجدداً {{ Auth::user()->name }}، نتمنى لك يوماً دراسياً موفقاً.</p>
    </div>

    {{-- 2. بطاقات الإحصائيات --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        @php
            // [تحسين] استخدام الخصائص المحسوبة مباشرة
            $stats = [
                ['label' => 'المواد الحالية', 'value' => $this->stats['currentCoursesCount'], 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25', 'color' => 'indigo'],
                ['label' => 'المشاريع النشطة', 'value' => $this->stats['activeProjectsCount'], 'icon' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 11.25h6.75M9 15.75h6.75', 'color' => 'blue'],
                ['label' => 'تكاليف قادمة', 'value' => $this->stats['pendingAssignmentsCount'], 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'amber'],
                ['label' => 'نقاشاتي', 'value' => $this->stats['myDiscussionsCount'], 'icon' => 'M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z', 'color' => 'rose'],
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

    {{-- 3. الصف الرئيسي (الرسم البياني والروابط السريعة  ) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        {{-- الرسم البياني --}}
        <div class="lg:col-span-2 bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4">آخر التقييمات والدرجات</h3>
            <div class="h-64">
                <canvas id="gradesChart"></canvas>
            </div>
        </div>

        {{-- الروابط السريعة --}}
        <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4">وصول سريع</h3>
            <div class="space-y-3">
                @php
                    $quickLinks = [
                        ['label' => 'جدولي الدراسي', 'route' => 'student.my-schedule', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18'],
                        ['label' => 'المواد والتكاليف', 'route' => 'student.assignments', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['label' => 'مشاريعي', 'route' => 'student.projects', 'icon' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 11.25h6.75M9 15.75h6.75'],
                        ['label' => 'تصفح المشاريع', 'route' => 'student.projects', 'icon' => 'M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941'],
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

    {{-- 4. الصف الثاني (آخر الأحداث والإعلانات  ) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        {{-- آخر الأحداث --}}
        <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4">آخر الأحداث</h3>
            <ul class="space-y-4">
                {{-- [تحسين] استخدام الخاصية المحسوبة --}}
                @forelse($this->recentActivities as $activity)
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

        {{-- قسم الإعلانات --}}
        <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
             <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4">آخر الإعلانات</h3>
            <livewire:shared.announcements-display />
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:init', ( ) => {
            const ctx = document.getElementById('gradesChart').getContext('2d');
            let chart;

            const createOrUpdateChart = (chartData) => {
                if (chart) {
                    chart.destroy();
                }

                const darkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                const gridColor = darkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
                const labelColor = darkMode ? '#a1a1aa' : '#71717a';

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'الدرجة',
                            data: chartData.data,
                            feedback: chartData.feedback,
                            backgroundColor: 'rgba(14, 165, 233, 0.2)',
                            borderColor: 'rgba(14, 165, 233, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(14, 165, 233, 1)',
                            pointRadius: 4,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: { color: labelColor },
                                grid: { color: gridColor }
                            },
                            x: {
                                ticks: { color: labelColor },
                                grid: { display: false }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                rtl: true,
                                xAlign: 'center',
                                yAlign: 'bottom',
                                backgroundColor: '#18181b',
                                titleColor: '#ffffff',
                                bodyColor: '#d4d4d8',
                                cornerRadius: 8,
                                padding: 10,
                                callbacks: {
                                    title: function(context) {
                                        return context[0].label;
                                    },
                                    label: function(context) {
                                        const grade = 'الدرجة: ' + context.raw + ' / 100';
                                        const feedback = 'ملاحظات: ' + context.dataset.feedback[context.dataIndex];
                                        return [grade, feedback];
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // [تحسين] استدعاء الخاصية المحسوبة مباشرة
            createOrUpdateChart(@json($this->gradesChartData));

            Livewire.on('gradesChartUpdated', (event) => {
                createOrUpdateChart(event[0]);
            });

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if(chart) {
                    createOrUpdateChart(chart.data);
                }
            });
        });
    </script>
    @endpush
</div>
