<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        
        {{-- 1. Hero Section المدمج --}}
        <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-emerald-50 to-teal-50 dark:from-zinc-900 dark:via-emerald-900/20 dark:to-teal-900/20 border border-slate-200 dark:border-slate-800" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
            {{-- Animated Background Orbs --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-10 right-10 w-72 h-72 bg-emerald-400/20 dark:bg-emerald-600/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-10 left-10 w-96 h-96 bg-teal-400/20 dark:bg-teal-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 p-8">
                {{-- Top Section: Animation + Title --}}
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    {{-- Left Side: Animation --}}
                    <div class="order-1 md:order-1 flex justify-center">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                            <lottie-player
                                src="/animations/Demo.json"
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
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 rounded-full mb-4">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span class="text-sm font-bold text-emerald-700 dark:text-emerald-300">بوابة المحاضر</span>
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-emerald-700 to-teal-700 dark:from-slate-100 dark:via-emerald-300 dark:to-teal-300 mb-4 leading-tight" style="font-family: 'Questv1', sans-serif;">
                            مقرراتي التدريسية
                        </h1>
                        <p class="text-lg text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                            نظرة شاملة على المواد التي تدرسها مع إمكانية إدارة المناقشات والتفاعل مع الطلاب
                        </p>

                        {{-- Stats Summary --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm p-4 rounded-xl border border-slate-200/50 dark:border-slate-700/50">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">إجمالي المواد</span>
                                </div>
                                <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $this->courses->count() }}</p>
                            </div>
                            <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm p-4 rounded-xl border border-slate-200/50 dark:border-slate-700/50">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">أسئلة مفتوحة</span>
                                </div>
                                <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $this->courses->sum('open_discussions_count') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Courses Grid --}}
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                <span class="w-2 h-8 bg-emerald-600 rounded-full inline-block"></span>
                موادي الدراسية
            </h2>

            @if($this->courses->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" wire:poll.15s>
                    @php
                        $colorThemes = [
                            ['gradient' => 'from-emerald-500 to-teal-500', 'icon_bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'icon_text' => 'text-emerald-600 dark:text-emerald-400', 'badge' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400'],
                            ['gradient' => 'from-sky-500 to-blue-500', 'icon_bg' => 'bg-sky-100 dark:bg-sky-900/30', 'icon_text' => 'text-sky-600 dark:text-sky-400', 'badge' => 'bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-400'],
                            ['gradient' => 'from-purple-500 to-indigo-500', 'icon_bg' => 'bg-purple-100 dark:bg-purple-900/30', 'icon_text' => 'text-purple-600 dark:text-purple-400', 'badge' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400'],
                            ['gradient' => 'from-amber-500 to-orange-500', 'icon_bg' => 'bg-amber-100 dark:bg-amber-900/30', 'icon_text' => 'text-amber-600 dark:text-amber-400', 'badge' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400'],
                            ['gradient' => 'from-rose-500 to-pink-500', 'icon_bg' => 'bg-rose-100 dark:bg-rose-900/30', 'icon_text' => 'text-rose-600 dark:text-rose-400', 'badge' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400'],
                        ];
                    @endphp

                    @foreach ($this->courses as $course)
                        @php
                            $theme = $colorThemes[$loop->index % count($colorThemes)];
                        @endphp
                        <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-500/10 dark:hover:shadow-emerald-900/30 hover:-translate-y-2 overflow-hidden">
                            {{-- Subtle Gradient Background --}}
                            <div class="absolute inset-0 bg-gradient-to-br from-slate-50 to-emerald-50 dark:from-slate-900 dark:to-slate-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                            
                            <div class="relative z-10 flex flex-col h-full">
                                {{-- Header --}}
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="w-14 h-14 flex-shrink-0 rounded-2xl bg-gradient-to-br {{ $theme['gradient'] }} flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="inline-block px-2.5 py-0.5 {{ $theme['badge'] }} rounded-full text-xs font-bold mb-1 truncate max-w-full">
                                            {{ $course->code }}
                                        </span>
                                        <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight truncate group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors" style="font-family: 'Questv1', sans-serif;">
                                            {{ $course->name }}
                                        </h3>
                                    </div>
                                </div>

                                {{-- Details --}}
                                <div class="flex-grow space-y-3 mb-5">
                                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 bg-slate-50 dark:bg-slate-900/50 p-3 rounded-xl border border-slate-100 dark:border-slate-800">
                                        {{ $course->description ?? 'لا يوجد وصف لهذه المادة.' }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-900/30">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 flex items-center justify-center {{ $theme['icon_bg'] }} rounded-lg">
                                                <svg class="w-5 h-5 {{ $theme['icon_text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">الأسئلة المفتوحة</span>
                                        </div>
                                        <span class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ $course->open_discussions_count }}</span>
                                    </div>
                                </div>

                                {{-- Action Button --}}
                                <a href="{{ route('doctor.courses.discussions', ['course' => $course->id]) }}" class="w-full flex items-center justify-center gap-2 p-3 bg-gradient-to-r {{ $theme['gradient'] }} hover:opacity-90 rounded-xl text-white font-bold transition-all hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <span>إدارة المناقشات</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="col-span-full p-12 text-center bg-white/50 dark:bg-zinc-800/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700 backdrop-blur-sm">
                    <div class="w-20 h-20 mx-auto bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-2">لا توجد مواد دراسية</h3>
                    <p class="text-zinc-500 dark:text-zinc-400">لم يتم تعيين أي مواد لك بعد. يرجى مراجعة إدارة القسم.</p>
                </div>
            @endif
        </div>
    </div>
    
    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
