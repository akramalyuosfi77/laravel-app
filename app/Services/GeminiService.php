<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function chatWithDocument($documentText, $question)
    {
        // Construct the prompt
        $header = "أنت مساعد أكاديمي ذكي ومفيد. استخدم محتوى المحاضرة التالي للإجابة على سؤال الطالب بدقة. إذا كانت الإجابة غير موجودة في المحتوى، أخبر الطالب بذلك بلطف.\n\n";
        $content = "محتوى المحاضرة:\n" . $documentText . "\n\n";
        $userQuery = "سؤال الطالب:\n" . $question;
        
        $fullPrompt = $header . $content . $userQuery;

        // Truncate if extremely large (safety mostly)
        if (strlen($fullPrompt) > 1000000) {
           $fullPrompt = substr($fullPrompt, 0, 1000000); 
        }

        try {
            $response = Http::timeout(60)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '?key=' . $this->apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $fullPrompt]
                            ]
                        ]
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'عذراً، لم أتمكن من فهم الرد.';
            } else {
                $errorBody = $response->body();
                $statusCode = $response->status();
                Log::error("Gemini API Error [{$statusCode}]: {$errorBody}");
                
                // Return user-friendly error based on status
                if ($statusCode == 400) {
                    // Demo mode - return intelligent mock response
                    return $this->getDemoResponse($question);
                } elseif ($statusCode == 403) {
                    return 'عذراً، مفتاح API غير صالح أو انتهت صلاحيته.';
                } elseif ($statusCode == 429) {
                    return 'عذراً، تجاوزت الحد المسموح من الطلبات. حاول مرة أخرى بعد قليل.';
                }
                
                return 'حدث خطأ أثناء الاتصال بالذكاء الاصطناعي. (كود الخطأ: ' . $statusCode . ')';
            }
        } catch (\Exception $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());
            return 'حدث خطأ غير متوقع: ' . $e->getMessage();
        }
    }

    private function getDemoResponse($question)
    {
        $lowerQuestion = mb_strtolower($question);
        
        if (str_contains($lowerQuestion, 'مرحبا') || str_contains($lowerQuestion, 'هلا') || str_contains($lowerQuestion, 'السلام')) {
            return "مرحباً بك! أنا حالياً في وضع التجربة. 🎓\n\nلتفعيل الذكاء الاصطناعي الكامل:\n1. تأكد من تفعيل Gemini API في Google Cloud Console\n2. أنشئ مفتاح API جديد من: https://aistudio.google.com/\n3. ضعه في ملف .env\n\nحالياً، يمكنني الرد على أسئلة بسيطة فقط!";
        }
        
        return "شكراً على سؤالك: \"$question\"\n\n📝 هذا رد تجريبي لأن مفتاح Gemini API يحتاج تفعيل.\n\nلتفعيل الذكاء الاصطناعي الكامل، تابع الخطوات في الرسالة الترحيبية.";
    }
}
