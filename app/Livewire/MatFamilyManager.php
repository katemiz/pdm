<?php

namespace App\Livewire;

use App\Models\MatFamily;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;


class MatFamilyManager extends Component
{
    use WithPagination;

    // Form properties
    public $name = '';
    public $code = '';
    public $description = '';
        public $content = '';

    public $is_active = true;

    // Component state
    public $editingId = null;
    public $deletingId = null; // For delete confirmation
    public $showForm = false;
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    // Validation rules
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:mat_families,name,' . $this->editingId,
            'code' => 'required|string|max:10|unique:mat_families,code,' . $this->editingId,
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ];
    }

    protected $validationAttributes = [
        'name' => 'family name',
        'code' => 'family code',
        'description' => 'description',
        'is_active' => 'active status',
    ];

    protected $messages = [
        'name.required' => 'The family name is required.',
        'name.unique' => 'This family name already exists.',
        'code.required' => 'The family code is required.',
        'code.unique' => 'This family code already exists.',
        'code.max' => 'The family code cannot exceed 10 characters.',
    ];

    // Lifecycle hooks
    public function mount()
    {
        $this->is_active = true;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Form actions
    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $family = MatFamily::findOrFail($id);

        $this->editingId = $id;
        $this->name = $family->name;
        $this->code = $family->code;
        $this->description = $family->description;
        $this->is_active = $family->is_active;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->editingId) {
                // Update existing record
                $family = MatFamily::findOrFail($this->editingId);
                $family->update([
                    'name' => $this->name,
                    'code' => $this->code,
                    'description' => $this->description,
                    'is_active' => $this->is_active,
                ]);

                session()->flash('message', 'Material family updated successfully!');
            } else {
                // Create new record
                MatFamily::create([
                    'name' => $this->name,
                    'code' => $this->code,
                    'description' => $this->description,
                    'is_active' => $this->is_active,
                ]);

                session()->flash('message', 'Material family created successfully!');
            }

            $this->resetForm();
            $this->showForm = false;

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
        }
    }





    public function deleteConfirm($id) {
        $this->deletingId = $id;
        $this->dispatch('ConfirmModal', type:'delete');
    }




    #[On('onDeleteConfirmed')]
    public function delete()
    {
        try {
            $family = MatFamily::findOrFail($this->deletingId);

            // Check if family has associated materials
            if ($family->materials()->count() > 0) {
                session()->flash('error', 'Cannot delete family with associated materials. Please delete or reassign materials first.');
                return;
            }

            $family->delete();
            session()->flash('message', 'Material family deleted successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
        }
    }



    public function toggleStatus($id)
    {
        try {
            $family = MatFamily::findOrFail($id);
            $family->update(['is_active' => !$family->is_active]);
            
            $status = $family->is_active ? 'activated' : 'deactivated';
            session()->flash('message', "Material family {$status} successfully!");

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
        }
    }



    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }






    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        
        $this->sortField = $field;
        $this->resetPage();
    }



    // Helper methods
    private function resetForm()
    {
        $this->editingId = null;
        $this->name = '';
        $this->code = '';
        $this->description = '';
        $this->is_active = true;
        $this->resetValidation();
    }





    // Search Reset 
    public function resetSearch()
    {
        $this->search = '';
        $this->resetPage();
    }





    // Render method
    public function render()
    {
        $families = MatFamily::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->withCount('materials')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.mat-family-manager', [
            'families' => $families
        ]);
    }
}
