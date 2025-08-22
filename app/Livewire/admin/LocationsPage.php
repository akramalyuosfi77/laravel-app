<?php

namespace App\Livewire\Admin;

use App\Models\Location;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log; // <-- [إضافة]

class LocationsPage extends Component
{
    use WithPagination;

    // --- خصائص النموذج ---
    public $location_id;
    public $name;
    public $type = 'hall';
    public $description;
    public $showForm = false;
    public $delete_id = null;

    // --- خصائص البحث ---
    public $search = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:locations,name,' . $this->location_id,
            'type' => 'required|in:hall,lab',
            'description' => 'nullable|string',
        ];
    }

    public function save()
    {
        $this->validate();
        try {
            Location::updateOrCreate(
                ['id' => $this->location_id],
                ['name' => $this->name, 'type' => $this->type, 'description' => $this->description]
            );
            $this->closeForm();
            $message = $this->location_id ? 'تم تحديث الموقع بنجاح.' : 'تم إضافة الموقع بنجاح.';
            $this->dispatch('showToast', message: $message, type: 'success');
        } catch (\Exception $e) {
            Log::error('Error saving location: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حفظ الموقع.', type: 'error');
        }
    }

    public function edit($id)
    {
        try {
            $location = Location::findOrFail($id);
            $this->location_id = $id;
            $this->name = $location->name;
            $this->type = $location->type;
            $this->description = $location->description;
            $this->showForm = true;
        } catch (\Exception $e) {
            Log::error('Error editing location: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على الموقع المطلوب.', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
    }

    public function delete()
    {
        try {
            Location::findOrFail($this->delete_id)->delete();
            $this->delete_id = null;
            $this->dispatch('showToast', message: 'تم حذف الموقع بنجاح.', type: 'success');
        } catch (\Exception $e) {
            Log::error('Error deleting location: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف الموقع.', type: 'error');
        }
    }

    public function resetForm()
    {
        $this->reset(['location_id', 'name', 'type', 'description']);
        $this->type = 'hall';
        $this->resetValidation();
    }

    public function openForm() { $this->resetForm(); $this->showForm = true; }
    public function closeForm() { $this->showForm = false; $this->resetForm(); }
    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $locations = Location::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.locations-page', ['locations' => $locations]);
    }
}
