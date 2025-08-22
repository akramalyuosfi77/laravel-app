<div>
    {{-- 1. الهيدر المدمج والذكي --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">إدارة المحاضرات</h1>
            <p class="mt-1 text-zinc-500 dark:text-zinc-400">تنظيم، إدارة، ومشاركة المحاضرات التعليمية بكل سهولة.</p>
        </div>
        <div class="w-full md:w-auto flex items-center gap-2">
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" placeholder="بحث بالعنوان، الوصف..." class="w-full pr-11 pl-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <button wire:click="openForm" class="flex-shrink-0 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2.5 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 shadow-md shadow-indigo-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>إضافة</span>
            </button>
        </div>
    </div>

    {{-- 2. فلاتر إضافية للمحاضرات --}}
    <div class="bg-white dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6 mb-8">
        <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
            </svg>
            تصفية متقدمة
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">المادة</label>
                <select wire:model.live="filter_course_id" class="w-full py-2.5 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">جميع المواد</option>
                    @foreach($this->courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الدكتور</label>
                <select wire:model.live="filter_doctor_id" class="w-full py-2.5 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">جميع الدكاترة</option>
                    @foreach($this->doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- 3. شبكة البطاقات الفنية بالألوان للمحاضرات --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-8">
            @php
                // مصفوفة الألوان لكل بطاقة - بتنظيم أفضل لضمان الموثوقية
                $colorThemes = [
                    ['gradient' => 'from-indigo-500 to-purple-500', 'border' => 'border-indigo-500', 'text' => 'text-indigo-500', 'overlay' => 'bg-gradient-to-br from-indigo-500/70 to-purple-500/70'],
                    ['gradient' => 'from-teal-500 to-emerald-500', 'border' => 'border-teal-500', 'text' => 'text-teal-500', 'overlay' => 'bg-gradient-to-br from-teal-500/70 to-emerald-500/70'],
                    ['gradient' => 'from-amber-500 to-orange-500', 'border' => 'border-amber-500', 'text' => 'text-amber-500', 'overlay' => 'bg-gradient-to-br from-amber-500/70 to-orange-500/70'],
                    ['gradient' => 'from-rose-500 to-pink-500', 'border' => 'border-rose-500', 'text' => 'text-rose-500', 'overlay' => 'bg-gradient-to-br from-rose-500/70 to-pink-500/70'],
                    ['gradient' => 'from-blue-500 to-cyan-500', 'border' => 'border-blue-500', 'text' => 'text-blue-500', 'overlay' => 'bg-gradient-to-br from-blue-500/70 to-cyan-500/70'],
                    ['gradient' => 'from-violet-500 to-fuchsia-500', 'border' => 'border-violet-500', 'text' => 'text-violet-500', 'overlay' => 'bg-gradient-to-br from-violet-500/70 to-fuchsia-500/70'],
                ];
            @endphp

            @forelse($lectures as $lecture)
                @php
                    $theme = $colorThemes[$loop->index % count($colorThemes)];
                @endphp

                <div class="group relative bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1.5">
                    <!-- تدرج لوني خلفي -->
                    <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-5 dark:opacity-10 rounded-2xl -z-10"></div>

                    <!-- المحتوى الرئيسي للبطاقة -->
                    <div class="flex flex-col h-full">
                        <div class="flex-grow">
                            <div class="flex items-start gap-4">
                                <div class="w-14 h-14 flex-shrink-0 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border {{ $theme['border'] }}">
                                    <svg class="w-8 h-8 {{ $theme['text'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold {{ $theme['text'] }} mb-1">عنوان المحاضرة</p>
                                    <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight">{{ $lecture->title }}</h3>
                                </div>
                            </div>

                            <div class="mt-4 space-y-3">
                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المادة</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $lecture->course->name ?? 'غير محدد' }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الدكتور</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $lecture->doctor->name ?? 'غير محدد' }}</p>
                                </div>

                                @if($lecture->lecture_date)
                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">تاريخ المحاضرة</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ \Carbon\Carbon::parse($lecture->lecture_date)->format('Y/m/d') }}</p>
                                </div>
                                @endif

                                @if($lecture->description)
                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الوصف</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300">
                                        {{ Str::limit($lecture->description, 80) }}
                                    </p>
                                </div>
                                @endif

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الملفات المرفقة</p>
                                    <div class="flex items-center gap-2">
                                        @if($lecture->files && $lecture->files->count() > 0)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200">
                                                {{ $lecture->files->count() }} ملف
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-200">
                                                لا توجد ملفات
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                            تم الإنشاء: {{ $lecture->created_at->format('Y/m/d') }}
                        </div>
                    </div>

                    <!-- أزرار التحكم التي تظهر عند الـ Hover -->
                    <div class="absolute inset-0 {{ $theme['overlay'] }} dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button wire:click="viewLecture({{ $lecture->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                        <button wire:click="edit({{ $lecture->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button wire:click="confirmDelete({{ $lecture->id }})" class="w-14 h-14 flex items-center justify-center bg-red-500/30 hover:bg-red-500/40 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            @empty
                {{-- حالة عدم وجود بيانات --}}
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-indigo-300 dark:border-zinc-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">ابدأ رحلة التعليم</h3>
                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">لم تقم بإضافة أي محاضرة بعد. ابدأ الآن وأنشئ محاضرة جديدة.</p>
                    <button wire:click="openForm" class="mt-6 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 mx-auto shadow-md shadow-indigo-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>إضافة أول محاضرة</span>
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

    {{-- نافذة نموذج إضافة/تعديل المحاضرة المنبثقة --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-form')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>

            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $lecture_id ? 'تعديل المحاضرة' : 'إضافة محاضرة جديدة' }}</h2>
                <button wire:click="closeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="flex-grow p-6 space-y-5 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="title" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">عنوان المحاضرة <span class="text-red-500">*</span></label>
                        <input id="title" wire:model="title" type="text" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="مثال: مقدمة في البرمجة">
                        @error('title') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="course_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">المادة <span class="text-red-500">*</span></label>
                        <select id="course_id" wire:model="course_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="">اختر المادة</option>
                            @foreach($this->courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="doctor_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الدكتور <span class="text-red-500">*</span></label>
                        <select id="doctor_id" wire:model="doctor_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="">اختر الدكتور</option>
                            @foreach($this->doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="lecture_date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">تاريخ المحاضرة (اختياري)</label>
                        <input id="lecture_date" wire:model="lecture_date" type="date" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        @error('lecture_date') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الوصف (اختياري)</label>
                    <textarea id="description" wire:model="description" rows="3" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-y transition-all" placeholder="أدخل وصف المحاضرة..."></textarea>
                    @error('description') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- حقول رفع الملفات الجديدة --}}
                <div class="border-t pt-5 mt-5 border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a2 2 0 00-2.828-2.828z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                        </svg>
                        إضافة ملفات جديدة
                    </h3>
                    <div class="space-y-4">
                        @foreach($new_files as $index => $file)
                            <div class="flex flex-col gap-3 p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">الملف</label>
                                        <input type="file" wire:model="new_files.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white">
                                        @error('new_files.' . $index) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">نوع الملف</label>
                                        <select wire:model="file_types.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white">
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
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">وصف الملف (اختياري)</label>
                                        <input type="text" wire:model="file_descriptions.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white" placeholder="وصف الملف">
                                        @error('file_descriptions.' . $index) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" wire:click="removeNewFile({{ $index }})" class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addNewFile" class="mt-4 bg-zinc-200 dark:bg-zinc-700 hover:bg-zinc-300 dark:hover:bg-zinc-600 text-zinc-700 dark:text-zinc-300 px-4 py-2 rounded-lg text-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة حقل ملف
                    </button>
                </div>

                {{-- عرض الملفات الموجودة (للتعديل) --}}
                @if($existing_files)
                    <div class="border-t pt-5 mt-5 border-zinc-200 dark:border-zinc-700">
                        <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            الملفات الحالية
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($existing_files as $file)
                                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-3 bg-white dark:bg-zinc-800/50 flex flex-col">
                                    @if(Str::startsWith($file['file_type'], 'image'))
                                        <img src="{{ Storage::url($file['file_path']) }}" alt="{{ $file['file_name'] }}" class="w-full h-24 object-cover rounded-md mb-2">
                                    @elseif(Str::startsWith($file['file_type'], 'video'))
                                        <video controls class="w-full h-24 object-cover rounded-md mb-2">
                                            <source src="{{ Storage::url($file['file_path']) }}" type="{{ $file['file_type'] }}">
                                            متصفحك لا يدعم الفيديو.
                                        </video>
                                    @elseif($file['type'] == 'pdf')
                                        <div class="w-full h-24 flex items-center justify-center bg-red-100 dark:bg-red-900/30 rounded-md mb-2 text-red-500 dark:text-red-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @elseif($file['type'] == 'presentation')
                                        <div class="w-full h-24 flex items-center justify-center bg-orange-100 dark:bg-orange-900/30 rounded-md mb-2 text-orange-500 dark:text-orange-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v1a1 1 0 01-1 1h-1v9a2 2 0 01-2 2H6a2 2 0 01-2-2V7H3a1 1 0 01-1-1V5a1 1 0 011-1h4z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-full h-24 flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-md mb-2 text-zinc-500 dark:text-zinc-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <p class="text-zinc-800 dark:text-white font-semibold text-sm truncate mb-1">{{ $file['file_name'] }}</p>
                                    <p class="text-zinc-600 dark:text-zinc-400 text-xs mb-2">{{ $file['description'] ?? 'لا يوجد وصف' }}</p>
                                    <div class="flex justify-between items-center mt-auto">
                                        <a href="{{ Storage::url($file['file_path']) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-xs transition-colors">عرض/تحميل</a>
                                        <button type="button" wire:click="markFileForDeletion({{ $file['id'] }})" class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-sm transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
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
                <button type="submit" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-indigo-500/20">
                    <span wire:loading.remove wire:target="save">{{ $lecture_id ? 'حفظ التعديلات' : 'إضافة المحاضرة' }}</span>
                    <span wire:loading wire:target="save">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- نافذة تأكيد الحذف --}}
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

    {{-- نافذة عرض تفاصيل المحاضرة المنبثقة --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-view-modal')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
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
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">عنوان المحاضرة</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedLecture->title ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المادة</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedLecture->course->name ?? 'غير محدد' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الدكتور</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedLecture->doctor->name ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @if($viewedLecture->lecture_date)
                            <div>
                                <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">تاريخ المحاضرة</p>
                                <p class="text-zinc-900 dark:text-white">{{ \Carbon\Carbon::parse($viewedLecture->lecture_date)->format('Y-m-d') }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">تاريخ الإنشاء</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedLecture->created_at->format('Y/m/d H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">عدد الملفات</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedLecture->files->count() }} ملف</p>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-2">الوصف</p>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded-lg p-4">
                        <p class="text-zinc-900 dark:text-white">{{ $viewedLecture->description ?? 'لا يوجد وصف' }}</p>
                    </div>
                </div>

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
                                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 bg-white dark:bg-zinc-800/50">
                                    @if(Str::startsWith($file->file_type, 'image'))
                                        <img src="{{ Storage::url($file->file_path) }}" alt="{{ $file->file_name }}" class="w-full h-32 object-cover rounded-md mb-3">
                                    @elseif(Str::startsWith($file->file_type, 'video'))
                                        <video controls class="w-full h-32 object-cover rounded-md mb-3">
                                            <source src="{{ Storage::url($file->file_path) }}" type="{{ $file->file_type }}">
                                            متصفحك لا يدعم الفيديو.
                                        </video>
                                    @elseif($file->type == 'pdf')
                                        <div class="w-full h-32 flex items-center justify-center bg-red-100 dark:bg-red-900/30 rounded-md mb-3 text-red-500 dark:text-red-400">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @elseif($file->type == 'presentation')
                                        <div class="w-full h-32 flex items-center justify-center bg-orange-100 dark:bg-orange-900/30 rounded-md mb-3 text-orange-500 dark:text-orange-400">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v1a1 1 0 01-1 1h-1v9a2 2 0 01-2 2H6a2 2 0 01-2-2V7H3a1 1 0 01-1-1V5a1 1 0 011-1h4z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-full h-32 flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-md mb-3 text-zinc-500 dark:text-zinc-400">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <p class="text-zinc-800 dark:text-white font-semibold text-sm truncate">{{ $file->file_name }}</p>
                                    <p class="text-zinc-600 dark:text-zinc-400 text-xs mt-1">{{ $file->description ?? 'لا يوجد وصف' }}</p>
                                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-xs mt-2 transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        عرض/تحميل
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                            <svg class="w-12 h-12 mx-auto text-zinc-400 dark:text-zinc-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-zinc-600 dark:text-zinc-400">لا توجد ملفات مرفقة بهذه المحاضرة.</p>
                        </div>
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
