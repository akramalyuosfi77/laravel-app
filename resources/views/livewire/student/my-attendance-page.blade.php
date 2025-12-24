<div class="min-h-screen bg-gradient-to-br from-slate-50 via-green-50/30 to-emerald-50/30 dark:from-zinc-900 dark:via-green-950/20 dark:to-emerald-950/20">
    @section('title', 'سجل الحضور')
    
    {{-- Hero Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-green-600 to-teal-600 dark:from-emerald-900 dark:via-green-900 dark:to-teal-900 shadow-2xl shadow-green-500/20">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-teal-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 p-8 md:p-12">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div class="order-2 md:order-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        <span class="text-sm font-bold text-white">متابعة الحضور</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-white mb-4 leading-tight">
                        ✅ سجل الحضور
                    </h1>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        تابع نسبة حضورك في جميع المواد الدراسية!
                    </p>
                    
                    <button wire:click="openScannerModal" class="group relative inline-flex items-center justify-center px-8 py-3 overflow-hidden font-bold text-emerald-600 transition-all duration-300 bg-white rounded-2xl hover:bg-emerald-50 hover:scale-105 shadow-lg shadow-emerald-900/20">
                        <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-emerald-100 opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                        <svg class="w-6 h-6 ml-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zm-6 12v-2m0 0v-2m0 2H9m12 0h2m-2 0v2m0-2h-2m0 0l-2-2m-2 2l-2-2m2 2l2 2m7-2v2m0-2h-2M9 4v2m2 2h2v2H9V6zm0 0h2v2H9V6zm6 6h2v2h-2v-2zm-6 0h2v2H9v-2zm-6 0h2v2H3v-2zm6 0v2m-6 0v2m6-2h2m-2 0v2m0-2h-2m0 0l-2-2m-2 2l-2-2m2 2l2 2m7-2v2m0-2h-2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6z"></path></svg>
                        <span class="relative">تسجيل حضور (QR)</span>
                    </button>
                </div>

                <div class="order-1 md:order-2 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-3xl"></div>
                        <lottie-player
                            src="/animations/data analysis.json"
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

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="currentColor" class="text-slate-50 dark:text-zinc-900"/>
            </svg>
        </div>
    </div>

    {{-- Attendance Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($attendanceSummary as $summary)
            @php
                $percentage = $summary['percentage'];
                if ($percentage >= 85) {
                    $theme = ['gradient' => 'from-emerald-500 to-teal-500', 'bg' => 'from-emerald-50 to-teal-50 dark:from-emerald-950/30 dark:to-teal-950/30', 'icon' => 'bg-emerald-500', 'bar' => 'bg-emerald-500'];
                } elseif ($percentage >= 70) {
                    $theme = ['gradient' => 'from-yellow-500 to-amber-500', 'bg' => 'from-yellow-50 to-amber-50 dark:from-yellow-950/30 dark:to-amber-950/30', 'icon' => 'bg-yellow-500', 'bar' => 'bg-yellow-500'];
                } else {
                    $theme = ['gradient' => 'from-red-500 to-rose-500', 'bg' => 'from-red-50 to-rose-50 dark:from-red-950/30 dark:to-rose-950/30', 'icon' => 'bg-red-500', 'bar' => 'bg-red-500'];
                }
            @endphp

            <div class="group relative bg-gradient-to-br {{ $theme['bg'] }} p-6 rounded-3xl border-2 border-white dark:border-zinc-800 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 overflow-hidden">
                <div class="h-2 bg-gradient-to-r {{ $theme['gradient'] }} rounded-t-3xl absolute top-0 left-0 right-0"></div>
                
                <div class="relative z-10 mt-4">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 class="font-black text-xl text-zinc-900 dark:text-white leading-tight mb-1 break-words">
                                {{ $summary['course_name'] }}
                            </h3>
                            <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400">
                                {{ $summary['course_code'] }}
                            </p>
                        </div>
                        <div class="w-14 h-14 rounded-full flex items-center justify-center bg-gradient-to-br {{ $theme['gradient'] }} text-white shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-zinc-700 dark:text-zinc-300">نسبة الحضور</span>
                            <span class="text-2xl font-black bg-gradient-to-r {{ $theme['gradient'] }} bg-clip-text text-transparent">
                                {{ $summary['percentage'] }}%
                            </span>
                        </div>
                        <div class="relative w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-3 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r {{ $theme['gradient'] }} rounded-full transition-all duration-1000 ease-out"
                                style="width: {{ $summary['percentage'] }}%">
                                <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <div class="text-center p-3 bg-white/50 dark:bg-zinc-800/50 rounded-2xl">
                            <p class="text-2xl font-black text-zinc-900 dark:text-white">{{ $summary['total_lectures'] }}</p>
                            <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 mt-1">إجمالي</p>
                        </div>
                        <div class="text-center p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-2xl">
                            <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $summary['present_count'] }}</p>
                            <p class="text-xs font-semibold text-emerald-700 dark:text-emerald-500 mt-1">حضور</p>
                        </div>
                        <div class="text-center p-3 bg-red-100 dark:bg-red-900/30 rounded-2xl">
                            <p class="text-2xl font-black text-red-600 dark:text-red-400">{{ $summary['absent_count'] }}</p>
                            <p class="text-xs font-semibold text-red-700 dark:text-red-500 mt-1">غياب</p>
                        </div>
                    </div>

                    <button wire:click="showDetails({{ $summary['course_id'] }})" class="group/btn relative w-full inline-flex items-center justify-center px-6 py-3 overflow-hidden font-bold text-white transition-all duration-300 bg-gradient-to-r {{ $theme['gradient'] }} rounded-2xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-400/50 shadow-lg">
                        <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover/btn:-translate-x-40 ease"></span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span class="relative">عرض التفاصيل</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 xl:col-span-3 text-center py-20 bg-white dark:bg-zinc-900/50 backdrop-blur-sm rounded-3xl border-2 border-dashed border-zinc-300 dark:border-zinc-700 shadow-xl">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900/20 dark:to-emerald-900/20 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <svg class="w-16 h-16 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-3">لا يوجد سجل حضور بعد</h3>
                <p class="text-zinc-600 dark:text-zinc-400 max-w-md mx-auto">لم يتم تسجيل أي محاضرات في موادك الدراسية حتى الآن.</p>
            </div>
        @endforelse
    </div>

    {{-- 3. نافذة عرض التفاصيل --}}
    @if ($detailsForCourse)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.closeDetailsModal()" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="flex-shrink-0 p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">
                    تفاصيل الحضور: {{ $detailsForCourse['course_name'] }}
                </h2>
                <button wire:click="closeDetailsModal" class="p-2 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="flex-grow p-6 overflow-y-auto">
                <ul class="space-y-3">
                    @forelse ($detailsForCourse['records'] as $record)
                        <li class="flex items-center justify-between p-4 rounded-lg
                            @if($record['status'] == 'present') bg-green-50 dark:bg-green-900/20
                            @elseif($record['status'] == 'excused_absence') bg-yellow-50 dark:bg-yellow-900/20
                            @else bg-red-50 dark:bg-red-900/20 @endif">

                            <div>
                                <p class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $record['lecture_title'] }}</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ \Carbon\Carbon::parse($record['lecture_date'])->format('l, Y-m-d') }}</p>
                            </div>

                            <span class="px-3 py-1 text-sm font-bold rounded-full
                                @if($record['status'] == 'present') bg-green-200 text-green-800 dark:bg-green-500/30 dark:text-green-300
                                @elseif($record['status'] == 'excused_absence') bg-yellow-200 text-yellow-800 dark:bg-yellow-500/30 dark:text-yellow-300
                                @else bg-red-200 text-red-800 dark:bg-red-500/30 dark:text-red-300 @endif">
                                @if($record['status'] == 'present') حاضر
                                @elseif($record['status'] == 'excused_absence') غائب بعذر
                                @else غائب @endif
                            </span>
                        </li>
                    @empty
                        <li class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                            لا توجد محاضرات مسجلة لهذه المادة بعد.
                        </li>
                    @endforelse
                </ul>
            </div>
            <div class="flex-shrink-0 p-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end">
                <button wire:click="closeDetailsModal" class="px-5 py-2.5 bg-zinc-200 hover:bg-zinc-300 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-800 dark:text-zinc-200 rounded-xl font-semibold transition-colors">
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
            background: linear-gradient(180deg, rgba(16, 185, 129, 0.3), rgba(20, 184, 166, 0.3));
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(16, 185, 129, 0.5), rgba(20, 184, 166, 0.5));
        }
    </style>
    {{-- Scanner Modal --}}
    @if($showScannerModal)
    <div class="fixed inset-0 bg-black/90 backdrop-blur-md flex items-center justify-center p-4 z-50" x-data="{
        scanner: null,
        initScanner() {
            this.$nextTick(() => {
                this.scanner = new Html5QrcodeScanner('reader', { 
                    fps: 10, 
                    qrbox: {width: 250, height: 250},
                    aspectRatio: 1.0
                });
                
                this.scanner.render((decodedText, decodedResult) => {
                    this.scanner.clear();
                    @this.handleScannedCode(decodedText);
                }, (errorMessage) => {
                    // parse error, ignore it.
                });
            });
        },
        stopScanner() {
            if(this.scanner) {
                this.scanner.clear().catch(error => console.error('Failed to clear html5-qrcode', error));
            }
            @this.closeScannerModal();
        }
    }" x-init="initScanner()">
        <div class="bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl w-full max-w-md border border-zinc-200 dark:border-zinc-800 overflow-hidden relative">
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-4 text-center">
                <h2 class="text-xl font-black text-white">📷 مسح رمز QR</h2>
                <button @click="stopScanner()" class="absolute top-4 right-4 text-white hover:text-emerald-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="p-6 bg-black">
                <div id="reader" class="w-full rounded-xl overflow-hidden border-2 border-emerald-500"></div>
                <p class="text-center text-zinc-400 text-sm mt-4">وجه الكاميرا نحو رمز QR الخاص بالمحاضرة</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Scripts --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</div>
