<div class="min-h-screen bg-gradient-to-br from-slate-50 via-teal-50/30 to-cyan-50/30 dark:from-zinc-900 dark:via-teal-950/20 dark:to-cyan-950/20">
    
    {{-- Hero Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-teal-600 via-cyan-600 to-blue-600 dark:from-teal-900 dark:via-cyan-900 dark:to-blue-900 shadow-2xl shadow-cyan-500/20">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 p-8 md:p-12">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div class="order-2 md:order-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        <span class="text-sm font-bold text-white">مركز المحاضرات</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 leading-tight">
                        📚 المحاضرات المتاحة
                    </h1>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        تصفح واستعرض جميع محاضراتك في مكان واحد!
                    </p>
                </div>

                <div class="order-1 md:order-2 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-3xl"></div>
                        <lottie-player
                            src="/animations/Back to school!.json"
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

    {{-- Filters --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-teal-600 to-cyan-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition"></div>
            <div class="relative bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-1">
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-zinc-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="🔍 ابحث بعنوان المحاضرة أو وصفها..." class="w-full pr-11 pl-4 py-4 bg-transparent border-0 focus:ring-0 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 font-medium rounded-xl">
                </div>
            </div>
        </div>
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-teal-600 to-cyan-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition"></div>
            <div class="relative bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-1">
                <select wire:model.live="filter_course_id" class="w-full px-6 py-4 bg-transparent border-0 focus:ring-0 text-zinc-900 dark:text-white font-medium rounded-xl">
                    <option value="">📚 جميع المواد</option>
                    @foreach($this->studentCourses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Lectures Grid --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        @if($lectures->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $colorThemes = [
                        ['gradient' => 'from-teal-500 to-cyan-500', 'bg' => 'from-teal-50 to-cyan-50 dark:from-teal-950/30 dark:to-cyan-950/30', 'badge' => 'from-teal-500 to-cyan-500'],
                        ['gradient' => 'from-blue-500 to-indigo-500', 'bg' => 'from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30', 'badge' => 'from-blue-500 to-indigo-500'],
                        ['gradient' => 'from-purple-500 to-pink-500', 'bg' => 'from-purple-50 to-pink-50 dark:from-purple-950/30 dark:to-pink-950/30', 'badge' => 'from-purple-500 to-pink-500'],
                        ['gradient' => 'from-emerald-500 to-teal-500', 'bg' => 'from-emerald-50 to-teal-50 dark:from-emerald-950/30 dark:to-teal-950/30', 'badge' => 'from-emerald-500 to-teal-500'],
                        ['gradient' => 'from-orange-500 to-red-500', 'bg' => 'from-orange-50 to-red-50 dark:from-orange-950/30 dark:to-red-950/30', 'badge' => 'from-orange-500 to-red-500'],
                        ['gradient' => 'from-rose-500 to-pink-500', 'bg' => 'from-rose-50 to-pink-50 dark:from-rose-950/30 dark:to-pink-950/30', 'badge' => 'from-rose-500 to-pink-500'],
                    ];
                @endphp

                @foreach($lectures as $lecture)
                    @php
                        $theme = $colorThemes[$loop->index % count($colorThemes)];
                    @endphp

                    <div class="group relative bg-gradient-to-br {{ $theme['bg'] }} p-6 rounded-3xl border-2 border-white dark:border-zinc-800 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 overflow-hidden">
                        <div class="h-2 bg-gradient-to-r {{ $theme['gradient'] }} rounded-t-3xl absolute top-0 left-0 right-0"></div>
                        
                        <div class="relative z-10 mt-4">
                            {{-- Header --}}
                            <div class="flex justify-between items-start mb-4">
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-gradient-to-r {{ $theme['badge'] }} text-white shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    <span>{{ $lecture->course->name ?? 'غير محدد' }}</span>
                                </span>
                                @if($lecture->lecture_date)
                                    <span class="text-xs font-bold text-zinc-600 dark:text-zinc-400 bg-white/50 dark:bg-zinc-800/50 px-3 py-1 rounded-full">
                                        📅 {{ \Carbon\Carbon::parse($lecture->lecture_date)->format('Y-m-d') }}
                                    </span>
                                @endif
                            </div>

                            {{-- Title --}}
                            <h3 class="text-xl font-black text-zinc-900 dark:text-white mb-3 break-words line-clamp-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:{{ $theme['gradient'] }} transition-all duration-300">
                                {{ $lecture->title }}
                            </h3>

                            {{-- Doctor --}}
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br {{ $theme['gradient'] }} flex items-center justify-center shadow-md">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                                    د. {{ $lecture->doctor->name ?? 'غير محدد' }}
                                </p>
                            </div>

                            {{-- Description --}}
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-3 mb-4 leading-relaxed">
                                {{ $lecture->description }}
                            </p>

                            {{-- Action Button --}}
                            <button wire:click="viewLecture({{ $lecture->id }})" class="group/btn relative w-full inline-flex items-center justify-center px-6 py-3 overflow-hidden font-bold text-white transition-all duration-300 bg-gradient-to-r {{ $theme['gradient'] }} rounded-2xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-cyan-400/50 shadow-lg">
                                <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover/btn:-translate-x-40 ease"></span>
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span class="relative">عرض التفاصيل والملفات</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $lectures->links() }}
            </div>
        @else
            <div class="text-center py-20 px-6 bg-white dark:bg-zinc-900/50 backdrop-blur-sm rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-teal-100 to-cyan-100 dark:from-teal-900/20 dark:to-cyan-900/20 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <svg class="w-16 h-16 text-teal-500 dark:text-teal-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-3">لا توجد محاضرات متاحة</h3>
                <p class="text-zinc-600 dark:text-zinc-400 max-w-md mx-auto">لا توجد محاضرات تطابق بحثك أو لم يتم إضافة محاضرات بعد.</p>
            </div>
        @endif
    </div>

    {{-- View Modal --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('closeViewModal')" class="bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-800" x-data="{ activeTab: 'details' }">
            <div class="h-2 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-t-3xl"></div>
            
            {{-- Header --}}
            <div class="flex-shrink-0 p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-800">
                <div>
                    <h2 class="text-2xl font-black text-zinc-900 dark:text-white">📚 {{ $viewedLecture->title ?? '' }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">تفاصيل المحاضرة والملفات المرفقة</p>
                </div>
                <button wire:click="closeViewModal" class="p-2 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Tabs Navigation --}}
            <div class="flex border-b border-zinc-200 dark:border-zinc-800 px-6 gap-6">
                <button 
                    @click="activeTab = 'details'" 
                    :class="activeTab === 'details' ? 'border-teal-500 text-teal-600 dark:text-teal-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200'"
                    class="py-4 px-2 border-b-2 font-bold transition-all flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l4 4a1 1 0 01.586 1.414V19a2 2 0 01-2 2z"/></svg>
                    التفاصيل والملفات
                </button>
                <button 
                    @click="activeTab = 'chat'" 
                    :class="activeTab === 'chat' ? 'border-teal-500 text-teal-600 dark:text-teal-400' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200'"
                    class="py-4 px-2 border-b-2 font-bold transition-all flex items-center gap-2 relative"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    المساعد الذكي (AI)
                    <span class="absolute top-2 -left-2 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-gradient-to-r from-teal-500 to-emerald-500"></span>
                    </span>
                </button>
            </div>

            {{-- Content --}}
            <div class="flex-grow p-6 overflow-y-auto custom-scrollbar bg-slate-50/50 dark:bg-zinc-900/50">
                
                {{-- DETAILS TAB --}}
                <div x-show="activeTab === 'details'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    {{-- Lecture Info --}}
                    <div class="p-6 bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
                        <h3 class="text-lg font-black text-teal-600 dark:text-teal-400 mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                            معلومات المحاضرة
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <p class="font-bold text-zinc-500 dark:text-zinc-400 mb-1">المادة</p>
                                <p class="text-zinc-900 dark:text-white font-medium">{{ $viewedLecture->course->name ?? 'غير محدد' }}</p>
                            </div>
                            <div>
                                <p class="font-bold text-zinc-500 dark:text-zinc-400 mb-1">الدكتور</p>
                                <p class="text-zinc-900 dark:text-white font-medium">{{ $viewedLecture->doctor->name ?? 'غير محدد' }}</p>
                            </div>
                            @if($viewedLecture->lecture_date)
                                <div>
                                    <p class="font-bold text-zinc-500 dark:text-zinc-400 mb-1">التاريخ</p>
                                    <p class="text-zinc-900 dark:text-white font-medium">{{ \Carbon\Carbon::parse($viewedLecture->lecture_date)->format('Y-m-d') }}</p>
                                </div>
                            @endif
                            <div class="col-span-full">
                                <p class="font-bold text-zinc-500 dark:text-zinc-400 mb-2">الوصف</p>
                                <p class="text-zinc-700 dark:text-zinc-300 leading-relaxed break-words">{{ $viewedLecture->description ?? 'لا يوجد وصف' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Files --}}
                    <div>
                        <h3 class="text-lg font-black text-cyan-600 dark:text-cyan-400 mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                            الملفات المرفقة
                        </h3>
                        @if($viewedLecture->files->isNotEmpty())
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($viewedLecture->files as $file)
                                    <div class="group border border-zinc-200 dark:border-zinc-700 rounded-2xl p-4 flex items-start gap-3 bg-white dark:bg-zinc-800 hover:border-cyan-500 dark:hover:border-cyan-500 transition-all duration-300 hover:shadow-lg">
                                        <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-teal-500 to-cyan-500 text-white shadow-md group-hover:scale-110 transition-transform duration-300">
                                            @if(Str::contains($file->file_type, ['image', 'jpeg', 'png', 'gif']))
                                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                            @elseif(Str::contains($file->file_type, 'pdf'))
                                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                            @else
                                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                            @endif
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="font-bold text-zinc-800 dark:text-zinc-200 hover:text-cyan-600 dark:hover:text-cyan-400 text-sm leading-tight block truncate">
                                                {{ $file->file_name }}
                                            </a>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-2">{{ $file->description ?? 'لا يوجد وصف' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 bg-white dark:bg-zinc-800 rounded-2xl border-2 border-dashed border-zinc-300 dark:border-zinc-700">
                                <p class="text-zinc-500 dark:text-zinc-400 font-medium">لا توجد ملفات مرفقة بهذه المحاضرة</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- CHAT TAB --}}
                <div x-show="activeTab === 'chat'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="max-w-3xl mx-auto">
                        <div class="bg-gradient-to-r from-teal-50 to-emerald-50 dark:from-teal-900/20 dark:to-emerald-900/20 p-6 rounded-2xl border border-teal-100 dark:border-teal-800 mb-6 flex gap-4 items-start">
                             <div class="bg-white p-2 text-3xl rounded-xl shadow-sm">🤖</div>
                             <div>
                                 <h4 class="font-bold text-teal-800 dark:text-teal-200 text-lg">مرحباً بك في تجربة "المساعد الذكي"!</h4>
                                 <p class="text-teal-700 dark:text-teal-300 text-sm mt-1">
                                     أنا هنا لمساعدتك في فهم المحاضرة. لقد قمت بقراءة ملفات الـ PDF المرفقة وأنا جاهز للإجابة على أي سؤال، أو تلخيص المحتوى، أو حتى شرح النقاط الصعبة. جربني الآن!
                                 </p>
                             </div>
                        </div>

                        <livewire:components.lecture-chat-bot :lectureId="$viewedLecture->id" :key="'chat-'.$viewedLecture->id" />
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="flex-shrink-0 p-6 flex justify-end bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800">
                <button type="button" wire:click="closeViewModal" class="px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-2xl font-bold transition-colors">
                    إغلاق
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    {{-- Custom Scrollbar --}}
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(20, 184, 166, 0.3), rgba(6, 182, 212, 0.3));
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(20, 184, 166, 0.5), rgba(6, 182, 212, 0.5));
        }
    </style>
</div>
