<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Student;
use App\Models\Doctor;
use App\Models\Project;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // لاستجيل الأخطاء
use Carbon\Carbon;

class AdminDashboard extends Component
{
    // --- خصائص بطاقات الإحصائيات ---
    public $totalUsers = 0;
    public $activeStudents = 0;
    public $totalDoctors = 0;
    public $totalDepartments = 0;
    public $totalSpecializations = 0;
    public $totalBatches = 0;
    public $totalCourses = 0;
    public $completedProjects = 0;

    // --- خصائص أحدث الأنشطة ---
    public $recentNotifications = [];

    // --- خصائص الرسوم البيانية ---
    public $userRolesChartData = [];
    public $newStudentsChartData = [];

    // --- خصائص قوائم المراجعة السريعة ---
    public $pendingStudents = [];
    public $pendingProjects = [];

    public function mount()
    {
        $this->loadAllData();
    }

    public function loadAllData()
    {
        try {
            // --- [تحسين] استخدام نفس منطقك الأصلي مع تنظيمه ---
            $this->totalUsers = User::count();
            $this->activeStudents = Student::where('status', 'نشط')->count();
            $this->totalDoctors = User::where('role', 'doctor')->count();
            $this->completedProjects = Project::where('status', 'completed')->count();
            $this->totalDepartments = Department::count();
            $this->totalSpecializations = Specialization::count();
            $this->totalBatches = Batch::count();
            $this->totalCourses = Course::count();
            // --- [نهاية التحسين] ---

            // --- تحميل أحدث الأنشطة (الإشعارات) ---
            $this->recentNotifications = Auth::user()->notifications()->latest()->take(5)->get();

            // --- تجهيز بيانات الرسوم البيانية ---
            $this->prepareChartsData();

            // --- تحميل قوائم المراجعة ---
            $this->pendingStudents = Student::whereHas('user', fn($q) => $q->where('is_active', false))
                                            ->latest()->take(5)->get();
            $this->pendingProjects = Project::where('status', 'pending')
                                            ->with('creatorStudent', 'course') // تحسين الأداء
                                            ->latest()->take(5)->get();

        } catch (\Exception $e) {
            // --- [إضافة] التعامل مع الأخطاء ---
            Log::error('Admin Dashboard Error: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء تحميل بيانات لوحة التحكم.', type: 'error');
        }
    }

    public function prepareChartsData()
    {
        // ... (هذه الدالة تبقى كما هي بدون تغيير)
        $rolesData = User::select('role', DB::raw('count(*) as total'))->groupBy('role')->get();
        $this->userRolesChartData = [
            'labels' => $rolesData->pluck('role')->map(fn($role) => __($role)),
            'data' => $rolesData->pluck('total'),
        ];
        $newStudents = Student::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                              ->where('created_at', '>=', Carbon::now()->subDays(6))
                              ->groupBy('date')->orderBy('date', 'asc')->get();
        $dates = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = Carbon::parse($date)->format('D');
            $counts[] = $newStudents->firstWhere('date', $date)->total ?? 0;
        }
        $this->newStudentsChartData = [
            'labels' => $dates,
            'data' => $counts,
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
