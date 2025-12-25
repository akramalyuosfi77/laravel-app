<div class="min-h-screen bg-gradient-to-br from-slate-50 via-teal-50/30 to-cyan-50/30 dark:from-zinc-900 dark:via-teal-950/20 dark:to-cyan-950/20 py-8 px-4 sm:px-6 lg:px-8">
    
    {{-- Dynamic Header Based on State --}}
    @if(!$selected_course_id && !$search)
        {{-- Hero Section for Subject Selection --}}
        <div class="relative mb-12 overflow-hidden rounded-[3rem] bg-gradient-to-br from-teal-600 via-cyan-600 to-blue-600 dark:from-teal-900 dark:via-cyan-900 dark:to-blue-900 shadow-2xl shadow-cyan-500/20">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 p-10 md:p-16">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="order-2 md:order-1">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full mb-6">
                            <span class="flex h-2 w-2 rounded-full bg-white animate-ping"></span>
                            <span class="text-sm font-bold text-white uppercase tracking-wider">أكاديمية المستقبل</span>
                        </div>
                        
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-white mb-6 leading-tight" style="font-family: 'Questv1', sans-serif;">
                            اختر مادتك <br> 
                            <span class="text-teal-200">لبدء التعلم</span>
                        </h1>
                        <p class="text-xl text-white/90 mb-8 leading-relaxed max-w-lg">
                            جميع موادك الدراسية منظمة بطريقة ذكية لتسهيل الوصول للمحاضرات والملفات.
                        </p>
                    </div>

                    <div class="order-1 md:order-2 flex justify-center">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-white/20 rounded-full blur-3xl group-hover:bg-white/30 transition-all duration-500"></div>
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
        </div>
    @else
        {{-- Header for Lecture List --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <button wire:click="resetSelection" class="p-4 rounded-2xl bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 hover:text-teal-600 dark:hover:text-teal-400 transition-all shadow-sm group">
                    <svg class="w-6 h-6 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </button>
                <div>
                    <h2 class="text-3xl font-black text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">
                        @if($search) نتائج البحث عن: "{{ $search }}" @else محاضرات: {{ $courses->find($selected_course_id)->name ?? '' }} @endif
                    </h2>
                    <p class="text-zinc-500 dark:text-zinc-400 mt-1">تصفح المحاضرات بالترتيب الزمني</p>
                </div>
            </div>

            {{-- Horizontal Course Tabs (Quick Access) --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-2 no-scrollbar">
                @foreach($courses as $course)
                    <button 
                        wire:click="selectCourse({{ $course->id }})"
                        class="flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ $selected_course_id == $course->id ? 'bg-teal-600 text-white shadow-lg shadow-teal-600/20' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 shadow-sm' }}"
                    >
                        {{ $course->name }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Search Block (Shown in selection mode) --}}
    @if(!$selected_course_id)
    <div class="max-w-2xl mx-auto mb-12 relative group">
        <div class="absolute -inset-1 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
        <div class="relative bg-white dark:bg-zinc-900 rounded-2xl shadow-xl p-1">
            <div class="relative">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <svg class="w-6 h-6 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="🔍 ابحث عن أي محاضرة بالاسم أو الموضوع..." 
                    class="w-full pr-12 pl-4 py-5 bg-transparent border-0 focus:ring-0 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 font-bold rounded-xl"
                >
            </div>
        </div>
    </div>
    @endif

    {{-- Main Content Grid --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        
        @if(!$selected_course_id && !$search)
            {{-- SUBJECT SELECTION MODE --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @php
                    $subjectColors = [
                        ['bg' => 'from-teal-500 to-emerald-600', 'shadow' => 'shadow-teal-500/20', 'icon' => '📚'],
                        ['bg' => 'from-blue-500 to-indigo-600', 'shadow' => 'shadow-blue-500/20', 'icon' => '💻'],
                        ['bg' => 'from-purple-500 to-pink-600', 'shadow' => 'shadow-purple-500/20', 'icon' => '📐'],
                        ['bg' => 'from-orange-500 to-red-600', 'shadow' => 'shadow-orange-500/20', 'icon' => '🔬'],
                        ['bg' => 'from-rose-500 to-pink-600', 'shadow' => 'shadow-rose-500/20', 'icon' => '🎨'],
                        ['bg' => 'from-amber-500 to-yellow-600', 'shadow' => 'shadow-amber-500/20', 'icon' => '🌍'],
                        ['bg' => 'from-cyan-500 to-blue-600', 'shadow' => 'shadow-cyan-500/20', 'icon' => '⚖️'],
                    ];
                @endphp

                @forelse($courses as $course)
                    @php $color = $subjectColors[$loop->index % count($subjectColors)]; @endphp
                    <div 
                        wire:click="selectCourse({{ $course->id }})"
                        class="group cursor-pointer relative bg-white dark:bg-zinc-800 rounded-[2.5rem] p-8 shadow-xl {{ $color['shadow'] }} hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 overflow-hidden border border-zinc-100 dark:border-zinc-700"
                    >
                        <div class="absolute -top-12 -left-12 w-40 h-40 bg-gradient-to-br {{ $color['bg'] }} opacity-5 blur-2xl group-hover:opacity-10 transition-opacity"></div>
                        
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-gradient-to-br {{ $color['bg'] }} rounded-2xl flex items-center justify-center text-4xl shadow-lg mb-8 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">
                                {{ $color['icon'] }}
                            </div>

                            <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-2 leading-tight" style="font-family: 'Questv1', sans-serif;">
                                {{ $course->name }}
                            </h3>
                            <p class="text-sm font-bold text-zinc-500 dark:text-zinc-400 mb-6 uppercase tracking-wider">
                                كود المادة: {{ $course->code ?? 'GEN' }}
                            </p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="p-2 rounded-lg bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    </span>
                                    <span class="text-sm font-black text-zinc-700 dark:text-zinc-300">
                                        {{ $course->lectures_count ?? $course->lectures()->count() }} محاضرة
                                    </span>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center text-zinc-400 group-hover:bg-teal-600 group-hover:text-white transition-all duration-500">
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="text-8xl mb-6">🏜️</div>
                        <h3 class="text-2xl font-black text-zinc-900 dark:text-white">لا توجد مواد مسجلة لهذا الفصل الدراسي</h3>
                    </div>
                @endforelse
            </div>
        @else
            {{-- LECTURE LIST MODE --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $lectureColors = [
                        ['bg' => 'from-teal-50 to-emerald-50 dark:from-teal-900/10 dark:to-emerald-900/10', 'accent' => 'teal-500'],
                        ['bg' => 'from-blue-50 to-indigo-50 dark:from-blue-900/10 dark:to-indigo-900/10', 'accent' => 'blue-500'],
                        ['bg' => 'from-purple-50 to-pink-50 dark:from-purple-900/10 dark:to-pink-900/10', 'accent' => 'purple-500'],
                    ];
                @endphp

                @forelse($lectures as $lecture)
                    <div class="group relative bg-white dark:bg-zinc-800 rounded-3xl p-6 shadow-xl border-2 border-transparent hover:border-teal-500/30 transition-all duration-500 hover:-translate-y-2">
                        {{-- Timeline Badge --}}
                        <div class="absolute -top-4 right-6 px-4 py-2 rounded-xl bg-gradient-to-r from-teal-600 to-cyan-600 text-white text-xs font-black shadow-lg">
                            المحاضرة #{{ $loop->iteration + ($lectures->currentPage() - 1) * $lectures->perPage() }}
                        </div>

                        <div class="mt-4">
                            {{-- Header Meta --}}
                            <div class="flex justify-between items-center mb-6">
                                <div class="flex items-center gap-2 text-xs font-bold text-zinc-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $lecture->lecture_date ? \Carbon\Carbon::parse($lecture->lecture_date)->translatedFormat('l, d M Y') : 'غير محدد' }}
                                </div>
                                <div class="w-3 h-3 rounded-full bg-teal-500 animate-pulse"></div>
                            </div>

                            <h3 class="text-xl font-black text-zinc-900 dark:text-white mb-4 leading-snug group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">
                                {{ $lecture->title }}
                            </h3>

                            <div class="flex items-center gap-3 mb-6 p-3 rounded-2xl bg-slate-50 dark:bg-zinc-900/50">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-500 to-emerald-500 flex items-center justify-center text-white font-bold text-xs shadow-md">
                                    {{ Str::limit($lecture->doctor->name ?? '?', 1, '') }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-zinc-500 dark:text-zinc-500 uppercase tracking-tighter">أستاذ المادة</p>
                                    <p class="text-sm font-black text-zinc-800 dark:text-zinc-200 truncate">د. {{ $lecture->doctor->name ?? 'غير محدد' }}</p>
                                </div>
                            </div>

                            <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-3 mb-8 leading-relaxed">
                                {{ $lecture->description }}
                            </p>

                            <button 
                                wire:click="viewLecture({{ $lecture->id }})" 
                                class="w-full py-4 rounded-2xl bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-black text-sm uppercase tracking-widest hover:bg-teal-600 dark:hover:bg-teal-500 dark:hover:text-white transition-all duration-300 shadow-lg hover:shadow-teal-500/40"
                            >
                                عرض المحتوى والذكاء الاصطناعي
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white dark:bg-zinc-800 rounded-[3rem] border border-zinc-200 dark:border-zinc-700 shadow-xl">
                        <div class="text-7xl mb-6">🔎</div>
                        <h3 class="text-2xl font-black text-zinc-900 dark:text-white">لم نجد أي محاضرات!</h3>
                        <p class="text-zinc-500 dark:text-zinc-400 mt-2">جرب البحث بكلمات أخرى أو اختر مادة مختلفة</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 flex justify-center">
                {{ $lectures->links() }}
            </div>
        @endif
    </div>

    {{-- Modal logic remains the same but with enhanced design if needed (Keeping it as provided originally but ensures it works with new state) --}}
    @if($showViewModal && $viewedLecture)
        <div class="fixed inset-0 bg-zinc-950/80 backdrop-blur-md flex items-center justify-center p-4 z-[100]" x-data="{ activeTab: 'details' }" x-transition.opacity>
            <div @click.away="$wire.closeViewModal()" class="bg-white dark:bg-zinc-900 rounded-[2.5rem] shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                {{-- Header --}}
                <div class="relative p-8 border-b border-zinc-100 dark:border-zinc-800">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-teal-600 to-cyan-600"></div>
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h2 class="text-3xl font-black text-zinc-900 dark:text-white">{{ $viewedLecture->title }}</h2>
                            <div class="flex flex-wrap items-center gap-4 mt-3">
                                <span class="px-3 py-1 rounded-lg bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 text-xs font-black">
                                    {{ $viewedLecture->course->name }}
                                </span>
                                <span class="text-xs font-bold text-zinc-400">
                                    📅 {{ $viewedLecture->lecture_date ? \Carbon\Carbon::parse($viewedLecture->lecture_date)->format('Y-m-d') : 'تاريخ غير محدد' }}
                                </span>
                            </div>
                        </div>
                        <button wire:click="closeViewModal" class="p-3 rounded-full bg-zinc-50 dark:bg-zinc-800 text-zinc-400 hover:text-rose-500 transition-colors shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    {{-- Tabs --}}
                    <div class="flex gap-8 mt-8">
                        <button @click="activeTab = 'details'" :class="activeTab === 'details' ? 'text-teal-600 dark:text-teal-400 border-teal-600' : 'text-zinc-400 border-transparent'" class="pb-2 border-b-4 font-black text-sm uppercase tracking-tighter transition-all">التفاصيل والملفات</button>
                        <button @click="activeTab = 'chat'" :class="activeTab === 'chat' ? 'text-teal-600 dark:text-teal-400 border-teal-600' : 'text-zinc-400 border-transparent'" class="pb-2 border-b-4 font-black text-sm uppercase tracking-tighter transition-all flex items-center gap-2">المساعد الذكي ✨</button>
                    </div>
                </div>

                {{-- Scrollable Content --}}
                <div class="flex-1 overflow-y-auto p-8 custom-scrollbar bg-slate-50/30 dark:bg-zinc-900/50">
                    <div x-show="activeTab === 'details'" x-transition>
                        <div class="grid lg:grid-cols-3 gap-8">
                            <div class="lg:col-span-2 space-y-8">
                                <div class="p-6 bg-white dark:bg-zinc-800 rounded-3xl shadow-sm border border-zinc-100 dark:border-zinc-800">
                                    <h4 class="text-sm font-black text-zinc-400 uppercase tracking-widest mb-4">وصف المحاضرة</h4>
                                    <p class="text-zinc-700 dark:text-zinc-300 leading-relaxed">{{ $viewedLecture->description }}</p>
                                </div>
                                
                                <div class="grid sm:grid-cols-2 gap-4">
                                    @foreach($viewedLecture->files as $file)
                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="flex items-center gap-4 p-5 bg-white dark:bg-zinc-800 rounded-2xl border-2 border-transparent hover:border-teal-500 transition-all group shadow-sm">
                                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-700 dark:to-zinc-600 flex items-center justify-center text-teal-600 dark:text-teal-400 group-hover:scale-110 transition-transform">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l4 4a1 1 0 01.586 1.414V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-black text-zinc-800 dark:text-zinc-200 truncate">{{ $file->file_name }}</p>
                                                <p class="text-xs font-bold text-zinc-400 mt-1 uppercase">{{ $file->file_type }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                <div class="p-6 bg-gradient-to-br from-teal-600 to-cyan-600 rounded-3xl text-white shadow-xl">
                                    <h4 class="text-xs font-black uppercase tracking-widest opacity-70 mb-4">أستاذ المادة</h4>
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-2xl">👨‍🏫</div>
                                        <div>
                                            <p class="text-lg font-black leading-tight">د. {{ $viewedLecture->doctor->name }}</p>
                                            <p class="text-xs font-bold opacity-80 mt-1">قسم الحوسبة والذكاء</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'chat'" x-transition class="max-w-4xl mx-auto">
                        <livewire:components.lecture-chat-bot :lectureId="$viewedLecture->id" :key="'chat-'.$viewedLecture->id" />
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #14b8a6; border-radius: 10px; }
    </style>
</div>