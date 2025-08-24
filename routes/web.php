<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// استيراد مكونات لوحة تحكم المدير (Admin)
use App\Livewire\admin\AdminDashboard;
use App\Livewire\admin\AnnouncementsPage;
use App\Livewire\admin\AssignmentsPage as AdminAssignmentsPage;
use App\Livewire\admin\BatchesPage;
use App\Livewire\admin\ContactMessagesPage;
use App\Livewire\admin\CoursesPage;
use App\Livewire\admin\DepartmentsPage;
use App\Livewire\admin\DiscussionsManagementPage;
use App\Livewire\admin\DoctorsPage;
use App\Livewire\admin\LecturesPage as AdminLecturesPage;
use App\Livewire\admin\LocationsPage;
use App\Livewire\admin\ProjectsPage as AdminProjectsPage;
use App\Livewire\admin\Reports\AttendanceReportPage;
use App\Livewire\admin\Reports\ReportCenter;
use App\Livewire\admin\SchedulesPage as AdminSchedulesPage;
use App\Livewire\admin\SpecializationsPage;
use App\Livewire\admin\StudentsPage;
use App\Livewire\admin\SubmissionsPage as AdminSubmissionsPage;
use App\Livewire\admin\UsersManagement;

// استيراد مكونات لوحة تحكم الدكتور (Doctor)
use App\Livewire\doctor\DoctorDashboard;
use App\Livewire\doctor\DoctorAssignmentsPage;
use App\Livewire\doctor\DoctorProjectsPage;
use App\Livewire\doctor\LecturesPage as DoctorLecturesPage;
use App\Livewire\doctor\MyCoursesPage as DoctorMyCoursesPage;
use App\Livewire\doctor\CourseDiscussionsPage as DoctorCourseDiscussionsPage;
use App\Livewire\doctor\MySchedulePage as DoctorMySchedulePage;
use App\Livewire\doctor\Reports\CourseReportPage;

// استيراد مكونات لوحة تحكم الطالب (Student)
use App\Livewire\student\StudentDashboard;
use App\Livewire\student\StudentAssignmentsPage;
use App\Livewire\student\StudentProjectsPage;
use App\Livewire\student\LecturesPage as StudentLecturesPage;
use App\Livewire\student\CourseDiscussionsPage as StudentCourseDiscussionsPage;
use App\Livewire\student\MyCoursesPage;
use App\Livewire\student\MySchedulePage as StudentMySchedulePage;
use App\Livewire\student\MyAttendancePage;
use App\Livewire\student\ProfilePage;


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
