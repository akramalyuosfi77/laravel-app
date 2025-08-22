<div class="bg-white dark:bg-zinc-800 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 shadow-md">
    @if($course)
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            <h3 class="text-lg font-bold text-zinc-800 dark:text-white">تقرير درجات الطلاب في مقرر: {{ $course->name }}</h3>
            <div class="flex items-center gap-2 w-full md:w-auto">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="ابحث في الطلاب..." class="w-full md:w-64 px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 focus:ring-2 focus:ring-indigo-500">
                <button wire:click="export" class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    تصدير
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-right">
                <thead class="bg-zinc-50 dark:bg-zinc-700/50">
                    <tr>
                        <th class="p-3 font-semibold text-zinc-600 dark:text-zinc-300">الاسم</th>
                        <th class="p-3 font-semibold text-zinc-600 dark:text-zinc-300">الرقم الجامعي</th>
                        @foreach($course->assignments as $assignment)
                            <th class="p-3 font-semibold text-zinc-600 dark:text-zinc-300">{{ $assignment->title }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($students as $student)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="p-3 text-zinc-800 dark:text-zinc-200">{{ $student->name }}</td>
                            <td class="p-3 text-zinc-500 dark:text-zinc-400">{{ $student->student_id_number }}</td>
                            @foreach($course->assignments as $assignment)
                                @php
                                    $submission = $student->submissions->firstWhere('assignment_id', $assignment->id);
                                @endphp
                                <td class="p-3 text-center font-semibold {{ $submission?->grade ? 'text-green-600 dark:text-green-400' : 'text-zinc-400' }}">
                                    {{ $submission?->grade ?? '-' }}
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 2 + $course->assignments->count() }}" class="p-4 text-center text-zinc-500 dark:text-zinc-400">لا يوجد طلاب لعرضهم.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="mt-4">
                {{ $students->links() }}
            </div>
        @endif
    @endif
</div>
