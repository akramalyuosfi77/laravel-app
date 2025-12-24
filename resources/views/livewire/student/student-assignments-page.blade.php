<div class="min-h-screen bg-gradient-to-br from-slate-50 via-orange-50/30 to-amber-50/30 dark:from-zinc-900 dark:via-orange-950/20 dark:to-amber-950/20">
    
    {{-- 1. Hero Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-amber-500 via-orange-500 to-red-500 dark:from-amber-900 dark:via-orange-900 dark:to-red-900 shadow-2xl shadow-orange-500/20">
        {{-- Animated Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 p-8 md:p-12">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                {{-- Left: Content --}}
                <div class="order-2 md:order-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span class="text-sm font-bold text-white">مهامي الأكاديمية</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 leading-tight">
                        📚 تكليفاتي
                    </h1>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        تابع مهامك الأكاديمية وقم بتسليمها في الوقت المحدد لتحقيق التفوق!
                    </p>

                    {{-- Quick Stats --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-2xl p-4">
                            <p class="text-white/80 text-sm mb-1">قيد الانتظار</p>
                            <p class="text-3xl font-black text-white">{{ $this->stats['pending'] ?? 0 }}</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-2xl p-4">
                            <p class="text-white/80 text-sm mb-1">تم التسليم</p>
                            <p class="text-3xl font-black text-white">{{ $this->stats['submitted'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                {{-- Right: Animation --}}
                <div class="order-1 md:order-2 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-3xl"></div>
                        <lottie-player
                            src="/animations/robot-analytics.json"
                            background="transparent"
                            speed="1"
                            style="width: 100%; max-width: 400px; height: auto;"
                            loop
                            autoplay>
                        </lottie-player>
                    </div>
                </div>
            </div>
        </div>

        {{-- Decorative Wave --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="currentColor" class="text-slate-50 dark:text-zinc-900"/>
            </svg>
        </div>
    </div>

    {{-- 2. Filters --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-orange-600 to-amber-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition"></div>
            <div class="relative bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-1">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="🔍 ابحث بالعنوان، الوصف، المادة..." class="w-full px-6 py-4 bg-transparent border-0 focus:ring-0 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 font-medium rounded-xl">
            </div>
        </div>
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-orange-600 to-amber-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition"></div>
            <div class="relative bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-1">
                <select wire:model.live="filter_status" class="w-full px-6 py-4 bg-transparent border-0 focus:ring-0 text-zinc-900 dark:text-white font-medium rounded-xl">
                    <option value="">📋 جميع الحالات</option>
                    @foreach($submissionStatuses as $statusOption)
                        <option value="{{ $statusOption }}">{{ __($statusOption) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- 3. Assignments List --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        @if($assignments->isNotEmpty())
            <div class="space-y-6">
                @foreach($assignments as $assignment)
                    @php
                        $submission = $assignment->submissions[0] ?? null;
                        $status = 'لم يتم التسليم';
                        $statusConfig = ['bg' => 'from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-700', 'text' => 'text-zinc-700 dark:text-zinc-300', 'icon' => '⏳'];
                        
                        if ($submission) {
                            $status = $submission->status;
                            if ($status == 'submitted') {
                                $statusConfig = ['bg' => 'from-blue-500 to-cyan-500', 'text' => 'text-white', 'icon' => '📤'];
                            } elseif ($status == 'graded') {
                                $statusConfig = ['bg' => 'from-emerald-500 to-teal-500', 'text' => 'text-white', 'icon' => '✅'];
                            } elseif ($status == 'rejected') {
                                $statusConfig = ['bg' => 'from-red-500 to-rose-500', 'text' => 'text-white', 'icon' => '❌'];
                            }
                        } elseif (now()->greaterThan($assignment->deadline)) {
                            $status = 'متأخر';
                            $statusConfig = ['bg' => 'from-red-500 to-rose-500', 'text' => 'text-white', 'icon' => '⚠️'];
                        }
                        
                        $isLate = now()->greaterThan($assignment->deadline) && (!$submission || $submission->status != 'submitted');
                        $gradientColors = [
                            'from-violet-500 to-purple-500',
                            'from-blue-500 to-cyan-500',
                            'from-emerald-500 to-teal-500',
                            'from-amber-500 to-orange-500',
                            'from-rose-500 to-pink-500',
                        ];
                        $gradient = $gradientColors[$loop->index % count($gradientColors)];
                    @endphp
                    
                    <div class="group relative bg-white dark:bg-zinc-900/50 backdrop-blur-sm rounded-3xl border border-zinc-200 dark:border-zinc-800 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
                        {{-- Decorative Gradient Bar --}}
                        <div class="h-2 bg-gradient-to-r {{ $gradient }}"></div>
                        
                        {{-- Content --}}
                        <div class="p-6 md:p-8">
                            <div class="grid md:grid-cols-3 gap-6">
                                {{-- Main Info --}}
                                <div class="md:col-span-2 space-y-4">
                                    {{-- Status & Grade --}}
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} shadow-lg">
                                            <span>{{ $statusConfig['icon'] }}</span>
                                            <span>{{ __($status) }}</span>
                                        </span>
                                        @if($submission && $submission->grade)
                                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-yellow-400 to-amber-500 text-white shadow-lg">
                                                <span>⭐</span>
                                                <span>{{ $submission->grade }}</span>
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Title & Course --}}
                                    <div>
                                        <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-2 break-words">
                                            {{ $assignment->title }}
                                        </h3>
                                        <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-gradient-to-r {{ $gradient }}"></span>
                                            {{ $assignment->course->name ?? 'غير محدد' }} • د. {{ $assignment->doctor->name ?? 'غير محدد' }}
                                        </p>
                                    </div>

                                    {{-- Description --}}
                                    <p class="text-zinc-600 dark:text-zinc-300 leading-relaxed break-words line-clamp-2">
                                        {{ $assignment->description }}
                                    </p>
                                </div>

                                {{-- Deadline & Actions --}}
                                <div class="flex flex-col justify-between">
                                    {{-- Deadline --}}
                                    <div class="bg-gradient-to-br from-zinc-50 to-zinc-100 dark:from-zinc-800/50 dark:to-zinc-800/30 rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700">
                                        <p class="text-sm font-bold text-zinc-500 dark:text-zinc-400 mb-2">📅 موعد التسليم</p>
                                        <p class="text-2xl font-black {{ $isLate ? 'text-red-500' : 'text-zinc-900 dark:text-white' }}">
                                            {{ $assignment->deadline->format('d M') }}
                                        </p>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                            {{ $assignment->deadline->format('h:i A') }}
                                        </p>
                                        @if($isLate)
                                            <p class="text-xs text-red-500 font-bold mt-2">⚠️ انتهى الموعد</p>
                                        @else
                                            <p class="text-xs text-emerald-500 font-bold mt-2">✓ لا يزال الوقت متاح</p>
                                        @endif
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex flex-col gap-3 mt-4">
                                        <button wire:click="viewAssignmentDetails({{ $assignment->id }})" class="group/btn relative inline-flex items-center justify-center px-6 py-3 overflow-hidden font-bold text-white transition-all duration-300 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-400/50 shadow-lg">
                                            <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover/btn:-translate-x-40 ease"></span>
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span class="relative">عرض التفاصيل</span>
                                        </button>
                                        
                                        @if(now()->lessThanOrEqualTo($assignment->deadline) || ($submission && $submission->status == 'submitted'))
                                            <button wire:click="openSubmissionForm({{ $assignment->id }})" class="group/btn relative inline-flex items-center justify-center px-6 py-3 overflow-hidden font-bold text-white transition-all duration-300 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-emerald-400/50 shadow-lg">
                                                <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover/btn:-translate-x-40 ease"></span>
                                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                                <span class="relative">{{ $submission ? 'تعديل التسليم' : 'تسليم الآن' }}</span>
                                            </button>
                                        @else
                                            <button disabled class="px-6 py-3 bg-zinc-300 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400 rounded-2xl cursor-not-allowed font-bold">
                                                ⏰ انتهى الموعد
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8 flex justify-center">
                {{ $assignments->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-20 px-6 bg-white dark:bg-zinc-900/50 backdrop-blur-sm rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-orange-100 to-amber-100 dark:from-orange-900/20 dark:to-amber-900/20 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <svg class="w-16 h-16 text-orange-500 dark:text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-3">لا توجد تكليفات</h3>
                <p class="text-zinc-600 dark:text-zinc-400 max-w-md mx-auto">لا توجد تكليفات تطابق بحثك أو لم يتم إضافة تكليفات بعد.</p>
            </div>
        @endif
    </div>

    {{-- Submission Form Modal --}}
    @if($showSubmissionForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('closeSubmissionForm')" class="bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-800">
            <div class="h-2 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-t-3xl"></div>
            
            {{-- Header --}}
            <div class="flex-shrink-0 p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-800">
                <div>
                    <h2 class="text-2xl font-black text-zinc-900 dark:text-white">{{ $existing_submission_id ? '✏️ تعديل التسليم' : '📤 تسليم التكليف' }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">قم برفع ملفاتك وإضافة ملاحظاتك</p>
                </div>
                <button wire:click="closeSubmissionForm" class="p-2 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Form --}}
            <form wire:submit.prevent="saveSubmission" class="flex-grow p-6 space-y-6 overflow-y-auto custom-scrollbar">
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">عنوان التسليم (اختياري)</label>
                    <input type="text" wire:model="submission_title" placeholder="أدخل عنواناً لتسليمك..." class="w-full px-4 py-3 border-2 border-zinc-200 dark:border-zinc-700 rounded-2xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                    @error('submission_title') <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">وصف التسليم (اختياري)</label>
                    <textarea wire:model="submission_description" rows="4" placeholder="أضف أي ملاحظات أو تفاصيل..." class="w-full px-4 py-3 border-2 border-zinc-200 dark:border-zinc-700 rounded-2xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all resize-none"></textarea>
                    @error('submission_description') <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>

                @if($old_submission_files && $old_submission_files->isNotEmpty())
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">📎 الملفات الحالية</label>
                    <div class="space-y-2">
                        @foreach($old_submission_files as $file)
                            <div class="flex items-center justify-between p-4 border-2 border-zinc-200 dark:border-zinc-700 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50 group hover:border-emerald-500 transition-colors">
                                <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-sm font-medium text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    {{ $file->file_name }}
                                </a>
                                <button type="button" wire:click="deleteExistingFile({{ $file->id }})" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">📁 إرفاق ملفات جديدة</label>
                    <div class="relative group">
                        <input type="file" wire:model="submission_files" multiple class="w-full text-sm text-zinc-600 dark:text-zinc-400 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-sm file:font-bold file:bg-gradient-to-r file:from-emerald-500 file:to-teal-500 file:text-white hover:file:from-emerald-600 hover:file:to-teal-600 file:transition-all file:shadow-lg border-2 border-dashed border-zinc-300 dark:border-zinc-700 rounded-2xl cursor-pointer p-4 hover:border-emerald-500 transition-colors">
                    </div>
                    @error('submission_files.*') <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    @error('submission_files') <p class="mt-2 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>
            </form>

            {{-- Footer --}}
            <div class="flex-shrink-0 p-6 flex justify-end gap-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-800">
                <button type="button" wire:click="closeSubmissionForm" class="px-6 py-3 border-2 border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-2xl font-bold transition-colors">
                    إلغاء
                </button>
                <button type="submit" wire:click="saveSubmission" wire:loading.attr="disabled" wire:target="submission_files" class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-2xl font-bold flex items-center justify-center gap-2 transition-all shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                    <div wire:loading.remove wire:target="submission_files">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ $existing_submission_id ? 'حفظ التعديلات' : 'تسليم التكليف' }}</span>
                    </div>
                    <div wire:loading wire:target="submission_files" class="flex items-center gap-2">
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>جاري الرفع...</span>
                    </div>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- View Details Modal --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('closeViewModal')" class="bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-800">
            <div class="h-2 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-t-3xl"></div>
            
            {{-- Header --}}
            <div class="flex-shrink-0 p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-800">
                <div>
                    <h2 class="text-2xl font-black text-zinc-900 dark:text-white">📋 تفاصيل التكليف</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">معلومات كاملة عن التكليف والتسليم</p>
                </div>
                <button wire:click="closeViewModal" class="p-2 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Content --}}
            <div class="flex-grow p-6 space-y-6 overflow-y-auto custom-scrollbar">
                {{-- Assignment Details --}}
                <div class="p-6 bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-950/20 dark:to-cyan-950/20 rounded-2xl border-2 border-blue-200 dark:border-blue-800">
                    <h3 class="text-lg font-black text-blue-600 dark:text-blue-400 mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        معلومات التكليف
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="font-bold text-zinc-500 dark:text-zinc-400 mb-1">العنوان</p>
                            <p class="text-zinc-900 dark:text-white font-medium break-words">{{ $viewedAssignment->title ?? '' }}</p>
                        </div>
                        <div>
                            <p class="font-bold text-zinc-500 dark:text-zinc-400 mb-1">المادة</p>
                            <p class="text-zinc-900 dark:text-white font-medium">{{ $viewedAssignment->course->name ?? 'غير محدد' }}</p>
                        </div>
                        <div>
                            <p class="font-bold text-zinc-500 dark:text-zinc-400 mb-1">موعد التسليم</p>
                            <p class="text-zinc-900 dark:text-white font-medium">{{ $viewedAssignment->deadline->format('Y-m-d') ?? '' }}</p>
                        </div>
                        <div class="col-span-full">
                            <p class="font-bold text-zinc-500 dark:text-zinc-400 mb-2">الوصف</p>
                            <p class="text-zinc-700 dark:text-zinc-300 leading-relaxed break-words">{{ $viewedAssignment->description ?? 'لا يوجد وصف' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Submission Details --}}
                <div>
                    <h3 class="text-lg font-black text-emerald-600 dark:text-emerald-400 mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        تفاصيل تسليمي
                    </h3>
                    @if($viewedSubmission)
                        <div class="p-6 bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-950/20 dark:to-teal-950/20 rounded-2xl border-2 border-emerald-200 dark:border-emerald-800">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm mb-6">
                                <div>
                                    <p class="font-bold text-zinc-500 dark:text-zinc-400 mb-1">تاريخ التسليم</p>
                                    <p class="text-zinc-900 dark:text-white font-medium">{{ $viewedSubmission->created_at->format('Y-m-d H:i') ?? '' }}</p>
                                </div>
                                <div>
                                    <p class="font-bold text-zinc-500 dark:text-zinc-400 mb-1">الحالة</p>
                                    <p class="text-zinc-900 dark:text-white font-medium">{{ __($viewedSubmission->status) }}</p>
                                </div>
                                <div>
                                    <p class="font-bold text-zinc-500 dark:text-zinc-400 mb-1">الدرجة</p>
                                    <p class="text-zinc-900 dark:text-white font-medium">{{ $viewedSubmission->grade ?? 'لم تقيم' }}</p>
                                </div>
                                @if($viewedSubmission->feedback)
                                <div class="col-span-full">
                                    <p class="font-bold text-zinc-500 dark:text-zinc-400 mb-2">💬 ملاحظات الدكتور</p>
                                    <p class="text-zinc-700 dark:text-zinc-300 leading-relaxed break-words bg-white dark:bg-zinc-800 p-4 rounded-xl">{{ $viewedSubmission->feedback }}</p>
                                </div>
                                @endif
                            </div>

                            {{-- Files --}}
                            @if($viewedSubmission->files->isNotEmpty())
                            <div>
                                <p class="font-bold text-zinc-700 dark:text-zinc-300 mb-3">📎 الملفات المرفقة</p>
                                <div class="space-y-2">
                                    @foreach($viewedSubmission->files as $file)
                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="flex items-center justify-between p-4 border-2 border-emerald-200 dark:border-emerald-800 rounded-xl bg-white dark:bg-zinc-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors group">
                                            <span class="text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-2 group-hover:underline">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                {{ $file->file_name }}
                                            </span>
                                            <span class="text-zinc-500 text-xs font-medium">{{ round($file->file_size / 1024, 2) }} KB</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-12 bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border-2 border-dashed border-zinc-300 dark:border-zinc-700">
                            <p class="text-zinc-500 dark:text-zinc-400 font-medium">لم تقم بتسليم هذا التكليف بعد</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex-shrink-0 p-6 flex justify-end bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-800">
                <button type="button" wire:click="closeViewModal" class="px-6 py-3 border-2 border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-2xl font-bold transition-colors">
                    إغلاق
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    {{-- Custom Scrollbar --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(245, 158, 11, 0.3), rgba(251, 146, 60, 0.3));
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(245, 158, 11, 0.5), rgba(251, 146, 60, 0.5));
        }
    </style>
</div>
