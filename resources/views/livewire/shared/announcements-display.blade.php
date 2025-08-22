<!-- //E:\laravel_almansa\example-wael\resources\views\livewire\shared\announcements-display.blade.php -->
<div class="bg-white dark:bg-slate-800 shadow-lg rounded-2xl p-6">
    <div class="flex items-center mb-5 pb-4 border-b border-slate-200 dark:border-slate-700">
        <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-yellow-400 to-amber-500 text-white flex-shrink-0">
            <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
        </div>
        <div class="mr-4">
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">آخر الإعلانات</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">تابع آخر المستجدات والأخبار الهامة.</p>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($this->announcements as $announcement )
            @php
                $theme = match($announcement->level) {
                    'danger' => ['icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z', 'color' => 'red', 'bg' => 'bg-red-50 dark:bg-red-900/30', 'border' => 'border-red-500', 'icon_color' => 'text-red-500'],
                    'warning' => ['icon' => 'M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z', 'color' => 'amber', 'bg' => 'bg-amber-50 dark:bg-amber-900/30', 'border' => 'border-amber-500', 'icon_color' => 'text-amber-500'],
                    'success' => ['icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'green', 'bg' => 'bg-green-50 dark:bg-green-900/30', 'border' => 'border-green-500', 'icon_color' => 'text-green-500'],
                    default => ['icon' => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z', 'color' => 'blue', 'bg' => 'bg-blue-50 dark:bg-blue-900/30', 'border' => 'border-blue-500', 'icon_color' => 'text-blue-500'],
                };
            @endphp
            <div class="border-r-4 p-4 rounded-lg shadow-sm {{ $theme['bg'] }} {{ $theme['border'] }}">
                <div class="flex justify-between items-start gap-3">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 {{ $theme['icon_color'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $theme['icon'] }}" /></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-900 dark:text-white">{{ $announcement->title }}</h3>
                            <p class="text-slate-700 dark:text-slate-300 mt-1">
                                {{ $announcement->content }}
                            </p>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-3">
                                <span>الناشر: {{ $announcement->user->name ?? 'غير معروف' }}</span>
                                @if($announcement->expires_at )
                                    <span class="mx-2">|</span>
                                    <span>ينتهي في: {{ $announcement->expires_at->format('Y-m-d') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">{{ $announcement->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <div class="text-center text-slate-500 dark:text-slate-400 py-8">
                <svg class="mx-auto h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p class="mt-2">لا توجد إعلانات جديدة لعرضها.</p>
            </div>
        @endforelse
    </div>
</div>
