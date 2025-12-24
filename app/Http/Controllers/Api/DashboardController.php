<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

// --- استيراد كل الموديلات المطلوبة ---
use App\Models\Student;
use App\Models\Doctor;
use App\Models\Course;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Batch;
use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\Schedule; // تم تغيير الاسم من Lecture إلى Schedule ليتوافق مع الموديلات السابقة
use App\Models\Project;
use App\Models\Submission;
use App\Models\Discussion;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * جلب كل إحصائيات لوحة التحكم للمدير
     * GET /api/manager/dashboard-stats
     */
    public function getStats(Request $request)
    {
        try {
            $stats = [
                // 1. الإحصائيات الرئيسية (12 بطاقة)
                'totalStudents' => Student::count(),
                'totalDoctors' => Doctor::count(),
                'totalCourses' => Course::count(),
                'totalDepartments' => Department::count(),
                'totalSpecializations' => Specialization::count(),
                'totalBatches' => Batch::count(),
                'totalAnnouncements' => Announcement::count(),
                'totalAssignments' => Assignment::count(),
                'totalSchedules' => Schedule::count(), // تم تغيير الاسم
                'totalProjects' => Project::count(),
                'totalSubmissions' => Submission::count(),
                'totalDiscussions' => Discussion::count(),

                // 2. إحصائيات حالة المشاريع
                'pendingProjectsCount' => Project::where("status", "pending")->count(),
                'approvedProjectsCount' => Project::where("status", "approved")->count(),
                'rejectedProjectsCount' => Project::where("status", "rejected")->count(),
                'completedProjectsCount' => Project::where("status", "completed")->count(),

                // 3. إحصائيات حالة الطلاب
                'activeStudentsCount' => Student::where("status", "نشط")->count(),
                'graduatedStudentsCount' => Student::where("status", "متخرج")->count(),
                'suspendedStudentsCount' => Student::where("status", "موقوف")->count(),
                'withdrawnStudentsCount' => Student::where("status", "منسحب")->count(),

                // 4. إحصائيات مستويات الإعلانات
                'infoAnnouncementsCount' => Announcement::where("level", "info")->count(),
                'successAnnouncementsCount' => Announcement::where("level", "success")->count(),
                'warningAnnouncementsCount' => Announcement::where("level", "warning")->count(),
                'dangerAnnouncementsCount' => Announcement::where("level", "danger")->count(),

                // 5. إحصائيات إضافية متنوعة
                'assignmentsDueSoonCount' => Assignment::where("deadline", ">=", Carbon::now())
                                                    ->where("deadline", "<=", Carbon::now()->addDays(7))
                                                    ->count(),
                'recentDiscussionsCount' => Discussion::where("created_at", ">=", Carbon::now()->subDays(7))->count(),
                'pendingSubmissionsCount' => Submission::where("status", "pending")->count(),
                'gradedSubmissionsCount' => Submission::where("status", "graded")->count(),
                'totalUsers' => User::count(),
                'newStudentsThisMonth' => Student::whereMonth("created_at", Carbon::now()->month)
                                                ->whereYear("created_at", Carbon::now()->year)
                                                ->count(),
                'newDoctorsThisMonth' => Doctor::whereMonth("created_at", Carbon::now()->month)
                                            ->whereYear("created_at", Carbon::now()->year)
                                            ->count(),
                'activeAnnouncementsCount' => Announcement::where(function ($query) {
                                                $query->whereNull("expires_at")
                                                      ->orWhere("expires_at", ">=", Carbon::now());
                                            })->count(),
            ];

            // إرجاع البيانات كـ JSON
            return response()->json(['data' => $stats]);

        } catch (\Throwable $e) {
            // في حال حدوث خطأ، سجل الخطأ وأرجع رسالة خطأ واضحة
            Log::error('API Error in DashboardController@getStats: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ في الخادم أثناء جلب الإحصائيات'], 500);
        }
    }
}
