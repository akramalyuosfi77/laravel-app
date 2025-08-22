<?php

namespace App\Livewire\Doctor;

use App\Models\Discussion;
use App\Models\Project;
use App\Models\Submission;
use App\Models\SpecializationCourseAcademicPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Carbon\Carbon;
use App\Models\DiscussionReply;


class DoctorDashboard extends Component
{
    // --- خصائص الإحصائيات ---
    public $assignedCoursesCount = 0;
    public $supervisingProjectsCount = 0;
    public $pendingSubmissionsCount = 0;
    public $openDiscussionsCount = 0;

    // --- خصائص أحدث الأنشطة ---
    public $recentActivities;
    public $topStudents;

    // --- خصائص الرسم البياني ---
    public $submissionsChartData = [];

    public function mount()
    {
        $this->loadAllData();
    }

    public function loadAllData()
    {
        
        try {
            $doctor = Auth::user()->doctor;
            if (!$doctor) {
                $this->resetAllData();
                return;
            }

            // [تحسين الأداء] جلب معرفات المواد مرة واحدة فقط
            $doctorCourseIds = $this->getDoctorCourseIds($doctor->id);

            // تحميل الإحصائيات
            $this->assignedCoursesCount = $doctorCourseIds->count();
            $this->supervisingProjectsCount = Project::where('doctor_id', $doctor->id)->where('supervision_status', 'approved')->count();
            $this->pendingSubmissionsCount = Submission::whereIn('assignment_id', fn($q) => $q->select('id')->from('assignments')->where('doctor_id', $doctor->id))->where('status', 'submitted')->count();
            $this->openDiscussionsCount = Discussion::whereIn('course_id', $doctorCourseIds)->where('status', 'open')->count();

            // تحميل الأنشطة والطلاب
            $this->recentActivities = Auth::user()->notifications()->latest()->take(5)->get();
            $this->topStudents = $this->getTopStudents($doctorCourseIds);

            // تحميل بيانات الرسم البياني
            $this->prepareSubmissionsChart($doctor->id);

        } catch (\Exception $e) {
            Log::error('Error loading doctor dashboard data: ' . $e->getMessage());
            $this->resetAllData();
            $this->dispatch('showToast', message: 'حدث خطأ أثناء تحميل بيانات لوحة التحكم.', type: 'error');
        }
    }

    // --- دوال مساعدة لجلب البيانات ---

    private function getDoctorCourseIds($doctorId)
    {
        // [تصحيح] نستخدم العلاقة العكسية التي أنشأناها في مودل Doctor
        // هذا الكود أكثر وضوحاً ويستفيد من علاقات Eloquent بشكل صحيح
        $doctor = \App\Models\Doctor::find($doctorId);
        if (!$doctor) {
            return collect(); // إرجاع مجموعة فارغة إذا لم يتم العثور على الدكتور
        }

        // نستخدم العلاقة specializationCourseAcademicPeriods لجلب السجلات من الجدول الوسيط
        // ثم نستخدم pluck لجلب course_id فقط
        return $doctor->specializationCourseAcademicPeriods()->pluck('course_id')->unique();
    }


    private function getTopStudents($courseIds)
    {
        if ($courseIds->isEmpty()) return collect();
        return DiscussionReply::join('users', 'discussion_replies.user_id', '=', 'users.id')
            ->join('students', 'users.id', '=', 'students.user_id')
            ->join('discussions', 'discussion_replies.discussion_id', '=', 'discussions.id')
            ->whereIn('discussions.course_id', $courseIds)
            ->where('users.role', 'student')
            ->select('students.name', 'students.profile_image', DB::raw('count(discussion_replies.id) as replies_count'))
            ->groupBy('students.id', 'students.name', 'students.profile_image')
            ->orderByDesc('replies_count')
            ->take(5)
            ->get();
    }

    private function prepareSubmissionsChart($doctorId)
    {
        $submissionsData = Submission::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereIn('assignment_id', fn($q) => $q->select('id')->from('assignments')->where('doctor_id', $doctorId))
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')->orderBy('date', 'asc')->get()->pluck('count', 'date');

        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates->put($date, $submissionsData->get($date, 0));
        }

        $this->submissionsChartData = [
            'labels' => $dates->keys()->map(fn($date) => Carbon::parse($date)->format('D'))->toArray(),
            'data' => $dates->values()->toArray(),
        ];
        $this->dispatch('submissionsChartUpdated', $this->submissionsChartData);
    }

    private function resetAllData()
    {
        $this->assignedCoursesCount = 0;
        $this->supervisingProjectsCount = 0;
        $this->pendingSubmissionsCount = 0;
        $this->openDiscussionsCount = 0;
        $this->recentActivities = collect();
        $this->topStudents = collect();
        $this->submissionsChartData = ['labels' => [], 'data' => []];
    }

    public function render()
    {
        return view('livewire.doctor.dashboard');
    }
}
