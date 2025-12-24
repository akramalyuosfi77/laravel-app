<div>
    {{-- 1. Combined Hero & Filters Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-purple-50 to-fuchsia-50 dark:from-zinc-900 dark:via-slate-900 dark:to-zinc-900 border border-slate-200 dark:border-slate-800 shadow-xl" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
        {{-- Animated Background Orbs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-10 right-10 w-72 h-72 bg-purple-400/20 dark:bg-purple-600/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-fuchsia-400/20 dark:bg-fuchsia-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        {{-- Top Part: Hero Content --}}
        <div class="relative z-10 p-8 pb-10">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                {{-- Left Side: Animation --}}
                <div class="order-1 md:order-1 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-fuchsia-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                        <lottie-player
                            src="/animations/robot-analytics.json"
                            background="transparent"
                            speed="1"
                            style="width: 100%; max-width: 350px; height: auto;"
                            loop
                            autoplay>
                        </lottie-player>
                    </div>
                </div>

                {{-- Right Side: Content --}}
                <div class="order-2 md:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 dark:bg-purple-900/30 border border-purple-200 dark:border-purple-800 rounded-full mb-4">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                        </span>
                        <span class="text-sm font-bold text-purple-700 dark:text-purple-300">المشاريع والابتكارات</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-purple-700 to-fuchsia-700 dark:from-slate-100 dark:via-purple-300 dark:to-fuchsia-300 mb-4 leading-tight">
                        إدارة مشاريع الطلاب
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-300 mb-8 leading-relaxed">
                        منصة شاملة لعرض وإدارة مشاريع التخرج والابتكارات الطلابية، ومتابعة تقدمها وتقييمها.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <div class="group relative flex-1 min-w-[200px]">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-fuchsia-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition"></div>
                            <div class="relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input wire:model.live.debounce.300ms="search" placeholder="بحث عن مشروع..." class="bg-transparent border-0 focus:ring-0 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 w-full">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Part: Filters (Merged) --}}
        <div class="relative z-10 bg-white/40 dark:bg-black/20 backdrop-blur-md border-t border-white/20 dark:border-white/5 p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="p-1.5 bg-purple-100 dark:bg-purple-900/50 rounded-lg text-purple-600 dark:text-purple-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">تصفية متقدمة</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                <!-- Status Filter -->
                <div>
                    <select wire:model.live="filter_status" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع الحالات</option>
                        @foreach($projectStatuses as $statusOption)
                            <option value="{{ $statusOption }}">{{ __($statusOption) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Batch Filter -->
                <div>
                    <select wire:model.live="filter_batch_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع الدفعات</option>
                        @foreach($this->batches as $batch)
                            <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Specialization Filter -->
                <div>
                    <select wire:model.live="filter_specialization_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع التخصصات</option>
                        @foreach($this->specializations as $spec)
                            <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Course Filter -->
                <div>
                    <select wire:model.live="filter_course_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع المواد</option>
                        @foreach( $this->courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Creator Filter -->
                <div>
                    <select wire:model.live="filter_creator_student_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع الطلاب</option>
                        @foreach($this->students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Projects Grid --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            @php
                $colorThemes = [
                    ['gradient' => 'from-purple-500 to-fuchsia-500', 'border' => 'border-purple-500', 'text' => 'text-purple-500', 'overlay' => 'bg-gradient-to-br from-purple-500/70 to-fuchsia-500/70'],
                    ['gradient' => 'from-blue-500 to-indigo-500', 'border' => 'border-blue-500', 'text' => 'text-blue-500', 'overlay' => 'bg-gradient-to-br from-blue-500/70 to-indigo-500/70'],
                    ['gradient' => 'from-emerald-500 to-teal-500', 'border' => 'border-emerald-500', 'text' => 'text-emerald-500', 'overlay' => 'bg-gradient-to-br from-emerald-500/70 to-teal-500/70'],
                    ['gradient' => 'from-amber-500 to-orange-500', 'border' => 'border-amber-500', 'text' => 'text-amber-500', 'overlay' => 'bg-gradient-to-br from-amber-500/70 to-orange-500/70'],
                    ['gradient' => 'from-rose-500 to-pink-500', 'border' => 'border-rose-500', 'text' => 'text-rose-500', 'overlay' => 'bg-gradient-to-br from-rose-500/70 to-pink-500/70'],
                    ['gradient' => 'from-cyan-500 to-sky-500', 'border' => 'border-cyan-500', 'text' => 'text-cyan-500', 'overlay' => 'bg-gradient-to-br from-cyan-500/70 to-sky-500/70'],
                ];
            @endphp

            @forelse($projects as $project)
                @php
                    $theme = $colorThemes[$loop->index % count($colorThemes)];
                @endphp

                <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-purple-500/10 dark:hover:shadow-purple-900/30 hover:-translate-y-2 overflow-hidden">
                    {{-- Subtle Gradient Background --}}
                    <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-300 rounded-2xl"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        {{-- Header --}}
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-14 h-14 flex-shrink-0 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border {{ $theme['border'] }} shadow-sm group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 {{ $theme['text'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold {{ $theme['text'] }} mb-1">مشروع</p>
                                <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight line-clamp-2">{{ Str::limit($project->title, 40) }}</h3>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="space-y-3 flex-grow">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">المنشئ</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium truncate max-w-[120px]" title="{{ $project->creatorStudent->name ?? 'غير محدد' }}">{{ $project->creatorStudent->name ?? 'غير محدد' }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">المادة</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium truncate max-w-[120px]" title="{{ $project->course->name ?? 'غير محدد' }}">{{ $project->course->name ?? 'غير محدد' }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 dark:text-slate-400">الحالة</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold
                                    @if($project->status == 'pending') bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300
                                    @elseif($project->status == 'approved') bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300
                                    @elseif($project->status == 'rejected') bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300
                                    @elseif($project->status == 'completed') bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300
                                    @endif">
                                    {{ __($project->status) }}
                                </span>
                            </div>

                            <div class="flex gap-4 text-xs text-slate-500 dark:text-slate-400 mt-2 bg-slate-50 dark:bg-zinc-700/50 p-2 rounded-lg justify-around">
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

                        {{-- Footer --}}
                        <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700/50 flex justify-between items-center">
                            <span class="text-xs text-slate-400 dark:text-slate-500">{{ $project->created_at->format('Y/m/d') }}</span>
                            
                            <div class="flex gap-2">
                                <button wire:click="viewProject({{ $project->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-blue-500 hover:text-white transition-colors" title="عرض التفاصيل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button wire:click="openChangeStatusModal({{ $project->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-purple-500 hover:text-white transition-colors" title="تغيير الحالة">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </button>
                                <button wire:click="confirmDelete({{ $project->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-red-500 hover:text-white transition-colors" title="حذف">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-slate-50 to-purple-50 dark:from-zinc-800/50 dark:to-zinc-900/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700/50 backdrop-blur-sm">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-purple-500 to-fuchsia-500 rounded-full flex items-center justify-center mb-6 shadow-2xl shadow-purple-500/30">
                        <svg class="w-14 h-14 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-zinc-800 dark:text-white mb-2">لا توجد مشاريع</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-6 max-w-md mx-auto">لم يتم العثور على أي مشاريع تطابق معايير البحث.</p>
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

    {{-- Change Status Modal --}}
    @if($showChangeStatusModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-change-status-modal')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-md flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-purple-500 to-fuchsia-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تغيير حالة المشروع</h2>
                <button wire:click="closeChangeStatusModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="saveStatus" class="flex-grow p-6">
                <div>
                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">الحالة الجديدة <span class="text-red-500">*</span></label>
                    <select wire:model="status" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all" required>
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
                <button type="submit" wire:click="saveStatus" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-purple-600 to-fuchsia-600 hover:from-purple-700 hover:to-fuchsia-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-purple-500/20">
                    <span wire:loading.remove wire:target="saveStatus">حفظ التغيير</span>
                    <span wire:loading wire:target="saveStatus">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if($delete_id)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.set('delete_id', null)" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
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

    {{-- View Project Modal --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-view-modal')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-6xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تفاصيل المشروع: {{ $viewedProject->title ?? '' }}</h2>
                <button wire:click="closeViewModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-grow p-6 overflow-y-auto">
                {{-- Basic Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-700">
                        <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">عنوان المشروع</p>
                        <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $viewedProject->title ?? '' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-700">
                        <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المادة</p>
                        <p class="text-lg text-zinc-900 dark:text-white">{{ $viewedProject->course->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-700">
                        <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المنشئ</p>
                        <p class="text-lg text-zinc-900 dark:text-white">{{ $viewedProject->creatorStudent->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-700">
                        <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الدفعة</p>
                        <p class="text-lg text-zinc-900 dark:text-white">{{ $viewedProject->batch->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-700">
                        <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">التخصص</p>
                        <p class="text-lg text-zinc-900 dark:text-white">{{ $viewedProject->specialization->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-700">
                        <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الحالة</p>
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

                {{-- Description --}}
                @if($viewedProject->description)
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        الوصف
                    </h3>
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-700">
                        <p class="text-zinc-900 dark:text-white leading-relaxed">{{ $viewedProject->description }}</p>
                    </div>
                </div>
                @endif

                {{-- Participants --}}
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
                                <span class="bg-blue-50 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 px-4 py-2 rounded-xl text-sm font-medium flex items-center gap-2 border border-blue-100 dark:border-blue-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $participant->name }}
                                    @if($participant->id == $viewedProject->creatorStudent->id)
                                        <span class="bg-yellow-200 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-200 px-2 py-0.5 rounded-lg text-xs font-bold mr-1">(المنشئ)</span>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-zinc-600 dark:text-zinc-400">لا يوجد طلاب مشاركون في هذا المشروع.</p>
                    @endif
                </div>

                {{-- Files --}}
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
                                <div class="group relative border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 bg-white dark:bg-zinc-800/50 hover:shadow-lg transition-all">
                                    @if(Str::startsWith($file->file_type, 'image'))
                                        <div class="aspect-video rounded-lg overflow-hidden mb-3 bg-zinc-100 dark:bg-zinc-700">
                                            <img src="{{ Storage::url($file->file_path) }}" alt="{{ $file->file_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        </div>
                                    @elseif(Str::startsWith($file->file_type, 'video'))
                                        <div class="aspect-video rounded-lg overflow-hidden mb-3 bg-zinc-100 dark:bg-zinc-700">
                                            <video controls class="w-full h-full object-cover">
                                                <source src="{{ Storage::url($file->file_path) }}" type="{{ $file->file_type }}">
                                                متصفحك لا يدعم الفيديو.
                                            </video>
                                        </div>
                                    @else
                                        <div class="aspect-video flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-lg mb-3 text-zinc-500 dark:text-zinc-400 group-hover:text-purple-500 transition-colors">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <p class="text-zinc-800 dark:text-white font-semibold text-sm truncate" title="{{ $file->file_name }}">{{ $file->file_name }}</p>
                                    <p class="text-zinc-600 dark:text-zinc-400 text-xs mt-1 truncate">{{ $file->description ?? 'لا يوجد وصف' }}</p>
                                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 text-xs mt-3 font-medium transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        عرض / تحميل
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-zinc-50 dark:bg-zinc-700/50 rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700">
                            <svg class="w-12 h-12 mx-auto text-zinc-400 dark:text-zinc-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-zinc-600 dark:text-zinc-400">لا توجد ملفات مرفقة بهذا المشروع.</p>
                        </div>
                    @endif
                </div>

                {{-- Likes & Comments --}}
                <div>
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        الإعجابات والتعليقات
                    </h3>
                    <div class="flex items-center gap-6 mb-6">
                        <span class="text-zinc-600 dark:text-zinc-400 flex items-center gap-2 bg-zinc-50 dark:bg-zinc-700/50 px-3 py-1.5 rounded-lg">
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span class="font-bold">{{ $viewedProject->likes_count }}</span> إعجاب
                        </span>
                        <span class="text-zinc-600 dark:text-zinc-400 flex items-center gap-2 bg-zinc-50 dark:bg-zinc-700/50 px-3 py-1.5 rounded-lg">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span class="font-bold">{{ $viewedProject->comments_count }}</span> تعليق
                        </span>
                    </div>

                    @if($viewedProject->comments->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($viewedProject->comments->sortByDesc('created_at') as $comment)
                                <div class="bg-zinc-50 dark:bg-zinc-700/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-700">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xs">
                                                {{ substr($comment->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <span class="font-semibold text-zinc-800 dark:text-white">{{ $comment->user->name ?? 'مستخدم غير معروف' }}</span>
                                        </div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400 bg-white dark:bg-zinc-800 px-2 py-1 rounded-lg border border-zinc-200 dark:border-zinc-700">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-zinc-700 dark:text-zinc-300 pr-10">{{ $comment->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6 bg-zinc-50 dark:bg-zinc-700/50 rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700">
                            <p class="text-zinc-500 dark:text-zinc-400">لا توجد تعليقات بعد.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex-shrink-0 p-4 flex justify-end bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeViewModal" class="px-6 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-medium transition-colors shadow-sm">إغلاق</button>
            </div>
        </div>
    </div>
    @endif

    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
