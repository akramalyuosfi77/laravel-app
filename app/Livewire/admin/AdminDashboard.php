<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Student;
use App\Models\Doctor;
use App\Models\Course;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Batch;
use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\Lecture;
use App\Models\Project;
use App\Models\Submission;
use App\Models\Discussion;
use Carbon\Carbon;

class AdminDashboard extends Component
{
    public $totalStudents;
    public $totalDoctors;
    public $totalCourses;
    public $totalDepartments;
    public $totalSpecializations;
    public $totalBatches;
    public $totalAnnouncements;
    public $totalAssignments;
    public $totalLectures;
    public $totalProjects;
    public $totalSubmissions;
    public $totalDiscussions;

    public $pendingProjectsCount;
    public $approvedProjectsCount;
    public $rejectedProjectsCount;
    public $completedProjectsCount;

    public $activeStudentsCount;
    public $graduatedStudentsCount;
    public $suspendedStudentsCount;
    public $withdrawnStudentsCount;

    public $infoAnnouncementsCount;
    public $successAnnouncementsCount;
    public $warningAnnouncementsCount;
    public $dangerAnnouncementsCount;

    // إحصائيات إضافية
    public $assignmentsDueSoonCount;
    public $recentDiscussionsCount;
    public $pendingSubmissionsCount;
    public $gradedSubmissionsCount;
    public $totalUsers;
    public $newStudentsThisMonth;
    public $newDoctorsThisMonth;
    public $activeAnnouncementsCount;

    public function mount()
    {
        $this->totalStudents = Student::count();
        $this->totalDoctors = Doctor::count();
        $this->totalCourses = Course::count();
        $this->totalDepartments = Department::count();
        $this->totalSpecializations = Specialization::count();
        $this->totalBatches = Batch::count();
        $this->totalAnnouncements = Announcement::count();
        $this->totalAssignments = Assignment::count();
        $this->totalLectures = Lecture::count();
        $this->totalProjects = Project::count();
        $this->totalSubmissions = Submission::count();
        $this->totalDiscussions = Discussion::count();

        $this->pendingProjectsCount = Project::where("status", "pending")->count();
        $this->approvedProjectsCount = Project::where("status", "approved")->count();
        $this->rejectedProjectsCount = Project::where("status", "rejected")->count();
        $this->completedProjectsCount = Project::where("status", "completed")->count();

        $this->activeStudentsCount = Student::where("status", "نشط")->count();
        $this->graduatedStudentsCount = Student::where("status", "متخرج")->count();
        $this->suspendedStudentsCount = Student::where("status", "موقوف")->count();
        $this->withdrawnStudentsCount = Student::where("status", "منسحب")->count();

        $this->infoAnnouncementsCount = Announcement::where("level", "info")->count();
        $this->successAnnouncementsCount = Announcement::where("level", "success")->count();
        $this->warningAnnouncementsCount = Announcement::where("level", "warning")->count();
        $this->dangerAnnouncementsCount = Announcement::where("level", "danger")->count();

        // إحصائيات إضافية
        $this->assignmentsDueSoonCount = Assignment::where("deadline", ">=", Carbon::now())
                                                ->where("deadline", "<=", Carbon::now()->addDays(7))
                                                ->count();
        $this->recentDiscussionsCount = Discussion::where("created_at", ">=", Carbon::now()->subDays(7))->count();
        $this->pendingSubmissionsCount = Submission::where("status", "pending")->count();
        $this->gradedSubmissionsCount = Submission::where("status", "graded")->count();
        $this->totalUsers = \App\Models\User::count(); // Assuming User model exists
        $this->newStudentsThisMonth = Student::whereMonth("created_at", Carbon::now()->month)
                                            ->whereYear("created_at", Carbon::now()->year)
                                            ->count();
        $this->newDoctorsThisMonth = Doctor::whereMonth("created_at", Carbon::now()->month)
                                        ->whereYear("created_at", Carbon::now()->year)
                                        ->count();
        $this->activeAnnouncementsCount = Announcement::where(function ($query) {
                                            $query->whereNull("expires_at")
                                                  ->orWhere("expires_at", ">=", Carbon::now());
                                        })->count();
    }

    public function render()
    {
        return view("livewire.admin.dashboard");
    }
}


