<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Permission;


class LwPermission extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW
    public $constants;

    public $pid = false;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    #[Rule('required', message: 'Please permission role name')] 
    public $name;

    public $created_at;
    public $updated_at;

    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->pid = request('id');
            $this->setProps();
        }

        $this->constants = config('permissions');
    }


    public function render()
    {
        $permissions = Permission::where([
            ['name', 'LIKE', "%".$this->query."%"],
        ])
        ->orderBy($this->sortField,$this->sortDirection)
        ->paginate(env('RESULTS_PER_PAGE'));

        return view('admin.permissions.lw-permissions',[
            'permissions' => $permissions
        ]);
    }


    public function changeSortDirection ($key) {

        $this->sortField = $key;

        if ($this->constants['list']['headers'][$key]['direction'] == 'asc') {
            $this->constants['list']['headers'][$key]['direction'] = 'desc';
        } else {
            $this->constants['list']['headers'][$key]['direction'] = 'asc';
        }

        $this->sortDirection = $this->constants['list']['headers'][$key]['direction'];
    }

    public function resetFilter() {
        $this->query = '';
    }

    public function viewPermission($pid) {
        $this->pid = $pid;
        $this->action = 'VIEW';

        $this->setProps();
    }

    public function editPermission($pid) {
        $this->pid = $pid;
        $this->action = 'FORM';

        $this->setProps();
    }

    public function addPermission() {
        $this->pid = false;
        $this->action = 'FORM';

        $this->reset('name');
    }


    public function setProps() {

        $p = Permission::find($this->pid);

        $this->name = $p->name;
        $this->created_at = $p->created_at;
        $this->updated_at = $p->updated_at;
    }


    public function triggerDelete($pid) {
        $this->pid = $pid;
        $this->dispatch('ConfirmDelete');
    }


    #[On('onDeleteConfirmed')]
    public function deleteRole()
    {
        Permission::find($this->pid)->delete();
        session()->flash('message','Permission has been deleted successfully.');
        $this->action = 'LIST';
        $this->resetPage();
    }

    
    public function storeUpdatePermission () {

        $this->validate();

        $props['name'] = $this->name;

        if ( $this->pid ) {
            // update
            Permission::find($this->pid)->update($props);
            session()->flash('message','Permission has been updated successfully.');

        } else {
            // create
            $permission = Permission::create($props);
            $this->pid = $permission->id;

            session()->flash('message','Permission has been created successfully.');
        }

        $this->action = 'VIEW';
    }
}
