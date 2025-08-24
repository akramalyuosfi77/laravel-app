{{-- ملف: resources/views/livewire/student/profile-page.blade.php --}}
<div>
    <div class="max-w-3xl mx-auto mt-10 bg-white dark:bg-zinc-800 rounded-2xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-8">
        <div class="flex items-center gap-6 mb-8">
            <div class="w-24 h-24 rounded-xl overflow-hidden border-2 border-indigo-500">
                @if($student->profile_image)
                    <img class="w-full h-full object-cover" src="{{ Storage::url($student->profile_image) }}" alt="صورة الطالب">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-700 dark:to-zinc-800 flex items-center justify-center text-zinc-500 dark:text-zinc-400 text-xs font-semibold">
                        لا توجد صورة
                    </div>
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">{{ $student->name }}</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $student->email }}</p>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">رقم جامعي: {{ $student->student_id_number }}</p>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">دفعة: {{ $student->batch->name ?? 'غير محدد' }}</span>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-xs text-zinc-500 dark:text-zinc-400 mb-1">رقم الهاتف</label>
                <div class="text-sm text-zinc-900 dark:text-white">{{ $student->phone ?? 'غير مدخل' }}</div>
            </div>
            <div>
                <label class="block text-xs text-zinc-500 dark:text-zinc-400 mb-1">تاريخ الميلاد</label>
                <div class="text-sm text-zinc-900 dark:text-white">{{ $student->date_of_birth ?? 'غير مدخل' }}</div>
            </div>
            <div>
                <label class="block text-xs text-zinc-500 dark:text-zinc-400 mb-1">العنوان</label>
                <div class="text-sm text-zinc-900 dark:text-white">{{ $student->address ?? 'غير مدخل' }}</div>
            </div>
            <div>
                <label class="block text-xs text-zinc-500 dark:text-zinc-400 mb-1">التخصص</label>
                <div class="text-sm text-zinc-900 dark:text-white">{{ $student->batch->specialization->name ?? 'غير محدد' }}</div>
            </div>
            <div>
                <label class="block text-xs text-zinc-500 dark:text-zinc-400 mb-1">القسم</label>
                <div class="text-sm text-zinc-900 dark:text-white">{{ $student->batch->specialization->department->name ?? 'غير محدد' }}</div>
            </div>
            <div>
                <label class="block text-xs text-zinc-500 dark:text-zinc-400 mb-1">السنة الدراسية</label>
                <div class="text-sm text-zinc-900 dark:text-white">{{ $student->current_academic_year ?? 'غير محدد' }}</div>
            </div>
            <div>
                <label class="block text-xs text-zinc-500 dark:text-zinc-400 mb-1">الترم الدراسي</label>
                <div class="text-sm text-zinc-900 dark:text-white">{{ $student->current_semester ?? 'غير محدد' }}</div>
            </div>
            <div>
                <label class="block text-xs text-zinc-500 dark:text-zinc-400 mb-1">الحالة</label>
                <div class="text-sm text-zinc-900 dark:text-white">{{ $student->status }}</div>
            </div>
        </div>
        <div class="flex gap-4 mt-6">
            <button class="px-5 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-md shadow-indigo-500/20 transition-colors" onclick="document.getElementById('editProfileModal').classList.remove('hidden')">تعديل البيانات الشخصية</button>
        <button class="px-5 py-2 bg-gradient-to-r from-zinc-200 to-zinc-400 dark:from-zinc-700 dark:to-zinc-900 hover:from-zinc-300 hover:to-zinc-500 dark:hover:from-zinc-600 dark:hover:to-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-xl font-semibold shadow-md transition-colors" onclick="document.getElementById('changePasswordModal').classList.remove('hidden')">تغيير كلمة المرور</button>
        </div>

        <!-- نافذة منبثقة لتغيير كلمة المرور -->
        <div id="changePasswordModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
            <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-md border border-zinc-200 dark:border-zinc-700">
                <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>
                <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تغيير كلمة المرور</h2>
                    <button onclick="document.getElementById('changePasswordModal').classList.add('hidden')" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form wire:submit.prevent="changePassword" class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">كلمة المرور الحالية</label>
                            <input type="password" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white" wire:model.defer="current_password" placeholder="أدخل كلمة المرور الحالية">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">كلمة المرور الجديدة</label>
                            <input type="password" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white" wire:model.defer="new_password" placeholder="أدخل كلمة المرور الجديدة">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">تأكيد كلمة المرور الجديدة</label>
                            <input type="password" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white" wire:model.defer="new_password_confirmation" placeholder="أعد إدخال كلمة المرور الجديدة">
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" onclick="document.getElementById('changePasswordModal').classList.add('hidden')" class="px-5 py-2 bg-zinc-200 dark:bg-zinc-700 hover:bg-zinc-300 dark:hover:bg-zinc-600 text-zinc-700 dark:text-zinc-300 rounded-lg font-semibold transition-colors">إلغاء</button>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition-colors">حفظ كلمة المرور</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- نافذة منبثقة لتعديل البيانات الشخصية -->
        <div id="editProfileModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
            <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl w-full max-w-lg border border-zinc-200 dark:border-zinc-700">
                <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>
                <div class="flex-shrink-0 p-5 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white">تعديل البيانات الشخصية</h2>
                    <button onclick="document.getElementById('editProfileModal').classList.add('hidden')" class="p-1 rounded-full text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form wire:submit.prevent="updateProfile" class="p-6 space-y-6" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">رقم الهاتف</label>
                            <input type="text" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white" wire:model.defer="phone">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">تاريخ الميلاد</label>
                            <input type="date" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white" wire:model.defer="date_of_birth">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">العنوان</label>
                            <input type="text" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white" wire:model.defer="address">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">الصورة الشخصية</label>
                            <input type="file" class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white" wire:model="profile_image" accept="image/*">
                            @if ($profile_image)
                                <div class="mt-2">
                                    <img src="{{ $profile_image->temporaryUrl() }}" alt="معاينة الصورة" class="w-full h-32 object-cover rounded-xl">
                                </div>
                            @elseif (auth()->user()->student->profile_image)
                                <div class="mt-2">
                                    <img src="{{ Storage::url(auth()->user()->student->profile_image) }}" alt="الصورة الحالية" class="w-full h-32 object-cover rounded-xl">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" onclick="document.getElementById('editProfileModal').classList.add('hidden')" class="px-5 py-2 bg-zinc-200 dark:bg-zinc-700 hover:bg-zinc-300 dark:hover:bg-zinc-600 text-zinc-700 dark:text-zinc-300 rounded-lg font-semibold transition-colors">إلغاء</button>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition-colors">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
