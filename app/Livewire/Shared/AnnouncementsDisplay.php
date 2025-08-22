<?php

namespace App\Livewire\Shared;

use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AnnouncementsDisplay extends Component
{
    public function getAnnouncementsProperty()
    {
        $user = Auth::user();
        if (!$user) {
            return collect();
        }

        // بناء الاستعلام الأساسي
        $query = Announcement::where(function ($q) {
            // 1. جلب الإعلانات التي لم تنتهِ صلاحيتها بعد
            $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
        })->latest(); // الترتيب حسب الأحدث

        // بناء الاستعلام المخصص بناءً على دور المستخدم
        return $query->where(function ($q) use ($user) {
            // 2. الإعلانات العامة للجميع
            $q->orWhere('target_type', 'global_all');

            // 3. الإعلانات الخاصة بالدور (طلاب أو دكاترة)
           if ($user->isStudent()) {
                $q->orWhere('target_type', 'global_students');

                $student = $user->student;
                // نتأكد من أن الطالب لديه بيانات كاملة
                if ($student && $student->batch && $student->batch->specialization) {
                    $departmentId = $student->batch->specialization->department_id;
                    $specializationId = $student->batch->specialization_id;

                    // 💡 نستخدم الدالة الجديدة والموثوقة لجلب IDs المواد
                    $courseIds = $student->getCurrentCourses()->pluck('id')->toArray();

                    // بناء شروط الاستعلام
                    if ($departmentId) {
                        $q->orWhere(fn($subQ) => $subQ->where('target_type', 'department')->where('target_id', $departmentId));
                    }
                    if ($specializationId) {
                        $q->orWhere(fn($subQ) => $subQ->where('target_type', 'specialization')->where('target_id', $specializationId));
                    }
                    if (!empty($courseIds)) {
                        $q->orWhere(fn($subQ) => $subQ->where('target_type', 'course')->whereIn('target_id', $courseIds));
                    }
                }
            }

                            // الكود الصحيح
                if ($user->isDoctor()) {
                    $q->orWhere('target_type', 'global_doctors');

                    $doctor = $user->doctor;
                    if ($doctor) {
                        // [تصحيح] جلب المواد مع علاقاتها مرة واحدة لتحسين الأداء
                        $doctorCourses = $doctor->courses()->with('specializations.department')->get();

                        // [تصحيح] استخدام العلاقة الصحيحة `specializations` (بالجمع)
                        $departmentIds = $doctorCourses->pluck('specializations.*.department.id')->flatten()->unique()->filter();
                        $specializationIds = $doctorCourses->pluck('specializations.*.id')->flatten()->unique()->filter();
                        $courseIds = $doctorCourses->pluck('id')->unique()->toArray();

                    if ($departmentIds->isNotEmpty()) {
                        $q->orWhere(function ($subQ) use ($departmentIds) {
                            $subQ->where('target_type', 'department')->whereIn('target_id', $departmentIds);
                        });
                    }
                    if ($specializationIds->isNotEmpty()) {
                        $q->orWhere(function ($subQ) use ($specializationIds) {
                            $subQ->where('target_type', 'specialization')->whereIn('target_id', $specializationIds);
                        });
                    }
                    if (!empty($courseIds)) {
                        $q->orWhere(function ($subQ) use ($courseIds) {
                            $subQ->where('target_type', 'course')->whereIn('target_id', $courseIds);
                        });
                    }
                }
            }
        })->get();
    }

    public function render()
    {
        return view('livewire.shared.announcements-display');
    }
}
