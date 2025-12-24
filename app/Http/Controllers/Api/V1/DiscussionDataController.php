<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discussion; // <-- استيراد موديل المناقشات
use Laravel\Sanctum\PersonalAccessToken;

class DiscussionDataController extends Controller
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
     * يجلب آخر 5 مناقشات في مواد الطالب الحالية.
     */
    public function getMyDiscussions(Request $request)
    {
        $user = $this->_getUserFromToken($request, 'student');

        if (!$user || !$user->student) {
            return response()->json(['message' => 'غير مصرح به أو لا يوجد ملف طالب.'], 401);
        }

        $student = $user->student;
        $courseIds = $student->getCurrentCourses()->pluck('id');

        $discussions = Discussion::with(['course', 'student']) // لجلب اسم المادة واسم الطالب
            ->whereIn('course_id', $courseIds)
            ->withCount('replies') // لحساب عدد الردود
            ->select('title', 'status', 'course_id', 'student_id') // نختار الحقول المهمة
            ->latest() // الأحدث أولاً
            ->take(5)  // نأخذ آخر 5 مناقشات فقط
            ->get();

        return response()->json($discussions);
    }
}
