<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

        {{-- Hero Section --}}
        <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-cyan-50 via-blue-50 to-indigo-50 dark:from-cyan-900/20 dark:via-blue-900/20 dark:to-indigo-900/20 border border-cyan-200 dark:border-cyan-800" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
            {{-- Animated Background Orbs --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-10 right-10 w-72 h-72 bg-cyan-400/20 dark:bg-cyan-600/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-10 left-10 w-96 h-96 bg-indigo-400/20 dark:bg-indigo-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 p-8">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    {{-- Left Side: Animation --}}
                    <div class="order-1 md:order-1 flex justify-center">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-indigo-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
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
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-100 dark:bg-cyan-900/30 border border-cyan-200 dark:border-cyan-800 rounded-full mb-4">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                            </span>
                            <span class="text-sm font-bold text-cyan-700 dark:text-cyan-300">إدارة النسخ الاحتياطي</span>
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-cyan-700 to-indigo-700 dark:from-slate-100 dark:via-cyan-300 dark:to-indigo-300 mb-4 leading-tight" style="font-family: 'Questv1', sans-serif;">
                            النسخ الاحتياطي 💾
                        </h1>
                        <p class="text-lg text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                            احمِ بياناتك بنسخ احتياطية آمنة واستعدها بسهولة
                        </p>

                        {{-- Stats --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm p-4 rounded-xl border border-slate-200/50 dark:border-slate-700/50">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">النسخ المتاحة</span>
                                </div>
                                <p class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">{{ count($backups) }}</p>
                            </div>
                            <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm p-4 rounded-xl border border-slate-200/50 dark:border-slate-700/50">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">الحجم الإجمالي</span>
                                </div>
                                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $totalSize }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- Create Backup Card --}}
            <div class="group relative bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 p-6 rounded-2xl border-2 border-emerald-200 dark:border-emerald-800 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-emerald-900 dark:text-emerald-100 mb-2" style="font-family: 'Questv1', sans-serif;">إنشاء نسخة احتياطية جديدة</h3>
                        <p class="text-sm text-emerald-700 dark:text-emerald-300 mb-4">احفظ جميع بيانات النظام في نسخة احتياطية آمنة</p>
                        <button 
                            wire:click="createBackup"
                            wire:loading.attr="disabled"
                            class="w-full px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-bold transition-all hover:scale-105 shadow-lg flex items-center justify-center gap-2"
                        >
                            <span wire:loading.remove wire:target="createBackup">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                إنشاء نسخة احتياطية
                            </span>
                            <span wire:loading wire:target="createBackup" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                جاري الإنشاء...
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Auto Backup Settings Card --}}
            <div class="group relative bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 p-6 rounded-2xl border-2 border-purple-200 dark:border-purple-800 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-purple-900 dark:text-purple-100 mb-2" style="font-family: 'Questv1', sans-serif;">النسخ الاحتياطي التلقائي</h3>
                        <p class="text-sm text-purple-700 dark:text-purple-300 mb-4">جدولة نسخ احتياطية تلقائية دورية</p>
                        <div class="flex items-center gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="autoBackupEnabled" class="sr-only peer">
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-gradient-to-r peer-checked:from-purple-600 peer-checked:to-pink-600"></div>
                            </label>
                            <span class="text-sm font-semibold text-purple-700 dark:text-purple-300">
                                @if($autoBackupEnabled) مفعّل @else معطّل @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Backups List --}}
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                <span class="w-2 h-8 bg-cyan-600 rounded-full inline-block"></span>
                النسخ الاحتياطية المتوفرة
            </h2>

            @if(count($backups) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($backups as $backup)
                        <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-cyan-500/10 dark:hover:shadow-cyan-900/30 hover:-translate-y-2">
                            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-cyan-400 to-indigo-500 rounded-t-2xl"></div>
                            
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-zinc-900 dark:text-white text-base mb-1" style="font-family: 'Questv1', sans-serif;">
                                        {{ $backup['name'] }}
                                    </h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $backup['date'] }}</p>
                                </div>
                            </div>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-600 dark:text-slate-400">الحجم:</span>
                                    <span class="font-bold text-cyan-600 dark:text-cyan-400">{{ $backup['size'] }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-600 dark:text-slate-400">النوع:</span>
                                    <span class="px-2 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-lg text-xs font-bold">
                                        {{ $backup['type'] }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-2">
                                <button 
                                    wire:click="downloadBackup('{{ $backup['file'] }}')"
                                    class="px-3 py-2 bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-800/40 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-1"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </button>
                                <button 
                                    wire:click="openRestoreModal('{{ $backup['file'] }}')"
                                    class="px-3 py-2 bg-emerald-100 dark:bg-emerald-900/30 hover:bg-emerald-200 dark:hover:bg-emerald-800/40 text-emerald-700 dark:text-emerald-300 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-1"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </button>
                                <button 
                                    wire:click="deleteBackup('{{ $backup['file'] }}')"
                                    wire:confirm="هل أنت متأكد من حذف هذه النسخة الاحتياطية؟"
                                    class="px-3 py-2 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-800/40 text-red-700 dark:text-red-300 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-1"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center bg-white/50 dark:bg-zinc-800/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700">
                    <div class="w-20 h-20 mx-auto bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-2">لا توجد نسخ احتياطية</h3>
                    <p class="text-zinc-500 dark:text-zinc-400">قم بإنشاء أول نسخة احتياطية الآن</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Restore Confirmation Modal --}}
    @if($showRestoreModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.closeRestoreModal()" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="h-2 bg-gradient-to-r from-amber-500 to-orange-500"></div>
            
            <div class="p-6">
                {{-- Warning Icon --}}
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-amber-500 to-orange-600 rounded-full flex items-center justify-center shadow-2xl animate-pulse">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>

                {{-- Title --}}
                <h2 class="text-2xl font-bold text-center text-zinc-900 dark:text-white mb-3" style="font-family: 'Questv1', sans-serif;">
                    تحذير: استعادة النسخة الاحتياطية
                </h2>

                {{-- Warning Message --}}
                <div class="bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-200 dark:border-amber-800 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-bold text-amber-900 dark:text-amber-100 mb-2">تحذير مهم جداً!</h4>
                            <ul class="text-sm text-amber-800 dark:text-amber-200 space-y-1.5">
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-600 dark:text-amber-400 mt-0.5">•</span>
                                    <span>سيتم استبدال جميع البيانات الحالية بالنسخة الاحتياطية</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-600 dark:text-amber-400 mt-0.5">•</span>
                                    <span>سيتم حذف جميع التغييرات التي تمت بعد إنشاء هذه النسخة</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-600 dark:text-amber-400 mt-0.5">•</span>
                                    <span>هذه العملية <strong>لا يمكن التراجع عنها</strong></span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-600 dark:text-amber-400 mt-0.5">•</span>
                                    <span>يُنصح بإنشاء نسخة احتياطية للوضع الحالي أولاً</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Backup Info --}}
                <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-4 mb-6">
                    <h4 class="text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">معلومات النسخة الاحتياطية:</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">اسم الملف:</span>
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $selectedBackup }}</span>
                        </div>
                    </div>
                </div>

                {{-- Confirmation Checkbox --}}
                <label class="flex items-start gap-3 p-4 bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-xl cursor-pointer hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors mb-6">
                    <input 
                        type="checkbox" 
                        wire:model="confirmRestore"
                        class="mt-1 w-5 h-5 rounded border-red-300 dark:border-red-700 text-red-600 focus:ring-2 focus:ring-red-500"
                    >
                    <span class="text-sm font-bold text-red-900 dark:text-red-100">
                        أؤكد أنني أدرك المخاطر وأرغب في استعادة هذه النسخة الاحتياطية
                    </span>
                </label>
            </div>

            {{-- Actions --}}
            <div class="p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button 
                    type="button" 
                    wire:click="closeRestoreModal" 
                    class="w-full sm:w-auto px-6 py-3 border-2 border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-bold transition-colors"
                >
                    إلغاء
                </button>
                <button 
                    type="button" 
                    wire:click="restoreBackup"
                    :disabled="!$wire.confirmRestore"
                    class="w-full sm:w-auto px-6 py-3 rounded-xl font-bold transition-all shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    :class="$wire.confirmRestore ? 'bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white' : 'bg-zinc-300 dark:bg-zinc-700 text-zinc-500 cursor-not-allowed'"
                >
                    <span wire:loading.remove wire:target="restoreBackup">
                        تأكيد الاستعادة
                    </span>
                    <span wire:loading wire:target="restoreBackup" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        جاري الاستعادة...
                    </span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
