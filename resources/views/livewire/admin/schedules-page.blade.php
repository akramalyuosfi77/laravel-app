<div>
    {{-- 1. الهيدر المدمج والذكي --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">إدارة الجداول الدراسية</h1>
            <p class="mt-1 text-zinc-500 dark:text-zinc-400">تخطيط وتنظيم المواعيد الأكاديمية بكفاءة.</p>
        </div>
        <div class="w-full md:w-auto flex items-center gap-2">
            <button wire:click="$set('showForm', true)" class="flex-shrink-0 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2.5 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 shadow-md shadow-indigo-500/20">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18" /></svg>
                <span>إضافة موعد</span>
            </button>
        </div>
    </div>

   {{-- 2. شبكة بطاقات الجداول (تم تحسين العرض ) --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-8">
            @php
                $colorThemes = [
                    ['gradient' => 'from-indigo-500 to-purple-500', 'border' => 'border-indigo-500', 'text' => 'text-indigo-500', 'overlay' => 'bg-gradient-to-br from-indigo-500/70 to-purple-500/70'],
                    ['gradient' => 'from-teal-500 to-emerald-500', 'border' => 'border-teal-500', 'text' => 'text-teal-500', 'overlay' => 'bg-gradient-to-br from-teal-500/70 to-emerald-500/70'],
                    ['gradient' => 'from-amber-500 to-orange-500', 'border' => 'border-amber-500', 'text' => 'text-amber-500', 'overlay' => 'bg-gradient-to-br from-amber-500/70 to-orange-500/70'],
                    ['gradient' => 'from-rose-500 to-pink-500', 'border' => 'border-rose-500', 'text' => 'text-rose-500', 'overlay' => 'bg-gradient-to-br from-rose-500/70 to-pink-500/70'],
                    ['gradient' => 'from-blue-500 to-cyan-500', 'border' => 'border-blue-500', 'text' => 'text-blue-500', 'overlay' => 'bg-gradient-to-br from-blue-500/70 to-cyan-500/70'],
                    ['gradient' => 'from-violet-500 to-fuchsia-500', 'border' => 'border-violet-500', 'text' => 'text-violet-500', 'overlay' => 'bg-gradient-to-br from-violet-500/70 to-fuchsia-500/70'],
                ];
            @endphp

            @forelse($schedules as $schedule)
                @php
                    $theme = $colorThemes[$loop->index % count($colorThemes)];
                @endphp

                <div class="group relative bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1.5">
                    <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-5 dark:opacity-10 rounded-2xl -z-10"></div>

                    <div class="flex flex-col h-full">
                        <div class="flex-grow">
                            <div class="text-center mb-4">
                                <span class="px-4 py-1.5 text-sm font-bold rounded-full bg-opacity-20 {{ $theme['text'] }} bg-current">{{ __($schedule->day_of_week) }}</span>
                            </div>

                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between items-start gap-2">
                                    <span class="font-semibold text-zinc-500 dark:text-zinc-400 flex-shrink-0">المادة:</span>
                                    <span class="text-zinc-800 dark:text-zinc-200 font-bold text-left">{{ $schedule->coursePlan->course->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between items-start gap-2">
                                    <span class="font-semibold text-zinc-500 dark:text-zinc-400 flex-shrink-0">التخصص:</span>
                                    <span class="text-zinc-600 dark:text-zinc-300 text-left">{{ $schedule->coursePlan->specialization->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between items-start gap-2">
                                    <span class="font-semibold text-zinc-500 dark:text-zinc-400 flex-shrink-0">الدكتور:</span>
                                    <span class="text-zinc-600 dark:text-zinc-300 text-left">{{ $schedule->coursePlan->doctor->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between items-start gap-2">
                                    <span class="font-semibold text-zinc-500 dark:text-zinc-400 flex-shrink-0">القاعة:</span>
                                    <span class="text-zinc-600 dark:text-zinc-300 text-left">{{ $schedule->location->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 text-center">
                            <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">التوقيت</p>
                            <div class="font-mono text-lg font-bold {{ $theme['text'] }}">
                                <span>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</span>
                                <span class="text-zinc-400 dark:text-zinc-500 mx-2">-</span>
                                <span>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="absolute inset-0 {{ $theme['overlay'] }} dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button wire:click="edit({{ $schedule->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button wire:click="confirmDelete({{ $schedule->id }})" class="w-14 h-14 flex items-center justify-center bg-red-500/30 hover:bg-red-500/40 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-indigo-300 dark:border-zinc-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18" /></svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">ابدأ بتنظيم الوقت</h3>
                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">لم تقم بإضافة أي مواعيد دراسية بعد. ابدأ الآن لإنشاء جدول منظم.</p>
                    <button wire:click="$set('showForm', true )" class="mt-6 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 mx-auto shadow-md shadow-indigo-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>إضافة أول موعد</span>
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($schedules->hasPages())
    <div class="mt-8">
        {{ $schedules->links() }}
    </div>
    @endif

    {{-- 💡 Add/Edit Modal with Chained Selects --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('resetForm')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $schedule_id ? 'تعديل الموعد الدراسي' : 'إضافة موعد جديد' }}</h2>
                <button wire:click="resetForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="flex-grow p-6 space-y-5 overflow-y-auto">
                {{-- 💡 1. Chained Selects Section --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 p-5 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                    {{-- Department --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">1. اختر القسم</label>
                        <select wire:model.live="selectedDepartment" class="w-full custom-select">
                            <option value="">-- اختر القسم --</option>
                            @foreach($this->departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Specialization --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">2. اختر التخصص</label>
                        <select wire:model.live="selectedSpecialization" class="w-full custom-select" @if(!$selectedDepartment) disabled @endif>
                            <option value="">-- اختر التخصص --</option>
                            @foreach($this->specializations as $specialization)
                                <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Course --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">3. اختر المادة</label>
                        <select wire:model.live="selectedCourse" class="w-full custom-select" @if(!$selectedSpecialization) disabled @endif>
                            <option value="">-- اختر المادة --</option>
                            @foreach($this->courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Course Plan --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">4. اختر الخطة <span class="text-red-500">*</span></label>
                        <select wire:model="specialization_course_academic_period_id" class="w-full custom-select" @if(!$selectedCourse) disabled @endif>
                            <option value="">-- اختر السنة والترم والدكتور --</option>
                            @foreach($this->coursePlans as $plan)
                                <option value="{{ $plan->id }}">
                                    سنة {{ $plan->academic_year }} / ترم {{ $plan->semester }} (د. {{ $plan->doctor->name ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('specialization_course_academic_period_id') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- 💡 2. Rest of the form --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">القاعة/المعمل <span class="text-red-500">*</span></label>
                        <select wire:model="location_id" class="w-full custom-select">
                            <option value="">-- اختر القاعة --</option>
                            @foreach($this->locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                        @error('location_id') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">اليوم <span class="text-red-500">*</span></label>
                        <select wire:model="day_of_week" class="w-full custom-select">
                            <option value="">-- اختر اليوم --</option>
                            <option value="Saturday">السبت</option>
                            <option value="Sunday">الأحد</option>
                            <option value="Monday">الإثنين</option>
                            <option value="Tuesday">الثلاثاء</option>
                            <option value="Wednesday">الأربعاء</option>
                            <option value="Thursday">الخميس</option>
                        </select>
                        @error('day_of_week') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">وقت البدء <span class="text-red-500">*</span></label>
                        <input type="time" wire:model.lazy="start_time" class="w-full custom-select">
                        @error('start_time') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">وقت الانتهاء <span class="text-red-500">*</span></label>
                        <input type="time" wire:model.lazy="end_time" class="w-full custom-select">
                        @error('end_time') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="resetForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-indigo-500/20">
                    <span wire:loading.remove wire:target="save">{{ $schedule_id ? 'حفظ التعديلات' : 'إنشاء الموعد' }}</span>
                    <span wire:loading wire:target="save">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Delete Confirmation Modal (يبقى كما هو) --}}
    @if($delete_id)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.set('delete_id', null)" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                </div>
                <h3 class="mt-5 text-lg font-bold text-zinc-900 dark:text-white">تأكيد عملية الحذف</h3>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">هل أنت متأكد من حذف هذا الموعد؟ لا يمكن التراجع عن هذا الإجراء.</p>
            </div>
            <div class="p-4 flex flex-col-reverse sm:flex-row gap-3 bg-zinc-50 dark:bg-zinc-800/50">
                <button wire:click="$set('delete_id', null)" class="w-full sm:w-1/2 px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button wire:click="delete" class="w-full sm:w-1/2 px-4 py-2.5 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-red-500/20">
                    <span wire:loading.remove wire:target="delete">نعم، قم بالحذف</span>
                    <span wire:loading wire:target="delete">جاري الحذف...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- 💡 إضافة كلاسات CSS مخصصة للقوائم المنسدلة --}}
    @push('styles')
    <style>
        .custom-select {
            @apply w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all;
        }
        .custom-select:disabled {
            @apply bg-zinc-100 dark:bg-zinc-700/50 cursor-not-allowed;
        }
    </style>
    @endpush
</div>
