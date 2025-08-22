<div> {{-- هذا هو العنصر الجذري الوحيد الذي يحيط بكل المحتوى --}}

    {{-- 1. الهيدر المدمج والذكي --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">إدارة المشاريع</h1>
            <p class="mt-1 text-zinc-500 dark:text-zinc-400">إدارة شاملة لمشاريع الطلاب وحالاتها.</p>
        </div>
        <div class="w-full md:w-auto flex items-center gap-2">
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" placeholder="بحث سريع..." class="w-full pr-11 pl-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الحالة</label>
                <select wire:model.live="filter_status"
                        class="w-full py-3 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="">جميع الحالات</option>
                    @foreach($projectStatuses as $statusOption)
                        <option value="{{ $statusOption }}">{{ __($statusOption) }}</option>
                    @endforeach
                </select>
            </div>

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

            <!-- Specialization Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">التخصص</label>
                <select wire:model.live="filter_specialization_id"
                        class="w-full py-3 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="">جميع التخصصات</option>
                    @foreach($this->specializations as $spec)
                        <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Course Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">المادة</label>
                <select wire:model.live="filter_course_id"
                        class="w-full py-3 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="">جميع المواد</option>
                    @foreach( $this->courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Creator Student Filter -->
            <div class="xl:col-span-2">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الطالب المنشئ</label>
                <select wire:model.live="filter_creator_student_id"
                        class="w-full py-3 px-4 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="">جميع الطلاب</option>
                    @foreach($this->students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- 3. شبكة البطاقات الفنية بالألوان للمشاريع --}}
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

            @forelse($projects as $project)
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
                                <div class="w-16 h-16 flex-shrink-0 rounded-xl overflow-hidden border-2 {{ $theme['border'] }} bg-gradient-to-br {{ $theme['gradient'] }} flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold {{ $theme['text'] }} mb-1">المشروع</p>
                                    <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight">{{ Str::limit($project->title, 40) }}</h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ $project->creatorStudent->name ?? 'غير محدد' }}</p>
                                </div>
                            </div>

                            <div class="mt-4 space-y-3">
                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المادة</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                        {{ $project->course->name ?? 'غير محدد' }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الدفعة</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
                                        {{ $project->batch->name ?? 'غير محدد' }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">التخصص</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-cyan-100 dark:bg-cyan-900 text-cyan-800 dark:text-cyan-200">
                                        {{ $project->specialization->name ?? 'غير محدد' }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الحالة</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($project->status == 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                        @elseif($project->status == 'approved') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                        @elseif($project->status == 'rejected') bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                        @elseif($project->status == 'completed') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                        @endif">
                                        {{ __($project->status) }}
                                    </span>
                                </div>

                                @if($project->description)
                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الوصف</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ Str::limit($project->description, 80) }}</p>
                                </div>
                                @endif

                                <div class="flex gap-4 text-xs text-zinc-500 dark:text-zinc-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        {{ $project->likes_count }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        {{ $project->comments_count }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                            تم الإنشاء: {{ $project->created_at->format('Y/m/d') }}
                        </div>
                    </div>

                    <!-- أزرار التحكم التي تظهر عند الـ Hover -->
                    <div class="absolute inset-0 {{ $theme['overlay'] }} dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button wire:click="viewProject({{ $project->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                        <button wire:click="openChangeStatusModal({{ $project->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </button>
                        <button wire:click="confirmDelete({{ $project->id }})" class="w-14 h-14 flex items-center justify-center bg-red-500/30 hover:bg-red-500/40 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            @empty
                {{-- حالة عدم وجود بيانات --}}
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-indigo-300 dark:border-zinc-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">لا توجد مشاريع</h3>
                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">لم يتم العثور على أي مشاريع تطابق معايير البحث.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($projects->hasPages())
    <div class="mt-8">
        {{ $projects->links() }}
    </div>
    @endif

    {{-- النوافذ المنبثقة (Modals) بتصميم فخم بالألوان --}}

    {{-- نافذة تغيير حالة المشروع --}}
    @if($showChangeStatusModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-change-status-modal')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-md flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-t-2xl"></div>

            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تغيير حالة المشروع</h2>
                <button wire:click="closeChangeStatusModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="saveStatus" class="flex-grow p-6">
                <div>
                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الحالة الجديدة <span class="text-red-500">*</span></label>
                    <select
                        wire:model="status"
                        class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                        required
                    >
                        <option value="">اختر الحالة</option>
                        @foreach($projectStatuses as $statusOption)
                            <option value="{{ $statusOption }}">{{ __($statusOption) }}</option>
                        @endforeach
                    </select>
                    @error('status') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                </div>
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeChangeStatusModal" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="saveStatus" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-purple-500/20">
                    <span wire:loading.remove wire:target="saveStatus">حفظ التغيير</span>
                    <span wire:loading wire:target="saveStatus">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- نافذة تأكيد الحذف --}}
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
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">هل أنت متأكد من حذف هذا المشروع؟ سيتم حذف جميع الملفات والإعجابات والتعليقات المرتبطة به. لا يمكن التراجع عن هذا الإجراء.</p>
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

    {{-- نافذة عرض تفاصيل المشروع --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-view-modal')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-6xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-t-2xl"></div>

            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تفاصيل المشروع: {{ $viewedProject->title ?? '' }}</h2>
                <button wire:click="closeViewModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-grow p-6 overflow-y-auto">
                <!-- معلومات أساسية -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl">
                        <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 mb-1">عنوان المشروع</p>
                        <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $viewedProject->title ?? '' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl">
                        <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 mb-1">المادة</p>
                        <p class="text-lg text-zinc-900 dark:text-white">{{ $viewedProject->course->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl">
                        <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 mb-1">المنشئ</p>
                        <p class="text-lg text-zinc-900 dark:text-white">{{ $viewedProject->creatorStudent->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl">
                        <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 mb-1">الدفعة</p>
                        <p class="text-lg text-zinc-900 dark:text-white">{{ $viewedProject->batch->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl">
                        <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 mb-1">التخصص</p>
                        <p class="text-lg text-zinc-900 dark:text-white">{{ $viewedProject->specialization->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl">
                        <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 mb-1">الحالة</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($viewedProject->status == 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                            @elseif($viewedProject->status == 'approved') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                            @elseif($viewedProject->status == 'rejected') bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                            @elseif($viewedProject->status == 'completed') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                            @endif">
                            {{ __($viewedProject->status) }}
                        </span>
                    </div>
                </div>

                <!-- الوصف -->
                @if($viewedProject->description)
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        الوصف
                    </h3>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl">
                        <p class="text-zinc-900 dark:text-white">{{ $viewedProject->description }}</p>
                    </div>
                </div>
                @endif

                <!-- الطلاب المشاركون -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                        الطلاب المشاركون
                    </h3>
                    @if($viewedProject->students->isNotEmpty())
                        <div class="flex flex-wrap gap-3">
                            @foreach($viewedProject->students as $participant)
                                <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-2 rounded-full text-sm font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $participant->name }}
                                    @if($participant->id == $viewedProject->creatorStudent->id)
                                        <span class="bg-yellow-200 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-200 px-2 py-0.5 rounded text-xs">(المنشئ)</span>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-zinc-600 dark:text-zinc-400">لا يوجد طلاب مشاركون في هذا المشروع.</p>
                    @endif
                </div>

                <!-- الملفات المرفقة -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                        </svg>
                        الملفات المرفقة
                    </h3>
                    @if($viewedProject->files->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($viewedProject->files as $file)
                                <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 shadow-sm bg-white dark:bg-zinc-800/50 flex flex-col">
                                    @if(Str::startsWith($file->file_type, 'image'))
                                        <img src="{{ Storage::url($file->file_path) }}" alt="{{ $file->file_name }}" class="w-full h-32 object-cover rounded-lg mb-3">
                                    @elseif(Str::startsWith($file->file_type, 'video'))
                                        <video controls class="w-full h-32 object-cover rounded-lg mb-3">
                                            <source src="{{ Storage::url($file->file_path) }}" type="{{ $file->file_type }}">
                                            متصفحك لا يدعم الفيديو.
                                        </video>
                                    @else
                                        <div class="w-full h-32 flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-lg mb-3 text-zinc-500 dark:text-zinc-400">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <p class="text-zinc-800 dark:text-white font-semibold text-sm truncate mb-2">{{ $file->file_name }}</p>
                                    <p class="text-zinc-600 dark:text-zinc-400 text-xs mb-3 flex-grow">{{ $file->description ?? 'لا يوجد وصف' }}</p>
                                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium flex items-center gap-2 mt-auto">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        عرض/تحميل
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-zinc-600 dark:text-zinc-400">لا توجد ملفات مرفقة بهذا المشروع.</p>
                    @endif
                </div>

                <!-- الإعجابات والتعليقات -->
                <div>
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        الإعجابات والتعليقات
                    </h3>
                    <div class="flex items-center gap-6 mb-6">
                        <span class="text-zinc-600 dark:text-zinc-400 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            {{ $viewedProject->likes_count }} إعجاب
                        </span>
                        <span class="text-zinc-600 dark:text-zinc-400 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            {{ $viewedProject->comments_count }} تعليق
                        </span>
                    </div>

                    @if($viewedProject->comments->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($viewedProject->comments->sortByDesc('created_at') as $comment)
                                <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-semibold text-zinc-800 dark:text-white">{{ $comment->user->name ?? 'مستخدم غير معروف' }}</span>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-zinc-700 dark:text-zinc-300">{{ $comment->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-zinc-600 dark:text-zinc-400">لا توجد تعليقات بعد.</p>
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
