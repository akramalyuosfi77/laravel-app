<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم تسجيل الحضور</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Cairo', sans-serif; }</style>
</head>
<body class="bg-zinc-50 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-3xl shadow-xl p-8 max-w-md w-full text-center border border-zinc-200 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-500 to-emerald-500"></div>
        
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        
        <h1 class="text-3xl font-black text-zinc-900 mb-2">ممتاز!</h1>
        <p class="text-lg text-green-600 font-bold mb-6">{{ $message }}</p>
        
        <div class="bg-zinc-50 rounded-2xl p-4 mb-8 text-right border border-zinc-100">
            <p class="text-xs text-zinc-400 font-bold mb-1">المحاضرة</p>
            <h3 class="font-bold text-zinc-900">{{ $lecture->title }}</h3>
            <p class="text-sm text-zinc-500 mt-1">{{ $lecture->course->name }}</p>
            <p class="text-xs text-zinc-400 mt-2">{{ now()->format('Y-m-d H:i A') }}</p>
        </div>

        <a href="/student/dashboard" class="inline-block w-full py-3 px-6 bg-zinc-900 hover:bg-zinc-800 text-white rounded-xl font-bold transition-colors shadow-lg shadow-zinc-200">
            العودة للرئيسية
        </a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 }
        });
    </script>
</body>
</html>
