<div>
    {{-- 1. Combined Hero & Filters Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50 dark:from-zinc-900 dark:via-slate-900 dark:to-zinc-900 border border-slate-200 dark:border-slate-800 shadow-xl" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
        {{-- Animated Background Orbs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-10 right-10 w-72 h-72 bg-blue-400/20 dark:bg-blue-600/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-cyan-400/20 dark:bg-cyan-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        {{-- Top Part: Hero Content --}}
        <div class="relative z-10 p-8 pb-10">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                {{-- Left Side: Animation --}}
                <div class="order-1 md:order-1 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                        <lottie-player
                            src="/animations/data analysis.json"
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
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-full mb-4">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        <span class="text-sm font-bold text-blue-700 dark:text-blue-300">المحتوى الأكاديمي</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-blue-700 to-cyan-700 dark:from-slate-100 dark:via-blue-300 dark:to-cyan-300 mb-4 leading-tight">
                        إدارة المواد الدراسية
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-300 mb-8 leading-relaxed">
                        إدارة شاملة للمقررات الدراسية، الخطط، والمحتوى التعليمي في مكان واحد.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <div class="group relative flex-1 min-w-[200px]">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition"></div>
                            <div class="relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input wire:model.live.debounce.300ms="search" placeholder="بحث عن مادة..." class="bg-transparent border-0 focus:ring-0 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 w-full">
                            </div>
                        </div>
                        
                        <button wire:click="openForm" class="group relative px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white rounded-2xl font-bold transition-all hover:scale-105 shadow-xl shadow-blue-500/30 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>إضافة مادة</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Part: Filters (Merged) --}}
        <div class="relative z-10 bg-white/40 dark:bg-black/20 backdrop-blur-md border-t border-white/20 dark:border-white/5 p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="p-1.5 bg-blue-100 dark:bg-blue-900/50 rounded-lg text-blue-600 dark:text-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">تصفية متقدمة</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Department Filter -->
                <div>
                    <select wire:model.live="filter_department_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع الأقسام</option>
                        @foreach($this->departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Specialization Filter -->
                <div>
                    <select wire:model.live="filter_specialization_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع التخصصات</option>
                        @foreach($this->filterSpecializations as $spec)
                            <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Academic Year Filter -->
                <div>
                    <select wire:model.live="filter_academic_year" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع السنوات</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year }}">السنة {{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Semester Filter -->
                <div>
                    <select wire:model.live="filter_semester" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع الترمات</option>
                        @foreach($semesters as $sem)
                            <option value="{{ $sem }}">الترم {{ $sem }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Courses Grid --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            @php
                $colorThemes = [
                    ['gradient' => 'from-indigo-500 to-purple-500', 'border' => 'border-indigo-500', 'text' => 'text-indigo-500', 'overlay' => 'bg-gradient-to-br from-indigo-500/70 to-purple-500/70'],
                    ['gradient' => 'from-teal-500 to-emerald-500', 'border' => 'border-teal-500', 'text' => 'text-teal-500', 'overlay' => 'bg-gradient-to-br from-teal-500/70 to-emerald-500/70'],
                    ['gradient' => 'from-amber-500 to-orange-500', 'border' => 'border-amber-500', 'text' => 'text-amber-500', 'overlay' => 'bg-gradient-to-br from-amber-500/70 to-orange-500/70'],
                    ['gradient' => 'from-rose-500 to-pink-500', 'border' => 'border-rose-500', 'text' => 'text-rose-500', 'overlay' => 'bg-gradient-to-br from-rose-500/70 to-pink-500/70'],
                    ['gradient' => 'from-blue-500 to-cyan-500', 'border' => 'border-blue-500', 'text' => 'text-blue-500', 'overlay' => 'bg-gradient-to-br from-blue-500/70 to-cyan-500/70'],
                    ['gradient' => 'from-violet-500 to-fuchsia-500', 'border' => 'border-violet-500', 'text' => 'text-violet-500', 'overlay' => 'bg-gradient-to-br from-violet-500/70 to-fuchsia-500/70'],
                ];
            @endphp

            @forelse($courses as $course)
                @php
                    $theme = $colorThemes[$loop->index % count($colorThemes)];
                @endphp

                <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-blue-500/10 dark:hover:shadow-blue-900/30 hover:-translate-y-2 overflow-hidden">
                    {{-- Subtle Gradient Background --}}
                    <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-300 rounded-2xl"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        {{-- Header --}}
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-14 h-14 flex-shrink-0 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border {{ $theme['border'] }} shadow-sm group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 {{ $theme['text'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold {{ $theme['text'] }} mb-1">{{ $course->code }}</p>
                                <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight line-clamp-2">{{ $course->name }}</h3>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="space-y-3 flex-grow">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">النوع</span>
                                <span class="px-2 py-0.5 rounded-lg text-xs font-bold {{ $course->type == 'نظرى' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300' : 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300' }}">
                                    {{ $course->type }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">المستوى</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium">سنة {{ $course->academic_year }} / ترم {{ $course->semester }}</span>
                            </div>

                            @if($course->specialization_name)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">التخصص</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium truncate max-w-[120px]" title="{{ $course->specialization_name }}">{{ $course->specialization_name }}</span>
                            </div>
                            @endif

                            @if($course->doctor_name)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">الدكتور</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium truncate max-w-[120px]" title="{{ $course->doctor_name }}">{{ $course->doctor_name }}</span>
                            </div>
                            @endif
                        </div>

                        {{-- Footer --}}
                        <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700/50 flex justify-between items-center">
                            <span class="text-xs text-slate-400 dark:text-slate-500">{{ $course->created_at->format('Y/m/d') }}</span>
                            
                            <div class="flex gap-2">
                                <button wire:click="edit({{ $course->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-blue-500 hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button wire:click="confirmDelete({{ $course->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-red-500 hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-slate-50 to-blue-50 dark:from-zinc-800/50 dark:to-zinc-900/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700/50 backdrop-blur-sm">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mb-6 shadow-2xl shadow-blue-500/30">
                        <svg class="w-14 h-14 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-zinc-800 dark:text-white mb-2">ابدأ رحلة التعلم</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-6 max-w-md mx-auto">لم تقم بإضافة أي مادة بعد. ابدأ الآن وأنشئ محتوى تعليمي متميز.</p>
                    <button wire:click="openForm" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:shadow-blue-500/40 hover:-translate-y-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>إضافة أول مادة</span>
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($courses->hasPages())
    <div class="mt-8">
        {{ $courses->links() }}
    </div>
    @endif

    {{-- Add/Edit Modal --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-form')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $edit_id ? 'تعديل المادة' : 'إضافة مادة جديدة' }}</h2>
                <button wire:click="closeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="flex-grow p-6 space-y-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">اسم المادة <span class="text-red-500">*</span></label>
                        <input wire:model="name" type="text" placeholder="أدخل اسم المادة" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @error('name') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">رمز المادة <span class="text-red-500">*</span></label>
                        <input wire:model="code" type="text" placeholder="مثال: CS101" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @error('code') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">نوع المادة <span class="text-red-500">*</span></label>
                        <select wire:model="type" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">اختر النوع</option>
                            <option value="نظرى">نظرى</option>
                            <option value="عملى">عملى</option>
                        </select>
                        @error('type') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">القسم <span class="text-red-500">*</span></label>
                        <select wire:model.live="selected_department_id_for_form" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">اختر القسم</option>
                            @foreach($this->departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('selected_department_id_for_form') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">التخصص <span class="text-red-500">*</span></label>
                        <select wire:model.live="specialization_id" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all {{ !$selected_department_id_for_form ? 'opacity-50 cursor-not-allowed' : '' }}" @if(!$selected_department_id_for_form) disabled @endif>
                            <option value="">اختر التخصص</option>
                            @foreach($this->formSpecializations as $spec)
                                <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                            @endforeach
                        </select>
                        @error('specialization_id') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                            الدكتور المسؤول <span class="text-red-500">*</span>
                            <span class="text-xs text-blue-500">({{ count($this->doctors) }} دكتور متاح)</span>
                        </label>
                        <select wire:model.live="doctor_id" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">اختر الدكتور</option>
                            @forelse($this->doctors as $doc)
                                <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                            @empty
                                <option value="" disabled>لا يوجد دكاترة في النظام</option>
                            @endforelse
                        </select>
                        @error('doctor_id') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">السنة الدراسية <span class="text-red-500">*</span></label>
                        <select wire:model="academic_year" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">اختر السنة</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year }}">السنة {{ $year }}</option>
                            @endforeach
                        </select>
                        @error('academic_year') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">الترم <span class="text-red-500">*</span></label>
                        <select wire:model="semester" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">اختر الترم</option>
                            @foreach($semesters as $sem)
                                <option value="{{ $sem }}">الترم {{ $sem }}</option>
                            @endforeach
                        </select>
                        @error('semester') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">الوصف (اختياري)</label>
                    <textarea wire:model="description" rows="4" placeholder="أدخل وصف المادة..." class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none transition-all"></textarea>
                    @error('description') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-blue-500/20">
                    <span wire:loading.remove wire:target="save">{{ $edit_id ? 'حفظ التعديلات' : 'إنشاء المادة' }}</span>
                    <span wire:loading wire:target="save">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if($delete_id)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.set('delete_id', null)" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                </div>
                <h3 class="mt-5 text-lg font-bold text-zinc-900 dark:text-white">تأكيد عملية الحذف</h3>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">هل أنت متأكد من حذف هذه المادة؟ لا يمكن التراجع عن هذا الإجراء.</p>
            </div>
            <div class="p-4 flex flex-col-reverse sm:flex-row gap-3 bg-zinc-50 dark:bg-zinc-800/50">
                <button wire:click="$set('delete_id', null)" class="w-full sm:w-1/2 px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button wire:click="delete" class="w-full sm:w-1/2 px-4 py-2.5 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-red-500/20">
                    <span wire:loading.remove wire:target="delete">نعم، قم بالحذف</span>
                    <span wire:loading wire:target="delete">جاري الحذف...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
