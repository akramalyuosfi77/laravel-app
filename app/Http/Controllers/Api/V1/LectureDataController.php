<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecture; // <-- استيراد موديل المحاضرات
use Laravel\Sanctum\PersonalAccessToken;

class LectureDataController extends Controller
{
    /**
     * دالة مساعدة خاصة للتحقق من التوكن وجلب المستخدم.
     */
    private function _getUserFromToken(Request $request, string $relationsToLoad = '')
    {
        $token = $request->bearerToken();
        if (!$token) return null;

        $accessToken = PersonalAccessToken::findToken($token);
        if (!$accessToken) return null;

        $user = $accessToken->tokenable;

        if ($user && !empty($relationsToLoad)) {
            $user->load($relationsToLoad);
        }

        return $user;
    }

    /**
     * يجلب آخر 10 محاضرات للطالب.
     * (مبني على منطق LecturesPage.php الخاص بك)
     */
    public function getMyLectures(Request $request)
    {
        $user = $this->_getUserFromToken($request, 'student');

        if (!$user || !$user->student) {
            return response()->json(['message' => 'غير مصرح به أو لا يوجد ملف طالب.'], 401);
        }

        $student = $user->student;

        // --- ⭐ استخدام نفس منطقك الاحترافي من LecturesPage ---
        $courseIds = $student->getCurrentCourses()->pluck('id');

        $lectures = Lecture::with('course') // لجلب اسم المادة مع المحاضرة
            ->whereIn('course_id', $courseIds)
            ->select('title', 'lecture_date', 'course_id') // نختار الحقول المهمة فقط
            ->latest() // الأحدث أولاً
            ->take(10)  // نأخذ آخر 10 محاضرات فقط
            ->get();

        return response()->json($lectures);
    }
}
