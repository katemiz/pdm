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


    public $topic;
    //public $description;
    public $description="<p>Hadi Deneyelim 22222</p>";

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
        $this->constants = config('crs');
    }



    public function updatedSearch () {
        $this->resetPage(); // Resets the page to 1
    }

    #[Title('Değişiklik Talebi - Change Request')] 
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
        $this->action = 'VIEW';
    }


    public function editItem($idItem)
    {
        $this->item = CRequest::find($idItem);
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


            $this->action = 'VIEW';



        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!'.$ex);
        }
    }





    public function updateItem()
    {
        $this->validate();
        try {
            Article::whereId($this->idArticle)->update([
                'prop1' => $this->prop1,
                'prop2' => $this->prop2
            ]);
            session()->flash('message','Article Updated Successfully!!');
            $this->resetFields();

            $this->article = Article::find($this->idArticle);

            $this->isAdd = false;
            $this->isEdit = false;
            $this->isList = false;
            $this->isView = true;

        } catch (\Exception $ex) {
            session()->flash('success','Something goes wrong!!');
        }
    }




}
