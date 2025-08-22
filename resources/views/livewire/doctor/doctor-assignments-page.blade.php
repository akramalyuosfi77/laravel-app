<div>
    {{-- الخلفية الرئيسية مع تدرج لوني فاخر --}}
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900 font-sans">
        <div class="max-w-7xl mx-auto p-6 sm:p-8">

            {{-- الهيدر الرئيسي الفاخر --}}
            <div class="bg-white dark:bg-zinc-800/50 rounded-3xl shadow-2xl border border-zinc-200 dark:border-zinc-700 p-8 mb-8 backdrop-blur-sm">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-zinc-800 dark:text-white">إدارة تكليفاتي</h1>
                        <p class="text-zinc-500 dark:text-zinc-400 text-lg">إدارة شاملة للتكليفات والتسليمات</p>
                    </div>
                </div>
            </div>

            {{-- قسم التكليفات --}}
            <div class="bg-white dark:bg-zinc-800/50 rounded-3xl shadow-2xl border border-zinc-200 dark:border-zinc-700 p-8 mb-12 backdrop-blur-sm">
                {{-- هيدر قسم التكليفات --}}
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">التكليفات التي قمت بإنشائها</h2>
                            <p class="text-zinc-500 dark:text-zinc-400">إدارة وتنظيم تكليفاتك الأكاديمية</p>
                        </div>
                    </div>
                    <button
                        wire:click="openAssignmentForm"
                        class="bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-3 shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:shadow-emerald-500/30 transform hover:scale-105"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        إضافة تكليف جديد
                    </button>
                </div>

                {{-- فلاتر البحث للتكليفات --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 p-6 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-2xl border border-emerald-200 dark:border-emerald-800">
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            wire:model.live="search"
                            placeholder="ابحث بالعنوان، الوصف، المادة..."
                            class="w-full pr-11 pl-4 py-3 border border-emerald-300 dark:border-emerald-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm"
                        >
                    </div>
                    <select
                        wire:model.live="filter_course_id"
                        class="w-full px-4 py-3 border border-emerald-300 dark:border-emerald-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm"
                    >
                        <option value="">فلتر حسب المادة</option>
                        @foreach($this->doctorCourses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- جدول التكليفات بتصميم حديث --}}
                <div class="overflow-hidden rounded-2xl shadow-xl border border-zinc-200 dark:border-zinc-700">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
                                <tr>
                                    <th class="p-4 text-right font-semibold">#</th>
                                    <th class="p-4 text-right font-semibold">العنوان</th>
                                    <th class="p-4 text-right font-semibold">الوصف</th>
                                    <th class="p-4 text-right font-semibold">المادة</th>
                                    <th class="p-4 text-right font-semibold">موعد التسليم</th>
                                    <th class="p-4 text-right font-semibold">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800/50">
                                @forelse ($assignments as $index => $assignment)
                                    <tr class="border-t border-zinc-200 dark:border-zinc-700 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all duration-200">
                                        <td class="p-4 text-zinc-700 dark:text-zinc-300 font-medium">{{ $assignments->firstItem() + $index }}</td>
                                        <td class="p-4 text-zinc-800 dark:text-zinc-200 font-semibold">{{ $assignment->title }}</td>
                                        <td class="p-4 text-zinc-600 dark:text-zinc-400">{{ Str::limit($assignment->description, 50) }}</td>
                                        <td class="p-4 text-zinc-700 dark:text-zinc-300">{{ $assignment->course->name ?? 'غير محدد' }}</td>
                                        <td class="p-4 text-zinc-700 dark:text-zinc-300">{{ $assignment->deadline->format('Y-m-d H:i') }}</td>
                                        <td class="p-4">
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                <button
                                                    wire:click="editAssignment({{ $assignment->id }})"
                                                    class="bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    تعديل
                                                </button>
                                                <button
                                                    wire:click="confirmDeleteAssignment({{ $assignment->id }})"
                                                    class="bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    حذف
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-12 text-center">
                                            <div class="flex flex-col items-center gap-4">
                                                <div class="w-20 h-20 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-zinc-800 dark:text-white">ابدأ بإنشاء أول تكليف</h3>
                                                    <p class="text-zinc-500 dark:text-zinc-400">لم تقم بإنشاء أي تكليفات بعد.</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ترقيم التكليفات --}}
                @if($assignments->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $assignments->links() }}
                    </div>
                @endif
            </div>

            {{-- قسم التسليمات --}}
            <div class="bg-white dark:bg-zinc-800/50 rounded-3xl shadow-2xl border border-zinc-200 dark:border-zinc-700 p-8 backdrop-blur-sm">
                {{-- هيدر قسم التسليمات --}}
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">تسليمات الطلاب لتكليفاتك</h2>
                        <p class="text-zinc-500 dark:text-zinc-400">مراجعة وتقييم تسليمات الطلاب</p>
                    </div>
                </div>

                {{-- فلاتر البحث للتسليمات --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 p-6 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-2xl border border-purple-200 dark:border-purple-800">
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            wire:model.live="search"
                            placeholder="ابحث بعنوان التسليم، الطالب..."
                            class="w-full pr-11 pl-4 py-3 border border-purple-300 dark:border-purple-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-purple-500 transition-all shadow-sm"
                        >
                    </div>
                    <select
                        wire:model.live="filter_submission_status"
                        class="w-full px-4 py-3 border border-purple-300 dark:border-purple-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-purple-500 transition-all shadow-sm"
                    >
                        <option value="">فلتر حسب حالة التسليم</option>
                        @foreach($submissionStatuses as $statusOption)
                            <option value="{{ $statusOption }}">{{ __($statusOption) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- جدول التسليمات بتصميم حديث --}}
                <div class="overflow-hidden rounded-2xl shadow-xl border border-zinc-200 dark:border-zinc-700">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                                <tr>
                                    <th class="p-4 text-right font-semibold">#</th>
                                    <th class="p-4 text-right font-semibold">عنوان التسليم</th>
                                    <th class="p-4 text-right font-semibold">الطالب</th>
                                    <th class="p-4 text-right font-semibold">التكليف الأصلي</th>
                                    <th class="p-4 text-right font-semibold">تاريخ التسليم</th>
                                    <th class="p-4 text-right font-semibold">الحالة</th>
                                    <th class="p-4 text-right font-semibold">الدرجة</th>
                                    <th class="p-4 text-right font-semibold">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800/50">
                                @forelse ($submissions as $index => $submission)
                                    <tr class="border-t border-zinc-200 dark:border-zinc-700 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-all duration-200">
                                        <td class="p-4 text-zinc-700 dark:text-zinc-300 font-medium">{{ $submissions->firstItem() + $index }}</td>
                                        <td class="p-4 text-zinc-800 dark:text-zinc-200 font-semibold">{{ $submission->title ?? 'لا يوجد عنوان' }}</td>
                                        <td class="p-4 text-zinc-700 dark:text-zinc-300">{{ $submission->student->name ?? 'غير محدد' }}</td>
                                        <td class="p-4 text-zinc-700 dark:text-zinc-300">{{ $submission->assignment->title ?? 'غير محدد' }}</td>
                                        <td class="p-4 text-zinc-700 dark:text-zinc-300">{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="p-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                                @if($submission->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                                @elseif($submission->status == 'submitted') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                                @elseif($submission->status == 'graded') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                                @elseif($submission->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                                @endif">
                                                {{ __($submission->status) }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-zinc-700 dark:text-zinc-300 font-semibold">{{ $submission->grade ?? 'لم يتم التقييم' }}</td>
                                        <td class="p-4">
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                <button
                                                    wire:click="viewSubmission({{ $submission->id }})"
                                                    class="bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    عرض
                                                </button>
                                                <button
                                                    wire:click="openGradeForm({{ $submission->id }})"
                                                    class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    تقييم
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="p-12 text-center">
                                            <div class="flex flex-col items-center gap-4">
                                                <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-zinc-800 dark:text-white">لا توجد تسليمات</h3>
                                                    <p class="text-zinc-500 dark:text-zinc-400">لا توجد تسليمات لتكليفاتك حتى الآن.</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ترقيم التسليمات --}}
                @if($submissions->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $submissions->links('livewire::bootstrap') }}
                    </div>
                @endif
            </div>
        </div>

        {{-- النوافذ المنبثقة بتصميم فاخر --}}

        {{-- نافذة نموذج إضافة/تعديل التكليف --}}
        @if($showForm)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.closeAssignmentForm()" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <!-- شريط أعلى النافذة بلون متدرج -->
                <div class="h-2 bg-gradient-to-r from-emerald-500 to-teal-500"></div>

                <div class="p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        {{ $edit_id ? 'تعديل التكليف' : 'إضافة تكليف جديد' }}
                    </h2>
                    <button wire:click="closeAssignmentForm" class="p-2 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveAssignment" class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">عنوان التكليف <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            wire:model="title"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm"
                            placeholder="أدخل عنوان التكليف"
                            required
                        >
                        @error('title') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">الوصف (اختياري)</label>
                        <textarea
                            wire:model="description"
                            rows="4"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 resize-y transition-all shadow-sm"
                            placeholder="أدخل وصفاً تفصيلياً للتكليف..."
                        ></textarea>
                        @error('description') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">المادة <span class="text-red-500">*</span></label>
                        <select
                            wire:model="course_id"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm"
                            required
                        >
                            <option value="">اختر المادة</option>
                            @foreach($this->doctorCourses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">موعد التسليم <span class="text-red-500">*</span></label>
                        <input
                            type="datetime-local"
                            wire:model="deadline"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm"
                            required
                        >
                        @error('deadline') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </form>

                <div class="p-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                    <button
                        type="button"
                        wire:click="closeAssignmentForm"
                        class="w-full sm:w-auto px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-semibold transition-colors"
                    >
                        إلغاء
                    </button>
                    <button
                        type="submit"
                        wire:click="saveAssignment"
                        class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-all shadow-lg shadow-emerald-500/25"
                    >
                        <span wire:loading.remove wire:target="saveAssignment">{{ $edit_id ? 'حفظ التعديلات' : 'إنشاء التكليف' }}</span>
                        <span wire:loading wire:target="saveAssignment">جاري الحفظ...</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- نافذة تأكيد حذف التكليف --}}
        @if($edit_id && !$showForm)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.set('edit_id', null)" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
                <!-- شريط أعلى النافذة بلون متدرج -->
                <div class="h-2 bg-gradient-to-r from-red-500 to-rose-500"></div>

                <div class="p-6 text-center">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-r from-red-100 to-rose-100 dark:from-red-900/30 dark:to-rose-900/30 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">تأكيد الحذف</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed">هل أنت متأكد من رغبتك في حذف هذا التكليف؟ سيتم حذف جميع التسليمات المرتبطة به. لا يمكن التراجع عن هذا الإجراء.</p>
                </div>

                <div class="p-6 flex flex-col-reverse sm:flex-row gap-3 bg-zinc-50 dark:bg-zinc-800/50">
                    <button
                        wire:click="$set('edit_id', null)"
                        class="w-full sm:w-1/2 px-4 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-semibold transition-colors"
                    >
                        إلغاء
                    </button>
                    <button
                        wire:click="deleteAssignment()"
                        class="w-full sm:w-1/2 px-4 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-all shadow-lg shadow-red-500/25"
                    >
                        <span wire:loading.remove wire:target="deleteAssignment">نعم، قم بالحذف</span>
                        <span wire:loading wire:target="deleteAssignment">جاري الحذف...</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- نافذة نموذج التقييم --}}
        @if($showGradeForm)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.resetGradeForm()" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <!-- شريط أعلى النافذة بلون متدرج -->
                <div class="h-2 bg-gradient-to-r from-purple-500 to-pink-500"></div>

                <div class="p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        تقييم التسليم
                    </h2>
                    <button wire:click="resetGradeForm" class="p-2 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveGrade" class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">الدرجة <span class="text-red-500">*</span></label>
                        <input
                            type="number"
                            wire:model="grade_value"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all shadow-sm"
                            required
                            min="0"
                            max="100"
                            placeholder="أدخل الدرجة من 0 إلى 100"
                        >
                        @error('grade_value') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">ملاحظات (اختياري)</label>
                        <textarea
                            wire:model="feedback_text"
                            rows="4"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 resize-y transition-all shadow-sm"
                            placeholder="أضف ملاحظاتك وتعليقاتك على التسليم..."
                        ></textarea>
                        @error('feedback_text') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </form>

                <div class="p-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                    <button
                        type="button"
                        wire:click="resetGradeForm"
                        class="w-full sm:w-auto px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-semibold transition-colors"
                    >
                        إلغاء
                    </button>
                    <button
                        type="submit"
                        wire:click="saveGrade"
                        class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-all shadow-lg shadow-purple-500/25"
                    >
                        <span wire:loading.remove wire:target="saveGrade">حفظ التقييم</span>
                        <span wire:loading wire:target="saveGrade">جاري الحفظ...</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- نافذة عرض تفاصيل التسليم --}}
        @if($showViewSubmissionModal)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.closeViewSubmissionModal()" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
                <!-- شريط أعلى النافذة بلون متدرج -->
                <div class="h-2 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-t-3xl"></div>

                <div class="flex-shrink-0 p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        تفاصيل التسليم: {{ $viewedSubmission->title ?? '' }}
                    </h2>
                    <button wire:click="closeViewSubmissionModal" class="p-2 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="flex-grow p-8 overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">عنوان التسليم:</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->title ?? 'لا يوجد عنوان' }}</p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">الطالب:</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->student->name ?? 'غير محدد' }}</p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">التكليف الأصلي:</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->assignment->title ?? 'غير محدد' }}</p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">المادة:</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->assignment->course->name ?? 'غير محدد' }}</p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">الدكتور المسؤول عن التكليف:</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedSubmission->assignment->doctor->name ?? 'غير محدد' }}</p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">حالة التسليم:</p>
                            <span class="px-3 py-1 rounded-full text-sm font-bold
                                @if($viewedSubmission->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                @elseif($viewedSubmission->status == 'submitted') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                @elseif($viewedSubmission->status == 'graded') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                @elseif($viewedSubmission->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                @endif">
                                {{ __($viewedSubmission->status) }}
                            </span>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">الدرجة:</p>
                            <p class="text-zinc-900 dark:text-white font-bold text-lg">{{ $viewedSubmission->grade ?? 'لم يتم التقييم' }}</p>
                        </div>
                        <div class="md:col-span-2 bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">وصف التسليم:</p>
                            <p class="text-zinc-900 dark:text-white leading-relaxed">{{ $viewedSubmission->description ?? 'لا يوجد وصف' }}</p>
                        </div>
                        <div class="md:col-span-2 bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">ملاحظات الدكتور:</p>
                            <p class="text-zinc-900 dark:text-white leading-relaxed">{{ $viewedSubmission->feedback ?? 'لا توجد ملاحظات' }}</p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 p-6 rounded-2xl border border-blue-200 dark:border-blue-800">
                        <h3 class="text-2xl font-bold text-blue-800 dark:text-blue-400 mb-6 flex items-center gap-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            الملفات المرفقة
                        </h3>
                        @if($viewedFiles->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($viewedFiles as $file)
                                    <div class="bg-white dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 shadow-md hover:shadow-lg transition-all duration-200">
                                        @if(Str::startsWith($file->file_type, 'image'))
                                            <img src="{{ Storage::url($file->file_path) }}" alt="{{ $file->file_name }}" class="w-full h-40 object-cover rounded-lg mb-3 shadow-sm">
                                        @elseif(Str::startsWith($file->file_type, 'video'))
                                            <video controls class="w-full h-40 object-cover rounded-lg mb-3 shadow-sm">
                                                <source src="{{ Storage::url($file->file_path) }}" type="{{ $file->file_type }}">
                                                متصفحك لا يدعم الفيديو.
                                            </video>
                                        @else
                                            <div class="w-full h-40 flex items-center justify-center bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-700 dark:to-zinc-800 rounded-lg mb-3 text-zinc-500">
                                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <p class="text-zinc-800 dark:text-zinc-200 font-bold text-sm truncate mb-2">{{ $file->file_name ?? 'ملف بدون اسم' }}</p>
                                        <p class="text-zinc-600 dark:text-zinc-400 text-xs mb-3">{{ $file->description ?? 'لا يوجد وصف' }}</p>
                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-semibold hover:underline transition-colors">
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
                                <div class="w-20 h-20 mx-auto bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-zinc-800 dark:text-white">لا توجد ملفات</h4>
                                <p class="text-zinc-600 dark:text-zinc-400">لا توجد ملفات مرفقة بهذا التسليم.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex-shrink-0 p-6 flex justify-end bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                    <button
                        type="button"
                        wire:click="closeViewSubmissionModal"
                        class="px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-semibold transition-colors"
                    >
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scale-in {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        .animate-scale-in {
            animation: scale-in 0.3s ease-out;
        }
    </style>
</div>

