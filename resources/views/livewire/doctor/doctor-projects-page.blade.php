<div>
    {{-- الخلفية الرئيسية مع تدرج لوني فاخر --}}
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900 font-sans">
        <div class="max-w-7xl mx-auto p-6 sm:p-8">

            {{-- الهيدر الرئيسي الفاخر --}}
            <div class="bg-white dark:bg-zinc-800/50 rounded-3xl shadow-2xl border border-zinc-200 dark:border-zinc-700 p-8 mb-8 backdrop-blur-sm">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-zinc-800 dark:text-white">مشاريعي</h1>
                        <p class="text-zinc-500 dark:text-zinc-400 text-lg">إدارة شاملة للمشاريع الأكاديمية</p>
                    </div>
                </div>
            </div>

            {{-- فلاتر البحث والتصفية --}}
            <div class="bg-white dark:bg-zinc-800/50 rounded-3xl shadow-2xl border border-zinc-200 dark:border-zinc-700 p-8 mb-8 backdrop-blur-sm">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">البحث والفلترة</h2>
                        <p class="text-zinc-500 dark:text-zinc-400">ابحث وصفي المشاريع حسب احتياجاتك</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            wire:model.live="search"
                            placeholder="ابحث بعنوان المشروع، الوصف، المنشئ، المادة..."
                            class="w-full pr-11 pl-4 py-3 border border-emerald-300 dark:border-emerald-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm"
                        >
                    </div>
                    <select
                        wire:model.live="filter_status"
                        class="w-full px-4 py-3 border border-emerald-300 dark:border-emerald-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm"
                    >
                        <option value="">فلتر حسب الحالة</option>
                        @foreach($projectStatuses as $statusOption)
                            <option value="{{ $statusOption }}">{{ __($statusOption) }}</option>
                        @endforeach
                    </select>
                    <select
                        wire:model.live="filter_course_id"
                        class="w-full px-4 py-3 border border-emerald-300 dark:border-emerald-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm"
                    >
                        <option value="">فلتر حسب المادة</option>
                        @foreach($this->doctorCourses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- قسم طلبات الإشراف المعلقة --}}
            @if($supervisionRequests->isNotEmpty())
            <div class="bg-white dark:bg-zinc-800/50 rounded-3xl shadow-2xl border border-zinc-200 dark:border-zinc-700 p-8 mb-8 backdrop-blur-sm">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">طلبات الإشراف المعلقة</h2>
                        <p class="text-zinc-500 dark:text-zinc-400">طلبات جديدة تحتاج لموافقتك</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($supervisionRequests as $request)
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border-2 border-amber-200 dark:border-amber-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400 px-3 py-1 rounded-full text-xs font-bold">معلق</span>
                            </div>

                            <h3 class="font-bold text-zinc-800 dark:text-white text-lg mb-3 line-clamp-2">{{ $request->title }}</h3>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $request->creatorStudent->name }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $request->course->name }}</span>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <button
                                    wire:click="rejectSupervision({{ $request->id }})"
                                    class="flex-1 bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    رفض
                                </button>
                                <button
                                    wire:click="approveSupervision({{ $request->id }})"
                                    class="flex-1 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    قبول
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- قسم المشاريع المشرف عليها --}}
            <div class="bg-white dark:bg-zinc-800/50 rounded-3xl shadow-2xl border border-zinc-200 dark:border-zinc-700 p-8 backdrop-blur-sm">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">مشاريعي المشرف عليها</h2>
                        <p class="text-zinc-500 dark:text-zinc-400">جميع المشاريع التي تشرف عليها</p>
                    </div>
                </div>

                {{-- Grid المشاريع الفاخر --}}
                @forelse ($projects as $index => $project)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                        @foreach ($projects as $project)
                            <div class="group relative bg-gradient-to-br from-white to-zinc-50 dark:from-zinc-800/50 dark:to-zinc-900/50 rounded-3xl shadow-xl border border-zinc-200 dark:border-zinc-700 p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-105 backdrop-blur-sm overflow-hidden">
                                {{-- شريط علوي ملون حسب الحالة --}}
                                <div class="absolute top-0 left-0 right-0 h-1
                                    @if($project->status == 'pending') bg-gradient-to-r from-yellow-400 to-amber-500
                                    @elseif($project->status == 'approved') bg-gradient-to-r from-green-400 to-emerald-500
                                    @elseif($project->status == 'rejected') bg-gradient-to-r from-red-400 to-rose-500
                                    @elseif($project->status == 'completed') bg-gradient-to-r from-blue-400 to-indigo-500
                                    @endif rounded-t-3xl">
                                </div>

                                {{-- هيدر البطاقة --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12
                                        @if($project->status == 'pending') bg-gradient-to-r from-yellow-500 to-amber-500
                                        @elseif($project->status == 'approved') bg-gradient-to-r from-green-500 to-emerald-500
                                        @elseif($project->status == 'rejected') bg-gradient-to-r from-red-500 to-rose-500
                                        @elseif($project->status == 'completed') bg-gradient-to-r from-blue-500 to-indigo-500
                                        @endif rounded-xl flex items-center justify-center shadow-lg">
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

                                {{-- عنوان المشروع --}}
                                <h3 class="text-xl font-bold text-zinc-800 dark:text-white mb-3 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $project->title }}
                                </h3>

                                {{-- معلومات المشروع --}}
                                <div class="space-y-3 mb-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-zinc-100 dark:bg-zinc-700 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">المنشئ</p>
                                            <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">{{ $project->creatorStudent->name ?? 'غير محدد' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-zinc-100 dark:bg-zinc-700 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">المادة</p>
                                            <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">{{ $project->course->name ?? 'غير محدد' }}</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 bg-zinc-100 dark:bg-zinc-700 rounded-md flex items-center justify-center">
                                                <svg class="w-3 h-3 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-zinc-500 dark:text-zinc-400">الدفعة</p>
                                                <p class="text-xs font-medium text-zinc-600 dark:text-zinc-400">{{ $project->batch->name ?? 'غير محدد' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 bg-zinc-100 dark:bg-zinc-700 rounded-md flex items-center justify-center">
                                                <svg class="w-3 h-3 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-zinc-500 dark:text-zinc-400">التخصص</p>
                                                <p class="text-xs font-medium text-zinc-600 dark:text-zinc-400">{{ $project->specialization->name ?? 'غير محدد' }}</p>
                                            </div>
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

                                {{-- أزرار الإجراءات --}}
                                <div class="flex flex-col gap-3">
                                    <button
                                        wire:click="viewProject({{ $project->id }})"
                                        class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white px-4 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 transform hover:scale-105"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        عرض التفاصيل
                                    </button>

                                    <div class="grid grid-cols-2 gap-3">
                                        <button
                                            wire:click="openChangeStatusModal({{ $project->id }})"
                                            class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            تغيير الحالة
                                        </button>

                                        <button
                                            wire:click="openGradeForm({{ $project->id }})"
                                            class="bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                            تقييم
                                        </button>
                                    </div>
                                </div>

                                {{-- تأثير hover للخلفية --}}
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-purple-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <div class="text-center py-16">
                        <div class="w-24 h-24 mx-auto bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-zinc-800 dark:text-white mb-2">لا توجد مشاريع</h3>
                        <p class="text-zinc-500 dark:text-zinc-400 text-lg">لا توجد مشاريع لعرضها حالياً.</p>
                    </div>
                @endforelse

                {{-- الترقيم --}}
                @if($projects->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $projects->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- النوافذ المنبثقة بتصميم فاخر --}}

        {{-- نافذة تغيير حالة المشروع --}}
        @if($showChangeStatusModal)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.closeChangeStatusModal()" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-md border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <!-- شريط أعلى النافذة بلون متدرج -->
                <div class="h-2 bg-gradient-to-r from-purple-500 to-pink-500"></div>

                <div class="p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        تغيير حالة المشروع
                    </h2>
                    <button wire:click="closeChangeStatusModal" class="p-2 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveStatus" class="p-8">
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">الحالة الجديدة <span class="text-red-500">*</span></label>
                        <select
                            wire:model="status"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all shadow-sm"
                            required
                        >
                            <option value="">اختر الحالة</option>
                            @foreach($projectStatuses as $statusOption)
                                <option value="{{ $statusOption }}">{{ __($statusOption) }}</option>
                            @endforeach
                        </select>
                        @error('status') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </form>

                <div class="p-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                    <button
                        type="button"
                        wire:click="closeChangeStatusModal"
                        class="w-full sm:w-auto px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-semibold transition-colors"
                    >
                        إلغاء
                    </button>
                    <button
                        type="submit"
                        wire:click="saveStatus"
                        class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-all shadow-lg shadow-purple-500/25"
                    >
                        <span wire:loading.remove wire:target="saveStatus">حفظ التغيير</span>
                        <span wire:loading wire:target="saveStatus">جاري الحفظ...</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- نافذة نموذج التقييم --}}
        @if($showGradeForm)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.resetGradeForm()" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <!-- شريط أعلى النافذة بلون متدرج -->
                <div class="h-2 bg-gradient-to-r from-green-500 to-emerald-500"></div>

                <div class="p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        تقييم المشروع
                    </h2>
                    <button wire:click="resetGradeForm" class="p-2 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveGrade" class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">الدرجة <span class="text-red-500">*</span></label>
                        <input
                            type="number"
                            wire:model="grade_value"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all shadow-sm"
                            required
                            min="0"
                            max="100"
                            placeholder="أدخل الدرجة من 0 إلى 100"
                        >
                        @error('grade_value') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-3">ملاحظات (اختياري)</label>
                        <textarea
                            wire:model="feedback_text"
                            rows="4"
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-y transition-all shadow-sm"
                            placeholder="أضف ملاحظاتك وتعليقاتك على المشروع..."
                        ></textarea>
                        @error('feedback_text') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </form>

                <div class="p-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                    <button
                        type="button"
                        wire:click="resetGradeForm"
                        class="w-full sm:w-auto px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-semibold transition-colors"
                    >
                        إلغاء
                    </button>
                    <button
                        type="submit"
                        wire:click="saveGrade"
                        class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-all shadow-lg shadow-green-500/25"
                    >
                        <span wire:loading.remove wire:target="saveGrade">حفظ التقييم</span>
                        <span wire:loading wire:target="saveGrade">جاري الحفظ...</span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- نافذة عرض تفاصيل المشروع --}}
        @if($showViewModal)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
            <div @click.away="$wire.closeViewModal()" class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl w-full max-w-6xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
                <!-- شريط أعلى النافذة بلون متدرج -->
                <div class="h-2 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-t-3xl"></div>

                <div class="flex-shrink-0 p-6 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        تفاصيل المشروع: {{ $viewedProject->title ?? '' }}
                    </h2>
                    <button wire:click="closeViewModal" class="p-2 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="flex-grow p-8 overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">عنوان المشروع:</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedProject->title ?? '' }}</p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">المادة:</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedProject->course->name ?? 'غير محدد' }}</p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">المنشئ:</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedProject->creatorStudent->name ?? 'غير محدد' }}</p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">الدفعة:</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedProject->batch->name ?? 'غير محدد' }}</p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">التخصص:</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedProject->specialization->name ?? 'غير محدد' }}</p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">الدكتور المشرف:</p>
                            <p class="text-zinc-900 dark:text-white">{{ $viewedProject->doctor->name ?? 'غير محدد' }}</p>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">الحالة:</p>
                            <span class="px-3 py-1 rounded-full text-sm font-bold
                                @if($viewedProject->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                @elseif($viewedProject->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                @elseif($viewedProject->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                @elseif($viewedProject->status == 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                @endif">
                                {{ __($viewedProject->status) }}
                            </span>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">الدرجة:</p>
                            <p class="text-zinc-900 dark:text-white font-bold text-lg">{{ $viewedProject->grade ?? 'لم يتم التقييم' }}</p>
                        </div>
                        <div class="md:col-span-2 bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">الوصف:</p>
                            <p class="text-zinc-900 dark:text-white leading-relaxed">{{ $viewedProject->description ?? 'لا يوجد وصف' }}</p>
                        </div>
                        <div class="md:col-span-2 bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <p class="text-zinc-700 dark:text-zinc-300 font-bold mb-2">ملاحظات الدكتور:</p>
                            <p class="text-zinc-900 dark:text-white leading-relaxed">{{ $viewedProject->feedback ?? 'لا توجد ملاحظات' }}</p>
                        </div>
                    </div>

                    {{-- باقي المحتوى مثل الطلاب المشاركون والملفات والتعليقات --}}
                    {{-- يمكن إضافة المزيد من التفاصيل هنا حسب الحاجة --}}
                </div>

                <div class="flex-shrink-0 p-6 flex justify-end bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                    <button
                        type="button"
                        wire:click="closeViewModal"
                        class="px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-semibold transition-colors"
                    >
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scale-in {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        .animate-scale-in {
            animation: scale-in 0.3s ease-out;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</div>

