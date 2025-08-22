<div>
    <div class="bg-slate-50 dark:bg-slate-900 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- 1. الهيدر الرئيسي للصفحة --}}
            <div class="relative bg-gradient-to-br from-sky-500 to-indigo-600 p-6 md:p-8 rounded-2xl shadow-lg mb-8 overflow-hidden">
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-8 -left-2 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="relative z-10">
                    <p class="text-indigo-200 font-semibold">مادة: {{ $course->name }}</p>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white mt-1">ساحة المناقشات</h1>
                </div>
            </div>

            {{-- 2. حاوية التصميم الرئيسية (قسمين) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- القسم الأيمن: قائمة المناقشات والبحث --}}
                <div class="lg:col-span-1 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-md h-fit">
                    <div class="flex justify-between items-center mb-4 pb-4 border-b border-slate-200 dark:border-slate-700">
                        <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">النقاشات</h2>
                        <button wire:click="openNewDiscussionForm" class="text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 font-semibold transition flex items-center gap-1">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" /></svg>
                            <span>سؤال جديد</span>
                        </button>
                    </div>

                    {{-- حقل البحث --}}
                    <div class="relative mb-4">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="ابحث في النقاشات..." class="w-full p-2.5 pr-10 border border-slate-300 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-sky-500 transition">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                        </div>
                    </div>

                    {{-- قائمة المناقشات --}}
                    <div class="space-y-2 max-h-[60vh] overflow-y-auto pr-1">
                        @forelse ($discussions as $discussion )
                            <div wire:click="selectDiscussion({{ $discussion->id }})"
                                 class="p-3 rounded-lg cursor-pointer transition-all duration-200 ease-in-out border-r-4
                                        {{ $selectedDiscussionId == $discussion->id
                                            ? 'bg-sky-100 dark:bg-sky-900/50 border-sky-500 dark:border-sky-400 shadow-sm'
                                            : 'bg-transparent border-transparent hover:bg-slate-100 dark:hover:bg-slate-700/50' }}">
                                <p class="font-bold text-slate-800 dark:text-slate-100 truncate">{{ $discussion->title }}</p>
                                <div class="flex justify-between items-center text-sm text-slate-500 dark:text-slate-400 mt-1">
                                    <span>بواسطة: {{ $discussion->student->user->name }}</span>
                                    <span class="flex items-center gap-1"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2 5.25A3.25 3.25 0 015.25 2h9.5A3.25 3.25 0 0118 5.25v7.5A3.25 3.25 0 0114.75 16h-6.165c.13-.18.252-.366.368-.556l.42-1.103a.75.75 0 00-.34-.93l-2.43-1.158a.75.75 0 01-.34-.93l.42-1.104a2.25 2.25 0 00-.42-2.356l-.255-.34a.75.75 0 00-1.06 1.06l.255.34a.75.75 0 01.14.786l-.42 1.103a2.25 2.25 0 001.02 2.79l2.43 1.158a2.25 2.25 0 011.02 2.79l-.42 1.104A3.75 3.75 0 015.25 16H3a1 1 0 01-1-1v-2.25a.75.75 0 011.5 0v1.5h.25a2.25 2.25 0 002.25-2.25v-7.5A1.75 1.75 0 003.75 3.5h-1.5A1.75 1.75 0 00.5 5.25v1.5a.75.75 0 01-1.5 0v-1.5z" clip-rule="evenodd" /></svg> {{ $discussion->replies_count }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-slate-500 dark:text-slate-400 p-4">لا توجد نقاشات حتى الآن. كن أول من يطرح سؤالاً!</p>
                        @endforelse
                    </div>

                    <div class="mt-4">{{ $discussions->links( ) }}</div>
                </div>

                {{-- القسم الأيسر: عرض تفاصيل النقاش أو فورم إضافة جديد --}}
                <div class="lg:col-span-2">
                    @if($showNewDiscussionForm)
                        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-md">
                            <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mb-5">طرح سؤال جديد</h2>
                            <form wire:submit.prevent="saveNewDiscussion" class="space-y-5">
                                <div>
                                    <label for="new-title" class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">العنوان</label>
                                    <input type="text" id="new-title" wire:model.lazy="newDiscussionTitle" class="w-full p-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-sky-500 transition">
                                    @error('newDiscussionTitle') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="new-content" class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">اشرح سؤالك بالتفصيل</label>
                                    <textarea id="new-content" wire:model.lazy="newDiscussionContent" rows="8" class="w-full p-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-sky-500 transition"></textarea>
                                    @error('newDiscussionContent') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="new-image" class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">إرفاق صورة (اختياري)</label>
                                    <input type="file" id="new-image" wire:model="newDiscussionImage" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 dark:file:bg-slate-700 file:text-sky-700 dark:file:text-sky-300 hover:file:bg-sky-100 dark:hover:file:bg-slate-600">
                                    @error('newDiscussionImage') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    @if ($newDiscussionImage)
                                        <div class="mt-4"><img src="{{ $newDiscussionImage->temporaryUrl() }}" class="rounded-lg max-h-48 border-2 border-slate-200 dark:border-slate-600"></div>
                                    @endif
                                </div>
                                <div class="flex justify-end mt-6 gap-3">
                                    <button type="button" wire:click="$set('showNewDiscussionForm', false)" class="px-6 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 font-semibold transition">إلغاء</button>
                                    <button type="submit" class="px-6 py-2.5 bg-sky-600 text-white rounded-lg hover:bg-sky-700 font-semibold transition flex items-center justify-center gap-2">
                                        <div wire:loading.remove wire:target="saveNewDiscussion">نشر السؤال</div>
                                        <div wire:loading wire:target="saveNewDiscussion">جاري النشر...</div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @elseif($selectedDiscussion)
                        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-md">
                            <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 break-all">{{ $selectedDiscussion->title }}</h2>
                                <div class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                                    <span>طُرح بواسطة <strong>{{ $selectedDiscussion->student->user->name }}</strong></span>
                                    <span class="mx-2">&middot;</span>
                                    <span>{{ $selectedDiscussion->created_at->diffForHumans() }}</span>
                                    {{-- ✅ الكود الجديد لعرض الصورة المرفقة --}}
                                    @if ($selectedDiscussion->image_path)
                                        <div class="mt-4">
                                            <a href="{{ Storage::url($selectedDiscussion->image_path) }}" target="_blank" title="اضغط لعرض الصورة بالحجم الكامل">
                                                <img src="{{ Storage::url($selectedDiscussion->image_path) }}" alt="صورة مرفقة" class="rounded-lg max-w-md h-auto cursor-pointer hover:opacity-90 transition border-2 border-slate-200 dark:border-slate-600">
                                            </a>
                                        </div>
                                    @endif

                                </div>
                                {{-- التعديل هنا --}}
                                <p class="mt-4 text-slate-700 dark:text-slate-300 whitespace-pre-wrap leading-relaxed break-all">{{ $selectedDiscussion->content }}</p>
                                @if ($selectedDiscussion->image_path)
                                    <div class="mt-4">
                                        <a href="{{ Storage::url($selectedDiscussion->image_path) }}" target="_blank">
                                            <img src="{{ Storage::url($selectedDiscussion->image_path) }}" alt="صورة مرفقة" class="rounded-lg max-w-md h-auto cursor-pointer hover:opacity-90 transition border-2 border-slate-200 dark:border-slate-600">
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-6">
                                @forelse ($selectedDiscussion->replies as $reply)
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 flex items-center justify-center font-bold flex-shrink-0">
                                            {{ $reply->user->initials() }}
                                        </div>
                                        <div class="flex-grow bg-slate-100 dark:bg-slate-900/50 p-4 rounded-lg">
                                            <div class="flex items-baseline gap-2">
                                                <span class="font-bold text-slate-800 dark:text-slate-100">{{ $reply->user->name }}</span>
                                                @if ($reply->user->role == 'doctor')
                                                    <span class="px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 rounded-full">الدكتور</span>
                                                @endif
                                                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            {{-- التعديل هنا --}}
                                            <p class="mt-1 text-slate-700 dark:text-slate-300 whitespace-pre-wrap break-all">{{ $reply->content }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-slate-500 dark:text-slate-400 py-4">لا توجد ردود بعد. كن أول من يرد!</p>
                                @endforelse
                            </div>

                            @if($course->student_replies_enabled || Auth::user()->role == 'doctor')
                                <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                                    <form wire:submit.prevent="saveNewReply" class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 flex items-center justify-center font-bold flex-shrink-0">
                                            {{ Auth::user()->initials() }}
                                        </div>
                                        <div class="flex-grow">
                                            <textarea wire:model.lazy="newReplyContent" rows="3" class="w-full p-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-200 focus:ring-2 focus:ring-sky-500 transition" placeholder="اكتب ردك هنا..."></textarea>
                                            @error('newReplyContent') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                            <div class="flex justify-end mt-2">
                                                <button type="submit" class="px-5 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 font-semibold transition flex items-center justify-center gap-2">
                                                    <div wire:loading.remove wire:target="saveNewReply">إرسال الرد</div>
                                                    <div wire:loading wire:target="saveNewReply">جاري الإرسال...</div>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="mt-6 pt-4 text-center text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700/50 p-4 rounded-lg">
                                    تم إيقاف الردود من قبل الدكتور لهذه المادة.
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="flex items-center justify-center h-full bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-md">
                            <div class="text-center text-slate-500 dark:text-slate-400">
                                <svg class="mx-auto h-12 w-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" /></svg>
                                <h2 class="mt-4 text-xl font-bold text-slate-700 dark:text-slate-200">مرحبًا بك في ساحة النقاش</h2>
                                <p class="mt-1 text-slate-500 dark:text-slate-400">اختر نقاشًا من القائمة لعرضه، أو اطرح سؤالاً جديداً.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
