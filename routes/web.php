<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\admin\DepartmentsPage;
use App\Livewire\admin\SpecializationsPage; // تأكد من استيراد المكون
use App\Livewire\admin\BatchesPage; // تأكد من استيراد المكون في بداية الملف
use App\Livewire\admin\CoursesPage; // تأكد من استيراد المكون في بداية الملف
use App\Livewire\admin\DoctorsPage; // تأكد من استيراد المكون في بداية الملف
use App\Livewire\admin\StudentsPage; // تأكد من استيراد المكون في بداية الملف
use App\Livewire\admin\AdminDashboard; // تأكد من استيراد المكون في بداية الملف
use App\Livewire\admin\AnnouncementsPage; // تأكد من استيراد المكون في بداية الملف
use App\Livewire\Student\CourseDiscussionsPage;
use App\Livewire\Student\MyCoursesPage;



use App\Livewire\doctor\DoctorDashboard;
use App\Livewire\student\StudentDashboard;
use App\Livewire\doctor\LecturesPage; // تأكد من استيراد المكون في بداية الملف
use App\Livewire\doctor\AnnouncementsPage as AnnouncementsPageDoctor; // تأكد من استيراد المكون في بداية الملف
use App\Livewire\admin\LecturesPage as LecturesPageadmin; // تأكد من استيراد المكون في بداية الملف
use App\Livewire\admin\UsersManagement; // تأكد من استيراد المكون في بداية الملف


use App\Livewire\student\LecturesPage as LecturesPagestudent; // تأكد من استيراد المكون في بداية الملف
use App\Livewire\Student\MyAttendancePage;


use App\Livewire\student\StudentAssignmentsPage; // تأكد من استيراد المكون
use App\Livewire\Admin\Reports\AttendanceReportPage;



Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::view('/contact', 'contact')->name('contact');



Route::middleware(['auth', 'role:admin','verified','throttle:20,1'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/batches', BatchesPage::class)->name('batches');
    Route::get('/specializations', SpecializationsPage::class)->name('specializations');
    Route::get('/departments', DepartmentsPage::class)->name('departments');
    Route::get('/courses', CoursesPage::class)->name('courses');
    Route::get('/doctor', DoctorsPage::class)->name('doctor');
    Route::get('/students', StudentsPage::class)->name('Students');
    Route::get('/assignments', App\Livewire\admin\AssignmentsPage::class)->name('assignments');
    Route::get('/submissions', App\Livewire\admin\SubmissionsPage::class)->name('submissions');
    Route::get('/projects', App\Livewire\admin\ProjectsPage::class)->name('projects');
    Route::get('/lectures', LecturesPageadmin::class)->name('lectures'); // المسار الجديد
    Route::get('/users', UsersManagement::class)->name('users'); // المسار الجديد
    Volt::route('/announcements', 'admin.announcements-page')->name('announcements');
    Route::get('/contact-messages', \App\Livewire\Admin\ContactMessagesPage::class)->name('contact-messages');
    Route::get('/discussions-management', \App\Livewire\Admin\DiscussionsManagementPage::class)->name('discussions.management');
    Route::get('schedules', \App\Livewire\Admin\SchedulesPage::class)->name('schedules');
    Route::get('locations', \App\Livewire\Admin\LocationsPage::class)->name('locations');
    Route::get('/reports', \App\Livewire\Admin\Reports\ReportCenter::class)->name('reports.center');
    Route::get('reports/attendance', AttendanceReportPage::class)->name('reports.attendance');



    // هنا تضيف باقي مسارات المسؤول
});

Route::middleware(['auth', 'role:doctor','verified','throttle:20,1'])->prefix('doctor')->name('doctor.')->group(function () {

    Route::get('/dashboard', DoctorDashboard::class)->name('dashboard');
    Route::get('assignments', App\Livewire\doctor\DoctorAssignmentsPage::class)->name('assignments');
    Route::get('/projects', \App\Livewire\doctor\DoctorProjectsPage::class)->name('projects');
    Route::get('/lectures', LecturesPage::class)->name('lectures');
    Volt::route('announcements', 'doctor.announcements-page')->name('announcements');
    Route::get('/my-courses', \App\Livewire\Doctor\MyCoursesPage::class)->name('courses.index');
    Route::get('/courses/{course}/discussions', \App\Livewire\Doctor\CourseDiscussionsPage::class)->name('courses.discussions');
    Route::get('my-schedule', \App\Livewire\Doctor\MySchedulePage::class)->name('my-schedule');
    Route::get('/reports', \App\Livewire\Doctor\Reports\CourseReportPage::class)->name('reports.course');


    // باقي مسارات الدكتور
});

Route::middleware(['auth', 'role:student','verified','throttle:20,1'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', StudentDashboard::class)->name('dashboard');
    Route::get('/assignments', StudentAssignmentsPage::class)->name('assignments');
    Route::get('/projects', App\Livewire\student\StudentProjectsPage::class)->name('projects');
    Route::get('/lectures', LecturesPagestudent::class)->name('lectures'); // المسار الجديد
    Route::get('/courses/{course}/discussions', CourseDiscussionsPage::class)->name('courses.discussions');
    Route::get('/my-courses', MyCoursesPage::class)->name('my-courses');
    Route::get('my-schedule', \App\Livewire\Student\MySchedulePage::class)->name('my-schedule');
    Route::get('/my-attendance', MyAttendancePage::class)->name('attendance');
    Route::get('/profile', App\Livewire\student\ProfilePage::class)->name('profile');


    // باقي مسارات الطالب
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
