<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Company;
use App\Models\User;

class LwCompany extends Component
{
    use WithPagination;

    public $constants = [

        "filterText" => "Search ...",
        "listCaption" => false,

        "list" => [

            "id"=> [
                "title" => "Id",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "name"=> [
                "title" => "Name",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],
            "fullname"=> [
                "title" => "Fullname",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "created_at"=> [
                "title" => "Created On",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ]
        ]
    ];

    public $action = 'LIST'; // LIST,FORM,VIEW

    public $cid = false;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    #[Rule('required', message: 'Please enter company short name')]
    public $name;

    #[Rule('required', message: 'Please enter company fullname')]
    public $fullname;

    public $remarks;

    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;

    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->cid = request('id');
        }
    }


    public function render()
    {
        $this->setProps();

        return view('admin.companies.lw-companies',[
            'companies' => $this->getCompaniesList()
        ]);
    }


    public function getCompaniesList() {

        if ( !in_array($this->action,['LIST']) ) {
            return false;
        }

        if ( strlen($this->query) > 2) {
            $sonuc = Company::where('name', 'LIKE', "%".$this->query."%")
                ->orWhere('fullname','LIKE',"%".$this->query."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
        } else {

            $sonuc = Company::orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
        }
        return $sonuc;
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

    public function viewItem($cid) {
        $this->cid = $cid;
        $this->action = 'VIEW';
    }

    public function editItem($cid) {
        $this->cid = $cid;
        $this->action = 'FORM';
    }

    public function addItem() {
        $this->cid = false;
        $this->action = 'FORM';
        $this->reset('name','fullname','remarks');
    }


    public function setProps() {

        if ($this->cid) {
            $c = Company::find($this->cid);

            $this->name = $c->name;
            $this->fullname = $c->fullname;
            $this->created_at = $c->created_at;
            $this->remarks = $c->remarks;
            $this->updated_at = $c->updated_at;

            $this->created_by = User::find($c->user_id);
            $this->updated_by = User::find($c->updated_uid);
        }
    }


    public function triggerDelete($cid) {
        $this->cid = $cid;
        $this->dispatch('ConfirmDelete');
    }


    #[On('onDeleteConfirmed')]
    public function deleteRole()
    {
        Company::find($this->cid)->delete();
        session()->flash('message','Company has been deleted successfully.');
        $this->reset('cid');
        $this->action = 'LIST';
        $this->resetPage();
    }


    public function storeUpdateItem () {

        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['name'] = $this->name;
        $props['fullname'] = $this->fullname;
        $props['remarks'] = $this->remarks;

        if ( $this->cid ) {
            // update
            Company::find($this->cid)->update($props);
            session()->flash('message','Company has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $c = Company::create($props);
            $this->cid = $c->id;

            session()->flash('message','Company has been created successfully.');
        }

        $this->action = 'VIEW';
    }
}
