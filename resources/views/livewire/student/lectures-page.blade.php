<div>
    <div class="bg-slate-50 dark:bg-slate-900 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- 1. الهيدر الرئيسي للصفحة --}}
            <div class="relative bg-gradient-to-br from-teal-500 to-cyan-600 p-6 md:p-8 rounded-2xl shadow-lg mb-8 overflow-hidden">
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-8 -left-2 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl sm:text-4xl font-bold text-white">المحاضرات المتاحة</h1>
                    <p class="text-cyan-200 font-semibold mt-1">تصفح واستعرض جميع محاضراتك في مكان واحد.</p>
                </div>
            </div>

            {{-- 2. فلاتر البحث والتصفية --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="ابحث بعنوان المحاضرة أو وصفها..." class="w-full p-3 pr-10 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-teal-500 transition">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                    </div>
                </div>
                <select wire:model.live="filter_course_id" class="w-full p-3 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-teal-500 transition">
                    <option value="">فلتر حسب المادة</option>
                    @foreach($this->studentCourses as $course )
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 3. قائمة المحاضرات --}}
            <div wire:loading.class.delay="opacity-50" class="transition-opacity">
                @if($lectures->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($lectures as $lecture)
                            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-md overflow-hidden flex flex-col h-full transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                <div class="p-5 flex-grow">
                                    <div class="flex justify-between items-start mb-2">
                                        <p class="text-sm font-semibold text-teal-600 dark:text-teal-400 bg-teal-50 dark:bg-teal-900/50 px-3 py-1 rounded-full">{{ $lecture->course->name ?? 'غير محدد' }}</p>
                                        @if($lecture->lecture_date)
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($lecture->lecture_date)->format('Y-m-d') }}</p>
                                        @endif
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-2">{{ $lecture->title }}</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">
                                        بواسطة: د. {{ $lecture->doctor->name ?? 'غير محدد' }}
                                    </p>
                                    <p class="text-slate-600 dark:text-slate-300 text-sm line-clamp-3">{{ $lecture->description }}</p>
                                </div>
                                <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                                    <button wire:click="viewLecture({{ $lecture->id }})" class="w-full text-center font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 text-sm transition duration-200">
                                        عرض التفاصيل والملفات
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8 flex justify-center">
                        {{ $lectures->links() }}
                    </div>
                @else
                    <div class="text-center py-16 px-6 bg-white dark:bg-slate-800 rounded-2xl shadow-md">
                        <svg class="mx-auto h-12 w-12 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                        <h3 class="mt-4 text-lg font-semibold text-slate-800 dark:text-slate-200">لا توجد محاضرات متاحة</h3>
                        <p class="mt-1 text-slate-500 dark:text-slate-400">لا توجد محاضرات تطابق بحثك أو لم يتم إضافة محاضرات بعد.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- نافذة عرض تفاصيل المحاضرة --}}
        @if($showViewModal )
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="window.livewire.dispatch('closeViewModal')" class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-slate-200 dark:border-slate-700">
                <div class="h-2 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-t-2xl"></div>
                <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $viewedLecture->title ?? '' }}</h2>
                    <button wire:click="closeViewModal" class="p-1 rounded-full text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="flex-grow p-6 space-y-6 overflow-y-auto">
                    <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700">
                        <h3 class="text-base font-bold text-teal-600 dark:text-teal-400 mb-3">معلومات المحاضرة</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <p class="font-semibold text-slate-500 dark:text-slate-400">المادة:</p>
                                <p class="text-slate-800 dark:text-slate-200">{{ $viewedLecture->course->name ?? 'غير محدد' }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-500 dark:text-slate-400">الدكتور:</p>
                                <p class="text-slate-800 dark:text-slate-200">{{ $viewedLecture->doctor->name ?? 'غير محدد' }}</p>
                            </div>
                            @if($viewedLecture->lecture_date)
                                <div>
                                    <p class="font-semibold text-slate-500 dark:text-slate-400">التاريخ:</p>
                                    <p class="text-slate-800 dark:text-slate-200">{{ \Carbon\Carbon::parse($viewedLecture->lecture_date)->format('Y-m-d') }}</p>
                                </div>
                            @endif
                            <div class="col-span-full">
                                <p class="font-semibold text-slate-500 dark:text-slate-400">الوصف:</p>
                                <p class="text-slate-700 dark:text-slate-300 mt-1">{{ $viewedLecture->description ?? 'لا يوجد وصف' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-cyan-600 dark:text-cyan-400 mb-3">الملفات المرفقة</h3>
                        @if($viewedLecture->files->isNotEmpty())
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($viewedLecture->files as $file)
                                    <div class="border border-slate-200 dark:border-slate-700 rounded-lg p-3 flex items-start gap-3 bg-white dark:bg-slate-800">
                                        <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">
                                            @if(Str::contains($file->file_type, ['image', 'jpeg', 'png', 'gif']))
                                                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                            @elseif(Str::contains($file->file_type, 'pdf' ))
                                                <svg class="w-7 h-7 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                            @else
                                                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                            @endif
                                        </div>
                                        <div class="flex-grow">
                                            <a href="{{ Storage::url($file->file_path ) }}" target="_blank" class="font-semibold text-slate-800 dark:text-slate-200 hover:text-sky-600 dark:hover:text-sky-400 text-sm leading-tight">{{ $file->file_name }}</a>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $file->description ?? 'لا يوجد وصف' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-slate-500 dark:text-slate-400 p-4 bg-slate-50 dark:bg-slate-900/50 rounded-lg border border-dashed dark:border-slate-700">لا توجد ملفات مرفقة بهذه المحاضرة.</div>
                        @endif
                    </div>
                </div>

                <div class="flex-shrink-0 p-4 flex justify-end bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-700">
                    <button type="button" wire:click="closeViewModal" class="px-5 py-2.5 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 rounded-lg font-medium transition-colors">إغلاق</button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
