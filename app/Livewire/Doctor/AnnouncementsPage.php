<?php

namespace App\Livewire\Doctor;

use App\Models\Announcement;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Carbon\Carbon;

class AnnouncementsPage extends Component
{
    use WithPagination;

    // --- خصائص النموذج ---
    public $announcement_id;
    public $title, $content, $level = 'info', $expires_at;
    public $course_id;

    // --- خصائص الواجهة ---
    public $showForm = false;
    public $delete_id = null;

    // --- خصائص البحث والفلاتر ---
    public $search = '';
    public $filter_course_id = '';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'level' => 'required|in:info,success,warning,danger',
            'expires_at' => 'nullable|date',
            'course_id' => 'required|exists:courses,id',
        ];
    }

    public function save()
    {
        $this->validate();
        try {
            $doctor = Auth::user()->doctor;
            // [أمان] التحقق من أن الدكتور يدرس هذه المادة قبل الحفظ
            if (!$doctor || !$doctor->courses()->where('courses.id', $this->course_id)->exists()) {
                $this->dispatch('showToast', message: 'غير مصرح لك بالنشر في هذه المادة.', type: 'error');
                return;
            }

            $announcementData = [
                'user_id' => Auth::id(),
                'title' => $this->title,
                'content' => $this->content,
                'level' => $this->level,
                'expires_at' => $this->expires_at,
                'target_type' => 'course',
                'target_id' => $this->course_id,
            ];

            $announcement = Announcement::updateOrCreate(['id' => $this->announcement_id], $announcementData);

            if (!$this->announcement_id) {
                $announcement->sendNotificationToTargets();
            }

            $this->closeForm();
            $message = $this->announcement_id ? 'تم تحديث الإعلان بنجاح' : 'تم نشر الإعلان بنجاح';
            $this->dispatch('showToast', message: $message, type: 'success');
        } catch (\Exception $e) {
            Log::error('Error saving announcement: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ الإعلان.', type: 'error');
        }
    }

    public function edit($id)
    {
        try {
            $announcement = Announcement::where('user_id', Auth::id())->findOrFail($id);
            $this->announcement_id = $id;
            $this->title = $announcement->title;
            $this->content = $announcement->content;
            $this->level = $announcement->level;
            $this->expires_at = $announcement->expires_at ? Carbon::parse($announcement->expires_at)->format('Y-m-d\TH:i') : null;
            $this->course_id = $announcement->target_id;
            $this->showForm = true;
        } catch (\Exception $e) {
            Log::error('Error editing announcement: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على الإعلان المطلوب.', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        // [أمان] التحقق من أن الدكتور هو من أنشأ الإعلان قبل عرض نافذة التأكيد
        if (Announcement::where('id', $id)->where('user_id', Auth::id())->doesntExist()) {
            $this->dispatch('showToast', message: 'غير مصرح لك بحذف هذا الإعلان.', type: 'error');
            return;
        }
        $this->delete_id = $id;
    }

    public function delete()
    {
        try {
            // [أمان] التحقق مرة أخرى قبل الحذف الفعلي
            Announcement::where('id', $this->delete_id)->where('user_id', Auth::id())->firstOrFail()->delete();
            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف الإعلان بنجاح', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting announcement: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف الإعلان.', type: 'error');
        }
    }

    // --- دوال مساعدة ---
    public function resetForm() { $this->reset(); $this->resetValidation(); }
    public function openForm() { $this->resetForm(); $this->showForm = true; }
    public function closeForm() { $this->showForm = false; $this->resetForm(); }
    public function updating($property) { if (in_array($property, ['search', 'filter_course_id'])) $this->resetPage(); }

    // --- [تحسين الأداء] الخصائص المحسوبة ---
    #[Computed(cache: true)]
    public function doctorCourses()
    {
        return Auth::user()->doctor?->courses()->orderBy('name')->get() ?? collect();
    }

    public function render()
    {
        $announcements = Announcement::where('user_id', Auth::id())
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->filter_course_id, fn($q) => $q->where('target_id', $this->filter_course_id)->where('target_type', 'course'))
            ->latest()
            ->paginate(10);

        return view('livewire.doctor.announcements-page', ['announcements' => $announcements]);
    }
}
