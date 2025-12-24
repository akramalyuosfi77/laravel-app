<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Discussion;
use Laravel\Sanctum\PersonalAccessToken;

class MobileDashboardController extends Controller
{
    /**
     * 📊 جلب بيانات لوحة التحكم للطالب (Dashboard)
     * تشمل: الإحصائيات، آخر النشاطات، ورسم بياني للدرجات
     */
    public function index(Request $request)
    {
        // 🔐 1. التحقق من التوكن يدوياً (حسب طلبك السابق)
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['status' => false, 'message' => 'غير مصدق عليه - لم يتم إرسال التوكن'], 401);
        }

        $accessToken = PersonalAccessToken::findToken($token);
        if (!$accessToken) {
            return response()->json(['status' => false, 'message' => 'التوكن غير صالح أو منتهي الصلاحية'], 401);
        }

        $user = $accessToken->tokenable;
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'المستخدم غير موجود'], 404);
        }

        $student = $user->student;
        if (!$student) {
            return response()->json(['status' => false, 'message' => 'لا توجد بيانات طالب لهذا المستخدم'], 404);
        }

        try {
            // 📊 2. جلب الإحصائيات (Stats)
            $currentCourses = $student->getCurrentCourses()->get();
            $submittedAssignmentIds = $student->submissions()->pluck('assignment_id');
            
            $pendingAssignmentsCount = Assignment::whereIn('course_id', $currentCourses->pluck('id'))
                ->whereNotIn('id', $submittedAssignmentIds)
                ->where('deadline', '>=', now())
                ->count();

            $stats = [
                'current_courses_count'     => $currentCourses->count(),
                'active_projects_count'     => $student->projects()->where('status', 'in_progress')->count(),
                'pending_assignments_count' => $pendingAssignmentsCount,
                'my_discussions_count'      => Discussion::where('student_id', $student->id)->count(),
            ];

            // 🔔 3. جلب الأنشطة الأخيرة (Recent Activities)
            $recentActivities = $user->notifications()->latest()->take(5)->get()->map(function ($notification) {
                return [
                    'id'         => $notification->id,
                    'title'      => $this->getNotificationTitle($notification), // دالة مساعدة للعنوان
                    'body'       => $this->getNotificationBody($notification),   // دالة مساعدة للمحتوى
                    'type'       => $notification->type,
                    'read_at'    => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans(), // وقت مقروء (مثلاً: منذ دقيقتين)
                ];
            });

            // 📈 4. جلب بيانات الرسم البياني للدرجات (Grades Chart)
            $latestGrades = $student->submissions()
                ->whereNotNull('grade')
                ->with('assignment:id,title')
                ->latest('updated_at')
                ->take(5)
                ->get()
                ->reverse() // لعرض الأقدم فالأحدث في الرسم البياني
                ->values();

            $gradesChart = [
                'labels'   => $latestGrades->map(fn($sub) => $sub->assignment->title ?? 'تكليف')->toArray(),
                'data'     => $latestGrades->pluck('grade')->toArray(),
                'feedback' => $latestGrades->map(fn($sub) => $sub->feedback ?: 'لا يوجد ملاحظات')->toArray(),
            ];

            return response()->json([
                'status' => true,
                'message' => 'تم جلب بيانات لوحة التحكم بنجاح',
                'data'   => [
                    'stats'             => $stats,
                    'recent_activities' => $recentActivities,
                    'grades_chart'      => $gradesChart,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * استخراج عنوان للإشعار بناءً على نوعه
     */
    private function getNotificationTitle($notification)
    {
        // يمكنك تخصيص العناوين حسب نوع الإشعار هنا
        $data = $notification->data;
        return $data['title'] ?? 'إشعار جديد';
    }

    /**
     * استخراج نص للإشعار
     */
    private function getNotificationBody($notification)
    {
        $data = $notification->data;
        return $data['message'] ?? $data['body'] ?? 'لديك إشعار جديد';
    }
}
