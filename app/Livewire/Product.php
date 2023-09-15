<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

use App\Models\CNotice;
use App\Models\Counter;
use App\Models\Malzeme;
use App\Models\Urun;
use App\Models\User;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class Product extends Component
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
    public $sortField = 'created_at';
    public $sortDirection;

    public $constants;

    public $mat_family = false;
    public $mat_form = false;
    public $materials = [];

    // Item Props
    public $mat_id;
    public $description;
    public $ecn_id;
    public $version;
    public $status;
    public $notes = [];

    public $createdBy;
    public $checkedBy;
    public $approvedBy;

    public $created_at;
    public $req_reviewed_at;
    public $eng_reviewed_at;

    public $remarks;

    protected $rules = [
        'description' => 'required|min:10',
        'ecn_id' => 'required'
    ];


    public function mount()
    {
        if (request('id')) {
            $this->itemId = request('id');
        }

        $this->action = strtoupper(request('action'));
        $this->constants = config('product');
    }


    #[Title('Products')]
    #[On('refreshAttachments')]
    public function render()
    {
        $ecns = CNotice::where('status','wip')->get();
        $items = false;

        if ( $this->action === 'VIEW') {
            $this->setUnsetProps();
        }

        if ( $this->action === 'FORM' && $this->itemId) {
            $this->setUnsetProps();
        }

        if ( $this->action === 'LIST') {

            $this->sortDirection = $this->constants['list']['headers'][$this->sortField]['direction'];

            $items = Urun::where('product_no', 'LIKE', "%".$this->search."%")
            ->orWhere('description', 'LIKE', "%".$this->search."%")
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

        return view('products.products',[
            'items' => $items,
            'ecns' => $ecns
        ]);
    }




    public function getMaterialList() {

        if ($this->mat_family && $this->mat_form) {
            $this->materials = Malzeme::where('family', $this->mat_family)
            ->where('form', $this->mat_form)
            ->orderBy($this->sortField,'asc')->get();

        }
    }


    public function setUnsetProps($opt = 'set') {

        if ($opt === 'set') {
            $this->item = Urun::find($this->itemId);

            $this->mat_id = $this->item->malzeme_id;

            $this->item->canEdit = false;
            $this->item->canDelete = false;

            if ($this->item->status == 'wip') {
                $this->item->canEdit = true;
                $this->item->canDelete = true;
            }

            $this->createdBy = User::find($this->item->user_id);
            $this->checkedBy = User::find($this->item->checker_id);
            $this->approvedBy = User::find($this->item->approver_id);

            $this->product_no = $this->item->product_no;
            $this->version = $this->item->version;

            $malzeme =  Malzeme::find($this->item->malzeme_id);

            $this->item->material_definition = $malzeme->material_definition;
            $this->item->family = $malzeme->family;
            $this->item->form = $malzeme->form;

            $this->mat_family = $malzeme->family;
            $this->mat_form = $malzeme->form;


            $this->getMaterialList();


            $this->description = $this->item->description;
            $this->ecn_id = $this->item->c_notice_id;
            $this->remarks = $this->item->remarks;
            $this->notes = explode(',',$this->item->notes);


            $this->status = $this->item->status;

            $this->created_at = $this->item->created_at;
            $this->check_reviewed_at = $this->item->check_reviewed_at;
            $this->app_reviewed_at = $this->item->app_reviewed_at;

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

        // dd([
        //     'malzeme_id' => $this->mat_id,
        //     'description' => $this->description,
        //     'product_no' => $this->getProductNo(),
        //     'c_notice_id' => $this->ecn_id,
        //     'remarks' => $this->remarks,
        //     'user_id' => Auth::id()
        // ]);


        $this->validate();
        try {
            $this->item = Urun::create([
                'malzeme_id' => $this->mat_id,
                'description' => $this->description,
                'product_no' => $this->getProductNo(),
                'c_notice_id' => $this->ecn_id,
                'notes' => implode(',',$this->notes),
                'remarks' => $this->remarks,
                'user_id' => Auth::id()
            ]);
            session()->flash('success','Product has been created successfully!');

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

        dd($this->notes);

        try {

            $this->item = Urun::whereId($this->itemId)->update([
                'malzeme_id' => $this->mat_id,
                'description' => $this->description,
                'product_no' => $this->getProductNo(),
                'c_notice_id' => $this->ecn_id,
                'remarks' => $this->remarks,
                'notes' => implode(',',$this->notes)
            ]);

            // dd($this->notes);
            // dd(implode(',',$this->notes));

            session()->flash('message','Product has been updated successfully!');

            $this->dispatch('triggerAttachment',
                modelId: $this->itemId
            );

            $this->action = 'VIEW';

        } catch (\Exception $ex) {
            session()->flash('success','Something goes wrong!!');
        }
    }


    public function getProductNo() {

        $counter = Counter::find(69);
        $new_no = $counter->product_no+1;
        $counter->update(['product_no' => $new_no]);         // Update Counter

        return $new_no;
    }








}
