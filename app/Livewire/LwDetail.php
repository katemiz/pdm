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
use App\Models\Item;
use App\Models\NoteCategory;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class LwDetail extends Component
{
    public $itemtype = 'Detail';

    public $page_view_title = 'Detail Parts';
    public $page_view_subtitle = 'Detail Part Properties';

    public $list_all_url = '/parts/list';
    public $item_edit_url = '/details/form';
    public $item_view_url = '/products-detail/view';

    public $has_material = true;
    public $has_bom = false;
    public $has_notes = true;
    public $has_flag_notes = true;
    public $has_vendor = false;

    public $action = 'LIST'; // LIST,FORM,VIEW

    public $uid = false;

    public $canUserAdd = true;
    public $canUserEdit = true;
    public $canUserDelete = true;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection;

    public $part_number;

    public $constants;

    public $mat_family = false;
    public $mat_form = false;

    public $material_definition;
    public $family;
    public $form;

    public $is_latest;


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

    //#[Validate('required|numeric', message: 'Weight should be numeric')]
    public $weight;

    public $created_by;
    public $updated_by;
    public $checked_by;
    public $approvedBy;

    public $created_at;
    public $updated_at;
    public $req_reviewed_at;
    public $eng_reviewed_at;

    public $fno     = [];
    public $fnotes  = [];
    public $notes = [];

    public $all_revs = [];

    public $remarks;

    public $release_errors = false;
    public $parts_list = false;

    public function mount()
    {

        if (!request('itemtype')) {

            dd('no itemtype defined');
        }

        $this->itemtype = request('itemtype');


        if (request('id')) {
            $this->uid = request('id');

            $this->setUnsetProps();

            foreach (Fnote::where('item_id',$this->uid)->get() as $r) {
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

        // if ( $this->action === 'VIEW') {
        //     $this->setUnsetProps();
        // }

        // if ( $this->action === 'FORM' && $this->uid) {
        //     $this->setUnsetProps();
        // }

        if ( $this->action === 'LIST') {

            $this->sortDirection = $this->constants['list']['headers'][$this->sortField]['direction'];

            $items = Item::where('part_number', 'LIKE', "%".$this->search."%")
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

        return view('products.details.details',[
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

            $item = Item::find($this->uid);

            $this->mat_id = $item->malzeme_id;

            if ($item->status == 'wip') {
                $this->isItemEditable = true;
                $this->isItemDeleteable = true;
            }

            $this->part_number = $item->part_number;
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

            $this->is_latest = $item->is_latest;


            $this->created_by = User::find($item->user_id);
            $this->created_at = $item->created_at;
            $this->updated_by = User::find($item->updated_uid);
            $this->updated_at = $item->updated_at;
            $this->checked_by = User::find($item->checker_id);
            $this->approved_by = User::find($item->approver_id);

            $this->check_reviewed_at = $item->check_reviewed_at;
            $this->app_reviewed_at = $item->app_reviewed_at;

            $this->notes_id_array = [];

            $this->notes = $item->pnotes;

            foreach ($item->pnotes as $note) {
                array_push($this->notes_id_array,$note->id);
            }

            // Revisions
            foreach (Item::where('part_number',$this->part_number)->get() as $i) {
                $this->all_revs[$i->version] = $i->id;
            }

        } else {
            $this->topic = '';
            $this->description = '';
            $this->is_for_ecn = false;
            $this->rejectReason = false;
            $this->status = false;
        }
    }

    public function viewItem($idItem) {
        $this->uid = $idItem;
        $this->action = 'VIEW';
        $this->setUnsetProps();
    }


    public function storeItem()
    {
        $this->validate();
        try {
            $this->item = Item::create([
                'part_type' => $this->itemtype,
                'updated_uid' => Auth::id(),
                'malzeme_id' => $this->mat_id,
                'description' => $this->description,
                'part_number' => $this->getProductNo(),
                'c_notice_id' => $this->ecn_id,
                'weight' => $this->weight,
                'unit' => $this->unit,
                'remarks' => $this->remarks,
                'user_id' => Auth::id()
            ]);
            session()->flash('success','Detail Part has been created successfully!');

            // Attach Notes to Product
            $this->item->pnotes()->attach($this->notes_id_array);

            $this->uid = $this->item->id;

            // Flag Notes (Special Notes)
            foreach ($this->fnotes as $fnote) {

                $props['urun_id'] = $this->uid;
                $props['no'] = $fnote['no'];
                $props['text_tr'] = $fnote['text_tr'];

                Fnote::create($props);
            }

            $this->dispatch('triggerAttachment', modelId: $this->uid);

            $this->action = 'VIEW';

            $this->setUnsetProps();


        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!'.$ex);
        }
    }



    public function updateItem()
    {
        $this->validate();

        try {

            Item::whereId($this->uid)->update([
                'malzeme_id' => $this->mat_id,
                'description' => $this->description,
                'c_notice_id' => $this->ecn_id,
                'weight' => $this->weight,
                'unit' => $this->unit,
                'remarks' => $this->remarks
            ]);

            $aaa = Item::find($this->uid);

            // Update Notes to Product
            $aaa->pnotes()->detach();
            $aaa->pnotes()->attach(array_unique($this->notes_id_array));

            // Flag Notes (Special Notes)
            Fnote::where('item_id',$this->uid)->delete();

            //dd($this->uid);

            foreach ($this->fnotes as $fnote) {
                $props['item_id'] = $this->uid;
                $props['no'] = $fnote['no'];
                $props['text_tr'] = $fnote['text_tr'];
                Fnote::create($props);
            }

            session()->flash('message','Product has been updated successfully!');

            $this->dispatch('triggerAttachment',
                modelId: $this->uid
            );

            $this->action = 'VIEW';

            $this->setUnsetProps();


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
                modelId: $this->uid
            );

        } else {
            $this->js("showModal('m10')");
            $this->js("console.log('m10false')");
        }
    }







    public function freezeConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'freeze');
    }


    #[On('onFreezeConfirmed')]
    public function doFreeze() {
        Item::find($this->uid)->update(['status' =>'Frozen']);
        $this->action = 'VIEW';
        $this->setUnsetProps();
    }




}
