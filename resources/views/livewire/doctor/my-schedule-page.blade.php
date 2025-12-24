<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        @section('title', 'جدولي الدراسي')

        {{-- 1. Hero Section المدمج --}}
        <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-cyan-50 to-blue-50 dark:from-zinc-900 dark:via-cyan-900/20 dark:to-blue-900/20 border border-slate-200 dark:border-slate-800" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
            {{-- Animated Background Orbs --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-10 right-10 w-72 h-72 bg-cyan-400/20 dark:bg-cyan-600/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-10 left-10 w-96 h-96 bg-blue-400/20 dark:bg-blue-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 p-8">
                {{-- Grid Layout: Animation + Content --}}
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    {{-- Left Side: Animation --}}
                    <div class="order-1 md:order-1 flex justify-center">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                            <lottie-player
                                src="/animations/Welcome.json"
                                background="transparent"
                                speed="1"
                                style="width: 100%; max-width: 350px; height: auto;"
                                loop
                                autoplay>
                            </lottie-player>
                        </div>
                    </div>

                    {{-- Right Side: Content --}}
                    <div class="order-2 md:order-2">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-100 dark:bg-cyan-900/30 border border-cyan-200 dark:border-cyan-800 rounded-full mb-4">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                            </span>
                            <span class="text-sm font-bold text-cyan-700 dark:text-cyan-300">الجدول الأسبوعي</span>
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-cyan-700 to-blue-700 dark:from-slate-100 dark:via-cyan-300 dark:to-blue-300 mb-4 leading-tight" style="font-family: 'Questv1', sans-serif;">
                            جدولي الدراسي
                        </h1>
                        <p class="text-lg text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                            نظرة أسبوعية شاملة على محاضراتك
                        </p>

                        {{-- Info Cards --}}
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm p-4 rounded-xl border border-slate-200/50 dark:border-slate-700/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-cyan-100 dark:bg-cyan-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">اليوم</p>
                                        <p class="font-bold text-slate-800 dark:text-white">{{ now()->translatedFormat('l, j F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <button onclick="window.print()" class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white rounded-xl font-bold transition-all hover:scale-105 shadow-lg shadow-cyan-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                <span>طباعة الجدول</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Schedule Grid --}}
        @if(empty($scheduleData))
            <div class="col-span-full p-12 text-center bg-white/50 dark:bg-zinc-800/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700 backdrop-blur-sm">
                <div class="w-20 h-20 mx-auto bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-2">الجدول فارغ حالياً</h3>
                <p class="text-zinc-500 dark:text-zinc-400">لم يتم إسناد أي مواعيد لك في الجدول الدراسي بعد.</p>
            </div>
        @else
            <div>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                    <span class="w-2 h-8 bg-cyan-600 rounded-full inline-block"></span>
                    الجدول الأسبوعي
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
                    @foreach($days as $day)
                        <div class="bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm rounded-2xl border border-slate-200/50 dark:border-slate-700/50 shadow-xl overflow-hidden">
                            {{-- Day Header --}}
                            <div class="bg-gradient-to-r from-cyan-600 to-blue-600 p-4 text-center">
                                <h2 class="text-xl font-bold text-white" style="font-family: 'Questv1', sans-serif;">{{ __($day) }}</h2>
                            </div>

                            {{-- Lectures List --}}
                            <div class="p-4 space-y-4">
                                @php
                                    $dailySchedules = collect($scheduleData[$day] ?? [])->sortBy(function($lectures, $timeSlot) {
                                        return \Carbon\Carbon::parse(explode(' - ', $timeSlot)[0])->format('H:i');
                                    });
                                @endphp

                                @forelse($dailySchedules as $timeSlot => $lectures)
                                    @foreach($lectures as $entry)
                                        <div class="group relative p-4 rounded-xl border-l-4 transition-all duration-300 hover:shadow-lg {{ $entry['type'] === 'عملى' ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-500 hover:bg-blue-100 dark:hover:bg-blue-900/30' : 'bg-green-50 dark:bg-green-900/20 border-green-500 hover:bg-green-100 dark:hover:bg-green-900/30' }}">
                                            {{-- Time Badge --}}
                                            <div class="flex items-center justify-center gap-2 mb-3 pb-3 border-b border-dashed {{ $entry['type'] === 'عملى' ? 'border-blue-200 dark:border-blue-800' : 'border-green-200 dark:border-green-800' }}">
                                                <svg class="w-4 h-4 {{ $entry['type'] === 'عملى' ? 'text-blue-600 dark:text-blue-400' : 'text-green-600 dark:text-green-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="text-sm font-bold {{ $entry['type'] === 'عملى' ? 'text-blue-600 dark:text-blue-400' : 'text-green-600 dark:text-green-400' }}">{{ $timeSlot }}</span>
                                            </div>

                                            {{-- Course Info --}}
                                            <h4 class="font-bold text-slate-800 dark:text-white mb-3 leading-tight">{{ $entry['course_name'] }}</h4>

                                            {{-- Details --}}
                                            <div class="space-y-2 text-xs text-slate-600 dark:text-slate-300">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                                    </svg>
                                                    <span>{{ $entry['specialization_name'] }}</span>
                                                </div>
                                                @if($entry['batch_info'])
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                        </svg>
                                                        <span>{{ $entry['batch_info'] }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex items-center gap-2 pt-2 mt-2 border-t border-slate-200 dark:border-slate-700">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                    <span class="font-semibold">{{ $entry['location_name'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @empty
                                    <div class="text-center py-10">
                                        <div class="w-12 h-12 mx-auto bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-400 dark:text-slate-500">يوم راحة</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    
    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
