<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class GuestAiChat extends Component
{
    // حالة ظهور النافذة
    public $isOpen = false;

    // محتوى الرسالة الحالية
    public $message = '';

    // سجل المحادثة
    public $messages = [];

    // حالة الكتابة (لإظهار المؤشر)
    public $isTyping = false;

    public function mount()
    {
        // رسالة ترحيبية تلقائية عند فتح الموقع
        $this->messages[] = [
            'role' => 'bot',
            'content' => 'أهلاً بك في منصة نورس التعليمية! 🎓👋 
أنا مساعدك الذكي، يمكنني إخبارك عن التخصصات، الرسوم الدراسية، أو معدلات القبول. تفضل بالسؤال!',
            'time' => now()->format('h:i A')
        ];
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function sendMessage()
    {
        $text = trim($this->message);

        if (empty($text)) {
            return;
        }

        // إضافة رسالة المستخدم
        $this->messages[] = [
            'role' => 'user',
            'content' => $text,
            'time' => now()->format('h:i A')
        ];

        $this->message = '';
        $this->isTyping = true;

        // إرسال للذكاء الاصطناعي (n8n)
        $this->dispatch('sendToN8n', $text);
    }

    protected $listeners = ['sendToN8n' => 'processAiResponse'];

    public function processAiResponse($userMessage)
    {
        $webhookUrl = 'https://n8n.nooris.me/webhook-test/6befab21-cf87-4163-a2cd-505ba1cd1f44';

        try {
            $response = Http::withoutVerifying()
                ->timeout(60) // زيادة الوقت تحسباً لبطء الاستجابة من الذكاء الاصطناعي
                ->post($webhookUrl, [
                    'message' => $userMessage,
                    'sessionId' => session()->getId()
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // حاول استخراج الرد من عدة مفاتيح محتملة يخرجها n8n
                $botReply = $data['output'] ?? $data['text'] ?? $data['reply'] ?? $data[0]['output'] ?? null;

                if ($botReply) {
                    $this->messages[] = [
                        'role' => 'bot',
                        'content' => $botReply,
                        'time' => now()->format('h:i A')
                    ];
                } else {
                    $this->messages[] = [
                        'role' => 'bot',
                        'content' => 'لقد استلمت رداً فارغاً من المساعد. هل يمكنك المحاولة مرة أخرى؟',
                        'time' => now()->format('h:i A')
                    ];
                }
            } else {
                \Log::error('n8n Webhook Error: ' . $response->status() . ' - ' . $response->body());
                $this->messages[] = [
                    'role' => 'bot',
                    'content' => '⚠️ عذراً، المساعد مشغول حالياً. حاول ثانية.',
                    'time' => now()->format('h:i A')
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Chatbot Connection Exception: ' . $e->getMessage());
            $this->messages[] = [
                'role' => 'bot',
                'content' => '❌ خطأ في الاتصال: تأكد من تشغيل n8n Test Mode.',
                'time' => now()->format('h:i A')
            ];
        } finally {
            $this->isTyping = false;
        }
    }

    public function render()
    {
        return view('livewire.guest-ai-chat');
    }
}
