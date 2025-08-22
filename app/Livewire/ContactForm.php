<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use App\Models\User; // 💡 استيراد موديل المستخدم
use App\Notifications\NewContactMessage; // 💡 استيراد فئة الإشعار
use Illuminate\Support\Facades\Notification; // 💡 استيراد واجهة الإشعارات
use Livewire\Component;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public string $subject = ''; // تم تعديل النوع ليكون متوافقاً
    public $message = '';

    public function submit()
    {
        // --- [الكود الجديد للحماية] ---
        $throttleKey = 'contact-form:'.request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'name' => 'لقد قمت بإرسال الكثير من الطلبات. يرجى المحاولة مرة أخرى بعد دقيقة.',
            ]);
        }
        RateLimiter::hit($throttleKey);
        // --- [نهاية الكود الجديد] ---
        
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $contactMessage = ContactMessage::create($validatedData);

        // --- 💡 الكود الجديد لإرسال الإشعار ---
        try {
            $admins = User::where('role', 'admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new NewContactMessage($contactMessage));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send contact message notification: ' . $e->getMessage());
        }
        // --- نهاية الكود الجديد ---

        $this->reset();
        session()->flash('success', '✅ تم إرسال رسالتك بنجاح');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
