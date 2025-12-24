<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lecture;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

class MobileLecturesController extends Controller
{
    /**
     * 1️⃣ جلب قائمة المواد مع عدد المحاضرات لكل مادة
     * GET /v1/mobile/lectures
     */
    public function index(Request $request)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        // جلب المواد الخاصة بتخصص الطالب
        $courses = Course::where('specialization_id', $student->specialization_id)
            ->get();

        $data = $courses->map(function ($course) {
            // عدد المحاضرات لكل مادة
            $lecturesCount = Lecture::where('course_id', $course->id)->count();
            
            // آخر محاضرة
            $lastLecture = Lecture::where('course_id', $course->id)
                ->orderBy('lecture_date', 'desc')
                ->first();

            // جلب اسم الدكتور من آخر محاضرة
            $doctorName = 'غير محدد';
            if ($lastLecture && $lastLecture->doctor) {
                $doctorName = $lastLecture->doctor->name;
            }

            return [
                'id' => $course->id,
                'name' => $course->name,
                'code' => $course->code ?? '',
                'doctor_name' => $doctorName,
                'lectures_count' => $lecturesCount,
                'last_lecture_date' => $lastLecture ? $lastLecture->lecture_date : null,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'تم جلب قائمة المواد بنجاح',
            'data' => $data
        ]);
    }

    /**
     * 2️⃣ جلب محاضرات مادة معينة
     * GET /v1/mobile/lectures/course/{courseId}
     */
    public function getCourseChapters(Request $request, $courseId)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        try {
            $course = Course::findOrFail($courseId);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'المادة غير موجودة'], 404);
        }

        // جلب المحاضرات مع معلومات الدكتور والملفات
        $lectures = Lecture::where('course_id', $courseId)
            ->with(['doctor', 'files']) // ⭐ جلب الملفات من العلاقة
            ->orderBy('lecture_date', 'desc')
            ->get();

        $lecturesData = $lectures->map(function ($lecture) {
            // ⭐ جلب أول ملف من المحاضرة (إذا موجود)
            $firstFile = $lecture->files->first();
            $filePath = null;
            $hasFile = false;
            
            if ($firstFile && !empty($firstFile->file_path)) {
                $filePath = url('storage/' . $firstFile->file_path);
                $hasFile = true;
            }

            return [
                'id' => $lecture->id,
                'title' => $lecture->title ?? 'بدون عنوان',
                'description' => $lecture->description ?? '',
                'lecture_date' => $lecture->lecture_date,
                'formatted_date' => Carbon::parse($lecture->lecture_date)->translatedFormat('l, d F Y'),
                'doctor_name' => $lecture->doctor ? $lecture->doctor->name : 'غير محدد',
                'doctor_image' => $lecture->doctor && $lecture->doctor->image ? url('storage/' . $lecture->doctor->image) : null,
                'file_path' => $filePath,      // ⭐ Full URL من جدول lecture_files
                'has_file' => $hasFile,        // ⭐ Boolean
                'files_count' => $lecture->files->count(), // ⭐ عدد الملفات
                'created_at' => Carbon::parse($lecture->created_at)->format('Y-m-d H:i'),
            ];
        });

        // معلومات المادة
        $doctorName = 'غير محدد';
        if ($lectures->first() && $lectures->first()->doctor) {
            $doctorName = $lectures->first()->doctor->name;
        }

        return response()->json([
            'status' => true,
            'message' => 'تم جلب المحاضرات بنجاح',
            'data' => [
                'course_id' => $course->id,
                'course_name' => $course->name,
                'course_code' => $course->code,
                'doctor_name' => $doctorName,
                'total_lectures' => $lectures->count(),
                'lectures' => $lecturesData,
            ]
        ]);
    }

    /**
     * 3️⃣ جلب تفاصيل محاضرة معينة
     * GET /v1/mobile/lectures/{lectureId}
     */
    public function show(Request $request, $lectureId)
    {
        $student = $this->getStudentFromToken($request);
        if (!$student) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        try {
            $lecture = Lecture::with(['doctor', 'course', 'files'])->findOrFail($lectureId);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'المحاضرة غير موجودة'], 404);
        }

        // ⭐ جلب أول ملف من المحاضرة (إذا موجود)
        $firstFile = $lecture->files->first();
        $filePath = null;
        $fileName = null;
        $hasFile = false;
        
        if ($firstFile && !empty($firstFile->file_path)) {
            $filePath = url('storage/' . $firstFile->file_path);
            $fileName = basename($firstFile->file_path);
            $hasFile = true;
        }

        $data = [
            'id' => $lecture->id,
            'title' => $lecture->title ?? 'بدون عنوان',
            'description' => $lecture->description ?? '',
            'lecture_date' => $lecture->lecture_date,
            'formatted_date' => Carbon::parse($lecture->lecture_date)->translatedFormat('l, d F Y'),
            'course_name' => $lecture->course->name,
            'course_code' => $lecture->course->code,
            'doctor_name' => $lecture->doctor ? $lecture->doctor->name : 'غير محدد',
            'doctor_image' => $lecture->doctor && $lecture->doctor->image ? url('storage/' . $lecture->doctor->image) : null,
            'file_path' => $filePath,     // ⭐ Full URL
            'file_name' => $fileName,     // ⭐ اسم الملف
            'has_file' => $hasFile,       // ⭐ Boolean
            'files_count' => $lecture->files->count(), // ⭐ عدد الملفات
            'created_at' => Carbon::parse($lecture->created_at)->format('Y-m-d H:i'),
        ];

        return response()->json([
            'status' => true,
            'message' => 'تم جلب تفاصيل المحاضرة بنجاح',
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
