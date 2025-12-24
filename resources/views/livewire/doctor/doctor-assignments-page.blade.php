<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

        {{-- 1. Hero Section المدمج مع الفلاتر --}}
        <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50 dark:from-zinc-900 dark:via-purple-900/20 dark:to-indigo-900/20 border border-slate-200 dark:border-slate-800" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
            {{-- Animated Background Orbs --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-10 right-10 w-72 h-72 bg-purple-400/20 dark:bg-purple-600/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-10 left-10 w-96 h-96 bg-indigo-400/20 dark:bg-indigo-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 p-8">
                {{-- Top Section: Animation + Title + Actions --}}
                <div class="grid md:grid-cols-2 gap-8 items-center mb-8">
                    {{-- Left Side: Animation --}}
                    <div class="order-1 md:order-1 flex justify-center">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
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
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 dark:bg-purple-900/30 border border-purple-200 dark:border-purple-800 rounded-full mb-4">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                            </span>
                            <span class="text-sm font-bold text-purple-700 dark:text-purple-300">بوابة المحاضر</span>
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-purple-700 to-indigo-700 dark:from-slate-100 dark:via-purple-300 dark:to-indigo-300 mb-4 leading-tight" style="font-family: 'Questv1', sans-serif;">
                            إدارة التكليفات
                        </h1>
                        <p class="text-lg text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                            قم بإنشاء وإدارة التكليفات الدراسية ومتابعة تسليمات الطلاب بكل سهولة
                        </p>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-3">
                            <div class="group relative flex-1 min-w-[200px]">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition"></div>
                                <div class="relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <input wire:model.live.debounce.300ms="search" placeholder="بحث عن تكليف..." class="bg-transparent border-0 focus:ring-0 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 w-full">
                                </div>
                            </div>
                            
                            <button wire:click="openAssignmentForm" class="group relative px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-2xl font-bold transition-all hover:scale-105 shadow-xl shadow-purple-500/30 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>إضافة تكليف</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Bottom Section: Filters --}}
                <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-6">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                        </svg>
                        تصفية التكليفات
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Course Filter -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">المادة الدراسية</label>
                            <select wire:model.live="filter_course_id"
                                    class="w-full py-2.5 px-4 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm">
                                <option value="">جميع المواد</option>
                                @foreach($this->doctorCourses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Assignments Grid --}}
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                <span class="w-2 h-8 bg-purple-600 rounded-full inline-block"></span>
                التكليفات الحالية
            </h2>

            <div wire:loading.class.delay="opacity-50" class="transition-opacity">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($assignments as $assignment)
                        <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-purple-500/10 dark:hover:shadow-purple-900/30 hover:-translate-y-2 overflow-hidden">
                            {{-- Subtle Gradient Background --}}
                            <div class="absolute inset-0 bg-gradient-to-br from-slate-50 to-purple-50 dark:from-slate-900 dark:to-slate-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                            
                            <div class="relative z-10 flex flex-col h-full">
                                {{-- Header --}}
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="w-14 h-14 flex-shrink-0 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="inline-block px-2.5 py-0.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-xs font-bold mb-1 truncate max-w-full">
                                            {{ $assignment->course->name ?? 'مادة غير محددة' }}
                                        </span>
                                        <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight truncate group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors" style="font-family: 'Questv1', sans-serif;">
                                            {{ $assignment->title }}
                                        </h3>
                                    </div>
                                </div>

                                {{-- Details --}}
                                <div class="flex-grow space-y-3 mb-5">
                                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 bg-slate-50 dark:bg-slate-900/50 p-3 rounded-xl border border-slate-100 dark:border-slate-800">
                                        {{ $assignment->description ?: 'لا يوجد وصف' }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            آخر موعد
                                        </span>
                                        <span class="text-sm text-slate-800 dark:text-slate-200 font-bold dir-ltr">
                                            {{ $assignment->deadline->format('Y-m-d H:i') }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="grid grid-cols-2 gap-2 mt-auto">
                                    <button wire:click="editAssignment({{ $assignment->id }})" class="flex items-center justify-center gap-2 p-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl text-slate-700 dark:text-slate-200 transition-all hover:scale-105">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span class="text-xs font-bold">تعديل</span>
                                    </button>
                                    <button wire:click="confirmDeleteAssignment({{ $assignment->id }})" class="flex items-center justify-center gap-2 p-2.5 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 rounded-xl text-red-600 dark:text-red-400 transition-all hover:scale-105">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="text-xs font-bold">حذف</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full p-12 text-center bg-white/50 dark:bg-zinc-800/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700 backdrop-blur-sm">
                            <div class="w-20 h-20 mx-auto bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-2">لا توجد تكليفات</h3>
                            <p class="text-zinc-500 dark:text-zinc-400 mb-6">لم تقم بإضافة أي تكليفات بعد.</p>
                            <button wire:click="openAssignmentForm" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl font-bold transition-all">
                                <span>إضافة أول تكليف</span>
                            </button>
                        </div>
                    @endforelse
                </div>
                
                @if($assignments->hasPages())
                    <div class="mt-8">
                        {{ $assignments->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- 3. Submissions Section --}}
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                <span class="w-2 h-8 bg-indigo-600 rounded-full inline-block"></span>
                تسليمات الطلاب
            </h2>

            {{-- Submissions Filters --}}
            <div class="mb-6 bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <select wire:model.live="filter_submission_status" class="w-full py-2.5 px-4 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                        <option value="">جميع الحالات</option>
                        @foreach($submissionStatuses as $statusOption)
                            <option value="{{ $statusOption }}">{{ __($statusOption) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Submissions Grid --}}
            <div wire:loading.class.delay="opacity-50" class="transition-opacity">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse ($submissions as $submission)
                        <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-500/10 dark:hover:shadow-indigo-900/30 hover:-translate-y-2 overflow-hidden">
                            {{-- Subtle Gradient Background --}}
                            <div class="absolute inset-0 bg-gradient-to-br from-slate-50 to-indigo-50 dark:from-slate-900 dark:to-slate-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                            
                            <div class="relative z-10 flex flex-col h-full">
                                {{-- Header --}}
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="w-14 h-14 flex-shrink-0 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="inline-block px-2.5 py-0.5 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-bold mb-1 truncate max-w-full">
                                            {{ $submission->assignment->course->name ?? 'مادة غير محددة' }}
                                        </span>
                                        <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors" style="font-family: 'Questv1', sans-serif;">
                                            {{ $submission->student->name ?? 'طالب غير محدد' }}
                                        </h3>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $submission->assignment->title ?? 'تكليف غير محدد' }}</p>
                                    </div>
                                </div>

                                {{-- Details --}}
                                <div class="flex-grow space-y-3 mb-5">
                                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            تاريخ التسليم
                                        </span>
                                        <span class="text-sm text-slate-800 dark:text-slate-200 font-bold dir-ltr">
                                            {{ $submission->created_at->format('Y-m-d H:i') }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">الحالة</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                            @if($submission->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                            @elseif($submission->status == 'submitted') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                            @elseif($submission->status == 'graded') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                            @elseif($submission->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                            @endif">
                                            {{ __($submission->status) }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            الدرجة
                                        </span>
                                        <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                            {{ $submission->grade ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="grid grid-cols-2 gap-2 mt-auto">
                                    <button wire:click="viewSubmission({{ $submission->id }})" class="flex items-center justify-center gap-2 p-2.5 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 rounded-xl text-blue-600 dark:text-blue-400 transition-all hover:scale-105">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span class="text-xs font-bold">عرض</span>
                                    </button>
                                    <button wire:click="openGradeForm({{ $submission->id }})" class="flex items-center justify-center gap-2 p-2.5 bg-green-50 hover:bg-green-100 dark:bg-green-900/20 dark:hover:bg-green-900/40 rounded-xl text-green-600 dark:text-green-400 transition-all hover:scale-105">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span class="text-xs font-bold">تقييم</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full p-12 text-center bg-white/50 dark:bg-zinc-800/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700 backdrop-blur-sm">
                            <div class="w-20 h-20 mx-auto bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-2">لا توجد تسليمات</h3>
                            <p class="text-zinc-500 dark:text-zinc-400">لا توجد تسليمات من الطلاب حتى الآن.</p>
                        </div>
                    @endforelse
                </div>
                
                @if($submissions->hasPages())
                    <div class="mt-8">
                        {{ $submissions->links('livewire::bootstrap') }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Modals --}}
        
        {{-- Create/Edit Assignment Modal --}}
        @if($showForm)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.closeAssignmentForm()" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
                <div class="h-2 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-t-2xl"></div>
                
                <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">{{ $edit_id ? 'تعديل التكليف' : 'إضافة تكليف جديد' }}</h2>
                    <button wire:click="closeAssignmentForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveAssignment" class="flex-grow p-6 space-y-6 overflow-y-auto">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">عنوان التكليف <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="title" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-purple-500 transition-all" placeholder="مثال: الواجب الأول">
                        @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">المادة <span class="text-red-500">*</span></label>
                        <select wire:model="course_id" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-purple-500 transition-all">
                            <option value="">اختر المادة</option>
                            @foreach($this->doctorCourses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">موعد التسليم <span class="text-red-500">*</span></label>
                        <input type="datetime-local" wire:model="deadline" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-purple-500 transition-all">
                        @error('deadline') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الوصف</label>
                        <textarea wire:model="description" rows="4" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-purple-500 transition-all" placeholder="تفاصيل التكليف..."></textarea>
                        @error('description') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </form>

                <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                    <button type="button" wire:click="closeAssignmentForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                    <button type="button" wire:click="saveAssignment" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md">
                        <span wire:loading.remove wire:target="saveAssignment">{{ $edit_id ? 'حفظ التعديلات' : 'إنشاء التكليف' }}</span>
                        <span wire:loading wire:target="saveAssignment">جاري الحفظ...</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- Delete Confirmation Modal --}}
        @if($edit_id && !$showForm)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.set('edit_id', null)" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
                <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>
                <div class="p-6 text-center">
                    <div class="w-16 h-16 mx-auto bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2" style="font-family: 'Questv1', sans-serif;">تأكيد الحذف</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 text-sm">هل أنت متأكد من حذف هذا التكليف؟ سيتم حذف جميع التسليمات المرتبطة به.</p>
                </div>
                <div class="p-4 flex flex-col-reverse sm:flex-row gap-3 bg-zinc-50 dark:bg-zinc-800/50">
                    <button wire:click="$set('edit_id', null)" class="w-full sm:w-1/2 px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                    <button wire:click="deleteAssignment" class="w-full sm:w-1/2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors shadow-md">
                        <span wire:loading.remove wire:target="deleteAssignment">نعم، حذف</span>
                        <span wire:loading wire:target="deleteAssignment">جاري الحذف...</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- Grade Modal --}}
        @if($showGradeForm)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.resetGradeForm()" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-lg border border-zinc-200 dark:border-zinc-700">
                <div class="h-2 bg-gradient-to-r from-green-500 to-emerald-500 rounded-t-2xl"></div>
                <div class="p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">تقييم التسليم</h2>
                    <button wire:click="resetGradeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form wire:submit.prevent="saveGrade" class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الدرجة (من 100)</label>
                        <input type="number" wire:model="grade_value" min="0" max="100" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 transition-all">
                        @error('grade_value') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">ملاحظات</label>
                        <textarea wire:model="feedback_text" rows="4" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 transition-all"></textarea>
                        @error('feedback_text') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </form>
                <div class="p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                    <button wire:click="resetGradeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                    <button wire:click="saveGrade" class="w-full sm:w-auto px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors shadow-md">
                        <span wire:loading.remove wire:target="saveGrade">حفظ التقييم</span>
                        <span wire:loading wire:target="saveGrade">جاري الحفظ...</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- View Submission Modal --}}
        @if($showViewSubmissionModal)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.closeViewSubmissionModal()" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
                <div class="h-2 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-t-2xl"></div>
                <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">تفاصيل التسليم</h2>
                    <button wire:click="closeViewSubmissionModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-grow p-6 overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">الطالب</span>
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $viewedSubmission->student->name ?? '-' }}</span>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">التكليف</span>
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $viewedSubmission->assignment->title ?? '-' }}</span>
                        </div>
                        <div class="col-span-full bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">الوصف</span>
                            <p class="text-zinc-800 dark:text-zinc-200 whitespace-pre-line">{{ $viewedSubmission->description ?? 'لا يوجد وصف' }}</p>
                        </div>
                    </div>

                    <h3 class="font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        الملفات المرفقة
                    </h3>
                    
                    @if($viewedFiles && $viewedFiles->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($viewedFiles as $file)
                                <div class="group relative bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden hover:shadow-lg transition-all">
                                    <div class="aspect-video bg-zinc-100 dark:bg-zinc-900 flex items-center justify-center">
                                        @if(Str::startsWith($file->file_type, 'image'))
                                            <img src="{{ Storage::url($file->file_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-12 h-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <p class="text-sm font-bold text-zinc-900 dark:text-white truncate mb-1">{{ $file->file_name }}</p>
                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">عرض الملف</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-zinc-500 dark:text-zinc-400 bg-zinc-50 dark:bg-zinc-900/50 rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700">
                            لا توجد ملفات مرفقة
                        </div>
                    @endif
                </div>
                <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end">
                    <button wire:click="closeViewSubmissionModal" class="px-5 py-2.5 bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 rounded-lg font-medium hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors">إغلاق</button>
                </div>
            </div>
        </div>
        @endif

    </div>
    
    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
