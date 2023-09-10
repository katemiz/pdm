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
    public $canDelete = true;

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

            foreach ($items as $key => $item) {
                $items[$key]['canEdit'] = false;
                $items[$key]['canDelete'] = false;

                if ($item->status == 'wip') {
                    $items[$key]['canEdit'] = true;
                    $items[$key]['canDelete'] = true;
                }
            }
        }

        return view('Material.material',[
            'items' => $items,
        ]);
    }



    public function setUnsetProps($opt = 'set') {

        if ($opt === 'set') {
            $this->item = Malzeme::find($this->itemId);

            $this->item->canEdit = false;
            $this->item->canDelete = false;

            if ($this->item->status == 'wip') {
                $this->item->canEdit = true;
                $this->item->canDelete = true;
            }


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




}
