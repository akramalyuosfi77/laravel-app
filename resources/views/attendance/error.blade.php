<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ في تسجيل الحضور</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Cairo', sans-serif; }</style>
</head>
<body class="bg-zinc-50 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-3xl shadow-xl p-8 max-w-md w-full text-center border border-zinc-200">
        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h1 class="text-2xl font-black text-zinc-900 mb-2">عفواً!</h1>
        <p class="text-zinc-600 mb-8">{{ $message }}</p>
        <a href="/student/dashboard" class="inline-block w-full py-3 px-6 bg-zinc-900 hover:bg-zinc-800 text-white rounded-xl font-bold transition-colors">
            العودة للرئيسية
        </a>
    </div>
</body>
</html>
