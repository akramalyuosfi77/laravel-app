<div>
    {{-- 1. الهيدر المدمج والذكي --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">إدارة ساحات النقاش</h1>
            <p class="mt-1 text-zinc-500 dark:text-zinc-400">مراقبة وإدارة جميع المناقشات في النظام.</p>
        </div>
        <div class="w-full md:w-auto flex items-center gap-2">
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" placeholder="بحث في المناقشات..." class="w-full pr-11 pl-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
        </div>
    </div>

    {{-- 2. فلاتر البحث والتصفية الأنيقة --}}
    <div class="bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 mb-8 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">فلتر حسب المادة</label>
                <select wire:model.live="filter_course_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">جميع المواد</option>
                    @foreach($this->courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">فلتر حسب الطالب</label>
                <select wire:model.live="filter_student_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">جميع الطلاب</option>
                    @foreach($this->students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">فلتر حسب الدكتور</label>
                <select wire:model.live="filter_doctor_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">جميع الدكاترة</option>
                    @foreach($this->doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- 3. شبكة بطاقات المناقشات الفنية بالألوان --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-8">
            @php
                // مصفوفة الألوان لكل بطاقة - بتنظيم أفضل لضمان الموثوقية
                $colorThemes = [
                    [
                        'gradient' => 'from-indigo-500 to-purple-500',
                        'border' => 'border-indigo-500',
                        'text' => 'text-indigo-500',
                        'overlay' => 'bg-gradient-to-br from-indigo-500/70 to-purple-500/70'
                    ],
                    [
                        'gradient' => 'from-teal-500 to-emerald-500',
                        'border' => 'border-teal-500',
                        'text' => 'text-teal-500',
                        'overlay' => 'bg-gradient-to-br from-teal-500/70 to-emerald-500/70'
                    ],
                    [
                        'gradient' => 'from-amber-500 to-orange-500',
                        'border' => 'border-amber-500',
                        'text' => 'text-amber-500',
                        'overlay' => 'bg-gradient-to-br from-amber-500/70 to-orange-500/70'
                    ],
                    [
                        'gradient' => 'from-rose-500 to-pink-500',
                        'border' => 'border-rose-500',
                        'text' => 'text-rose-500',
                        'overlay' => 'bg-gradient-to-br from-rose-500/70 to-pink-500/70'
                    ],
                    [
                        'gradient' => 'from-blue-500 to-cyan-500',
                        'border' => 'border-blue-500',
                        'text' => 'text-blue-500',
                        'overlay' => 'bg-gradient-to-br from-blue-500/70 to-cyan-500/70'
                    ],
                    [
                        'gradient' => 'from-violet-500 to-fuchsia-500',
                        'border' => 'border-violet-500',
                        'text' => 'text-violet-500',
                        'overlay' => 'bg-gradient-to-br from-violet-500/70 to-fuchsia-500/70'
                    ],
                ];
            @endphp

            @forelse($discussions as $discussion)
                @php
                    $theme = $colorThemes[$loop->index % count($colorThemes)];
                @endphp

                <div class="group relative bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1.5 overflow-hidden">
                    <!-- تدرج لوني خلفي -->
                    <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-5 dark:opacity-10 rounded-2xl -z-10"></div>

                    <!-- المحتوى الرئيسي للبطاقة -->
                    <div class="flex flex-col h-full min-h-[320px]">
                        <div class="flex-grow">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-14 h-14 flex-shrink-0 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border {{ $theme['border'] }}">
                                    <svg class="w-8 h-8 {{ $theme['text'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold {{ $theme['text'] }} mb-1">مناقشة</p>
                                    <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight break-words">
                                        {{ Str::limit($discussion->title, 50 ) }}
                                    </h3>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المحتوى</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 break-words overflow-hidden" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        {{ Str::limit($discussion->content, 80) }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الطالب</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 break-words truncate">
                                        {{ Str::limit($discussion->student->user->name, 25) }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المادة</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 break-words truncate">
                                        {{ Str::limit($discussion->course->name, 25) }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الردود</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $theme['text'] }} bg-{{ explode('-', $theme['gradient'])[1] }}-100 dark:bg-{{ explode('-', $theme['gradient'])[1] }}-900/30">
                                            {{ $discussion->replies_count }}
                                        </span>
                                    </div>
                                    @if($discussion->image_path)
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-green-600 bg-green-100 dark:bg-green-900/30">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            صورة
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                            تم الإنشاء: {{ $discussion->created_at->format('Y/m/d') }}
                        </div>
                    </div>

                    <!-- أزرار التحكم التي تظهر عند الـ Hover -->
                    <div class="absolute inset-0 {{ $theme['overlay'] }} dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button wire:click="viewDiscussion({{ $discussion->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                        <button wire:click="confirmDeleteDiscussion({{ $discussion->id }})" class="w-14 h-14 flex items-center justify-center bg-red-500/30 hover:bg-red-500/40 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            @empty
                {{-- حالة عدم وجود بيانات --}}
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-indigo-300 dark:border-zinc-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">لا توجد مناقشات</h3>
                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">لا توجد بيانات تطابق معايير البحث الحالية.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($discussions->hasPages( ))
    <div class="mt-8">
        {{ $discussions->links() }}
    </div>
    @endif

    {{-- نافذة منبثقة لعرض تفاصيل النقاش --}}
    @if($viewedDiscussion)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.set('viewing_discussion_id', null)" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>

            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white break-words overflow-hidden">{{ $viewedDiscussion->title }}</h2>
                </div>
                <button wire:click="$set('viewing_discussion_id', null )" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-grow p-6 space-y-6 overflow-y-auto">
                <!-- محتوى المناقشة الأصلي -->
                <div class="bg-zinc-50 dark:bg-zinc-700/50 p-6 rounded-xl border border-zinc-200 dark:border-zinc-600">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                            {{ substr($viewedDiscussion->student->user->name, 0, 1) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-semibold text-zinc-900 dark:text-white break-words">{{ $viewedDiscussion->student->user->name }}</h4>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $viewedDiscussion->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <p class="text-zinc-700 dark:text-zinc-300 leading-relaxed whitespace-pre-wrap break-words">{{ $viewedDiscussion->content }}</p>
                    @if ($viewedDiscussion->image_path)
                        <div class="mt-4">
                            <a href="{{ Storage::url($viewedDiscussion->image_path) }}" target="_blank">
                                <img src="{{ Storage::url($viewedDiscussion->image_path) }}" alt="صورة مرفقة" class="rounded-lg max-w-full h-auto border border-zinc-200 dark:border-zinc-600">
                            </a>
                        </div>
                    @endif
                </div>

                <!-- الردود -->
                <div>
                    <h4 class="text-lg font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        الردود ({{ $viewedDiscussion->replies->count() }})
                    </h4>
                    <div class="space-y-4">
                        @forelse ($viewedDiscussion->replies as $reply)
                            <div class="bg-white dark:bg-zinc-800 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0
                                            {{ $reply->user->role == 'doctor' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' :
                                               ($reply->user->role == 'student' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' :
                                               'bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300') }}">
                                            {{ substr($reply->user->name, 0, 1) }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <span class="font-semibold text-zinc-900 dark:text-white break-words">{{ $reply->user->name }}</span>
                                            <span class="text-xs text-zinc-500 dark:text-zinc-400 ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <button wire:click="confirmDeleteReply({{ $reply->id }})" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm transition-colors flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                                <p class="mt-3 text-zinc-700 dark:text-zinc-300 whitespace-pre-wrap break-words">{{ $reply->content }}</p>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="w-16 h-16 mx-auto bg-zinc-100 dark:bg-zinc-700 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <p class="text-zinc-500 dark:text-zinc-400">لا توجد ردود على هذا النقاش بعد.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="flex-shrink-0 p-4 flex justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button wire:click="$set('viewing_discussion_id', null)" class="px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إغلاق</button>
            </div>
        </div>
    </div>
    @endif

    {{-- نوافذ تأكيد الحذف --}}
    <x-confirm-delete-modal action="deleteDiscussion" state="discussion_to_delete_id" title="حذف النقاش" message="هل أنت متأكد من رغبتك في حذف هذا النقاش بالكامل؟ سيتم حذف جميع الردود المرتبطة به بشكل دائم." />
    <x-confirm-delete-modal action="deleteReply" state="reply_to_delete_id" title="حذف الرد" message="هل أنت متأكد من رغبتك في حذف هذا الرد؟ لا يمكن التراجع عن هذا الإجراء." />


{{-- إضافة الأنماط المخصصة --}}
<style>
    /* تحسينات إضافية للتصميم وحل مشكلة النصوص الخارجة عن الحدود */
    .break-words {
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* تأثيرات الانتقال الناعمة */
    .transition-all {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* تحسين الظلال */
    .shadow-md {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* تحسين الألوان الديناميكية */
    .bg-indigo-100 { background-color: #e0e7ff !important; }
    .bg-teal-100 { background-color: #ccfbf1 !important; }
    .bg-amber-100 { background-color: #fef3c7 !important; }
    .bg-rose-100 { background-color: #ffe4e6 !important; }
    .bg-blue-100 { background-color: #dbeafe !important; }
    .bg-violet-100 { background-color: #ede9fe !important; }

    .dark .bg-indigo-900\/30 { background-color: rgba(55, 48, 163, 0.3) !important; }
    .dark .bg-teal-900\/30 { background-color: rgba(19, 78, 74, 0.3) !important; }
    .dark .bg-amber-900\/30 { background-color: rgba(120, 53, 15, 0.3) !important; }
    .dark .bg-rose-900\/30 { background-color: rgba(136, 19, 55, 0.3) !important; }
    .dark .bg-blue-900\/30 { background-color: rgba(30, 58, 138, 0.3) !important; }
    .dark .bg-violet-900\/30 { background-color: rgba(76, 29, 149, 0.3) !important; }

    /* تحسين التفاعلية */
    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }

    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }

    /* تحسين الخطوط */
    body {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* ضمان عدم خروج المحتوى من الحاويات */
    .overflow-hidden {
        overflow: hidden;
    }

    .min-w-0 {
        min-width: 0;
    }

    /* تحسين الاستجابة */
    @media (max-width: 768px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3.2xl\:grid-cols-4 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    @media (min-width: 768px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3.2xl\:grid-cols-4 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1280px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3.2xl\:grid-cols-4 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (min-width: 1536px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3.2xl\:grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    /* تحسين عرض النصوص الطويلة */
    .-webkit-line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

</div>
