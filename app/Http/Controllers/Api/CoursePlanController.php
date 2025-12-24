<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpecializationCourseAcademicPeriod;
use Illuminate\Support\Facades\Log;

class CoursePlanController extends Controller
{
    /**
     * جلب الخطط الدراسية بناءً على التخصص والمادة
     * GET /api/course-plans?specialization_id={id}&course_id={id}
     */
    public function index(Request $request)
    {
        try {
            // التحقق من وجود المدخلات المطلوبة
            $request->validate([
                'specialization_id' => 'required|integer|exists:specializations,id',
                'course_id' => 'required|integer|exists:courses,id',
            ]);

            $specializationId = $request->specialization_id;
            $courseId = $request->course_id;

            // جلب الخطط مع علاقة الدكتور
            $coursePlans = SpecializationCourseAcademicPeriod::with('doctor.user') // جلب الدكتور ومعلوماته الأساسية
                ->where('specialization_id', $specializationId)
                ->where('course_id', $courseId)
                ->get();

            return response()->json(['data' => $coursePlans]);

        } catch (\Throwable $e) {
            Log::error('API Error in CoursePlanController@index: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ في الخادم'], 500);
        }
    }
}
