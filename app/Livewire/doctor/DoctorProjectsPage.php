<?php

namespace App\Livewire\doctor;

use App\Models\Project;
use App\Models\ProjectComment;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Notifications\TeamInvitationUpdated;
use App\Notifications\ProjectStatusChanged;
use App\Notifications\NewProjectInteraction;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Computed;
use Illuminate\Pagination\LengthAwarePaginator;

class DoctorProjectsPage extends Component
{
    use WithPagination;

    // --- خصائص النموذج ---
    public $project_id = null;
    public $status;
    public $grade_value;
    public $feedback_text;
    public $comment_text;

    // --- خصائص الواجهة ---
    public $showChangeStatusModal = false;
    public $showGradeForm = false;
    public $showViewModal = false;
    public $viewedProject = null;

    // --- خصائص البحث والفلاتر ---
    public $search = '';
    public $filter_status = '';
    public $filter_course_id = '';

    // --- قواعد التحقق ---
    protected function rules()
    {
        return [
            'status' => 'required|in:pending,approved,rejected,completed',
            'grade_value' => 'required|numeric|min:0|max:100',
            'feedback_text' => 'nullable|string|max:1000',
            'comment_text' => 'required|string|max:500',
        ];
    }

    // --- [تحسين] دالة مساعدة للتحقق من الصلاحيات ---
    private function authorizeDoctorAction($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            if ($project->doctor_id !== Auth::user()->doctor->id) {
                $this->dispatch('showToast', message: 'غير مصرح لك بتنفيذ هذا الإجراء.', type: 'error');
                return null;
            }
            return $project;
        } catch (\Exception $e) {
            Log::error('Error authorizing doctor action for project: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على المشروع المطلوب.', type: 'error');
            return null;
        }
    }

    public function approveSupervision($projectId)
    {
        try {
            $project = Project::where('id', $projectId)
                ->where('doctor_id', auth()->user()->doctor->id)
                ->where('supervision_status', 'pending')
                ->firstOrFail();
            $project->update(['supervision_status' => 'approved']);
            $message = "وافق الدكتور '{$project->doctor->name}' على الإشراف على مشروعكم '{$project->title}'.";
            Notification::send($project->students()->with('user')->get()->pluck('user'), new TeamInvitationUpdated($project, $message, 'bi-check2-circle'));
            $this->dispatch('showToast', message: 'تم قبول طلب الإشراف بنجاح.', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error approving supervision: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء قبول طلب الإشراف.', type: 'error');
        }
    }

    public function rejectSupervision($projectId)
    {
        try {
            $project = Project::where('id', $projectId)
                ->where('doctor_id', auth()->user()->doctor->id)
                ->where('supervision_status', 'pending')
                ->firstOrFail();
            $project->update(['supervision_status' => 'rejected']);
            $message = "اعتذر الدكتور '{$project->doctor->name}' عن الإشراف على مشروعكم '{$project->title}'.";
            Notification::send($project->students()->with('user')->get()->pluck('user'), new TeamInvitationUpdated($project, $message, 'bi-x-circle'));
            $this->dispatch('showToast', message: 'تم رفض طلب الإشراف.', type: 'info');
        } catch (\Exception $e) {
            Log::error('Error rejecting supervision: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء رفض طلب الإشراف.', type: 'error');
        }
    }

    public function openChangeStatusModal($id)
    {
        if ($project = $this->authorizeDoctorAction($id)) {
            $this->project_id = $id;
            $this->status = $project->status;
            $this->showChangeStatusModal = true;
        }
    }

    public function saveStatus()
    {
        $this->validateOnly('status');
        if ($project = $this->authorizeDoctorAction($this->project_id)) {
            try {
                $project->update(['status' => $this->status]);
                // ... (منطق الإشعارات)
                $this->closeChangeStatusModal();
                $this->dispatch('showToast', message: 'تم تحديث حالة المشروع بنجاح.', type: 'success');
            } catch (\Exception $e) {
                Log::error('Error saving project status: ' . $e->getMessage());
                $this->dispatch('showToast', message: 'حدث خطأ أثناء تحديث الحالة.', type: 'error');
            }
        }
    }

    public function openGradeForm($id)
    {
        if ($project = $this->authorizeDoctorAction($id)) {
            $this->project_id = $id;
            $this->grade_value = $project->grade;
            $this->feedback_text = $project->feedback;
            $this->showGradeForm = true;
        }
    }

    public function saveGrade()
    {
        $this->validate(['grade_value' => 'required|numeric|min:0|max:100', 'feedback_text' => 'nullable|string|max:1000']);
        if ($project = $this->authorizeDoctorAction($this->project_id)) {
            try {
                $project->update(['grade' => $this->grade_value, 'feedback' => $this->feedback_text, 'status' => 'completed']);
                // ... (منطق الإشعارات)
                $this->resetGradeForm();
                $this->dispatch('showToast', message: 'تم حفظ التقييم بنجاح.', type: 'success');
            } catch (\Exception $e) {
                Log::error('Error saving grade: ' . $e->getMessage());
                $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ التقييم.', type: 'error');
            }
        }
    }

    public function addComment($projectId)
    {
        if (RateLimiter::tooManyAttempts('forms:' . Auth::id(), 10)) {
            $this->dispatch('showToast', message: 'لقد قمت بإرسال الكثير من التعليقات. يرجى المحاولة مرة أخرى بعد دقيقة.', type: 'error');
            return;
        }
        $this->validateOnly('comment_text');
        if ($project = $this->authorizeDoctorAction($projectId)) {
            try {
                $project->comments()->create(['user_id' => Auth::id(), 'comment' => $this->comment_text]);
                // ... (منطق الإشعارات)
                $this->reset('comment_text');
                $this->viewedProject->load(['comments.user', 'likes']);
                RateLimiter::hit('forms:' . Auth::id());
                $this->dispatch('showToast', message: 'تم إضافة التعليق بنجاح.', type: 'success');
            } catch (\Exception $e) {
                Log::error('Error adding comment: ' . $e->getMessage());
                $this->dispatch('showToast', message: 'حدث خطأ أثناء إضافة التعليق.', type: 'error');
            }
        }
    }

    // --- دوال مساعدة ---
    public function closeChangeStatusModal() { $this->reset(['project_id', 'status', 'showChangeStatusModal']); }
    public function resetGradeForm() { $this->reset(['project_id', 'grade_value', 'feedback_text', 'showGradeForm']); }
    public function viewProject($id) { if ($project = $this->authorizeDoctorAction($id)) { $this->viewedProject = $project->load(['creatorStudent.user', 'students.user', 'batch', 'specialization', 'course', 'doctor', 'files', 'likes.user', 'comments.user']); $this->showViewModal = true; } }
    public function closeViewModal() { $this->showViewModal = false; $this->reset(['viewedProject', 'comment_text']); }
    public function updating($property) { if (in_array($property, ['search', 'filter_status', 'filter_course_id'])) $this->resetPage(); }

    // --- [تحسين الأداء] الخصائص المحسوبة ---
    #[Computed(cache: true)]
    public function doctorCourses()
    {
        return Auth::user()->doctor?->courses()->orderBy('name')->get() ?? collect();
    }

    public function render()
    {
        $doctor = Auth::user()->doctor;
        if (!$doctor) {
            $emptyPaginator = new LengthAwarePaginator([], 0, 10);
            return view('livewire.doctor.doctor-projects-page', [
                'supervisionRequests' => collect(),
                'projects' => $emptyPaginator,
                'projectStatuses' => [],
            ]);
        }

        $supervisionRequests = Project::with(['creatorStudent', 'course'])
            ->where('doctor_id', $doctor->id)
            ->where('supervision_status', 'pending')
            ->latest()
            ->get();

        $projects = Project::with(['creatorStudent.user', 'course'])
            ->where('doctor_id', $doctor->id)
            ->where('supervision_status', 'approved')
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->filter_status, fn($q) => $q->where('status', $this->filter_status))
            ->when($this->filter_course_id, fn($q) => $q->where('course_id', $this->filter_course_id))
            ->latest()
            ->paginate(10);

        return view('livewire.doctor.doctor-projects-page', [
            'supervisionRequests' => $supervisionRequests,
            'projects' => $projects,
            'projectStatuses' => ['pending', 'approved', 'rejected', 'completed'],
        ]);
    }
}
