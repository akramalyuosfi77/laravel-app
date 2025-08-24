<?php

namespace App\Livewire\Doctor;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Submission;
use App\Notifications\NewAssignmentCreated;
use App\Notifications\SubmissionGraded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class DoctorAssignmentsPage extends Component
{
    use WithPagination;

    // --- خصائص النموذج ---
    public $title, $description, $course_id, $deadline;
    public $edit_id = null;
    public $showForm = false;

    // --- خصائص التقييم ---
    public $grade_submission_id = null;
    public $grade_value;
    public $feedback_text;
    public $showGradeForm = false;

    // --- خصائص الواجهة ---
    public $showViewSubmissionModal = false;
    public $viewedSubmission = null;

    // --- خصائص البحث والفلاتر ---
    public $search = '';
    public $filter_course_id = '';
    public $filter_submission_status = '';

    // --- قواعد التحقق ---
    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'deadline' => 'required|date|after_or_equal:now',
        ];
    }

    protected function gradeRules()
    {
        return [
            'grade_value' => 'required|integer|min:0|max:100',
            'feedback_text' => 'nullable|string|max:1000',
        ];
    }

    // --- [تحسين] دالة مساعدة للتحقق من الصلاحيات ---
    private function authorizeDoctorAction($model, $modelId)
    {
        $record = $model::findOrFail($modelId);
        $doctorId = Auth::user()->doctor->id;

        $isAuthorized = match ($model) {
            Assignment::class => $record->doctor_id === $doctorId,
            Submission::class => $record->assignment->doctor_id === $doctorId,
            default => false,
        };

        if (!$isAuthorized) {
            $this->dispatch('showToast', message: 'غير مصرح لك بتنفيذ هذا الإجراء.', type: 'error');
            return null;
        }
        return $record;
    }

    public function saveAssignment()
    {
        $this->validate();
        try {
            $doctor = Auth::user()->doctor;
            if (!$doctor || !$this->doctorCourses->contains($this->course_id)) {
                $this->dispatch('showToast', message: 'غير مصرح لك بالنشر في هذه المادة.', type: 'error');
                return;
            }

            $assignment = Assignment::updateOrCreate(
                ['id' => $this->edit_id],
                ['title' => $this->title, 'description' => $this->description, 'course_id' => $this->course_id, 'doctor_id' => $doctor->id, 'deadline' => $this->deadline]
            );

            // --- الكود الجديد لإرسال الإشعار ---
// نرسل الإشعار فقط عند إنشاء تكليف جديد (عندما يكون edit_id فارغاً)
// --- الكود الجديد لإرسال الإشعار ---
if (!$this->edit_id) {
    try {
        // 💡 [تصحيح] نستخدم العلاقة الجديدة والمحسنة students()
        // ونضيف with('user') لجلب المستخدمين بكفاءة وتجنب استعلامات N+1
        $students = $assignment->course->students()->with('user')->get();

        // 💡 [تحسين] جلب المستخدمين مباشرة وتصفيتهم
        $usersToSend = $students->pluck('user')->filter();

        if ($usersToSend->isNotEmpty()) {
            Notification::send($usersToSend, new NewAssignmentCreated($assignment));
        }
    } catch (\Exception $e) {
        // في حال حدوث أي خطأ، يتم تسجيله دون إيقاف العملية
        \Log::error('Failed to send new assignment notification: ' . $e->getMessage());
    }
}
-

            $this->closeAssignmentForm();
            $message = $this->edit_id ? 'تم تحديث التكليف بنجاح' : 'تم إضافة التكليف بنجاح';
            $this->dispatch('showToast', message: $message, type: 'success');
        } catch (\Exception $e) {
            Log::error('Error saving assignment: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ التكليف.', type: 'error');
        }
    }

    public function editAssignment($id)
    {
        if ($assignment = $this->authorizeDoctorAction(Assignment::class, $id)) {
            $this->edit_id = $assignment->id;
            $this->title = $assignment->title;
            $this->description = $assignment->description;
            $this->course_id = $assignment->course_id;
            $this->deadline = Carbon::parse($assignment->deadline)->format('Y-m-d\TH:i');
            $this->showForm = true;
        }
    }

    public function confirmDeleteAssignment($id) { $this->edit_id = $id; }

    public function deleteAssignment()
    {
        if ($assignment = $this->authorizeDoctorAction(Assignment::class, $this->edit_id)) {
            try {
                $assignment->delete();
                $this->edit_id = null;
                $this->dispatch('showToast', message: 'تم حذف التكليف بنجاح', type: 'success');
            } catch (\Exception $e) {
                Log::error('Error deleting assignment: ' . $e->getMessage());
                $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف التكليف.', type: 'error');
            }
        }
    }

    public function openGradeForm($submissionId)
    {
        if ($submission = $this->authorizeDoctorAction(Submission::class, $submissionId)) {
            $this->grade_submission_id = $submission->id;
            $this->grade_value = $submission->grade;
            $this->feedback_text = $submission->feedback;
            $this->showGradeForm = true;
        }
    }

    public function saveGrade()
    {
        $this->validate($this->gradeRules());
        if ($submission = $this->authorizeDoctorAction(Submission::class, $this->grade_submission_id)) {
            try {
                $submission->update(['grade' => $this->grade_value, 'feedback' => $this->feedback_text, 'status' => 'graded']);
                if ($submission->student->user) {
                    Notification::send($submission->student->user, new SubmissionGraded($submission));
                }
                $this->resetGradeForm();
                $this->dispatch('showToast', message: 'تم حفظ التقييم بنجاح', type: 'success');
            } catch (\Exception $e) {
                Log::error('Error saving grade: ' . $e->getMessage());
                $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ التقييم.', type: 'error');
            }
        }
    }

    public function viewSubmission($submissionId)
    {
        if ($submission = $this->authorizeDoctorAction(Submission::class, $submissionId)) {
            $this->viewedSubmission = $submission->load('files');
            $this->showViewSubmissionModal = true;
        }
    }

    // --- دوال مساعدة ---
    public function resetAssignmentForm() { $this->reset(['title', 'description', 'course_id', 'deadline', 'edit_id']); $this->resetValidation(); }
    public function openAssignmentForm() { $this->resetAssignmentForm(); $this->showForm = true; }
    public function closeAssignmentForm() { $this->showForm = false; $this->resetAssignmentForm(); }
    public function resetGradeForm() { $this->reset(['grade_submission_id', 'grade_value', 'feedback_text', 'showGradeForm']); $this->resetValidation(); }
    public function closeViewSubmissionModal() { $this->reset(['viewedSubmission', 'showViewSubmissionModal']); }
    public function updating($property) { if (in_array($property, ['search', 'filter_course_id', 'filter_submission_status'])) $this->resetPage(); }

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
            return view('livewire.doctor.doctor-assignments-page', [
                'assignments' => $emptyPaginator,
                'submissions' => $emptyPaginator,
                'submissionStatuses' => [],
            ]);
        }

        $assignments = Assignment::where('doctor_id', $doctor->id)
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->filter_course_id, fn($q) => $q->where('course_id', $this->filter_course_id))
            ->latest()
            ->paginate(10, ['*'], 'assignmentsPage');

        $submissions = Submission::whereHas('assignment', fn($q) => $q->where('doctor_id', $doctor->id))
            ->when($this->search, function ($query) {
                $query->whereHas('student', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                      ->orWhereHas('assignment', fn($q) => $q->where('title', 'like', '%' . $this->search . '%'));
            })
            ->when($this->filter_submission_status, fn($q) => $q->where('status', $this->filter_submission_status))
            ->latest()
            ->paginate(10, ['*'], 'submissionsPage');

        return view('livewire.doctor.doctor-assignments-page', [
            'assignments' => $assignments,
            'submissions' => $submissions,
            'submissionStatuses' => ['pending', 'submitted', 'graded', 'rejected'],
        ]);
    }
}
