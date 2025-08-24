<?php

namespace App\Livewire\Admin;

use App\Models\Lecture;
use App\Models\Course;
use App\Models\Doctor;
use App\Models\LectureFile;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;   // <-- [إضافة]
use Illuminate\Support\Facades\Log;  // <-- [إضافة]
use Illuminate\Support\Str;
use App\Livewire\Traits\WithSecureFileUploads;
use Livewire\Attributes\Computed; // <-- [إضافة]
use Carbon\Carbon; // <-- [إضافة]

class LecturesPage extends Component
{
    use WithPagination, WithFileUploads, WithSecureFileUploads;

    // --- خصائص النموذج ---
    public $lecture_id;
    public $title, $description, $course_id, $doctor_id, $lecture_date;
    public $new_files = [];
    public $file_types = [];
    public $file_descriptions = [];
    public $existing_files = [];
    public $files_to_delete = [];

    // --- خصائص الواجهة ---
    public $showForm = false;
    public $delete_id = null;
    public $showViewModal = false;
    public $viewedLecture = null;

    // --- خصائص البحث والفلاتر ---
    public $search = '';
    public $filter_course_id = '';
    public $filter_doctor_id = '';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'doctor_id' => 'required|exists:doctors,id',
            'lecture_date' => 'nullable|date',
            'new_files.*' => $this->secureFileUploadRules(20480), // 20MB max
            'file_types.*' => 'nullable|string',
            'file_descriptions.*' => 'nullable|string|max:500',
        ];
    }

    public function mount() { $this->addNewFile(); }
    public function updated($propertyName) { $this->validateOnly($propertyName); }

    /**
     * دالة save() المحسّنة.
     * تستخدم DB::transaction لضمان أن عملية حفظ المحاضرة وملفاتها
     * تتم كوحدة واحدة لا تتجزأ.
     */
    public function save()
    {
        $this->validate();
        try {
            DB::transaction(function () {
                $lectureData = [
                    'title' => $this->title,
                    'description' => $this->description,
                    'course_id' => $this->course_id,
                    'doctor_id' => $this->doctor_id,
                    'lecture_date' => $this->lecture_date,
                ];

                $lecture = Lecture::updateOrCreate(['id' => $this->lecture_id], $lectureData);

                // معالجة الملفات الجديدة
                foreach ($this->new_files as $index => $file) {
                    if ($file) {
                        $filePath = $file->store('lecture_files', 'public');
                        $lecture->files()->create([
                            'file_path' => $filePath,
                            'file_name' => $file->getClientOriginalName(),
                            'file_type' => $file->getMimeType(),
                            'file_size' => $file->getSize(),
                            'description' => $this->file_descriptions[$index] ?? null,
                            'type' => $this->file_types[$index] ?? 'other',
                        ]);
                    }
                }

                // حذف الملفات المحددة
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
            $lecture = Lecture::with('files')->findOrFail($id);
            $this->lecture_id = $id;
            $this->title = $lecture->title;
            $this->description = $lecture->description;
            $this->course_id = $lecture->course_id;
            $this->doctor_id = $lecture->doctor_id;
            $this->lecture_date = $lecture->lecture_date ? Carbon::parse($lecture->lecture_date)->format('Y-m-d') : null;
            $this->existing_files = $lecture->files->toArray();
            $this->reset(['new_files', 'file_types', 'file_descriptions', 'files_to_delete']);
            $this->showForm = true;
        } catch (\Exception $e) {
            Log::error('Error editing lecture: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على المحاضرة المطلوبة.', type: 'error');
        }
    }

    public function confirmDelete($id) { $this->delete_id = $id; }

    public function deleteLecture()
    {
        try {
            DB::transaction(function () {
                $lecture = Lecture::with('files')->findOrFail($this->delete_id);
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

    // --- دوال مساعدة ---
    public function resetForm()
    {
        $this->reset(['lecture_id', 'title', 'description', 'course_id', 'doctor_id', 'lecture_date', 'new_files', 'file_types', 'file_descriptions', 'existing_files', 'files_to_delete']);
        $this->addNewFile();
        $this->resetValidation();
    }
    public function openForm() { $this->resetForm(); $this->showForm = true; }
    public function closeForm() { $this->showForm = false; $this->resetForm(); }
    public function addNewFile() { $this->new_files[] = null; $this->file_types[] = null; $this->file_descriptions[] = null; }
    public function removeNewFile($index) { unset($this->new_files[$index], $this->file_types[$index], $this->file_descriptions[$index]); }
    public function markFileForDeletion($fileId) { $this->files_to_delete[] = $fileId; $this->existing_files = array_filter($this->existing_files, fn($file) => $file['id'] != $fileId); }
    public function viewLecture($id) { $this->viewedLecture = Lecture::with(['course', 'doctor', 'files'])->findOrFail($id); $this->showViewModal = true; }
    public function closeViewModal() { $this->showViewModal = false; $this->viewedLecture = null; }

    // --- دوال إعادة تعيين الترقيم ---
    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterCourseId() { $this->resetPage(); }
    public function updatingFilterDoctorId() { $this->resetPage(); }

    // --- [تحسين الأداء] الخصائص المحسوبة ---
    #[Computed(cache: true)]
    public function courses() { return Course::orderBy('name')->get(); }

    #[Computed(cache: true)]
    public function doctors() { return Doctor::orderBy('name')->get(); }

    public function render()
    {
        $lectures = Lecture::with(['course', 'doctor'])
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%'))
            ->when($this->filter_course_id, fn($q) => $q->where('course_id', $this->filter_course_id))
            ->when($this->filter_doctor_id, fn($q) => $q->where('doctor_id', $this->filter_doctor_id))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.lectures-page', ['lectures' => $lectures]);
    }
}
