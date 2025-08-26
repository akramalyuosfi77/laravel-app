<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// استيراد مكونات لوحة تحكم المدير (Admin)
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\AnnouncementsPage;
use App\Livewire\Admin\AssignmentsPage as AdminAssignmentsPage;
use App\Livewire\Admin\BatchesPage;
use App\Livewire\Admin\ContactMessagesPage;
use App\Livewire\Admin\CoursesPage;
use App\Livewire\Admin\DepartmentsPage;
use App\Livewire\Admin\DiscussionsManagementPage;
use App\Livewire\Admin\DoctorsPage;
use App\Livewire\Admin\LecturesPage as AdminLecturesPage;
use App\Livewire\Admin\LocationsPage;
use App\Livewire\Admin\ProjectsPage as AdminProjectsPage;
use App\Livewire\Admin\Reports\AttendanceReportPage;
use App\Livewire\Admin\Reports\ReportCenter;
use App\Livewire\Admin\SchedulesPage as AdminSchedulesPage;
use App\Livewire\Admin\SpecializationsPage;
use App\Livewire\Admin\StudentsPage;
use App\Livewire\Admin\SubmissionsPage as AdminSubmissionsPage;
use App\Livewire\Admin\UsersManagement;

// استيراد مكونات لوحة تحكم الدكتور (Doctor)
use App\Livewire\Doctor\DoctorDashboard;
use App\Livewire\Doctor\DoctorAssignmentsPage;
use App\Livewire\Doctor\DoctorProjectsPage;
use App\Livewire\Doctor\LecturesPage as DoctorLecturesPage;
use App\Livewire\Doctor\MyCoursesPage as DoctorMyCoursesPage;
use App\Livewire\Doctor\CourseDiscussionsPage as DoctorCourseDiscussionsPage;
use App\Livewire\Doctor\MySchedulePage as DoctorMySchedulePage;
use App\Livewire\Doctor\Reports\CourseReportPage;

// استيراد مكونات لوحة تحكم الطالب (Student)
use App\Livewire\Student\StudentDashboard;
use App\Livewire\Student\StudentAssignmentsPage;
use App\Livewire\Student\StudentProjectsPage;
use App\Livewire\Student\LecturesPage as StudentLecturesPage;
use App\Livewire\Student\CourseDiscussionsPage as StudentCourseDiscussionsPage;
use App\Livewire\Student\MyCoursesPage;
use App\Livewire\Student\MySchedulePage as StudentMySchedulePage;
use App\Livewire\Student\MyAttendancePage;
use App\Livewire\Student\ProfilePage;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/contact', 'contact')->name('contact');

// --- مسارات المدير (Admin) ---
Route::middleware(['auth', 'role:admin', 'verified', 'throttle:20,1'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/departments', DepartmentsPage::class)->name('departments');
    Route::get('/specializations', SpecializationsPage::class)->name('specializations');
    Route::get('/batches', BatchesPage::class)->name('batches');
    Route::get('/courses', CoursesPage::class)->name('courses');
    Route::get('/doctor', DoctorsPage::class)->name('doctor');
    Route::get('/students', StudentsPage::class)->name('Students');
    Route::get('/assignments', AdminAssignmentsPage::class)->name('assignments');
    Route::get('/submissions', AdminSubmissionsPage::class)->name('submissions');
    Route::get('/projects', AdminProjectsPage::class)->name('projects');
    Route::get('/lectures', AdminLecturesPage::class)->name('lectures');
    Route::get('/users', UsersManagement::class)->name('users');
    Route::get('/contact-messages', ContactMessagesPage::class)->name('contact-messages');
    Route::get('/discussions-management', DiscussionsManagementPage::class)->name('discussions.management');
    Route::get('schedules', AdminSchedulesPage::class)->name('schedules');
    Route::get('locations', LocationsPage::class)->name('locations');
    Route::get('/reports', ReportCenter::class)->name('reports.center');
    Route::get('reports/attendance', AttendanceReportPage::class)->name('reports.attendance');
    Volt::route('/announcements', 'admin.announcements-page')->name('announcements');
});

// --- مسارات الدكتور (Doctor) ---
Route::middleware(['auth', 'role:doctor', 'verified', 'throttle:20,1'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', DoctorDashboard::class)->name('dashboard');
    Route::get('assignments', DoctorAssignmentsPage::class)->name('assignments');
    Route::get('/projects', DoctorProjectsPage::class)->name('projects');
    Route::get('/lectures', DoctorLecturesPage::class)->name('lectures');
    Route::get('/my-courses', DoctorMyCoursesPage::class)->name('courses.index');
    Route::get('/courses/{course}/discussions', DoctorCourseDiscussionsPage::class)->name('courses.discussions');
    Route::get('my-schedule', DoctorMySchedulePage::class)->name('my-schedule');
    Route::get('/reports', CourseReportPage::class)->name('reports.course');
    Volt::route('announcements', 'doctor.announcements-page')->name('announcements');
});

// --- مسارات الطالب (Student) ---
Route::middleware(['auth', 'role:student', 'verified', 'throttle:20,1'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', StudentDashboard::class)->name('dashboard');
    Route::get('/assignments', StudentAssignmentsPage::class)->name('assignments');
    Route::get('/projects', StudentProjectsPage::class)->name('projects');
    Route::get('/lectures', StudentLecturesPage::class)->name('lectures');
    Route::get('/my-courses', MyCoursesPage::class)->name('my-courses');
    Route::get('/courses/{course}/discussions', StudentCourseDiscussionsPage::class)->name('courses.discussions');
    Route::get('my-schedule', StudentMySchedulePage::class)->name('my-schedule');
    Route::get('/my-attendance', MyAttendancePage::class)->name('attendance');
    Route::get('/profile', ProfilePage::class)->name('profile');
});

// --- مسارات الإعدادات العامة والمصادقة ---
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';


// ==========================================================
// ==   مسار مؤقت لتشخيص مشكلة ملفات build على Render   ==
// ==========================================================
use Illuminate\Support\Facades\File;

Route::get('/debug-render-files', function () {
    $path = public_path('build');

    if (!File::exists($path)) {
        return response('Directory not found: ' . $path, 404);
    }

    if (!File::isDirectory($path)) {
        return response('Path exists, but is not a directory: ' . $path, 500);
    }

    $files = File::allFiles($path);
    $output = '<h1>Files in ' . $path . '</h1>';
    $output .= '<ul>';

    if (empty($files)) {
        $output .= '<li>Directory is empty.</li>';
    } else {
        foreach ($files as $file) {
            $output .= '<li>' . $file->getPathname() . ' (' . $file->getSize() . ' bytes)</li>';
        }
    }

    $output .= '</ul>';

    // تحقق من وجود manifest.json تحديداً
    $manifestPath = public_path('build/manifest.json');
    if (File::exists($manifestPath)) {
        $output .= '<h2>Manifest.json FOUND!</h2>';
        $output .= '<pre>' . File::get($manifestPath) . '</pre>';
    } else {
        $output .= '<h2>Manifest.json NOT FOUND at ' . $manifestPath . '</h2>';
    }

    return $output;
});

