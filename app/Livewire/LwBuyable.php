<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

use App\Models\Counter;
use App\Models\CNotice;
use App\Models\Document;
use App\Models\Item;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LwBuyable extends Component
{
    use WithPagination;

    public $part_type = 'Buyable';


    public $page_view_title = 'Buyable Products';
    public $page_view_subtitle = 'Buyable Product Properties';

    public $list_all_url = '/parts/list';
    public $item_edit_url = '/buyables/form';
    public $item_view_url = '/buyables/view';

    public $has_material = false;
    public $has_bom = false;
    public $has_notes = false;
    public $has_flag_notes = false;
    public $has_vendor = true;

    public $uid;
    public $action = 'LIST'; // LIST,FORM,VIEW

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $show_latest = true; /// Show only latest versions

    public $constants;

    // Item Properties
    public $createdBy;
    public $part_number;
    public $part_number_mt;

    #[Validate('nullable|numeric', message: 'WB Part Number should be numeric')]
    public $part_number_wb;
    public $description;
    public $version;
    public $is_latest;

    #[Validate('required|numeric', message: 'Please select ECN')]
    public $c_notice_id;

    public $all_revs = [];

    #[Validate('required', message: 'Vendor name is mandatory')]
    public $vendor;
    public $vendor_part_no;
    public $url;

    #[Validate('nullable|numeric', message: 'Weight should be numeric')]
    public $weight;

    public $material;
    public $finish;
    public $remarks;
    public $status;

    public $unit = 'mm';


    public $has_mirror = false;
    public $is_mirror_of = false;   

    public $mirror_part_number =  false;
    public $mirror_part_version =  false;
    public $mirror_part_description =  false;

    public $is_mirror_of_part_number =  false;
    public $is_mirror_of_part_version =  false;
    public $is_mirror_of_part_description =  false;




    public $created_by;
    public $created_at;
    public $updated_by;
    public $updated_at;


    public $release_errors = false;
    public $parts_list = false;

    public $whereUsed = [];
    public $manual_doc_number_exists;

    public $parents = [];



    public function mount()
    {

        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->uid = request('id');
        }

        $this->constants = config('buyables');

        $this->getProps();
    }


    public function render() {

        return view('products.buyables.buyables',[
            'buyables' => $this->getBuyables(),
            'ecns' => CNotice::where('status','wip')->get()
        ]);
    }


    public function updated($property)
    {
        // $property: The name of the current property that was updated
        if ($property === 'manual_doc_number') {

            $this->manual_doc_number_exists = 'no';

            $manual = Document::where(
                ['document_no' => $this->manual_doc_number],
                ['is_latest' => true]
            )->first();

            if ($manual) {
                $this->manual_doc_number_exists = 'D'.$this->manual_doc_number.' R'.$manual->revision.' '.$manual->title;
            }
        }
    }


    public function getBuyables() {

        if ( $this->action == 'FORM'  && !$this->uid) {
            return collect([]);
        }

        if ( strlen($this->query) > 2) {
            return Item::when($this->show_latest, function ($query) {
                    $query->where('is_latest', true);
                })
                ->where('description', 'LIKE', "%".$this->query."%")
                ->orWhere('part_number','LIKE',"%".$this->query."%")
                ->orWhere('part_number_mt','LIKE',"%".$this->query."%")
                ->orWhere('part_number_wb','LIKE',"%".$this->query."%")
                ->orWhere('material','LIKE',"%".$this->query."%")
                ->orWhere('finish','LIKE',"%".$this->query."%")
                ->orWhere('remarks','LIKE',"%".$this->query."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
        } else {

            return Item::when($this->show_latest, function ($query) {
                $query->where('is_latest', true);
            })
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }
    }


    public function viewItem($uid) {

        $this->uid = $uid;
        $this->action = 'VIEW';
        $this->getProps();
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


    public function storeUpdateItem () {

        $this->part_type = 'Buyable';

        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['part_type'] = $this->part_type;
        $props['unit'] = $this->unit;
        $props['part_number_mt'] = $this->part_number_mt;
        $props['part_number_wb'] = $this->part_number_wb;
        $props['c_notice_id'] = $this->c_notice_id;
        $props['vendor'] = $this->vendor;
        $props['vendor_part_no'] = $this->vendor_part_no;
        $props['url'] = $this->url;
        $props['description'] = $this->description;
        $props['weight'] = $this->weight;
        $props['material_text'] = $this->material;
        $props['remarks'] = $this->remarks;
        $props['finish'] = $this->finish;

        if ( $this->uid ) {
            // update
            Item::find($this->uid)->update($props);
            session()->flash('message','Buyable product has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $props['part_number'] = $this->getBuyableNo();
            $this->uid = Item::create($props)->id;
            session()->flash('message','Buyable product has been created successfully.');
        }

        // ATTACHMENTS, TRIGGER ATTACHMENT COMPONENT
        $this->dispatch('triggerAttachment',modelId: $this->uid);

        $this->getProps();

        $this->action = 'VIEW';

    }


    public function getProps () {

        if ($this->uid && in_array($this->action,['VIEW','FORM']) ) {

            $buyable = Item::find($this->uid);

            $this->part_number = $buyable->part_number;
            $this->part_number_mt = $buyable->part_number_mt;
            $this->part_number_wb = $buyable->part_number_wb;
            $this->c_notice_id = $buyable->c_notice_id;
            $this->part_type = $buyable->part_type;
            $this->vendor = $buyable->vendor;
            $this->vendor_part_no = $buyable->vendor_part_no;
            $this->url = $buyable->url;
            $this->unit = $buyable->unit;
            $this->description = $buyable->description;
            $this->version = $buyable->version;
            $this->is_latest = $buyable->is_latest;
            $this->weight = $buyable->weight;
            $this->material = $buyable->material_text;
            $this->finish = $buyable->finish;
            $this->remarks = $buyable->remarks;
            $this->status = $buyable->status;
            $this->created_by = User::find($buyable->user_id);
            $this->created_at = $buyable->created_at;
            $this->updated_by = User::find($buyable->updated_uid);
            $this->updated_at = $buyable->updated_at;
        }

        // Revisions
        foreach (Item::where('part_number',$this->part_number)->get() as $i) {
            $this->all_revs[$i->version] = $i->id;
        }

        // Get Parents
        $parents = Item::whereJsonContains('bom',['id' => (int) $this->uid])->get();
        if ($parents) {
            $this->parents = $parents;
        }

    }


    public function getBuyableNo() {

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



    public function resetFilter() {
        $this->query = '';
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



}
