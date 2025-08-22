<div class="max-w-xl mx-auto bg-white p-6 rounded shadow space-y-6 mt-6">
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <label for="name">الاسم الكامل</label>
            <input type="text" id="name" wire:model="name" class="form-control w-full">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" wire:model="email" class="form-control w-full">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="subject">الموضوع</label>
            <select id="subject" wire:model="subject" class="form-control w-full">
                <option value="">اختر الموضوع...</option>
                <option value="academic">استفسار أكاديمي</option>
                <option value="registration">التسجيل والقبول</option>
                <option value="technical">دعم فني</option>
                <option value="general">استفسار عام</option>
            </select>
            @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="message">رسالتك</label>
            <textarea id="message" wire:model="message" rows="4" class="form-control w-full"></textarea>
            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded w-full hover:bg-blue-700">
            <i class="fas fa-paper-plane ml-2"></i> إرسال الرسالة
        </button> -->
          <button type="submit" class="btn-primary" style="width: 100%; padding: 15px;"><i class="fas fa-paper-plane" style="margin-left: 8px;"></i>إرسال الرسالة</button>

    </form>
</div>
