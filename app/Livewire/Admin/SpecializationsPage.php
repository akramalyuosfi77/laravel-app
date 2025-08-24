<?php

namespace App\Livewire\Admin;

use App\Models\Specialization;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed; // <-- [إضافة]
use Illuminate\Support\Facades\Log;  // <-- [إضافة]

class SpecializationsPage extends Component
{
    use WithPagination;

    // --- خصائص النموذج ---
    public $name, $description, $department_id, $duration;
    public $edit_id = null;
    public $delete_id = null;
    public $showForm = false;

    // --- خصائص البحث ---
    public $search = '';

    // --- قواعد التحقق ---
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:specializations,name,' . $this->edit_id,
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'duration' => 'required|string|max:255',
        ];
    }

    public function save()
    {
        $this->validate();
        try {
            Specialization::updateOrCreate(
                ['id' => $this->edit_id],
                [
                    'name' => $this->name,
                    'description' => $this->description,
                    'department_id' => $this->department_id,
                    'duration' => $this->duration,
                ]
            );

            $this->closeForm();
            $message = $this->edit_id ? 'تم تحديث التخصص بنجاح' : 'تم إضافة التخصص بنجاح';
            $this->dispatch('showToast', message: $message, type: 'success');

        } catch (\Exception $e) {
            Log::error('Error saving specialization: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ التخصص.', type: 'error');
        }
    }

    public function edit($id)
    {
        try {
            $specialization = Specialization::findOrFail($id);
            $this->edit_id = $specialization->id;
            $this->name = $specialization->name;
            $this->description = $specialization->description;
            $this->department_id = $specialization->department_id;
            $this->duration = $specialization->duration;
            $this->showForm = true;
        } catch (\Exception $e) {
            Log::error('Error editing specialization: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على التخصص المطلوب.', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
    }

    public function delete()
    {
        try {
            Specialization::findOrFail($this->delete_id)->delete();
            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف التخصص بنجاح', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting specialization: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف التخصص.', type: 'error');
        }
    }

    // --- دوال مساعدة ---
    public function resetForm()
    {
        $this->reset(['name', 'description', 'department_id', 'duration', 'edit_id']);
        $this->resetValidation();
    }
    public function openForm() { $this->resetForm(); $this->showForm = true; }
    public function closeForm() { $this->showForm = false; $this->resetForm(); }
    public function updatingSearch() { $this->resetPage(); }

    // --- [تحسين الأداء] الخصائص المحسوبة ---
    #[Computed(cache: true)]
    public function departments()
    {
        return Department::orderBy('name')->get();
    }

    public function render()
    {
        $specializations = Specialization::with('department')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('duration', 'like', '%' . $this->search . '%')
                      ->orWhereHas('department', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.specializations-page', [
            'specializations' => $specializations,
        ]);
    }
}
