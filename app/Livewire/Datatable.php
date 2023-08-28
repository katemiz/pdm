<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

use App\Models\Article;
use App\Models\CRequest;
use App\Models\Company;
use App\Models\EndProduct;
use App\Models\Project;
use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class Datatable extends Component
{
    use WithPagination;

    public $idItem;
    public $title;
    public $subtitle;

    public $model;

    public $search = '';
    public $sortField;
    public $sortDirection = 'asc';

    public $configs;

    public function render()
    {
        $items = [];

        switch ($this->model) {

            case 'Article':
                $this->sortField = 'prop1';
                $this->configs = config('articles');

                $items = Article::where('prop1', 'LIKE', "%".$this->search."%")
                ->orWhere('prop1', 'LIKE', "%".$this->search."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
                break;

            case 'EndProduct':
                $this->sortField = 'description';
                $this->configs = config('endproducts');

                $items = EndProduct::where('description', 'LIKE', "%".$this->search."%")
                // ->orWhere('remarks', 'LIKE', "%".$this->search."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
                break;

            case 'User':
                $this->sortField = 'name';
                $this->configs = config('users');

                $items = User::where('name', 'LIKE', "%".$this->search."%")
                ->orWhere('lastname', 'LIKE', "%".$this->search."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
                break;

            case 'Role':
                $this->sortField = 'name';
                $this->configs = config('roles');

                $items = Role::where('name', 'LIKE', "%".$this->search."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
                break;

            case 'Permission':
                $this->sortField = 'name';
                $this->configs = config('permissions');

                $items = Permission::where('name', 'LIKE', "%".$this->search."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
                break;

            case 'Company':
                $this->sortField = 'shortname';
                $this->configs = config('companies');

                $items = Company::where('shortname', 'LIKE', "%".$this->search."%")
                ->orWhere('fullname', 'LIKE', "%".$this->search."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
                break;


            case 'Project':
                $this->sortField = 'shortname';
                $this->configs = config('projects');

                $items = Project::where('shortname', 'LIKE', "%".$this->search."%")
                ->orWhere('fullname', 'LIKE', "%".$this->search."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
                break;


            case 'CR':
                $this->sortField = 'topic';
                $this->configs = config('crs');

                $items = CRequest::where('topic', 'LIKE', "%".$this->search."%")
                ->orWhere('description', 'LIKE', "%".$this->search."%")
                ->orWhere('rej_reason_req', 'LIKE', "%".$this->search."%")
                ->orWhere('rej_reason_eng', 'LIKE', "%".$this->search."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
                break;




        }



        return view('livewire.datatable', [
            'items' => $items
        ]);
    }

    public function resetFilter() {
        $this->reset('search');
    }


    public function deleteConfirm($idItem) {
        $this->idItem = $idItem;
        $this->dispatch('runConfirmDialog11', title:'Do you really want to delete this item ?',text:'Once deleted, there is no turning back!');
    }

    #[On('runDelete11')]
    public function deleteItem() {

        switch ($this->model) {

            case 'Article':
                Article::find($this->idItem)->delete();
                break;

            case 'EndProduct':
                EndProduct::find($this->idItem)->delete();
                break;

            case 'User':
                User::find($this->idItem)->delete();
                session()->flash('message','User deleted successfully!!');
                break;

            case 'Role':
                Role::find($this->idItem)->delete();
                session()->flash('message','Role deleted successfully!!');
                break;

            case 'Permission':
                Permission::find($this->idItem)->delete();
                session()->flash('message','Permission deleted successfully!!');
                break;

            case 'Company':
                Company::find($this->idItem)->delete();
                session()->flash('message','Company deleted successfully!!');
                break;

            case 'Project':
                Project::find($this->idItem)->delete();
                session()->flash('message','Project deleted successfully!!');
                break;

            case 'CR':
                Project::find($this->idItem)->delete();
                session()->flash('message','CR deleted successfully!!');
                break;


        }



        $this->dispatch('infoDeleted11');
    }

}
