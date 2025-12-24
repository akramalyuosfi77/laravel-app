<div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
    {{-- 1. Hero Section المدمج - نفس تصميم صفحة الطلاب --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-zinc-900 dark:via-slate-900 dark:to-zinc-900 border border-slate-200 dark:border-slate-800" x-show="loaded" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
        {{-- Animated Background Orbs --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-10 right-10 w-72 h-72 bg-blue-400/20 dark:bg-blue-600/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-indigo-400/20 dark:bg-indigo-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 p-8">
            {{-- Top Section: Animation + Title + Actions --}}
            <div class="grid md:grid-cols-2 gap-8 items-center mb-8">
                {{-- Left Side: Animation --}}
                <div class="order-1 md:order-1 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                        <lottie-player
                            src="{{ asset('animations/abihe.json') }}"
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
                        <span class="text-sm font-bold text-blue-700 dark:text-blue-300">نظام إدارة متقدم</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-blue-700 to-indigo-700 dark:from-slate-100 dark:via-blue-300 dark:to-indigo-300 mb-4 leading-tight">
                        إدارة الدفعات الأكاديمية
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                        تنظيم، متابعة، وتحكم كامل في دفعات الطلاب بأسلوب احترافي وذكي
                    </p>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap gap-3">
                        <div class="group relative flex-1 min-w-[200px]">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition"></div>
                            <div class="relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input wire:model.live.debounce.300ms="search" placeholder="بحث سريع..." class="bg-transparent border-0 focus:ring-0 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 w-full">
                            </div>
                        </div>
                        
                        <button wire:click="openForm" class="group relative px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-2xl font-bold transition-all hover:scale-105 shadow-xl shadow-blue-500/30 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>إضافة دفعة</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Bottom Section: Filters --}}
            <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-6">
                <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                    </svg>
                    البحث والتصفية
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Department Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">القسم</label>
                        <select wire:model.live="filter_department_id"
                                class="w-full py-2.5 px-4 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm">
                            <option value="">كل الأقسام</option>
                            @foreach($this->departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Specialization Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">التخصص</label>
                        <select wire:model.live="filter_specialization_id"
                                class="w-full py-2.5 px-4 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm">
                            <option value="">كل التخصصات</option>
                            @foreach($this->filterSpecializations as $spec)
                                <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. شبكة البطاقات - تصميم بسيط موحد --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            @forelse($batches as $batch)
                <div class="group relative bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1.5">
                    {{-- Subtle gradient background --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 dark:from-blue-500/10 dark:to-indigo-500/10 rounded-2xl"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        {{-- Header with Icon --}}
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-14 h-14 flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 12l4.179 2.25M21.75 12l-4.179-2.25m0 4.5l4.179-2.25M17.571 12l-5.571 3-5.571-3" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-full text-xs font-bold mb-2">دفعة أكاديمية</span>
                                <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight">{{ $batch->name }}</h3>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="flex-grow space-y-3 mb-5">
                            <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-900/50 rounded-xl">
                                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                    التخصص
                                </span>
                                <span class="text-sm text-zinc-800 dark:text-zinc-200 font-bold">{{ $batch->specialization->name ?? 'غير محدد' }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-900/50 rounded-xl">
                                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                    القسم
                                </span>
                                <span class="text-sm text-zinc-800 dark:text-zinc-200 font-bold">{{ $batch->specialization->department->name ?? 'غير محدد' }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-900/50 rounded-xl">
                                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>
                                    سنة البدء
                                </span>
                                <span class="text-sm text-zinc-800 dark:text-zinc-200 font-bold">{{ $batch->start_year }}</span>
                            </div>
                            <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-center">
                                <span class="text-xs text-blue-600 dark:text-blue-400 font-bold">السنة {{ $batch->academic_year }} - الترم {{ $batch->semester }}</span>
                            </div>
                        </div>

                        {{-- Info Footer --}}
                        <div class="pb-4 mb-4 border-t border-zinc-200 dark:border-zinc-700/50 pt-4">
                            <span class="text-xs text-zinc-400 dark:text-zinc-500">تم الإنشاء: {{ $batch->created_at->format('Y/m/d') }}</span>
                        </div>

                        {{-- Action Buttons - Unified Color --}}
                        <div class="grid grid-cols-3 gap-2">
                            <button wire:click="viewBatch({{ $batch->id }})" class="flex flex-col items-center gap-1.5 p-3 bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl text-white transition-all hover:scale-105 shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span class="text-xs font-bold">عرض</span>
                            </button>
                            <button wire:click="edit({{ $batch->id }})" class="flex flex-col items-center gap-1.5 p-3 bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl text-white transition-all hover:scale-105 shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span class="text-xs font-bold">تعديل</span>
                            </button>
                            <button wire:click="confirmDelete({{ $batch->id }})" class="flex flex-col items-center gap-1.5 p-3 bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 rounded-xl text-white transition-all hover:scale-105 shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span class="text-xs font-bold">حذف</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-blue-300 dark:border-zinc-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 12l4.179 2.25M21.75 12l-4.179-2.25m0 4.5l4.179-2.25M17.571 12l-5.571 3-5.571-3" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">ابدأ رحلة جديدة</h3>
                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">لم تقم بإضافة أي دفعة بعد. ابدأ الآن لتنظيم المسار الأكاديمي للطلاب.</p>
                    <button wire:click="openForm" class="mt-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 mx-auto shadow-md shadow-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>إضافة أول دفعة</span>
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($batches->hasPages())
    <div class="mt-8">
        {{ $batches->links() }}
    </div>
    @endif

    {{-- Form Modal - نفس التصميم القديم بدون تغيير --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-form')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $edit_id ? 'تعديل الدفعة' : 'إضافة دفعة جديدة' }}</h2>
                <button wire:click="closeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="flex-grow p-6 space-y-5 overflow-y-auto">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">اسم الدفعة <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="name" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                    @error('name') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">سنة البدء <span class="text-red-500">*</span></label>
                    <input type="number" wire:model="start_year" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                    @error('start_year') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">القسم <span class="text-red-500">*</span></label>
                    <select wire:model.live="selected_department_id_for_form" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                        <option value="">اختر القسم</option>
                        @foreach($this->departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    @error('selected_department_id_for_form') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">التخصص <span class="text-red-500">*</span></label>
                    <select wire:model="specialization_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required @if(!$selected_department_id_for_form) disabled @endif>
                        <option value="">اختر التخصص</option>
                        @foreach($this->formSpecializations as $spec)
                            <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                        @endforeach
                    </select>
                    @error('specialization_id') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">السنة الدراسية الحالية <span class="text-red-500">*</span></label>
                    <select wire:model="academic_year" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                        <option value="">اختر السنة</option>
                        @foreach($academicYearsOptions as $year)
                            <option value="{{ $year }}">السنة {{ $year }}</option>
                        @endforeach
                    </select>
                    @error('academic_year') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الترم الحالي <span class="text-red-500">*</span></label>
                    <select wire:model="semester" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                        <option value="">اختر الترم</option>
                        @foreach($semestersOptions as $sem)
                            <option value="{{ $sem }}">الترم {{ $sem }}</option>
                        @endforeach
                    </select>
                    @error('semester') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-indigo-500/20">
                    <span wire:loading.remove wire:target="save">{{ $edit_id ? 'حفظ التعديلات' : 'إنشاء الدفعة' }}</span>
                    <span wire:loading wire:target="save">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Delete Confirmation Modal - نفس التصميم القديم --}}
    @if($delete_id)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.set('delete_id', null)" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                </div>
                <h3 class="mt-5 text-lg font-bold text-zinc-900 dark:text-white">تأكيد عملية الحذف</h3>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">هل أنت متأكد من حذف هذه الدفعة؟ لا يمكن التراجع عن هذا الإجراء.</p>
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

    {{-- View Details Modal - نفس التصميم القديم بدون تغيير --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('closeViewModal')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تفاصيل الدفعة: {{ $viewedBatch->name ?? '' }}</h2>
                <button wire:click="closeViewModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-grow p-6 space-y-6 overflow-y-auto">
                <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-base font-bold text-indigo-600 dark:text-indigo-400 mb-3">معلومات أساسية</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="font-semibold text-zinc-500 dark:text-zinc-400">اسم الدفعة:</p>
                            <p class="text-zinc-800 dark:text-zinc-200 font-medium">{{ $viewedBatch->name ?? '' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-zinc-500 dark:text-zinc-400">سنة البدء:</p>
                            <p class="text-zinc-800 dark:text-zinc-200 font-medium">{{ $viewedBatch->start_year ?? '' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-zinc-500 dark:text-zinc-400">التخصص:</p>
                            <p class="text-zinc-800 dark:text-zinc-200 font-medium">{{ $viewedBatch->specialization->name ?? 'غير محدد' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-zinc-500 dark:text-zinc-400">القسم:</p>
                            <p class="text-zinc-800 dark:text-zinc-200 font-medium">{{ $viewedBatch->specialization->department->name ?? 'غير محدد' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-zinc-500 dark:text-zinc-400">السنة الحالية:</p>
                            <p class="text-zinc-800 dark:text-zinc-200 font-medium">{{ $viewedBatch->academic_year ?? '' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-zinc-500 dark:text-zinc-400">الترم الحالي:</p>
                            <p class="text-zinc-800 dark:text-zinc-200 font-medium">{{ $viewedBatch->semester ?? '' }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-base font-bold text-teal-600 dark:text-teal-400 mb-3">المواد المخصصة</h3>
                    @if($viewedCourses->isNotEmpty())
                        <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
                            <table class="w-full text-sm text-right">
                                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                    <tr>
                                        <th class="p-3 font-semibold text-zinc-600 dark:text-zinc-300">اسم المادة</th>
                                        <th class="p-3 font-semibold text-zinc-600 dark:text-zinc-300">الرمز</th>
                                        <th class="p-3 font-semibold text-zinc-600 dark:text-zinc-300">النوع</th>
                                        <th class="p-3 font-semibold text-zinc-600 dark:text-zinc-300">الدكتور</th>
                                        <th class="p-3 font-semibold text-zinc-600 dark:text-zinc-300">الوصف</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                    @foreach($viewedCourses as $course)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                            <td class="p-3 text-zinc-800 dark:text-zinc-200">{{ $course->name }}</td>
                                            <td class="p-3 text-zinc-500 dark:text-zinc-400">{{ $course->code }}</td>
                                            <td class="p-3 text-zinc-500 dark:text-zinc-400">{{ $course->type }}</td>
                                            <td class="p-3 text-zinc-800 dark:text-zinc-200">{{ $course->doctor_name ?? 'غير محدد' }}</td>
                                            <td class="p-3 text-zinc-500 dark:text-zinc-400 max-w-xs truncate">{{ $course->description ?? 'لا يوجد' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-zinc-500 dark:text-zinc-400 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-dashed dark:border-zinc-700">لا توجد مواد مخصصة لهذه الدفعة في مستواها الحالي.</div>
                    @endif
                </div>

                <div>
                    <h3 class="text-base font-bold text-amber-600 dark:text-amber-400 mb-3">الطلاب المرتبطون</h3>
                    @if($viewedStudents->isNotEmpty())
                        <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
                            <table class="w-full text-sm text-right">
                                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                    <tr>
                                        <th class="p-3 font-semibold text-zinc-600 dark:text-zinc-300">الطالب</th>
                                        <th class="p-3 font-semibold text-zinc-600 dark:text-zinc-300">الرقم الجامعي</th>
                                        <th class="p-3 font-semibold text-zinc-600 dark:text-zinc-300">البريد الإلكتروني</th>
                                        <th class="p-3 font-semibold text-zinc-600 dark:text-zinc-300">الحالة</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                    @foreach($viewedStudents as $student)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                            <td class="p-3 text-zinc-800 dark:text-zinc-200 flex items-center gap-3">
                                                @if($student->profile_image)
                                                    <img src="{{ Storage::url($student->profile_image) }}" alt="صورة الطالب" class="w-8 h-8 rounded-full object-cover">
                                                @else
                                                    <div class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-xs text-zinc-500"></div>
                                                @endif
                                                <span>{{ $student->name }}</span>
                                            </td>
                                            <td class="p-3 text-zinc-500 dark:text-zinc-400">{{ $student->student_id_number }}</td>
                                            <td class="p-3 text-zinc-500 dark:text-zinc-400">{{ $student->email ?? 'لا يوجد' }}</td>
                                            <td class="p-3">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300">{{ $student->status }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-zinc-500 dark:text-zinc-400 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-dashed dark:border-zinc-700">لا يوجد طلاب مرتبطون بهذه الدفعة.</div>
                    @endif
                </div>
            </div>

            <div class="flex-shrink-0 p-4 flex justify-end bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeViewModal" class="px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إغلاق</button>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endpush
