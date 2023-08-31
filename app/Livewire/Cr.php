<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

use App\Models\CRequest;
use App\Models\Company;
// use App\Models\EndProduct;
use App\Models\Project;
use App\Models\User;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Cr extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW

    public $itemId = false;
    public $item = false;


    public $isAdd = false;
    public $isEdit = false;
    public $isList = true;
    public $isView = false;

    public $canAdd = true;
    public $canEdit = true;
    public $canDelete = true;

    public $search = '';
    public $sortField;
    public $sortDirection = 'asc';

    public $constants;

    public $cr_approvers = [];
    public $cr_approver = false;

    // Item Props
    public $topic;
    public $description;
    public $is_for_ecn = 0;

    protected $rules = [
        'topic' => 'required|min:5',
        'description' => 'required|min:10'
    ];


    //public $isRelease = false;


    protected $listeners = [
        'runDelete'=>'deleteItem'
    ];


    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->itemId = request('id');
        }
        $this->constants = config('crs');
    }



    public function updatedSearch () {
        $this->resetPage(); // Resets the page to 1
    }

    #[Title('Değişiklik Talebi - Change Request')]
    public function render()
    {
        $items = false;

        if ( $this->action === 'VIEW') {
            $this->setUnsetProps();
        }

        if ( $this->action === 'FORM' && $this->itemId) {
            $this->setUnsetProps();
        }

        if ( $this->action === 'LIST') {

            $this->sortField = 'topic';

            $items = CRequest::where('topic', 'LIKE', "%".$this->search."%")
            ->orWhere('description', 'LIKE', "%".$this->search."%")
            ->orWhere('rej_reason_req', 'LIKE', "%".$this->search."%")
            ->orWhere('rej_reason_eng', 'LIKE', "%".$this->search."%")
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }

        return view('CR.cr',[
            'items' => $items
        ]);
    }


    public function setUnsetProps($opt = 'set')
    {
        $this->item = CRequest::find($this->itemId);

        if ($opt === 'set') {
            $this->topic = $this->item->topic;
            $this->description = $this->item->description;
            $this->is_for_ecn = $this->item->is_for_ecn;
        } else {
            $this->topic = '';
            $this->description = '';
            $this->is_for_ecn = false;
        }

    }


    public function viewItem($idItem)
    {
        $this->itemId = $idItem;
        $this->action = 'VIEW';
    }


    public function editItem($idItem)
    {
        $this->itemId = $idItem;
        $this->action = 'FORM';
    }

    public function deleteConfirm($idItem)
    {
        $this->item = CRequest::find($idItem);

        $this->dispatch('runConfirmDialog',
            title: 'Do you really want to delete this item?',
            text: 'Once deleted, there is no reverting back!'
        );
    }

    public function deleteItem()
    {
        $this->item->delete();
        session()->flash('message','Talep başarıyla silinmiştir.');
        $this->action = 'LIST';
    }


    public function storeItem()
    {

        $this->validate();
        try {
            $this->item = CRequest::create([
                'topic' => $this->topic,
                'description' => $this->description,
                'is_for_ecn' => $this->is_for_ecn,
                'user_id' => Auth::id()
            ]);
            session()->flash('success','Change Request Created Successfully!');
            //$this->resetFields();

            //$this->dispatch('deleteFormDOM');

            $this->itemId = $this->item->id;


            $this->action = 'VIEW';

            $this->dispatch('triggerAttachment',
                id: $this->itemId
            );



        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!'.$ex);
        }
    }





    public function updateItem()
    {
        $this->validate();
        try {
            CRequest::whereId($this->itemId)->update([
                'topic' => $this->topic,
                'description' => $this->description,
                'is_for_ecn' => $this->is_for_ecn,
                'user_id' => Auth::id()
            ]);
            session()->flash('message','Article Updated Successfully!!');
            //$this->resetFields();


            $this->action = 'VIEW';

        } catch (\Exception $ex) {
            session()->flash('success','Something goes wrong!!');
        }
    }




}
