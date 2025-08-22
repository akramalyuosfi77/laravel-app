<div>
    <div class="bg-slate-50 dark:bg-slate-900 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- 1. الهيدر الرئيسي للصفحة --}}
            <div class="relative bg-gradient-to-br from-violet-500 to-purple-600 p-6 md:p-8 rounded-2xl shadow-lg mb-8 overflow-hidden">
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-8 -left-2 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl sm:text-4xl font-bold text-white">مقرراتي الدراسية</h1>
                    <p class="text-purple-200 font-semibold mt-1">نظرة عامة حية على موادك في الفصل الدراسي الحالي.</p>
                </div>
            </div>

            {{-- 2. شبكة عرض المواد --}}
            @if($this->courses->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" wire:poll.15s>
                    @php
                        $themes = [
                            ['bg' => 'from-sky-400 to-blue-500', 'text' => 'text-blue-600', 'icon_bg' => 'bg-blue-100 dark:bg-blue-900/50', 'icon_text' => 'text-blue-600 dark:text-blue-400'],
                            ['bg' => 'from-emerald-400 to-teal-500', 'text' => 'text-teal-600', 'icon_bg' => 'bg-teal-100 dark:bg-teal-900/50', 'icon_text' => 'text-teal-600 dark:text-teal-400'],
                            ['bg' => 'from-amber-400 to-orange-500', 'text' => 'text-orange-600', 'icon_bg' => 'bg-orange-100 dark:bg-orange-900/50', 'icon_text' => 'text-orange-600 dark:text-orange-400'],
                            ['bg' => 'from-rose-400 to-red-500', 'text' => 'text-red-600', 'icon_bg' => 'bg-red-100 dark:bg-red-900/50', 'icon_text' => 'text-red-600 dark:text-red-400'],
                            ['bg' => 'from-violet-400 to-purple-500', 'text' => 'text-purple-600', 'icon_bg' => 'bg-purple-100 dark:bg-purple-900/50', 'icon_text' => 'text-purple-600 dark:text-purple-400'],
                        ];
                    @endphp
                    @foreach ($this->courses as $course)
                        @php
                            $theme = $themes[$loop->index % count($themes)];
                        @endphp
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-md flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-1.5">
                            {{-- رأس البطاقة --}}
                            <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br {{ $theme['bg'] }} flex-shrink-0"></div>
                                    <div>
                                        <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 truncate">{{ $course->name }}</h2>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $course->code }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- جسم البطاقة مع الإحصائيات --}}
                            <div class="p-6 flex-grow">
                                <p class="text-slate-600 dark:text-slate-300 mb-6 text-sm leading-relaxed min-h-[40px]">{{ $course->description ?? 'لا يوجد وصف لهذه المادة.' }}</p>

                                <h3 class="text-sm font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-3">نظرة سريعة</h3>
                                <div class="space-y-3">
                                    {{-- إحصائية المحاضرات --}}
                                    <div class="flex items-center justify-between text-slate-700 dark:text-slate-300 p-3 bg-slate-50 dark:bg-slate-900/50 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 flex items-center justify-center rounded-full {{ $theme['icon_bg'] }} {{ $theme['icon_text'] }}">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" /></svg>
                                            </div>
                                            <span>إجمالي المحاضرات</span>
                                        </div>
                                        <span class="font-bold text-lg text-slate-800 dark:text-slate-100">{{ $course->lectures_count }}</span>
                                    </div>

                                    {{-- إحصائية المناقشات المفتوحة --}}
                                    <div class="flex items-center justify-between text-slate-700 dark:text-slate-300 p-3 bg-slate-50 dark:bg-slate-900/50 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 flex items-center justify-center rounded-full {{ $theme['icon_bg'] }} {{ $theme['icon_text'] }}">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.44a.75.75 0 00-1.06 1.06L8.94 8.562l-1.062 1.06a.75.75 0 001.06 1.06L10 9.622l1.06 1.06a.75.75 0 101.06-1.06L11.06 8.561l1.06-1.06a.75.75 0 10-1.06-1.06L10 7.5l-1.06-1.06z" clip-rule="evenodd" /></svg>
                                            </div>
                                            <span>الأسئلة المفتوحة</span>
                                        </div>
                                        <span class="font-bold text-lg text-slate-800 dark:text-slate-100">{{ $course->open_discussions_count }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- ذيل البطاقة مع الرابط الرئيسي --}}
                            <div class="p-4 bg-slate-50 dark:bg-slate-800/50">
                                <a href="{{ route('student.courses.discussions', ['course' => $course->id] ) }}"
                                   class="w-full text-center block px-6 py-3 bg-gradient-to-r {{ $theme['bg'] }} text-white rounded-lg hover:opacity-90 transition font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-1">
                                    دخول ساحة المناقشات
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 px-6 bg-white dark:bg-slate-800 rounded-2xl shadow-md">
                    <svg class="mx-auto h-12 w-12 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                    <h2 class="mt-4 text-xl font-semibold text-slate-800 dark:text-slate-200">لم يتم تخصيص أي مواد لك بعد</h2>
                    <p class="mt-1 text-slate-500 dark:text-slate-400">يرجى مراجعة إدارة القسم لتسجيلك في مواد الفصل الدراسي الحالي.</p>
                </div>
            @endif

        </div>
    </div>
</div>
