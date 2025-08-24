<?php

namespace App\Livewire\Doctor;

use App\Models\Lecture;
use App\Models\Course;
use App\Models\LectureFile;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Livewire\Traits\WithSecureFileUploads;
use Livewire\Attributes\Computed;
use Carbon\Carbon;

class LecturesPage extends Component
{
    use WithPagination, WithFileUploads, WithSecureFileUploads;

    // --- خصائص النموذج ---
    public $lecture_id;
    public $title, $description, $course_id, $lecture_date;
    public $new_files = [], $file_types = [], $file_descriptions = [];
    public $existing_files = [], $files_to_delete = [];

    // --- خصائص الواجهة ---
    public $showForm = false;
    public $delete_id = null;
    public $showViewModal = false;
    public $viewedLecture = null;

    // --- خصائص البحث والفلاتر ---
    public $search = '';
    public $filter_course_id = '';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'lecture_date' => 'nullable|date',
            'new_files.*' => $this->secureFileUploadRules(20480),
            'file_types.*' => 'nullable|string',
            'file_descriptions.*' => 'nullable|string|max:500',
        ];
    }

    public function mount() { $this->addNewFile(); }

    public function save()
    {
        $this->validate();
        try {
            DB::transaction(function () {
                $doctor = Auth::user()->doctor;
                if (!$doctor || !$this->doctorCourses->contains($this->course_id)) {
                    throw new \Exception('غير مصرح لك بالنشر في هذه المادة.');
                }

                $lecture = Lecture::updateOrCreate(
                    ['id' => $this->lecture_id],
                    ['title' => $this->title, 'description' => $this->description, 'course_id' => $this->course_id, 'doctor_id' => $doctor->id, 'lecture_date' => $this->lecture_date]
                );

                foreach ($this->new_files as $index => $file) {
                    if ($file) {
                        $filePath = $file->store('lecture_files', 'public');
                        $lecture->files()->create([
                            'file_path' => $filePath, 'file_name' => $file->getClientOriginalName(), 'file_type' => $file->getMimeType(),
                            'file_size' => $file->getSize(), 'description' => $this->file_descriptions[$index] ?? null, 'type' => $this->file_types[$index] ?? 'other',
                        ]);
                    }
                }

                if (!empty($this->files_to_delete)) {
                    $filesToDelete = LectureFile::whereIn('id', $this->files_to_delete)->where('lecture_id', $lecture->id)->get();
                    foreach ($filesToDelete as $file) {
                        Storage::disk('public')->delete($file->file_path);
                        $file->delete();
                    }
                }
            });

            $this->closeForm();
            $message = $this->lecture_id ? 'تم تحديث المحاضرة بنجاح' : 'تم إضافة المحاضرة بنجاح';
            $this->dispatch('showToast', message: $message, type: 'success');
        } catch (\Exception $e) {
            Log::error('Error saving lecture: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ المحاضرة.', type: 'error');
        }
    }

    public function edit($id)
    {
        try {
            $lecture = Lecture::where('doctor_id', Auth::user()->doctor->id)->findOrFail($id);
            $this->lecture_id = $lecture->id;
            $this->title = $lecture->title;
            $this->description = $lecture->description;
            $this->course_id = $lecture->course_id;
            $this->lecture_date = $lecture->lecture_date ? Carbon::parse($lecture->lecture_date)->format('Y-m-d') : null;
            $this->existing_files = $lecture->files->toArray();
            $this->reset(['new_files', 'file_types', 'file_descriptions', 'files_to_delete']);
            $this->showForm = true;
        } catch (\Exception $e) {
            Log::error('Error editing lecture: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على المحاضرة المطلوبة.', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        if (Lecture::where('id', $id)->where('doctor_id', Auth::user()->doctor->id)->doesntExist()) {
            $this->dispatch('showToast', message: 'غير مصرح لك بحذف هذه المحاضرة.', type: 'error');
            return;
        }
        $this->delete_id = $id;
    }

    public function deleteLecture()
    {
        try {
            DB::transaction(function () {
                $lecture = Lecture::with('files')->where('id', $this->delete_id)->where('doctor_id', Auth::user()->doctor->id)->firstOrFail();
                foreach ($lecture->files as $file) {
                    Storage::disk('public')->delete($file->file_path);
                }
                $lecture->delete();
            });
            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف المحاضرة بنجاح', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting lecture: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف المحاضرة.', type: 'error');
        }
    }

    public function viewLecture($id)
    {
        try {
            $this->viewedLecture = Lecture::with(['course', 'doctor', 'files'])->findOrFail($id);
            $this->showViewModal = true;
        } catch (\Exception $e) {
            Log::error('Error viewing lecture: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على المحاضرة المطلوبة.', type: 'error');
        }
    }

    // --- دوال مساعدة ---
    public function resetForm() { $this->reset(); $this->addNewFile(); $this->resetValidation(); }
    public function openForm() { $this->resetForm(); $this->showForm = true; }
    public function closeForm() { $this->showForm = false; $this->resetForm(); }
    public function closeViewModal() { $this->showViewModal = false; $this->viewedLecture = null; }
    public function addNewFile() { $this->new_files[] = null; $this->file_types[] = null; $this->file_descriptions[] = null; }
    public function removeNewFile($index) { unset($this->new_files[$index], $this->file_types[$index], $this->file_descriptions[$index]); }
    public function markFileForDeletion($fileId) { $this->files_to_delete[] = $fileId; $this->existing_files = array_filter($this->existing_files, fn($file) => $file['id'] != $fileId); }
    public function updating($property) { if (in_array($property, ['search', 'filter_course_id'])) $this->resetPage(); }

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
            return view('livewire.doctor.lectures-page', ['lectures' => collect()]);
        }

        $lectures = Lecture::with('course')
            ->where('doctor_id', $doctor->id)
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->filter_course_id, fn($q) => $q->where('course_id', $this->filter_course_id))
            ->latest()
            ->paginate(10);

        return view('livewire.doctor.lectures-page', ['lectures' => $lectures]);
    }
}
