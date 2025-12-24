<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Lecture;
use App\Services\GeminiService;
use App\Services\PdfService;
use Illuminate\Support\Facades\Cache;

class LectureChatBot extends Component
{
    public $lectureId;
    public $messages = [];
    public $userQuestion = '';
    public $isLoading = false;
    public $hasPdf = false;
    
    // We only load the text when needed
    protected $lectureText = null;

    public function mount($lectureId)
    {
        $this->lectureId = $lectureId;
        $this->checkIfPdfExists();
        
        // Add specific welcome message
        $this->messages[] = [
            'role' => 'bot',
            'content' => 'مرحباً! أنا مساعدك الذكي لهذه المحاضرة. اسألني أي سؤال عن المحتوى وسأجيبك فوراً! 🧠✨'
        ];
    }

    private function checkIfPdfExists()
    {
        $lecture = Lecture::with('files')->find($this->lectureId);
        if ($lecture && $lecture->files) {
            foreach ($lecture->files as $file) {
                if (str_contains(strtolower($file->file_type), 'pdf') || str_ends_with(strtolower($file->file_name), '.pdf')) {
                    $this->hasPdf = true;
                    return;
                }
            }
        }
    }

    private function getLectureContent()
    {
        // Cache the text content for 24 hours to avoid re-parsing
        return Cache::remember('lecture_text_' . $this->lectureId, 60 * 60 * 24, function () {
            $lecture = Lecture::with('files')->find($this->lectureId);
            $text = "";
            $pdfService = new PdfService();

            foreach ($lecture->files as $file) {
                 if (str_contains(strtolower($file->file_type), 'pdf') || str_ends_with(strtolower($file->file_name), '.pdf')) {
                    $extracted = $pdfService->extractText($file->file_path);
                    if ($extracted) {
                        $text .= "\n\n--- ملف: " . $file->file_name . " ---\n" . $extracted;
                    }
                 }
            }
            
            // Add description as fallback
            if (empty($text)) {
                $text .= "\n\nوصف المحاضرة:\n" . $lecture->description;
            }

            return $text;
        });
    }

    public function sendMessage()
    {
        $question = trim($this->userQuestion);
        
        if (empty($question)) return;

        // Add user message immediately
        $this->messages[] = ['role' => 'user', 'content' => $question];
        $this->userQuestion = '';
        $this->isLoading = true;

        // Get lecture content
        $lectureText = $this->getLectureContent();

        if (empty(trim($lectureText))) {
            $this->messages[] = [
                'role' => 'bot',
                'content' => 'عذراً، لا يوجد محتوى نصي (PDF) أو وصف كافٍ لهذه المحاضرة يمكنني التحليل بناءً عليه.'
            ];
            $this->isLoading = false;
            return;
        }

        $gemini = new GeminiService();
        $answer = $gemini->chatWithDocument($lectureText, $question);

        $this->messages[] = [
            'role' => 'bot',
            'content' => $answer
        ];
        
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.components.lecture-chat-bot');
    }
}
