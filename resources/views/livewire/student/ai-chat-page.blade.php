<div>
    {{-- 1. الهيدر --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">المساعد الذكي</h1>
        <p class="mt-1 text-zinc-500 dark:text-zinc-400">اطرح أي سؤال يتعلق بالمنصة، المقررات، أو التكاليف.</p>
    </div>

    {{-- 2. جسم الشات --}}
    <div class="bg-white dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 flex flex-col" style="height: 70vh;">

        {{-- منطقة عرض الرسائل --}}
        <div class="flex-1 p-6 space-y-6 overflow-y-auto">
            @forelse ($conversation as $message)
                @if ($message['sender'] === 'ai')
                    {{-- رسالة الذكاء الاصطناعي (على اليسار) --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/50 rounded-full">
                            {{-- أيقونة الروبوت --}}
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM7.5 12c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5zm5.01 0c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5zM12 16c-1.48 0-2.75-.81-3.45-2H15.45c-.7 1.19-1.97 2-3.45 2z"/></svg>
                        </div>
                        <div class="p-4 bg-zinc-100 dark:bg-zinc-700 rounded-2xl rounded-tl-none">
                            <p class="text-sm text-zinc-800 dark:text-zinc-200 leading-relaxed">{{ $message['text'] }}</p>
                        </div>
                    </div>
                @else
                    {{-- رسالة المستخدم (على اليمين ) --}}
                    <div class="flex items-start gap-4 flex-row-reverse">
                        <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center bg-sky-100 dark:bg-sky-900/50 rounded-full">
                            {{-- أيقونة المستخدم --}}
                            <svg class="w-6 h-6 text-sky-600 dark:text-sky-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div class="p-4 bg-sky-500 text-white rounded-2xl rounded-tr-none">
                            <p class="text-sm leading-relaxed">{{ $message['text'] }}</p>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center text-zinc-400">ابدأ محادثتك...</div>
            @endforelse

            {{-- مؤشر "جارٍ الكتابة..." --}}
            @if ($isLoading )
                <div class="flex items-start gap-4" wire:key="loading-indicator">
                    <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/50 rounded-full">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM7.5 12c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5zm5.01 0c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5zM12 16c-1.48 0-2.75-.81-3.45-2H15.45c-.7 1.19-1.97 2-3.45 2z"/></svg>
                    </div>
                    <div class="p-4 bg-zinc-100 dark:bg-zinc-700 rounded-2xl rounded-tl-none">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-indigo-400 rounded-full animate-pulse delay-0"></span>
                            <span class="w-2 h-2 bg-indigo-400 rounded-full animate-pulse delay-150"></span>
                            <span class="w-2 h-2 bg-indigo-400 rounded-full animate-pulse delay-300"></span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- منطقة إدخال النص --}}
        <div class="p-4 bg-white dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
            <form wire:submit.prevent="sendMessage" class="flex items-center gap-4">
                <input
                    type="text"
                    wire:model="currentMessage"
                    placeholder="اكتب رسالتك هنا..."
                    class="flex-1 w-full px-4 py-2 bg-zinc-100 dark:bg-zinc-700 border-transparent rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-transparent transition"
                    autocomplete="off"
                    :disabled="$isLoading"
                >
                <button
                    type="submit"
                    class="w-10 h-10 flex-shrink-0 flex items-center justify-center bg-sky-500 hover:bg-sky-600 text-white rounded-full transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="$isLoading"
                >
                    {{-- أيقونة الإرسال --}}
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                </button>
            </form>
        </div>
    </div>
</div>
