<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

use App\Models\Malzeme;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class Material extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW

    public $itemId = false;
    public $item = false;

    public $canAdd = true;
    public $canEdit = true;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection;

    public $constants;

    // Item Props
    public $family;
    public $form;
    public $description;
    public $specification;
    public $remarks;
    public $status="A";
    public $created_at;
    public $createdBy;


    protected $rules = [
        'family' => 'required',
        'form' => 'required',
        'description' => 'required',
    ];


    public function mount()
    {
        if (request('id')) {
            $this->itemId = request('id');
        }

        $this->action = strtoupper(request('action'));
        $this->constants = config('material');
    }

    #[Title('Materials')]
    #[On('refreshAttachments')]
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

            $this->sortDirection = $this->constants['list']['headers'][$this->sortField]['direction'];

            $items = Malzeme::where('description', 'LIKE', "%".$this->search."%")
            ->orWhere('remarks', 'LIKE', "%".$this->search."%")
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));

        }

        return view('Material.material',[
            'items' => $items,
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



    public function setUnsetProps($opt = 'set') {

        if ($opt === 'set') {
            $this->item = Malzeme::find($this->itemId);

            $this->item->canEdit = true;

            $this->form = $this->item->form;
            $this->family = $this->item->family;
            $this->description = $this->item->description;
            $this->specification = $this->item->specification;
            $this->remarks = $this->item->remarks;
            $this->status = $this->item->status;
            $this->created_at = $this->item->created_at;
            $this->createdBy = User::find($this->item->user_id);


        } else {
            $this->topic = '';
            $this->description = '';
            $this->is_for_ecn = false;
            $this->rejectReason = false;
            $this->status = false;
        }
    }







    public function viewItem($idItem) {
        $this->itemId = $idItem;
        $this->action = 'VIEW';
    }









    public function storeItem()
    {
        $this->validate();
        try {
            $this->item = Malzeme::create([
                'user_id' => Auth::id(),
                'form' => $this->form,
                'family' => $this->family,
                'description' => $this->description,
                'specification' => $this->specification,
                'remarks' => $this->remarks,
            ]);
            session()->flash('success','Material has been created successfully!');

            $this->itemId = $this->item->id;

            $this->dispatch('triggerAttachment',
                modelId: $this->itemId
            );

            $this->action = 'VIEW';

            //return redirect('/cr/view/'.$this->itemId);

        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!'.$ex);
        }
    }




    public function updateItem()
    {
        $this->validate();

        try {

            $this->item = Malzeme::whereId($this->itemId)->update([
                'user_id' => Auth::id(),
                'form' => $this->form,
                'family' => $this->family,
                'description' => $this->description,
                'specification' => $this->specification,
                'remarks' => $this->remarks,
                'status' => $this->status,

            ]);


            session()->flash('message','Material has been updated successfully!');

            $this->dispatch('triggerAttachment',
                modelId: $this->itemId
            );

            $this->action = 'VIEW';

        } catch (\Exception $ex) {
            session()->flash('success','Something goes wrong!!');
        }
    }


    public function usedBy()
    {



        return redirect('/parts/list?parts_uses_material=814');

    }



}
