<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Attendance;
use Laravel\Sanctum\PersonalAccessToken; // ✅ إضافة

class MobileAttendanceController extends Controller
{
    /**
     * Get attendance summary for all current courses.
     */
    public function index(Request $request)
    {
        try {
            $student = $this->getStudentFromToken($request); // ✅ تغيير
            if (!$student) {
                \Log::error('Attendance API: Student not found');
                return response()->json(['status' => false, 'message' => 'Student not found'], 404);
            }
            
            // ✅ تسجيل معلومات الطالب للتأكد
            \Log::info('Fetching attendance for student', [
                'student_id' => $student->id,
                'batch_id' => $student->batch_id,
                'current_year' => $student->current_academic_year,
                'current_semester' => $student->current_semester,
            ]);
            
            $courses = $student->getCurrentCourses()->get();
            
            \Log::info('Courses found', ['count' => $courses->count()]);
            
            $summary = [];

            foreach ($courses as $course) {
                $totalLectures = Lecture::where('course_id', $course->id)->count();
                
                if ($totalLectures > 0) {
                    $presentCount = Attendance::where('student_id', $student->id)
                        ->where('status', 'present')
                        ->whereHas('lecture', function ($query) use ($course) {
                            $query->where('course_id', $course->id);
                        })
                        ->count();

                    $percentage = ($presentCount / $totalLectures) * 100;
                } else {
                    $presentCount = 0;
                    $percentage = 100;
                }

                $summary[] = [
                    'course_id' => $course->id,
                    'course_name' => $course->name,
                    'course_code' => $course->code,
                    'total_lectures' => $totalLectures,
                    'present_count' => $presentCount,
                    'absent_count' => $totalLectures - $presentCount,
                    'percentage' => round($percentage),
                ];
            }

            return response()->json([
                'status' => true,
                'data' => $summary
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Attendance API Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, $courseId)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) {
            return response()->json(['status' => false, 'message' => 'Student not found'], 404);
        }
        
        try {
            $course = Course::findOrFail($courseId);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Course not found'], 404);
        }

        // Get all lectures for this course with doctor info
        $lectures = Lecture::where('course_id', $courseId)
            ->with('doctor')
            ->orderBy('lecture_date', 'desc')
            ->get();

        // Get attendance records for these lectures
        $attendanceRecords = Attendance::where('student_id', $student->id)
            ->whereIn('lecture_id', $lectures->pluck('id'))
            ->get()
            ->keyBy('lecture_id');

        $details = $lectures->map(function ($lecture) use ($attendanceRecords) {
            $attendance = $attendanceRecords->get($lecture->id);
            return [
                'lecture_id' => $lecture->id,
                'lecture_title' => $lecture->title,
                'lecture_date' => $lecture->lecture_date,
                'formatted_date' => \Carbon\Carbon::parse($lecture->lecture_date)->translatedFormat('l, d F Y'),
                'doctor_name' => $lecture->doctor ? $lecture->doctor->name : 'غير محدد',
                'status' => $attendance ? $attendance->status : 'absent',
                'attended_at' => $attendance ? $attendance->created_at->format('h:i A') : null,
            ];
        });

        // Get doctor name from first lecture
        $doctorName = $lectures->first() && $lectures->first()->doctor 
            ? $lectures->first()->doctor->name 
            : 'غير محدد';

        return response()->json([
            'status' => true,
            'data' => [
                'course_name' => $course->name,
                'course_code' => $course->code,
                'doctor_name' => $doctorName,
                'total_lectures' => $lectures->count(),
                'records' => $details
            ]
        ]);
    }

    /**
     * ✅ دالة مساعدة لجلب الطالب من التوكن (نفس طريقة MobileProjectsController)
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
