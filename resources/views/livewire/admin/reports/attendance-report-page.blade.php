<div>
    @section('title', 'تقارير الحضور والغياب')

    {{-- 1. هيدر الصفحة --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">تقارير الحضور والغياب</h1>
            <p class="mt-1 text-zinc-500 dark:text-zinc-400">تحليل ومتابعة سجلات حضور الطلاب في جميع الأقسام.</p>
        </div>
        {{-- زر التصدير --}}
        <button wire:click="export" wire:loading.attr="disabled"
            class="w-full md:w-auto flex-shrink-0 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-5 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 shadow-lg shadow-green-500/20">
            <i class="bi bi-file-earmark-excel-fill"></i>
            <span wire:loading.remove wire:target="export">تصدير إلى Excel</span>
            <span wire:loading wire:target="export">جاري التصدير...</span>
        </button>
    </div>

    {{-- 2. صندوق الفلاتر المتقدمة --}}
    <div class="p-6 mb-8 bg-white dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- فلتر البحث العام --}}
            <div class="lg:col-span-2">
                <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">بحث</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="ابحث باسم الطالب, رقمه الجامعي, أو عنوان المحاضرة..." class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all">
            </div>
            {{-- فلتر الحالة --}}
            <div>
                <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">الحالة</label>
                <select wire:model.live="filter_status" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all">
                    <option value="">كل الحالات</option>
                    <option value="present">حاضر</option>
                    <option value="absent">غائب</option>
                    <option value="excused_absence">غائب بعذر</option>
                </select>
            </div>
            {{-- فلتر القسم --}}
            <div>
                <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">القسم</label>
                <select wire:model.live="filter_department_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all">
                    <option value="">كل الأقسام</option>
                    @foreach($this->departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            {{-- فلتر التخصص --}}
            <div>
                <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">التخصص</label>
                <select wire:model.live="filter_specialization_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all" @if(!$filter_department_id) disabled @endif>
                    <option value="">كل التخصصات</option>
                    @foreach($this->specializations as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                    @endforeach
                </select>
            </div>
            {{-- فلتر المادة --}}
            <div>
                <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">المادة</label>
                <select wire:model.live="filter_course_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all" @if(!$filter_specialization_id) disabled @endif>
                    <option value="">كل المواد</option>
                    @foreach($this->courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            {{-- فلتر التاريخ (من) --}}
            <div>
                <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">من تاريخ</label>
                <input type="date" wire:model.live="filter_date_from" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all">
            </div>
            {{-- فلتر التاريخ (إلى) --}}
            <div>
                <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">إلى تاريخ</label>
                <input type="date" wire:model.live="filter_date_to" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all">
            </div>
        </div>
    </div>

    {{-- 3. جدول عرض البيانات --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="bg-white dark:bg-zinc-800/50 rounded-2xl shadow-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-right text-zinc-500 dark:text-zinc-400">
                    <thead class="bg-zinc-100 dark:bg-zinc-800 text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold">الطالب</th>
                            <th scope="col" class="px-6 py-4 font-bold">المحاضرة</th>
                            <th scope="col" class="px-6 py-4 font-bold">المادة</th>
                            <th scope="col" class="px-6 py-4 font-bold">الحالة</th>
                            <th scope="col" class="px-6 py-4 font-bold">التاريخ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse ($attendanceRecords as $record)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors" wire:key="record-{{ $record->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $record->student->user?->profile_image ? asset('storage/' . $record->student->user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($record->student->name ) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $record->student->name }}">
                                        <div class="mr-4">
                                            <div class="font-medium text-zinc-900 dark:text-white">{{ $record->student->name ?? 'غير متوفر' }}</div>
                                            <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $record->student->student_id_number ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-zinc-900 dark:text-white">{{ $record->lecture->title ?? 'غير متوفر' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-zinc-900 dark:text-white">{{ $record->lecture->course->name ?? 'غير متوفر' }}</div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $record->student->batch->specialization->department->name ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full
                                        @if($record->status == 'present') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400
                                        @elseif($record->status == 'excused_absence') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400
                                        @else bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400 @endif">
                                        @if($record->status == 'present') حاضر
                                        @elseif($record->status == 'excused_absence') غائب بعذر
                                        @else غائب @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-zinc-900 dark:text-white">{{ $record->lecture->lecture_date ? \Carbon\Carbon::parse($record->lecture->lecture_date)->format('Y-m-d') : 'غير محدد' }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12">
                                    <i class="bi bi-search text-5xl text-zinc-400"></i>
                                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">لا توجد نتائج</h3>
                                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">حاول تغيير معايير البحث أو الفلترة.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($attendanceRecords->hasPages())
                <div class="p-4 bg-zinc-50 dark:bg-zinc-800 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $attendanceRecords->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
