<div class="relative" x-data="{ isOpen: false }">
    {{-- 1. أيقونة الجرس والعداد --}}
    <button
        @click="isOpen = !isOpen"
        wire:poll.15s="loadNotifications"
        class="relative text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-white focus:outline-none transition-colors"
    >
        <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>

        @if($unreadNotificationsCount > 0 )
            <span class="absolute top-0 right-0 -mt-1 -mr-1 flex items-center justify-center h-5 w-5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">
                {{ $unreadNotificationsCount }}
            </span>
        @endif
    </button>

    {{-- 2. القائمة المنسدلة (تم التعديل هنا لتكون متجاوبة) --}}
    <div
        x-show="isOpen"
        @click.away="isOpen = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute left-0 lg:left-auto lg:right-0 mt-3 w-80 sm:w-96 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden z-50"
        style="display: none;"
    >
        {{-- رأس القائمة --}}
        <div class="p-4 flex justify-between items-center border-b border-slate-200 dark:border-slate-700">
            <h3 class="font-bold text-slate-800 dark:text-white">الإشعارات</h3>
            @if($unreadNotificationsCount > 0)
                <button wire:click="markAllAsRead" class="text-xs text-sky-600 dark:text-sky-400 hover:underline font-semibold">
                    تمييز الكل كمقروء
                </button>
            @endif
        </div>

        {{-- جسم القائمة --}}
        <div class="divide-y divide-slate-100 dark:divide-slate-700 max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <a
                    href="{{ $notification->data['url'] ?? '#' }}"
                    wire:click.prevent="markAsRead('{{ $notification->id }}')"
                    class="flex items-start p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition duration-150
                           {{ is_null($notification->read_at) ? 'bg-sky-50 dark:bg-sky-900/20' : '' }}"
                >
                    {{-- أيقونة الإشعار --}}
                    <div class="flex-shrink-0 mr-3 rtl:mr-0 rtl:ml-3 mt-1">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-sky-100 dark:bg-sky-900/50 text-sky-500 dark:text-sky-400">
                            <i class="bi {{ $notification->data['icon'] ?? 'bi-bell' }} text-base"></i>
                        </div>
                    </div>
                    {{-- محتوى الإشعار --}}
                    <div class="flex-grow">
                        <p class="text-sm text-slate-700 dark:text-slate-200 leading-relaxed">{{ $notification->data['message'] }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                    {{-- النقطة الزرقاء للإشعارات غير المقروءة --}}
                    @if(is_null($notification->read_at))
                        <div class="flex-shrink-0 ml-2 rtl:ml-0 rtl:mr-2 mt-1">
                            <div class="h-2.5 w-2.5 bg-blue-500 rounded-full"></div>
                        </div>
                    @endif
                </a>
            @empty
                <div class="p-8 text-center text-slate-500 dark:text-slate-400">
                    <svg class="mx-auto h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="mt-2 font-semibold">لا توجد إشعارات جديدة.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>






<!-- شرح بسيط للكود:
x-data="{ isOpen: false }": هذا من AlpineJS، يقوم بإنشاء متغير isOpen للتحكم في القائمة.
@click="isOpen = !isOpen": عند الضغط على الجرس، يتم تبديل قيمة isOpen (فتح/إغلاق).
@click.away="isOpen = false": عند الضغط خارج القائمة، يتم إغلاقها.
wire:poll.15s="loadNotifications": هذا هو سحر Livewire! سيقوم تلقائياً باستدعاء دالة loadNotifications في الخلفية كل 15 ثانية لتحديث عدد الإشعارات.
wire:click.prevent="markAsRead  $notification->id ": عند الضغط على إشعار، يتم استدعاء دالة markAsRead التي برمجناها، والتي ستقوم بتمييز الإشعار كمقروء ثم توجيه المستخدم للرابط الصحيح. -->
