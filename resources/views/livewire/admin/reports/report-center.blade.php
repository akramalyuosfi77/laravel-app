<div>
    @section('title', 'مركز التقارير')

    {{-- الهيدر الرئيسي للصفحة --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">مركز التقارير</h1>
        <p class="mt-1 text-zinc-500 dark:text-zinc-400">بناء وتصدير تقارير مخصصة حول أداء الجامعة.</p>
    </div>

    {{-- قسم الفلاتر الرئيسية --}}
    <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 shadow-lg mb-8">
        <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4">1. اختر نطاق التقرير</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- اختيار النطاق العام --}}
            <select wire:model.live="reportScope" class="w-full py-3 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                <option value="university">الجامعة بشكل عام</option>
                <option value="department">قسم معين</option>
                <option value="specialization">تخصص معين</option>
            </select>

            {{-- اختيار القسم (يظهر فقط إذا كان النطاق قسماً أو تخصصاً) --}}
            @if ($reportScope === 'department' || $reportScope === 'specialization')
                <select wire:model.live="selectedDepartmentId" class="w-full py-3 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">-- اختر القسم --</option>
                    @foreach ($this->departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            @endif

            {{-- اختيار التخصص (يظهر فقط إذا كان النطاق تخصصاً وتم اختيار قسم) --}}
            @if ($reportScope === 'specialization' && $selectedDepartmentId)
                <select wire:model.live="selectedSpecializationId" class="w-full py-3 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">-- اختر التخصص --</option>
                        @foreach ($this->reportSpecializations as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>

    {{-- منطقة عرض التقارير --}}
 {{-- منطقة عرض التقارير --}}
<div class="mt-8 space-y-8">
    @if ($reportScope === 'department' && $selectedDepartmentId)
        {{-- عرض تقارير القسم --}}
        <livewire:admin.reports.widgets.department-stats-widget :departmentId="$selectedDepartmentId" :key="'stats-dept-'.$selectedDepartmentId" />
        <livewire:admin.reports.widgets.department-students-widget :departmentId="$selectedDepartmentId" :key="'students-dept-'.$selectedDepartmentId" />

    @elseif ($reportScope === 'specialization' && $selectedSpecializationId)
        {{-- 💡 عرض تقارير التخصص (سنبنيها لاحقاً) --}}
        {{-- <livewire:admin.reports.widgets.specialization-stats-widget :specializationId="$selectedSpecializationId" :key="'stats-spec-'.$selectedSpecializationId" /> --}}
        <livewire:admin.reports.widgets.department-students-widget :specializationId="$selectedSpecializationId" :key="'students-spec-'.$selectedSpecializationId" />

    @else
        {{-- رسالة توجيهية للمستخدم --}}
        <div class="bg-zinc-50 dark:bg-zinc-800/50 border border-dashed border-zinc-300 dark:border-zinc-700 p-8 rounded-2xl text-center">
            <p class="text-zinc-600 dark:text-zinc-400 font-semibold">
                يرجى اختيار نطاق التقرير من القوائم أعلاه لعرض البيانات.
            </p>
        </div>
    @endif
</div>


</div>
