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
use App\Models\Sfamily;
use App\Models\NoteCategory;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class LwDetail extends Component
{
    public $part_type = 'Detail';

    public $page_view_title = 'Detail Parts';
    public $page_view_subtitle = 'Detail Part Properties';

    public $list_all_url = '/parts/list';
    public $item_edit_url;
    public $item_view_url = '/details/Detail/view';

    public $has_material = true;
    public $has_bom = false;
    public $has_notes = true;
    public $has_flag_notes = true;
    public $has_vendor = false;

    public $action = 'LIST'; // LIST,FORM,VIEW

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $uid = false;

    public $canUserAdd = true;
    public $canUserEdit = true;
    public $canUserDelete = true;

    public $part_number;
    public $makefrom_part_id;
    public $makefrom_part_item;

    public $constants;

    public $mat_family = false;
    public $mat_form = false;

    public $material_definition;
    public $family;
    public $form;

    public $is_latest;

    public $sfamilies;
    public $standard_family;
    public $standard_number;
    public $standard_family_id;
    public $std_params;

    public $materials = [];
    public $ncategories = [];
    public $notes_id_array = [];

    // Item Props
    #[Validate('required|numeric', message: 'Please select material')]
    public $malzeme_id;

    #[Validate('required', message: 'Please write part name/title')]
    public $description;

    #[Validate('required|numeric', message: 'Please select ECN')]
    public $c_notice_id;

    public $isItemEditable = false;
    public $isItemDeleteable = false;

    public $version;
    public $status;
    public $unit = 'mm';

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

    public $togglePartSelect = false;

    public $release_errors = false;
    public $parts_list = false;

    public $approved_by;

    public $check_reviewed_at;
    public $app_reviewed_at;

    public $parents = [];


    public function mount()
    {
        if (!request('part_type')) {
            dd('no part_type defined');
        }

        $this->part_type = request('part_type');
        $this->item_edit_url = '/details/'.$this->part_type.'/form';

        if (request('id')) {

            $this->uid = request('id');
            $this->getProps();

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

        if ( $this->part_type == 'Standard') {
            $this->getStandardFamilies();
        }


        if ( $this->action === 'LIST') {

            $this->sortDirection = $this->constants['list']['headers'][$this->sortField]['direction'];

            $items = Item::where('part_number', 'LIKE', "%".$this->query."%")
                        ->orWhere('description', 'LIKE', "%".$this->query."%")
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
            'ecns' => $ecns,
            'nodes' => $this->getNodes()
        ]);
    }




    public function getStandardFamilies()  {
        $this->sfamilies = Sfamily::orderBy('standard_number','ASC')->get();
    }



    public function getMaterialList() {

        if ($this->mat_family && $this->mat_form) {
            $this->materials = Malzeme::where('family', $this->mat_family)
            ->where('form', $this->mat_form)
            ->orderBy($this->sortField,'asc')->get();
        }
    }



    public function getNodes() {

        if ($this->part_type == 'MakeFrom') {

            if ( strlen($this->query) > 2 ) {

                //dd('dddd');

                return Item::where('part_number', 'LIKE', "%".$this->query."%")
                    ->orWhere('standard_number', 'LIKE', "%".$this->query."%")
                    ->orWhere('description', 'LIKE', "%".$this->query."%")
                    ->orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));

            } else {

                //dd('dddd2');


                return Item::orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));
            }

        } else {
            return false;
        }
    }


    public function getProps() {

        $item = Item::find($this->uid);

        $this->malzeme_id = $item->malzeme_id;
        $this->part_type = $item->part_type;

        switch ($item->part_type) {

            case 'MakeFrom':
                $item_view_url = '/details/MakeFrom/view';
                break;

            case 'Buyable':
                $item_view_url = '/details/Buyable/view';
                break;

            case 'Standard':
                $item_view_url = '/details/Standard/view';
                break;

            case 'Detail':
                $item_view_url = '/details/Detail/view';
                break;

            case 'Assy':
                $item_view_url = '/products-assy/view';
                break;

        }

        if ($item->status == 'WIP') {
            $this->isItemEditable = true;
            $this->isItemDeleteable = true;
        }

        $this->part_number = $item->part_number;
        $this->version = $item->version;
        $this->weight = $item->weight;
        $this->unit = $item->unit;

        $malzeme =  Malzeme::find($item->malzeme_id);

        if ( in_array($this->part_type,['MakeFrom','Standard']) ) {

            if ($this->part_type == 'MakeFrom') {
                $this->material_definition = 'See Source Part Material';
            }

            if ($this->part_type == 'Standard') {
                $this->material_definition = 'See Standard Documentation';
            }

        } elseif ($malzeme) {

            $this->material_definition = $malzeme->material_definition;

            $this->family = $malzeme->family;
            $this->form = $malzeme->form;

            $this->mat_family = $malzeme->family;
            $this->mat_form = $malzeme->form;
        }

        $this->getMaterialList();

        $this->standard_family_id = $item->standard_family_id;
        $this->standard_number = $item->standard_number;
        $this->description = $item->description;
        $this->c_notice_id = $item->c_notice_id;
        $this->remarks = $item->remarks;

        $this->status = $item->status;

        $this->is_latest = $item->is_latest;

        $this->makefrom_part_id = $item->makefrom_part_id;


        if ($this->part_type == 'MakeFrom' && $item->makefrom_part_id) {
            $this->makefrom_part_item = Item::find($item->makefrom_part_id);
        }

        $this->std_params = $item->std_params;

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

        $this->standard_family = Sfamily::find($this->standard_family_id);

        // Revisions
        foreach (Item::where('part_number',$this->part_number)->get() as $i) {
            $this->all_revs[$i->version] = $i->id;
        }

        // Get Parents
        $parents = Item::whereJsonContains('bom',['id' => (int) $this->uid])->get()->toArray();
        //$parents = Item::whereJsonContains('bom->id',$this->uid)->get()->toArray();


        //dd($parents);

        if ($parents) {
            $this->parents[] = $parents;
        }
    }


    public function resetFilter() {
        $this->query = '';
    }

    public function viewItem($idItem) {
        $this->uid = $idItem;
        $this->action = 'VIEW';
        $this->getProps();
    }


    public function storeItem()
    {
        if ($this->part_type == 'MakeFrom') {
            $this->malzeme_id = 0 ;
        }


        //$this->validate();

        $this->standard_family = Sfamily::find($this->standard_family_id);



        switch ($this->part_type) {

            case 'Detail':
            case 'MakeFrom':

                $props = $this->validate([
                    'c_notice_id' => 'required',
                    'description' => 'required|min:6',
                    'malzeme_id' => 'required'
                ]);

                $props['part_type']  = $this->part_type;
                $props['user_id']  = Auth::id();
                $props['updated_uid']  = Auth::id();
                $props['weight']  = $this->weight;
                $props['remarks']  = $this->remarks;

                $props['part_number']  = $this->getProductNo();
                $props['makefrom_part_id']  = $this->makefrom_part_id;
                $props['c_notice_id']  = $this->c_notice_id;
                $props['unit']  = $this->unit;

                break;

            case 'Standard':

                $props = $this->validate([
                    'standard_family_id' => 'required',
                    'std_params' => 'required'
                ]);

                $props['part_type']  = $this->part_type;
                $props['user_id']  = Auth::id();
                $props['updated_uid']  = Auth::id();
                $props['weight']  = $this->weight;
                $props['remarks']  = $this->remarks;

                $props['standard_family_id']  = $this->standard_family_id;
                $props['standard_number']  = $this->standard_family->standard_number;
                $props['part_number']  = 0;
                $props['description'] = $this->standard_family->description;

                break;
        }


        //dd($props);


        try {

            $item = Item::create($props);
            $this->uid = $item->id;

            session()->flash('success',$this->part_type.' Part has been created successfully!');

            // Attach Notes to Product
            $item->pnotes()->attach($this->notes_id_array);

            // Flag Notes (Special Notes)
            foreach ($this->fnotes as $fnote) {

                $props['item_id'] = $this->uid;
                $props['no'] = $fnote['no'];
                $props['text_tr'] = $fnote['text_tr'];

                Fnote::create($props);
            }

            $this->dispatch('triggerAttachment', modelId: $this->uid);
            $this->action = 'VIEW';

            $this->getProps();

        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!'.$ex);
        }
    }



    public function updateItem()
    {
        if ($this->part_type == 'MakeFrom') {
            $this->malzeme_id = 0 ;
        }

        $this->standard_family = Sfamily::find($this->standard_family_id);


        switch ($this->part_type) {

            case 'Detail':
            case 'MakeFrom':

                $props = $this->validate([
                    'c_notice_id' => 'required',
                    'description' => 'required|min:6',
                    'malzeme_id' => 'required'
                ]);

                $props['updated_uid']  = Auth::id();
                $props['makefrom_part_id']  = $this->makefrom_part_id;
                $props['weight']  = $this->weight;
                $props['unit']  = $this->unit;
                $props['remarks']  = $this->remarks;

                break;

            case 'Standard':

                $props = $this->validate([
                    'standard_family_id' => 'required',
                    'std_params' => 'required'
                ]);

                $props['standard_family_id']  = $this->standard_family_id;
                $props['part_type']  = $this->part_type;
                $props['updated_uid']  = Auth::id();
                $props['standard_number']  = $this->standard_family->standard_number;
                $props['weight']  = $this->weight;
                $props['remarks']  = $this->remarks;
                $props['user_id']  = Auth::id();

                $props['description'] = $this->standard_family->description;

                break;
        }

        //dd($props);

        try {

            Item::whereId($this->uid)->update($props);

            $aaa = Item::find($this->uid);

            // Update Notes to Product
            $aaa->pnotes()->detach();
            $aaa->pnotes()->attach(array_unique($this->notes_id_array));

            // Flag Notes (Special Notes)
            Fnote::where('item_id',$this->uid)->delete();

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

            $this->getProps();



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




    public function addSourcePart($makefrom_part_id,$full_part_number) {

        $this->makefrom_part_id = $makefrom_part_id;
        $this->makefrom_part_item = Item::find($makefrom_part_id);
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


    public function reviseConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'revise');
    }


    #[On('onReviseConfirmed')]
    public function doRevise() {

        $original_part = Item::find($this->uid);
        $revised_part = $original_part->replicate();

        $revised_part->status = 'WIP';
        $revised_part->version = $original_part->version+1;

        $revised_part->save();

        // Do not Copy files!
        // Delibrate decision

        $original_part->update(['is_latest' => false]);

        $this->uid = $revised_part->id;
        $this->action = 'VIEW';

        $this->getProps();

        // This refreshes new item attachments
        $this->dispatch('triggerAttachment',modelId: $this->uid);
    }






    public function freezeConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'freeze');
    }


    #[On('onFreezeConfirmed')]
    public function doFreeze() {
        Item::find($this->uid)->update(['status' =>'Frozen']);
        $this->action = 'VIEW';
        $this->getProps();
    }




    public function deleteConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'delete');
    }


    #[On('onDeleteConfirmed')]
    public function doDelete() {

        $current_item = Item::find($this->uid);

        if ($current_item->version > 0) {

            $previous_item = Item::where("part_number",$current_item->part_number)
            ->where("version",$current_item->version-1)->first();

            $previous_item->update(['is_latest' => true]);
        }

        $current_item->delete();

        session()->flash('info','Item has been deleted successfully!');

        redirect('/parts/list');
    }



}
