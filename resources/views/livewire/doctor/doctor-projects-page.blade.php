<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

        {{-- 1. Hero Section المدمج --}}
        <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-indigo-50 to-purple-50 dark:from-zinc-900 dark:via-indigo-900/20 dark:to-purple-900/20 border border-slate-200 dark:border-slate-800" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
            {{-- Animated Background Orbs --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-10 right-10 w-72 h-72 bg-indigo-400/20 dark:bg-indigo-600/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-10 left-10 w-96 h-96 bg-purple-400/20 dark:bg-purple-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 p-8">
                {{-- Grid Layout: Animation + Content --}}
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    {{-- Left Side: Animation --}}
                    <div class="order-1 md:order-1 flex justify-center">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                            <lottie-player
                                src="/animations/Demo.json"
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
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-100 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-800 rounded-full mb-4">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                            <span class="text-sm font-bold text-indigo-700 dark:text-indigo-300">إدارة المشاريع</span>
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-indigo-700 to-purple-700 dark:from-slate-100 dark:via-indigo-300 dark:to-purple-300 mb-4 leading-tight" style="font-family: 'Questv1', sans-serif;">
                            مشاريعي 🎯
                        </h1>
                        <p class="text-lg text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
                            إشراف شامل على المشاريع الأكاديمية بكل احترافية وتميز
                        </p>

                        {{-- Stats Cards --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm p-4 rounded-xl border border-slate-200/50 dark:border-slate-700/50">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">المشاريع</span>
                                </div>
                                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $projects->total() }}</p>
                            </div>
                            <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm p-4 rounded-xl border border-slate-200/50 dark:border-slate-700/50">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">طلبات معلقة</span>
                                </div>
                                <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $supervisionRequests->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Filters Section --}}
        <div class="bg-white/60 dark:bg-zinc-800/60 backdrop-blur-sm rounded-2xl border border-slate-200/50 dark:border-slate-700/50 p-6 mb-6 shadow-xl">
            <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                </svg>
                البحث والتصفية
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" wire:model.live="search" placeholder="ابحث بعنوان المشروع..." class="w-full pr-10 pl-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>
                <select wire:model.live="filter_status" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">كل الحالات</option>
                    @foreach($projectStatuses as $statusOption)
                        <option value="{{ $statusOption }}">{{ __($statusOption) }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filter_course_id" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-zinc-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">كل المواد</option>
                    @foreach($this->doctorCourses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- 3. Supervision Requests Section --}}
        @if($supervisionRequests->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                <span class="w-2 h-8 bg-amber-600 rounded-full inline-block"></span>
                طلبات الإشراف المعلقة
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($supervisionRequests as $request)
                    <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-amber-200/50 dark:border-amber-800/50 transition-all duration-300 hover:shadow-2xl hover:shadow-amber-500/10 dark:hover:shadow-amber-900/30 hover:-translate-y-2">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-orange-500 rounded-t-2xl"></div>
                        
                        <span class="inline-block px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400 rounded-full text-xs font-bold mb-4">معلق</span>
                        
                        <h3 class="font-bold text-zinc-800 dark:text-white text-lg mb-4 line-clamp-2 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors" style="font-family: 'Questv1', sans-serif;">{{ $request->title }}</h3>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>{{ $request->creatorStudent->name }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span>{{ $request->course->name }}</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <button wire:click="rejectSupervision({{ $request->id }})" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-bold transition-all">رفض</button>
                            <button wire:click="approveSupervision({{ $request->id }})" class="px-4 py-2 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white rounded-xl text-sm font-bold transition-all shadow-lg">قبول</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- 4. Projects Grid --}}
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2" style="font-family: 'Questv1', sans-serif;">
                <span class="w-2 h-8 bg-indigo-600 rounded-full inline-block"></span>
                مشاريعي المشرف عليها
            </h2>

            @forelse ($projects as $project)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach ($projects as $project)
                        <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-500/10 dark:hover:shadow-indigo-900/30 hover:-translate-y-2 overflow-hidden">
                            {{-- Status Bar --}}
                            <div class="absolute top-0 left-0 right-0 h-1
                                @if($project->status == 'pending') bg-gradient-to-r from-yellow-400 to-amber-500
                                @elseif($project->status == 'approved') bg-gradient-to-r from-green-400 to-emerald-500
                                @elseif($project->status == 'rejected') bg-gradient-to-r from-red-400 to-rose-500
                                @elseif($project->status == 'completed') bg-gradient-to-r from-blue-400 to-indigo-500
                                @endif rounded-t-2xl">
                            </div>

                            <div class="relative z-10">
                                {{-- Header --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 rounded-2xl
                                        @if($project->status == 'pending') bg-gradient-to-r from-yellow-500 to-amber-500
                                        @elseif($project->status == 'approved') bg-gradient-to-r from-green-500 to-emerald-500
                                        @elseif($project->status == 'rejected') bg-gradient-to-r from-red-500 to-rose-500
                                        @elseif($project->status == 'completed') bg-gradient-to-r from-blue-500 to-indigo-500
                                        @endif flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        @if($project->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                        @elseif($project->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                        @elseif($project->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                        @elseif($project->status == 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                        @endif">
                                        {{ __($project->status) }}
                                    </span>
                                </div>

                                {{-- Title --}}
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors" style="font-family: 'Questv1', sans-serif;">
                                    {{ $project->title }}
                                </h3>

                                {{-- Info --}}
                                <div class="space-y-3 mb-6">
                                    <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                        <div class="w-8 h-8 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">المنشئ</p>
                                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $project->creatorStudent->name ?? 'غير محدد' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                                        <div class="w-8 h-8 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">المادة</p>
                                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $project->course->name ?? 'غير محدد' }}</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 text-xs">
                                        <div class="p-2 bg-slate-50 dark:bg-slate-900/50 rounded-lg">
                                            <p class="text-slate-500 dark:text-slate-400 mb-1">الدفعة</p>
                                            <p class="font-medium text-slate-600 dark:text-slate-400">{{ $project->batch->name ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="p-2 bg-slate-50 dark:bg-slate-900/50 rounded-lg">
                                            <p class="text-slate-500 dark:text-slate-400 mb-1">التخصص</p>
                                            <p class="font-medium text-slate-600 dark:text-slate-400">{{ $project->specialization->name ?? 'غير محدد' }}</p>
                                        </div>
                                    </div>

                                    @if($project->grade)
                                    <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 rounded-xl border border-yellow-200 dark:border-yellow-800">
                                        <div class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-amber-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-yellow-600 dark:text-yellow-400">الدرجة</p>
                                            <p class="text-lg font-bold text-yellow-800 dark:text-yellow-300">{{ $project->grade }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="flex flex-col gap-3">
                                    <button wire:click="viewProject({{ $project->id }})" class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white px-4 py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2 shadow-lg hover:scale-105">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        عرض التفاصيل
                                    </button>

                                    <div class="grid grid-cols-2 gap-3">
                                        <button wire:click="openChangeStatusModal({{ $project->id }})" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-lg font-bold transition-all flex items-center justify-center gap-2 shadow-md hover:scale-105">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            تغيير الحالة
                                        </button>

                                        <button wire:click="openGradeForm({{ $project->id }})" class="bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white px-4 py-2 rounded-lg font-bold transition-all flex items-center justify-center gap-2 shadow-md hover:scale-105">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                            تقييم
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="col-span-full p-12 text-center bg-white/50 dark:bg-zinc-800/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700 backdrop-blur-sm">
                    <div class="w-20 h-20 mx-auto bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-2">لا توجد مشاريع</h3>
                    <p class="text-zinc-500 dark:text-zinc-400">لا توجد مشاريع لعرضها حالياً.</p>
                </div>
            @endforelse

            @if($projects->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Modals --}}

    {{-- Change Status Modal --}}
    @if($showChangeStatusModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.closeChangeStatusModal()" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-md border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="h-2 bg-gradient-to-r from-purple-500 to-pink-500"></div>
            
            <div class="p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">تغيير حالة المشروع</h2>
                <button wire:click="closeChangeStatusModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="saveStatus" class="p-6">
                <div>
                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الحالة الجديدة <span class="text-red-500">*</span></label>
                    <select wire:model="status" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-purple-500 transition-all" required>
                        <option value="">اختر الحالة</option>
                        @foreach($projectStatuses as $statusOption)
                            <option value="{{ $statusOption }}">{{ __($statusOption) }}</option>
                        @endforeach
                    </select>
                    @error('status') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
            </form>

            <div class="p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeChangeStatusModal" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="saveStatus" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-lg font-semibold transition-colors shadow-md">
                    <span wire:loading.remove wire:target="saveStatus">حفظ التغيير</span>
                    <span wire:loading wire:target="saveStatus">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Grade Form Modal --}}
    @if($showGradeForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.resetGradeForm()" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="h-2 bg-gradient-to-r from-green-500 to-emerald-500"></div>
            
            <div class="p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">تقييم المشروع</h2>
                <button wire:click="resetGradeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="saveGrade" class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الدرجة <span class="text-red-500">*</span></label>
                    <input type="number" wire:model="grade_value" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 transition-all" required min="0" max="100" placeholder="أدخل الدرجة من 0 إلى 100">
                    @error('grade_value') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">ملاحظات (اختياري)</label>
                    <textarea wire:model="feedback_text" rows="4" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 transition-all" placeholder="أضف ملاحظاتك وتعليقاتك على المشروع..."></textarea>
                    @error('feedback_text') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
            </form>

            <div class="p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="resetGradeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="saveGrade" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg font-semibold transition-colors shadow-md">
                    <span wire:loading.remove wire:target="saveGrade">حفظ التقييم</span>
                    <span wire:loading wire:target="saveGrade">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- View Project Modal --}}
    @if($showViewModal)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="$wire.closeViewModal()" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-6xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-t-2xl"></div>
            
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white" style="font-family: 'Questv1', sans-serif;">تفاصيل المشروع</h2>
                <button wire:click="closeViewModal" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-grow p-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">عنوان المشروع</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $viewedProject->title ?? '' }}</span>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">المادة</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $viewedProject->course->name ?? '-' }}</span>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">المنشئ</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $viewedProject->creatorStudent->name ?? '-' }}</span>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">الدفعة</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $viewedProject->batch->name ?? '-' }}</span>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">التخصص</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $viewedProject->specialization->name ?? '-' }}</span>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">الدكتور المشرف</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $viewedProject->doctor->name ?? '-' }}</span>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">الحالة</span>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-bold
                            @if($viewedProject->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                            @elseif($viewedProject->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                            @elseif($viewedProject->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                            @elseif($viewedProject->status == 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                            @endif">
                            {{ __($viewedProject->status) }}
                        </span>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">الدرجة</span>
                        <span class="font-bold text-lg text-zinc-900 dark:text-white">{{ $viewedProject->grade ?? 'لم يتم التقييم' }}</span>
                    </div>
                    <div class="col-span-full bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">الوصف</span>
                        <p class="text-zinc-800 dark:text-zinc-200 whitespace-pre-line">{{ $viewedProject->description ?? 'لا يوجد وصف' }}</p>
                    </div>
                    <div class="col-span-full bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <span class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">ملاحظات الدكتور</span>
                        <p class="text-zinc-800 dark:text-zinc-200 whitespace-pre-line">{{ $viewedProject->feedback ?? 'لا توجد ملاحظات' }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end">
                <button wire:click="closeViewModal" class="px-5 py-2.5 bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 rounded-lg font-medium hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors">إغلاق</button>
            </div>
        </div>
    </div>
    @endif

    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
