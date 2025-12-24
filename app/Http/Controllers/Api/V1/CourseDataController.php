<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CourseDataController extends Controller
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
     * يجلب المواد الدراسية الحالية للطالب مع إحصائيات عنها.
     * (مبني على منطق MyCoursesPage.php الخاص بك)
     */
    public function getMyCourses(Request $request)
    {
        $user = $this->_getUserFromToken($request, 'student');

        if (!$user || !$user->student) {
            return response()->json(['message' => 'غير مصرح به أو لا يوجد ملف طالب.'], 401);
        }

        $student = $user->student;

        // --- ⭐ استخدام نفس منطقك الاحترافي من MyCoursesPage ---
        $myCourses = $student->getCurrentCourses()
            ->withCount([
                'lectures', // حساب عدد المحاضرات
                'discussions as open_discussions_count' => function ($query) {
                    $query->where('status', 'open'); // حساب عدد المناقشات المفتوحة
                }
            ])
            ->select('name', 'code') // نختار الحقول المهمة فقط
            ->get();

        return response()->json($myCourses);
    }
}
