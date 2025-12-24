<div class="min-h-screen bg-gradient-to-br from-slate-50 via-cyan-50/30 to-sky-50/30 dark:from-zinc-900 dark:via-cyan-950/20 dark:to-sky-950/20">
    
    {{-- Hero Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-cyan-600 via-sky-600 to-blue-600 dark:from-cyan-900 dark:via-sky-900 dark:to-blue-900 shadow-2xl shadow-cyan-500/20">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 p-8 md:p-12">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div class="order-2 md:order-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-sm font-bold text-white">الجدول الأسبوعي</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 leading-tight">
                        📅 جدولي الدراسي
                    </h1>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        نظرة شاملة ومنظمة على جدول محاضراتك الأسبوعي!
                    </p>
                </div>

                <div class="order-1 md:order-2 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-3xl"></div>
                        <lottie-player
                            src="/animations/Demo.json"
                            background="transparent"
                            speed="1"
                            style="width: 100%; max-width: 400px; height: auto;"
                            loop
                            autoplay>
                        </lottie-player>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="currentColor" class="text-slate-50 dark:text-zinc-900"/>
            </svg>
        </div>
    </div>

    {{-- Schedule Grid --}}
    @if(empty($scheduleData))
        <div class="text-center py-20 px-6 bg-white dark:bg-zinc-900/50 backdrop-blur-sm rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
            <div class="w-32 h-32 mx-auto bg-gradient-to-br from-cyan-100 to-sky-100 dark:from-cyan-900/20 dark:to-sky-900/20 rounded-full flex items-center justify-center mb-6 shadow-inner">
                <svg class="w-16 h-16 text-cyan-500 dark:text-cyan-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M-4.5 12h22.5" />
                </svg>
            </div>
            <h2 class="text-2xl font-black text-zinc-900 dark:text-white mb-3">لم يتم إعداد جدولك الدراسي بعد</h2>
            <p class="text-zinc-600 dark:text-zinc-400 max-w-md mx-auto">يرجى مراجعة الإدارة أو الانتظار لحين نزول الجدول الرسمي.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5">
            @foreach($days as $day)
                <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-sm rounded-3xl shadow-lg border-2 border-zinc-200 dark:border-zinc-800 p-5 flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <h2 class="text-xl font-black text-center bg-gradient-to-r from-cyan-600 to-sky-600 bg-clip-text text-transparent mb-4 pb-3 border-b-2 border-zinc-200 dark:border-zinc-700">
                        {{ __($day) }}
                    </h2>
                    <div class="space-y-3 flex-grow">
                        @php
                            $daySchedule = collect($scheduleData[$day] ?? [])->sortBy(function ($entry, $timeSlot) {
                                return strtotime(explode(' - ', $timeSlot)[0]);
                            });
                        @endphp
                        @forelse($daySchedule as $timeSlot => $entries)
                            @foreach($entries as $entry)
                                @php
                                    $isLab = $entry['type'] === 'عملى';
                                    $theme = $isLab
                                        ? ['gradient' => 'from-blue-500 to-indigo-500', 'bg' => 'from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30', 'icon' => 'M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75']
                                        : ['gradient' => 'from-emerald-500 to-teal-500', 'bg' => 'from-emerald-50 to-teal-50 dark:from-emerald-950/30 dark:to-teal-950/30', 'icon' => 'M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6a2.25 2.25 0 012.25-2.25h15A2.25 2.25 0 0121.75 6v3.776'];
                                @endphp
                                <div class="group relative bg-gradient-to-br {{ $theme['bg'] }} p-4 rounded-2xl border-l-4 border-gradient-to-b {{ $theme['gradient'] }} transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                    <div class="h-1 bg-gradient-to-r {{ $theme['gradient'] }} rounded-t-2xl absolute top-0 left-0 right-0"></div>
                                    
                                    <p class="font-black text-sm text-zinc-900 dark:text-white mb-1 break-words">{{ $entry['course_name'] }}</p>
                                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-3">{{ $entry['doctor_name'] }}</p>
                                    
                                    <div class="text-xs text-zinc-600 dark:text-zinc-400 pt-3 border-t border-zinc-200 dark:border-zinc-700 space-y-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-5 rounded-full bg-gradient-to-br {{ $theme['gradient'] }} flex items-center justify-center shadow-sm">
                                                <svg class="w-3 h-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <span class="font-semibold">{{ $timeSlot }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-5 rounded-full bg-gradient-to-br {{ $theme['gradient'] }} flex items-center justify-center shadow-sm">
                                                <svg class="w-3 h-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $theme['icon'] }}" /></svg>
                                            </div>
                                            <span class="font-semibold">{{ $entry['location_name'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @empty
                            <div class="flex-grow flex items-center justify-center py-12">
                                <div class="text-center">
                                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-700 rounded-full flex items-center justify-center mb-3 shadow-inner">
                                        <svg class="w-8 h-8 text-zinc-400 dark:text-zinc-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-bold text-zinc-500 dark:text-zinc-400">يوم راحة</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
