<?php

namespace App\Livewire\admin;

use App\Models\Submission;
use App\Models\Assignment;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed; // <-- [إضافة]
use Illuminate\Support\Facades\Log;  // <-- [إضافة]

class SubmissionsPage extends Component
{
    use WithPagination;

    // --- خصائص التقييم ---
    public $grade_id = null;
    public $grade_value;
    public $feedback_text;
    public $showGradeForm = false;

    // --- خصائص عرض التفاصيل ---
    public $showViewModal = false;
    public $viewedSubmission = null;

    // --- خصائص البحث والفلاتر ---
    public $search = '';
    public $filter_assignment_id = '';
    public $filter_student_id = '';
    public $filter_status = '';

    // --- قواعد التحقق ---
    protected function rules()
    {
        return [
            'grade_value' => 'required|integer|min:0|max:100',
            'feedback_text' => 'nullable|string|max:1000',
        ];
    }

    public function openGradeForm($id)
    {
        try {
            $submission = Submission::findOrFail($id);
            $this->grade_id = $submission->id;
            $this->grade_value = $submission->grade;
            $this->feedback_text = $submission->feedback;
            $this->showGradeForm = true;
        } catch (\Exception $e) {
            Log::error('Error opening grade form: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على التسليم المطلوب.', type: 'error');
        }
    }

    public function saveGrade()
    {
        $this->validate();
        try {
            $submission = Submission::findOrFail($this->grade_id);
            $submission->update([
                'grade' => $this->grade_value,
                'feedback' => $this->feedback_text,
                'status' => 'graded',
            ]);
            $this->resetGradeForm();
            $this->dispatch('showToast', message: 'تم حفظ التقييم بنجاح', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error saving grade: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ التقييم.', type: 'error');
        }
    }

    public function resetGradeForm()
    {
        $this->reset(['grade_id', 'grade_value', 'feedback_text', 'showGradeForm']);
        $this->resetValidation();
    }

    public function viewSubmission($id)
    {
        try {
            $this->viewedSubmission = Submission::with(['assignment.course', 'assignment.doctor', 'student', 'files'])->findOrFail($id);
            $this->showViewModal = true;
        } catch (\Exception $e) {
            Log::error('Error viewing submission: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على التسليم المطلوب.', type: 'error');
        }
    }

    public function closeViewModal()
    {
        $this->reset(['viewedSubmission', 'showViewModal']);
    }

    // --- دوال إعادة تعيين الترقيم ---
    public function updating($property)
    {
        if (in_array($property, ['search', 'filter_assignment_id', 'filter_student_id', 'filter_status'])) {
            $this->resetPage();
        }
    }

    // --- [تحسين الأداء] الخصائص المحسوبة ---
    #[Computed(cache: true)]
    public function assignments() { return Assignment::orderBy('title')->get(); }

    #[Computed(cache: true)]
    public function students() { return Student::orderBy('name')->get(); }

    public function render()
    {
        $submissions = Submission::with(['assignment.course', 'assignment.doctor', 'student'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhereHas('student', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                      ->orWhereHas('assignment', fn($q) => $q->where('title', 'like', '%' . $this->search . '%'));
            })
            ->when($this->filter_assignment_id, fn($q) => $q->where('assignment_id', $this->filter_assignment_id))
            ->when($this->filter_student_id, fn($q) => $q->where('student_id', $this->filter_student_id))
            ->when($this->filter_status, fn($q) => $q->where('status', $this->filter_status))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.submissions-page', [
            'submissions' => $submissions,
            'statuses' => ['pending', 'submitted', 'graded', 'rejected'],
        ]);
    }
}
