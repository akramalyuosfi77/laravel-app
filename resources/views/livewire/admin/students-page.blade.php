<div> {{-- هذا هو العنصر الجذري الوحيد الذي يحيط بكل المحتوى --}}

    {{-- 1. Hero Section المدمج مع الفلاتر --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-zinc-900 dark:via-slate-900 dark:to-zinc-900 border border-slate-200 dark:border-slate-800" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
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
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-full mb-4">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        <span class="text-sm font-bold text-blue-700 dark:text-blue-300">نظام إدارة الطلاب</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-blue-700 to-indigo-700 dark:from-slate-100 dark:via-blue-300 dark:to-indigo-300 mb-4 leading-tight" style="font-family: 'Questv1', sans-serif;">
                        إدارة الطلاب
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                        إدارة شاملة ومتقدمة لبيانات الطلاب وتسجيلهم في النظام التعليمي
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
                            <span>إضافة طالب</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Bottom Section: Filters --}}
            <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-6">
                <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                    </svg>
                    البحث والتصفية
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Batch Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">الدفعة</label>
                        <select wire:model.live="filter_batch_id"
                                class="w-full py-2.5 px-4 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm">
                            <option value="">جميع الدفعات</option>
                            @foreach($this->batches as $batch)
                                <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Academic Year Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">السنة</label>
                        <select wire:model.live="filter_academic_year"
                                class="w-full py-2.5 px-4 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm">
                            <option value="">جميع السنوات</option>
                            @foreach($academicYearsOptions as $year)
                                <option value="{{ $year }}">السنة {{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Semester Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">الترم</label>
                        <select wire:model.live="filter_semester"
                                class="w-full py-2.5 px-4 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm">
                            <option value="">جميع الترمات</option>
                            @foreach($semestersOptions as $sem)
                                <option value="{{ $sem }}">الترم {{ $sem }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">الحالة</label>
                        <select wire:model.live="filter_status"
                                class="w-full py-2.5 px-4 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm">
                            <option value="">جميع الحالات</option>
                            @foreach($statuses as $statusOption)
                                <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. شبكة البطاقات المتناسقة للطلاب --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            @forelse($students as $student)
                <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-slate-500/10 dark:hover:shadow-slate-900/30 hover:-translate-y-2 overflow-hidden">
                    {{-- Subtle Gradient Background --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                    
                    {{-- Decorative Corner --}}
                    <div class="absolute top-0 right-0 w-24 h-24 bg-slate-100/50 dark:bg-slate-700/30 rounded-bl-full opacity-50"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        {{-- Header with Image & Title --}}
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-16 h-16 flex-shrink-0 rounded-2xl overflow-hidden border-2 border-slate-200 dark:border-slate-700 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                @if($student->profile_image)
                                    <img class="w-full h-full object-cover"
                                         src="{{ Storage::url($student->profile_image) }}"
                                         alt="صورة الطالب">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <span class="inline-block px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-full text-xs font-bold mb-2">طالب</span>
                                <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" style="font-family: 'Questv1', sans-serif;">{{ $student->name }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-mono">{{ $student->student_id_number }}</p>
                            </div>
                        </div>

                        {{-- Details Grid --}}
                        <div class="flex-grow space-y-3 mb-5">
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>
                                    الدفعة
                                </span>
                                <span class="text-sm text-slate-800 dark:text-slate-200 font-bold">{{ $student->batch->name ?? 'غير محدد' }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                                    التخصص
                                </span>
                                <span class="text-sm text-slate-800 dark:text-slate-200 font-bold">{{ $student->batch->specialization->name ?? 'غير محدد' }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                                    القسم
                                </span>
                                <span class="text-sm text-slate-800 dark:text-slate-200 font-bold">{{ $student->batch->specialization->department->name ?? 'غير محدد' }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg text-center">
                                    <span class="text-xs text-green-600 dark:text-green-400 font-bold">السنة {{ $student->current_academic_year }}</span>
                                </div>
                                <div class="p-2 bg-orange-50 dark:bg-orange-900/20 rounded-lg text-center">
                                    <span class="text-xs text-orange-600 dark:text-orange-400 font-bold">الترم {{ $student->current_semester }}</span>
                                </div>
                            </div>

                            <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-center">
                                <span class="text-xs text-blue-600 dark:text-blue-400 font-bold">{{ $student->status }}</span>
                            </div>

                            @if($student->email)
                            <div class="p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">البريد الإلكتروني</span>
                                <p class="text-xs text-slate-700 dark:text-slate-300 break-all">{{ Str::limit($student->email, 30) }}</p>
                            </div>
                            @endif
                        </div>

                        {{-- Info Footer --}}
                        <div class="pb-4 mb-4 border-b border-slate-200 dark:border-slate-700/50">
                            <span class="text-xs text-slate-400 dark:text-slate-500">تم الإنشاء: {{ $student->created_at->format('Y/m/d') }}</span>
                        </div>

                        {{-- Action Buttons - Unified Color --}}
                            <div class="grid grid-cols-3 gap-2">
                                <button wire:click="toggleRepresentative({{ $student->id }})" 
                                    class="flex flex-col items-center gap-1.5 p-3 rounded-xl text-white transition-all hover:scale-105 shadow-md hover:shadow-lg {{ $student->is_representative ? 'bg-amber-500 hover:bg-amber-600' : 'bg-slate-400 hover:bg-slate-500' }}"
                                    title="{{ $student->is_representative ? 'إلغاء تعيين كمندوب' : 'تعيين كمندوب' }}">
                                    <svg class="w-5 h-5" fill="{{ $student->is_representative ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span class="text-xs font-bold">{{ $student->is_representative ? 'مندوب' : 'تعيين' }}</span>
                                </button>
                                <button wire:click="edit({{ $student->id }})" class="flex flex-col items-center gap-1.5 p-3 bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl text-white transition-all hover:scale-105 shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span class="text-xs font-bold">تعديل</span>
                                </button>
                                <button wire:click="confirmDelete({{ $student->id }})" class="flex flex-col items-center gap-1.5 p-3 bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 rounded-xl text-white transition-all hover:scale-105 shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span class="text-xs font-bold">حذف</span>
                                </button>
                            </div>
                    </div>
                </div>
            @empty
                {{-- حالة عدم وجود بيانات --}}
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-slate-50 to-blue-50 dark:from-zinc-800/50 dark:to-zinc-900/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700/50 backdrop-blur-sm">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center mb-6 shadow-2xl shadow-blue-500/30">
                        <svg class="w-14 h-14 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-zinc-800 dark:text-white mb-2">ابدأ ببناء قاعدة الطلاب</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-6 max-w-md mx-auto">لم تقم بإضافة أي طالب بعد. ابدأ الآن وأنشئ قاعدة بيانات الطلاب.</p>
                    <button wire:click="openForm" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:shadow-blue-500/40 hover:-translate-y-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>إضافة أول طالب</span>
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($students->hasPages())
    <div class="mt-8">
        {{ $students->links() }}
    </div>
    @endif

    {{-- النوافذ المنبثقة (Modals) بتصميم فخم بالألوان --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-form')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>

            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">{{ $edit_id ? 'تعديل بيانات الطالب' : 'إضافة طالب جديد' }}</h2>
                <button wire:click="closeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="flex-grow p-6 space-y-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- اسم الطالب -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">اسم الطالب <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            wire:model="name"
                            placeholder="أدخل اسم الطالب الكامل..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            required
                        >
                        @error('name') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- الرقم الجامعي -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الرقم الجامعي <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            wire:model="student_id_number"
                            placeholder="أدخل الرقم الجامعي..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            required
                        >
                        @error('student_id_number') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- البريد الإلكتروني -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">البريد الإلكتروني <span class="text-red-500">*</span></label>
                        <input
                            type="email"
                            wire:model="email"
                            placeholder="أدخل البريد الإلكتروني..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            required
                        >
                        @error('email') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- رقم الهاتف -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">رقم الهاتف (اختياري)</label>
                        <input
                            type="text"
                            wire:model="phone"
                            placeholder="أدخل رقم الهاتف..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                        >
                        @error('phone') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- الجنس -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الجنس (اختياري)</label>
                        <select
                            wire:model="gender"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                        >
                            <option value="">اختر الجنس</option>
                            <option value="ذكر">ذكر</option>
                            <option value="أنثى">أنثى</option>
                        </select>
                        @error('gender') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- تاريخ الميلاد -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">تاريخ الميلاد (اختياري)</label>
                        <input
                            type="date"
                            wire:model="date_of_birth"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                        >
                        @error('date_of_birth') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- العنوان -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">العنوان (اختياري)</label>
                        <input
                            type="text"
                            wire:model="address"
                            placeholder="أدخل العنوان..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                        >
                        @error('address') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- الصورة الشخصية -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الصورة الشخصية (اختياري)</label>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <input
                                    type="file"
                                    wire:model="profile_image"
                                    accept="image/*"
                                    class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300"
                                >
                            </div>
                            @if ($profile_image)
                                <img src="{{ $profile_image->temporaryUrl() }}" class="w-20 h-20 rounded-xl object-cover border border-zinc-200 dark:border-zinc-600">
                            @elseif ($old_profile_image)
                                <img src="{{ Storage::url($old_profile_image) }}" class="w-20 h-20 rounded-xl object-cover border border-zinc-200 dark:border-zinc-600">
                            @else
                                <div class="w-20 h-20 rounded-xl bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center border border-zinc-200 dark:border-zinc-600">
                                    <svg class="w-8 h-8 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        @error('profile_image') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- القسم -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">القسم <span class="text-red-500">*</span></label>
                        <select
                            wire:model.live="selected_department_id_for_form"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            required
                        >
                            <option value="">اختر القسم</option>
                            @foreach($this->departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('selected_department_id_for_form') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- التخصص -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">التخصص <span class="text-red-500">*</span></label>
                        <select
                            wire:model.live="selected_specialization_id_for_form"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                            required
                            @if(!$selected_department_id_for_form) disabled @endif
                        >
                            <option value="">اختر التخصص</option>
                            @foreach($this->formSpecializations as $spec)
                                <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                            @endforeach
                        </select>
                        @error('selected_specialization_id_for_form') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- الدفعة -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الدفعة <span class="text-red-500">*</span></label>
                        <select
                            wire:model.live="batch_id"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                            required
                            @if(!$selected_specialization_id_for_form) disabled @endif
                        >
                            <option value="">اختر الدفعة</option>
                            @foreach($this->formBatches as $batch)
                                <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                            @endforeach
                        </select>
                        @error('batch_id') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- السنة والترم المستنتجين -->
                    @if($inferred_academic_year && $inferred_semester)
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">السنة الدراسية (مستنتجة)</label>
                            <div class="flex items-center gap-3 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-green-800 dark:text-green-200 font-medium">السنة {{ $inferred_academic_year }}</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الترم (مستنتج)</label>
                            <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-blue-800 dark:text-blue-200 font-medium">الترم {{ $inferred_semester }}</span>
                            </div>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">السنة الدراسية (مستنتجة)</label>
                            <div class="flex items-center gap-3 p-4 bg-zinc-50 dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 rounded-xl">
                                <div class="w-8 h-8 bg-zinc-100 dark:bg-zinc-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-zinc-600 dark:text-zinc-400">اختر دفعة أولاً</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الترم (مستنتج)</label>
                            <div class="flex items-center gap-3 p-4 bg-zinc-50 dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 rounded-xl">
                                <div class="w-8 h-8 bg-zinc-100 dark:bg-zinc-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-zinc-600 dark:text-zinc-400">اختر دفعة أولاً</span>
                            </div>
                        </div>
                    @endif

                    <!-- الحالة -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الحالة <span class="text-red-500">*</span></label>
                        <select
                            wire:model="status"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            required
                        >
                            <option value="">اختر الحالة</option>
                            @foreach($statuses as $statusOption)
                                <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                            @endforeach
                        </select>
                        @error('status') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- حقول كلمة المرور -->
                    @if(!$edit_id)
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">كلمة المرور <span class="text-red-500">*</span></label>
                        <input
                            type="password"
                            wire:model="password"
                            placeholder="أدخل كلمة المرور..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            autocomplete="new-password"
                        >
                        @error('password') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">تأكيد كلمة المرور <span class="text-red-500">*</span></label>
                        <input
                            type="password"
                            wire:model="password_confirmation"
                            placeholder="أعد إدخال كلمة المرور..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            autocomplete="new-password"
                        >
                        @error('password_confirmation') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    @else
                    <div class="md:col-span-2 border-t pt-6 mt-6 border-zinc-200 dark:border-zinc-700">
                        <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">تغيير كلمة المرور (اختياري)</h4>
                                    <p class="text-xs text-yellow-700 dark:text-yellow-300">اتركها فارغة إذا كنت لا تريد تغيير كلمة المرور</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">كلمة المرور الجديدة</label>
                                <input
                                    type="password"
                                    wire:model="password"
                                    placeholder="كلمة المرور الجديدة..."
                                    class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                    autocomplete="new-password"
                                >
                                @error('password') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">تأكيد كلمة المرور الجديدة</label>
                                <input
                                    type="password"
                                    wire:model="password_confirmation"
                                    placeholder="تأكيد كلمة المرور الجديدة..."
                                    class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                    autocomplete="new-password"
                                >
                                @error('password_confirmation') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-indigo-500/20">
                    <span wire:loading.remove wire:target="save">{{ $edit_id ? 'حفظ التعديلات' : 'إضافة الطالب' }}</span>
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
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>

            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="mt-5 text-lg font-bold text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">تأكيد عملية الحذف</h3>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">هل أنت متأكد من حذف هذا الطالب؟ سيتم حذف جميع بياناته نهائياً. لا يمكن التراجع عن هذا الإجراء.</p>
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
