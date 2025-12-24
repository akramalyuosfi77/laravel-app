<div class="flex flex-col h-[500px] bg-slate-50 dark:bg-zinc-900 rounded-2xl border border-slate-200 dark:border-zinc-700 overflow-hidden shadow-sm">
    
    {{-- Chat Header --}}
    <div class="p-4 bg-gradient-to-r from-teal-500 to-emerald-500 text-white flex items-center gap-3 shadow-md">
        <div class="p-2 bg-white/20 rounded-full backdrop-blur-sm">
            <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
            </svg>
        </div>
        <div>
            <h3 class="font-bold text-lg">المساعد الذكي (AI)</h3>
            <p class="text-xs text-teal-100">اسألني عن محتوى المحاضرة</p>
        </div>
        @if(!$hasPdf)
            <span class="mr-auto text-xs bg-yellow-500/20 text-yellow-100 px-2 py-1 rounded border border-yellow-500/30">
                ⚠️ لا يوجد ملف PDF 
            </span>
        @endif
    </div>

    {{-- Chat Messages Area --}}
    <div class="flex-grow overflow-y-auto p-4 space-y-4 custom-scrollbar" id="chat-container">
        @foreach($messages as $msg)
            <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[80%] rounded-2xl p-4 {{ $msg['role'] === 'user' ? 'bg-teal-500 text-white rounded-br-none shadow-lg shadow-teal-500/10' : 'bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 text-slate-800 dark:text-slate-200 rounded-bl-none shadow-sm' }}">
                    <p class="text-sm leading-relaxed whitespace-pre-line">{{ $msg['content'] }}</p>
                </div>
            </div>
        @endforeach

        {{-- Loading Indicator --}}
        @if($isLoading)
            <div class="flex justify-start">
                <div class="bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 rounded-2xl rounded-bl-none p-4 shadow-sm flex items-center gap-2">
                    <div class="w-2 h-2 bg-teal-500 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-teal-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-2 h-2 bg-teal-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <span class="text-xs text-slate-400 mr-2">جاري التفكير...</span>
                </div>
            </div>
        @endif
    </div>

    {{-- Input Area --}}
    <div class="p-4 bg-white dark:bg-zinc-800 border-t border-slate-200 dark:border-zinc-700">
        <form wire:submit.prevent="sendMessage" class="relative flex items-center gap-2">
            <input 
                type="text" 
                wire:model.live="userQuestion" 
                placeholder="اكتب سؤالك هنا عن المحاضرة..." 
                class="flex-grow px-4 py-3 bg-slate-100 dark:bg-zinc-700/50 border-0 rounded-xl focus:ring-2 focus:ring-teal-500 dark:text-white placeholder-slate-400 transition-all"
                wire:loading.attr="disabled"
            >
            <button 
                type="submit" 
                wire:loading.attr="disabled"
                class="p-3 bg-teal-500 hover:bg-teal-600 text-white rounded-xl transition-all shadow-lg shadow-teal-500/20 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </form>
        <div class="text-center mt-2">
            <p class="text-[10px] text-slate-400">مدعوم بواسطة Google Gemini 🤖</p>
        </div>
    </div>

    <script>
        // Auto scroll to bottom
        document.addEventListener('livewire:initialized', () => {
             const container = document.getElementById('chat-container');
             const scrollToBottom = () => {
                 container.scrollTop = container.scrollHeight;
             };
             
             // Scroll on load
             scrollToBottom();

             // Scroll on message updates
             Livewire.hook('morph.updated', ({ el, component }) => {
                 scrollToBottom();
             });
        });
    </script>
</div>
