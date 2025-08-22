<div>
    @section('title', 'إدارة المحاضرات')

    {{-- 1. الهيدر المدمج والذكي --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">إدارة المحاضرات</h1>
            <p class="mt-1 text-zinc-500 dark:text-zinc-400">نظرة شاملة على محاضراتك والملفات المرفقة.</p>
        </div>
        <button wire:click="openForm"
            class="w-full md:w-auto flex-shrink-0 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white px-5 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 shadow-lg shadow-pink-500/20 transform hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>إضافة محاضرة جديدة</span>
        </button>
    </div>

    {{-- 2. الفلاتر والبحث --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 p-4 bg-white dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
        <div class="relative">
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" wire:model.live="search" placeholder="ابحث بعنوان المحاضرة أو وصفها..." class="w-full pr-11 pl-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all">
        </div>
        <select wire:model.live="filter_course_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all">
            <option value="">فلتر حسب المادة</option>
            @foreach($this->doctorCourses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- 3. شبكة بطاقات المحاضرات --}}
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white mb-6">محاضراتي</h2>
        <div wire:loading.class.delay="opacity-50" class="transition-opacity">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @php
                    $lectureThemes = [
                        ['gradient' => 'from-sky-500 to-blue-500', 'border' => 'border-sky-500', 'text' => 'text-sky-500', 'overlay' => 'bg-gradient-to-br from-sky-500/70 to-blue-500/70'],
                        ['gradient' => 'from-emerald-500 to-teal-500', 'border' => 'border-emerald-500', 'text' => 'text-emerald-500', 'overlay' => 'bg-gradient-to-br from-emerald-500/70 to-teal-500/70'],
                        ['gradient' => 'from-amber-500 to-orange-500', 'border' => 'border-amber-500', 'text' => 'text-amber-500', 'overlay' => 'bg-gradient-to-br from-amber-500/70 to-orange-500/70'],
                    ];
                @endphp
                @forelse($lectures as $lecture)
                    @php
                        $theme = $lectureThemes[$loop->index % count($lectureThemes)];
                    @endphp
                    <div class="group relative bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1.5 flex flex-col">
                        <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-5 dark:opacity-10 rounded-2xl -z-10"></div>
                        <div class="flex-grow">
                            <div class="flex items-start gap-4">
                                <div class="w-14 h-14 flex-shrink-0 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border {{ $theme['border'] }}">
                                    <svg class="w-8 h-8 {{ $theme['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold {{ $theme['text'] }} mb-1">{{ $lecture->course->name ?? 'مقرر غير محدد' }}</p>
                                    <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight">{{ $lecture->title }}</h3>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الوصف</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-300 leading-relaxed">{{ Str::limit($lecture->description, 120, '...') ?: 'لا يوجد وصف.' }}</p>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-between items-center text-xs text-zinc-500 dark:text-zinc-400">
                            <span>الدكتور:</span>
                            <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $lecture->doctor->name ?? 'غير محدد' }}</span>
                        </div>
                        @if($lecture->lecture_date)
                        <div class="mt-2 flex justify-between items-center text-xs text-zinc-500 dark:text-zinc-400">
                            <span>تاريخ المحاضرة:</span>
                            <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ \Carbon\Carbon::parse($lecture->lecture_date)->format('Y-m-d') }}</span>
                        </div>
                        @endif
                        {{-- أزرار التحكم --}}
                        <div class="absolute inset-0 {{ $theme['overlay'] }} dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button wire:click="viewLecture({{ $lecture->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                            <button wire:click="edit({{ $lecture->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                            <button wire:click="confirmDelete({{ $lecture->id }})" class="w-14 h-14 flex items-center justify-center bg-red-500/30 hover:bg-red-500/40 rounded-full text-white transform transition-all hover:scale-110 shadow-lg"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 xl:col-span-3 p-12 text-center bg-gradient-to-br from-sky-50 to-blue-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-sky-300 dark:border-zinc-700">
                        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-sky-500 to-blue-500 rounded-full flex items-center justify-center mb-4"><svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                        <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">ابدأ بإضافة أول محاضرة</h3>
                        <p class="mt-1 text-zinc-500 dark:text-zinc-400">لم تقم بإضافة أي محاضرات بعد. اضغط على زر "إضافة محاضرة جديدة" للبدء.</p>
                    </div>
                @endforelse
            </div>
            @if($lectures->hasPages())<div class="mt-8">{{ $lectures->links() }}</div>@endif
        </div>
    </div>

    {{-- ================================================================= --}}
    {{-- ✅ النوافذ المنبثقة (Modals) كاملة وجاهزة --}}
    {{-- ================================================================= --}}

    {{-- نافذة نموذج إضافة/تعديل المحاضرة --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.closeForm()" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-4xl border border-zinc-200 dark:border-zinc-700 overflow-hidden flex flex-col max-h-[90vh]">
            <div class="h-2 bg-gradient-to-r from-sky-500 to-blue-500"></div>
            <div class="p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-sky-500 to-blue-500 rounded-xl flex items-center justify-center"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                    {{ $lecture_id ? 'تعديل المحاضرة' : 'إضافة محاضرة جديدة' }}
                </h2>
                <button wire:click="closeForm" class="p-2 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <form wire:submit.prevent="save" class="p-8 space-y-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">عنوان المحاضرة <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="title" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all shadow-sm" placeholder="أدخل عنوان المحاضرة" required>
                        @error('title') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">المادة <span class="text-red-500">*</span></label>
                        <select wire:model="course_id" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all shadow-sm" required>
                            <option value="">اختر المادة</option>
                            @foreach($this->doctorCourses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">الوصف (اختياري)</label>
                        <textarea wire:model="description" rows="3" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 resize-y transition-all shadow-sm" placeholder="أدخل وصفاً تفصيلياً للمحاضرة..."></textarea>
                        @error('description') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">تاريخ المحاضرة (اختياري)</label>
                        <input type="date" wire:model="lecture_date" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all shadow-sm">
                        @error('lecture_date') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- حقول رفع الملفات الجديدة --}}
                <div class="border-t pt-6 mt-6 border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
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
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">وصف الملف (اختياري)</label>
                                    <input type="text" wire:model="file_descriptions.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white shadow-sm" placeholder="أدخل وصفاً للملف...">
                                    @error('file_descriptions.' . $index) <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                </div>
                                <button type="button" wire:click="removeNewFile({{ $index }})" class="flex-shrink-0 mt-8 p-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addNewFile" class="mt-4 px-4 py-2 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-700 dark:text-zinc-300 rounded-xl text-sm font-medium flex items-center gap-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        إضافة حقل ملف
                    </button>
                </div>

                {{-- عرض الملفات الموجودة (للتعديل) --}}
                @if($existing_files && count($existing_files) > 0)
                    <div class="border-t pt-6 mt-6 border-zinc-200 dark:border-zinc-700">
                        <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            الملفات الحالية
                        </h3>
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
                                    @elseif($file['type'] == 'presentation')
                                        <div class="w-full h-24 flex items-center justify-center bg-orange-100 dark:bg-orange-900/30 rounded-lg mb-3 text-orange-500 dark:text-orange-400">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
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
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            حذف
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </form>
            <div class="p-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-semibold transition-colors">إلغاء</button>
                <button type="submit" wire:click="save" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-all shadow-lg shadow-sky-500/25"><span wire:loading.remove wire:target="save">{{ $lecture_id ? 'حفظ التعديلات' : 'إضافة المحاضرة' }}</span><span wire:loading wire:target="save">جاري الحفظ...</span></button>
            </div>
        </div>
    </div>
    @endif

    {{-- نافذة تأكيد حذف المحاضرة --}}
    @if($delete_id)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.set('delete_id', null)" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-red-500 to-rose-500"></div>
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gradient-to-r from-red-100 to-rose-100 dark:from-red-900/30 dark:to-rose-900/30 rounded-full flex items-center justify-center mb-4"><svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg></div>
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">تأكيد الحذف</h3>
                <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed">هل أنت متأكد من رغبتك في حذف هذه المحاضرة؟ سيتم حذف جميع الملفات المرتبطة بها. لا يمكن التراجع عن هذا الإجراء.</p>
            </div>
            <div class="p-6 flex flex-col-reverse sm:flex-row gap-3 bg-zinc-50 dark:bg-zinc-800/50">
                <button wire:click="$set('delete_id', null)" class="w-full sm:w-1/2 px-4 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-semibold transition-colors">إلغاء</button>
                <button wire:click="deleteLecture" class="w-full sm:w-1/2 px-4 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-all shadow-lg shadow-red-500/25"><span wire:loading.remove wire:target="deleteLecture">نعم، قم بالحذف</span><span wire:loading wire:target="deleteLecture">جاري الحذف...</span></button>
            </div>
        </div>
    </div>
    @endif

    {{-- نافذة عرض تفاصيل المحاضرة --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.closeViewModal()" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-sky-500 to-blue-500 rounded-t-3xl"></div>
            <div class="flex-shrink-0 p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-sky-500 to-blue-500 rounded-xl flex items-center justify-center"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></div>
                    تفاصيل المحاضرة: {{ $viewedLecture->title ?? '' }}
                </h2>
                <button wire:click="closeViewModal" class="p-2 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div class="flex-grow p-8 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">عنوان المحاضرة:</p>
                        <p class="text-zinc-900 dark:text-white">{{ $viewedLecture->title ?? '' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">المادة:</p>
                        <p class="text-zinc-900 dark:text-white">{{ $viewedLecture->course->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">الدكتور:</p>
                        <p class="text-zinc-900 dark:text-white">{{ $viewedLecture->doctor->name ?? 'غير محدد' }}</p>
                    </div>
                    @if($viewedLecture->lecture_date)
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">تاريخ المحاضرة:</p>
                            <p class="text-zinc-900 dark:text-white">{{ \Carbon\Carbon::parse($viewedLecture->lecture_date)->format('Y-m-d') }}</p>
                        </div>
                    @endif
                    <div class="md:col-span-2 bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">الوصف:</p>
                        <p class="text-zinc-900 dark:text-white leading-relaxed">{{ $viewedLecture->description ?? 'لا يوجد وصف' }}</p>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-sky-50 to-blue-50 dark:from-sky-900/20 dark:to-blue-900/20 p-6 rounded-2xl border border-sky-200 dark:border-sky-800">
                    <h3 class="text-2xl font-bold text-sky-800 dark:text-sky-400 mb-6 flex items-center gap-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        الملفات المرفقة
                    </h3>
                    @if($viewedLecture->files->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($viewedLecture->files as $file)
                                <div class="bg-white dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 shadow-md hover:shadow-lg transition-all duration-200">
                                    @if(Str::startsWith($file->file_type, 'image'))
                                        <img src="{{ Storage::url($file->file_path) }}" alt="{{ $file->file_name }}" class="w-full h-40 object-cover rounded-lg mb-3 shadow-sm">
                                    @elseif(Str::startsWith($file->file_type, 'video'))
                                        <video controls class="w-full h-40 object-cover rounded-lg mb-3 shadow-sm">
                                            <source src="{{ Storage::url($file->file_path) }}" type="{{ $file->file_type }}">
                                            متصفحك لا يدعم الفيديو.
                                        </video>
                                    @elseif($file->type == 'pdf')
                                        <div class="w-full h-40 flex items-center justify-center bg-red-100 dark:bg-red-900/30 rounded-lg mb-3 text-red-500 dark:text-red-400">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                    @elseif($file->type == 'presentation')
                                        <div class="w-full h-40 flex items-center justify-center bg-orange-100 dark:bg-orange-900/30 rounded-lg mb-3 text-orange-500 dark:text-orange-400">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-full h-40 flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-lg mb-3 text-zinc-500 dark:text-zinc-400">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <p class="text-zinc-800 dark:text-zinc-200 font-bold text-sm truncate mb-2">{{ $file->file_name ?? 'ملف بدون اسم' }}</p>
                                    <p class="text-zinc-600 dark:text-zinc-400 text-xs mb-3">{{ $file->description ?? 'لا يوجد وصف' }}</p>
                                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="inline-flex items-center gap-2 text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-300 text-sm font-semibold hover:underline transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        عرض/تحميل
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-r from-sky-500 to-blue-500 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-zinc-800 dark:text-white">لا توجد ملفات</h4>
                            <p class="text-zinc-600 dark:text-zinc-400">لا توجد ملفات مرفقة بهذه المحاضرة.</p>
                        </div>
                    @endif
                </div>

                {{-- ====================================================================== --}}
                {{-- ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ الكود المضاف هنا ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼ --}}
                {{-- ====================================================================== --}}

                <div class="my-8 border-t-2 border-dashed border-zinc-200 dark:border-zinc-700"></div>

                @if ($viewedLecture)
                    @livewire('doctor.attendance-manager', ['lecture' => $viewedLecture], key($viewedLecture->id))
                @endif

                {{-- ====================================================================== --}}
                {{-- ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ نهاية الكود المضاف ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲ --}}
                {{-- ====================================================================== --}}

            </div>

            <div class="flex-shrink-0 p-6 flex justify-end bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button
                    type="button"
                    wire:click="closeViewModal"
                    class="px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-semibold transition-colors"
                >
                    إغلاق
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

