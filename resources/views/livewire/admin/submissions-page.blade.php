<div>
    {{-- 1. الهيدر المدمج والذكي --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">إدارة تسليمات الطلاب</h1>
            <p class="mt-1 text-zinc-500 dark:text-zinc-400">متابعة، تقييم، وإدارة تسليمات الطلاب بكل سهولة.</p>
        </div>
        <div class="w-full md:w-auto flex items-center gap-2">
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" placeholder="بحث بالعنوان، الطالب..." class="w-full pr-11 pl-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
        </div>
    </div>

    {{-- 2. فلاتر إضافية للتسليمات --}}
    <div class="bg-white dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6 mb-8">
        <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
            </svg>
            تصفية متقدمة
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">التكليف</label>
                <select wire:model.live="filter_assignment_id" class="w-full py-2.5 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">جميع التكليفات</option>
                    @foreach($this->assignments as $assignment)
                        <option value="{{ $assignment->id }}">{{ $assignment->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الطالب</label>
                <select wire:model.live="filter_student_id" class="w-full py-2.5 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">جميع الطلاب</option>
                    @foreach($this->students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الحالة</label>
                <select wire:model.live="filter_status" class="w-full py-2.5 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">جميع الحالات</option>
                    @foreach($statuses as $statusOption)
                        <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- 3. شبكة البطاقات الفنية بالألوان للتسليمات --}}
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

            @forelse($submissions as $submission)
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
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0-1.125.504-1.125 1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold {{ $theme['text'] }} mb-1">عنوان التسليم</p>
                                    <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight">{{ $submission->title ?? 'لا يوجد عنوان' }}</h3>
                                </div>
                            </div>

                            <div class="mt-4 space-y-3">
                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الطالب</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $submission->student->name ?? 'غير محدد' }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">التكليف الأصلي</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $submission->assignment->title ?? 'غير محدد' }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المادة</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $submission->assignment->course->name ?? 'غير محدد' }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الدكتور</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $submission->assignment->doctor->name ?? 'غير محدد' }}</p>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الحالة</p>
                                    <div class="flex items-center gap-2">
                                        @if($submission->status == 'pending')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200">
                                                في الانتظار
                                            </span>
                                        @elseif($submission->status == 'submitted')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200">
                                                تم التسليم
                                            </span>
                                        @elseif($submission->status == 'graded')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200">
                                                تم التقييم
                                            </span>
                                        @elseif($submission->status == 'rejected')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200">
                                                مرفوض
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الدرجة</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300">
                                        @if($submission->grade)
                                            <span class="font-semibold {{ $theme['text'] }}">{{ $submission->grade }}/100</span>
                                        @else
                                            لم يتم التقييم
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                            تم الإنشاء: {{ $submission->created_at->format('Y/m/d') }}
                        </div>
                    </div>

                    <!-- أزرار التحكم التي تظهر عند الـ Hover -->
                    <div class="absolute inset-0 {{ $theme['overlay'] }} dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button wire:click="viewSubmission({{ $submission->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                        <button wire:click="openGradeForm({{ $submission->id }})" class="w-14 h-14 flex items-center justify-center bg-green-500/30 hover:bg-green-500/40 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                    </div>
                </div>
            @empty
                {{-- حالة عدم وجود بيانات --}}
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-indigo-300 dark:border-zinc-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0-1.125.504-1.125 1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">لا توجد تسليمات</h3>
                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">لم يقم الطلاب بتسليم أي مهام بعد.</p>
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

    {{-- نافذة نموذج التقييم المنبثقة --}}
    @if($showGradeForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-grade-form')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-green-500 to-emerald-500 rounded-t-2xl"></div>

            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تقييم التسليم</h2>
                <button wire:click="resetGradeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="saveGrade" class="flex-grow p-6 space-y-5 overflow-y-auto">
                <div>
                    <label for="grade_value" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الدرجة <span class="text-red-500">*</span></label>
                    <input id="grade_value" wire:model="grade_value" type="number" min="0" max="100" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" placeholder="أدخل الدرجة من 0 إلى 100">
                    @error('grade_value') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="feedback_text" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">ملاحظات (اختياري)</label>
                    <textarea id="feedback_text" wire:model="feedback_text" rows="4" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-y transition-all" placeholder="أدخل ملاحظاتك على التسليم..."></textarea>
                    @error('feedback_text') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="resetGradeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="saveGrade" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-green-500/20">
                    <span wire:loading.remove wire:target="saveGrade">حفظ التقييم</span>
                    <span wire:loading wire:target="saveGrade">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- نافذة عرض تفاصيل التسليم المنبثقة --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-view-modal')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
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
                            <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->title ?? 'لا يوجد عنوان' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الطالب</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->student->name ?? 'غير محدد' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">التكليف الأصلي</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->assignment->title ?? 'غير محدد' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المادة</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->assignment->course->name ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الدكتور المسؤول</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->assignment->doctor->name ?? 'غير محدد' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">حالة التسليم</p>
                            <p class="text-zinc-900 dark:text-white">{{ __($viewedSubmission->status) }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الدرجة</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->grade ?? 'لم يتم التقييم' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">تاريخ التسليم</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->created_at->format('Y/m/d H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-2">وصف التسليم</p>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded-lg p-4">
                        <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->description ?? 'لا يوجد وصف' }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-2">ملاحظات الدكتور</p>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded-lg p-4">
                        <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->feedback ?? 'لا توجد ملاحظات' }}</p>
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
                    @if($viewedFiles->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($viewedFiles as $file)
                                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 bg-white dark:bg-zinc-800/50">
                                    @if(Str::startsWith($file->file_type, 'image'))
                                        <img src="{{ Storage::url($file->file_path) }}" alt="{{ $file->file_name }}" class="w-full h-32 object-cover rounded-md mb-3">
                                    @elseif(Str::startsWith($file->file_type, 'video'))
                                        <video controls class="w-full h-32 object-cover rounded-md mb-3">
                                            <source src="{{ Storage::url($file->file_path) }}" type="{{ $file->file_type }}">
                                            متصفحك لا يدعم الفيديو.
                                        </video>
                                    @else
                                        <div class="w-full h-32 flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-md mb-3 text-zinc-500 dark:text-zinc-400">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <p class="text-zinc-800 dark:text-white font-semibold text-sm truncate">{{ $file->file_name ?? 'ملف بدون اسم' }}</p>
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
                            <p class="text-zinc-600 dark:text-zinc-400">لا توجد ملفات مرفقة بهذا التسليم.</p>
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
