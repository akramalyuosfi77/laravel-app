<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-zinc-900 dark:via-slate-900 dark:to-zinc-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        
        {{-- Header Section --}}
        <div class="text-center">
            <div class="mx-auto h-32 w-32 relative">
                <div class="absolute inset-0 bg-blue-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                <lottie-player
                    src="/animations/Welcome.json"
                    background="transparent"
                    speed="1"
                    style="width: 100%; height: 100%;"
                    loop
                    autoplay>
                </lottie-player>
            </div>
            
            <h2 class="mt-6 text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400" style="font-family: 'Questv1', sans-serif;">
                انضمام سريع للدفعة
            </h2>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                أنت على وشك الانضمام إلى زملائك في
            </p>
        </div>

        {{-- Batch Info Card --}}
        <div class="bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm rounded-2xl p-6 border border-blue-200 dark:border-blue-800 shadow-xl shadow-blue-500/10 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                        الدفعة المستهدفة
                    </span>
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-1">{{ $batch->name }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">
                    {{ $batch->specialization->name }} - {{ $batch->specialization->department->name }}
                </p>

                <div class="flex gap-2 text-xs font-semibold">
                    <span class="px-2 py-1 bg-slate-100 dark:bg-slate-700 rounded text-slate-600 dark:text-slate-300">
                        السنة {{ $batch->current_academic_year ?? 1 }}
                    </span>
                    <span class="px-2 py-1 bg-slate-100 dark:bg-slate-700 rounded text-slate-600 dark:text-slate-300">
                        الترم {{ $batch->current_semester ?? 1 }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Registration Flow Selection --}}
        <div class="mt-8 space-y-4">
            {{-- Google Fast Registration --}}
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-3xl shadow-xl border border-slate-100 dark:border-slate-700 text-center">
                <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-4">التسجيل السريع عبر جوجل</p>
                <a href="{{ route('auth.google.redirect', ['batch_id' => $batch->id]) }}" class="flex items-center justify-center gap-3 w-full py-3 px-4 bg-white dark:bg-zinc-700 border-2 border-slate-100 dark:border-slate-600 rounded-xl hover:bg-slate-50 dark:hover:bg-zinc-600 transition-all group">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.07.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400">تحقق ومتابعة عبر جوجل</span>
                </a>
            </div>

            <div class="relative py-4">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200 dark:border-slate-700"></div></div>
                <div class="relative flex justify-center text-xs uppercase"><span class="bg-slate-50 dark:bg-zinc-900 px-2 text-slate-500">أو سجل يدوياً</span></div>
            </div>

            {{-- Manual Form --}}
            <form wire:submit.prevent="register" class="bg-white dark:bg-zinc-800 p-8 rounded-3xl shadow-2xl border border-slate-100 dark:border-slate-700 space-y-6 text-right">
            <div class="space-y-4">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">الاسم الكامل</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input wire:model="name" id="name" type="text" required class="block w-full pr-10 pl-3 py-3 border border-slate-300 dark:border-slate-600 rounded-xl leading-5 bg-slate-50 dark:bg-zinc-700 text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="أدخل اسمك الرباعي">
                    </div>
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Student ID --}}
                <div>
                    <label for="student_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">الرقم الجامعي</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .884-.5 2-2 2h4c-1.5 0-2-1.116-2-2z"/>
                            </svg>
                        </div>
                        <input wire:model="student_id_number" id="student_id" type="text" required class="block w-full pr-10 pl-3 py-3 border border-slate-300 dark:border-slate-600 rounded-xl leading-5 bg-slate-50 dark:bg-zinc-700 text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="رقمك الجامعي">
                    </div>
                    @error('student_id_number') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">البريد الإلكتروني</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input wire:model="email" id="email" type="email" required class="block w-full pr-10 pl-3 py-3 border border-slate-300 dark:border-slate-600 rounded-xl leading-5 bg-slate-50 dark:bg-zinc-700 text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="example@student.edu">
                    </div>
                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">كلمة المرور</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input wire:model="password" id="password" type="password" required class="block w-full pr-10 pl-3 py-3 border border-slate-300 dark:border-slate-600 rounded-xl leading-5 bg-slate-50 dark:bg-zinc-700 text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="********">
                    </div>
                    @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">تأكيد كلمة المرور</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" required class="block w-full pr-10 pl-3 py-3 border border-slate-300 dark:border-slate-600 rounded-xl leading-5 bg-slate-50 dark:bg-zinc-700 text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all" placeholder="********">
                    </div>
                </div>
            </div>

            <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all hover:scale-[1.02] shadow-lg shadow-blue-500/30">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-blue-200 group-hover:text-blue-100 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                </span>
                <span wire:loading.remove>انضمام للدفعة الآن</span>
                <span wire:loading>جاري التسجيل...</span>
            </button>
        </form>
        
        <div class="text-center text-xs text-slate-500 dark:text-slate-400">
            &copy; {{ date('Y') }} جميع الحقوق محفوظة للنظام الجامعي الذكي
        </div>
    </div>
    
    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>