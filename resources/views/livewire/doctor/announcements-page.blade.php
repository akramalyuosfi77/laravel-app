<div>
    @section('title', 'إدارة إعلاناتي')

    {{-- 1. الهيدر المدمج والذكي --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">إدارة إعلاناتي</h1>
            <p class="mt-1 text-zinc-500 dark:text-zinc-400">نظرة شاملة على الإعلانات التي قمت بنشرها.</p>
        </div>
        <button wire:click="openForm" class="w-full md:w-auto flex-shrink-0 bg-gradient-to-r from-sky-500 to-blue-500 hover:from-sky-600 hover:to-blue-600 text-white px-5 py-3 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 shadow-lg shadow-sky-500/20 transform hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>إضافة إعلان جديد</span>
        </button>
    </div>

    {{-- 2. الفلاتر والبحث --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 p-4 bg-white dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
        <div class="relative">
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="ابحث بعنوان الإعلان..." class="w-full pr-11 pl-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all">
        </div>
        <select wire:model.live="filter_course_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 transition-all">
            <option value="">كل المقررات</option>
            @foreach($this->doctorCourses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- 3. شبكة بطاقات الإعلانات --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @php
                $announcementThemes = [
                    ['gradient' => 'from-sky-500 to-blue-500', 'border' => 'border-sky-500', 'text' => 'text-sky-500', 'overlay' => 'bg-gradient-to-br from-sky-500/70 to-blue-500/70'],
                    ['gradient' => 'from-cyan-500 to-teal-500', 'border' => 'border-cyan-500', 'text' => 'text-cyan-500', 'overlay' => 'bg-gradient-to-br from-cyan-500/70 to-teal-500/70'],
                    ['gradient' => 'from-indigo-500 to-violet-500', 'border' => 'border-indigo-500', 'text' => 'text-indigo-500', 'overlay' => 'bg-gradient-to-br from-indigo-500/70 to-violet-500/70'],
                ];
            @endphp
            @forelse($announcements as $announcement)
                @php
                    $theme = $announcementThemes[$loop->index % count($announcementThemes)];
                @endphp
                <div class="group relative bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1.5 flex flex-col">
                    <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-5 dark:opacity-10 rounded-2xl -z-10"></div>
                    <div class="flex-grow">
                        {{-- رأس البطاقة --}}
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 flex-shrink-0 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border {{ $theme['border'] }}">
                                <svg class="w-8 h-8 {{ $theme['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold {{ $theme['text'] }} mb-1">العنوان</p>
                                <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight">{{ $announcement->title }}</h3>
                            </div>
                        </div>
                        {{-- محتوى البطاقة --}}
                        <div class="mt-4">
                            <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">المحتوى</p>
                            <p class="text-sm text-zinc-600 dark:text-zinc-300 leading-relaxed">{{ Str::limit($announcement->content, 150, '...') }}</p>
                        </div>
                        {{-- تفاصيل إضافية --}}
                        <div class="mt-4 space-y-3 pt-3 border-t border-zinc-200 dark:border-zinc-700/50">
                            <div class="flex justify-between items-center">
                                <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">المادة المستهدفة:</p>
                                <p class="text-sm font-medium text-zinc-700 dark:text-zinc-200">{{ \App\Models\Course::find($announcement->target_id)->name ?? 'كل المواد' }}</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">مستوى الأهمية:</p>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($announcement->level == 'danger') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                    @elseif($announcement->level == 'warning') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                    @elseif($announcement->level == 'success') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                    @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 @endif">
                                    {{ __($announcement->level) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- ذيل البطاقة --}}
                    <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400 flex justify-between">
                        <span>نُشر في: {{ $announcement->created_at->format('Y/m/d') }}</span>
                        <span>ينتهي في: {{ $announcement->expires_at ? $announcement->expires_at->format('Y/m/d') : 'لا ينتهي' }}</span>
                    </div>
                    {{-- أزرار التحكم --}}
                    <div class="absolute inset-0 {{ $theme['overlay'] }} dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button wire:click="edit({{ $announcement->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                        <button wire:click="confirmDelete({{ $announcement->id }})" class="w-14 h-14 flex items-center justify-center bg-red-500/30 hover:bg-red-500/40 rounded-full text-white transform transition-all hover:scale-110 shadow-lg"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 xl:col-span-3 p-12 text-center bg-gradient-to-br from-sky-50 to-blue-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-sky-300 dark:border-zinc-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-sky-500 to-blue-500 rounded-full flex items-center justify-center mb-4"><svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg></div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">لم تقم بنشر أي إعلانات بعد</h3>
                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">اضغط على زر "إضافة إعلان جديد" للبدء.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- 4. الترقيم --}}
    @if($announcements->hasPages())
    <div class="mt-8">
        {{ $announcements->links() }}
    </div>
    @endif

    {{-- ================================================================= --}}
    {{-- ✅ النوافذ المنبثقة (Modals) كاملة وجاهزة --}}
    {{-- ================================================================= --}}

    {{-- نافذة نموذج إضافة/تعديل الإعلان --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.closeForm()" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden flex flex-col max-h-[90vh]">
            <div class="h-2 bg-gradient-to-r from-sky-500 to-blue-500"></div>
            <div class="p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-sky-500 to-blue-500 rounded-xl flex items-center justify-center"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg></div>
                    {{ $announcement_id ? 'تعديل الإعلان' : 'إضافة إعلان جديد' }}
                </h2>
<button wire:click="closeForm"
    class="p-2 rounded-full
           bg-sky-500 hover:bg-sky-600
           text-white shadow-md shadow-sky-400/40
           transition-all duration-300 ease-in-out transform hover:scale-110">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
    </svg>
</button>
            </div>
            <form wire:submit.prevent="save" class="p-8 space-y-6 overflow-y-auto">
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">المادة <span class="text-red-500">*</span></label>
                    <select wire:model="course_id" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all shadow-sm" required>
                        <option value="">-- اختر المادة --</option>
                        @foreach($this->doctorCourses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                    @error('course_id') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">العنوان <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="title" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all shadow-sm" required>
                    @error('title') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">المحتوى <span class="text-red-500">*</span></label>
                    <textarea wire:model="content" rows="4" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 resize-y transition-all shadow-sm" required></textarea>
                    @error('content') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">المستوى</label>
                        <select wire:model="level" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all shadow-sm">
                            <option value="info">معلومات</option>
                            <option value="success">نجاح</option>
                            <option value="warning">تحذير</option>
                            <option value="danger">خطر</option>
                        </select>
                        @error('level') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">انتهاء الصلاحية</label>
                        <input type="datetime-local" wire:model="expires_at" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all shadow-sm">
                        @error('expires_at') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
            </form>
            <div class="p-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex-shrink-0">
<button type="button" wire:click="closeForm"
    class="w-full sm:w-auto px-6 py-3
           bg-sky-500 hover:bg-sky-600
           text-white rounded-xl font-semibold
           shadow-md shadow-sky-400/40
           transition-all duration-300 transform hover:scale-105">
    إلغاء
</button>
 <button type="submit" wire:click="save"
    class="w-full sm:w-auto px-6 py-3
           bg-sky-500 hover:bg-sky-600
           text-white rounded-xl font-semibold flex items-center justify-center gap-2
           transition-all shadow-lg shadow-cyan-400/30 dark:shadow-sky-700/40">

    <span wire:loading.remove wire:target="save">{{ $announcement_id ? 'حفظ التعديلات' : 'إضافة الإعلان' }}</span>
    <span wire:loading wire:target="save">جاري الحفظ...</span>
</button>


            </div>
        </div>
    </div>
    @endif

    {{-- نافذة تأكيد حذف الإعلان --}}
    @if($delete_id)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.set('delete_id', null)" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-red-500 to-rose-500"></div>
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gradient-to-r from-red-100 to-rose-100 dark:from-red-900/30 dark:to-rose-900/30 rounded-full flex items-center justify-center mb-4"><svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg></div>
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">تأكيد الحذف</h3>
                <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed">هل أنت متأكد من رغبتك في حذف هذا الإعلان؟ لا يمكن التراجع عن هذا الإجراء.</p>
            </div>
            <div class="p-6 flex flex-col-reverse sm:flex-row gap-3 bg-zinc-50 dark:bg-zinc-800/50">
                <button wire:click="$set('delete_id', null)" class="w-full sm:w-1/2 px-4 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-semibold transition-colors">إلغاء</button>
                <button wire:click="delete" class="w-full sm:w-1/2 px-4 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-all shadow-lg shadow-red-500/25"><span wire:loading.remove wire:target="delete">نعم، قم بالحذف</span><span wire:loading wire:target="delete">جاري الحذف...</span></button>
            </div>
        </div>
    </div>
    @endif
</div>
