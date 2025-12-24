<div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
    {{-- 1. Hero Section المدمج --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-zinc-900 dark:via-slate-900 dark:to-zinc-900 border border-slate-200 dark:border-slate-800" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
        {{-- Animated Background Orbs --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-10 right-10 w-72 h-72 bg-blue-400/20 dark:bg-blue-600/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-indigo-400/20 dark:bg-indigo-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 p-8">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                {{-- Left Side: Animation --}}
                <div class="order-1 md:order-1 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                        <lottie-player
                            src="{{ asset('animations/data analysis.json') }}"
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
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-full mb-4">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        <span class="text-sm font-bold text-blue-700 dark:text-blue-300">نظام إدارة متقدم</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-blue-700 to-indigo-700 dark:from-slate-100 dark:via-blue-300 dark:to-indigo-300 mb-4 leading-tight">
                        إدارة الأقسام الأكاديمية
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                        نظّم، أبدع، وطوّر أقسامك الأكاديمية بكل سهولة واحترافية
                    </p>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap gap-3">
                        <div class="group relative flex-1 min-w-[200px]">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition"></div>
                            <div class="relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input wire:model.live.debounce.300ms="search" placeholder="بحث سريع..." class="bg-transparent border-0 focus:ring-0 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 w-full">
                            </div>
                        </div>
                        
                        <button wire:click="openForm" class="group relative px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-2xl font-bold transition-all hover:scale-105 shadow-xl shadow-blue-500/30 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>إضافة قسم</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. شبكة البطاقات الفنية المتناسقة --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            @php
                $colorThemes = [
                    [
                        'gradient' => 'from-indigo-500 to-purple-500',
                        'bg' => 'bg-indigo-500/10 dark:bg-indigo-500/20',
                        'border' => 'border-indigo-500/30 dark:border-indigo-500/40',
                        'text' => 'text-indigo-600 dark:text-indigo-400',
                        'badge' => 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300',
                        'icon' => 'bg-gradient-to-br from-indigo-500 to-purple-500',
                    ],
                    [
                        'gradient' => 'from-teal-500 to-emerald-500',
                        'bg' => 'bg-teal-500/10 dark:bg-teal-500/20',
                        'border' => 'border-teal-500/30 dark:border-teal-500/40',
                        'text' => 'text-teal-600 dark:text-teal-400',
                        'badge' => 'bg-teal-100 dark:bg-teal-900/50 text-teal-700 dark:text-teal-300',
                        'icon' => 'bg-gradient-to-br from-teal-500 to-emerald-500',
                    ],
                    [
                        'gradient' => 'from-amber-500 to-orange-500',
                        'bg' => 'bg-amber-500/10 dark:bg-amber-500/20',
                        'border' => 'border-amber-500/30 dark:border-amber-500/40',
                        'text' => 'text-amber-600 dark:text-amber-400',
                        'badge' => 'bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300',
                        'icon' => 'bg-gradient-to-br from-amber-500 to-orange-500',
                    ],
                    [
                        'gradient' => 'from-rose-500 to-pink-500',
                        'bg' => 'bg-rose-500/10 dark:bg-rose-500/20',
                        'border' => 'border-rose-500/30 dark:border-rose-500/40',
                        'text' => 'text-rose-600 dark:text-rose-400',
                        'badge' => 'bg-rose-100 dark:bg-rose-900/50 text-rose-700 dark:text-rose-300',
                        'icon' => 'bg-gradient-to-br from-rose-500 to-pink-500',
                    ],
                    [
                        'gradient' => 'from-blue-500 to-cyan-500',
                        'bg' => 'bg-blue-500/10 dark:bg-blue-500/20',
                        'border' => 'border-blue-500/30 dark:border-blue-500/40',
                        'text' => 'text-blue-600 dark:text-blue-400',
                        'badge' => 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300',
                        'icon' => 'bg-gradient-to-br from-blue-500 to-cyan-500',
                    ],
                    [
                        'gradient' => 'from-violet-500 to-fuchsia-500',
                        'bg' => 'bg-violet-500/10 dark:bg-violet-500/20',
                        'border' => 'border-violet-500/30 dark:border-violet-500/40',
                        'text' => 'text-violet-600 dark:text-violet-400',
                        'badge' => 'bg-violet-100 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300',
                        'icon' => 'bg-gradient-to-br from-violet-500 to-fuchsia-500',
                    ],
                ];
            @endphp

            @forelse($departments as $dept)
                @php
                    $theme = $colorThemes[$loop->index % count($colorThemes)];
                @endphp

                <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border {{ $theme['border'] }} transition-all duration-300 hover:shadow-2xl hover:shadow-{{ explode('-', $theme['gradient'])[1] }}-500/20 hover:-translate-y-2 overflow-hidden">
                    {{-- Gradient Background --}}
                    <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-0 group-hover:opacity-5 dark:group-hover:opacity-10 transition-opacity duration-300 rounded-2xl"></div>
                    
                    {{-- Decorative Corner --}}
                    <div class="absolute top-0 right-0 w-24 h-24 {{ $theme['bg'] }} rounded-bl-full opacity-50"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        {{-- Header with Icon & Title --}}
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-16 h-16 flex-shrink-0 {{ $theme['icon'] }} rounded-2xl flex items-center justify-center shadow-lg shadow-{{ explode('-', $theme['gradient'])[1] }}-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-9 h-9 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18h18a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0118 21.75H6a2.25 2.25 0 01-2.25-2.25V5.25A2.25 2.25 0 016 3h12" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="inline-block px-3 py-1 {{ $theme['badge'] }} rounded-full text-xs font-bold mb-2">قسم أكاديمي</span>
                                <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight group-hover:{{ $theme['text'] }} transition-colors">{{ $dept->name }}</h3>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="flex-grow mb-5">
                            <div class="p-3 bg-zinc-50 dark:bg-zinc-900/50 rounded-xl">
                                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 flex items-center gap-2 mb-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $theme['bg'] }}"></span>
                                    الوصف
                                </span>
                                <p class="text-sm text-zinc-800 dark:text-zinc-200 leading-relaxed">
                                    {{ $dept->description ?: 'لا يوجد وصف متاح لهذا القسم.' }}
                                </p>
                            </div>
                        </div>

                        {{-- Info Footer --}}
                        <div class="pb-4 mb-4 border-b border-zinc-200 dark:border-zinc-700/50">
                            <span class="text-xs text-zinc-400 dark:text-zinc-500">تم الإنشاء: {{ $dept->created_at->format('Y/m/d') }}</span>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="grid grid-cols-2 gap-2">
                            <button wire:click="edit({{ $dept->id }})" class="flex flex-col items-center gap-1.5 p-3 bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl text-white transition-all hover:scale-105 shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span class="text-xs font-bold">تعديل</span>
                            </button>
                            <button wire:click="confirmDelete({{ $dept->id }})" class="flex flex-col items-center gap-1.5 p-3 bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 rounded-xl text-white transition-all hover:scale-105 shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span class="text-xs font-bold">حذف</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                {{-- حالة عدم وجود بيانات --}}
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-zinc-800/50 dark:to-zinc-900/50 rounded-3xl border-2 border-dashed border-indigo-300 dark:border-indigo-700/50 backdrop-blur-sm">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-6 shadow-2xl shadow-indigo-500/30">
                        <svg class="w-14 h-14 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.75M9 11.25h6.75M9 15.75h6.75" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-zinc-800 dark:text-white mb-2">أطلق العنان للإبداع</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-6 max-w-md mx-auto">لم تقم بإضافة أي قسم بعد. ابدأ الآن وأنشئ بيئة تعليمية فريدة.</p>
                    <button wire:click="openForm" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-xl shadow-indigo-500/30 hover:shadow-2xl hover:shadow-indigo-500/40 hover:-translate-y-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>إضافة أول قسم</span>
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($departments->hasPages())
    <div class="mt-8">
        {{ $departments->links() }}
    </div>
    @endif

    {{-- النوافذ المنبثقة (Modals) بتصميم فخم بالألوان --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-form')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>

            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $edit_id ? 'تعديل القسم' : 'إضافة قسم جديد' }}</h2>
                <button wire:click="closeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="flex-grow p-6 space-y-5 overflow-y-auto">
                <div>
                    <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">اسم القسم <span class="text-red-500">*</span></label>
                    <input id="name" wire:model="name" type="text" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="مثال: قسم علوم الحاسب">
                    @error('name') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الوصف (اختياري)</label>
                    <textarea id="description" wire:model="description" rows="4" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-y transition-all" placeholder="أدخل وصفاً موجزاً عن مهام القسم..."></textarea>
                    @error('description') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-indigo-500/20">
                    <span wire:loading.remove wire:target="save">{{ $edit_id ? 'حفظ التعديلات' : 'إنشاء القسم' }}</span>
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
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">هل أنت متأكد من حذف هذا القسم؟ لا يمكن التراجع عن هذا الإجراء.</p>
            </div>

            <div class="p-4 flex flex-col-reverse sm:flex-row gap-3 bg-zinc-50 dark:bg-zinc-800/50">
                <button wire:click="$set('delete_id', null)" class="w-full sm:w-1/2 px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button wire:click="delete" class="w-full sm:w-1/2 px-4 py-2.5 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-red-500/20">
                    <span wire:loading.remove wire:target="delete">نعم، قم بالحذف</span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endpush
