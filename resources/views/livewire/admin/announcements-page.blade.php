<div>
    {{-- 1. الهيدر المدمج والذكي --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">إدارة الإعلانات</h1>
            <p class="mt-1 text-zinc-500 dark:text-zinc-400">تواصل، أعلن، وشارك المعلومات بفعالية.</p>
        </div>
        <div class="w-full md:w-auto flex items-center gap-2">
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" placeholder="بحث في الإعلانات..." class="w-full pr-11 pl-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <button wire:click="openForm" class="flex-shrink-0 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2.5 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 shadow-md shadow-indigo-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>إضافة إعلان</span>
            </button>
        </div>
    </div>

    {{-- 2. فلاتر البحث والتصفية الأنيقة --}}
    <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 mb-8 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">فلتر حسب المستوى</label>
                <select wire:model.live="filter_level" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">جميع المستويات</option>
                    <option value="info">معلومات</option>
                    <option value="success">نجاح</option>
                    <option value="warning">تحذير</option>
                    <option value="danger">خطر</option>
                </select>
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">فلتر حسب الجمهور</label>
                <select wire:model.live="filter_target_type" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">جميع الجماهير</option>
                    <option value="global_all">الجميع</option>
                    <option value="global_students">الطلاب فقط</option>
                    <option value="global_doctors">الدكاترة فقط</option>
                    <option value="department">قسم معين</option>
                    <option value="specialization">تخصص معين</option>
                    <option value="course">مادة معينة</option>
                </select>
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">فلتر حسب التاريخ</label>
                <select wire:model.live="filter_date" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">جميع التواريخ</option>
                    <option value="today">اليوم</option>
                    <option value="week">هذا الأسبوع</option>
                    <option value="month">هذا الشهر</option>
                    <option value="expired">منتهية الصلاحية</option>
                </select>
            </div>
        </div>
    </div>

    {{-- 3. شبكة بطاقات الإعلانات الفنية بالألوان --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-8">
            @php
                // مصفوفة الألوان لكل بطاقة حسب مستوى الأهمية
                $levelThemes = [
                    'info' => [
                        'gradient' => 'from-blue-500 to-cyan-500',
                        'border' => 'border-blue-500',
                        'text' => 'text-blue-500',
                        'overlay' => 'bg-gradient-to-br from-blue-500/70 to-cyan-500/70',
                        'bg' => 'bg-blue-100 dark:bg-blue-900/30',
                        'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    'success' => [
                        'gradient' => 'from-emerald-500 to-teal-500',
                        'border' => 'border-emerald-500',
                        'text' => 'text-emerald-500',
                        'overlay' => 'bg-gradient-to-br from-emerald-500/70 to-teal-500/70',
                        'bg' => 'bg-emerald-100 dark:bg-emerald-900/30',
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    'warning' => [
                        'gradient' => 'from-amber-500 to-orange-500',
                        'border' => 'border-amber-500',
                        'text' => 'text-amber-500',
                        'overlay' => 'bg-gradient-to-br from-amber-500/70 to-orange-500/70',
                        'bg' => 'bg-amber-100 dark:bg-amber-900/30',
                        'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z'
                    ],
                    'danger' => [
                        'gradient' => 'from-red-500 to-rose-500',
                        'border' => 'border-red-500',
                        'text' => 'text-red-500',
                        'overlay' => 'bg-gradient-to-br from-red-500/70 to-rose-500/70',
                        'bg' => 'bg-red-100 dark:bg-red-900/30',
                        'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z'
                    ],
                ];
            @endphp

            @forelse($announcements as $announcement)
                @php
                    $theme = $levelThemes[$announcement->level] ?? $levelThemes['info'];
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
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $theme['icon'] }}" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $theme['text'] }} {{ $theme['bg'] }}">
                                            {{ __($announcement->level) }}
                                        </span>
                                        @if($announcement->expires_at && $announcement->expires_at->isPast())
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full text-red-600 bg-red-100 dark:bg-red-900/30">
                                                منتهي
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight">{{ $announcement->title }}</h3>
                                </div>
                            </div>

                            <div class="mt-4">
                                <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المحتوى</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-300 line-clamp-3">
                                    {{ Str::limit($announcement->content, 120) }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الجمهور المستهدف</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ __($announcement->target_type) }}
                                    @if($announcement->target_id)
                                        <span class="text-zinc-500 dark:text-zinc-400">
                                            ({{ \App\Models\Department::find($announcement->target_id)->name ?? \App\Models\Specialization::find($announcement->target_id)->name ?? \App\Models\Course::find($announcement->target_id)->name ?? 'ID: ' . $announcement->target_id }})
                                        </span>
                                    @endif
                                </p>
                            </div>

                            <div class="mt-4">
                                <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الناشر</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $announcement->user->name ?? 'غير معروف' }}</p>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-between items-center text-xs text-zinc-500 dark:text-zinc-400">
                            <span>تم النشر: {{ $announcement->created_at->format('Y/m/d') }}</span>
                            @if($announcement->expires_at)
                                <span>ينتهي: {{ $announcement->expires_at->format('Y/m/d') }}</span>
                            @else
                                <span>لا ينتهي</span>
                            @endif
                        </div>
                    </div>

                    <!-- أزرار التحكم التي تظهر عند الـ Hover -->
                    <div class="absolute inset-0 {{ $theme['overlay'] }} dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button wire:click="edit({{ $announcement->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button wire:click="confirmDelete({{ $announcement->id }})" class="w-14 h-14 flex items-center justify-center bg-red-500/30 hover:bg-red-500/40 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            @empty
                {{-- حالة عدم وجود بيانات --}}
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-indigo-300 dark:border-zinc-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">ابدأ التواصل الآن</h3>
                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">لم تقم بإضافة أي إعلان بعد. ابدأ الآن وشارك المعلومات المهمة.</p>
                    <button wire:click="openForm" class="mt-6 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 mx-auto shadow-md shadow-indigo-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>إضافة أول إعلان</span>
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($announcements->hasPages())
    <div class="mt-8">
        {{ $announcements->links() }}
    </div>
    @endif

    {{-- النوافذ المنبثقة (Modals) بتصميم فخم بالألوان --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-form')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>

            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $announcement_id ? 'تعديل الإعلان' : 'إضافة إعلان جديد' }}</h2>
                <button wire:click="closeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="flex-grow p-6 space-y-5 overflow-y-auto">
                {{-- حقل العنوان --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">عنوان الإعلان <span class="text-red-500">*</span></label>
                    <input id="title" wire:model="title" type="text" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="مثال: إعلان مهم للطلاب">
                    @error('title') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- حقل المحتوى --}}
                <div>
                    <label for="content" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">محتوى الإعلان <span class="text-red-500">*</span></label>
                    <textarea id="content" wire:model="content" rows="5" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-y transition-all" placeholder="أدخل محتوى الإعلان هنا..."></textarea>
                    @error('content') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- حقل مستوى الأهمية --}}
                    <div>
                        <label for="level" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">مستوى الأهمية <span class="text-red-500">*</span></label>
                        <select id="level" wire:model="level" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="">اختر المستوى</option>
                            <option value="info">معلومات</option>
                            <option value="success">نجاح</option>
                            <option value="warning">تحذير</option>
                            <option value="danger">خطر</option>
                        </select>
                        @error('level') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- حقل تاريخ الانتهاء --}}
                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">تاريخ الانتهاء (اختياري)</label>
                        <input id="expires_at" wire:model="expires_at" type="datetime-local" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        @error('expires_at') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- حقول الجمهور المستهدف المتسلسلة --}}
                <div class="border-t border-zinc-200 dark:border-zinc-700 pt-5 mt-5">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-4">الجمهور المستهدف <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="target_audience_type" class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">نوع الجمهور</label>
                            <select id="target_audience_type" wire:model.live="target_audience_type" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                <option value="">-- اختر نوع الجمهور --</option>
                                <option value="general">عام</option>
                                <option value="department">قسم معين</option>
                                <option value="specialization">تخصص معين</option>
                            </select>
                            @error('target_audience_type') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>

                        {{-- يظهر فقط إذا كان الجمهور "عام" --}}
                        @if($target_audience_type === 'general')
                            <div>
                                <label for="general_target_role" class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">الفئة المستهدفة</label>
                                <select id="general_target_role" wire:model="general_target_role" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                    <option value="">-- اختر الفئة --</option>
                                    <option value="global_all">الجميع</option>
                                    <option value="global_students">الطلاب فقط</option>
                                    <option value="global_doctors">الدكاترة فقط</option>
                                </select>
                                @error('general_target_role') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        {{-- يظهر فقط إذا كان الجمهور "قسم" أو "تخصص" --}}
                        @if($target_audience_type === 'department' || $target_audience_type === 'specialization')
                            <div>
                                <label for="department_id" class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">القسم</label>
                                <select id="department_id" wire:model.live="department_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                    <option value="">-- اختر القسم --</option>
                                    @foreach($this->departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        {{-- يظهر فقط إذا كان الجمهور "تخصص" وتم اختيار قسم --}}
                        @if($target_audience_type === 'specialization' && $department_id)
                            <div>
                                <label for="specialization_id" class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">التخصص</label>
                                <select id="specialization_id" wire:model="specialization_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                    <option value="">-- اختر التخصص --</option>
                                    @foreach($this->specializations as $specialization)
                                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                                    @endforeach
                                </select>
                                @error('specialization_id') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                        @endif
                    </div>
                </div>
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-indigo-500/20">
                    <span wire:loading.remove wire:target="save">{{ $announcement_id ? 'حفظ التعديلات' : 'نشر الإعلان' }}</span>
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
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">هل أنت متأكد من حذف هذا الإعلان؟ لا يمكن التراجع عن هذا الإجراء.</p>
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



{{-- إضافة الأنماط المخصصة --}}
<style>
    /* تحسينات إضافية للتصميم */
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* تأثيرات الانتقال الناعمة */
    .transition-all {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* تحسين الظلال */
    .shadow-md {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* تحسين الألوان الديناميكية */
    .bg-blue-100 { background-color: #dbeafe; }
    .bg-emerald-100 { background-color: #d1fae5; }
    .bg-amber-100 { background-color: #fef3c7; }
    .bg-red-100 { background-color: #fee2e2; }

    .dark .bg-blue-900\/30 { background-color: rgba(30, 58, 138, 0.3); }
    .dark .bg-emerald-900\/30 { background-color: rgba(6, 78, 59, 0.3); }
    .dark .bg-amber-900\/30 { background-color: rgba(120, 53, 15, 0.3); }
    .dark .bg-red-900\/30 { background-color: rgba(127, 29, 29, 0.3); }

    /* تحسين التفاعلية */
    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }

    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }

    /* تحسين الخطوط */
    body {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* تحسين الاستجابة */
    @media (max-width: 768px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3.2xl\:grid-cols-4 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    @media (min-width: 768px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3.2xl\:grid-cols-4 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1280px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3.2xl\:grid-cols-4 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (min-width: 1536px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3.2xl\:grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    /* تحسين الألوان المخصصة */
    .bg-blue-100 { background-color: #dbeafe !important; }
    .bg-emerald-100 { background-color: #d1fae5 !important; }
    .bg-amber-100 { background-color: #fef3c7 !important; }
    .bg-red-100 { background-color: #fee2e2 !important; }

    .dark .bg-blue-900\/30 { background-color: rgba(30, 58, 138, 0.3) !important; }
    .dark .bg-emerald-900\/30 { background-color: rgba(6, 78, 59, 0.3) !important; }
    .dark .bg-amber-900\/30 { background-color: rgba(120, 53, 15, 0.3) !important; }
    .dark .bg-red-900\/30 { background-color: rgba(127, 29, 29, 0.3) !important; }
</style>


</div>
