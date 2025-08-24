<?php

namespace App\Livewire\Admin;

use App\Models\Announcement;
use App\Models\Department;
use App\Models\Specialization;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed; // <-- [إضافة] لاستخدام الخصائص المحسوبة
use Carbon\Carbon; // <-- أضف هذا السطر هنا

class AnnouncementsPage extends Component
{
    use WithPagination;

    // خصائص لنموذج الإضافة/التعديل
    public $announcement_id;
    public $title, $content, $level = 'info', $expires_at;

    // خصائص للتحكم في الواجهة المتسلسلة
    public $target_audience_type = '';
    public $general_target_role = '';
    public $department_id = '';
    public $specialization_id = '';

    public $showForm = false;
    public $delete_id = null;

    // فلاتر البحث
    public $search = '';
    public $filter_level = '';
    public $filter_target_type = '';

    protected function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'level' => 'required|in:info,success,warning,danger',
            'expires_at' => 'nullable|date',
            'target_audience_type' => 'required',
        ];

        if ($this->target_audience_type === 'general') {
            $rules['general_target_role'] = 'required|in:global_all,global_students,global_doctors';
        } elseif ($this->target_audience_type === 'department') {
            $rules['department_id'] = 'required|exists:departments,id';
        } elseif ($this->target_audience_type === 'specialization') {
            $rules['department_id'] = 'required|exists:departments,id';
            $rules['specialization_id'] = 'required|exists:specializations,id';
        }

        return $rules;
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'target_audience_type') {
            $this->reset(['general_target_role', 'department_id', 'specialization_id']);
        }
        if ($propertyName === 'department_id') {
            $this->reset('specialization_id');
        }
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        try {
            $target_type = null;
            $target_id = null;

            if ($this->target_audience_type === 'general') {
                $target_type = $this->general_target_role;
            } elseif ($this->target_audience_type === 'department') {
                $target_type = 'department';
                $target_id = $this->department_id;
            } elseif ($this->target_audience_type === 'specialization') {
                $target_type = 'specialization';
                $target_id = $this->specialization_id;
            }

            $announcementData = [
                'user_id' => Auth::id(),
                'title' => $this->title,
                'content' => $this->content,
                'level' => $this->level,
                'expires_at' => $this->expires_at,
                'target_type' => $target_type,
                'target_id' => $target_id,
            ];

            $announcement = Announcement::updateOrCreate(['id' => $this->announcement_id], $announcementData);

            if (!$this->announcement_id) {
                $freshAnnouncement = Announcement::find($announcement->id);
                // التأكد من أن الدالة موجودة قبل استدعائها
                if (method_exists($freshAnnouncement, 'sendNotificationToTargets')) {
                    $freshAnnouncement->sendNotificationToTargets();
                }
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
        $announcement = Announcement::findOrFail($id);
        $this->announcement_id = $id;
        $this->title = $announcement->title;
        $this->content = $announcement->content;
        $this->level = $announcement->level;
        $this->expires_at = $announcement->expires_at ? Carbon::parse($announcement->expires_at)->format('Y-m-d\TH:i') : null;

        $target_type = $announcement->target_type;
        if (in_array($target_type, ['global_all', 'global_students', 'global_doctors'])) {
            $this->target_audience_type = 'general';
            $this->general_target_role = $target_type;
        } elseif ($target_type === 'department') {
            $this->target_audience_type = 'department';
            $this->department_id = $announcement->target_id;
        } elseif ($target_type === 'specialization') {
            $this->target_audience_type = 'specialization';
            $this->specialization_id = $announcement->target_id;
            $this->department_id = Specialization::find($announcement->target_id)?->department_id;
        }

        $this->showForm = true;
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
    }

    public function delete()
    {
        try {
            Announcement::findOrFail($this->delete_id)->delete();
            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف الإعلان بنجاح', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting announcement: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف الإعلان.', type: 'error');
        }
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function openForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    // --- [تحسين] استخدام الخصائص المحسوبة لجلب البيانات بكفاءة ---
    #[Computed(cache: true)]
    public function departments()
    {
        return Department::orderBy('name')->get();
    }

    #[Computed]
    public function specializations()
    {
        if (!$this->department_id) {
            return collect();
        }
        return Specialization::where('department_id', $this->department_id)->orderBy('name')->get();
    }
    // --- [نهاية التحسين] ---

    public function render()
    {
        $announcements = Announcement::with('user')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->when($this->filter_level, fn($q) => $q->where('level', $this->filter_level))
            ->when($this->filter_target_type, fn($q) => $q->where('target_type', $this->filter_target_type))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.announcements-page', [
            'announcements' => $announcements,
        ]);
    }
}
