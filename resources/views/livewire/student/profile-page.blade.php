{{-- ملف: resources/views/livewire/student/profile-page.blade.php --}}
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50/30 to-purple-50/30 dark:from-zinc-900 dark:via-indigo-950/20 dark:to-purple-950/20">
    
    {{-- Hero Section --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-purple-600 to-fuchsia-600 dark:from-indigo-900 dark:via-purple-900 dark:to-fuchsia-900 shadow-2xl shadow-purple-500/20">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-fuchsia-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative z-10 p-8 md:p-12">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div class="order-2 md:order-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span class="text-sm font-bold text-white">الملف الشخصي</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black text-white mb-4 leading-tight">
                        👤 ملفي الشخصي
                    </h1>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        معلوماتك الشخصية والأكاديمية!
                    </p>
                </div>

                <div class="order-1 md:order-2 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-3xl"></div>
                        <lottie-player
                            src="/animations/abihe.json"
                            background="transparent"
                            speed="1"
                            style="width: 100%; max-width: 350px; height: auto;"
                            loop
                            autoplay>
                        </lottie-player>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="currentColor" class="text-slate-50 dark:text-zinc-900"/>
            </svg>
        </div>
    </div>

    {{-- Profile Card --}}
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-sm rounded-3xl shadow-2xl border-2 border-zinc-200 dark:border-zinc-800 overflow-hidden">
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
            
            {{-- Profile Header --}}
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-center gap-6 mb-8">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl blur opacity-25 group-hover:opacity-75 transition"></div>
                        <div class="relative w-32 h-32 rounded-3xl overflow-hidden border-4 border-white dark:border-zinc-800 shadow-xl">
                            @if($student->profile_image)
                                <img class="w-full h-full object-cover" src="{{ Storage::url($student->profile_image) }}" alt="صورة الطالب">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1 text-center md:text-right">
                        <h2 class="text-3xl font-black text-zinc-900 dark:text-white mb-2">{{ $student->name }}</h2>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">{{ $student->email }}</p>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3">رقم جامعي: {{ $student->student_id_number }}</p>
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            دفعة: {{ $student->batch->name ?? 'غير محدد' }}
                        </span>
                    </div>
                </div>

                {{-- Info Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="p-4 bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-950/20 dark:to-cyan-950/20 rounded-2xl border border-blue-200 dark:border-blue-800">
                        <label class="block text-xs font-bold text-blue-600 dark:text-blue-400 mb-2">📱 رقم الهاتف</label>
                        <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $student->phone ?? 'غير مدخل' }}</div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-950/20 dark:to-teal-950/20 rounded-2xl border border-emerald-200 dark:border-emerald-800">
                        <label class="block text-xs font-bold text-emerald-600 dark:text-emerald-400 mb-2">🎂 تاريخ الميلاد</label>
                        <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $student->date_of_birth ?? 'غير مدخل' }}</div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-violet-50 to-purple-50 dark:from-violet-950/20 dark:to-purple-950/20 rounded-2xl border border-violet-200 dark:border-violet-800">
                        <label class="block text-xs font-bold text-violet-600 dark:text-violet-400 mb-2">🏠 العنوان</label>
                        <div class="text-sm font-semibold text-zinc-900 dark:text-white break-words">{{ $student->address ?? 'غير مدخل' }}</div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-950/20 dark:to-orange-950/20 rounded-2xl border border-amber-200 dark:border-amber-800">
                        <label class="block text-xs font-bold text-amber-600 dark:text-amber-400 mb-2">🎓 التخصص</label>
                        <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $student->batch->specialization->name ?? 'غير محدد' }}</div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-rose-50 to-pink-50 dark:from-rose-950/20 dark:to-pink-950/20 rounded-2xl border border-rose-200 dark:border-rose-800">
                        <label class="block text-xs font-bold text-rose-600 dark:text-rose-400 mb-2">🏛️ القسم</label>
                        <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $student->batch->specialization->department->name ?? 'غير محدد' }}</div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-cyan-50 to-sky-50 dark:from-cyan-950/20 dark:to-sky-950/20 rounded-2xl border border-cyan-200 dark:border-cyan-800">
                        <label class="block text-xs font-bold text-cyan-600 dark:text-cyan-400 mb-2">📅 السنة الدراسية</label>
                        <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $student->current_academic_year ?? 'غير محدد' }}</div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-950/20 dark:to-blue-950/20 rounded-2xl border border-indigo-200 dark:border-indigo-800">
                        <label class="block text-xs font-bold text-indigo-600 dark:text-indigo-400 mb-2">📚 الترم الدراسي</label>
                        <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $student->current_semester ?? 'غير محدد' }}</div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-950/20 dark:to-emerald-950/20 rounded-2xl border border-green-200 dark:border-green-800">
                        <label class="block text-xs font-bold text-green-600 dark:text-green-400 mb-2">✅ الحالة</label>
                        <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $student->status }}</div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-wrap gap-4">
                    <button onclick="document.getElementById('editProfileModal').classList.remove('hidden')" class="group relative inline-flex items-center justify-center px-8 py-4 overflow-hidden font-bold text-white transition-all duration-300 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-purple-400/50 shadow-lg">
                        <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span class="relative">تعديل البيانات الشخصية</span>
                    </button>
                    <button onclick="document.getElementById('changePasswordModal').classList.remove('hidden')" class="group relative inline-flex items-center justify-center px-8 py-4 overflow-hidden font-bold text-zinc-700 dark:text-zinc-300 transition-all duration-300 bg-gradient-to-r from-zinc-200 to-zinc-300 dark:from-zinc-700 dark:to-zinc-800 rounded-2xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-zinc-400/50 shadow-lg">
                        <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white dark:bg-zinc-900 opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        <span class="relative">تغيير كلمة المرور</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Change Password Modal --}}
    <div id="changePasswordModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl w-full max-w-md border border-zinc-200 dark:border-zinc-800">
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-3xl"></div>
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-black text-zinc-900 dark:text-white">🔐 تغيير كلمة المرور</h2>
                    <button onclick="document.getElementById('changePasswordModal').classList.add('hidden')" class="p-2 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <form wire:submit.prevent="changePassword" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">كلمة المرور الحالية</label>
                    <input type="password" wire:model.defer="current_password" placeholder="أدخل كلمة المرور الحالية" class="w-full px-4 py-3 border-2 border-zinc-300 dark:border-zinc-600 rounded-2xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">كلمة المرور الجديدة</label>
                    <input type="password" wire:model.defer="new_password" placeholder="أدخل كلمة المرور الجديدة" class="w-full px-4 py-3 border-2 border-zinc-300 dark:border-zinc-600 rounded-2xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">تأكيد كلمة المرور الجديدة</label>
                    <input type="password" wire:model.defer="new_password_confirmation" placeholder="أعد إدخال كلمة المرور الجديدة" class="w-full px-4 py-3 border-2 border-zinc-300 dark:border-zinc-600 rounded-2xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('changePasswordModal').classList.add('hidden')" class="flex-1 px-6 py-3 border-2 border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-2xl font-bold transition-colors">إلغاء</button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-2xl font-bold transition-colors shadow-lg">حفظ</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Profile Modal --}}
    <div id="editProfileModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl w-full max-w-lg border border-zinc-200 dark:border-zinc-800 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-3xl sticky top-0"></div>
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800 sticky top-2 bg-white dark:bg-zinc-900 z-10">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-black text-zinc-900 dark:text-white">✏️ تعديل البيانات الشخصية</h2>
                    <button onclick="document.getElementById('editProfileModal').classList.add('hidden')" class="p-2 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <form wire:submit.prevent="updateProfile" class="p-6 space-y-4" enctype="multipart/form-data">
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">📱 رقم الهاتف</label>
                    <input type="text" wire:model.defer="phone" class="w-full px-4 py-3 border-2 border-zinc-300 dark:border-zinc-600 rounded-2xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">🎂 تاريخ الميلاد</label>
                    <input type="date" wire:model.defer="date_of_birth" class="w-full px-4 py-3 border-2 border-zinc-300 dark:border-zinc-600 rounded-2xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">🏠 العنوان</label>
                    <input type="text" wire:model.defer="address" class="w-full px-4 py-3 border-2 border-zinc-300 dark:border-zinc-600 rounded-2xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2">📸 الصورة الشخصية</label>
                    <input type="file" wire:model="profile_image" accept="image/*" class="w-full px-4 py-3 border-2 border-zinc-300 dark:border-zinc-600 rounded-2xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                    @if ($profile_image)
                        <div class="mt-3">
                            <img src="{{ $profile_image->temporaryUrl() }}" alt="معاينة الصورة" class="w-full h-40 object-cover rounded-2xl border-2 border-indigo-500">
                        </div>
                    @elseif (auth()->user()->student->profile_image)
                        <div class="mt-3">
                            <img src="{{ Storage::url(auth()->user()->student->profile_image) }}" alt="الصورة الحالية" class="w-full h-40 object-cover rounded-2xl border-2 border-zinc-300 dark:border-zinc-600">
                        </div>
                    @endif
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('editProfileModal').classList.add('hidden')" class="flex-1 px-6 py-3 border-2 border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-2xl font-bold transition-colors">إلغاء</button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-2xl font-bold transition-colors shadow-lg">حفظ</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Lottie Player Script --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    {{-- Custom Scrollbar --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(99, 102, 241, 0.3), rgba(168, 85, 247, 0.3));
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(99, 102, 241, 0.5), rgba(168, 85, 247, 0.5));
        }
    </style>
</div>
