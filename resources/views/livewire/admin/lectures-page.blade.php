<div>
    {{-- 1. Combined Hero & Filters Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-zinc-900 dark:via-slate-900 dark:to-zinc-900 border border-slate-200 dark:border-slate-800 shadow-xl" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
        {{-- Animated Background Orbs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-10 right-10 w-72 h-72 bg-blue-400/20 dark:bg-blue-600/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-indigo-400/20 dark:bg-indigo-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        {{-- Top Part: Hero Content --}}
        <div class="relative z-10 p-8 pb-10">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                {{-- Left Side: Animation --}}
                <div class="order-1 md:order-1 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
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
                        <span class="text-sm font-bold text-blue-700 dark:text-blue-300">المحاضرات والمحتوى التعليمي</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-blue-700 to-indigo-700 dark:from-slate-100 dark:via-blue-300 dark:to-indigo-300 mb-4 leading-tight">
                        إدارة المحاضرات
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-300 mb-8 leading-relaxed">
                        تنظيم وإدارة المحاضرات التعليمية، ومشاركة المصادر والمرفقات مع الطلاب بسهولة.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <div class="group relative flex-1 min-w-[200px]">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition"></div>
                            <div class="relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input wire:model.live.debounce.300ms="search" placeholder="بحث بالعنوان، الوصف..." class="bg-transparent border-0 focus:ring-0 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 w-full">
                            </div>
                        </div>
                        <button wire:click="openForm" class="relative inline-flex items-center justify-center px-8 py-3 overflow-hidden font-bold text-white transition-all duration-300 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl group hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                            <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span class="relative">إضافة محاضرة</span>
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Course Filter -->
                <div>
                    <select wire:model.live="filter_course_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع المواد</option>
                        @foreach($this->courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Doctor Filter -->
                <div>
                    <select wire:model.live="filter_doctor_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع الدكاترة</option>
                        @foreach($this->doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Lectures Grid --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            @php
                $colorThemes = [
                    ['gradient' => 'from-blue-500 to-indigo-500', 'border' => 'border-blue-500', 'text' => 'text-blue-500', 'overlay' => 'bg-gradient-to-br from-blue-500/70 to-indigo-500/70'],
                    ['gradient' => 'from-emerald-500 to-teal-500', 'border' => 'border-emerald-500', 'text' => 'text-emerald-500', 'overlay' => 'bg-gradient-to-br from-emerald-500/70 to-teal-500/70'],
                    ['gradient' => 'from-violet-500 to-purple-500', 'border' => 'border-violet-500', 'text' => 'text-violet-500', 'overlay' => 'bg-gradient-to-br from-violet-500/70 to-purple-500/70'],
                    ['gradient' => 'from-amber-500 to-orange-500', 'border' => 'border-amber-500', 'text' => 'text-amber-500', 'overlay' => 'bg-gradient-to-br from-amber-500/70 to-orange-500/70'],
                    ['gradient' => 'from-rose-500 to-pink-500', 'border' => 'border-rose-500', 'text' => 'text-rose-500', 'overlay' => 'bg-gradient-to-br from-rose-500/70 to-pink-500/70'],
                    ['gradient' => 'from-cyan-500 to-sky-500', 'border' => 'border-cyan-500', 'text' => 'text-cyan-500', 'overlay' => 'bg-gradient-to-br from-cyan-500/70 to-sky-500/70'],
                ];
            @endphp

            @forelse($lectures as $lecture)
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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold {{ $theme['text'] }} mb-1">محاضرة</p>
                                <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight line-clamp-2">{{ $lecture->title }}</h3>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="space-y-3 flex-grow">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">المادة</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium truncate max-w-[120px]" title="{{ $lecture->course->name ?? 'غير محدد' }}">{{ $lecture->course->name ?? 'غير محدد' }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">الدكتور</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium truncate max-w-[120px]" title="{{ $lecture->doctor->name ?? 'غير محدد' }}">{{ $lecture->doctor->name ?? 'غير محدد' }}</span>
                            </div>

                            @if($lecture->lecture_date)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">التاريخ</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium">{{ \Carbon\Carbon::parse($lecture->lecture_date)->format('Y/m/d') }}</span>
                            </div>
                            @endif

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">الملفات</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                                    {{ $lecture->files->count() }} ملف
                                </span>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700/50 flex justify-between items-center">
                            <span class="text-xs text-slate-400 dark:text-slate-500">{{ $lecture->created_at->format('Y/m/d') }}</span>
                            
                            <div class="flex gap-2">
                                <button wire:click="generateQrCode({{ $lecture->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-indigo-600 hover:text-white transition-colors" title="رمز QR للحضور">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zm-6 12v-2m0 0v-2m0 2H9m12 0h2m-2 0v2m0-2h-2m0 0l-2-2m-2 2l-2-2m2 2l2 2m7-2v2m0-2h-2M9 4v2m2 2h2v2H9V6zm0 0h2v2H9V6zm6 6h2v2h-2v-2zm-6 0h2v2H9v-2zm-6 0h2v2H3v-2zm6 0v2m-6 0v2m6-2h2m-2 0v2m0-2h-2m0 0l-2-2m-2 2l-2-2m2 2l2 2m7-2v2m0-2h-2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6z"></path></svg>
                                </button>
                                <button wire:click="viewLecture({{ $lecture->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-blue-500 hover:text-white transition-colors" title="عرض التفاصيل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button wire:click="edit({{ $lecture->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-indigo-500 hover:text-white transition-colors" title="تعديل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button wire:click="confirmDelete({{ $lecture->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-red-500 hover:text-white transition-colors" title="حذف">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-slate-50 to-blue-50 dark:from-zinc-800/50 dark:to-zinc-900/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700/50 backdrop-blur-sm">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center mb-6 shadow-2xl shadow-blue-500/30">
                        <svg class="w-14 h-14 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-zinc-800 dark:text-white mb-2">ابدأ رحلة التعليم</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-6 max-w-md mx-auto">لم تقم بإضافة أي محاضرة بعد. ابدأ الآن وأنشئ محاضرة جديدة.</p>
                    <button wire:click="openForm" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-3 rounded-xl font-bold transition-all transform hover:scale-105 shadow-lg shadow-blue-500/20">
                        إضافة أول محاضرة
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($lectures->hasPages())
    <div class="mt-8">
        {{ $lectures->links() }}
    </div>
    @endif

    {{-- QR Code Modal --}}
    @if($showQrModal)
    <div class="fixed inset-0 bg-black/80 backdrop-blur-md flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-qr-modal')" class="bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl w-full max-w-md border border-zinc-200 dark:border-zinc-800 overflow-hidden transform transition-all scale-100">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-6 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-white/10 opacity-50 blur-xl"></div>
                <h2 class="text-2xl font-black text-white relative z-10">📱 تسجيل الحضور</h2>
                <p class="text-indigo-100 text-sm mt-1 relative z-10">امسح الرمز لتسجيل حضورك في المحاضرة</p>
                <button type="button" wire:click="closeQrModal" class="absolute top-4 right-4 z-20 p-2 bg-white/20 hover:bg-white/30 rounded-full text-white transition-colors backdrop-blur-sm cursor-pointer focus:outline-none focus:ring-2 focus:ring-white/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="p-8 flex flex-col items-center justify-center bg-white dark:bg-zinc-900">
                <div class="bg-white p-4 rounded-2xl shadow-lg border-2 border-indigo-100 dark:border-zinc-700 mb-6">
                    <img src="{{ $qrCodeImage }}" alt="QR Code" class="w-64 h-64 object-contain" />
                </div>
                
                <div class="text-center space-y-2">
                    <h3 class="font-bold text-lg text-zinc-900 dark:text-white">{{ $qrLectureTitle }}</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $qrLectureCourse }} | {{ $qrLectureDoctor }}
                    </p>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 rounded-full text-xs font-bold mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        صالح لمدة ساعتين
                    </div>
                </div>
            </div>

            <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-800 text-center">
                <p class="text-xs text-zinc-500 dark:text-zinc-400">يجب على الطلاب استخدام كاميرا الجوال أو تطبيق المنصة للمسح</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Form Modal --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-form')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $lecture_id ? 'تعديل المحاضرة' : 'إضافة محاضرة جديدة' }}</h2>
                <button wire:click="closeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="flex-grow p-6 space-y-5 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">عنوان المحاضرة <span class="text-red-500">*</span></label>
                        <input id="title" wire:model="title" type="text" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="مثال: مقدمة في البرمجة">
                        @error('title') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="course_id" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">المادة <span class="text-red-500">*</span></label>
                        <select id="course_id" wire:model="course_id" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">اختر المادة</option>
                            @foreach($this->courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="doctor_id" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الدكتور <span class="text-red-500">*</span></label>
                        <select id="doctor_id" wire:model="doctor_id" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">اختر الدكتور</option>
                            @foreach($this->doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="lecture_date" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">تاريخ المحاضرة (اختياري)</label>
                        <input id="lecture_date" wire:model="lecture_date" type="date" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @error('lecture_date') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الوصف (اختياري)</label>
                    <textarea id="description" wire:model="description" rows="3" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-y transition-all" placeholder="أدخل وصف المحاضرة..."></textarea>
                    @error('description') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- File Uploads --}}
                <div class="border-t pt-5 mt-5 border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a2 2 0 00-2.828-2.828z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                        </svg>
                        إضافة ملفات جديدة
                    </h3>
                    <div class="space-y-4">
                        @foreach($new_files as $index => $file)
                            <div class="flex flex-col gap-3 p-4 border border-zinc-200 dark:border-zinc-700 rounded-xl bg-zinc-50 dark:bg-zinc-800/50">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">الملف</label>
                                        <input type="file" wire:model="new_files.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white text-sm">
                                        @error('new_files.' . $index) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">نوع الملف</label>
                                        <select wire:model="file_types.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white text-sm">
                                            <option value="">اختر النوع</option>
                                            <option value="pdf">ملف PDF</option>
                                            <option value="presentation">عرض تقديمي</option>
                                            <option value="video">فيديو</option>
                                            <option value="image">صورة</option>
                                            <option value="other">أخرى</option>
                                        </select>
                                        @error('file_types.' . $index) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">وصف الملف</label>
                                        <input type="text" wire:model="file_descriptions.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white text-sm" placeholder="وصف الملف">
                                        @error('file_descriptions.' . $index) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" wire:click="removeNewFile({{ $index }})" class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors text-sm flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        حذف
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addNewFile" class="mt-4 bg-zinc-100 dark:bg-zinc-700 hover:bg-zinc-200 dark:hover:bg-zinc-600 text-zinc-700 dark:text-zinc-300 px-4 py-2 rounded-lg text-sm transition-colors flex items-center gap-2 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        إضافة حقل ملف
                    </button>
                </div>

                {{-- Existing Files --}}
                @if($existing_files)
                    <div class="border-t pt-5 mt-5 border-zinc-200 dark:border-zinc-700">
                        <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            الملفات الحالية
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($existing_files as $file)
                                <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-3 bg-white dark:bg-zinc-800/50 flex flex-col relative group">
                                    @if(Str::startsWith($file['file_type'], 'image'))
                                        <img src="{{ Storage::url($file['file_path']) }}" alt="{{ $file['file_name'] }}" class="w-full h-24 object-cover rounded-lg mb-2">
                                    @elseif(Str::startsWith($file['file_type'], 'video'))
                                        <video controls class="w-full h-24 object-cover rounded-lg mb-2">
                                            <source src="{{ Storage::url($file['file_path']) }}" type="{{ $file['file_type'] }}">
                                        </video>
                                    @else
                                        <div class="w-full h-24 flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-lg mb-2 text-zinc-500 dark:text-zinc-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                    @endif
                                    <p class="text-zinc-800 dark:text-white font-semibold text-sm truncate mb-1">{{ $file['file_name'] }}</p>
                                    <p class="text-zinc-600 dark:text-zinc-400 text-xs mb-2 truncate">{{ $file['description'] ?? 'لا يوجد وصف' }}</p>
                                    <div class="flex justify-between items-center mt-auto">
                                        <a href="{{ Storage::url($file['file_path']) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-xs font-medium transition-colors">عرض/تحميل</a>
                                        <button type="button" wire:click="markFileForDeletion({{ $file['id'] }})" class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs font-medium transition-colors">حذف</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-blue-500/20">
                    <span wire:loading.remove wire:target="save">{{ $lecture_id ? 'حفظ التعديلات' : 'إضافة المحاضرة' }}</span>
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
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">هل أنت متأكد من حذف هذه المحاضرة؟ سيتم حذف جميع الملفات المرتبطة بها. لا يمكن التراجع عن هذا الإجراء.</p>
            </div>
            <div class="p-4 flex flex-col-reverse sm:flex-row gap-3 bg-zinc-50 dark:bg-zinc-800/50">
                <button wire:click="$set('delete_id', null)" class="w-full sm:w-1/2 px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button wire:click="deleteLecture" class="w-full sm:w-1/2 px-4 py-2.5 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-red-500/20">
                    <span wire:loading.remove wire:target="deleteLecture">نعم، قم بالحذف</span>
                    <span wire:loading wire:target="deleteLecture">جاري الحذف...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- View Modal --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-view-modal')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تفاصيل المحاضرة: {{ $viewedLecture->title ?? '' }}</h2>
                <button wire:click="closeViewModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-grow p-6 space-y-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-700">
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">عنوان المحاضرة</p>
                            <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $viewedLecture->title ?? '' }}</p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-700">
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المادة</p>
                            <p class="text-lg text-zinc-900 dark:text-white">{{ $viewedLecture->course->name ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-700">
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الدكتور</p>
                            <p class="text-lg text-zinc-900 dark:text-white">{{ $viewedLecture->doctor->name ?? 'غير محدد' }}</p>
                        </div>
                        @if($viewedLecture->lecture_date)
                        <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-700">
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">تاريخ المحاضرة</p>
                            <p class="text-lg text-zinc-900 dark:text-white">{{ \Carbon\Carbon::parse($viewedLecture->lecture_date)->format('Y/m/d') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                @if($viewedLecture->description)
                <div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                        الوصف
                    </h3>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded-xl p-4 border border-zinc-100 dark:border-zinc-700">
                        <p class="text-zinc-900 dark:text-white leading-relaxed">{{ $viewedLecture->description }}</p>
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
                    @if($viewedLecture->files->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($viewedLecture->files as $file)
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
                                    <p class="text-zinc-800 dark:text-white font-semibold text-sm truncate" title="{{ $file->file_name }}">{{ $file->file_name }}</p>
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
                            <p class="text-zinc-600 dark:text-zinc-400">لا توجد ملفات مرفقة بهذه المحاضرة.</p>
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
