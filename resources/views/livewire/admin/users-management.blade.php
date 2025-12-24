<div>
    {{-- 1. Combined Hero & Filters Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-50 via-indigo-50 to-purple-50 dark:from-zinc-900 dark:via-slate-900 dark:to-zinc-900 border border-slate-200 dark:border-slate-800 shadow-xl" x-data x-init="setTimeout(() => $el.classList.add('scale-100', 'opacity-100'), 100)" class="scale-95 opacity-0 transition-all duration-700">
        {{-- Animated Background Orbs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-10 right-10 w-72 h-72 bg-indigo-400/20 dark:bg-indigo-600/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-purple-400/20 dark:bg-purple-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        {{-- Top Part: Hero Content --}}
        <div class="relative z-10 p-8 pb-10">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                {{-- Left Side: Animation --}}
                <div class="order-1 md:order-1 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full blur-2xl opacity-20 animate-pulse"></div>
                        <lottie-player
                            src="/animations/robot-analytics.json"
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
                        <span class="text-sm font-bold text-indigo-700 dark:text-indigo-300">إدارة النظام</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-indigo-700 to-purple-700 dark:from-slate-100 dark:via-indigo-300 dark:to-purple-300 mb-4 leading-tight">
                        إدارة المستخدمين
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-300 mb-8 leading-relaxed">
                        إدارة شاملة لحسابات المستخدمين، الصلاحيات، والأدوار في النظام بكل سهولة.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <div class="group relative flex-1 min-w-[200px]">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition"></div>
                            <div class="relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input wire:model.live.debounce.300ms="search" placeholder="بحث بالاسم، البريد..." class="bg-transparent border-0 focus:ring-0 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 w-full">
                            </div>
                        </div>
                        <button wire:click="openForm" class="relative inline-flex items-center justify-center px-8 py-3 overflow-hidden font-bold text-white transition-all duration-300 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl group hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                            <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span class="relative">إضافة مستخدم</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Part: Filters (Merged) --}}
        <div class="relative z-10 bg-white/40 dark:bg-black/20 backdrop-blur-md border-t border-white/20 dark:border-white/5 p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="p-1.5 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg text-indigo-600 dark:text-indigo-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">تصفية متقدمة</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Role Filter -->
                <div>
                    <select wire:model.live="filter_role" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع الأدوار</option>
                        <option value="admin">مسؤول</option>
                        <option value="doctor">دكتور</option>
                        <option value="student">طالب</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <select wire:model.live="filter_is_active" class="w-full py-2.5 px-4 border border-slate-200 dark:border-slate-700/50 rounded-xl bg-white/50 dark:bg-zinc-800/50 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm hover:bg-white dark:hover:bg-zinc-800">
                        <option value="">جميع الحالات</option>
                        <option value="1">نشط</option>
                        <option value="0">معطل</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Users Grid --}}
    <div wire:loading.class.delay="opacity-50" class="transition-opacity">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            @php
                $colorThemes = [
                    ["gradient" => "from-indigo-500 to-purple-500", "border" => "border-indigo-500", "text" => "text-indigo-500", "overlay" => "bg-gradient-to-br from-indigo-500/70 to-purple-500/70"],
                    ["gradient" => "from-teal-500 to-emerald-500", "border" => "border-teal-500", "text" => "text-teal-500", "overlay" => "bg-gradient-to-br from-teal-500/70 to-emerald-500/70"],
                    ["gradient" => "from-amber-500 to-orange-500", "border" => "border-amber-500", "text" => "text-amber-500", "overlay" => "bg-gradient-to-br from-amber-500/70 to-orange-500/70"],
                    ["gradient" => "from-rose-500 to-pink-500", "border" => "border-rose-500", "text" => "text-rose-500", "overlay" => "bg-gradient-to-br from-rose-500/70 to-pink-500/70"],
                    ["gradient" => "from-blue-500 to-cyan-500", "border" => "border-blue-500", "text" => "text-blue-500", "overlay" => "bg-gradient-to-br from-blue-500/70 to-cyan-500/70"],
                    ["gradient" => "from-violet-500 to-fuchsia-500", "border" => "border-violet-500", "text" => "text-violet-500", "overlay" => "bg-gradient-to-br from-violet-500/70 to-fuchsia-500/70"],
                ];
            @endphp

            @forelse($users as $user)
                @php
                    $theme = $colorThemes[$loop->index % count($colorThemes)];
                @endphp

                <div class="group relative bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-500/10 dark:hover:shadow-indigo-900/30 hover:-translate-y-2 overflow-hidden">
                    {{-- Subtle Gradient Background --}}
                    <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-300 rounded-2xl"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        {{-- Header --}}
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-16 h-16 flex-shrink-0 rounded-xl overflow-hidden border-2 {{ $theme['border'] }} bg-gradient-to-br {{ $theme['gradient'] }} flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300">
                                @if($user->role === 'admin')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                @elseif($user->role === 'doctor')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold {{ $theme['text'] }} mb-1">{{ __($user->role) }}</p>
                                <h3 class="font-bold text-lg text-zinc-900 dark:text-white leading-tight line-clamp-1 break-all">{{ $user->name }}</h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 break-all line-clamp-1">{{ $user->email }}</p>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="space-y-2 mb-4 flex-grow">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-500 dark:text-slate-400">الحالة</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $user->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400' }}">
                                    {{ $user->is_active ? 'نشط' : 'معطل' }}
                                </span>
                            </div>

                            @if($user->role === 'student' && $user->student)
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-500 dark:text-slate-400">الرقم الجامعي</span>
                                    <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $user->student->student_id_number ?? '-' }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-500 dark:text-slate-400">الدفعة</span>
                                    <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $user->student->batch->name ?? '-' }}</span>
                                </div>
                            @endif

                            @if($user->role === 'doctor' && $user->doctor)
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-500 dark:text-slate-400">المواد</span>
                                    <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $user->doctor->specializationCourseAcademicPeriods->count() }} مادة</span>
                                </div>
                            @endif
                        </div>

                        {{-- Footer --}}
                        <div class="pt-3 border-t border-slate-200 dark:border-slate-700/50 flex justify-between items-center">
                            <span class="text-[10px] text-slate-400 dark:text-slate-500">
                                {{ $user->created_at ? $user->created_at->format('Y/m/d') : '-' }}
                            </span>
                            
                            <div class="flex gap-2">
                                <button wire:click="edit({{ $user->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-indigo-500 hover:text-white transition-colors" title="تعديل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button wire:click="toggleActiveStatus({{ $user->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-amber-500 hover:text-white transition-colors" title="{{ $user->is_active ? 'تعطيل' : 'تفعيل' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($user->is_active)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        @endif
                                    </svg>
                                </button>
                                <button wire:click="confirmDelete({{ $user->id }})" class="p-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-red-500 hover:text-white transition-colors" title="حذف">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 xl:col-span-3 2xl:col-span-4 p-12 text-center bg-gradient-to-br from-slate-50 to-indigo-50 dark:from-zinc-800/50 dark:to-zinc-900/50 rounded-3xl border-2 border-dashed border-slate-300 dark:border-slate-700/50 backdrop-blur-sm">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-6 shadow-2xl shadow-indigo-500/30">
                        <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-zinc-800 dark:text-white mb-2">لا توجد مستخدمين</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 mb-6 max-w-md mx-auto">لم يتم العثور على أي مستخدمين تطابق معايير البحث.</p>
                    <button wire:click="openForm" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-xl font-bold transition-all transform hover:scale-105 shadow-lg shadow-indigo-500/20">
                        إضافة أول مستخدم
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
    <div class="mt-8">
        {{ $users->links() }}
    </div>
    @endif

    {{-- Form Modal --}}
    @if($showForm)
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50" x-data x-transition.opacity>
        <div @click.away="window.livewire.dispatch('close-form')" class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col border border-zinc-200 dark:border-zinc-700">
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>
            <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $user_id ? 'تعديل المستخدم' : 'إضافة مستخدم جديد' }}</h2>
                <button wire:click="closeForm" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="flex-grow p-6 space-y-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الاسم <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="name" placeholder="أدخل اسم المستخدم..." class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                        @error('name') <span class="text-red-500 text-sm mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">البريد الإلكتروني <span class="text-red-500">*</span></label>
                        <input type="email" wire:model="email" placeholder="أدخل البريد الإلكتروني..." class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                        @error('email') <span class="text-red-500 text-sm mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الدور <span class="text-red-500">*</span></label>
                        <select wire:model.live="role" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                            <option value="">اختر الدور</option>
                            <option value="admin">مسؤول</option>
                            <option value="doctor">دكتور</option>
                            <option value="student">طالب</option>
                        </select>
                        @error('role') <span class="text-red-500 text-sm mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الحالة <span class="text-red-500">*</span></label>
                        <select wire:model="is_active" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                            <option value="1">نشط</option>
                            <option value="0">معطل</option>
                        </select>
                        @error('is_active') <span class="text-red-500 text-sm mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">كلمة المرور @if(!$user_id) <span class="text-red-500">*</span> @endif</label>
                        <input type="password" wire:model="password" placeholder="أدخل كلمة المرور..." class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" @if(!$user_id) required @endif>
                        @error('password') <span class="text-red-500 text-sm mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">تأكيد كلمة المرور @if(!$user_id) <span class="text-red-500">*</span> @endif</label>
                        <input type="password" wire:model="password_confirmation" placeholder="أعد إدخال كلمة المرور..." class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" @if(!$user_id) required @endif>
                        @error('password_confirmation') <span class="text-red-500 text-sm mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Student Fields --}}
                    @if($role === 'student')
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الرقم الجامعي <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="student_id_number" placeholder="أدخل الرقم الجامعي..." class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                            @error('student_id_number') <span class="text-red-500 text-sm mt-1.5 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">التخصص <span class="text-red-500">*</span></label>
                            <select wire:model="specialization_id" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                                <option value="">اختر التخصص</option>
                                @foreach($this->formSpecializations as $specialization)
                                    <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                                @endforeach
                            </select>
                            @error('specialization_id') <span class="text-red-500 text-sm mt-1.5 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الدفعة <span class="text-red-500">*</span></label>
                            <select wire:model="batch_id" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                                <option value="">اختر الدفعة</option>
                                @foreach($this->formBatches as $batch)
                                    <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                @endforeach
                            </select>
                            @error('batch_id') <span class="text-red-500 text-sm mt-1.5 block">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    {{-- Doctor Fields --}}
                    @if($role === 'doctor')
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">المواد التي يشرف عليها <span class="text-red-500">*</span></label>
                            <select wire:model="selected_specialization_course_academic_periods" multiple class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all h-32" required>
                                @foreach($this->availableCoursePeriods as $period)
                                    <option value="{{ $period->id }}">
                                        {{ $period->course->name ?? 'مادة غير معروفة' }} -
                                        {{ $period->specialization->name ?? 'تخصص غير معروف' }} -
                                        سنة {{ $period->academic_year }} -
                                        ترم {{ $period->semester }}
                                    </option>
                                @endforeach
                            </select>
                            @error('selected_specialization_course_academic_periods') <span class="text-red-500 text-sm mt-1.5 block">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>
            </form>

            <div class="flex-shrink-0 p-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-xl font-medium transition-colors">إلغاء</button>
                <button type="submit" wire:click="save" class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-indigo-500/20">
                    <span wire:loading.remove wire:target="save">{{ $user_id ? 'حفظ التعديلات' : 'إضافة المستخدم' }}</span>
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
            <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                </div>
                <h3 class="mt-5 text-lg font-bold text-zinc-900 dark:text-white">تأكيد عملية الحذف</h3>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">هل أنت متأكد من حذف هذا المستخدم؟ سيتم حذف جميع البيانات المرتبطة به. لا يمكن التراجع عن هذا الإجراء.</p>
            </div>
            <div class="p-4 flex flex-col-reverse sm:flex-row gap-3 bg-zinc-50 dark:bg-zinc-800/50">
                <button wire:click="$set('delete_id', null)" class="w-full sm:w-1/2 px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-lg font-medium transition-colors">إلغاء</button>
                <button wire:click="deleteUser" class="w-full sm:w-1/2 px-4 py-2.5 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition-colors shadow-md shadow-red-500/20">
                    <span wire:loading.remove wire:target="deleteUser">نعم، قم بالحذف</span>
                    <span wire:loading wire:target="deleteUser">جاري الحذف...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</div>
