<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use App\Models\Student;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Specialization;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;  // <-- [إضافة]
use Livewire\Attributes\Computed; // <-- [إضافة]

class ProjectsPage extends Component
{
    use WithPagination;

    // --- خصائص النموذج ---
    public $project_id = null;
    public $status;
    public $delete_id = null;

    // --- خصائص البحث والفلاتر ---
    public $search = '';
    public $filter_status = '';
    public $filter_batch_id = '';
    public $filter_specialization_id = '';
    public $filter_course_id = '';
    public $filter_creator_student_id = '';

    // --- خصائص الواجهة ---
    public $showChangeStatusModal = false;
    public $showViewModal = false;
    public $viewedProject = null;

    // --- قواعد التحقق ---
    protected function rules()
    {
        return [
            'status' => 'required|in:pending,approved,rejected,completed',
        ];
    }

    public function openChangeStatusModal($id)
    {
        try {
            $project = Project::findOrFail($id);
            $this->project_id = $id;
            $this->status = $project->status;
            $this->showChangeStatusModal = true;
        } catch (\Exception $e) {
            Log::error('Error opening change status modal for project: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على المشروع المطلوب.', type: 'error');
        }
    }

    public function saveStatus()
    {
        $this->validateOnly('status');
        try {
            $project = Project::findOrFail($this->project_id);
            $project->status = $this->status;
            $project->save();
            $this->closeChangeStatusModal();
            $this->dispatch('showToast', message: 'تم تحديث حالة المشروع بنجاح.', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error saving project status: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء تحديث حالة المشروع.', type: 'error');
        }
    }

    public function closeChangeStatusModal()
    {
        $this->reset(['project_id', 'status', 'showChangeStatusModal']);
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
    }

    public function delete()
    {
        try {
            DB::transaction(function () {
                $project = Project::with('files')->findOrFail($this->delete_id);
                foreach ($project->files as $file) {
                    Storage::disk('public')->delete($file->file_path);
                }
                $project->delete();
            });
            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف المشروع بنجاح.', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting project: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف المشروع.', type: 'error');
        }
    }

    public function viewProject($id)
    {
        try {
            // جلب كل العلاقات المطلوبة في استعلام واحد لتحسين الأداء
            $this->viewedProject = Project::with([
                'creatorStudent.user', 'students.user', 'batch', 'specialization',
                'course', 'files', 'likes.user', 'comments.user'
            ])->findOrFail($id);
            $this->showViewModal = true;
        } catch (\Exception $e) {
            Log::error('Error viewing project: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على المشروع المطلوب.', type: 'error');
        }
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewedProject = null;
    }

    // --- دوال إعادة تعيين الترقيم ---
    public function updating($property)
    {
        if (in_array($property, ['search', 'filter_status', 'filter_batch_id', 'filter_specialization_id', 'filter_course_id', 'filter_creator_student_id'])) {
            $this->resetPage();
        }
    }

    // --- [تحسين الأداء] الخصائص المحسوبة لجلب بيانات الفلاتر ---
    #[Computed(cache: true)]
    public function batches() { return Batch::orderBy('name')->get(); }

    #[Computed(cache: true)]
    public function specializations() { return Specialization::orderBy('name')->get(); }

    #[Computed(cache: true)]
    public function courses() { return Course::orderBy('name')->get(); }

    #[Computed(cache: true)]
    public function students() { return Student::orderBy('name')->get(); }

    public function render()
    {
        // بناء استعلام جلب المشاريع مع الفلاتر
        $projects = Project::with(['creatorStudent.user', 'batch', 'specialization', 'course'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhereHas('creatorStudent', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                      ->orWhereHas('course', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            })
            ->when($this->filter_status, fn($q) => $q->where('status', $this->filter_status))
            ->when($this->filter_batch_id, fn($q) => $q->where('batch_id', $this->filter_batch_id))
            ->when($this->filter_specialization_id, fn($q) => $q->where('specialization_id', $this->filter_specialization_id))
            ->when($this->filter_course_id, fn($q) => $q->where('course_id', $this->filter_course_id))
            ->when($this->filter_creator_student_id, fn($q) => $q->where('student_id', $this->filter_creator_student_id))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.projects-page', [
            'projects' => $projects,
            'projectStatuses' => ['pending', 'approved', 'rejected', 'completed'],
        ]);
    }
}
