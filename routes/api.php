<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController; // 💡 سنقوم باستيراد الكنترولر الذي سننشئه لاحقًا
use App\Http\Controllers\Api\BatchController;
use App\Http\Controllers\Api\DoctorController; // ✅ استيراد الكنترولر الجديد للدكاترة
use App\Http\Controllers\Api\StudentController; // ✅ استيراد الكنترولر الجديد للطلاب
use App\Http\Controllers\Api\CourseController;
// ✅ استيراد الكنترولر الجديد للمواد
use App\Http\Controllers\Api\AssignmentController; // ✅ استيراد الكنترولر الجديد للتكليفات
use App\Http\Controllers\Api\ProjectController; // ✅ استيراد الكنترولر الجديد للمشاريع
use App\Http\Controllers\Api\AnnouncementController; // ✅ استيراد الكنترولر الجديد للإعلانات
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\CoursePlanController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\UserController; // <-- تأكد من استيراده
use App\Http\Controllers\Api\DashboardController; // <-- تأكد من استيراده

use App\Http\Controllers\Api\V1\StudentAuthController;
use App\Http\Controllers\Api\V1\StudentDataController;
use App\Http\Controllers\Api\V1\ProjectDataController; // <-- ⭐ أضف هذا الاستيراد
use App\Http\Controllers\Api\V1\CourseDataController; // <-- ⭐ أضف هذا الاستيراد
use App\Http\Controllers\Api\V1\LectureDataController; // <-- ⭐ أضف هذا الاستيراد
use App\Http\Controllers\Api\V1\DiscussionDataController; // <-- ⭐ أضف هذا الاستيراد


// --- ⭐ أضف هذا السطر الجديد ---
Route::get('/v1/student/my-discussions', [DiscussionDataController::class, 'getMyDiscussions']);




// --- ⭐ أضف هذا السطر الجديد ---
Route::get('/v1/student/my-lectures', [LectureDataController::class, 'getMyLectures']);





Route::get('/v1/student/my-courses', [CourseDataController::class, 'getMyCourses']);


Route::middleware('auth:sanctum')->group(function () {


    // -- مسار مشترك --
    Route::post('/logout', [AuthController::class, 'logout']);

});



  // مسار تسجيل الخروج
    Route::post('/v1/student/logout', [StudentAuthController::class, 'logout']);

 Route::post('/v1/student/login', [StudentAuthController::class, 'login']);






Route::post('/manager/login', [AuthController::class, 'managerLogin']);
Route::post('/update-fcm-token', [AuthController::class, 'updateFcmToken']);

Route::apiResource('departments', App\Http\Controllers\Api\DepartmentController::class);
Route::apiResource('specializations', App\Http\Controllers\Api\SpecializationController::class);
   Route::get('/batches', [BatchController::class, 'index']);
    Route::post('/batches', [BatchController::class, 'store']);
    Route::put('/batches/{id}', [BatchController::class, 'update']);
    Route::delete('/batches/{id}', [BatchController::class, 'destroy']);
    Route::get('batches/{batch}', [App\Http\Controllers\Api\BatchController::class, 'show']);

        // ✅✅✅ --- أضف هذه المسارات الجديدة للدكاترة --- ✅✅✅
    Route::get('/doctors', [DoctorController::class, 'index']);      // جلب كل الدكاترة
    Route::post('/doctors', [DoctorController::class, 'store']);     // إضافة دكتور جديد
    Route::get('/doctors/{id}', [DoctorController::class, 'show']);    // جلب دكتور واحد (للتفاصيل)
    Route::post('/doctors/{id}', [DoctorController::class, 'update']);   // تحديث دكتور (استخدام POST لدعم الصور)
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy']);


    // ✅✅✅ --- أضف هذه المسارات الجديدة للطلاب --- ✅✅✅
    Route::get('/students', [StudentController::class, 'index']);      // جلب كل الطلاب مع الفلاتر
    Route::post('/students', [StudentController::class, 'store']);     // إضافة طالب جديد
    Route::get('/students/{id}', [StudentController::class, 'show']);    // جلب طالب واحد (للتفاصيل)
    Route::post('/students/{id}', [StudentController::class, 'update']);   // تحديث طالب (استخدام POST لدعم الصور)
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);// حذف طالب

        // ✅✅✅ --- مسارات إدارة المواد الدراسية (الجديدة) --- ✅✅✅
    Route::get('courses', [CourseController::class, 'index']);
    Route::post('courses', [CourseController::class, 'store']);
    Route::put('courses/{course}', [CourseController::class, 'update']);
    Route::delete('courses/{course}', [CourseController::class, 'destroy']);


    Route::apiResource('assignments', AssignmentController::class);
    // ✅✅✅ --- مسارات إدارة التكليفات (الجديدة) --- ✅✅✅
  Route::apiResource('submissions', App\Http\Controllers\Api\SubmissionController::class);
    Route::apiResource('projects', ProjectController::class);
Route::apiResource('announcements', AnnouncementController::class);

Route::apiResource('discussions', App\Http\Controllers\Api\DiscussionController::class);
Route::apiResource('schedules', controller: ScheduleController::class);

Route::apiResource('locations', LocationController::class);

    Route::apiResource('course-plans', CoursePlanController::class)->only(['index']); // أضف هذا السطر
Route::get('/manager/dashboard-stats', [App\Http\Controllers\Api\DashboardController::class, 'getStats']);
Route::apiResource('contact-messages', ContactMessageController::class)->only(['index', 'destroy']);

    Route::post('/users/manage', [UserController::class, 'handle']);

    Route::get('dashboard-stats', [DashboardController::class, 'getStats']);




    // --- المسار الجديد والنظيف لجلب الواجبات ---
    Route::get('/v1/student/assignments', [StudentDataController::class, 'getAssignments']);
Route::get('/v1/student/full-schedule', [StudentDataController::class, 'getFullSchedule']);
// ⚠️ تم نقل مسار الحضور إلى /v1/mobile/attendance (MobileAttendanceController)



// ... في ملف routes/api.php ...
Route::get('/v1/student/announcements', [StudentDataController::class, 'getAnnouncements']);



Route::get('/v1/student/my-projects', [ProjectDataController::class, 'getMyProjects']);

// ✅✅✅ --- مسارات تطبيق الجوال (Mobile App) --- ✅✅✅
Route::prefix('v1/mobile')->group(function () {
    // 1. جلب معلومات الدفعة (عام)
    Route::get('batch/{batch}', [App\Http\Controllers\Api\V1\MobileAuthController::class, 'getBatchInfo']);
    
    // 2. التسجيل السريع والانضمام (عام)
    Route::post('register', [App\Http\Controllers\Api\V1\MobileAuthController::class, 'registerWithBatch']);
    
    // 2.1 تسجيل عبر Google OAuth + Barcode (🆕)
    Route::post('register-google', [App\Http\Controllers\Api\V1\MobileAuthController::class, 'registerWithGoogleAndBatch']);
    
    // 3. تسجيل الدخول (عام)
    Route::post('login', [App\Http\Controllers\Api\V1\MobileAuthController::class, 'login']);

    // 4. جلب بيانات الطالب (محمي - الـ middleware في الكنترولر)
    Route::get('me', [App\Http\Controllers\Api\V1\MobileAuthController::class, 'getStudentInfo']);

    // 5. جلب بيانات لوحة التحكم (Dashboard) 📊 (🆕)
    Route::get('dashboard', [App\Http\Controllers\Api\V1\MobileDashboardController::class, 'index']);

    // 6. إدارة التكليفات (Assignments) 📝 (🆕)
    Route::get('assignments', [App\Http\Controllers\Api\V1\MobileAssignmentsController::class, 'index']);
    Route::get('assignments/{id}', [App\Http\Controllers\Api\V1\MobileAssignmentsController::class, 'show']);
    Route::post('assignments/{id}/submit', [App\Http\Controllers\Api\V1\MobileAssignmentsController::class, 'submit']);

    // 7. إدارة المشاريع (Projects) 🚀 (🆕)
    Route::get('projects/data/courses', [App\Http\Controllers\Api\V1\ProjectDataController::class, 'getCourses']); // 🆕 جلب المواد
    Route::get('projects/data/doctors', [App\Http\Controllers\Api\V1\ProjectDataController::class, 'getDoctors']); // 🆕 جلب الدكاترة
    Route::get('projects/data/students', [App\Http\Controllers\Api\V1\ProjectDataController::class, 'getStudents']); // 🆕 جلب طلاب الدفعة
    Route::get('projects', [App\Http\Controllers\Api\V1\MobileProjectsController::class, 'index']);
    Route::post('projects', [App\Http\Controllers\Api\V1\MobileProjectsController::class, 'store']);
    Route::get('projects/{id}', [App\Http\Controllers\Api\V1\MobileProjectsController::class, 'show']);
    Route::post('projects/{id}/invitation', [App\Http\Controllers\Api\V1\MobileProjectsController::class, 'respondToInvitation']);
    Route::post('projects/{id}/like', [App\Http\Controllers\Api\V1\MobileProjectsController::class, 'toggleLike']);
    Route::post('projects/{id}/comment', [App\Http\Controllers\Api\V1\MobileProjectsController::class, 'addComment']);
    Route::post('projects/{id}/update', [App\Http\Controllers\Api\V1\MobileProjectsController::class, 'update']); // 🆕 تعديل
    Route::delete('projects/{id}', [App\Http\Controllers\Api\V1\MobileProjectsController::class, 'destroy']); // 🆕 حذف

    // 8. سجل الحضور (Attendance) 📅 (🆕)
    Route::get('attendance', [App\Http\Controllers\Api\V1\MobileAttendanceController::class, 'index']);
    Route::get('attendance/{courseId}', [App\Http\Controllers\Api\V1\MobileAttendanceController::class, 'show']);
    Route::post('attendance/scan', [App\Http\Controllers\Api\V1\MobileAttendanceRecordController::class, 'scan']); // ✅ تسجيل حضور عبر QR
    
    // 9. قائمة المواد وحالة الحضور اليومي 📚 (🆕)
    Route::get('courses-attendance', [App\Http\Controllers\Api\V1\MobileCourseAttendanceController::class, 'index']);
    
    // 10. المحاضرات 📖 (🆕)
    Route::get('lectures', [App\Http\Controllers\Api\V1\MobileLecturesController::class, 'index']); // قائمة المواد
    Route::get('lectures/course/{courseId}', [App\Http\Controllers\Api\V1\MobileLecturesController::class, 'getCourseChapters']); // محاضرات المادة
    Route::get('lectures/{lectureId}', [App\Http\Controllers\Api\V1\MobileLecturesController::class, 'show']); // تفاصيل محاضرة
});
