<?php

namespace App\Livewire\Doctor;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Computed;

class MyCoursesPage extends Component
{
    /**
     * [تحسين الأداء]
     * خاصية محسوبة لجلب مواد الدكتور مرة واحدة وتخزينها مؤقتاً.
     * هذا يمنع إعادة الاستعلام في كل تحديث للواجهة.
     */
    #[Computed(cache: true)]
    public function courses()
    {
        try {
            $doctor = Auth::user()->doctor;
            if (!$doctor) {
                return collect(); // إرجاع مجموعة فارغة إذا لم يكن المستخدم دكتوراً
            }

            // جلب مواد الدكتور مع إحصائيات حية للمناقشات المفتوحة
            return $doctor->courses()
                ->withCount([
                    'discussions as open_discussions_count' => function ($query) {
                        $query->where('status', 'open');
                    }
                ])
                ->get();
        } catch (\Exception $e) {
            Log::error('Error fetching doctor courses: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء جلب المقررات.', type: 'error');
            return collect(); // إرجاع مجموعة فارغة في حالة حدوث خطأ
        }
    }

    public function render()
    {
        return view('livewire.doctor.my-courses-page');
    }
}
