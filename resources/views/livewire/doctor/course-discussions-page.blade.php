<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        
        {{-- 1. Hero Section المدمج --}}
        <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-violet-50 to-purple-50 dark:from-zinc-900 dark:via-violet-900/20 dark:to-purple-900/20 border border-slate-200 dark:border-slate-800" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
            {{-- Animated Background Orbs --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-10 right-10 w-72 h-72 bg-violet-400/20 dark:bg-violet-600/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-10 left-10 w-96 h-96 bg-purple-400/20 dark:bg-purple-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 p-8">
                {{-- Grid Layout: Animation + Content --}}
                <div class="grid md:grid-cols-2 gap-8 items-center mb-6">
                    {{-- Left Side: Animation --}}
                    <div class="order-1 md:order-1 flex justify-center">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-violet-500 to-purple-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                            <lottie-player
                                src="/animations/Demo.json"
                                background="transparent"
                                speed="1"
                                style="width: 100%; max-width: 300px; height: auto;"
                                loop
                                autoplay>
                            </lottie-player>
                        </div>
                    </div>

                    {{-- Right Side: Content --}}
                    <div class="order-2 md:order-2">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-violet-100 dark:bg-violet-900/30 border border-violet-200 dark:border-violet-800 rounded-full mb-4">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-violet-500"></span>
                            </span>
                            <span class="text-sm font-bold text-violet-700 dark:text-violet-300">ساحة المناقشات</span>
                        </div>
                        
                        <h1 class="text-3xl md:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-violet-700 to-purple-700 dark:from-slate-100 dark:via-violet-300 dark:to-purple-300 mb-2 leading-tight" style="font-family: 'Questv1', sans-serif;">
                            إدارة المناقشات
                        </h1>
                        <p class="text-lg text-slate-600 dark:text-slate-300 leading-relaxed mb-4">
                            المادة: <span class="font-bold text-violet-600 dark:text-violet-400">{{ $course->name }}</span>
                        </p>

                        {{-- Toggle Switch --}}
                        <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm px-6 py-4 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 inline-block">
                            <label for="toggle-replies" class="flex items-center cursor-pointer gap-3">
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-300">السماح للطلاب بالرد</span>
                                <div class="relative">
                                    <input type="checkbox" id="toggle-replies" class="sr-only" wire:click="toggleStudentReplies" {{ $course->student_replies_enabled ? 'checked' : '' }}>
                                    <div class="block bg-slate-300 dark:bg-slate-600 w-14 h-8 rounded-full"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition shadow-md"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Discussions List --}}
            <div class="lg:col-span-1 bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 shadow-xl h-fit">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    النقاشات
                </h2>
                
                {{-- Search --}}
                <div class="mb-4 relative">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="ابحث في النقاشات..." class="w-full pr-10 pl-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-violet-500 transition-all">
                </div>

                {{-- Discussions Items --}}
                <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-2">
                    @forelse ($discussions as $discussion)
                        <div wire:click="selectDiscussion({{ $discussion->id }})" class="group p-4 rounded-xl cursor-pointer transition-all duration-200 {{ $selectedDiscussionId == $discussion->id ? 'bg-violet-100 dark:bg-violet-900/30 border-2 border-violet-500 shadow-md' : 'bg-slate-50 dark:bg-slate-700/50 hover:bg-slate-100 dark:hover:bg-slate-700 border-2 border-transparent' }}">
                            <p class="font-bold text-slate-900 dark:text-white truncate mb-2 group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">{{ $discussion->title }}</p>
                            <div class="flex justify-between items-center text-xs text-slate-500 dark:text-slate-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $discussion->student->user->name }}
                                </span>
                                <span class="flex items-center gap-1 px-2 py-1 bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 rounded-full font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    {{ $discussion->replies_count }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-8 bg-slate-50 dark:bg-slate-800/50 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-700">
                            <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p class="text-slate-500 dark:text-slate-400 font-medium">لا توجد نقاشات</p>
                        </div>
                    @endforelse
                </div>
                
                @if($discussions->hasPages())
                    <div class="mt-4">{{ $discussions->links() }}</div>
                @endif
            </div>

            {{-- Discussion Details --}}
            <div class="lg:col-span-2 flex flex-col">
                @if($selectedDiscussion)
                    <div class="bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 shadow-xl animate-fade-in">
                        {{-- Discussion Header --}}
                        <div class="border-b border-slate-200 dark:border-slate-700 pb-6 mb-6">
                            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white break-all mb-3" style="font-family: 'Questv1', sans-serif;">{{ $selectedDiscussion->title }}</h2>
                            <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500 dark:text-slate-400 mb-4">
                                <span class="flex items-center gap-1 px-3 py-1 bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 rounded-full font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $selectedDiscussion->student->user->name }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $selectedDiscussion->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap break-all leading-relaxed bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl">{{ $selectedDiscussion->content }}</p>
                            @if ($selectedDiscussion->image_path)
                                <div class="mt-4">
                                    <a href="{{ Storage::url($selectedDiscussion->image_path) }}" target="_blank">
                                        <img src="{{ Storage::url($selectedDiscussion->image_path) }}" alt="صورة مرفقة" class="rounded-xl max-w-md h-auto cursor-pointer hover:opacity-90 transition shadow-lg border-2 border-slate-200 dark:border-slate-700">
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Replies List --}}
                        <div class="space-y-4 mb-6">
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                                <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                الردود ({{ $selectedDiscussion->replies->count() }})
                            </h3>
                            
                            @forelse ($selectedDiscussion->replies as $reply)
                                <div class="flex items-start gap-4 p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm {{ $reply->user->role == 'doctor' ? 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300' : 'bg-sky-100 text-sky-700 dark:bg-sky-900/50 dark:text-sky-300' }}">
                                            {{ $reply->user->initials() }}
                                        </div>
                                    </div>
                                    <div class="flex-grow min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 mb-2">
                                            <span class="font-bold text-slate-800 dark:text-slate-100">{{ $reply->user->name }}</span>
                                            <span class="text-xs text-slate-500 dark:text-slate-400">{{ $reply->created_at->diffForHumans() }}</span>
                                            @if ($reply->user->role == 'doctor')
                                                <span class="px-2 py-0.5 text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 rounded-full">أنت</span>
                                            @endif
                                        </div>
                                        <p class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap break-all leading-relaxed">{{ $reply->content }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center p-8 bg-slate-50 dark:bg-slate-800/50 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-700">
                                    <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <p class="text-slate-500 dark:text-slate-400 font-medium">لا توجد ردود بعد. كن أول من يرد!</p>
                                </div>
                            @endforelse
                        </div>

                        {{-- Reply Form --}}
                        <div class="pt-6 border-t border-slate-200 dark:border-slate-700">
                            <h3 class="font-bold text-lg mb-3 text-zinc-900 dark:text-white flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                                <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                أضف ردك
                            </h3>
                            <form wire:submit.prevent="saveNewReply">
                                <textarea wire:model.lazy="newReplyContent" rows="4" class="w-full p-4 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-violet-500 transition-all" placeholder="اكتب ردك هنا..."></textarea>
                                @error('newReplyContent') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                <div class="flex justify-end mt-4">
                                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white rounded-xl font-bold flex items-center justify-center gap-2 transition-all shadow-lg shadow-violet-500/30">
                                        <span wire:loading.remove wire:target="saveNewReply">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                            </svg>
                                            إرسال الرد
                                        </span>
                                        <span wire:loading wire:target="saveNewReply">جاري الإرسال...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex-grow flex items-center justify-center bg-white/50 dark:bg-zinc-800/50 p-12 rounded-2xl border-2 border-dashed border-slate-300 dark:border-slate-700 backdrop-blur-sm">
                        <div class="text-center">
                            <div class="w-20 h-20 mx-auto bg-violet-100 dark:bg-violet-900/30 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-zinc-800 dark:text-white mb-2">مرحباً بك في ساحة النقاش</h2>
                            <p class="text-slate-500 dark:text-slate-400">اختر نقاشًا من القائمة لعرضه والرد عليه</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Toggle Switch Styles */
        input:checked ~ .dot {
            transform: translateX(1.5rem);
            background-color: #10b981;
        }
        input:checked ~ .block {
            background-color: #059669;
        }
        
        /* Fade In Animation */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
    
    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
