<div>
    {{-- 1. Combined Hero & Filters Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-purple-50 to-pink-50 dark:from-zinc-900 dark:via-slate-900 dark:to-zinc-900 border border-slate-200 dark:border-slate-800 shadow-xl" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
        {{-- Animated Background Orbs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-10 right-10 w-72 h-72 bg-purple-400/20 dark:bg-purple-600/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-pink-400/20 dark:bg-pink-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        {{-- Top Part: Hero Content --}}
        <div class="relative z-10 p-8 pb-10">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                {{-- Left Side: Animation --}}
                <div class="order-1 md:order-1 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                        <lottie-player
                            src="/animations/Welcome.json"
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
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 dark:bg-purple-900/30 border border-purple-200 dark:border-purple-800 rounded-full mb-4">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                        </span>
                        <span class="text-sm font-bold text-purple-700 dark:text-purple-300">ساحات النقاش والتفاعل</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-purple-700 to-pink-700 dark:from-slate-100 dark:via-purple-300 dark:to-pink-300 mb-4 leading-tight">
                        إدارة المناقشات
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-300 mb-8 leading-relaxed">
                        مراقبة وإدارة الحوارات الأكاديمية، وتعزيز التفاعل البناء بين الطلاب وأعضاء هيئة التدريس.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <div class="group relative flex-1 min-w-[200px]">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition"></div>
                            <div class="relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input wire:model.live.debounce.300ms="search" placeholder="بحث في المناقشات..." class="bg-transparent border-0 focus:ring-0 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 w-full">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Part: Filters (Merged) --}}
        <div class="relative z-10 bg-white/40 dark:bg-black/20 backdrop-blur-md border-t border-white/20 dark:border-white/5 p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="p-1.5 bg-purple-100 dark:bg-purple-900/50 rounded-lg text-purple-600 dark:text-purple-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">تصفية متقدمة</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Course Filter -->
                <div>
                    <select wire:model.live="filter_course_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع المواد</option>
                        @foreach($this->courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Student Filter -->
                <div>
                    <select wire:model.live="filter_student_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع الطلاب</option>
                        @foreach($this->students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Doctor Filter -->
                <div>
                    <select wire:model.live="filter_doctor_id" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع الدكاترة</option>
                        @foreach($this->doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Discussions Grid --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            @php
                $colorThemes = [
                    ['gradient' => 'from-purple-500 to-pink-500', 'border' => 'border-purple-500', 'text' => 'text-purple-500', 'overlay' => 'bg-gradient-to-br from-purple-500/70 to-pink-500/70'],
                    ['gradient' => 'from-blue-500 to-cyan-500', 'border' => 'border-blue-500', 'text' => 'text-blue-500', 'overlay' => 'bg-gradient-to-br from-blue-500/70 to-cyan-500/70'],
                    ['gradient' => 'from-emerald-500 to-teal-500', 'border' => 'border-emerald-500', 'text' => 'text-emerald-500', 'overlay' => 'bg-gradient-to-br from-emerald-500/70 to-teal-500/70'],
                    ['gradient' => 'from-amber-500 to-orange-500', 'border' => 'border-amber-500', 'text' => 'text-amber-500', 'overlay' => 'bg-gradient-to-br from-amber-500/70 to-orange-500/70'],
                    ['gradient' => 'from-rose-500 to-red-500', 'border' => 'border-rose-500', 'text' => 'text-rose-500', 'overlay' => 'bg-gradient-to-br from-rose-500/70 to-red-500/70'],
                    ['gradient' => 'from-violet-500 to-indigo-500', 'border' => 'border-violet-500', 'text' => 'text-violet-500', 'overlay' => 'bg-gradient-to-br from-violet-500/70 to-indigo-500/70'],
                ];
            @endphp

            @forelse($discussions as $discussion)
                @php
                    $theme = $colorThemes[$loop->index % count($colorThemes)];
                @endphp

                <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-purple-500/10 dark:hover:shadow-purple-900/30 hover:-translate-y-2 overflow-hidden">
                    {{-- Subtle Gradient Background --}}
                    <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-300 rounded-2xl"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        {{-- Header --}}
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-14 h-14 flex-shrink-0 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border {{ $theme['border'] }} shadow-sm group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 {{ $theme['text'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold {{ $theme['text'] }} mb-1">مناقشة</p>
                                <h3 class="font-bold text-base md:text-lg text-zinc-900 dark:text-white leading-tight line-clamp-2 break-all">{{ $discussion->title }}</h3>
                            </div>
                        </div>

                        {{-- Content Preview --}}
                        <div class="mb-4 flex-grow">
                            <p class="text-sm text-slate-600 dark:text-slate-300 line-clamp-3 leading-relaxed break-words">
                                {{ Str::limit($discussion->content, 80) }}
                            </p>
                        </div>

                        {{-- Details --}}
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-500 dark:text-slate-400">الطالب</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium truncate max-w-[120px]">{{ $discussion->student->user->name ?? 'غير معروف' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-500 dark:text-slate-400">المادة</span>
                                <span class="text-slate-700 dark:text-slate-300 font-medium truncate max-w-[120px]">{{ $discussion->course->name ?? 'غير محدد' }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between pt-2">
                                <div class="flex items-center gap-1">
                                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">الردود:</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                                        {{ $discussion->replies_count }}
                                    </span>
                                </div>
                                @if($discussion->image_path)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium text-green-600 bg-green-100 dark:bg-green-900/30">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        مرفق
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="pt-3 border-t border-slate-200 dark:border-slate-700/50 flex justify-between items-center">
                            <span class="text-[10px] text-slate-400 dark:text-slate-500">{{ $discussion->created_at->format('Y/m/d') }}</span>
                            
                            <div class="flex gap-2">
                                <button wire:click="viewDiscussion({{ $discussion->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-purple-500 hover:text-white transition-colors" title="عرض التفاصيل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button wire:click="confirmDeleteDiscussion({{ $discussion->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-red-500 hover:text-white transition-colors" title="حذف">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-slate-50 to-purple-50 dark:from-zinc-800/50 dark:to-zinc-900/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700/50 backdrop-blur-sm">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mb-6 shadow-2xl shadow-purple-500/30">
                        <svg class="w-14 h-14 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-zinc-800 dark:text-white mb-2">لا توجد مناقشات</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-6 max-w-md mx-auto">لا توجد بيانات تطابق معايير البحث الحالية.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($discussions->hasPages())
    <div class="mt-8">
        {{ $discussions->links() }}
    </div>
    @endif

    {{-- View Modal --}}
    @if($viewedDiscussion)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.set('viewing_discussion_id', null)" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-purple-500 to-pink-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg shadow-purple-500/20">
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white break-all overflow-hidden">{{ $viewedDiscussion->title }}</h2>
                </div>
                <button wire:click="$set('viewing_discussion_id', null)" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-grow p-6 space-y-6 overflow-y-auto">
                {{-- Discussion Content --}}
                <div class="bg-zinc-50 dark:bg-zinc-700/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-600">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0 shadow-md">
                            {{ substr($viewedDiscussion->student->user->name, 0, 1) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-bold text-zinc-900 dark:text-white break-words">{{ $viewedDiscussion->student->user->name }}</h4>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $viewedDiscussion->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <p class="text-zinc-700 dark:text-zinc-300 leading-relaxed whitespace-pre-wrap break-words">{{ $viewedDiscussion->content }}</p>
                    @if ($viewedDiscussion->image_path)
                        <div class="mt-4">
                            <a href="{{ Storage::url($viewedDiscussion->image_path) }}" target="_blank" class="block overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-600 hover:opacity-90 transition-opacity">
                                <img src="{{ Storage::url($viewedDiscussion->image_path) }}" alt="صورة مرفقة" class="max-w-full h-auto">
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Replies --}}
                <div>
                    <h4 class="text-lg font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        الردود ({{ $viewedDiscussion->replies->count() }})
                    </h4>
                    <div class="space-y-4">
                        @forelse ($viewedDiscussion->replies as $reply)
                            <div class="bg-white dark:bg-zinc-800 p-5 rounded-2xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-sm
                                            {{ $reply->user->role == 'doctor' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' :
                                               ($reply->user->role == 'student' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' :
                                               'bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300') }}">
                                            {{ substr($reply->user->name, 0, 1) }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <span class="font-bold text-zinc-900 dark:text-white break-words">{{ $reply->user->name }}</span>
                                            <span class="text-xs text-zinc-500 dark:text-zinc-400 ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <button wire:click="confirmDeleteReply({{ $reply->id }})" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm transition-colors flex-shrink-0 p-1 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                                <p class="mt-3 text-zinc-700 dark:text-zinc-300 whitespace-pre-wrap break-words leading-relaxed">{{ $reply->content }}</p>
                            </div>
                        @empty
                            <div class="text-center py-8 bg-zinc-50 dark:bg-zinc-700/30 rounded-2xl border border-dashed border-zinc-300 dark:border-zinc-700">
                                <div class="w-12 h-12 mx-auto bg-zinc-100 dark:bg-zinc-700 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <p class="text-zinc-500 dark:text-zinc-400">لا توجد ردود على هذا النقاش بعد.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="flex-shrink-0 p-4 flex justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button wire:click="$set('viewing_discussion_id', null)" class="px-6 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-medium transition-colors shadow-sm">إغلاق</button>
            </div>
        </div>
    </div>
    @endif

    {{-- Delete Confirmation Modals --}}
    <x-confirm-delete-modal action="deleteDiscussion" state="discussion_to_delete_id" title="حذف النقاش" message="هل أنت متأكد من رغبتك في حذف هذا النقاش بالكامل؟ سيتم حذف جميع الردود المرتبطة به بشكل دائم." />
    <x-confirm-delete-modal action="deleteReply" state="reply_to_delete_id" title="حذف الرد" message="هل أنت متأكد من رغبتك في حذف هذا الرد؟ لا يمكن التراجع عن هذا الإجراء." />

    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
