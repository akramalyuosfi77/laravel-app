<?php

namespace App\Livewire\admin;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log; // <-- [إضافة] لتسجيل الأخطاء

class DepartmentsPage extends Component
{
    use WithPagination;

    // --- خصائص النموذج ---
    public $name, $description;
    public $edit_id = null;
    public $delete_id = null;
    public $showForm = false;

    // --- خصائص البحث ---
    public $search = '';

    // --- قواعد التحقق ---
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:departments,name,' . $this->edit_id,
            'description' => 'nullable|string',
        ];
    }

    public function save()
    {
        $this->validate();
        try {
            Department::updateOrCreate(
                ['id' => $this->edit_id],
                ['name' => $this->name, 'description' => $this->description]
            );

            $this->closeForm();
            $message = $this->edit_id ? 'تم تحديث القسم بنجاح' : 'تم إضافة القسم بنجاح';
            $this->dispatch('showToast', message: $message, type: 'success');

        } catch (\Exception $e) {
            Log::error('Error saving department: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ القسم.', type: 'error');
        }
    }

    public function edit($id)
    {
        try {
            $dept = Department::findOrFail($id);
            $this->edit_id = $dept->id;
            $this->name = $dept->name;
            $this->description = $dept->description;
            $this->showForm = true;
        } catch (\Exception $e) {
            Log::error('Error editing department: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على القسم المطلوب.', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
    }

    public function delete()
    {
        try {
            Department::findOrFail($this->delete_id)->delete();
            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف القسم بنجاح', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting department: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف القسم.', type: 'error');
        }
    }

    // --- دوال مساعدة ---
    public function resetForm()
    {
        $this->reset(['name', 'description', 'edit_id']);
        $this->resetValidation();
    }
    public function openForm() { $this->resetForm(); $this->showForm = true; }
    public function closeForm() { $this->showForm = false; $this->resetForm(); }
    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $departments = Department::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        })
        ->latest()
        ->paginate(10);

        return view('livewire.admin.departments-page', compact('departments'));
    }
}
