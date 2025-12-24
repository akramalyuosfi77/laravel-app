<div class="min-h-screen bg-gradient-to-br from-slate-50 via-violet-50/30 to-purple-50/30 dark:from-zinc-900 dark:via-violet-950/20 dark:to-purple-950/20">
    
    {{-- Hero Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-violet-600 via-purple-600 to-fuchsia-600 dark:from-violet-900 dark:via-purple-900 dark:to-fuchsia-900 shadow-2xl shadow-purple-500/20">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-fuchsia-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 p-8 md:p-12">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div class="order-2 md:order-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span class="text-sm font-bold text-white">موادي الدراسية</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 leading-tight">
                        📚 مقرراتي الدراسية
                    </h1>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        نظرة عامة حية على موادك في الفصل الدراسي الحالي!
                    </p>
                </div>

                <div class="order-1 md:order-2 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-3xl"></div>
                        <lottie-player
                            src="/animations/Welcome.json"
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

    {{-- Courses Grid --}}
    @if($this->courses->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" wire:poll.15s>
            @php
                $colorThemes = [
                    ['gradient' => 'from-blue-500 to-cyan-500', 'bg' => 'from-blue-50 to-cyan-50 dark:from-blue-950/30 dark:to-cyan-950/30', 'icon' => 'bg-blue-500'],
                    ['gradient' => 'from-emerald-500 to-teal-500', 'bg' => 'from-emerald-50 to-teal-50 dark:from-emerald-950/30 dark:to-teal-950/30', 'icon' => 'bg-emerald-500'],
                    ['gradient' => 'from-amber-500 to-orange-500', 'bg' => 'from-amber-50 to-orange-50 dark:from-amber-950/30 dark:to-orange-950/30', 'icon' => 'bg-amber-500'],
                    ['gradient' => 'from-rose-500 to-pink-500', 'bg' => 'from-rose-50 to-pink-50 dark:from-rose-950/30 dark:to-pink-950/30', 'icon' => 'bg-rose-500'],
                    ['gradient' => 'from-violet-500 to-purple-500', 'bg' => 'from-violet-50 to-purple-50 dark:from-violet-950/30 dark:to-purple-950/30', 'icon' => 'bg-violet-500'],
                    ['gradient' => 'from-indigo-500 to-blue-500', 'bg' => 'from-indigo-50 to-blue-50 dark:from-indigo-950/30 dark:to-blue-950/30', 'icon' => 'bg-indigo-500'],
                ];
            @endphp

            @foreach ($this->courses as $course)
                @php
                    $theme = $colorThemes[$loop->index % count($colorThemes)];
                @endphp

                <div class="group relative bg-gradient-to-br {{ $theme['bg'] }} p-6 rounded-3xl border-2 border-white dark:border-zinc-800 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 overflow-hidden">
                    <div class="h-2 bg-gradient-to-r {{ $theme['gradient'] }} rounded-t-3xl absolute top-0 left-0 right-0"></div>
                    
                    <div class="relative z-10 mt-4">
                        {{-- Header --}}
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $theme['gradient'] }} flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl font-black text-zinc-900 dark:text-white leading-tight break-words">{{ $course->name }}</h2>
                                <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 mt-1">{{ $course->code }}</p>
                            </div>
                        </div>

                        {{-- Description --}}
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4 leading-relaxed line-clamp-2 min-h-[40px]">
                            {{ $course->description ?? 'لا يوجد وصف لهذه المادة.' }}
                        </p>

                        {{-- Stats --}}
                        <div class="mb-4">
                            <h3 class="text-xs font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-3">نظرة سريعة</h3>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-3 bg-white/60 dark:bg-zinc-800/60 rounded-2xl backdrop-blur-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gradient-to-br {{ $theme['gradient'] }} shadow-md">
                                            <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" /></svg>
                                        </div>
                                        <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">إجمالي المحاضرات</span>
                                    </div>
                                    <span class="text-lg font-black text-zinc-900 dark:text-white">{{ $course->lectures_count }}</span>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-white/60 dark:bg-zinc-800/60 rounded-2xl backdrop-blur-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gradient-to-br {{ $theme['gradient'] }} shadow-md">
                                            <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.44a.75.75 0 00-1.06 1.06L8.94 8.562l-1.062 1.06a.75.75 0 001.06 1.06L10 9.622l1.06 1.06a.75.75 0 101.06-1.06L11.06 8.561l1.06-1.06a.75.75 0 10-1.06-1.06L10 7.5l-1.06-1.06z" clip-rule="evenodd" /></svg>
                                        </div>
                                        <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">الأسئلة المفتوحة</span>
                                    </div>
                                    <span class="text-lg font-black text-zinc-900 dark:text-white">{{ $course->open_discussions_count }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Action Button --}}
                        <a href="{{ route('student.courses.discussions', ['course' => $course->id]) }}"
                           class="group/btn relative w-full inline-flex items-center justify-center px-6 py-3 overflow-hidden font-bold text-white transition-all duration-300 bg-gradient-to-r {{ $theme['gradient'] }} rounded-2xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-purple-400/50 shadow-lg">
                            <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover/btn:-translate-x-40 ease"></span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <span class="relative">دخول ساحة المناقشات</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 px-6 bg-white dark:bg-zinc-900/50 backdrop-blur-sm rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
            <div class="w-32 h-32 mx-auto bg-gradient-to-br from-violet-100 to-purple-100 dark:from-violet-900/20 dark:to-purple-900/20 rounded-full flex items-center justify-center mb-6 shadow-inner">
                <svg class="w-16 h-16 text-violet-500 dark:text-violet-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <h2 class="text-2xl font-black text-zinc-900 dark:text-white mb-3">لم يتم تخصيص أي مواد لك بعد</h2>
            <p class="text-zinc-600 dark:text-zinc-400 max-w-md mx-auto">يرجى مراجعة إدارة القسم لتسجيلك في مواد الفصل الدراسي الحالي.</p>
        </div>
    @endif

    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    {{-- Custom Styles --}}
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</div>
