<div>
    <div class="bg-slate-50 dark:bg-slate-900 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- 1. الهيدر الرئيسي للصفحة --}}
            <div class="relative bg-gradient-to-br from-amber-500 to-orange-600 p-6 md:p-8 rounded-2xl shadow-lg mb-8 overflow-hidden">
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-8 -left-2 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl sm:text-4xl font-bold text-white">تكليفاتي</h1>
                    <p class="text-orange-200 font-semibold mt-1">تابع مهامك الأكاديمية وقم بتسليمها في الوقت المحدد.</p>
                </div>
            </div>

            {{-- 2. فلاتر البحث والتصفية --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="ابحث بالعنوان، الوصف، المادة..." class="w-full p-3 pr-10 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-amber-500 transition">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                    </div>
                </div>
                <select wire:model.live="filter_status" class="w-full p-3 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-amber-500 transition">
                    <option value="">فلتر حسب الحالة</option>
                    @foreach($submissionStatuses as $statusOption )
                        <option value="{{ $statusOption }}">{{ __($statusOption) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 3. قائمة التكليفات --}}
            <div wire:loading.class.delay="opacity-50" class="transition-opacity">
                @if($assignments->isNotEmpty())
                    <div class="space-y-5">
                        @foreach($assignments as $assignment)
                            @php
                                $submission = $assignment->submissions[0] ?? null;
                                $status = 'لم يتم التسليم';
                                $statusClasses = 'bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-slate-300';
                                if ($submission) {
                                    $status = $submission->status;
                                    if ($status == 'submitted') $statusClasses = 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300';
                                    elseif ($status == 'graded') $statusClasses = 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300';
                                    elseif ($status == 'rejected') $statusClasses = 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300';
                                } elseif (now()->greaterThan($assignment->deadline)) {
                                    $status = 'متأخر';
                                    $statusClasses = 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300';
                                }
                                $isLate = now()->greaterThan($assignment->deadline) && (!$submission || $submission->status != 'submitted');
                            @endphp
                            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
                                <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                                    {{-- Main Info --}}
                                    <div class="md:col-span-2">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClasses }}">{{ __($status) }}</span>
                                            <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">
                                                الدرجة: {{ $submission->grade ?? '- / -' }}
                                            </span>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">{{ $assignment->title }}</h3>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                            {{ $assignment->course->name ?? 'غير محدد' }} - د. {{ $assignment->doctor->name ?? 'غير محدد' }}
                                        </p>
                                        {{-- الوصف المضاف هنا --}}
                                        <p class="text-slate-600 dark:text-slate-300 text-sm mt-3 line-clamp-2">{{ $assignment->description }}</p>
                                    </div>
                                    {{-- Deadline and Actions --}}
                                    <div class="md:text-left md:border-r md:pr-4 border-slate-200 dark:border-slate-700">
                                        <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">موعد التسليم</p>
                                        <p class="font-bold {{ $isLate ? 'text-red-500' : 'text-slate-700 dark:text-slate-200' }}">{{ $assignment->deadline->format('Y-m-d') }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $assignment->deadline->format('h:i A') }}</p>
                                        <div class="flex flex-col gap-2 mt-4">
                                            <button wire:click="viewAssignmentDetails({{ $assignment->id }})" class="w-full text-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-sm">عرض التفاصيل</button>
                                            @if(now()->lessThanOrEqualTo($assignment->deadline) || ($submission && $submission->status == 'submitted'))
                                                <button wire:click="openSubmissionForm({{ $assignment->id }})" class="w-full text-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-semibold text-sm">{{ $submission ? 'تعديل التسليم' : 'تسليم التكليف' }}</button>
                                            @else
                                                <button disabled class="w-full text-center px-4 py-2 bg-slate-300 dark:bg-slate-600 text-slate-500 dark:text-slate-400 rounded-lg cursor-not-allowed font-semibold text-sm">انتهى الموعد</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8 flex justify-center">
                        {{ $assignments->links() }}
                    </div>
                @else
                    <div class="text-center py-16 px-6 bg-white dark:bg-slate-800 rounded-2xl shadow-md">
                        <svg class="mx-auto h-12 w-12 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m-1.125 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        <h3 class="mt-4 text-lg font-semibold text-slate-800 dark:text-slate-200">لا توجد تكليفات متاحة</h3>
                        <p class="mt-1 text-slate-500 dark:text-slate-400">لا توجد تكليفات تطابق بحثك أو لم يتم إضافة تكليفات بعد.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- نافذة نموذج التسليم --}}
        @if($showSubmissionForm )
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="window.livewire.dispatch('closeSubmissionForm')" class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col border border-slate-200 dark:border-slate-700">
                <div class="h-2 bg-gradient-to-r from-green-500 to-emerald-500 rounded-t-2xl"></div>
                <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $existing_submission_id ? 'تعديل التسليم' : 'تسليم التكليف' }}</h2>
                    <button wire:click="closeSubmissionForm" class="p-1 rounded-full text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form wire:submit.prevent="saveSubmission" class="flex-grow p-6 space-y-5 overflow-y-auto">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">عنوان التسليم (اختياري)</label>
                        <input type="text" wire:model="submission_title" class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-500 transition-all">
                        @error('submission_title') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">وصف التسليم (اختياري)</label>
                        <textarea wire:model="submission_description" rows="3" class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-500 transition-all"></textarea>
                        @error('submission_description') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    @if($old_submission_files && $old_submission_files->isNotEmpty())
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">الملفات الحالية</label>
                        <div class="space-y-2">
                            @foreach($old_submission_files as $file)
                                <div class="flex items-center justify-between p-2 border border-slate-200 dark:border-slate-600 rounded-md bg-slate-50 dark:bg-slate-700/50">
                                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-2">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.497a.75.75 0 00-1.06-1.06l-.497.497a1.5 1.5 0 01-2.122-2.122l7-7a1.5 1.5 0 012.122 0r.001.001z" clip-rule="evenodd" /></svg>
                                        {{ $file->file_name }}
                                    </a>
                                    <button type="button" wire:click="deleteExistingFile({{ $file->id }} )" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">إرفاق ملفات جديدة (اختياري )</label>
                        <input type="file" wire:model="submission_files" multiple class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 dark:file:bg-slate-700 file:text-green-700 dark:file:text-green-300 hover:file:bg-green-100 dark:hover:file:bg-slate-600 border border-slate-300 dark:border-slate-600 rounded-lg cursor-pointer">
                        @error('submission_files.*') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                        @error('submission_files') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </form>
                <div class="flex-shrink-0 p-4 flex justify-end gap-3 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-700">
                    <button type="button" wire:click="closeSubmissionForm" class="px-5 py-2.5 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 rounded-lg font-medium transition-colors">إلغاء</button>
                    {{-- الكود الجديد والمُحسّن --}}
                    <button
                        type="submit"
                        wire:click="saveSubmission"
                        wire:loading.attr="disabled" {{-- 💡 1. تعطيل الزر أثناء الرفع --}}
                        wire:target="submission_files" {{-- 💡 2. مراقبة رفع الملفات فقط --}}
                        class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-green-500/20 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        {{-- 💡 3. إظهار رسالة مختلفة أثناء الرفع --}}
                        <div wire:loading.remove wire:target="submission_files">
                            <span>{{ $existing_submission_id ? 'حفظ التعديلات' : 'تسليم التكليف' }}</span>
                        </div>
                        <div wire:loading wire:target="submission_files">
                            <span>جاري رفع الملفات...</span>
                        </div>
                    </button>

                </div>
            </div>
        </div>
        @endif

        {{-- نافذة عرض تفاصيل التكليف والتسليم --}}
        @if($showViewModal)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="window.livewire.dispatch('closeViewModal')" class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-slate-200 dark:border-slate-700">
                <div class="h-2 bg-gradient-to-r from-blue-500 to-sky-500 rounded-t-2xl"></div>
                <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">تفاصيل التكليف</h2>
                    <button wire:click="closeViewModal" class="p-1 rounded-full text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-grow p-6 space-y-6 overflow-y-auto">
                    {{-- تفاصيل التكليف --}}
                    <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700">
                        <h3 class="text-base font-bold text-sky-600 dark:text-sky-400 mb-3">معلومات التكليف</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <p class="font-semibold text-slate-500 dark:text-slate-400">العنوان:</p>
                                <p class="text-slate-800 dark:text-slate-200">{{ $viewedAssignment->title ?? '' }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-500 dark:text-slate-400">المادة:</p>
                                <p class="text-slate-800 dark:text-slate-200">{{ $viewedAssignment->course->name ?? 'غير محدد' }}</p>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-500 dark:text-slate-400">موعد التسليم:</p>
                                <p class="text-slate-800 dark:text-slate-200">{{ $viewedAssignment->deadline->format('Y-m-d') ?? '' }}</p>
                            </div>
                            <div class="col-span-full">
                                <p class="font-semibold text-slate-500 dark:text-slate-400">الوصف:</p>
                                <p class="text-slate-700 dark:text-slate-300 mt-1">{{ $viewedAssignment->description ?? 'لا يوجد وصف' }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- تفاصيل التسليم --}}
                    <div>
                        <h3 class="text-base font-bold text-emerald-600 dark:text-emerald-400 mb-3">تفاصيل تسليمي</h3>
                        @if($viewedSubmission)
                            <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700">
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <p class="font-semibold text-slate-500 dark:text-slate-400">تاريخ التسليم:</p>
                                        <p class="text-slate-800 dark:text-slate-200">{{ $viewedSubmission->created_at->format('Y-m-d H:i') ?? '' }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-500 dark:text-slate-400">الحالة:</p>
                                        <p class="text-slate-800 dark:text-slate-200">{{ __($viewedSubmission->status) }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-500 dark:text-slate-400">الدرجة:</p>
                                        <p class="text-slate-800 dark:text-slate-200">{{ $viewedSubmission->grade ?? 'لم تقيم' }}</p>
                                    </div>
                                    <div class="col-span-full">
                                        <p class="font-semibold text-slate-500 dark:text-slate-400">ملاحظات الدكتور:</p>
                                        <p class="text-slate-700 dark:text-slate-300 mt-1">{{ $viewedSubmission->feedback ?? 'لا توجد ملاحظات' }}</p>
                                    </div>
                                    <div class="col-span-full">
                                        <p class="font-semibold text-slate-500 dark:text-slate-400 mb-2">الملفات التي تم تسليمها:</p>
                                        <div class="space-y-2">
                                            @forelse($viewedSubmission->files as $file)
                                                <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="flex items-center justify-between p-2 border border-slate-200 dark:border-slate-600 rounded-md bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700">
                                                    <span class="text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-2">
                                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.497a.75.75 0 00-1.06-1.06l-.497.497a1.5 1.5 0 01-2.122-2.122l7-7a1.5 1.5 0 012.122 0r.001.001z" clip-rule="evenodd" /></svg>
                                                        {{ $file->file_name }}
                                                    </span>
                                                    <span class="text-slate-500 text-xs">{{ round($file->file_size / 1024, 2 ) }} KB</span>
                                                </a>
                                            @empty
                                                <p class="text-slate-500 text-sm">لم يتم إرفاق ملفات.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-slate-500 dark:text-slate-400 p-4 bg-slate-50 dark:bg-slate-900/50 rounded-lg border border-dashed dark:border-slate-700">لم تقم بتسليم هذا التكليف بعد.</div>
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
