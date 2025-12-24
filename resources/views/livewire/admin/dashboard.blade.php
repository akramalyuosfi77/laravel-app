<div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)" class="space-y-8">
    {{-- 1. بطاقة الترحيب الرئيسية --}}
    <div x-show="loaded" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="relative bg-gradient-to-br from-accent to-purple-600 dark:from-accent/80 dark:to-purple-900/80 p-6 md:p-12 rounded-3xl overflow-visible text-white shadow-2xl shadow-accent/20 dark:shadow-accent/10 backdrop-blur-sm min-h-[300px] flex flex-col md:block">
        
        {{-- Text Section --}}
        <div class="relative z-10 max-w-2xl order-1">
            <h1 class="text-3xl md:text-5xl font-bold leading-tight text-center md:text-right">مرحباً بعودتك، <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-purple-200">{{ auth()->user()->name }}</span>!</h1>
            <p class="mt-4 text-lg md:text-xl text-purple-100 leading-relaxed max-w-lg text-center md:text-right mx-auto md:mx-0">
                أنت تتقدم بخطى ثابتة. استمر في الإبداع وإلهام طلابك. العالم بحاجة إلى معرفتك.
            </p>
        </div>

        {{-- Mobile Robot (Prominent & Centered) --}}
        <div class="order-2 relative w-full h-56 flex justify-center items-center my-4 md:hidden z-0">
            <lottie-player src="{{ asset('animations/robot-analytics.json') }}" background="transparent" speed="1" loop autoplay class="w-56 h-56"></lottie-player>
        </div>

        {{-- Action Button --}}
        <div class="relative z-10 order-3 w-full md:w-auto mt-2 md:mt-8">
            <a href="#" class="flex items-center justify-center w-full md:inline-flex md:w-auto bg-white text-purple-700 font-bold px-8 py-4 rounded-2xl shadow-[0_0_20px_rgba(255,255,255,0.3)] hover:shadow-[0_0_30px_rgba(255,255,255,0.5)] hover:bg-zinc-50 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                <span>استعراض تقارير الأداء</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        {{-- Desktop Robot (Side & Break-out) --}}
        <div class="absolute left-0 bottom-0 w-64 h-64 md:w-[450px] md:h-[450px] opacity-90 transform translate-y-8 md:translate-y-16 md:-translate-x-8 pointer-events-none z-0 hidden md:block">
            <lottie-player src="{{ asset('animations/robot-analytics.json') }}" background="transparent" speed="1" loop autoplay></lottie-player>
        </div>
        
        {{-- Decorative SVG --}}
        <div class="absolute -right-10 -bottom-16 opacity-10 dark:opacity-20 transform -rotate-12 pointer-events-none">
            <svg width="400" height="400" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#FFFFFF" d="M37.5,-63.9C50.5,-59.1,64.4,-53.8,73.1,-43.8C81.8,-33.8,85.4,-19.1,84.9,-4.9C84.4,9.4,80,23.3,71.5,34.8C63,46.3,50.5,55.4,37.8,61.7C25.1,68,12.5,71.5,0.4,70.9C-11.8,70.4,-23.6,65.8,-36.2,60.2C-48.7,54.6,-62.1,48,-69.1,37.6C-76.1,27.2,-76.8,13.1,-75.3,0.1C-73.8,-12.8,-70,-25.6,-62.7,-35.8C-55.4,-46,-44.6,-53.6,-33.3,-58.9C-22,-64.1,-11,-67,1.2,-68.8C13.4,-70.6,26.8,-71.2,37.5,-63.9Z" transform="translate(100 100)" />
            </svg>
        </div>
    </div>

    {{-- 2. إحصائيات سريعة --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- بطاقة 1: الطلاب -->
        <div x-show="loaded" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none" style="transition-delay: 0ms;">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-cyan-400 to-cyan-600 rounded-xl shadow-lg shadow-cyan-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 5a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">الطلاب المسجلون</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalStudents }}</p>
                </div>
            </div>
        </div>
        <!-- بطاقة 2: الدكاترة -->
        <div x-show="loaded" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none" style="transition-delay: 100ms;">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg shadow-blue-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h-2a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2v11a2 2 0 01-2 2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 18H8a2 2 0 01-2-2V5a2 2 0 012-2h2a2 2 0 012 2v11a2 2 0 01-2 2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21v-3a2 2 0 012-2h6a2 2 0 012 2v3" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">الدكاترة</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalDoctors }}</p>
                </div>
            </div>
        </div>
        <!-- بطاقة 3: المقررات -->
        <div x-show="loaded" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none" style="transition-delay: 200ms;">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl shadow-lg shadow-amber-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">المقررات المتاحة</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalCourses }}</p>
                </div>
            </div>
        </div>
        <!-- بطاقة 4: الأقسام -->
        <div x-show="loaded" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none" style="transition-delay: 300ms;">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl shadow-lg shadow-purple-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">الأقسام</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalDepartments }}</p>
                </div>
            </div>
        </div>

        <!-- بطاقة 5: التخصصات -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-pink-400 to-pink-600 rounded-xl shadow-lg shadow-pink-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">التخصصات</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalSpecializations }}</p>
                </div>
            </div>
        </div>

        <!-- بطاقة 6: الدفعات -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-teal-400 to-teal-600 rounded-xl shadow-lg shadow-teal-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">الدفعات</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalBatches }}</p>
                </div>
            </div>
        </div>

        <!-- بطاقة 7: الإعلانات -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl shadow-lg shadow-orange-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.5 1.5 0 01-2.077 1.48L7.5 19.24V5.882a1.5 1.5 0 012.432-1.166l.15.15a1.5 1.5 0 002.432 1.166zM17 13V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v9a1 1 0 001 1h4a1 1 0 001-1z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">الإعلانات</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalAnnouncements }}</p>
                </div>
            </div>
        </div>

        <!-- بطاقة 8: التكليفات -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-red-400 to-red-600 rounded-xl shadow-lg shadow-red-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">التكليفات</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalAssignments }}</p>
                </div>
            </div>
        </div>

        <!-- بطاقة 9: المحاضرات -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-lime-400 to-lime-600 rounded-xl shadow-lg shadow-lime-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">المحاضرات</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalLectures }}</p>
                </div>
            </div>
        </div>

        <!-- بطاقة 10: المشاريع -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-fuchsia-400 to-fuchsia-600 rounded-xl shadow-lg shadow-fuchsia-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">المشاريع</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalProjects }}</p>
                </div>
            </div>
        </div>

        <!-- بطاقة 11: التسليمات -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl shadow-lg shadow-indigo-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">التسليمات</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalSubmissions }}</p>
                </div>
            </div>
        </div>

        <!-- بطاقة 12: المناقشات -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-gray-400 to-gray-600 rounded-xl shadow-lg shadow-gray-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">المناقشات</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalDiscussions }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. قسم إحصائيات المشاريع والطلاب والإعلانات --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- حالة المشاريع -->
        <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">حالة المشاريع</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">نظرة عامة على حالة المشاريع.</p>
            <div class="mt-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 dark:text-zinc-200">معلقة:</span>
                    <span class="font-bold text-orange-500">{{ $pendingProjectsCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 dark:text-zinc-200">معتمدة:</span>
                    <span class="font-bold text-green-500">{{ $approvedProjectsCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 dark:text-zinc-200">مرفوضة:</span>
                    <span class="font-bold text-red-500">{{ $rejectedProjectsCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 dark:text-zinc-200">مكتملة:</span>
                    <span class="font-bold text-blue-500">{{ $completedProjectsCount }}</span>
                </div>
            </div>
        </div>

        <!-- حالة الطلاب -->
        <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">حالة الطلاب</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">توزيع الطلاب حسب حالتهم الأكاديمية.</p>
            <div class="mt-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 dark:text-zinc-200">نشط:</span>
                    <span class="font-bold text-green-500">{{ $activeStudentsCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 dark:text-zinc-200">متخرج:</span>
                    <span class="font-bold text-purple-500">{{ $graduatedStudentsCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 dark:text-zinc-200">موقوف:</span>
                    <span class="font-bold text-red-500">{{ $suspendedStudentsCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 dark:text-zinc-200">منسحب:</span>
                    <span class="font-bold text-gray-500">{{ $withdrawnStudentsCount }}</span>
                </div>
            </div>
        </div>

        <!-- مستويات الإعلانات -->
        <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">مستويات الإعلانات</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">توزيع الإعلانات حسب مستوى الأهمية.</p>
            <div class="mt-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 dark:text-zinc-200">معلومات:</span>
                    <span class="font-bold text-blue-500">{{ $infoAnnouncementsCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 dark:text-zinc-200">نجاح:</span>
                    <span class="font-bold text-green-500">{{ $successAnnouncementsCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 dark:text-zinc-200">تحذير:</span>
                    <span class="font-bold text-yellow-500">{{ $warningAnnouncementsCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-zinc-700 dark:text-zinc-200">خطر:</span>
                    <span class="font-bold text-red-500">{{ $dangerAnnouncementsCount }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. قسم الإحصائيات الإضافية --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- بطاقة: تكليفات مستحقة قريباً -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl shadow-lg shadow-yellow-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">تكليفات قريباً</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $assignmentsDueSoonCount }}</p>
                </div>
            </div>
        </div>
        <!-- بطاقة: مناقشات حديثة -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-cyan-400 to-cyan-600 rounded-xl shadow-lg shadow-cyan-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">مناقشات حديثة</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $recentDiscussionsCount }}</p>
                </div>
            </div>
        </div>
        <!-- بطاقة: تسليمات معلقة -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl shadow-lg shadow-orange-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">تسليمات معلقة</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $pendingSubmissionsCount }}</p>
                </div>
            </div>
        </div>
        <!-- بطاقة: تسليمات تم تقييمها -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-green-400 to-green-600 rounded-xl shadow-lg shadow-green-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">تسليمات مقيّمة</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $gradedSubmissionsCount }}</p>
                </div>
            </div>
        </div>

        <!-- بطاقة: إجمالي المستخدمين -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl shadow-lg shadow-purple-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h-2a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2v11a2 2 0 01-2 2zM7 20h2a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v11a2 2 0 002 2zM12 14c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">إجمالي المستخدمين</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <!-- بطاقة: طلاب جدد هذا الشهر -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg shadow-blue-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">طلاب جدد</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $newStudentsThisMonth }}</p>
                </div>
            </div>
        </div>
        <!-- بطاقة: دكاترة جدد هذا الشهر -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-red-400 to-red-600 rounded-xl shadow-lg shadow-red-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">دكاترة جدد</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $newDoctorsThisMonth }}</p>
                </div>
            </div>
        </div>
        <!-- بطاقة: إعلانات نشطة -->
        <div class="bg-white dark:bg-zinc-800/50 p-4 md:p-6 rounded-2xl border border-transparent hover:border-accent dark:hover:border-accent transition-all duration-300 group backdrop-blur-sm shadow-lg shadow-zinc-200/50 dark:shadow-none">
            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-2 md:gap-0">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-lime-400 to-lime-600 rounded-xl shadow-lg shadow-lime-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.5 1.5 0 01-2.077 1.48L7.5 19.24V5.882a1.5 1.5 0 012.432-1.166l.15.15a1.5 1.5 0 002.432 1.166zM17 13V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v9a1 1 0 001 1h4a1 1 0 001-1z" />
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">إعلانات نشطة</p>
                    <p class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white">{{ $activeAnnouncementsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. قسم الروابط السريعة --}}
    <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
        <h3 class="text-xl font-bold text-zinc-900 dark:text-white">روابط سريعة</h3>
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">انتقل بسرعة إلى أقسام الإدارة الرئيسية.</p>
        <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <a href="{{ route('admin.courses') }}" class="flex flex-col items-center justify-center p-4 bg-gray-100 dark:bg-zinc-700 rounded-xl shadow hover:shadow-lg transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-600 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span class="mt-2 text-sm font-semibold text-zinc-700 dark:text-zinc-200">المقررات</span>
            </a>
            <a href="{{ route('admin.departments') }}" class="flex flex-col items-center justify-center p-4 bg-gray-100 dark:bg-zinc-700 rounded-xl shadow hover:shadow-lg transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span class="mt-2 text-sm font-semibold text-zinc-700 dark:text-zinc-200">الأقسام</span>
            </a>
            <a href="{{ route('admin.specializations') }}" class="flex flex-col items-center justify-center p-4 bg-gray-100 dark:bg-zinc-700 rounded-xl shadow hover:shadow-lg transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-pink-600 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span class="mt-2 text-sm font-semibold text-zinc-700 dark:text-zinc-200">التخصصات</span>
            </a>
            <a href="{{ route('admin.batches') }}" class="flex flex-col items-center justify-center p-4 bg-gray-100 dark:bg-zinc-700 rounded-xl shadow hover:shadow-lg transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="mt-2 text-sm font-semibold text-zinc-700 dark:text-zinc-200">الدفعات</span>
            </a>
            <a href="{{ route('admin.announcements') }}" class="flex flex-col items-center justify-center p-4 bg-gray-100 dark:bg-zinc-700 rounded-xl shadow hover:shadow-lg transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.5 1.5 0 01-2.077 1.48L7.5 19.24V5.882a1.5 1.5 0 012.432-1.166l.15.15a1.5 1.5 0 002.432 1.166zM17 13V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v9a1 1 0 001 1h4a1 1 0 001-1z" />
                </svg>
                <span class="mt-2 text-sm font-semibold text-zinc-700 dark:text-zinc-200">الإعلانات</span>
            </a>
            <a href="{{ route('admin.assignments') }}" class="flex flex-col items-center justify-center p-4 bg-gray-100 dark:bg-zinc-700 rounded-xl shadow hover:shadow-lg transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span class="mt-2 text-sm font-semibold text-zinc-700 dark:text-zinc-200">التكليفات</span>
            </a>
            <a href="{{ route('admin.lectures') }}" class="flex flex-col items-center justify-center p-4 bg-gray-100 dark:bg-zinc-700 rounded-xl shadow hover:shadow-lg transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-lime-600 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                </svg>
                <span class="mt-2 text-sm font-semibold text-zinc-700 dark:text-zinc-200">المحاضرات</span>
            </a>
            <a href="{{ route('admin.projects') }}" class="flex flex-col items-center justify-center p-4 bg-gray-100 dark:bg-zinc-700 rounded-xl shadow hover:shadow-lg transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-fuchsia-600 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="mt-2 text-sm font-semibold text-zinc-700 dark:text-zinc-200">المشاريع</span>
            </a>
            <a href="{{ route('admin.submissions') }}" class="flex flex-col items-center justify-center p-4 bg-gray-100 dark:bg-zinc-700 rounded-xl shadow hover:shadow-lg transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="mt-2 text-sm font-semibold text-zinc-700 dark:text-zinc-200">التسليمات</span>
            </a>
            <a href="{{ route('admin.users') }}" class="flex flex-col items-center justify-center p-4 bg-gray-100 dark:bg-zinc-700 rounded-xl shadow hover:shadow-lg transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 5a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>
                <span class="mt-2 text-sm font-semibold text-zinc-700 dark:text-zinc-200">المستخدمين</span>
            </a>
        </div>
    </div>

    {{-- 6. قسم الرسوم البيانية --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- رسم بياني لحالة المشاريع -->
        <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">توزيع حالة المشاريع</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">نظرة مرئية على حالة المشاريع المختلفة.</p>
            <div class="mt-6">
                <canvas id="projectStatusChart"></canvas>
            </div>
        </div>

        <!-- رسم بياني لحالة الطلاب -->
        <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">توزيع حالة الطلاب</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">توزيع الطلاب حسب حالتهم الأكاديمية.</p>
            <div class="mt-6">
                <canvas id="studentStatusChart"></canvas>
            </div>
        </div>

        <!-- رسم بياني لمستويات الإعلانات -->
        <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 lg:col-span-2">
            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">توزيع مستويات الإعلانات</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">توزيع الإعلانات حسب مستوى الأهمية.</p>
            <div class="mt-6">
                <canvas id="announcementLevelChart"></canvas>
            </div>
        </div>
    </div>

    {{-- 7. قسم المحتوى الرئيسي (المقررات والمناقشات) --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <!-- المقررات الأكثر نشاطًا (هذا الجزء يحتاج بيانات ديناميكية من قاعدة البيانات) -->
        <div class="lg:col-span-3 bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">المقررات الأكثر نشاطًا</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">نظرة على مدى تقدم الطلاب في أهم المقررات.</p>
            <div class="mt-6 space-y-5">
                <!-- مثال: مقرر 1 - ستحتاج لجلب هذه البيانات من قاعدة البيانات -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-semibold text-zinc-700 dark:text-zinc-200">مقدمة في الذكاء الاصطناعي</span>
                        <span class="text-sm font-bold text-accent">85%</span>
                    </div>
                    <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2.5">
                        <div class="bg-accent h-2.5 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                <!-- مثال: مقرر 2 -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-semibold text-zinc-700 dark:text-zinc-200">تصميم واجهات المستخدم (UI/UX)</span>
                        <span class="text-sm font-bold text-cyan-500">60%</span>
                    </div>
                    <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2.5">
                        <div class="bg-cyan-500 h-2.5 rounded-full" style="width: 60%"></div>
                    </div>
                </div>
                <!-- مثال: مقرر 3 -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-semibold text-zinc-700 dark:text-zinc-200">تطوير تطبيقات الويب المتقدمة</span>
                        <span class="text-sm font-bold text-amber-500">45%</span>
                    </div>
                    <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2.5">
                        <div class="bg-amber-500 h-2.5 rounded-full" style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- آخر المناقشات (هذا الجزء يحتاج بيانات ديناميكية من قاعدة البيانات) -->
        <div class="lg:col-span-2 bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">آخر المناقشات</h3>
            <div class="mt-6 flow-root">
                <ul role="list" class="-mb-8">
                    <!-- مثال: مناقشة 1 -->
                    <li>
                        <div class="relative pb-8">
                            <span class="absolute top-4 right-4 -mr-px h-full w-0.5 bg-zinc-200 dark:bg-zinc-700" aria-hidden="true"></span>
                            <div class="relative flex space-x-3 gap-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-4 ring-white dark:ring-zinc-800/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.94 8.94 0 01-4.436-1.293L.536 17.47A.5.5 0 00.952 18h.004c.264 0 .513-.105.698-.29l1.62-1.621A8.962 8.962 0 0110 17c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.374 1.97 4.564L.536 16.03A.5.5 0 000 16.5v.003c0 .264.105.513.29.698l1.621 1.62a8.962 8.962 0 014.564 1.97C7.626 19.257 8.79 19 10 19c4.418 0 8-3.134 8-7z" clip-rule="evenodd" /></svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">سؤال جديد في مقرر <a href="#" class="font-medium text-zinc-900 dark:text-white">الخوارزميات</a></p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-zinc-500">
                                        <time datetime="2023-01-23T10:32">منذ 3 دقائق</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- مثال: مناقشة 2 -->
                    <li>
                        <div class="relative pb-8">
                            <span class="absolute top-4 right-4 -mr-px h-full w-0.5 bg-zinc-200 dark:bg-zinc-700" aria-hidden="true"></span>
                            <div class="relative flex space-x-3 gap-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full flex items-center justify-center ring-4 ring-white dark:ring-zinc-800/50">
                                        <img class="h-full w-full rounded-full" src="https://i.pravatar.cc/40?u=a042581f4e29026704d" alt="">
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">رد <a href="#" class="font-medium text-zinc-900 dark:text-white">د. خالد الأحمد</a></p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-zinc-500">
                                        <time datetime="2023-01-23T11:00">منذ 28 دقيقة</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- مثال: مناقشة 3 -->
                    <li>
                        <div class="relative pb-8">
                            <div class="relative flex space-x-3 gap-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-4 ring-white dark:ring-zinc-800/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">إعلان هام في مقرر <a href="#" class="font-medium text-zinc-900 dark:text-white">أمن الشبكات</a></p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-zinc-500">
                                        <time datetime="2023-01-23T11:24">منذ ساعة</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            // Helper function to create gradients
            const createGradient = (ctx, colorStart, colorEnd) => {
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, colorStart);
                gradient.addColorStop(1, colorEnd);
                return gradient;
            };

            // Project Status Chart
            const projectStatusCtx = document.getElementById('projectStatusChart').getContext('2d');
            new Chart(projectStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['معلقة', 'معتمدة', 'مرفوضة', 'مكتملة'],
                    datasets: [{
                        data: [{{ $pendingProjectsCount }}, {{ $approvedProjectsCount }}, {{ $rejectedProjectsCount }}, {{ $completedProjectsCount }}],
                        backgroundColor: [
                            '#f97316', // orange-500
                            '#22c55e', // green-500
                            '#ef4444', // red-500
                            '#3b82f6'  // blue-500
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: 'rgb(113 113 122)',
                                padding: 20,
                                font: { family: 'Tajawal' }
                            }
                        },
                        title: { display: false }
                    }
                }
            });

            // Student Status Chart
            const studentStatusCtx = document.getElementById('studentStatusChart').getContext('2d');
            new Chart(studentStatusCtx, {
                type: 'polarArea',
                data: {
                    labels: ['نشط', 'متخرج', 'موقوف', 'منسحب'],
                    datasets: [{
                        data: [{{ $activeStudentsCount }}, {{ $graduatedStudentsCount }}, {{ $suspendedStudentsCount }}, {{ $withdrawnStudentsCount }}],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.8)', // green
                            'rgba(168, 85, 247, 0.8)', // purple
                            'rgba(239, 68, 68, 0.8)', // red
                            'rgba(107, 114, 128, 0.8)' // gray
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        r: {
                            ticks: { display: false },
                            grid: { color: 'rgba(113, 113, 122, 0.1)' }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: 'rgb(113 113 122)',
                                padding: 20,
                                font: { family: 'Tajawal' }
                            }
                        }
                    }
                }
            });

            // Announcement Level Chart
            const announcementLevelCtx = document.getElementById('announcementLevelChart').getContext('2d');
            const announcementGradient = createGradient(announcementLevelCtx, 'rgba(59, 130, 246, 0.8)', 'rgba(59, 130, 246, 0.1)');
            
            new Chart(announcementLevelCtx, {
                type: 'bar',
                data: {
                    labels: ['معلومات', 'نجاح', 'تحذير', 'خطر'],
                    datasets: [{
                        label: 'عدد الإعلانات',
                        data: [{{ $infoAnnouncementsCount }}, {{ $successAnnouncementsCount }}, {{ $warningAnnouncementsCount }}, {{ $dangerAnnouncementsCount }}],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(234, 179, 8, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ],
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleFont: { family: 'Tajawal' },
                            bodyFont: { family: 'Tajawal' }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(113, 113, 122, 0.1)' },
                            ticks: { color: 'rgb(113 113 122)' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: 'rgb(113 113 122)', font: { family: 'Tajawal' } }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        });
    </script>
    @endpush
    {{-- 8. زر الإجراءات السريع (FAB) --}}
    <div x-data="{ open: false }" class="fixed bottom-8 left-8 z-50">
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" class="flex flex-col space-y-3 mb-4">
            <button class="flex items-center justify-end gap-2 text-white group">
                <span class="bg-zinc-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">إضافة طالب</span>
                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                </div>
            </button>
            <button class="flex items-center justify-end gap-2 text-white group">
                <span class="bg-zinc-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">إعلان جديد</span>
                <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center shadow-lg hover:bg-orange-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.5 1.5 0 01-2.077 1.48L7.5 19.24V5.882a1.5 1.5 0 012.432-1.166l.15.15a1.5 1.5 0 002.432 1.166zM17 13V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v9a1 1 0 001 1h4a1 1 0 001-1z" /></svg>
                </div>
            </button>
        </div>
        <button @click="open = !open" :class="{'rotate-45': open}" class="w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-110">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    </div>
</div>
