<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md mt-6">

    {{-- 1. عنوان القسم وزر "تسجيل الكل كحاضر" --}}
    <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                <i class="bi bi-person-check-fill text-blue-500"></i>
                سجل حضور الطلاب
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                قم بتحديث حالة حضور الطلاب لهذه المحاضرة.
            </p>
        </div>
        {{-- زر لتسجيل الجميع كـ "حاضر" دفعة واحدة --}}
        <button wire:click="markAllAsPresent" wire:loading.attr="disabled" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-colors disabled:opacity-50">
            <span wire:loading.remove wire:target="markAllAsPresent">
                <i class="bi bi-check-all"></i> تسجيل الكل كـ "حاضر"
            </span>
            <span wire:loading wire:target="markAllAsPresent">
                <i class="bi bi-arrow-repeat animate-spin"></i> جاري التسجيل...
            </span>
        </button>
    </div>

    {{-- 2. قائمة الطلاب --}}
    <div class="space-y-3">
        @forelse ($students as $student)
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg" wire:key="student-{{ $student->id }}">

                {{-- اسم الطالب وصورته --}}
                {{-- اسم الطالب وصورته (مع التحقق من وجود المستخدم) --}}
                <div class="flex items-center">
                    @if ($student->profile_image)
                        <img class="h-10 w-10 rounded-full object-cover me-3"
                            src="{{ Storage::url($student->profile_image) }}"
                            alt="{{ $student->name }}">
                    @else
                        <img class="h-10 w-10 rounded-full object-cover me-3"
                            src="{{ 'https://ui-avatars.com/api/?name=' . urlencode($student->name ) . '&color=7F9CF5&background=EBF4FF' }}"
                            alt="{{ $student->name }}">
                    @endif

                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $student->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $student->student_id_number }}</p>
                    </div>
                </div>


                {{-- أزرار التحكم بالحالة --}}
                <div class="flex items-center space-x-1 space-x-reverse">
                    @php
                        // مصفوفة لتسهيل إنشاء الأزرار
                        $statuses = [
                            'present' => ['label' => 'حاضر', 'color' => 'green', 'icon' => 'bi-check-circle-fill'],
                            'absent' => ['label' => 'غائب', 'color' => 'red', 'icon' => 'bi-x-circle-fill'],
                            'excused_absence' => ['label' => 'غائب بعذر', 'color' => 'yellow', 'icon' => 'bi-exclamation-circle-fill'],
                        ];
                    @endphp

                    @foreach ($statuses as $statusKey => $statusDetails)
                        <button
                            wire:click="updateAttendance({{ $student->id }}, '{{ $statusKey }}')"
                            wire:loading.attr="disabled"
                            wire:target="updateAttendance({{ $student->id }})"
                            class="px-3 py-1 text-sm rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800
                                {{-- هذا الشرط يحدد لون الزر بناءً على الحالة الحالية --}}
                                @if ($attendance_status[$student->id] == $statusKey)
                                    bg-{{ $statusDetails['color'] }}-500 text-white shadow-md ring-{{ $statusDetails['color'] }}-500
                                @else
                                    bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 hover:bg-{{ $statusDetails['color'] }}-100 dark:hover:bg-{{ $statusDetails['color'] }}-800/50
                                @endif
                            ">
                            <i class="{{ $statusDetails['icon'] }}"></i>
                            {{ $statusDetails['label'] }}
                        </button>
                    @endforeach

                    {{-- مؤشر التحميل (يظهر عند تحديث حالة هذا الطالب فقط) --}}
                    <div wire:loading wire:target="updateAttendance({{ $student->id }})">
                        <i class="bi bi-arrow-repeat animate-spin text-blue-500"></i>
                    </div>
                </div>
            </div>
        @empty
            {{-- رسالة في حال عدم وجود طلاب في هذه المادة --}}
            <div class="text-center py-8">
                <i class="bi bi-people-fill text-4xl text-gray-400"></i>
                <p class="mt-2 text-gray-500 dark:text-gray-400">لا يوجد طلاب مسجلون في هذه المادة حتى الآن.</p>
            </div>
        @endforelse
    </div>
</div>
