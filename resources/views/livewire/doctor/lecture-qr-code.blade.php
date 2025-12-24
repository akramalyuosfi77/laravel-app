<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        @section('title', 'إدارة الحضور QR')

        {{-- Header Section --}}
        <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-indigo-50 to-purple-50 dark:from-zinc-900 dark:via-indigo-900/20 dark:to-purple-900/20 border border-slate-200 dark:border-slate-800" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
            {{-- Animated Background Orbs --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-10 right-10 w-72 h-72 bg-indigo-400/20 dark:bg-indigo-600/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-10 left-10 w-96 h-96 bg-purple-400/20 dark:bg-purple-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-100 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-800 rounded-full mb-4">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                            <span class="text-sm font-bold text-indigo-700 dark:text-indigo-300">نظام الحضور الذكي</span>
                        </div>
                        
                        <h1 class="text-3xl md:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-indigo-700 to-purple-700 dark:from-slate-100 dark:via-indigo-300 dark:to-purple-300 mb-2 leading-tight" style="font-family: 'Questv1', sans-serif;">
                            {{ $lecture->title }}
                        </h1>
                        <p class="text-lg text-slate-600 dark:text-slate-300 flex items-center gap-2">
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $lecture->course->name }}</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                            <span>{{ \Carbon\Carbon::parse($lecture->lecture_date)->format('Y-m-d') }}</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                            <span>{{ \Carbon\Carbon::parse($lecture->lecture_date)->translatedFormat('l') }}</span>
                        </p>
                    </div>

                    <a href="{{ route('doctor.lectures') }}" class="group relative px-6 py-3 bg-white dark:bg-zinc-800 border border-slate-200 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-700 text-slate-700 dark:text-slate-200 rounded-2xl font-bold transition-all hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <span>العودة للمحاضرات</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
            {{-- Main QR Section --}}
            <div class="lg:col-span-7 space-y-8">
                <div class="bg-white/80 dark:bg-zinc-800/80 backdrop-blur-xl rounded-3xl border border-slate-200/50 dark:border-slate-700/50 p-8 shadow-xl relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10 flex flex-col items-center justify-center min-h-[400px]">
                        @if ($isActive && $qrCodeUrl)
                            <div class="relative" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                                <div class="absolute -inset-4 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-[2rem] opacity-75 blur-lg animate-pulse"></div>
                                <div class="relative bg-white p-6 rounded-[1.5rem] shadow-2xl transform transition-all duration-700" 
                                     :class="show ? 'scale-100 opacity-100 rotate-0' : 'scale-90 opacity-0 rotate-12'">
                                    <img src="{{ $qrCodeUrl }}" alt="QR Code" class="w-72 h-72 object-contain">
                                    
                                    {{-- Scanning Animation Overlay --}}
                                    <div class="absolute inset-0 overflow-hidden rounded-[1.5rem]">
                                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-indigo-500 to-transparent opacity-50 animate-scan"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 text-center space-y-2">
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-xl font-bold animate-bounce">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-ping"></span>
                                    <span>جاري استقبال الحضور</span>
                                </div>
                                <p class="text-slate-500 dark:text-slate-400 text-sm">اطلب من الطلاب مسح الرمز باستخدام التطبيق</p>
                            </div>
                        @else
                            <div class="text-center relative">
                                <div class="w-32 h-32 mx-auto bg-slate-100 dark:bg-slate-800/50 rounded-full flex items-center justify-center mb-6 relative group-hover:scale-110 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-indigo-500/10 rounded-full animate-ping"></div>
                                    <svg class="w-16 h-16 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zm-6 12v-2m0 0v-2m0 2H9m12 0h2m-2 0v2m0-2h-2m0 0l-2-2m-2 2l-2-2m2 2l2 2m7-2v2m0-2h-2M9 4v2m2 2h2v2H9V6zm0 0h2v2H9V6zm6 6h2v2h-2v-2zm-6 0h2v2H9v-2zm-6 0h2v2H3v-2zm6 0v2m-6 0v2m6-2h2m-2 0v2m0-2h-2m0 0l-2-2m-2 2l-2-2m2 2l2 2m7-2v2m0-2h-2"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2" style="font-family: 'Questv1', sans-serif;">الحضور غير مفعّل</h3>
                                <p class="text-slate-500 dark:text-slate-400 max-w-xs mx-auto">قم باختيار مدة التفعيل من القائمة الجانبية لبدء تسجيل الحضور</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar Controls --}}
            <div class="lg:col-span-5 space-y-6">
                {{-- Timer Card --}}
                <div class="bg-white/80 dark:bg-zinc-800/80 backdrop-blur-xl rounded-3xl border border-slate-200/50 dark:border-slate-700/50 p-6 shadow-lg">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        الوقت المتبقي
                    </h3>
                    
                    <div class="relative overflow-hidden rounded-2xl bg-slate-50 dark:bg-slate-900/50 p-6 text-center">
                        @if ($isActive)
                            <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-br from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 mb-2 font-mono tracking-wider">
                                {{ $remainingMinutes }}
                            </div>
                            <div class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">دقيقة</div>
                            
                            {{-- Progress Bar --}}
                            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-slate-200 dark:bg-slate-700">
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 animate-progress" style="width: 100%"></div>
                            </div>
                        @else
                            <div class="text-4xl font-bold text-slate-300 dark:text-slate-600">-- : --</div>
                        @endif
                    </div>
                </div>

                {{-- Controls Card --}}
                <div class="bg-white/80 dark:bg-zinc-800/80 backdrop-blur-xl rounded-3xl border border-slate-200/50 dark:border-slate-700/50 p-6 shadow-lg">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        لوحة التحكم
                    </h3>

                    @if (!$isActive)
                        <div class="space-y-3">
                            <button wire:click="enableAttendance(15)" class="w-full group relative overflow-hidden p-4 rounded-2xl bg-white dark:bg-zinc-700 border border-slate-200 dark:border-slate-600 hover:border-indigo-500 dark:hover:border-indigo-500 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="relative flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                            <span class="font-bold">15</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-slate-800 dark:text-white">تفعيل لمدة 15 دقيقة</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">مناسب للمحاضرات القصيرة</div>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-300 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </button>

                            <button wire:click="enableAttendance(30)" class="w-full group relative overflow-hidden p-4 rounded-2xl bg-white dark:bg-zinc-700 border border-slate-200 dark:border-slate-600 hover:border-purple-500 dark:hover:border-purple-500 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-pink-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="relative flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                                            <span class="font-bold">30</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-slate-800 dark:text-white">تفعيل لمدة 30 دقيقة</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">الوقت القياسي للحضور</div>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-300 group-hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </button>

                            <button wire:click="enableAttendance(60)" class="w-full group relative overflow-hidden p-4 rounded-2xl bg-white dark:bg-zinc-700 border border-slate-200 dark:border-slate-600 hover:border-pink-500 dark:hover:border-pink-500 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <div class="absolute inset-0 bg-gradient-to-r from-pink-500/10 to-rose-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="relative flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center text-pink-600 dark:text-pink-400">
                                            <span class="font-bold">60</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-slate-800 dark:text-white">تفعيل لمدة ساعة</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">للمحاضرات الطويلة</div>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-300 group-hover:text-pink-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </button>
                        </div>
                    @else
                        <div class="space-y-4">
                            <div class="p-4 rounded-2xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/50 flex items-center justify-center text-green-600 dark:text-green-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-green-800 dark:text-green-300">النظام نشط</div>
                                    <div class="text-xs text-green-600 dark:text-green-400">يتم تسجيل الحضور الآن</div>
                                </div>
                            </div>

                            <button wire:click="refreshStatus" class="w-full py-3 px-4 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-900/20 dark:hover:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-xl font-bold transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <span>تحديث الحالة</span>
                            </button>

                            <button wire:click="disableAttendance" class="w-full py-3 px-4 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 rounded-xl font-bold transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                                <span>إيقاف الحضور</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Attendance List Section --}}
        <div class="bg-white/80 dark:bg-zinc-800/80 backdrop-blur-xl rounded-3xl border border-slate-200/50 dark:border-slate-700/50 p-8 shadow-xl">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-3" style="font-family: 'Questv1', sans-serif;">
                    <span class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </span>
                    قائمة الحضور
                </h3>
                <div class="px-4 py-2 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800/50">
                    <span class="text-slate-500 dark:text-slate-400 text-sm">عدد الحاضرين:</span>
                    <span class="font-bold text-indigo-600 dark:text-indigo-400 text-lg mr-2">{{ count($attendances) }}</span>
                </div>
            </div>

            @if(count($attendances) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($attendances as $attendance)
                        <div class="group relative bg-white dark:bg-zinc-900 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xl font-bold text-slate-500 dark:text-slate-400 overflow-hidden">
                                    {{ substr($attendance->student->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-slate-800 dark:text-white truncate">{{ $attendance->student->name }}</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $attendance->student->email }}</p>
                                </div>
                            </div>
                            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                                <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $attendance->created_at->format('h:i A') }}
                                </span>
                                <span class="px-2 py-1 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-bold">
                                    حاضر
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 mx-auto bg-slate-50 dark:bg-slate-800/50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 font-medium">لم يتم تسجيل حضور أي طالب بعد</p>
                </div>
            @endif
        </div>

        {{-- Auto Refresh Script --}}
        @if ($isActive)
            <script>
                setInterval(() => {
                    @this.call('refreshStatus');
                }, 30000);
            </script>
        @endif
    </div>

    <style>
        @keyframes scan {
            0% { top: 0; opacity: 0; }
            50% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }
        .animate-scan {
            animation: scan 2s linear infinite;
        }
        @keyframes progress {
            0% { width: 100%; }
            100% { width: 0%; }
        }
        .animate-progress {
            animation: progress {{ $remainingMinutes * 60 }}s linear forwards;
        }
    </style>
</div>
