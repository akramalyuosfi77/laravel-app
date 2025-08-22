<?php

namespace App\Livewire\student;

use App\Models\User;
use App\Models\Student;
use App\Models\Project;
use App\Models\Course;
use App\Models\Doctor;
use App\Models\ProjectFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SupervisionRequestReceived;
use App\Notifications\AddedToProjectTeam;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Notifications\TeamInvitationUpdated;
use App\Notifications\NewProjectInteraction;
use App\Livewire\Traits\WithSecureFileUploads;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;

class StudentProjectsPage extends Component
{
    use WithPagination, WithFileUploads, WithSecureFileUploads;

    // --- خصائص النموذج ---
    public $project_id;
    public $title, $description, $course_id, $doctor_id;
    public $selected_students = [];
    public $new_files = [];
    public $file_types = [];
    public $file_descriptions = [];
    public $existing_files = [];
    public $files_to_delete = [];

    // --- خصائص الواجهة ---
    public $showForm = false;
    public $delete_id = null;
    public $showViewModal = false;
    public $viewedProject = null;
    public $comment_text = '';

    // --- خصائص البحث والفلاتر ---
    public $search = '';
    public $filter_status = '';
    public $filter_course_id = '';

    // --- خصائص مساعدة للنماذج المتسلسلة ---
    public $selected_course_id_for_form = '';

    // --- [تحسين الأداء] الخصائص المحسوبة ---

    #[Computed(cache: true)]
    public function studentCourses()
    {
        return Auth::user()->student?->getCurrentCourses()->get() ?? collect();
    }

    #[Computed(cache: true)]
    public function allStudents()
    {
        // نستثني الطالب الحالي من قائمة الاختيار
        return Student::where('id', '!=', Auth::user()->student?->id)->orderBy('name')->get();
    }

    #[Computed(cache: true)]
    public function availableDoctorsForCourse()
    {
        if (!$this->selected_course_id_for_form) {
            return collect();
        }
        return Course::find($this->selected_course_id_for_form)?->doctors()->get() ?? collect();
    }

    // --- دوال التحكم ---

    public function mount()
    {
        $this->addNewFile();
    }

    public function updatedSelectedCourseIdForForm($value)
    {
        $this->course_id = $value;
        $this->doctor_id = null;
        unset($this->availableDoctorsForCourse);
    }

    public function respondToInvitation($projectId, $status)
    {
        try {
            $student = Auth::user()->student;
            $project = Project::findOrFail($projectId);
            $project->students()->updateExistingPivot($student->id, ['membership_status' => $status]);

            if ($creator = $project->creatorStudent->user) {
                $decision = ($status === 'approved') ? 'وافق' : 'رفض';
                $icon = ($status === 'approved') ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
                $message = "{$decision} الطالب '{$student->name}' على دعوتك للانضمام لمشروع '{$project->title}'.";
                Notification::send($creator, new TeamInvitationUpdated($project, $message, $icon));
            }

            $toastMessage = ($status === 'approved') ? 'تم قبول الدعوة بنجاح.' : 'تم رفض الدعوة.';
            $this->dispatch('showToast', message: $toastMessage, type: 'success');
        } catch (\Exception $e) {
            Log::error('Error responding to invitation: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ ما.', type: 'error');
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'selected_students' => 'nullable|array',
            'selected_students.*' => 'exists:students,id',
            'new_files.*' => $this->secureFileUploadRules(51200),
            'file_types.*' => 'nullable|string',
            'file_descriptions.*' => 'nullable|string|max:500',
        ]);

        try {
            DB::transaction(function () {
                $student = Auth::user()->student;
                if (!$student) throw new \Exception('لا يوجد حساب طالب مرتبط بهذا المستخدم.');

                $projectData = [
                    'title' => $this->title, 'description' => $this->description, 'course_id' => $this->course_id,
                    'doctor_id' => $this->doctor_id, 'student_id' => $student->id, 'batch_id' => $student->batch_id,
                    'specialization_id' => $student->batch->specialization_id, 'academic_year' => $student->batch->current_academic_year,
                    'semester' => $student->batch->current_semester, 'status' => 'pending',
                    'supervision_status' => $this->doctor_id ? 'pending' : null,
                ];

                $project = Project::updateOrCreate(['id' => $this->project_id], $projectData);

                if (!$this->project_id) {
                    $project->students()->syncWithoutDetaching([$student->id => ['membership_status' => 'approved']]);
                    $team_members_ids = array_diff($this->selected_students, [$student->id]);
                    if (!empty($team_members_ids)) {
                        foreach ($team_members_ids as $member_id) {
                            $project->students()->syncWithoutDetaching([$member_id => ['membership_status' => 'pending']]);
                        }
                    }
                } else {
                    $currentMembers = $project->students()->pluck('student_id')->toArray();
                    $newAndCurrentMembers = array_unique(array_merge($currentMembers, $this->selected_students, [$student->id]));
                    $project->students()->sync($newAndCurrentMembers);
                }

                if (!empty($this->new_files)) {
                    foreach ($this->new_files as $index => $file) {
                        if ($file) {
                            $filePath = $file->store('project_files', 'public');
                            $project->files()->create([
                                'file_path' => $filePath, 'file_name' => $file->getClientOriginalName(),
                                'file_type' => $file->getMimeType(), 'file_size' => $file->getSize(),
                                'description' => $this->file_descriptions[$index] ?? null, 'type' => $this->file_types[$index] ?? 'other',
                            ]);
                        }
                    }
                }

                if (!empty($this->files_to_delete)) {
                    $filesToDelete = ProjectFile::whereIn('id', $this->files_to_delete)->where('project_id', $project->id)->get();
                    foreach ($filesToDelete as $file) {
                        Storage::disk('public')->delete($file->file_path);
                        $file->delete();
                    }
                }

                if (!$this->project_id) {
                    if ($project->doctor?->user) {
                        Notification::send($project->doctor->user, new SupervisionRequestReceived($project));
                    }
                    if (!empty($team_members_ids)) {
                        $team_members_users = Student::whereIn('id', $team_members_ids)->with('user')->get()->pluck('user')->filter();
                        if ($team_members_users->isNotEmpty()) {
                            Notification::send($team_members_users, new AddedToProjectTeam($project, $student));
                        }
                    }
                } else {
                    $updater = Auth::user();
                    $recipients = $project->students()->where('membership_status', 'approved')->with('user')->get()->pluck('user');
                    if ($project->doctor?->user) $recipients->push($project->doctor->user);
                    $recipientsToSend = $recipients->reject(fn($r) => $r->id === $updater->id);
                    if ($recipientsToSend->isNotEmpty()) {
                        Notification::send($recipientsToSend, new \App\Notifications\ProjectDetailsUpdated($project, $updater->name));
                    }
                }
            });

            $this->resetForm();
            $this->showForm = false;
            $message = $this->project_id ? 'تم تحديث المشروع بنجاح' : 'تم إضافة المشروع بنجاح';
            $this->dispatch('showToast', message: $message, type: 'success');
        } catch (\Exception $e) {
            Log::error('Error saving project: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ ما أثناء حفظ المشروع.', type: 'error');
        }
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        if (!$project->isParticipant(Auth::user()->student)) abort(403, 'غير مصرح لك بتعديل هذا المشروع.');

        $this->project_id = $project->id;
        $this->title = $project->title;
        $this->description = $project->description;
        $this->course_id = $project->course_id;
        $this->doctor_id = $project->doctor_id;
        $this->selected_students = $project->students->pluck('id')->toArray();
        $this->selected_course_id_for_form = $project->course_id;
        unset($this->availableDoctorsForCourse);
        $this->existing_files = $project->files->toArray();
        $this->new_files = [];
        $this->file_types = [];
        $this->file_descriptions = [];
        $this->files_to_delete = [];
        $this->showForm = true;
    }

    public function confirmDelete($id)
    {
        $project = Project::findOrFail($id);
        if ($project->student_id !== Auth::user()->student->id) abort(403, 'فقط منشئ المشروع يمكنه حذفه.');
        $this->delete_id = $id;
    }

    public function delete()
    {
        try {
            DB::transaction(function () {
                $project = Project::findOrFail($this->delete_id);
                if ($project->student_id !== Auth::user()->student->id) throw new \Exception('غير مصرح لك بحذف هذا المشروع.');
                foreach ($project->files as $file) Storage::disk('public')->delete($file->file_path);
                $project->delete();
            });
            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف المشروع وكل ما يتعلق به بنجاح.', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting project: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ ما أثناء حذف المشروع.', type: 'error');
        }
    }

    public function toggleLike($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            $user = Auth::user();
            if (!$user->student) return;

            if ($project->isLikedByUser($user)) {
                $project->likes()->where('user_id', $user->id)->delete();
            } else {
                $project->likes()->create(['user_id' => $user->id]);
                $recipients = $project->students()->where('membership_status', 'approved')->with('user')->get()->pluck('user');
                if ($project->doctor?->user) $recipients->push($project->doctor->user);
                $recipientsToSend = $recipients->reject(fn($r) => $r->id === $user->id);
                if ($recipientsToSend->isNotEmpty()) {
                    Notification::send($recipientsToSend, new NewProjectInteraction($project, "أعجب '{$user->name}' بمشروعكم '{$project->title}'.", 'bi-heart-fill text-red-500'));
                }
            }
            $this->viewedProject->loadCount('likes');
        } catch (\Exception $e) {
            Log::error('Error toggling like: ' . $e->getMessage());
        }
    }

    public function addComment($projectId)
    {
        if (RateLimiter::tooManyAttempts('forms:' . Auth::id(), 10)) {
            $this->dispatch('showToast', message: 'لقد قمت بإرسال الكثير من التعليقات. يرجى المحاولة مرة أخرى بعد دقيقة.', type: 'error');
            return;
        }
        RateLimiter::hit('forms:' . Auth::id());
        $this->validate(['comment_text' => 'required|string|max:1000']);

        try {
            $project = Project::findOrFail($projectId);
            $user = Auth::user();
            if (!$user) return;

            $project->comments()->create(['user_id' => $user->id, 'comment' => $this->comment_text]);
            $this->reset('comment_text');
            $this->viewedProject->load(['comments.user', 'comments' => fn($q) => $q->withCount('likes')]);
            $this->viewedProject->loadCount('comments');
        } catch (\Exception $e) {
            Log::error('Error adding comment: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء إضافة التعليق.', type: 'error');
        }
    }

    // --- دوال مساعدة ---
    public function resetForm() { $this->reset(['project_id', 'title', 'description', 'course_id', 'doctor_id', 'selected_students', 'new_files', 'file_types', 'file_descriptions', 'existing_files', 'files_to_delete', 'selected_course_id_for_form', 'comment_text']); $this->addNewFile(); $this->resetValidation(); }
    public function openForm() { $this->resetForm(); $this->showForm = true; }
    public function closeForm() { $this->showForm = false; $this->resetForm(); }
    public function addNewFile() { $this->new_files[] = null; $this->file_types[] = null; $this->file_descriptions[] = null; }
    public function removeNewFile($index) { unset($this->new_files[$index], $this->file_types[$index], $this->file_descriptions[$index]); $this->new_files = array_values($this->new_files); $this->file_types = array_values($this->file_types); $this->file_descriptions = array_values($this->file_descriptions); }
    public function markFileForDeletion($fileId) { $this->files_to_delete[] = $fileId; $this->existing_files = array_filter($this->existing_files, fn($file) => $file['id'] != $fileId); $this->dispatch('showToast', message: 'تم تحديد الملف للحذف عند الحفظ.', type: 'info'); }
    // public function viewProject($id) { $this->viewedProject = Project::with(['creatorStudent.user', 'students.user', 'course.specialization.department', 'doctor', 'files', 'likes', 'comments.user'])->findOrFail($id); $this->showViewModal = true; }
    public function viewProject($id)
{
    // [تصحيح] استخدام specializations (بالجمع)
    $this->viewedProject = Project::with(['creatorStudent.user', 'students.user', 'course.specializations.department', 'doctor', 'files', 'likes', 'comments.user'])->findOrFail($id);
    $this->showViewModal = true;
}

    public function closeViewModal() { $this->showViewModal = false; $this->viewedProject = null; $this->comment_text = ''; }
    public function updatingSearch() { $this->resetPage('myProjectsPage'); $this->resetPage('allProjectsPage'); }
    public function updatingFilterStatus() { $this->resetPage('myProjectsPage'); $this->resetPage('allProjectsPage'); }
    public function updatingFilterCourseId() { $this->resetPage('myProjectsPage'); $this->resetPage('allProjectsPage'); }

    public function render()
    {
        $student = Auth::user()->student;
        if (!$student) {
            return view('livewire.student.student-projects-page', [
                'invitations' => collect(), 'myProjects' => collect(), 'allProjects' => collect(),
            ]);
        }

        $invitations = Project::with(['creatorStudent', 'course'])
            ->whereHas('students', fn($q) => $q->where('students.id', $student->id)->where('project_student.membership_status', 'pending'))
            ->latest()->get();

            $myProjects = Project::with(['creatorStudent.user', 'students.user', 'course.specializations.department', 'doctor'])
            ->whereHas('students', fn($q) => $q->where('student_id', $student->id)->where('project_student.membership_status', 'approved'))
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%")->orWhere('description', 'like', "%{$this->search}%"))
            ->when($this->filter_status, fn($q) => $q->where('status', $this->filter_status))
            ->when($this->filter_course_id, fn($q) => $q->where('course_id', $this->filter_course_id))
            ->latest()->paginate(6, ['*'], 'myProjectsPage');

            $allProjects = Project::with(['creatorStudent.user', 'students.user', 'course.specializations.department', 'doctor'])
            ->whereIn('status', ['approved', 'completed'])
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%")->orWhere('description', 'like', "%{$this->search}%"))
            ->when($this->filter_course_id, fn($q) => $q->where('course_id', $this->filter_course_id))
            ->latest()->paginate(6, ['*'], 'allProjectsPage');

        return view('livewire.student.student-projects-page', [
            'invitations' => $invitations,
            'myProjects' => $myProjects,
            'allProjects' => $allProjects,
        ]);
    }
}
