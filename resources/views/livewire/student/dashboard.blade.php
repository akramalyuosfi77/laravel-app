<div wire:poll.60s="refreshDashboard" class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50/30 to-blue-50/30 dark:from-zinc-900 dark:via-purple-950/20 dark:to-blue-950/20">
    
    {{-- 1. Hero Welcome Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 dark:from-indigo-900 dark:via-purple-900 dark:to-pink-900 shadow-2xl shadow-purple-500/20">
        {{-- Animated Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-pink-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
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
                        <span class="text-yellow-300">{{ Auth::user()->name }}</span> 👋
                    </h1>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        نتمنى لك يوماً دراسياً مليئاً بالإنجاز والتفوق. استعد لتحقيق أهدافك!
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('student.my-schedule') }}" wire:navigate class="group relative inline-flex items-center justify-center px-8 py-4 overflow-hidden font-bold text-purple-600 transition-all duration-300 bg-white rounded-2xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-white/50 shadow-xl">
                            <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-purple-100 opacity-50 rotate-12 group-hover:-translate-x-40 ease"></span>
                            <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="relative">جدولي الدراسي</span>
                        </a>
                        <a href="{{ route('student.assignments') }}" wire:navigate class="group relative inline-flex items-center justify-center px-8 py-4 overflow-hidden font-bold text-white transition-all duration-300 bg-white/20 backdrop-blur-sm border-2 border-white/30 rounded-2xl hover:bg-white/30 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-white/50">
                            <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span class="relative">واجباتي</span>
                        </a>
                    </div>
                </div>

                {{-- Right: Animation --}}
                <div class="order-1 md:order-2 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-3xl"></div>
                        <lottie-player
                            src="/animations/Back to school!.json"
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

    {{-- Representative Section (Visible only to Representatives) --}}
    @if(auth()->user()->student->is_representative)
    <div class="mb-8" x-data="{ showQrModal: false }">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-amber-500 to-orange-600 shadow-xl shadow-orange-500/20 p-1">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
            <div class="relative bg-white/10 backdrop-blur-sm rounded-[20px] p-6 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-white mb-1">لوحة المندوب</h3>
                        <p class="text-orange-100 font-medium">أنت مندوب هذه الدفعة. استخدم الرمز لتسجيل زملائك.</p>
                    </div>
                </div>
                <button @click="showQrModal = true" class="group relative px-8 py-3 bg-white text-orange-600 rounded-xl font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center gap-2">
                    <span>عرض QR التسجيل</span>
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- QR Modal --}}
        <div x-show="showQrModal" class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/80 backdrop-blur-sm" x-transition.opacity style="display: none;">
            <div @click.away="showQrModal = false" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all" x-transition.scale>
                <div class="relative p-8 text-center">
                    <button @click="showQrModal = false" class="absolute top-4 right-4 p-2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-2">رمز الانضمام للدفعة</h3>
                    <p class="text-zinc-500 dark:text-zinc-400 mb-8">اطلب من زملائك مسح هذا الرمز للانضمام فوراً</p>

                    <div class="bg-white p-4 rounded-2xl shadow-inner border border-zinc-100 dark:border-zinc-700 inline-block mb-6">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ route('join.batch', auth()->user()->student->batch_id) }}" alt="QR Code" class="w-64 h-64 rounded-lg">
                    </div>

                    <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded-xl p-4 flex items-center justify-between gap-3 border border-zinc-200 dark:border-zinc-700">
                        <code class="text-sm font-mono text-zinc-600 dark:text-zinc-300 truncate flex-1 text-left" id="joinLink">
                            {{ route('join.batch', auth()->user()->student->batch_id) }}
                        </code>
                        <button onclick="navigator.clipboard.writeText('{{ route('join.batch', auth()->user()->student->batch_id) }}'); alert('تم نسخ الرابط!')" class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="نسخ الرابط">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>
                </div>
                <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 text-center border-t border-zinc-200 dark:border-zinc-700">
                    <p class="text-xs text-zinc-500">هذا الرمز خاص بدفعتك فقط. لا تشاركه مع أشخاص من خارج الدفعة.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- 2. Quick Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        @php
            $stats = [
                ['label' => 'المواد الحالية', 'value' => $this->stats['currentCoursesCount'], 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25', 'gradient' => 'from-violet-500 via-purple-500 to-fuchsia-500', 'bg' => 'from-violet-50 to-purple-50 dark:from-violet-950/30 dark:to-purple-950/30'],
                ['label' => 'المشاريع النشطة', 'value' => $this->stats['activeProjectsCount'], 'icon' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 11.25h6.75M9 15.75h6.75', 'gradient' => 'from-cyan-500 via-blue-500 to-indigo-500', 'bg' => 'from-cyan-50 to-blue-50 dark:from-cyan-950/30 dark:to-blue-950/30'],
                ['label' => 'تكاليف قادمة', 'value' => $this->stats['pendingAssignmentsCount'], 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'gradient' => 'from-amber-500 via-orange-500 to-red-500', 'bg' => 'from-amber-50 to-orange-50 dark:from-amber-950/30 dark:to-orange-950/30'],
                ['label' => 'نقاشاتي', 'value' => $this->stats['myDiscussionsCount'], 'icon' => 'M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z', 'gradient' => 'from-emerald-500 via-teal-500 to-cyan-500', 'bg' => 'from-emerald-50 to-teal-50 dark:from-emerald-950/30 dark:to-teal-950/30'],
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
                    <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-2">📊 تقييماتي ودرجاتي</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">تتبع تقدمك الأكاديمي</p>
                </div>
                <div class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-full text-sm font-bold shadow-lg">
                    ممتاز 🎉
                </div>
            </div>
            <div class="h-80 relative">
                <canvas id="gradesChart"></canvas>
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-sm p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
            <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-6">⚡ وصول سريع</h3>
            <div class="space-y-3">
                @php
                    $quickLinks = [
                        ['label' => 'جدولي الدراسي', 'route' => 'student.my-schedule', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18', 'gradient' => 'from-indigo-500 to-purple-500'],
                        ['label' => 'المواد والتكاليف', 'route' => 'student.assignments', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'gradient' => 'from-blue-500 to-cyan-500'],
                        ['label' => 'مشاريعي', 'route' => 'student.projects', 'icon' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 11.25h6.75M9 15.75h6.75', 'gradient' => 'from-emerald-500 to-teal-500'],
                        ['label' => 'المناقشات', 'route' => 'student.projects', 'icon' => 'M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z', 'gradient' => 'from-amber-500 to-orange-500'],
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

    {{-- 4. Activities & Announcements --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        {{-- Recent Activities --}}
        <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-sm p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
            <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-6">🔔 آخر الأحداث</h3>
            <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar pr-2">
                @forelse($this->recentActivities as $activity)
                    <div class="group flex items-start gap-4 p-5 rounded-2xl bg-gradient-to-r from-zinc-50 to-white dark:from-zinc-800/30 dark:to-zinc-800/10 border border-zinc-200 dark:border-zinc-700/50 hover:border-pink-300 dark:hover:border-pink-700 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl shadow-md group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="bi {{ $activity->data['icon'] ?? 'bi-bell' }} text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="{{ $activity->data['url'] ?? '#' }}" class="text-sm font-bold text-zinc-800 dark:text-zinc-200 hover:text-pink-600 dark:hover:text-pink-400 transition-colors block mb-2 break-words line-clamp-2">
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
                        <div class="w-24 h-24 mx-auto bg-gradient-to-br from-pink-100 to-rose-100 dark:from-pink-900/20 dark:to-rose-900/20 rounded-full flex items-center justify-center mb-4 shadow-inner">
                            <svg class="w-12 h-12 text-pink-500 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-zinc-800 dark:text-white mb-2">لا توجد أنشطة</h4>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-xs mx-auto">ستظهر هنا آخر التحديثات والأحداث</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Announcements --}}
        <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-sm p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
            <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-6">📢 آخر الإعلانات</h3>
            <div class="max-h-96 overflow-y-auto custom-scrollbar pr-2">
                <livewire:shared.announcements-display />
            </div>
        </div>
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
            background: linear-gradient(180deg, rgba(139, 92, 246, 0.3), rgba(219, 39, 119, 0.3));
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(139, 92, 246, 0.5), rgba(219, 39, 119, 0.5));
        }
    </style>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            const ctx = document.getElementById('gradesChart').getContext('2d');
            let chart;

            const createOrUpdateChart = (chartData) => {
                if (chart) {
                    chart.destroy();
                }

                const darkMode = document.documentElement.classList.contains('dark');
                
                // Create beautiful gradient
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(139, 92, 246, 0.8)');
                gradient.addColorStop(0.5, 'rgba(99, 102, 241, 0.4)');
                gradient.addColorStop(1, 'rgba(59, 130, 246, 0.1)');

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'الدرجة',
                            data: chartData.data,
                            feedback: chartData.feedback,
                            backgroundColor: gradient,
                            borderColor: '#8b5cf6',
                            borderWidth: 4,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#8b5cf6',
                            pointBorderWidth: 3,
                            pointRadius: 8,
                            pointHoverRadius: 12,
                            pointHoverBackgroundColor: '#8b5cf6',
                            pointHoverBorderColor: '#ffffff',
                            fill: true,
                            tension: 0.4
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
                                max: 100,
                                ticks: { 
                                    color: darkMode ? '#a1a1aa' : '#71717a',
                                    font: { family: 'Tajawal', size: 14, weight: 'bold' },
                                    callback: function(value) {
                                        return value + '%';
                                    }
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
                                borderColor: '#8b5cf6',
                                borderWidth: 2,
                                displayColors: false,
                                callbacks: {
                                    title: function(context) {
                                        return '📚 ' + context[0].label;
                                    },
                                    label: function(context) {
                                        const grade = '🎯 الدرجة: ' + context.raw + ' / 100';
                                        const feedback = context.dataset.feedback[context.dataIndex];
                                        return [grade, feedback ? '💬 ' + feedback : ''];
                                    }
                                }
                            }
                        }
                    }
                });
            }

            createOrUpdateChart(@json($this->gradesChartData));

            Livewire.on('gradesChartUpdated', (event) => {
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
