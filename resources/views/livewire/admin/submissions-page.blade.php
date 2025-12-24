<div>
    {{-- 1. Combined Hero & Filters Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-emerald-50 to-teal-50 dark:from-zinc-900 dark:via-slate-900 dark:to-zinc-900 border border-slate-200 dark:border-slate-800 shadow-xl" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
        {{-- Animated Background Orbs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-10 right-10 w-72 h-72 bg-emerald-400/20 dark:bg-emerald-600/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-teal-400/20 dark:bg-teal-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        {{-- Top Part: Hero Content --}}
        <div class="relative z-10 p-8 pb-10">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                {{-- Left Side: Animation --}}
                <div class="order-1 md:order-1 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
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
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 rounded-full mb-4">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-sm font-bold text-emerald-700 dark:text-emerald-300">تسليمات الطلاب</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-emerald-700 to-teal-700 dark:from-slate-100 dark:via-emerald-300 dark:to-teal-300 mb-4 leading-tight">
                        إدارة التسليمات والتقييم
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-300 mb-8 leading-relaxed">
                        منصة مركزية لمراجعة تسليمات الطلاب، رصد الدرجات، وتقديم التغذية الراجعة بكفاءة.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <div class="group relative flex-1 min-w-[200px]">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition"></div>
                            <div class="relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input wire:model.live.debounce.300ms="search" placeholder="بحث بالعنوان، الطالب..." class="bg-transparent border-0 focus:ring-0 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 w-full">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Part: Filters (Merged) --}}
        <div class="relative z-10 bg-white/40 dark:bg-black/20 backdrop-blur-md border-t border-white/20 dark:border-white/5 p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="p-1.5 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg text-emerald-600 dark:text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">تصفية متقدمة</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Assignment Filter -->
                <div>
                    <select wire:model.live="filter_assignment_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع التكليفات</option>
                        @foreach($this->assignments as $assignment)
                            <option value="{{ $assignment->id }}">{{ $assignment->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Student Filter -->
                <div>
                    <select wire:model.live="filter_student_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع الطلاب</option>
                        @foreach($this->students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <select wire:model.live="filter_status" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع الحالات</option>
                        @foreach($statuses as $statusOption)
                            <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Submissions Grid --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            @php
                $colorThemes = [
                    ['gradient' => 'from-emerald-500 to-teal-500', 'border' => 'border-emerald-500', 'text' => 'text-emerald-500', 'overlay' => 'bg-gradient-to-br from-emerald-500/70 to-teal-500/70'],
                    ['gradient' => 'from-blue-500 to-cyan-500', 'border' => 'border-blue-500', 'text' => 'text-blue-500', 'overlay' => 'bg-gradient-to-br from-blue-500/70 to-cyan-500/70'],
                    ['gradient' => 'from-violet-500 to-purple-500', 'border' => 'border-violet-500', 'text' => 'text-violet-500', 'overlay' => 'bg-gradient-to-br from-violet-500/70 to-purple-500/70'],
                    ['gradient' => 'from-amber-500 to-orange-500', 'border' => 'border-amber-500', 'text' => 'text-amber-500', 'overlay' => 'bg-gradient-to-br from-amber-500/70 to-orange-500/70'],
                    ['gradient' => 'from-rose-500 to-pink-500', 'border' => 'border-rose-500', 'text' => 'text-rose-500', 'overlay' => 'bg-gradient-to-br from-rose-500/70 to-pink-500/70'],
                    ['gradient' => 'from-indigo-500 to-blue-500', 'border' => 'border-indigo-500', 'text' => 'text-indigo-500', 'overlay' => 'bg-gradient-to-br from-indigo-500/70 to-blue-500/70'],
                ];
            @endphp

            @forelse($submissions as $submission)
                @php
                    $theme = $colorThemes[$loop->index % count($colorThemes)];
                @endphp

                <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-500/10 dark:hover:shadow-emerald-900/30 hover:-translate-y-2 overflow-hidden">
                    {{-- Subtle Gradient Background --}}
                    <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-300 rounded-2xl"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        {{-- Header --}}
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-14 h-14 flex-shrink-0 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border {{ $theme['border'] }} shadow-sm group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 {{ $theme['text'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0-1.125.504-1.125 1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold {{ $theme['text'] }} mb-1">تسليم</p>
                                <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight line-clamp-2">{{ $submission->title ?? 'لا يوجد عنوان' }}</h3>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="space-y-3 flex-grow">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">الطالب</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium truncate max-w-[120px]" title="{{ $submission->student->name ?? 'غير محدد' }}">{{ $submission->student->name ?? 'غير محدد' }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">التكليف</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium truncate max-w-[120px]" title="{{ $submission->assignment->title ?? 'غير محدد' }}">{{ $submission->assignment->title ?? 'غير محدد' }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">الحالة</span>
                                @if($submission->status == 'pending')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300">
                                        في الانتظار
                                    </span>
                                @elseif($submission->status == 'submitted')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">
                                        تم التسليم
                                    </span>
                                @elseif($submission->status == 'graded')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300">
                                        تم التقييم
                                    </span>
                                @elseif($submission->status == 'rejected')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300">
                                        مرفوض
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">الدرجة</span>
                                @if($submission->grade)
                                    <span class="font-bold {{ $theme['text'] }}">{{ $submission->grade }}/100</span>
                                @else
                                    <span class="text-slate-400 dark:text-slate-500">--</span>
                                @endif
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700/50 flex justify-between items-center">
                            <span class="text-xs text-slate-400 dark:text-slate-500">{{ $submission->created_at->format('Y/m/d') }}</span>
                            
                            <div class="flex gap-2">
                                <button wire:click="viewSubmission({{ $submission->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-blue-500 hover:text-white transition-colors" title="عرض التفاصيل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button wire:click="openGradeForm({{ $submission->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-emerald-500 hover:text-white transition-colors" title="رصد الدرجة">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-slate-50 to-emerald-50 dark:from-zinc-800/50 dark:to-zinc-900/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700/50 backdrop-blur-sm">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-emerald-500 to-teal-500 rounded-full flex items-center justify-center mb-6 shadow-2xl shadow-emerald-500/30">
                        <svg class="w-14 h-14 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0-1.125.504-1.125 1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-zinc-800 dark:text-white mb-2">لا توجد تسليمات</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-6 max-w-md mx-auto">لم يقم الطلاب بتسليم أي مهام حتى الآن.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($submissions->hasPages())
    <div class="mt-8">
        {{ $submissions->links() }}
    </div>
    @endif

    {{-- Grade Modal --}}
    @if($showGradeForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-grade-form')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تقييم التسليم</h2>
                <button wire:click="resetGradeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="saveGrade" class="flex-grow p-6 space-y-5 overflow-y-auto">
                <div>
                    <label for="grade_value" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الدرجة <span class="text-red-500">*</span></label>
                    <input id="grade_value" wire:model="grade_value" type="number" min="0" max="100" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all" placeholder="أدخل الدرجة من 0 إلى 100">
                    @error('grade_value') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="feedback_text" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">ملاحظات (اختياري)</label>
                    <textarea id="feedback_text" wire:model="feedback_text" rows="4" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 resize-none transition-all" placeholder="أدخل ملاحظاتك على التسليم..."></textarea>
                    @error('feedback_text') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="resetGradeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="saveGrade" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-emerald-500/20">
                    <span wire:loading.remove wire:target="saveGrade">حفظ التقييم</span>
                    <span wire:loading wire:target="saveGrade">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- View Details Modal --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-view-modal')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تفاصيل التسليم: {{ $viewedSubmission->title ?? '' }}</h2>
                <button wire:click="closeViewModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-grow p-6 space-y-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">عنوان التسليم</p>
                            <p class="text-zinc-900 dark:text-white font-medium">{{ $viewedSubmission->title ?? 'لا يوجد عنوان' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الطالب</p>
                            <p class="text-zinc-900 dark:text-white font-medium">{{ $viewedSubmission->student->name ?? 'غير محدد' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">التكليف الأصلي</p>
                            <p class="text-zinc-900 dark:text-white font-medium">{{ $viewedSubmission->assignment->title ?? 'غير محدد' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المادة</p>
                            <p class="text-zinc-900 dark:text-white font-medium">{{ $viewedSubmission->assignment->course->name ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الدكتور المسؤول</p>
                            <p class="text-zinc-900 dark:text-white font-medium">{{ $viewedSubmission->assignment->doctor->name ?? 'غير محدد' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">حالة التسليم</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-sm font-bold 
                                @if($viewedSubmission->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300
                                @elseif($viewedSubmission->status == 'submitted') bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300
                                @elseif($viewedSubmission->status == 'graded') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300
                                @elseif($viewedSubmission->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300
                                @endif">
                                {{ __($viewedSubmission->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الدرجة</p>
                            <p class="text-xl font-bold text-zinc-900 dark:text-white">{{ $viewedSubmission->grade ?? '--' }} <span class="text-sm font-normal text-zinc-500">/ 100</span></p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">تاريخ التسليم</p>
                            <p class="text-zinc-900 dark:text-white font-medium">{{ $viewedSubmission->created_at->format('Y/m/d H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-2">وصف التسليم</p>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded-xl p-4 border border-zinc-100 dark:border-zinc-700">
                        <p class="text-zinc-900 dark:text-white leading-relaxed">{{ $viewedSubmission->description ?? 'لا يوجد وصف' }}</p>
                    </div>
                </div>

                @if($viewedSubmission->feedback)
                <div>
                    <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-2">ملاحظات الدكتور</p>
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-100 dark:border-blue-800">
                        <p class="text-zinc-900 dark:text-white leading-relaxed">{{ $viewedSubmission->feedback }}</p>
                    </div>
                </div>
                @endif

                <div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a2 2 0 00-2.828-2.828z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                        </svg>
                        الملفات المرفقة
                    </h3>
                    @if($viewedFiles->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($viewedFiles as $file)
                                <div class="group relative border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 bg-white dark:bg-zinc-800/50 hover:shadow-lg transition-all">
                                    @if(Str::startsWith($file->file_type, 'image'))
                                        <div class="aspect-video rounded-lg overflow-hidden mb-3 bg-zinc-100 dark:bg-zinc-700">
                                            <img src="{{ Storage::url($file->file_path) }}" alt="{{ $file->file_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        </div>
                                    @elseif(Str::startsWith($file->file_type, 'video'))
                                        <div class="aspect-video rounded-lg overflow-hidden mb-3 bg-zinc-100 dark:bg-zinc-700">
                                            <video controls class="w-full h-full object-cover">
                                                <source src="{{ Storage::url($file->file_path) }}" type="{{ $file->file_type }}">
                                                متصفحك لا يدعم الفيديو.
                                            </video>
                                        </div>
                                    @else
                                        <div class="aspect-video flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-lg mb-3 text-zinc-500 dark:text-zinc-400 group-hover:text-indigo-500 transition-colors">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <p class="text-zinc-800 dark:text-white font-semibold text-sm truncate" title="{{ $file->file_name }}">{{ $file->file_name ?? 'ملف بدون اسم' }}</p>
                                    <p class="text-zinc-600 dark:text-zinc-400 text-xs mt-1 truncate">{{ $file->description ?? 'لا يوجد وصف' }}</p>
                                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-xs mt-3 font-medium transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        عرض / تحميل
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-zinc-50 dark:bg-zinc-700/50 rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700">
                            <svg class="w-12 h-12 mx-auto text-zinc-400 dark:text-zinc-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-zinc-600 dark:text-zinc-400">لا توجد ملفات مرفقة بهذا التسليم.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex-shrink-0 p-4 flex justify-end bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeViewModal" class="px-6 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-medium transition-colors shadow-sm">إغلاق</button>
            </div>
        </div>
    </div>
    @endif

    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
