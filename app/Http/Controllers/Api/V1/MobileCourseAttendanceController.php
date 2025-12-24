<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Attendance;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

class MobileCourseAttendanceController extends Controller
{
    /**
     * جلب قائمة المواد مع حالة الحضور لليوم
     */
    public function index(Request $request)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) {
            \Log::warning('Mobile Courses Attendance: No student found from token');
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        \Log::info('Mobile Courses Attendance Request', [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'batch_id' => $student->batch_id,
        ]);

        // جلب المواد المرتبطة بتخصص الطالب
        // المواد في جدول courses مرتبطة بـ specialization_id وليس batch_id
        
        $courses = Course::where('specialization_id', $student->specialization_id)
            ->get();

        \Log::info('Courses Found', [
            'count' => $courses->count(),
            'specialization_id' => $student->specialization_id,
            'student_id' => $student->id,
        ]);

        $today = Carbon::today();

        $data = $courses->map(function ($course) use ($student, $today) {
            // 1. هل توجد محاضرة لهذا الكورس اليوم؟
            $todaysLecture = Lecture::where('course_id', $course->id)
                ->whereDate('lecture_date', $today)
                ->with('doctor') // نجلب معلومات الدكتور من المحاضرة
                ->first();

            // 2. هل سجل الطالب حضوراً فيها؟
            $isPresent = false;
            if ($todaysLecture) {
                $isPresent = Attendance::where('lecture_id', $todaysLecture->id)
                    ->where('student_id', $student->id)
                    ->exists();
            }

            // 3. اسم الدكتور من المحاضرة (أو من أول محاضرة للمادة)
            $doctorName = 'غير محدد';
            if ($todaysLecture && $todaysLecture->doctor) {
                $doctorName = $todaysLecture->doctor->name;
            } else {
                // جلب أي دكتور من محاضرات هذه المادة
                $anyLecture = Lecture::where('course_id', $course->id)
                    ->with('doctor')
                    ->first();
                if ($anyLecture && $anyLecture->doctor) {
                    $doctorName = $anyLecture->doctor->name;
                }
            }

            return [
                'id' => $course->id,
                'name' => $course->name,
                'code' => $course->code ?? '',
                'doctor_name' => $doctorName,
                'doctor_image' => null, // يمكن إضافتها لاحقاً
                'has_lecture_today' => $todaysLecture ? true : false,
                'is_present_today' => $isPresent,
                'lecture_id' => $todaysLecture ? $todaysLecture->id : null,
                'lecture_time' => $todaysLecture ? Carbon::parse($todaysLecture->created_at)->format('h:i A') : null,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'تم جلب قائمة المواد وحالة الحضور بنجاح',
            'data' => $data
        ]);
    }

    /**
     * دالة مساعدة لجلب الطالب من التوكن
     */
    private function getStudentFromToken(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) return null;
        
        $accessToken = PersonalAccessToken::findToken($token);
        if (!$accessToken || !$accessToken->tokenable) return null;
        
        return $accessToken->tokenable->student;
    }
}
