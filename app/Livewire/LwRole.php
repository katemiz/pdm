<?php

namespace App\Livewire;

use App\Models\User;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;

class LwRole extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW
    public $constants;

    public $rid = false;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $logged_user;
    public $user;

    #[Rule('required', message: 'Please enter role name')] 
    public $name;

    public $created_at;
    public $updated_at;

    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->rid = request('id');
            $this->setProps();
        }

        $this->constants = config('roles');
    }


    public function render()
    {
        $roles = Role::where([
            ['name', 'LIKE', "%".$this->query."%"],
        ])
        ->orderBy($this->sortField,$this->sortDirection)
        ->paginate(env('RESULTS_PER_PAGE'));

        return view('admin.roles.lw-roles',[
            'roles' => $roles
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

    public function viewRole($rid) {
        $this->rid = $rid;
        $this->action = 'VIEW';

        $this->setProps();
    }

    public function editRole($rid) {
        $this->rid = $rid;
        $this->action = 'FORM';

        $this->setProps();
    }

    public function addRole() {
        $this->rid = false;
        $this->action = 'FORM';
    }


    public function setProps() {

        $r = Role::find($this->rid);

        $this->name = $r->name;
        $this->created_at = $r->created_at;
        $this->updated_at = $r->updated_at;
    }


    public function triggerDelete($rid) {
        $this->rid = $rid;
        $this->dispatch('ConfirmDelete');
    }


    #[On('onDeleteConfirmed')]
    public function deleteRole()
    {
        Role::find($this->rid)->delete();
        session()->flash('message','Role has been deleted successfully.');
        $this->action = 'LIST';
        $this->resetPage();
    }

    
    public function storeUpdateRole () {

        $this->validate();

        $props['name'] = $this->name;

        if ( $this->rid ) {
            // update
            Role::find($this->rid)->update($props);
            session()->flash('message','Role has been updated successfully.');

        } else {
            // create
            $role = Role::create($props);
            $this->rid = $role->id;
            session()->flash('message','Role has been created successfully.');
        }

        $this->action = 'VIEW';
    }
}
