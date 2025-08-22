
<div>
    {{-- 1. الهيدر المدمج والذكي --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">إدارة المشاريع</h1>
            <p class="mt-1 text-zinc-500 dark:text-zinc-400">إدارة، إبداع، وتنظيم مشاريعك في مكان واحد.</p>
        </div>
        <div class="w-full md:w-auto flex items-center gap-2">
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input wire:model.live="search" placeholder="ابحث بعنوان المشروع أو وصفه..." class="w-full pr-11 pl-4 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <button wire:click="openForm" class="flex-shrink-0 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2.5 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 shadow-md shadow-indigo-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>إضافة مشروع جديد</span>
            </button>
        </div>
    </div>

    {{-- فلاتر البحث والتصفية --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 p-6 bg-white dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
        <select
            wire:model.live="filter_status"
            class="w-full p-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all"
        >
            <option value="">فلتر حسب الحالة</option>
            <option value="pending">معلق</option>
            <option value="approved">موافق عليه</option>
            <option value="rejected">مرفوض</option>
            <option value="completed">مكتمل</option>
        </select>
        <select
            wire:model.live="filter_course_id"
            class="w-full p-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all"
        >
            <option value="">فلتر حسب المادة</option>
            @foreach($this->studentCourses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- قسم دعوات المشاريع المعلقة --}}
    @if($invitations->isNotEmpty())
    <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-r from-teal-500 to-emerald-500 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">دعوات المشاريع المعلقة</h2>
                <p class="text-zinc-500 dark:text-zinc-400">دعوات للانضمام إلى مشاريع جديدة</p>
            </div>
        </div>

        <div wire:loading.class.delay="opacity-50" class="transition-opacity">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($invitations as $invitation)
                    <div class="group relative bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <!-- تدرج لوني خلفي -->
                        <div class="absolute inset-0 bg-gradient-to-br from-teal-500 to-emerald-500 opacity-5 dark:opacity-10 rounded-2xl -z-10"></div>

                        <div class="flex flex-col h-full">
                            <div class="flex-grow">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 flex-shrink-0 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border border-teal-500">
                                        <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold text-teal-500 mb-1">عنوان المشروع</p>
                                        <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight">{{ $invitation->title }}</h3>
                                    </div>
                                </div>

                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-300">
                                            دعوة من: <strong>{{ $invitation->creatorStudent->name }}</strong>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-300">
                                            المادة: <strong>{{ $invitation->course->name }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end gap-3">
                                <button wire:click="respondToInvitation({{ $invitation->id }}, 'rejected')" class="px-4 py-2 text-sm font-semibold text-red-600 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors border border-red-200 dark:border-red-800">
                                    رفض
                                </button>
                                <button wire:click="respondToInvitation({{ $invitation->id }}, 'approved')" class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 rounded-lg transition-colors shadow-md shadow-teal-500/20">
                                    قبول الدعوة
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- قسم مشاريعي --}}
    <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">مشاريعي</h2>
                <p class="text-zinc-500 dark:text-zinc-400">المشاريع التي قمت بإنشائها أو المشاركة فيها</p>
            </div>
        </div>

        <div wire:loading.class.delay="opacity-50" class="transition-opacity">
            @if($myProjects->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @php
                        $colorThemes = [
                            ['gradient' => 'from-indigo-500 to-purple-500', 'border' => 'border-indigo-500', 'text' => 'text-indigo-500', 'overlay' => 'bg-gradient-to-br from-indigo-500/70 to-purple-500/70'],
                            ['gradient' => 'from-teal-500 to-emerald-500', 'border' => 'border-teal-500', 'text' => 'text-teal-500', 'overlay' => 'bg-gradient-to-br from-teal-500/70 to-emerald-500/70'],
                            ['gradient' => 'from-amber-500 to-orange-500', 'border' => 'border-amber-500', 'text' => 'text-amber-500', 'overlay' => 'bg-gradient-to-br from-amber-500/70 to-orange-500/70'],
                            ['gradient' => 'from-rose-500 to-pink-500', 'border' => 'border-rose-500', 'text' => 'text-rose-500', 'overlay' => 'bg-gradient-to-br from-rose-500/70 to-pink-500/70'],
                            ['gradient' => 'from-blue-500 to-cyan-500', 'border' => 'border-blue-500', 'text' => 'text-blue-500', 'overlay' => 'bg-gradient-to-br from-blue-500/70 to-cyan-500/70'],
                            ['gradient' => 'from-violet-500 to-fuchsia-500', 'border' => 'border-violet-500', 'text' => 'text-violet-500', 'overlay' => 'bg-gradient-to-br from-violet-500/70 to-fuchsia-500/70'],
                        ];
                    @endphp

                    @foreach($myProjects as $project)
                        @php
                            $theme = $colorThemes[$loop->index % count($colorThemes)];
                        @endphp

                        <div class="group relative bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1.5">
                            <!-- تدرج لوني خلفي -->
                            <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-5 dark:opacity-10 rounded-2xl -z-10"></div>

                            <!-- المحتوى الرئيسي للبطاقة -->
                            <div class="flex flex-col h-full">
                                <div class="flex-grow">
                                    <div class="flex items-start gap-4">
                                        <div class="w-14 h-14 flex-shrink-0 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border {{ $theme['border'] }}">
                                            <svg class="w-8 h-8 {{ $theme['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs font-semibold {{ $theme['text'] }} mb-1">عنوان المشروع</p>
                                            <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight">{{ $project->title }}</h3>
                                        </div>
                                    </div>

                                    <div class="mt-4 space-y-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                            <p class="text-xs text-zinc-600 dark:text-zinc-300">المادة: {{ $project->course->name ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            <p class="text-xs text-zinc-600 dark:text-zinc-300">الدكتور: {{ $project->doctor->name ?? 'غير محدد' }}</p>
                                        </div>
                                        @if($project->course && $project->course->specialization)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                <p class="text-xs text-zinc-600 dark:text-zinc-300">التخصص: {{ $project->course->specialization->name ?? 'غير محدد' }}</p>
                                            </div>
                                        @endif
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                                @if($project->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                                @elseif($project->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                                @elseif($project->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                                @elseif($project->status == 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                                @endif">
                                                {{ __($project->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الوصف</p>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-300 line-clamp-3">
                                            {{ $project->description ?: 'لا يوجد وصف متاح لهذا المشروع.' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                                    المنشئ: {{ $project->creatorStudent->name ?? 'غير محدد' }}
                                </div>
                            </div>

                            <!-- أزرار التحكم التي تظهر عند الـ Hover -->
                            <div class="absolute inset-0 {{ $theme['overlay'] }} dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <button wire:click="viewProject({{ $project->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button wire:click="edit({{ $project->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button wire:click="confirmDelete({{ $project->id }})" class="w-14 h-14 flex items-center justify-center bg-red-500/30 hover:bg-red-500/40 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $myProjects->links('livewire::bootstrap', ['pageName' => 'myProjectsPage']) }}
                </div>
            @else
                {{-- حالة عدم وجود مشاريع --}}
                <div class="p-12 text-center bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-indigo-300 dark:border-zinc-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">ابدأ مشروعك الأول</h3>
                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">لم تقم بإنشاء أي مشاريع بعد. ابدأ الآن وأنشئ مشروعاً مميزاً.</p>
                    <button wire:click="openForm" class="mt-6 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-colors flex items-center justify-center gap-2 mx-auto shadow-md shadow-indigo-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>إضافة أول مشروع</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- قسم جميع المشاريع --}}
    <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">جميع المشاريع</h2>
                <p class="text-zinc-500 dark:text-zinc-400">استكشف المشاريع المتاحة للانضمام إليها</p>
            </div>
        </div>

        <div wire:loading.class.delay="opacity-50" class="transition-opacity">
            @if($allProjects->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @php
                        $colorThemes = [
                            ['gradient' => 'from-blue-500 to-cyan-500', 'border' => 'border-blue-500', 'text' => 'text-blue-500', 'overlay' => 'bg-gradient-to-br from-blue-500/70 to-cyan-500/70'],
                            ['gradient' => 'from-violet-500 to-fuchsia-500', 'border' => 'border-violet-500', 'text' => 'text-violet-500', 'overlay' => 'bg-gradient-to-br from-violet-500/70 to-fuchsia-500/70'],
                            ['gradient' => 'from-emerald-500 to-teal-500', 'border' => 'border-emerald-500', 'text' => 'text-emerald-500', 'overlay' => 'bg-gradient-to-br from-emerald-500/70 to-teal-500/70'],
                            ['gradient' => 'from-orange-500 to-red-500', 'border' => 'border-orange-500', 'text' => 'text-orange-500', 'overlay' => 'bg-gradient-to-br from-orange-500/70 to-red-500/70'],
                            ['gradient' => 'from-pink-500 to-rose-500', 'border' => 'border-pink-500', 'text' => 'text-pink-500', 'overlay' => 'bg-gradient-to-br from-pink-500/70 to-rose-500/70'],
                            ['gradient' => 'from-indigo-500 to-blue-500', 'border' => 'border-indigo-500', 'text' => 'text-indigo-500', 'overlay' => 'bg-gradient-to-br from-indigo-500/70 to-blue-500/70'],
                        ];
                    @endphp

                    @foreach($allProjects as $project)
                        @php
                            $theme = $colorThemes[$loop->index % count($colorThemes)];
                        @endphp

                        <div class="group relative bg-white dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1.5">
                            <!-- تدرج لوني خلفي -->
                            <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-5 dark:opacity-10 rounded-2xl -z-10"></div>

                            <!-- المحتوى الرئيسي للبطاقة -->
                            <div class="flex flex-col h-full">
                                <div class="flex-grow">
                                    <div class="flex items-start gap-4">
                                        <div class="w-14 h-14 flex-shrink-0 bg-white dark:bg-zinc-800 rounded-xl flex items-center justify-center border {{ $theme['border'] }}">
                                            <svg class="w-8 h-8 {{ $theme['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs font-semibold {{ $theme['text'] }} mb-1">عنوان المشروع</p>
                                            <h3 class="font-bold text-xl text-zinc-900 dark:text-white leading-tight">{{ $project->title }}</h3>
                                        </div>
                                    </div>

                                    <div class="mt-4 space-y-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                            <p class="text-xs text-zinc-600 dark:text-zinc-300">المادة: {{ $project->course->name ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            <p class="text-xs text-zinc-600 dark:text-zinc-300">الدكتور: {{ $project->doctor->name ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                                @if($project->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                                @elseif($project->status == 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                                @endif">
                                                {{ __($project->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">الوصف</p>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-300 line-clamp-3">
                                            {{ $project->description ?: 'لا يوجد وصف متاح لهذا المشروع.' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        المنشئ: {{ $project->creatorStudent->name ?? 'غير محدد' }}
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                            <span class="text-xs text-zinc-600 dark:text-zinc-300">{{ $project->likes_count }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                            <span class="text-xs text-zinc-600 dark:text-zinc-300">{{ $project->comments_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- أزرار التحكم التي تظهر عند الـ Hover -->
                            <div class="absolute inset-0 {{ $theme['overlay'] }} dark:bg-zinc-900/80 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <button wire:click="viewProject({{ $project->id }})" class="w-14 h-14 flex items-center justify-center bg-white/20 hover:bg-white/30 rounded-full text-white transform transition-all hover:scale-110 shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $allProjects->links('livewire::bootstrap', ['pageName' => 'allProjectsPage']) }}
                </div>
            @else
                {{-- حالة عدم وجود مشاريع --}}
                <div class="p-12 text-center bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-zinc-800/30 dark:to-zinc-900/30 rounded-2xl border border-dashed border-blue-300 dark:border-zinc-700">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-zinc-800 dark:text-white">لا توجد مشاريع متاحة</h3>
                    <p class="mt-1 text-zinc-500 dark:text-zinc-400">لا توجد مشاريع أخرى لعرضها حاليًا.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- النوافذ المنبثقة (Modals) بتصميم فخم بالألوان --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-form')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>

            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $project_id ? 'تعديل المشروع' : 'إضافة مشروع جديد' }}</h2>
                <button wire:click="closeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="flex-grow p-6 space-y-5 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="title" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">عنوان المشروع <span class="text-red-500">*</span></label>
                        <input id="title" wire:model="title" type="text" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="أدخل عنوان المشروع">
                        @error('title') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="selected_course_id_for_form" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">المادة <span class="text-red-500">*</span></label>
                        <select id="selected_course_id_for_form" wire:model.live="selected_course_id_for_form" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="">اختر المادة</option>
                            @foreach($this->studentCourses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('selected_course_id_for_form') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الوصف (اختياري)</label>
                        <textarea id="description" wire:model="description" rows="4" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-y transition-all" placeholder="أدخل وصفاً موجزاً عن المشروع..."></textarea>
                        @error('description') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="doctor_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الدكتور المشرف <span class="text-red-500">*</span></label>
                        <select id="doctor_id" wire:model="doctor_id" class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" @if(!$selected_course_id_for_form) disabled @endif>
                            <option value="">اختر الدكتور</option>
                            @foreach($this->availableDoctorsForCourse as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="selected_students" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">الطلاب المشاركون <span class="text-red-500">*</span></label>
                        <select id="selected_students" wire:model="selected_students" multiple class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all h-32">
                            @foreach($this->allStudents as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->student_id_number }})</option>
                            @endforeach
                        </select>
                        @error('selected_students') <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- حقول رفع الملفات الجديدة --}}
                <div class="border-t border-zinc-200 dark:border-zinc-700 pt-5">
                    <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4">إضافة ملفات جديدة</h3>
                    <div class="space-y-4">
                        @if(count($new_files) < 5)
                            @foreach($new_files as $index => $file)
                                <div class="flex flex-col sm:flex-row items-center gap-3 p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                                    <div class="flex-grow">
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">الملف</label>
                                        <input type="file" wire:model="new_files.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg">
                                        @error('new_files.' . $index) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex-grow">
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">نوع الملف</label>
                                        <select wire:model="file_types.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700">
                                            <option value="">اختر النوع</option>
                                            <option value="image">صورة</option>
                                            <option value="video">فيديو</option>
                                            <option value="presentation">عرض تقديمي</option>
                                            <option value="document">مستند</option>
                                            <option value="other">أخرى</option>
                                        </select>
                                        @error('file_types.' . $index) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex-grow">
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">وصف الملف (اختياري)</label>
                                        <input type="text" wire:model="file_descriptions.{{ $index }}" class="w-full p-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700">
                                        @error('file_descriptions.' . $index) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <button type="button" wire:click="removeNewFile({{ $index }})" class="text-red-600 hover:text-red-800 mt-6">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            @endforeach
                            <button type="button" wire:click="addNewFile" class="mt-4 bg-zinc-200 dark:bg-zinc-700 hover:bg-zinc-300 dark:hover:bg-zinc-600 text-zinc-700 dark:text-zinc-300 px-4 py-2 rounded-lg text-sm transition-colors">
                                <svg class="w-4 h-4 inline me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                إضافة حقل ملف
                            </button>
                        @else
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">لقد وصلت للحد الأقصى من الملفات (5).</p>
                        @endif
                    </div>
                </div>

                {{-- عرض الملفات الموجودة (للتعديل) --}}
                @if($existing_files)
                    <div class="border-t border-zinc-200 dark:border-zinc-700 pt-5">
                        <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4">الملفات الحالية</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($existing_files as $file)
                                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-3 bg-zinc-50 dark:bg-zinc-800/50 flex flex-col">
                                    @if(Str::startsWith($file['file_type'], 'image'))
                                        <img src="{{ Storage::url($file['file_path']) }}" alt="{{ $file['file_name'] }}" class="w-full h-24 object-cover rounded-md mb-2">
                                    @elseif(Str::startsWith($file['file_type'], 'video'))
                                        <video controls class="w-full h-24 object-cover rounded-md mb-2">
                                            <source src="{{ Storage::url($file['file_path']) }}" type="{{ $file['file_type'] }}">
                                            متصفحك لا يدعم الفيديو.
                                        </video>
                                    @else
                                        <div class="w-full h-24 flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-md mb-2 text-zinc-500">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                    @endif
                                    <p class="text-zinc-800 dark:text-zinc-200 font-semibold text-sm truncate mb-1">{{ $file['file_name'] }}</p>
                                    <p class="text-zinc-600 dark:text-zinc-400 text-xs mb-2">{{ $file['description'] ?? 'لا يوجد وصف' }}</p>
                                    <div class="flex justify-between items-center mt-auto">
                                        <a href="{{ Storage::url($file['file_path']) }}" target="_blank" class="text-blue-600 hover:underline text-xs">عرض/تحميل</a>
                                        <button type="button" wire:click="markFileForDeletion({{ $file['id'] }})" class="text-red-600 hover:text-red-800 text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-indigo-500/20">
                    <span wire:loading.remove wire:target="save">{{ $project_id ? 'حفظ التعديلات' : 'إنشاء المشروع' }}</span>
                    <span wire:loading wire:target="save">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if($delete_id)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.set('delete_id', null)" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>

            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="mt-5 text-lg font-bold text-zinc-900 dark:text-white">تأكيد عملية الحذف</h3>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">هل أنت متأكد من حذف هذا المشروع؟ سيتم حذف جميع الملفات والإعجابات والتعليقات المرتبطة به. لا يمكن التراجع عن هذا الإجراء.</p>
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

    {{-- نافذة عرض تفاصيل المشروع المنبثقة --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.closeViewModal()" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <!-- شريط أعلى النافذة بلون متدرج -->
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>

            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تفاصيل المشروع: {{ $viewedProject->title ?? '' }}</h2>
                <button wire:click="closeViewModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-grow p-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <p class="text-zinc-700 dark:text-zinc-300 font-semibold mb-2">عنوان المشروع:</p>
                        <p class="text-zinc-900 dark:text-white">{{ $viewedProject->title ?? '' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <p class="text-zinc-700 dark:text-zinc-300 font-semibold mb-2">المادة:</p>
                        <p class="text-zinc-900 dark:text-white">{{ $viewedProject->course->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <p class="text-zinc-700 dark:text-zinc-300 font-semibold mb-2">المنشئ:</p>
                        <p class="text-zinc-900 dark:text-white">{{ $viewedProject->creatorStudent->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <p class="text-zinc-700 dark:text-zinc-300 font-semibold mb-2">الدكتور المشرف:</p>
                        <p class="text-zinc-900 dark:text-white">{{ $viewedProject->doctor->name ?? 'غير محدد' }}</p>
                    </div>
                    @if($viewedProject->course && $viewedProject->course->specialization)
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-semibold mb-2">التخصص:</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedProject->course->specialization->name ?? 'غير محدد' }}</p>
                        </div>
                        @if($viewedProject->course->specialization->department)
                            <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                <p class="text-zinc-700 dark:text-zinc-300 font-semibold mb-2">القسم:</p>
                                <p class="text-zinc-900 dark:text-white">{{ $viewedProject->course->specialization->department->name ?? 'غير محدد' }}</p>
                            </div>
                        @endif
                    @endif
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <p class="text-zinc-700 dark:text-zinc-300 font-semibold mb-2">الحالة:</p>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if($viewedProject->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                            @elseif($viewedProject->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                            @elseif($viewedProject->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                            @elseif($viewedProject->status == 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                            @endif">
                            {{ __($viewedProject->status) }}
                        </span>
                    </div>
                    @if($viewedProject->status == 'completed' && ($viewedProject->grade !== null || $viewedProject->feedback !== null))
                        <div class="md:col-span-2 bg-green-50 dark:bg-green-900/20 p-4 rounded-xl border border-green-200 dark:border-green-800">
                            <h3 class="text-lg font-bold text-green-800 dark:text-green-400 mb-3">تقييم الدكتور:</h3>
                            @if($viewedProject->grade !== null)
                                <p class="text-zinc-700 dark:text-zinc-300 font-semibold mb-1">الدرجة:</p>
                                <p class="text-zinc-900 dark:text-white text-lg font-bold">{{ $viewedProject->grade }}%</p>
                            @endif
                            @if($viewedProject->feedback !== null)
                                <p class="text-zinc-700 dark:text-zinc-300 font-semibold mt-3 mb-1">ملاحظات الدكتور:</p>
                                <p class="text-zinc-900 dark:text-white">{{ $viewedProject->feedback }}</p>
                            @endif
                        </div>
                    @elseif($viewedProject->status == 'completed')
                        <div class="md:col-span-2 bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-xl border border-yellow-200 dark:border-yellow-800">
                            <h3 class="text-lg font-bold text-yellow-800 dark:text-yellow-400 mb-3">تقييم الدكتور:</h3>
                            <p class="text-zinc-600 dark:text-zinc-400">المشروع مكتمل ولكن لم يتم إضافة تقييم بعد.</p>
                        </div>
                    @endif
                    <div class="md:col-span-2 bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <p class="text-zinc-700 dark:text-zinc-300 font-semibold mb-2">الوصف:</p>
                        <p class="text-zinc-900 dark:text-white">{{ $viewedProject->description ?? 'لا يوجد وصف' }}</p>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-4">الطلاب المشاركون:</h3>
                @if($viewedProject->students->isNotEmpty())
                    <div class="flex flex-wrap gap-3 mb-6">
                        @foreach($viewedProject->students as $participant)
                            <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $participant->name }}
                                @if($participant->id == $viewedProject->creatorStudent->id) (المنشئ) @endif
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-zinc-600 dark:text-zinc-400 mb-6">لا يوجد طلاب مشاركون في هذا المشروع.</p>
                @endif

                <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-4">الملفات المرفقة:</h3>
                @if($viewedProject->files->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                        @foreach($viewedProject->files as $file)
                            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-3 bg-zinc-50 dark:bg-zinc-800/50 flex flex-col">
                                @if(Str::startsWith($file->file_type, 'image'))
                                    <img src="{{ Storage::url($file->file_path) }}" alt="{{ $file->file_name }}" class="w-full h-32 object-cover rounded-md mb-2">
                                @elseif(Str::startsWith($file->file_type, 'video'))
                                    <video controls class="w-full h-32 object-cover rounded-md mb-2">
                                        <source src="{{ Storage::url($file->file_path) }}" type="{{ $file->file_type }}">
                                        متصفحك لا يدعم الفيديو.
                                    </video>
                                @else
                                    <div class="w-full h-32 flex items-center justify-center bg-zinc-100 dark:bg-zinc-700 rounded-md mb-2 text-zinc-500">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                @endif
                                <p class="text-zinc-800 dark:text-zinc-200 font-semibold text-sm truncate mb-1">{{ $file->file_name }}</p>
                                <p class="text-zinc-600 dark:text-zinc-400 text-xs mb-2">{{ $file->description ?? 'لا يوجد وصف' }}</p>
                                <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-blue-600 hover:underline text-xs mt-auto">عرض/تحميل</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-zinc-600 dark:text-zinc-400 mb-6">لا توجد ملفات مرفقة بهذا المشروع.</p>
                @endif

                <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-4">الإعجابات والتعليقات:</h3>

                <div class="flex items-center gap-6 mb-4">
                    <!-- زر الإعجاب -->
                    <button wire:click="toggleLike({{ $viewedProject->id }})" class="flex items-center text-zinc-600 dark:text-zinc-400 hover:text-red-500 transition duration-200">
                        <svg class="w-6 h-6 me-2 {{ $viewedProject->isLikedByUser(Auth::user()) ? 'text-red-500 fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span class="text-sm font-medium">{{ $viewedProject->likes->count() }} إعجاب</span>
                    </button>

                    <!-- عدد التعليقات -->
                    <div class="flex items-center text-zinc-600 dark:text-zinc-400">
                        <svg class="w-6 h-6 me-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span class="text-sm font-medium">{{ $viewedProject->comments->count() }} تعليق</span>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-zinc-800 dark:text-white mb-2">أضف تعليقًا:</h4>
                    <textarea
                        wire:model="comment_text"
                        rows="3"
                        class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                        placeholder="اكتب تعليقك هنا..."
                    ></textarea>
                    @error('comment_text') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    <button
                        wire:click="addComment({{ $viewedProject->id }})"
                        class="mt-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors shadow-md shadow-indigo-500/20"
                    >
                        إضافة تعليق
                    </button>
                </div>

                <h4 class="text-lg font-semibold text-zinc-800 dark:text-white mb-2">التعليقات السابقة:</h4>
                @if($viewedProject->comments->isNotEmpty())
                    <div class="space-y-4">
                        @foreach($viewedProject->comments->sortByDesc('created_at') as $comment)
                            <div class="bg-zinc-100 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                <div class="flex items-center mb-1">
                                    <span class="font-semibold text-zinc-800 dark:text-zinc-200 me-2">{{ $comment->user->name ?? 'مستخدم غير معروف' }}</span>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-zinc-700 dark:text-zinc-300 text-sm">{{ $comment->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-zinc-600 dark:text-zinc-400">لا توجد تعليقات بعد.</p>
                @endif
            </div>

            <div class="flex-shrink-0 p-4 flex justify-end bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button
                    type="button"
                    wire:click="closeViewModal"
                    class="px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors"
                >
                    إغلاق
                </button>
            </div>
        </div>
    </div>
    @endif

    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</div>

