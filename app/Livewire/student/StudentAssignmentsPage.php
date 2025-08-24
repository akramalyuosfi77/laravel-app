<?php

namespace App\Livewire\Student;

use App\Models\Assignment;
use App\Models\Submission;
use App\Models\SubmissionFile;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Notifications\NewSubmissionReceived;
use Illuminate\Support\Facades\Notification;
use App\Livewire\Traits\WithSecureFileUploads;

class StudentAssignmentsPage extends Component
{
    use WithPagination, WithFileUploads, WithSecureFileUploads;

    // --- الخصائص ---
    public $search = '';
    public $filter_status = '';
    public $assignment_id_to_submit = null;
    public $submission_title;
    public $submission_description;
    public $submission_files = [];
    public $existing_submission_id = null;
    public $old_submission_files = [];
    public $showSubmissionForm = false;
    public $showViewModal = false;
    public $viewedAssignment = null;
    public $viewedSubmission = null;

    // --- [تصحيح] تم حذف دالة rules() العامة ---

    // --- [تحسين] دالة مساعدة للتحقق من الصلاحيات ---
    private function authorizeStudentAction($assignmentId)
    {
        try {
            $student = Auth::user()->student;
            if (!$student) {
                throw new \Exception('لا يوجد حساب طالب مرتبط بهذا المستخدم.');
            }

            $assignment = Assignment::findOrFail($assignmentId);
            $studentCoursesIds = $student->getCurrentCourses()->pluck('id');

            if (!$studentCoursesIds->contains($assignment->course_id)) {
                $this->dispatch('showToast', message: 'غير مصرح لك بالتعامل مع هذا التكليف.', type: 'error');
                return null;
            }
            return $assignment;
        } catch (\Exception $e) {
            Log::error('Error authorizing student action for assignment: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على التكليف المطلوب.', type: 'error');
            return null;
        }
    }

    public function openSubmissionForm($assignmentId)
    {
        if ($assignment = $this->authorizeStudentAction($assignmentId)) {
            $this->resetSubmissionForm();
            $student = Auth::user()->student;
            $existingSubmission = Submission::with('files')->where('assignment_id', $assignmentId)->where('student_id', $student->id)->first();

            if ($existingSubmission) {
                $this->existing_submission_id = $existingSubmission->id;
                $this->submission_title = $existingSubmission->title;
                $this->submission_description = $existingSubmission->description;
                $this->old_submission_files = $existingSubmission->files;
            }

            $this->assignment_id_to_submit = $assignmentId;
            $this->showSubmissionForm = true;
        }
    }

   // ... داخل كلاس StudentAssignmentsPage ...

public function saveSubmission()
{
    // التحقق من البيانات النصية أولاً
    $this->validate([
        'submission_title' => 'nullable|string|max:255',
        'submission_description' => 'nullable|string',
    ]);

    // التحقق من الملفات فقط إذا تم رفعها
    if (!empty($this->submission_files)) {
        $this->validate(['submission_files.*' => $this->secureFileUploadRules(10240)]);
    }

    if (!$assignment = $this->authorizeStudentAction($this->assignment_id_to_submit)) return;

    if (Carbon::now()->greaterThan($assignment->deadline)) {
        $this->dispatch('showToast', message: 'انتهى موعد تسليم هذا التكليف. لا يمكنك التسليم أو التعديل.', type: 'error');
        return;
    }

    try {
        DB::transaction(function () use ($assignment) {
            $student = Auth::user()->student;
            $submission = Submission::updateOrCreate(
                ['id' => $this->existing_submission_id, 'assignment_id' => $this->assignment_id_to_submit, 'student_id' => $student->id],
                ['title' => $this->submission_title, 'description' => $this->submission_description, 'status' => 'submitted']
            );

            if (!empty($this->submission_files)) {
                foreach ($this->submission_files as $file) {
                    $path = $file->store('submissions', 'public');
                    $submission->files()->create(['file_path' => $path, 'file_name' => $file->getClientOriginalName(), 'file_type' => $file->getMimeType(), 'file_size' => $file->getSize()]);
                }
            }

            if ($assignment->doctor?->user) {
                Notification::send($assignment->doctor->user, new NewSubmissionReceived($submission));
            }
        });

        $this->closeSubmissionForm();
        $message = $this->existing_submission_id ? 'تم تحديث التسليم بنجاح' : 'تم تسليم التكليف بنجاح';
        $this->dispatch('showToast', message: $message, type: 'success');
    } catch (\Exception $e) {
        Log::error('Error saving submission: ' . $e->getMessage());
        $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ التسليم.', type: 'error');
    }
}


    public function deleteExistingFile($fileId)
    {
        try {
            $file = SubmissionFile::findOrFail($fileId);
            if ($file->submission->student_id !== Auth::user()->student->id) {
                $this->dispatch('showToast', message: 'غير مصرح لك بحذف هذا الملف.', type: 'error');
                return;
            }
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
            $this->old_submission_files = $this->old_submission_files->except($fileId);
            $this->dispatch('showToast', message: 'تم حذف الملف بنجاح', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting submission file: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف الملف.', type: 'error');
        }
    }

    public function viewAssignmentDetails($assignmentId)
    {
        if ($assignment = $this->authorizeStudentAction($assignmentId)) {
            $this->viewedAssignment = $assignment->load(['course', 'doctor']);
            $this->viewedSubmission = Submission::with('files')->where('assignment_id', $assignmentId)->where('student_id', Auth::user()->student->id)->first();
            $this->showViewModal = true;
        }
    }

    // --- دوال مساعدة ---
    public function resetSubmissionForm() { $this->reset(['assignment_id_to_submit', 'submission_title', 'submission_description', 'submission_files', 'existing_submission_id', 'old_submission_files']); $this->resetValidation(); }
    public function closeSubmissionForm() { $this->showSubmissionForm = false; $this->resetSubmissionForm(); }
    public function closeViewModal() { $this->reset(['showViewModal', 'viewedAssignment', 'viewedSubmission']); }
    public function updating($property) { if (in_array($property, ['search', 'filter_status'])) $this->resetPage(); }

    public function render()
    {
        $student = Auth::user()->student;
        if (!$student) {
            return view('livewire.student.student-assignments-page', ['assignments' => collect(), 'submissionStatuses' => []]);
        }

        $assignments = Assignment::with(['course', 'doctor', 'submissions' => fn($q) => $q->where('student_id', $student->id)])
            ->whereIn('course_id', $student->getCurrentCourses()->pluck('id'))
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->filter_status, function ($query) use ($student) {
                if ($this->filter_status == 'submitted') $query->whereHas('submissions', fn($q) => $q->where('student_id', $student->id));
                elseif ($this->filter_status == 'pending') $query->whereDoesntHave('submissions', fn($q) => $q->where('student_id', $student->id));
                elseif ($this->filter_status == 'late') $query->whereDoesntHave('submissions', fn($q) => $q->where('student_id', $student->id))->where('deadline', '<', now());
            })
            ->latest('deadline')
            ->paginate(10);

        return view('livewire.student.student-assignments-page', [
            'assignments' => $assignments,
            'submissionStatuses' => ['pending', 'submitted', 'graded', 'late']
        ]);
    }
}
