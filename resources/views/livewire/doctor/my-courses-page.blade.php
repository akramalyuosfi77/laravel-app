<div>
    <div class="bg-slate-50 dark:bg-slate-900 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- 1. الهيدر الفني --}}
            <div class="relative bg-gradient-to-br from-sky-500 to-blue-600 p-8 rounded-2xl shadow-lg mb-8 overflow-hidden">
                <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full opacity-80"></div>
                <div class="absolute bottom-4 left-4 w-24 h-24 bg-white/10 rounded-full opacity-60"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl sm:text-4xl font-bold text-white tracking-tight">مقرراتي التدريسية</h1>
                    <p class="text-blue-200 font-semibold mt-2 max-w-2xl">نظرة عامة حية على موادك التي تدرسها هذا الفصل، مع وصول سريع لإدارة المناقشات.</p>
                </div>
            </div>

            {{-- 2. شبكة عرض المواد بتصميم جديد --}}
            @if($this->courses->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" wire:poll.15s>
                    @php
                        // مصفوفة الألوان لكل بطاقة
                        $colorThemes = [
                            ['from' => 'from-sky-500', 'to' => 'to-blue-500', 'hover_border' => 'hover:border-sky-500'],
                            ['from' => 'from-purple-500', 'to' => 'to-indigo-500', 'hover_border' => 'hover:border-purple-500'],
                            ['from' => 'from-teal-500', 'to' => 'to-emerald-500', 'hover_border' => 'hover:border-teal-500'],
                            ['from' => 'from-amber-500', 'to' => 'to-orange-500', 'hover_border' => 'hover:border-amber-500'],
                            ['from' => 'from-rose-500', 'to' => 'to-pink-500', 'hover_border' => 'hover:border-rose-500'],
                        ];
                    @endphp

                    @foreach ($this->courses as $course)
                        @php
                            $theme = $colorThemes[$loop->index % count($colorThemes)];
                        @endphp
                        <div class="group bg-white dark:bg-slate-800 rounded-2xl shadow-md flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-1.5 border-2 border-transparent {{ $theme['hover_border'] }}">
                            {{-- رأس البطاقة مع أيقونة بارزة --}}
                            <div class="p-6 flex items-center gap-5 border-b border-slate-200 dark:border-slate-700">
                                <div class="w-16 h-16 flex-shrink-0 bg-gradient-to-br {{ $theme['from'] }} {{ $theme['to'] }} rounded-xl flex items-center justify-center text-white shadow-lg transition-transform duration-300 group-hover:scale-110">
                                    <svg class="w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 truncate">{{ $course->name }}</h2>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $course->code }}</p>
                                </div>
                            </div>

                            {{-- جسم البطاقة مع الإحصائيات --}}
                            <div class="p-6 flex-grow">
                                <p class="text-slate-600 dark:text-slate-300 mb-6 text-sm leading-relaxed line-clamp-3">{{ $course->description ?? 'لا يوجد وصف لهذه المادة.' }}</p>

                                <div class="space-y-3">
                                    {{-- إحصائية المناقشات المفتوحة --}}
                                    <div class="flex items-center justify-between text-slate-700 dark:text-slate-300">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/50 rounded-lg">
                                                <i class="bi bi-patch-question-fill text-yellow-500 text-lg"></i>
                                            </div>
                                            <span>الأسئلة المفتوحة</span>
                                        </div>
                                        <span class="font-bold text-lg bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300 px-2.5 py-0.5 rounded-md">{{ $course->open_discussions_count }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- ذيل البطاقة مع الرابط الرئيسي --}}
                            <div class="p-4 bg-slate-50 dark:bg-slate-800/50 mt-auto">
                                <a href="{{ route('doctor.courses.discussions', ['course' => $course->id] ) }}"
                                   class="w-full text-center block px-6 py-3 bg-slate-700 text-white rounded-xl hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 transition font-semibold shadow-md group-hover:bg-gradient-to-r {{ $theme['from'] }} {{ $theme['to'] }}">
                                    <i class="bi bi-chat-square-dots-fill me-2"></i>
                                    إدارة ساحة المناقشات
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center bg-white dark:bg-slate-800 p-10 rounded-2xl shadow-md">
                    <svg class="mx-auto h-16 w-16 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    <h2 class="mt-4 text-2xl font-bold text-slate-700 dark:text-slate-200">لم يتم تعيين أي مواد لك بعد</h2>
                    <p class="mt-2 text-slate-500 dark:text-slate-400">يرجى مراجعة إدارة القسم لتعيين المواد التي ستقوم بتدريسها.</p>
                </div>
            @endif

        </div>
    </div>
</div>
