<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecture;
use App\Models\Attendance;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Log;

class MobileAttendanceRecordController extends Controller
{
    /**
     * 📷 تسجيل الحضور عبر مسح QR Code
     */
    public function scan(Request $request)
    {
        try {
            // ✅ 1. الحصول على الطالب من التوكن
            $student = $this->getStudentFromToken($request);
            if (!$student) {
                return response()->json([
                    'status' => false,
                    'message' => 'غير مصرح لك بالوصول'
                ], 401);
            }

            // ✅ 2. التحقق من صحة البيانات
            $request->validate([
                'qr_token' => 'required|string',
            ]);

            // ✅ 3. البحث عن المحاضرة بواسطة QR token
            Log::info('QR Scan Attempt', [
                'received_token' => $request->qr_token,
                'student_id' => $student->id
            ]);

            $lecture = Lecture::where('qr_token', $request->qr_token)->first();

            if (!$lecture) {
                Log::warning('QR Scan Failed: Token not found', [
                    'received_token' => $request->qr_token,
                    'available_tokens' => Lecture::whereNotNull('qr_token')->pluck('qr_token')->toArray() // للتجربة فقط (احذفه لاحقاً)
                ]);

                return response()->json([
                    'status' => false,
                    'message' => 'رمز QR غير صالح: ' . $request->qr_token // إضافة التوكن للرسالة للتأكد
                ], 404);
            }

            // ✅ 4. التحقق من صلاحية QR
            if (!$lecture->isQrValid()) {
                $message = 'رمز QR منتهي الصلاحية أو غير مفعّل';
                
                if ($lecture->qr_expires_at && now()->isAfter($lecture->qr_expires_at)) {
                    $message = 'انتهت صلاحية رمز QR. يرجى التواصل مع الدكتور.';
                } elseif (!$lecture->attendance_enabled) {
                    $message = 'تسجيل الحضور غير مفعّل لهذه المحاضرة';
                }

                return response()->json([
                    'status' => false,
                    'message' => $message
                ], 400);
            }

            // ✅ 5. التحقق من عدم تسجيل الحضور مسبقاً
            $existingAttendance = Attendance::where('lecture_id', $lecture->id)
                ->where('student_id', $student->id)
                ->first();

            if ($existingAttendance) {
                return response()->json([
                    'status' => false,
                    'message' => 'تم تسجيل حضورك مسبقاً في هذه المحاضرة',
                    'data' => [
                        'lecture_title' => $lecture->title,
                        'course_name' => $lecture->course->name ?? '',
                        'recorded_at' => $existingAttendance->created_at->format('Y-m-d H:i:s'),
                        'status' => $existingAttendance->status,
                    ]
                ], 400);
            }

            // ✅ 6. تسجيل الحضور
            $attendance = Attendance::create([
                'lecture_id' => $lecture->id,
                'student_id' => $student->id,
                'status' => 'present',
                'notes' => 'تم التسجيل عبر QR Code من التطبيق',
            ]);

            // ✅ 7. تسجيل في اللوج
            Log::info('Attendance recorded via QR', [
                'student_id' => $student->id,
                'lecture_id' => $lecture->id,
                'qr_token' => $request->qr_token,
            ]);

            // ✅ 8. إرجاع الاستجابة
            return response()->json([
                'status' => true,
                'message' => '✅ تم تسجيل حضورك بنجاح',
                'data' => [
                    'lecture_title' => $lecture->title,
                    'course_name' => $lecture->course->name ?? '',
                    'doctor_name' => $lecture->doctor->name ?? '',
                    'lecture_date' => $lecture->lecture_date,
                    'recorded_at' => $attendance->created_at->format('Y-m-d H:i:s'),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('QR Attendance Scan Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء تسجيل الحضور: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ دالة مساعدة لجلب الطالب من التوكن
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
