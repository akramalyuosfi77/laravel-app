<div class="fixed bottom-6 right-6 z-[9999] font-sans rtl" x-data="{ open: @entangle('isOpen') }">
    
    {{-- Chat Window Container --}}
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-8 scale-95"
        class="w-[85vw] md:w-[340px] h-[500px] bg-white dark:bg-[#0f111a] rounded-[2rem] shadow-[0_15px_40px_rgba(0,0,0,0.25)] border border-zinc-200 dark:border-zinc-800 flex flex-col overflow-hidden ring-1 ring-black/5"
        style="display: none;"
    >
        {{-- Elegant Compact Header --}}
        <div class="relative p-5 bg-gradient-to-r from-[#1e293b] to-[#334155] dark:from-[#1a1c26] dark:to-[#242736] shrink-0 border-b border-white/5">
            <div class="relative z-10 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 border border-indigo-400/30">
                            <span class="text-2xl">🤖</span>
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-[#1e293b] rounded-full"></span>
                    </div>
                    <div class="text-right">
                        <h3 class="font-bold text-white text-sm leading-tight">نورس AI</h3>
                        <p class="text-indigo-200 text-[10px] font-medium opacity-80">المساعد الأكاديمي الذكي</p>
                    </div>
                </div>
                <button @click="open = false" class="p-2 rounded-lg text-zinc-400 hover:text-white hover:bg-white/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Messages Area --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar bg-slate-50/50 dark:bg-[#0d0f17]" id="chat-messages">
            @foreach($messages as $msg)
                <div class="flex w-full {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }} animate-fade-in-up">
                    <div class="flex max-w-[90%] gap-2.5 {{ $msg['role'] === 'user' ? 'flex-row-reverse' : 'flex-row' }}">
                        
                        <div class="w-7 h-7 rounded-lg shadow-sm shrink-0 flex items-center justify-center text-xs {{ $msg['role'] === 'user' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-100 dark:border-zinc-700' }}">
                            {{ $msg['role'] === 'user' ? '👤' : '🤖' }}
                        </div>

                        <div class="flex flex-col {{ $msg['role'] === 'user' ? 'items-end' : 'items-start' }}">
                            <div class="
                                p-3.5 px-4 rounded-2xl text-[13px] leading-relaxed shadow-sm
                                {{ $msg['role'] === 'user' 
                                    ? 'bg-indigo-600 text-white rounded-tr-none' 
                                    : 'bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 rounded-tl-none border border-zinc-100 dark:border-zinc-700' 
                                }}
                            ">
                                {!! \Illuminate\Support\Str::markdown($msg['content']) !!}
                            </div>
                            <span class="text-[9px] text-zinc-400 mt-1 px-1 font-medium">
                                {{ $msg['time'] }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($isTyping)
                <div class="flex justify-start items-center gap-2.5 animate-pulse">
                     <div class="w-7 h-7 rounded-lg bg-zinc-200 dark:bg-zinc-800 flex items-center justify-center text-xs">🤖</div>
                     <div class="px-4 py-2.5 bg-white dark:bg-zinc-800 rounded-2xl rounded-tl-none border border-zinc-100 dark:border-zinc-700 shadow-sm flex gap-1 items-center">
                         <span class="w-1 h-1 bg-indigo-500 rounded-full animate-bounce"></span>
                         <span class="w-1 h-1 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
                         <span class="w-1 h-1 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                     </div>
                </div>
            @endif
        </div>

        {{-- Input Area --}}
        <div class="p-4 bg-white dark:bg-[#0f111a] border-t border-zinc-100 dark:border-zinc-800 shrink-0">
            <form wire:submit.prevent="sendMessage" class="relative">
                <input 
                    type="text" 
                    wire:model="message" 
                    placeholder="اسأل نورس..." 
                    class="w-full pl-12 pr-4 py-3 bg-zinc-100 dark:bg-zinc-800/80 border-0 rounded-xl focus:ring-2 focus:ring-indigo-500 text-zinc-900 dark:text-white placeholder-zinc-400 text-sm transition-all"
                >
                <button 
                    type="submit" 
                    class="absolute top-1/2 left-1.5 -translate-y-1/2 w-8 h-8 rounded-lg bg-indigo-600 text-white shadow-md hover:bg-indigo-700 transition-all flex items-center justify-center"
                    wire:loading.attr="disabled"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </form>
            <div class="text-center mt-2">
                <span class="text-[8px] text-zinc-400 dark:text-zinc-500 font-bold uppercase tracking-widest">جامعة الحضارة | AI</span>
            </div>
        </div>
    </div>

    {{-- Floating Button --}}
    <button 
        @click="open = !open" 
        class="group relative flex items-center justify-center w-[60px] h-[60px] rounded-2xl shadow-[0_10px_30px_rgba(79,70,229,0.3)] transition-all duration-300"
    >
        <div class="absolute inset-0 bg-indigo-600 rounded-2xl group-hover:scale-105 transition-transform"></div>
        <div class="relative z-10 transition-all duration-300" :class="open ? 'rotate-90 scale-75' : 'rotate-0 scale-100'">
            <div x-show="!open" class="text-3xl">🤖</div>
            <div x-show="open" style="display: none;">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
        </div>
    </button>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(79, 70, 229, 0.2); border-radius: 10px; }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fade-in-up 0.4s ease-out forwards; }
    </style>
</div>