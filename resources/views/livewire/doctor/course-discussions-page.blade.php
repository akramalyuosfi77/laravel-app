<div>
    <div class="bg-slate-50 dark:bg-slate-900 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- 1. الهيدر الرئيسي والتعليمات --}}
            <div class="relative bg-gradient-to-br from-purple-500 to-indigo-600 p-6 md:p-8 rounded-2xl shadow-lg mb-8 overflow-hidden">
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-8 -left-2 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="relative z-10">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-bold text-white">إدارة ساحة المناقشات</h1>
                            <p class="text-indigo-200 font-semibold mt-1">المادة: {{ $course->name }}</p>
                        </div>
                        {{-- زر التحكم في ردود الطلاب --}}
                        <div class="mt-4 sm:mt-0">
                            <label for="toggle-replies" class="flex items-center cursor-pointer">
                                <span class="me-3 text-white font-semibold">السماح للطلاب بالرد:</span>
                                <div class="relative">
                                    <input type="checkbox" id="toggle-replies" class="sr-only" wire:click="toggleStudentReplies" {{ $course->student_replies_enabled ? 'checked' : '' }}>
                                    <div class="block bg-white/30 w-14 h-8 rounded-full"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. حاوية التصميم الرئيسية (قسمين) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- القسم الأيمن: قائمة المناقشات والبحث --}}
                <div class="lg:col-span-1 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-md h-fit">
                    <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-4">النقاشات</h2>
                    <div class="mb-4">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="ابحث في النقاشات..." class="w-full p-3 pr-10 border border-slate-300 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-purple-500 transition">
                    </div>
                    <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-2">
                        @forelse ($discussions as $discussion)
                            <div wire:click="selectDiscussion({{ $discussion->id }})"
                                 class="p-4 rounded-lg cursor-pointer transition duration-200 ease-in-out
                                        {{ $selectedDiscussionId == $discussion->id ? 'bg-purple-100 dark:bg-purple-900/50 border-r-4 border-purple-500' : 'bg-slate-50 dark:bg-slate-700/50 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                                <p class="font-bold text-slate-900 dark:text-slate-100 truncate">{{ $discussion->title }}</p>
                                <div class="flex justify-between items-center text-sm text-slate-500 dark:text-slate-400 mt-1">
                                    <span>بواسطة: {{ $discussion->student->user->name }}</span>
                                    <span><i class="bi bi-chat-left-text-fill me-1"></i> {{ $discussion->replies_count }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-slate-500 dark:text-slate-400 p-4">لا توجد نقاشات في هذه المادة بعد.</p>
                        @endforelse
                    </div>
                    <div class="mt-4">{{ $discussions->links() }}</div>
                </div>

                  {{-- القسم الأيسر: عرض تفاصيل النقاش --}}
                <div class="lg:col-span-2 flex flex-col">
                    @if($selectedDiscussion)
                        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-md animate-fade-in">
                            {{-- رأس النقاش --}}
                            <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-4">
                                {{-- 💡 تم استخدام break-all هنا --}}
                                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 break-all">{{ $selectedDiscussion->title }}</h2>
                                <div class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                                    <span>طُرح بواسطة: <strong>{{ $selectedDiscussion->student->user->name }}</strong></span>
                                    <span class="mx-2">|</span>
                                    <span>{{ $selectedDiscussion->created_at->diffForHumans() }}</span>
                                </div>
                                {{-- 💡 تم استخدام break-all هنا --}}
                                <p class="mt-4 text-slate-700 dark:text-slate-300 whitespace-pre-wrap break-all">{{ $selectedDiscussion->content }}</p>
                                @if ($selectedDiscussion->image_path)
                                    <div class="mt-4">
                                        <a href="{{ Storage::url($selectedDiscussion->image_path) }}" target="_blank">
                                            <img src="{{ Storage::url($selectedDiscussion->image_path) }}" alt="صورة مرفقة بالنقاش" class="rounded-lg max-w-md h-auto cursor-pointer hover:opacity-90 transition">
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- قائمة الردود --}}
                            <div class="space-y-6">
                                @forelse ($selectedDiscussion->replies as $reply)
                                    <div class="flex items-start space-x-4 rtl:space-x-reverse">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold
                                                {{ $reply->user->role == 'doctor' ? 'bg-green-200 text-green-700 dark:bg-green-900/50 dark:text-green-300' : 'bg-sky-200 text-sky-700 dark:bg-sky-900/50 dark:text-sky-300' }}">
                                                {{ $reply->user->initials() }}
                                            </div>
                                        </div>
                                        <div class="flex-grow min-w-0"> {{-- 💡 إضافة min-w-0 مهمة جداً مع flexbox --}}
                                            <div class="flex items-baseline space-x-2 rtl:space-x-reverse">
                                                <span class="font-bold text-slate-800 dark:text-slate-100">{{ $reply->user->name }}</span>
                                                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                @if ($reply->user->role == 'doctor')
                                                    <span class="px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 rounded-full">أنت</span>
                                                @endif
                                            </div>
                                            {{-- 💡 تم استخدام break-all هنا --}}
                                            <p class="mt-1 text-slate-700 dark:text-slate-300 whitespace-pre-wrap break-all">{{ $reply->content }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-slate-500 dark:text-slate-400 py-4">لا توجد ردود بعد. كن أول من يرد!</p>
                                @endforelse
                            </div>

                            {{-- فورم إضافة رد جديد --}}
                            <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                                <h3 class="font-bold text-lg mb-2 text-slate-800 dark:text-slate-100">أضف ردك</h3>
                                <form wire:submit.prevent="saveNewReply">
                                    <textarea wire:model.lazy="newReplyContent" rows="4" class="w-full p-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-purple-500 transition-all" placeholder="اكتب ردك هنا..."></textarea>
                                    @error('newReplyContent') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    <div class="flex justify-end mt-4">
                                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-indigo-500/20">
                                            <div wire:loading.remove wire:target="saveNewReply">
                                                <i class="bi bi-send-fill me-1"></i> إرسال الرد
                                            </div>
                                            <div wire:loading wire:target="saveNewReply">
                                                جاري الإرسال...
                                            </div>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex-grow flex items-center justify-center h-full bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-md">
                            <div class="text-center text-slate-500 dark:text-slate-400">
                                <svg class="mx-auto h-16 w-16 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" /></svg>
                                <h2 class="mt-4 text-2xl font-bold text-slate-800 dark:text-slate-200">مرحباً بك في ساحة النقاش</h2>
                                <p class="mt-1 text-slate-500 dark:text-slate-400">اختر نقاشًا من القائمة لعرضه والرد عليه.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* كود CSS الخاص بزر التبديل (Toggle Switch ) */
        input:checked ~ .dot {
            transform: translateX(1.5rem); /* 24px */
            background-color: #34d399; /* emerald-400 */
        }
        input:checked ~ .block {
            background-color: #059669; /* emerald-600 */
        }
    </style>
</div>
