<div wire:poll.60s="loadAllData" class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50/30 to-purple-50/30 dark:from-zinc-900 dark:via-indigo-950/20 dark:to-purple-950/20">
    
    {{-- 1. Hero Welcome Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-blue-600 to-purple-600 dark:from-indigo-900 dark:via-blue-900 dark:to-purple-900 shadow-2xl shadow-indigo-500/20">
        {{-- Animated Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-blue-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="relative z-10 p-8 md:p-12">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                {{-- Left: Content --}}
                <div class="order-2 md:order-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full mb-4">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                        </span>
                        <span class="text-sm font-bold text-white">{{ now()->format('l, d F Y') }}</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 leading-tight">
                        مرحباً بك، <br>
                        <span class="text-yellow-300">د. {{ Auth::user()->name }}</span> 👨‍🏫
                    </h1>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        نتمنى لك يوماً مليئاً بالإنجاز والتميز في رحلتك التعليمية!
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('doctor.assignments') }}" wire:navigate class="group relative inline-flex items-center justify-center px-8 py-4 overflow-hidden font-bold text-indigo-600 transition-all duration-300 bg-white rounded-2xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-white/50 shadow-xl">
                            <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-indigo-100 opacity-50 rotate-12 group-hover:-translate-x-40 ease"></span>
                            <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span class="relative">إدارة التكاليف</span>
                        </a>
                        <a href="{{ route('doctor.projects') }}" wire:navigate class="group relative inline-flex items-center justify-center px-8 py-4 overflow-hidden font-bold text-white transition-all duration-300 bg-white/20 backdrop-blur-sm border-2 border-white/30 rounded-2xl hover:bg-white/30 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-white/50">
                            <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 11.25h6.75M9 15.75h6.75"/></svg>
                            <span class="relative">متابعة المشاريع</span>
                        </a>
                    </div>
                </div>

                {{-- Right: Animation --}}
                <div class="order-1 md:order-2 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-3xl"></div>
                        <lottie-player
                            src="/animations/robot-analytics.json"
                            background="transparent"
                            speed="1"
                            style="width: 100%; max-width: 450px; height: auto;"
                            loop
                            autoplay>
                        </lottie-player>
                    </div>
                </div>
            </div>
        </div>

        {{-- Decorative Wave --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="currentColor" class="text-slate-50 dark:text-zinc-900"/>
            </svg>
        </div>
    </div>

    {{-- 2. Quick Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        @php
            $stats = [
                ['label' => 'المواد المسندة', 'value' => $assignedCoursesCount, 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25', 'gradient' => 'from-violet-500 via-purple-500 to-fuchsia-500', 'bg' => 'from-violet-50 to-purple-50 dark:from-violet-950/30 dark:to-purple-950/30'],
                ['label' => 'مشاريع تحت إشرافك', 'value' => $supervisingProjectsCount, 'icon' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 11.25h6.75M9 15.75h6.75', 'gradient' => 'from-cyan-500 via-blue-500 to-indigo-500', 'bg' => 'from-cyan-50 to-blue-50 dark:from-cyan-950/30 dark:to-blue-950/30'],
                ['label' => 'تسليمات بانتظار التقييم', 'value' => $pendingSubmissionsCount, 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'gradient' => 'from-amber-500 via-orange-500 to-red-500', 'bg' => 'from-amber-50 to-orange-50 dark:from-amber-950/30 dark:to-orange-950/30'],
                ['label' => 'أسئلة مفتوحة', 'value' => $openDiscussionsCount, 'icon' => 'M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z', 'gradient' => 'from-emerald-500 via-teal-500 to-cyan-500', 'bg' => 'from-emerald-50 to-teal-50 dark:from-emerald-950/30 dark:to-teal-950/30'],
            ];
        @endphp

        @foreach ($stats as $stat)
        <div class="group relative bg-gradient-to-br {{ $stat['bg'] }} p-6 rounded-2xl border border-white dark:border-zinc-800 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 cursor-pointer">
            {{-- Animated Gradient Background --}}
            <div class="absolute inset-0 bg-gradient-to-br {{ $stat['gradient'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
            
            {{-- Decorative Circle --}}
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-gradient-to-br {{ $stat['gradient'] }} opacity-10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            
            <div class="relative z-10">
                {{-- Icon --}}
                <div class="w-14 h-14 mb-4 flex items-center justify-center bg-gradient-to-br {{ $stat['gradient'] }} rounded-2xl shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                    <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                    </svg>
                </div>

                {{-- Content --}}
                <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 mb-2">{{ $stat['label'] }}</p>
                <h3 class="text-4xl font-black bg-gradient-to-r {{ $stat['gradient'] }} bg-clip-text text-transparent">{{ $stat['value'] }}</h3>
            </div>

            {{-- Shine Effect --}}
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transform -skew-x-12 translate-x-full group-hover:-translate-x-full transition-transform duration-1000"></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- 3. Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        {{-- Chart Section --}}
        <div class="lg:col-span-2 bg-white dark:bg-zinc-900/50 backdrop-blur-sm p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-2">📊 معدل تسليمات الطلاب</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">آخر 7 أيام</p>
                </div>
                <div class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-full text-sm font-bold shadow-lg">
                    نشط 🔥
                </div>
            </div>
            <div class="h-80 relative">
                <canvas id="submissionsChart"></canvas>
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-sm p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
            <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-6">⚡ وصول سريع</h3>
            <div class="space-y-3">
                @php
                    $quickLinks = [
                        ['label' => 'إدارة موادي', 'route' => 'doctor.assignments', 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25', 'gradient' => 'from-indigo-500 to-purple-500'],
                        ['label' => 'إنشاء تكليف جديد', 'route' => 'doctor.assignments', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'gradient' => 'from-blue-500 to-cyan-500'],
                        ['label' => 'متابعة المشاريع', 'route' => 'doctor.projects', 'icon' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 11.25h6.75M9 15.75h6.75', 'gradient' => 'from-emerald-500 to-teal-500'],
                        ['label' => 'نشر إعلان', 'route' => 'doctor.announcements', 'icon' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0', 'gradient' => 'from-amber-500 to-orange-500'],
                    ];
                @endphp
                @foreach ($quickLinks as $link)
                <a href="{{ route($link['route']) }}" wire:navigate class="group flex items-center gap-4 p-4 bg-gradient-to-r from-zinc-50 to-zinc-100 dark:from-zinc-800/50 dark:to-zinc-800/30 hover:from-white hover:to-white dark:hover:from-zinc-800 dark:hover:to-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-2xl transition-all duration-300 hover:shadow-lg hover:-translate-x-1">
                    <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br {{ $link['gradient'] }} rounded-xl shadow-md group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
                        </svg>
                    </div>
                    <span class="font-bold text-zinc-800 dark:text-zinc-200 flex-1">{{ $link['label'] }}</span>
                    <svg class="w-5 h-5 text-zinc-400 group-hover:text-zinc-600 dark:group-hover:text-zinc-300 transform group-hover:-translate-x-1 transition-all" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- 4. Activities & Top Students --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        {{-- Recent Activities --}}
        <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-sm p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
            <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-6">🔔 آخر الأحداث</h3>
            <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar pr-2">
                @forelse($recentActivities as $activity)
                    <div class="group flex items-start gap-4 p-5 rounded-2xl bg-gradient-to-r from-zinc-50 to-white dark:from-zinc-800/30 dark:to-zinc-800/10 border border-zinc-200 dark:border-zinc-700/50 hover:border-indigo-300 dark:hover:border-indigo-700 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl shadow-md group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="bi {{ $activity->data['icon'] ?? 'bi-bell' }} text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="{{ $activity->data['url'] ?? '#' }}" class="text-sm font-bold text-zinc-800 dark:text-zinc-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors block mb-2 break-words line-clamp-2">
                                {{ $activity->data['message'] }}
                            </a>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $activity->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <div class="w-24 h-24 mx-auto bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-full flex items-center justify-center mb-4 shadow-inner">
                            <svg class="w-12 h-12 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-zinc-800 dark:text-white mb-2">لا توجد أنشطة</h4>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-xs mx-auto">ستظهر هنا آخر التحديثات والأحداث</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Top Students --}}
        <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-sm p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
            <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-6">🏆 الطلاب الأكثر تفاعلاً</h3>
            <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar pr-2">
                @forelse($topStudents as $student)
                    <div class="group flex items-center gap-4 p-4 rounded-2xl bg-gradient-to-r from-zinc-50 to-white dark:from-zinc-800/30 dark:to-zinc-800/10 border border-zinc-200 dark:border-zinc-700/50 hover:border-emerald-300 dark:hover:border-emerald-700 hover:shadow-lg transition-all duration-300">
                        @if ($student->profile_image)
                            <img src="{{ Storage::url($student->profile_image) }}" alt="{{ $student->name }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-emerald-500 group-hover:scale-110 transition-transform duration-300">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white font-black text-lg shadow-md group-hover:scale-110 transition-transform duration-300">
                                {{ Str::substr($student->name, 0, 1) }}
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-zinc-800 dark:text-white truncate">{{ $student->name }}</p>
                        </div>

                        <div class="px-3 py-1.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-full text-xs font-black shadow-md">
                            {{ $student->replies_count }} ردود
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <div class="w-24 h-24 mx-auto bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-full flex items-center justify-center mb-4 shadow-inner">
                            <svg class="w-12 h-12 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-zinc-800 dark:text-white mb-2">لا يوجد تفاعل</h4>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-xs mx-auto">لا يوجد تفاعل من الطلاب في ساحات النقاش بعد</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- 5. Announcements Section --}}
    <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-sm p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
        <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-6">📢 آخر الإعلانات</h3>
        <livewire:shared.announcements-display />
    </div>

    {{-- Custom Scrollbar Styles --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(99, 102, 241, 0.3), rgba(139, 92, 246, 0.3));
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(99, 102, 241, 0.5), rgba(139, 92, 246, 0.5));
        }
    </style>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            const ctx = document.getElementById('submissionsChart').getContext('2d');
            let chart;

            const createOrUpdateChart = (chartData) => {
                if (chart) {
                    chart.destroy();
                }

                const darkMode = document.documentElement.classList.contains('dark');
                
                // Create beautiful gradient
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(99, 102, 241, 0.8)');
                gradient.addColorStop(0.5, 'rgba(139, 92, 246, 0.4)');
                gradient.addColorStop(1, 'rgba(168, 85, 247, 0.1)');

                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'عدد التسليمات',
                            data: chartData.data,
                            backgroundColor: gradient,
                            borderColor: '#6366f1',
                            borderWidth: 2,
                            borderRadius: 12,
                            hoverBackgroundColor: '#8b5cf6'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { 
                                    color: darkMode ? '#a1a1aa' : '#71717a',
                                    font: { family: 'Tajawal', size: 14, weight: 'bold' },
                                    stepSize: 1
                                },
                                grid: { 
                                    color: darkMode ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)',
                                    borderDash: [5, 5]
                                }
                            },
                            x: {
                                ticks: { 
                                    color: darkMode ? '#a1a1aa' : '#71717a',
                                    font: { family: 'Tajawal', size: 13 }
                                },
                                grid: { display: false }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                rtl: true,
                                backgroundColor: darkMode ? 'rgba(24, 24, 27, 0.95)' : 'rgba(255, 255, 255, 0.95)',
                                titleColor: darkMode ? '#ffffff' : '#18181b',
                                bodyColor: darkMode ? '#d4d4d8' : '#52525b',
                                titleFont: { family: 'Tajawal', size: 16, weight: 'bold' },
                                bodyFont: { family: 'Tajawal', size: 14 },
                                padding: 16,
                                cornerRadius: 16,
                                borderColor: '#6366f1',
                                borderWidth: 2,
                                displayColors: false,
                                callbacks: {
                                    title: function(context) {
                                        return '📊 ' + context[0].label;
                                    },
                                    label: function(context) {
                                        return '📝 عدد التسليمات: ' + context.raw;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            createOrUpdateChart(@json($submissionsChartData));

            Livewire.on('submissionsChartUpdated', (event) => {
                createOrUpdateChart(event[0]);
            });

            // Watch for dark mode changes
            const observer = new MutationObserver(() => {
                if(chart && chart.data) {
                    createOrUpdateChart(chart.data);
                }
            });
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        });
    </script>
    @endpush
</div>
