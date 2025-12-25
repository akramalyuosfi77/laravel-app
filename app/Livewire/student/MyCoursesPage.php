<?php

namespace App\Livewire\Student;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Computed;

class MyCoursesPage extends Component
{
    /**
     * [تحسين الأداء]
     * خاصية محسوبة لجلب مواد الطالب مرة واحدة وتخزينها مؤقتاً.
     * هذا يمنع إعادة الاستعلام في كل تحديث للواجهة.
     */
    // ... داخل كلاس MyCoursesPage ...
// ... داخل كلاس MyCoursesPage ...

#[Computed]
public function courses()
{
    try {
        $student = Auth::user()->student;
        if (!$student) {
            return collect();
        }

        // [تصحيح] نستدعي الدالة التي ترجع استعلاماً ثم نبني عليه
        return $student->getCurrentCourses()
            ->withCount([
                'lectures',
                'discussions as open_discussions_count' => fn($q) => $q->where('status', 'open')
            ])
            ->get();
    } catch (\Exception $e) {
        Log::error('Error fetching student courses: ' . $e->getMessage());
        $this->dispatch('showToast', message: 'حدث خطأ أثناء جلب المقررات.', type: 'error');
        return collect();
    }
}


    public function render()
    {
        return view('livewire.student.my-courses-page');
    }
}