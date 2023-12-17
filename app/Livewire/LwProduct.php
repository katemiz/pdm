<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

use App\Models\CNotice;
use App\Models\Counter;
use App\Models\Fnote;
use App\Models\Malzeme;
use App\Models\Urun;
use App\Models\NoteCategory;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class LwProduct extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW

    public $itemId = false;

    public $isAdd = false;
    public $isEdit = false;
    public $isList = true;
    public $isView = false;

    public $canUserAdd = true;
    public $canUserEdit = true;
    public $canUserDelete = true;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection;

    public $product_no;

    public $constants;

    public $mat_family = false;
    public $mat_form = false;

    public $material_definition;
    public $family;
    public $form;

    public $notes = [];

    public $materials = [];
    public $ncategories = [];
    public $notes_id_array = [];

    // Item Props
    #[Validate('required|numeric', message: 'Please select material')]
    public $mat_id;

    #[Validate('required', message: 'Please write part name/title')]
    public $description;

    #[Validate('required|numeric', message: 'Please select ECN')]
    public $ecn_id;

    public $isItemEditable = false;
    public $isItemDeleteable = false;

    public $version;
    public $status;
    public $unit = 'mm';
    public $weight;

    public $createdBy;
    public $checkedBy;
    public $approvedBy;

    public $created_at;
    public $req_reviewed_at;
    public $eng_reviewed_at;

    public $fno     = [];
    public $fnotes  = [];

    public $remarks;



    public function mount()
    {
        if (request('id')) {
            $this->itemId = request('id');
            foreach (Fnote::where('urun_id',$this->itemId)->get() as $r) {
                $this->fnotes[] = ['no' => $r->no,'text_tr' => $r->text_tr,'text_en' => $r->text_en];
            }
        }

        $this->action = strtoupper(request('action'));
        $this->constants = config('product');
        $this->ncategories = NoteCategory::orderBy('text_tr')->get();
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
                $items[$key]['isItemEditable'] = false;
                $items[$key]['isItemDeleteable'] = false;

                if ($item->status == 'wip') {
                    $items[$key]['isItemEditable'] = true;
                    $items[$key]['isItemDeleteable'] = true;
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

            $item = Urun::find($this->itemId);

            $this->mat_id = $item->malzeme_id;

            if ($item->status == 'wip') {
                $this->isItemEditable = true;
                $this->isItemDeleteable = true;
            }

            $this->createdBy = User::find($item->user_id);
            $this->checkedBy = User::find($item->checker_id);
            $this->approvedBy = User::find($item->approver_id);

            $this->product_no = $item->product_no;
            $this->version = $item->version;
            $this->weight = $item->weight;
            $this->unit = $item->unit;

            $malzeme =  Malzeme::find($item->malzeme_id);

            $this->material_definition = $malzeme->material_definition;
            $this->family = $malzeme->family;
            $this->form = $malzeme->form;

            $this->mat_family = $malzeme->family;
            $this->mat_form = $malzeme->form;

            $this->getMaterialList();

            $this->description = $item->description;
            $this->ecn_id = $item->c_notice_id;
            $this->remarks = $item->remarks;

            $this->status = $item->status;

            $this->created_at = $item->created_at;
            $this->check_reviewed_at = $item->check_reviewed_at;
            $this->app_reviewed_at = $item->app_reviewed_at;

            $this->notes_id_array = [];

            //dd($item->notes);

            $this->notes = $item->notes;

            foreach ($item->notes as $note) {
                //array_push($this->notes,$note);
                array_push($this->notes_id_array,$note->id);
            }

            //dd($this->notes_id_array);

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
            $this->item = Urun::create([
                'malzeme_id' => $this->mat_id,
                'description' => $this->description,
                'product_no' => $this->getProductNo(),
                'c_notice_id' => $this->ecn_id,
                'weight' => $this->weight,
                'unit' => $this->unit,
                'remarks' => $this->remarks,
                'user_id' => Auth::id()
            ]);
            session()->flash('success','Product has been created successfully!');

            // Attach Notes to Product
            $this->item->notes()->attach($this->notes_id_array);

            $this->itemId = $this->item->id;

            // Flag Notes (Special Notes)
            foreach ($this->fnotes as $fnote) {

                $props['urun_id'] = $this->itemId;
                $props['no'] = $fnote['no'];
                $props['text_tr'] = $fnote['text_tr'];

                Fnote::create($props);

                //dd($fnote);
            }

            $this->dispatch('triggerAttachment',
                modelId: $this->itemId
            );

            $this->action = 'VIEW';

        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!'.$ex);
        }
    }



    public function updateItem()
    {
        $this->validate();

        try {

            Urun::whereId($this->itemId)->update([
                'malzeme_id' => $this->mat_id,
                'description' => $this->description,
                'c_notice_id' => $this->ecn_id,
                'weight' => $this->weight,
                'unit' => $this->unit,
                'remarks' => $this->remarks
            ]);

            $aaa = Urun::find($this->itemId);

            // Update Notes to Product
            $aaa->notes()->detach();
            $aaa->notes()->attach(array_unique($this->notes_id_array));

            // Flag Notes (Special Notes)
            Fnote::where('urun_id',$this->itemId)->delete();

            foreach ($this->fnotes as $fnote) {
                $props['urun_id'] = $this->itemId;
                $props['no'] = $fnote['no'];
                $props['text_tr'] = $fnote['text_tr'];
                Fnote::create($props);
            }

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

        $parameter = 'product_no';
        $initial_no = config('appconstants.counters.product_no');
        $counter = Counter::find($parameter);

        if ($counter == null) {
            Counter::create([
                'counter_type' => $parameter,
                'counter_value' => $initial_no
            ]);

            return $initial_no;
        }

        $new_no = $counter->counter_value + 1;
        $counter->update(['counter_value' => $new_no]);         // Update Counter
        return $new_no;
    }


    public function integrityCheck() {
        return true;
    }


    public function addSNote() {
        $this->fnotes[] = [];
    }

    public function deleteSNote($key) {
        unset($this->fnotes[$key]);
    }


    public function releaseStart() {

        if ($this->integrityCheck()) {
            $this->js("console.log('m10true')");
            $this->dispatch('show-select-approvers',
                modelId: $this->itemId
            );

        } else {
            $this->js("showModal('m10')");
            $this->js("console.log('m10false')");
        }
    }




}
