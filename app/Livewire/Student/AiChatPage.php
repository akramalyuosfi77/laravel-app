<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Auth;

class AiChatPage extends Component
{
    // سجل المحادثة
    public $conversation = [];

    // رسالة المستخدم الحالية
    public $currentMessage = '';

    // حالة التحميل
    public $isLoading = false;

    /**
     * تُنفذ عند تحميل الصفحة
     */
    public function mount()
    {
        $this->addMessageToConversation('ai', 'أهلاً بك يا ' . Auth::user()->name . '! أنا مساعدك الذكي. كيف يمكنني خدمتك اليوم؟');
    }

    /**
     * إضافة رسالة إلى سجل المحادثة
     */
    private function addMessageToConversation($sender, $text)
    {
        $this->conversation[] = ['sender' => $sender, 'text' => $text];
    }

    /**
     * دالة إرسال الرسالة
     */
    public function sendMessage()
    {
        $trimmedMessage = trim($this->currentMessage);
        if (empty($trimmedMessage)) {
            return;
        }

        // أضف رسالة المستخدم فوراً
        $this->addMessageToConversation('user', $trimmedMessage);

        // فعّل التحميل وافرغ الإدخال
        $this->isLoading = true;
        $this->currentMessage = '';

        // بعد تحديث الواجهة، نفذ الطلب إلى الذكاء الصناعي
        $this->dispatch('sendToAi', $trimmedMessage);
    }

    /**
     * مستمع للحدث (حتى يتم تنفيذ askAi بعد تحديث الواجهة)
     */
    protected $listeners = ['sendToAi' => 'askAi'];

    /**
     * دالة الاتصال بـ n8n
     */
    public function askAi($message)
    {
        // ✅ استخدم عنوان n8n مباشرة إذا كنت تتصل به من Laravel
        // أو يمكنك استخدام API محلي لو عملت وسيط بينهما
        // ملاحظة: استخدم production URL وليس test URL
        $n8nWebhookUrl = 'https://n8n.nooris.me/webhook/467225a5-d87d-45bb-926a-81dac97f6849';
        // $n8nWebhookUrl = url('/api/ask-ai'); // لو عندك route داخلي في Laravel يتعامل مع n8n

        try {
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->post($n8nWebhookUrl, ['message' => $message]);

            if ($response->successful() && isset($response->json()['reply'])) {
                $this->addMessageToConversation('ai', $response->json()['reply']);
            } else {
                $this->addMessageToConversation('ai', '⚠️ حدث خطأ أثناء الاتصال بالمساعد الذكي.');
            }
        } catch (ConnectionException $e) {
            $this->addMessageToConversation('ai', '❌ لا يمكن الوصول إلى خدمة المساعد الذكي في الوقت الحالي.');
        } finally {
            $this->isLoading = false;
        }
    }

    public function render()
    {
        return view('livewire.student.ai-chat-page');
    }
}
