<div>
    {{-- 1. الهيدر والفلاتر --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">صندوق الرسائل</h1>
            <p class="mt-1 text-zinc-500 dark:text-zinc-400">عرض وإدارة رسائل "تواصل معنا".</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        {{-- حقل البحث العام --}}
        <div class="relative">
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" placeholder="ابحث بالاسم, البريد, المحتوى..." class="w-full pr-11 pl-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
        </div>
        {{-- فلتر الموضوع --}}
        <select wire:model.live="filter_subject" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
            <option value="">فلتر حسب الموضوع</option>
            <option value="academic">استفسار أكاديمي</option>
            <option value="registration">التسجيل والقبول</option>
            <option value="technical">دعم فني</option>
            <option value="general">استفسار عام</option>
        </select>
    </div>

    {{-- 2. شبكة بطاقات الرسائل --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @php
                $colorThemes = [
                    'academic' => ['gradient' => 'from-indigo-500 to-purple-500', 'border' => 'border-indigo-500', 'text' => 'text-indigo-500', 'overlay' => 'bg-gradient-to-br from-indigo-500/70 to-purple-500/70'],
                    'registration' => ['gradient' => 'from-teal-500 to-emerald-500', 'border' => 'border-teal-500', 'text' => 'text-teal-500', 'overlay' => 'bg-gradient-to-br from-teal-500/70 to-emerald-500/70'],
                    'technical' => ['gradient' => 'from-amber-500 to-orange-500', 'border' => 'border-amber-500', 'text' => 'text-amber-500', 'overlay' => 'bg-gradient-to-br from-amber-500/70 to-orange-500/70'],
                    'general' => ['gradient' => 'from-rose-500 to-pink-500', 'border' => 'border-rose-500', 'text' => 'text-rose-500', 'overlay' => 'bg-gradient-to-br from-rose-500/70 to-pink-500/70'],
                ];
            @endphp

            @forelse($messages as $message)
                @php
                    $theme = $colorThemes[$message->subject] ?? $colorThemes['general'];
                @endphp

                <div class="group relative bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1.5 flex flex-col">
                    <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-5 dark:opacity-10 rounded-2xl -z-10"></div>

                    <div class="flex-grow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 flex-shrink-0 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border {{ $theme['border'] }}">
                                <svg class="w-7 h-7 {{ $theme['text'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold {{ $theme['text'] }} mb-1">{{ __($message->subject ) }}</p>
                                <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight">{{ $message->name }}</h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $message->email }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-300 mt-4 h-16 overflow-hidden text-ellipsis">
                            {{ $message->message }}
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                        تاريخ الإرسال: {{ $message->created_at->format('Y-m-d H:i') }}
                    </div>

                    <div class="absolute inset-0 {{ $theme['overlay'] }} dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button wire:click="viewMessage({{ $message->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </button>
                        <button wire:click="confirmDelete({{ $message->id }} )" class="w-14 h-14 flex items-center justify-center bg-red-500/30 hover:bg-red-500/40 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 xl:col-span-3 p-12 text-center bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-indigo-300 dark:border-zinc-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">صندوق الوارد فارغ</h3>
                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">لا توجد أي رسائل جديدة لعرضها في الوقت الحالي.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($messages->hasPages( ))
    <div class="mt-8">
        {{ $messages->links() }}
    </div>
    @endif

    {{-- View Message Modal --}}
   @if($viewedMessage)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('closeViewModal')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تفاصيل الرسالة</h2>
                <button wire:click="closeViewModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-grow p-6 space-y-4 overflow-y-auto">
                <div class="flex justify-between items-center text-sm pb-4 border-b dark:border-zinc-700">
                    <div>
                        <p class="font-semibold text-zinc-500 dark:text-zinc-400">من:</p>
                        <p class="text-zinc-800 dark:text-zinc-200">{{ $viewedMessage->name }} &lt;{{ $viewedMessage->email }}&gt;</p>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-zinc-500 dark:text-zinc-400">التاريخ:</p>
                        <p class="text-zinc-800 dark:text-zinc-200">{{ $viewedMessage->created_at->format('Y-m-d H:i A') }}</p>
                    </div>
                </div>
                <div>
                    <p class="font-semibold text-zinc-500 dark:text-zinc-400 text-sm">الموضوع:</p>
                    <p class="text-zinc-800 dark:text-zinc-200 font-bold">{{ __($viewedMessage->subject) }}</p>
                </div>
                <div>
                    {{-- This is the added label --}}
                    <p class="font-semibold text-zinc-500 dark:text-zinc-400 text-sm">نص الرسالة:</p>
                    <p class="whitespace-pre-wrap text-zinc-700 dark:text-zinc-300 bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-lg mt-2">{{ $viewedMessage->message }}</p>
                </div>
            </div>

            <div class="flex-shrink-0 p-4 flex justify-end bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeViewModal" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إغلاق</button>
            </div>
        </div>
    </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if($delete_id)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.set('delete_id', null)" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                </div>
                <h3 class="mt-5 text-lg font-bold text-zinc-900 dark:text-white">تأكيد عملية الحذف</h3>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">هل أنت متأكد من حذف هذه الرسالة؟ لا يمكن التراجع عن هذا الإجراء.</p>
            </div>
            <div class="p-4 flex flex-col-reverse sm:flex-row gap-3 bg-zinc-50 dark:bg-zinc-800/50">
                <button wire:click="$set('delete_id', null)" class="w-full sm:w-1/2 px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button wire:click="delete" class="w-full sm:w-1/2 px-4 py-2.5 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-red-500/20">
                    <span wire:loading.remove wire:target="delete">نعم، قم بالحذف</span>
                    <span wire:loading wire:target="delete">جاري الحذف...</span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
