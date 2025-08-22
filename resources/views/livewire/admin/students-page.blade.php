<div> {{-- هذا هو العنصر الجذري الوحيد الذي يحيط بكل المحتوى --}}

    {{-- 1. الهيدر المدمج والذكي --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">إدارة الطلاب</h1>
            <p class="mt-1 text-zinc-500 dark:text-zinc-400">إدارة شاملة لبيانات الطلاب وتسجيلهم في النظام.</p>
        </div>
        <div class="w-full md:w-auto flex items-center gap-2">
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" placeholder="بحث سريع..." class="w-full pr-11 pl-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <button wire:click="openForm" class="flex-shrink-0 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2.5 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 shadow-md shadow-indigo-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>إضافة طالب</span>
            </button>
        </div>
    </div>

    {{-- 2. قسم الفلاتر المحسن --}}
    <div class="bg-white dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6 mb-8 shadow-lg">
        <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
            </svg>
            البحث والتصفية
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Batch Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الدفعة</label>
                <select wire:model.live="filter_batch_id"
                        class="w-full py-3 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="">جميع الدفعات</option>
                    @foreach($this->batches as $batch)
                        <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Academic Year Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">السنة</label>
                <select wire:model.live="filter_academic_year"
                        class="w-full py-3 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="">جميع السنوات</option>
                    @foreach($academicYearsOptions as $year)
                        <option value="{{ $year }}">السنة {{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Semester Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الترم</label>
                <select wire:model.live="filter_semester"
                        class="w-full py-3 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="">جميع الترمات</option>
                    @foreach($semestersOptions as $sem)
                        <option value="{{ $sem }}">الترم {{ $sem }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الحالة</label>
                <select wire:model.live="filter_status"
                        class="w-full py-3 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="">جميع الحالات</option>
                    @foreach($statuses as $statusOption)
                        <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- 3. شبكة البطاقات الفنية بالألوان للطلاب --}}
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

            @forelse($students as $student)
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
                                <div class="w-16 h-16 flex-shrink-0 rounded-xl overflow-hidden border-2 {{ $theme['border'] }}">
                                    @if($student->profile_image)
                                        <img class="w-full h-full object-cover"
                                             src="{{ Storage::url($student->profile_image) }}"
                                             alt="صورة الطالب">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-700 dark:to-zinc-800 flex items-center justify-center text-zinc-500 dark:text-zinc-400 text-xs font-semibold">
                                            لا توجد
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold {{ $theme['text'] }} mb-1">الطالب</p>
                                    <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight">{{ $student->name }}</h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ $student->student_id_number }}</p>
                                </div>
                            </div>

                            <div class="mt-4 space-y-3">
                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الدفعة</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                        {{ $student->batch->name ?? 'غير محدد' }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">التخصص</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
                                        {{ $student->batch->specialization->name ?? 'غير محدد' }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">القسم</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-cyan-100 dark:bg-cyan-900 text-cyan-800 dark:text-cyan-200">
                                        {{ $student->batch->specialization->department->name ?? 'غير محدد' }}
                                    </span>
                                </div>

                                <div class="flex gap-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        السنة {{ $student->current_academic_year }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                                        الترم {{ $student->current_semester }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الحالة</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                        {{ $student->status }}
                                    </span>
                                </div>

                                @if($student->email)
                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">البريد الإلكتروني</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 break-all">{{ Str::limit($student->email, 25) }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                            تم الإنشاء: {{ $student->created_at->format('Y/m/d') }}
                        </div>
                    </div>

                    <!-- أزرار التحكم التي تظهر عند الـ Hover -->
                    <div class="absolute inset-0 {{ $theme['overlay'] }} dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button wire:click="edit({{ $student->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button wire:click="confirmDelete({{ $student->id }})" class="w-14 h-14 flex items-center justify-center bg-red-500/30 hover:bg-red-500/40 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            @empty
                {{-- حالة عدم وجود بيانات --}}
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-indigo-300 dark:border-zinc-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">ابدأ ببناء قاعدة الطلاب</h3>
                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">لم تقم بإضافة أي طالب بعد. ابدأ الآن وأنشئ قاعدة بيانات الطلاب.</p>
                    <button wire:click="openForm" class="mt-6 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 mx-auto shadow-md shadow-indigo-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>إضافة أول طالب</span>
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($students->hasPages())
    <div class="mt-8">
        {{ $students->links() }}
    </div>
    @endif

    {{-- النوافذ المنبثقة (Modals) بتصميم فخم بالألوان --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-form')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>

            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $edit_id ? 'تعديل بيانات الطالب' : 'إضافة طالب جديد' }}</h2>
                <button wire:click="closeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="flex-grow p-6 space-y-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- اسم الطالب -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">اسم الطالب <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            wire:model="name"
                            placeholder="أدخل اسم الطالب الكامل..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            required
                        >
                        @error('name') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- الرقم الجامعي -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الرقم الجامعي <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            wire:model="student_id_number"
                            placeholder="أدخل الرقم الجامعي..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            required
                        >
                        @error('student_id_number') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- البريد الإلكتروني -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">البريد الإلكتروني <span class="text-red-500">*</span></label>
                        <input
                            type="email"
                            wire:model="email"
                            placeholder="أدخل البريد الإلكتروني..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            required
                        >
                        @error('email') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- رقم الهاتف -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">رقم الهاتف (اختياري)</label>
                        <input
                            type="text"
                            wire:model="phone"
                            placeholder="أدخل رقم الهاتف..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                        >
                        @error('phone') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- الجنس -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الجنس (اختياري)</label>
                        <select
                            wire:model="gender"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                        >
                            <option value="">اختر الجنس</option>
                            <option value="ذكر">ذكر</option>
                            <option value="أنثى">أنثى</option>
                        </select>
                        @error('gender') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- تاريخ الميلاد -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">تاريخ الميلاد (اختياري)</label>
                        <input
                            type="date"
                            wire:model="date_of_birth"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                        >
                        @error('date_of_birth') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- العنوان -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">العنوان (اختياري)</label>
                        <input
                            type="text"
                            wire:model="address"
                            placeholder="أدخل العنوان..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                        >
                        @error('address') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- الصورة الشخصية -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الصورة الشخصية (اختياري)</label>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <input
                                    type="file"
                                    wire:model="profile_image"
                                    accept="image/*"
                                    class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300"
                                >
                            </div>
                            @if ($profile_image)
                                <img src="{{ $profile_image->temporaryUrl() }}" class="w-20 h-20 rounded-xl object-cover border border-zinc-200 dark:border-zinc-600">
                            @elseif ($old_profile_image)
                                <img src="{{ Storage::url($old_profile_image) }}" class="w-20 h-20 rounded-xl object-cover border border-zinc-200 dark:border-zinc-600">
                            @else
                                <div class="w-20 h-20 rounded-xl bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center border border-zinc-200 dark:border-zinc-600">
                                    <svg class="w-8 h-8 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        @error('profile_image') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- القسم -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">القسم <span class="text-red-500">*</span></label>
                        <select
                            wire:model.live="selected_department_id_for_form"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            required
                        >
                            <option value="">اختر القسم</option>
                            @foreach($this->departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('selected_department_id_for_form') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- التخصص -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">التخصص <span class="text-red-500">*</span></label>
                        <select
                            wire:model.live="selected_specialization_id_for_form"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                            required
                            @if(!$selected_department_id_for_form) disabled @endif
                        >
                            <option value="">اختر التخصص</option>
                            @foreach($this->formSpecializations as $spec)
                                <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                            @endforeach
                        </select>
                        @error('selected_specialization_id_for_form') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- الدفعة -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الدفعة <span class="text-red-500">*</span></label>
                        <select
                            wire:model.live="batch_id"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                            required
                            @if(!$selected_specialization_id_for_form) disabled @endif
                        >
                            <option value="">اختر الدفعة</option>
                            @foreach($this->formBatches as $batch)
                                <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                            @endforeach
                        </select>
                        @error('batch_id') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- السنة والترم المستنتجين -->
                    @if($inferred_academic_year && $inferred_semester)
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">السنة الدراسية (مستنتجة)</label>
                            <div class="flex items-center gap-3 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-green-800 dark:text-green-200 font-medium">السنة {{ $inferred_academic_year }}</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الترم (مستنتج)</label>
                            <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-blue-800 dark:text-blue-200 font-medium">الترم {{ $inferred_semester }}</span>
                            </div>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">السنة الدراسية (مستنتجة)</label>
                            <div class="flex items-center gap-3 p-4 bg-zinc-50 dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 rounded-xl">
                                <div class="w-8 h-8 bg-zinc-100 dark:bg-zinc-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-zinc-600 dark:text-zinc-400">اختر دفعة أولاً</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الترم (مستنتج)</label>
                            <div class="flex items-center gap-3 p-4 bg-zinc-50 dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 rounded-xl">
                                <div class="w-8 h-8 bg-zinc-100 dark:bg-zinc-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-zinc-600 dark:text-zinc-400">اختر دفعة أولاً</span>
                            </div>
                        </div>
                    @endif

                    <!-- الحالة -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الحالة <span class="text-red-500">*</span></label>
                        <select
                            wire:model="status"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            required
                        >
                            <option value="">اختر الحالة</option>
                            @foreach($statuses as $statusOption)
                                <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                            @endforeach
                        </select>
                        @error('status') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- حقول كلمة المرور -->
                    @if(!$edit_id)
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">كلمة المرور <span class="text-red-500">*</span></label>
                        <input
                            type="password"
                            wire:model="password"
                            placeholder="أدخل كلمة المرور..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            autocomplete="new-password"
                        >
                        @error('password') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">تأكيد كلمة المرور <span class="text-red-500">*</span></label>
                        <input
                            type="password"
                            wire:model="password_confirmation"
                            placeholder="أعد إدخال كلمة المرور..."
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            autocomplete="new-password"
                        >
                        @error('password_confirmation') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    @else
                    <div class="md:col-span-2 border-t pt-6 mt-6 border-zinc-200 dark:border-zinc-700">
                        <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">تغيير كلمة المرور (اختياري)</h4>
                                    <p class="text-xs text-yellow-700 dark:text-yellow-300">اتركها فارغة إذا كنت لا تريد تغيير كلمة المرور</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">كلمة المرور الجديدة</label>
                                <input
                                    type="password"
                                    wire:model="password"
                                    placeholder="كلمة المرور الجديدة..."
                                    class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                    autocomplete="new-password"
                                >
                                @error('password') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">تأكيد كلمة المرور الجديدة</label>
                                <input
                                    type="password"
                                    wire:model="password_confirmation"
                                    placeholder="تأكيد كلمة المرور الجديدة..."
                                    class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                    autocomplete="new-password"
                                >
                                @error('password_confirmation') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-indigo-500/20">
                    <span wire:loading.remove wire:target="save">{{ $edit_id ? 'حفظ التعديلات' : 'إضافة الطالب' }}</span>
                    <span wire:loading wire:target="save">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if($delete_id)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.set('delete_id', null)" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>

            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="mt-5 text-lg font-bold text-zinc-900 dark:text-white">تأكيد عملية الحذف</h3>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">هل أنت متأكد من حذف هذا الطالب؟ سيتم حذف جميع بياناته نهائياً. لا يمكن التراجع عن هذا الإجراء.</p>
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

</div>
