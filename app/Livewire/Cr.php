<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

use App\Models\CRequest;
use App\Models\Company;
// use App\Models\EndProduct;
use App\Models\Project;
use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Cr extends Component
{
    use WithPagination;

    //public $ptitle = 'Değişiklik Talebi - Change Requests';
    public $action = 'LIST'; // LIST,FORM,VIEW

    public $item = false;

    public $isAdd = false;
    public $isEdit = false;
    public $isList = true;
    public $isView = false;

    public $canEdit = true;
    public $canDelete = true;

    public $search = '';
    public $sortField;
    public $sortDirection = 'asc';

    public $constants;

    public $cr_approvers = [];
    public $cr_approver = false;

    //public $isRelease = false;


    protected $listeners = [
        'runDelete'=>'deleteItem'
    ];


    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }
        $this->constants = config('crs');
    }



    public function updatedSearch () {
        $this->resetPage(); // Resets the page to 1
    }

    public function render()
    {
        $this->sortField = 'topic';

        $items = CRequest::where('topic', 'LIKE', "%".$this->search."%")
        ->orWhere('description', 'LIKE', "%".$this->search."%")
        ->orWhere('rej_reason_req', 'LIKE', "%".$this->search."%")
        ->orWhere('rej_reason_eng', 'LIKE', "%".$this->search."%")
        ->orderBy($this->sortField,$this->sortDirection)
        ->paginate(env('RESULTS_PER_PAGE'));

        return view('CR.cr',[
            'items' => $items
        ]);
    }



    public function viewItem($idItem)
    {
        $this->item = CRequest::find($idItem);
        $this->action = strtoupper('VIEW');
    }


    public function editItem($idItem)
    {
        $this->item = CRequest::find($idItem);
        $this->action = strtoupper('FORM');
    }

    public function deleteConfirm($idItem)
    {
        $this->item = CRequest::find($idItem);

        $this->dispatch('runConfirmDialog', 
            title: 'Do you really want to delete this item?',
            text: 'Once deleted, there is no reverting back!'
        );
    }

    // #[On('runDelete')]
    public function deleteItem($item)
    {
        dd('sss');

        $this->item->delete();
        session()->flash('message','Talep başarıyla silinmiştir.');
        $this->action = 'LIST';
    }


    public function delete($item)
    {
        dd('sss');

    }




}
