<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        @section('title', 'إدارة المحاضرات')

        {{-- 1. Hero Section المدمج مع الفلاتر --}}
        <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-sky-50 to-blue-50 dark:from-zinc-900 dark:via-sky-900/20 dark:to-blue-900/20 border border-slate-200 dark:border-slate-800" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
            {{-- Animated Background Orbs --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-10 right-10 w-72 h-72 bg-sky-400/20 dark:bg-sky-600/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-10 left-10 w-96 h-96 bg-blue-400/20 dark:bg-blue-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 p-8">
                {{-- Top Section: Animation + Title + Actions --}}
                <div class="grid md:grid-cols-2 gap-8 items-center mb-8">
                    {{-- Left Side: Animation --}}
                    <div class="order-1 md:order-1 flex justify-center">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-sky-500 to-blue-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
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
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-sky-100 dark:bg-sky-900/30 border border-sky-200 dark:border-sky-800 rounded-full mb-4">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-sky-500"></span>
                            </span>
                            <span class="text-sm font-bold text-sky-700 dark:text-sky-300">بوابة المحاضر</span>
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-sky-700 to-blue-700 dark:from-slate-100 dark:via-sky-300 dark:to-blue-300 mb-4 leading-tight" style="font-family: 'Questv1', sans-serif;">
                            إدارة المحاضرات
                        </h1>
                        <p class="text-lg text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                            قم بإنشاء وإدارة محاضراتك الدراسية ورفع الملفات بكل سهولة
                        </p>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-3">
                            <div class="group relative flex-1 min-w-[200px]">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-sky-600 to-blue-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition"></div>
                                <div class="relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <input wire:model.live.debounce.300ms="search" placeholder="بحث عن محاضرة..." class="bg-transparent border-0 focus:ring-0 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 w-full">
                                </div>
                            </div>
                            
                            <button wire:click="openForm" class="group relative px-6 py-3 bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white rounded-2xl font-bold transition-all hover:scale-105 shadow-xl shadow-sky-500/30 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>إضافة محاضرة</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Bottom Section: Filters --}}
                <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-6">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                        <svg class="w-5 h-5 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                        </svg>
                        تصفية المحاضرات
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">المادة الدراسية</label>
                            <select wire:model.live="filter_course_id" class="w-full py-2.5 px-4 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all text-sm">
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

        {{-- 2. Lectures Grid --}}
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                <span class="w-2 h-8 bg-sky-600 rounded-full inline-block"></span>
                محاضراتي
            </h2>

            <div wire:loading.class.delay="opacity-50" class="transition-opacity">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($lectures as $lecture)
                        <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-sky-500/10 dark:hover:shadow-sky-900/30 hover:-translate-y-2 overflow-hidden">
                            {{-- Subtle Gradient Background --}}
                            <div class="absolute inset-0 bg-gradient-to-br from-slate-50 to-sky-50 dark:from-slate-900 dark:to-slate-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                            
                            <div class="relative z-10 flex flex-col h-full">
                                {{-- Header --}}
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="w-14 h-14 flex-shrink-0 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-500 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="inline-block px-2.5 py-0.5 bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-300 rounded-full text-xs font-bold mb-1 truncate max-w-full">
                                            {{ $lecture->course->name ?? 'مادة غير محددة' }}
                                        </span>
                                        <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight truncate group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors" style="font-family: 'Questv1', sans-serif;">
                                            {{ $lecture->title }}
                                        </h3>
                                    </div>
                                </div>

                                {{-- Details --}}
                                <div class="flex-grow space-y-3 mb-5">
                                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 bg-slate-50 dark:bg-slate-900/50 p-3 rounded-xl border border-slate-100 dark:border-slate-800">
                                        {{ Str::limit($lecture->description, 120, '...') ?: 'لا يوجد وصف' }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">الدكتور</span>
                                        <span class="text-sm text-slate-800 dark:text-slate-200 font-bold">
                                            {{ $lecture->doctor->name ?? 'غير محدد' }}
                                        </span>
                                    </div>

                                    @if($lecture->lecture_date)
                                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            التاريخ
                                        </span>
                                        <span class="text-sm text-slate-800 dark:text-slate-200 font-bold dir-ltr">
                                            {{ \Carbon\Carbon::parse($lecture->lecture_date)->format('Y-m-d') }}
                                        </span>
                                    </div>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="grid grid-cols-4 gap-2 mt-auto">
                                    <a href="{{ route('doctor.lectures.qr', $lecture->id) }}" class="flex items-center justify-center p-2.5 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-900/20 dark:hover:bg-indigo-900/40 rounded-xl text-indigo-600 dark:text-indigo-400 transition-all hover:scale-105" title="QR Code">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zm-6 12v-2m0 0v-2m0 2H9m12 0h2m-2 0v2m0-2h-2m0 0l-2-2m-2 2l-2-2m2 2l2 2m7-2v2m0-2h-2M9 4v2m2 2h2v2H9V6zm0 0h2v2H9V6zm6 6h2v2h-2v-2zm-6 0h2v2H9v-2zm-6 0h2v2H3v-2zm6 0v2m-6 0v2m6-2h2m-2 0v2m0-2h-2m0 0l-2-2m-2 2l-2-2m2 2l2 2m7-2v2m0-2h-2"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6z"></svg>
                                    </a>
                                    <button wire:click="viewLecture({{ $lecture->id }})" class="flex items-center justify-center p-2.5 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 rounded-xl text-blue-600 dark:text-blue-400 transition-all hover:scale-105" title="عرض">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button wire:click="edit({{ $lecture->id }})" class="flex items-center justify-center p-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl text-slate-700 dark:text-slate-200 transition-all hover:scale-105" title="تعديل">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $lecture->id }})" class="flex items-center justify-center p-2.5 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 rounded-xl text-red-600 dark:text-red-400 transition-all hover:scale-105" title="حذف">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
                            <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-2">لا توجد محاضرات</h3>
                            <p class="text-zinc-500 dark:text-zinc-400 mb-6">لم تقم بإضافة أي محاضرات بعد.</p>
                            <button wire:click="openForm" class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-xl font-bold transition-all">
                                <span>إضافة أول محاضرة</span>
                            </button>
                        </div>
                    @endforelse
                </div>
                
                @if($lectures->hasPages())
                    <div class="mt-8">
                        {{ $lectures->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Modals (keeping existing modals as they are well-designed) --}}
        
        {{-- Create/Edit Lecture Modal --}}
        @if($showForm)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.closeForm()" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
                <div class="h-2 bg-gradient-to-r from-sky-500 to-blue-500 rounded-t-2xl"></div>
                
                <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">{{ $lecture_id ? 'تعديل المحاضرة' : 'إضافة محاضرة جديدة' }}</h2>
                    <button wire:click="closeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="flex-grow p-6 space-y-6 overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">عنوان المحاضرة <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="title" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all" placeholder="مثال: المحاضرة الأولى" required>
                            @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">المادة <span class="text-red-500">*</span></label>
                            <select wire:model="course_id" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all" required>
                                <option value="">اختر المادة</option>
                                @foreach($this->doctorCourses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">تاريخ المحاضرة</label>
                            <input type="date" wire:model="lecture_date" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all">
                            @error('lecture_date') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الوصف</label>
                            <textarea wire:model="description" rows="3" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all" placeholder="تفاصيل المحاضرة..."></textarea>
                            @error('description') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- File Upload Section --}}
                    <div class="border-t pt-6 mt-6 border-zinc-200 dark:border-zinc-700">
                        <h3 class="text-base font-bold text-zinc-800 dark:text-white mb-4 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                            <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            إضافة ملفات جديدة
                        </h3>
                        <div class="space-y-4">
                            @foreach($new_files as $index => $file)
                                <div class="flex flex-col sm:flex-row items-start gap-4 p-4 border border-zinc-200 dark:border-zinc-700 rounded-xl bg-zinc-50 dark:bg-zinc-800/50">
                                    <div class="flex-grow">
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الملف</label>
                                        <input type="file" wire:model="new_files.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm">
                                        @error('new_files.' . $index) <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="flex-grow">
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">نوع الملف</label>
                                        <select wire:model="file_types.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm">
                                            <option value="">اختر النوع</option>
                                            <option value="pdf">ملف PDF</option>
                                            <option value="presentation">عرض تقديمي</option>
                                            <option value="video">فيديو</option>
                                            <option value="image">صورة</option>
                                            <option value="other">أخرى</option>
                                        </select>
                                        @error('file_types.' . $index) <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="flex-grow">
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">وصف الملف</label>
                                        <input type="text" wire:model="file_descriptions.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm" placeholder="وصف...">
                                        @error('file_descriptions.' . $index) <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                    </div>
                                    <button type="button" wire:click="removeNewFile({{ $index }})" class="flex-shrink-0 mt-8 p-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" wire:click="addNewFile" class="mt-4 px-4 py-2 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-700 dark:text-zinc-300 rounded-xl text-sm font-medium flex items-center gap-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            إضافة حقل ملف
                        </button>
                    </div>

                    {{-- Existing Files --}}
                    @if($existing_files && count($existing_files) > 0)
                        <div class="border-t pt-6 mt-6 border-zinc-200 dark:border-zinc-700">
                            <h3 class="text-base font-bold text-zinc-800 dark:text-white mb-4" style="font-family: 'Questv1', sans-serif;">الملفات الحالية</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($existing_files as $file)
                                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 shadow-sm bg-white dark:bg-zinc-800/50 flex flex-col">
                                        @if(Str::startsWith($file['file_type'], 'image'))
                                            <img src="{{ Storage::url($file['file_path']) }}" alt="{{ $file['file_name'] }}" class="w-full h-24 object-cover rounded-lg mb-3">
                                        @elseif(Str::startsWith($file['file_type'], 'video'))
                                            <div class="w-full h-24 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 rounded-lg mb-3 text-blue-500 dark:text-blue-400">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                            </div>
                                        @elseif($file['type'] == 'pdf')
                                            <div class="w-full h-24 flex items-center justify-center bg-red-100 dark:bg-red-900/30 rounded-lg mb-3 text-red-500 dark:text-red-400">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                        @else
                                            <div class="w-full h-24 flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-lg mb-3 text-zinc-500 dark:text-zinc-400">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                        @endif
                                        <p class="text-zinc-800 dark:text-zinc-200 font-semibold text-sm truncate mb-1">{{ $file['file_name'] }}</p>
                                        <p class="text-zinc-600 dark:text-zinc-400 text-xs mb-3">{{ $file['description'] ?? 'لا يوجد وصف' }}</p>
                                        <div class="flex justify-between items-center mt-auto">
                                            <a href="{{ Storage::url($file['file_path']) }}" target="_blank" class="text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-300 text-xs hover:underline">عرض/تحميل</a>
                                            <button type="button" wire:click="markFileForDeletion({{ $file['id'] }})" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                حذف
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </form>

                <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                    <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                    <button type="button" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md">
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
                    <div class="w-16 h-16 mx-auto bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2" style="font-family: 'Questv1', sans-serif;">تأكيد الحذف</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 text-sm">هل أنت متأكد من حذف هذه المحاضرة؟ سيتم حذف جميع الملفات المرتبطة بها.</p>
                </div>
                <div class="p-4 flex flex-col-reverse sm:flex-row gap-3 bg-zinc-50 dark:bg-zinc-800/50">
                    <button wire:click="$set('delete_id', null)" class="w-full sm:w-1/2 px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                    <button wire:click="deleteLecture" class="w-full sm:w-1/2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors shadow-md">
                        <span wire:loading.remove wire:target="deleteLecture">نعم، حذف</span>
                        <span wire:loading wire:target="deleteLecture">جاري الحذف...</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- View Lecture Modal --}}
        @if($showViewModal)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.closeViewModal()" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
                <div class="h-2 bg-gradient-to-r from-sky-500 to-blue-500 rounded-t-2xl"></div>
                <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">تفاصيل المحاضرة</h2>
                    <button wire:click="closeViewModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-grow p-6 overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">عنوان المحاضرة</span>
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $viewedLecture->title ?? '' }}</span>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">المادة</span>
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $viewedLecture->course->name ?? '-' }}</span>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">الدكتور</span>
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $viewedLecture->doctor->name ?? '-' }}</span>
                        </div>
                        @if($viewedLecture->lecture_date)
                            <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">تاريخ المحاضرة</span>
                                <span class="font-bold text-zinc-900 dark:text-white">{{ \Carbon\Carbon::parse($viewedLecture->lecture_date)->format('Y-m-d') }}</span>
                            </div>
                        @endif
                        <div class="col-span-full bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">الوصف</span>
                            <p class="text-zinc-800 dark:text-zinc-200 whitespace-pre-line">{{ $viewedLecture->description ?? 'لا يوجد وصف' }}</p>
                        </div>
                    </div>

                    <h3 class="font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        الملفات المرفقة
                    </h3>
                    
                    @if($viewedLecture->files->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($viewedLecture->files as $file)
                                <div class="group relative bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden hover:shadow-lg transition-all">
                                    <div class="aspect-video bg-zinc-100 dark:bg-zinc-900 flex items-center justify-center">
                                        @if(Str::startsWith($file->file_type, 'image'))
                                            <img src="{{ Storage::url($file->file_path) }}" class="w-full h-full object-cover">
                                        @elseif($file->type == 'pdf')
                                            <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        @else
                                            <svg class="w-12 h-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <p class="text-sm font-bold text-zinc-900 dark:text-white truncate mb-1">{{ $file->file_name }}</p>
                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-xs text-sky-600 dark:text-sky-400 hover:underline">عرض الملف</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-zinc-500 dark:text-zinc-400 bg-zinc-50 dark:bg-zinc-900/50 rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700">
                            لا توجد ملفات مرفقة
                        </div>
                    @endif

                    <div class="my-8 border-t-2 border-dashed border-zinc-200 dark:border-zinc-700"></div>

                    @if ($viewedLecture)
                        @livewire('doctor.attendance-manager', ['lecture' => $viewedLecture], key($viewedLecture->id))
                    @endif
                </div>
                <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end">
                    <button wire:click="closeViewModal" class="px-5 py-2.5 bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 rounded-lg font-medium hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors">إغلاق</button>
                </div>
            </div>
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
                        <h3 class="text-zinc-900 dark:text-white font-bold">{{ $qrLectureTitle }}</h3>
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
    </div>
    
    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
