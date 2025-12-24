<div>
    @forelse($this->announcements as $announcement)
        @php
            $theme = match($announcement->level) {
                'danger' => ['gradient' => 'from-red-500 to-rose-500', 'icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z', 'bg' => 'bg-red-50 dark:bg-red-900/20', 'border' => 'border-red-200 dark:border-red-800'],
                'warning' => ['gradient' => 'from-amber-500 to-orange-500', 'icon' => 'M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z', 'bg' => 'bg-amber-50 dark:bg-amber-900/20', 'border' => 'border-amber-200 dark:border-amber-800'],
                'success' => ['gradient' => 'from-emerald-500 to-teal-500', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'bg' => 'bg-emerald-50 dark:bg-emerald-900/20', 'border' => 'border-emerald-200 dark:border-emerald-800'],
                default => ['gradient' => 'from-blue-500 to-indigo-500', 'icon' => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z', 'bg' => 'bg-blue-50 dark:bg-blue-900/20', 'border' => 'border-blue-200 dark:border-blue-800'],
            };
        @endphp
        
        <div class="group relative bg-white dark:bg-zinc-800/50 p-5 rounded-2xl border {{ $theme['border'] }} overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 mb-4">
            {{-- Gradient Background --}}
            <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-0 group-hover:opacity-5 transition-opacity duration-300"></div>
            
            <div class="relative z-10">
                {{-- Header --}}
                <div class="flex items-start gap-4 mb-3">
                    <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center bg-gradient-to-br {{ $theme['gradient'] }} rounded-xl shadow-md group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $theme['icon'] }}" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-base text-zinc-900 dark:text-white leading-tight mb-1 break-words">{{ $announcement->title }}</h4>
                        <p class="text-xs text-zinc-400 dark:text-zinc-500">{{ $announcement->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                
                {{-- Content --}}
                <p class="text-sm text-zinc-600 dark:text-zinc-300 leading-relaxed mb-3 break-words">
                    {{ Str::limit($announcement->content, 120) }}
                </p>
                
                {{-- Footer --}}
                <div class="flex items-center justify-between pt-3 border-t border-zinc-100 dark:border-zinc-700/50">
                    <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>{{ $announcement->user->name ?? 'الإدارة' }}</span>
                    </div>
                    @if($announcement->expires_at)
                        <div class="flex items-center gap-1 text-xs text-zinc-500 dark:text-zinc-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $announcement->expires_at->format('Y/m/d') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-blue-500 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            </div>
            <h4 class="text-base font-bold text-zinc-800 dark:text-white mb-2">لا توجد إعلانات</h4>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">لا توجد إعلانات جديدة لعرضها في الوقت الحالي.</p>
        </div>
    @endforelse
</div>
