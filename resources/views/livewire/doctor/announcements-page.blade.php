<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        @section('title', 'إدارة الإعلانات')

        {{-- 1. Hero Section المدمج مع الفلاتر --}}
        <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-amber-50 to-orange-50 dark:from-zinc-900 dark:via-amber-900/20 dark:to-orange-900/20 border border-slate-200 dark:border-slate-800" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
            {{-- Animated Background Orbs --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-10 right-10 w-72 h-72 bg-amber-400/20 dark:bg-amber-600/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-10 left-10 w-96 h-96 bg-orange-400/20 dark:bg-orange-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 p-8">
                {{-- Top Section: Animation + Title + Actions --}}
                <div class="grid md:grid-cols-2 gap-8 items-center mb-8">
                    {{-- Left Side: Animation --}}
                    <div class="order-1 md:order-1 flex justify-center">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                            <lottie-player
                                src="/animations/Demo.json"
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
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-100 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800 rounded-full mb-4">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                            </span>
                            <span class="text-sm font-bold text-amber-700 dark:text-amber-300">مركز الإعلانات</span>
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-amber-700 to-orange-700 dark:from-slate-100 dark:via-amber-300 dark:to-orange-300 mb-4 leading-tight" style="font-family: 'Questv1', sans-serif;">
                            إدارة الإعلانات
                        </h1>
                        <p class="text-lg text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                            قم بإنشاء ونشر الإعلانات للطلاب وإدارتها بكل سهولة
                        </p>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-3">
                            <div class="group relative flex-1 min-w-[200px]">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-amber-600 to-orange-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition"></div>
                                <div class="relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <input wire:model.live.debounce.300ms="search" placeholder="بحث عن إعلان..." class="bg-transparent border-0 focus:ring-0 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 w-full">
                                </div>
                            </div>
                            
                            <button wire:click="openForm" class="group relative px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white rounded-2xl font-bold transition-all hover:scale-105 shadow-xl shadow-amber-500/30 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>إضافة إعلان</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Bottom Section: Filters --}}
                <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-6">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                        </svg>
                        تصفية الإعلانات
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">المادة الدراسية</label>
                            <select wire:model.live="filter_course_id" class="w-full py-2.5 px-4 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all text-sm">
                                <option value="">جميع المواد</option>
                                @foreach($this->doctorCourses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Announcements Grid --}}
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                <span class="w-2 h-8 bg-amber-600 rounded-full inline-block"></span>
                إعلاناتي
            </h2>

            <div wire:loading.class.delay="opacity-50" class="transition-opacity">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($announcements as $announcement)
                        <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-amber-500/10 dark:hover:shadow-amber-900/30 hover:-translate-y-2 overflow-hidden">
                            {{-- Subtle Gradient Background --}}
                            <div class="absolute inset-0 bg-gradient-to-br from-slate-50 to-amber-50 dark:from-slate-900 dark:to-slate-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                            
                            <div class="relative z-10 flex flex-col h-full">
                                {{-- Header --}}
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="w-14 h-14 flex-shrink-0 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="inline-block px-2.5 py-0.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-full text-xs font-bold mb-1 truncate max-w-full">
                                            {{ \App\Models\Course::find($announcement->target_id)->name ?? 'كل المواد' }}
                                        </span>
                                        <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight truncate group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors" style="font-family: 'Questv1', sans-serif;">
                                            {{ $announcement->title }}
                                        </h3>
                                    </div>
                                </div>

                                {{-- Details --}}
                                <div class="flex-grow space-y-3 mb-5">
                                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-3 bg-slate-50 dark:bg-slate-900/50 p-3 rounded-xl border border-slate-100 dark:border-slate-800">
                                        {{ Str::limit($announcement->content, 150, '...') }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">مستوى الأهمية</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                            @if($announcement->level == 'danger') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                            @elseif($announcement->level == 'warning') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                            @elseif($announcement->level == 'success') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                            @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 @endif">
                                            {{ __($announcement->level) }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="flex flex-col p-2 bg-slate-50 dark:bg-slate-900/50 rounded-lg">
                                            <span class="text-xs text-slate-500 dark:text-slate-400">نُشر في</span>
                                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200 dir-ltr">{{ $announcement->created_at->format('Y/m/d') }}</span>
                                        </div>
                                        <div class="flex flex-col p-2 bg-slate-50 dark:bg-slate-900/50 rounded-lg">
                                            <span class="text-xs text-slate-500 dark:text-slate-400">ينتهي في</span>
                                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200 dir-ltr">{{ $announcement->expires_at ? $announcement->expires_at->format('Y/m/d') : 'لا ينتهي' }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="grid grid-cols-2 gap-2 mt-auto">
                                    <button wire:click="edit({{ $announcement->id }})" class="flex items-center justify-center gap-2 p-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl text-slate-700 dark:text-slate-200 transition-all hover:scale-105">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span class="text-xs font-bold">تعديل</span>
                                    </button>
                                    <button wire:click="confirmDelete({{ $announcement->id }})" class="flex items-center justify-center gap-2 p-2.5 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 rounded-xl text-red-600 dark:text-red-400 transition-all hover:scale-105">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="text-xs font-bold">حذف</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full p-12 text-center bg-white/50 dark:bg-zinc-800/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700 backdrop-blur-sm">
                            <div class="w-20 h-20 mx-auto bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-2">لا توجد إعلانات</h3>
                            <p class="text-zinc-500 dark:text-zinc-400 mb-6">لم تقم بنشر أي إعلانات بعد.</p>
                            <button wire:click="openForm" class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-xl font-bold transition-all">
                                <span>إضافة أول إعلان</span>
                            </button>
                        </div>
                    @endforelse
                </div>
                
                @if($announcements->hasPages())
                    <div class="mt-8">
                        {{ $announcements->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Modals --}}
        
        {{-- Create/Edit Announcement Modal --}}
        @if($showForm)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.closeForm()" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
                <div class="h-2 bg-gradient-to-r from-amber-500 to-orange-500 rounded-t-2xl"></div>
                
                <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">{{ $announcement_id ? 'تعديل الإعلان' : 'إضافة إعلان جديد' }}</h2>
                    <button wire:click="closeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="flex-grow p-6 space-y-6 overflow-y-auto">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">المادة <span class="text-red-500">*</span></label>
                        <select wire:model="course_id" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-amber-500 transition-all" required>
                            <option value="">اختر المادة</option>
                            @foreach($this->doctorCourses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">العنوان <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="title" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-amber-500 transition-all" placeholder="مثال: إعلان هام" required>
                        @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">المحتوى <span class="text-red-500">*</span></label>
                        <textarea wire:model="content" rows="4" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-amber-500 transition-all" placeholder="محتوى الإعلان..." required></textarea>
                        @error('content') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">المستوى</label>
                            <select wire:model="level" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-amber-500 transition-all">
                                <option value="info">معلومات</option>
                                <option value="success">نجاح</option>
                                <option value="warning">تحذير</option>
                                <option value="danger">خطر</option>
                            </select>
                            @error('level') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">انتهاء الصلاحية</label>
                            <input type="datetime-local" wire:model="expires_at" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-amber-500 transition-all">
                            @error('expires_at') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </form>

                <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                    <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                    <button type="button" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md">
                        <span wire:loading.remove wire:target="save">{{ $announcement_id ? 'حفظ التعديلات' : 'إضافة الإعلان' }}</span>
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
                <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>
                <div class="p-6 text-center">
                    <div class="w-16 h-16 mx-auto bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2" style="font-family: 'Questv1', sans-serif;">تأكيد الحذف</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 text-sm">هل أنت متأكد من حذف هذا الإعلان؟ لا يمكن التراجع عن هذا الإجراء.</p>
                </div>
                <div class="p-4 flex flex-col-reverse sm:flex-row gap-3 bg-zinc-50 dark:bg-zinc-800/50">
                    <button wire:click="$set('delete_id', null)" class="w-full sm:w-1/2 px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                    <button wire:click="delete" class="w-full sm:w-1/2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors shadow-md">
                        <span wire:loading.remove wire:target="delete">نعم، حذف</span>
                        <span wire:loading wire:target="delete">جاري الحذف...</span>
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
