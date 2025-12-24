<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\SpecializationCourseAcademicPeriod;

class ScheduleController extends Controller
{
    /**
     * جلب قائمة الجداول الدراسية (مع الفلاتر)
     * GET /api/schedules
     */
    public function index(Request $request)
    {
        try {
            $query = Schedule::with([
                'coursePlan.course',
                'coursePlan.specialization',
                'coursePlan.doctor',
                'location'
            ]);

            // فلترة البحث
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->whereHas('coursePlan.course', fn($sq) => $sq->where('name', 'like', "%{$search}%"))
                      ->orWhereHas('location', fn($sq) => $sq->where('name', 'like', "%{$search}%"))
                      ->orWhereHas('coursePlan.doctor', fn($sq) => $sq->where('name', 'like', "%{$search}%"));
                });
            }

            $schedules = $query->latest()->get();

            return response()->json(['data' => $schedules]);

        } catch (\Throwable $e) {
            Log::error('API Error in ScheduleController@index: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ في الخادم'], 500);
        }
    }

    /**
     * جلب جدول دراسي واحد
     * GET /api/schedules/{id}
     */
    public function show($id)
    {
        try {
            $schedule = Schedule::with([
                'coursePlan.course',
                'coursePlan.specialization.department', // لجلب القسم أيضاً
                'coursePlan.doctor',
                'location'
            ])->find($id);

            if (!$schedule) {
                return response()->json(['message' => 'الجدول غير موجود'], 404);
            }
            return response()->json(['data' => $schedule]);
        } catch (\Throwable $e) {
            Log::error('API Error in ScheduleController@show: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ في الخادم'], 500);
        }
    }

    /**
     * إضافة جدول دراسي جديد
     * POST /api/schedules
     */
    public function store(Request $request)
    {
        // قواعد التحقق مأخوذة من كود Livewire
        $validator = Validator::make($request->all(), [
            'specialization_course_academic_period_id' => 'required|exists:specialization_course_academic_period,id',
            'location_id' => 'required|exists:locations,id',
            'day_of_week' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // يمكنك إضافة التحقق من التعارض هنا إذا أردت

        $schedule = Schedule::create($validator->validated());

        // جلب النسخة الكاملة من الجدول الجديد مع كل العلاقات
        $newSchedule = $this->show($schedule->id)->original;

        return response()->json([
            'message' => 'تم إضافة الموعد بنجاح',
            'data' => $newSchedule['data']
        ], 201);
    }

    /**
     * تحديث جدول دراسي
     * PUT /api/schedules/{id}
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return response()->json(['message' => 'الجدول غير موجود'], 404);
        }

        $validator = Validator::make($request->all(), [
            'specialization_course_academic_period_id' => 'sometimes|required|exists:specialization_course_academic_period,id',
            'location_id' => 'sometimes|required|exists:locations,id',
            'day_of_week' => 'sometimes|required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday',
            'start_time' => 'sometimes|required|date_format:H:i',
            'end_time' => 'sometimes|required|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $schedule->update($validator->validated());

        $updatedSchedule = $this->show($schedule->id)->original;

        return response()->json([
            'message' => 'تم تحديث الموعد بنجاح',
            'data' => $updatedSchedule['data']
        ]);
    }

    /**
     * حذف جدول دراسي
     * DELETE /api/schedules/{id}
     */
    public function destroy($id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return response()->json(['message' => 'الجدول غير موجود'], 404);
        }

        $schedule->delete();

        return response()->json(['message' => 'تم حذف الموعد بنجاح']);
    }
}
