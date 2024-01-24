<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

use App\Models\Counter;
use App\Models\Document;
use App\Models\EProduct;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LwSellable extends Component
{
    use WithPagination;

    public $uid;
    public $action = 'LIST'; // LIST,FORM,VIEW

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $sortDirManualNo ="asc";
    public $sortDirManualTitle ="asc";

    public $show_latest = true; /// Show only latest versions

    public $constants;


    // Constants
    public $product_types = [
        "ACC" => 'Accessories',
        "RCP" => 'Remote Control Positioner',
        "MTPC" => "Compressor",
        "MST" => "Mast",
    ];

    public $drive_types = [
        "M" => "Manual",
        "MP" => "Manual, Pneumatic",
        "P" => "Pneumatic",
        "EM" => "Electromechanical"
    ];

    public $mast_families = [
        "MTHP-A" => "CDL",
        "MTHP-M" => "CDL",
        "MTP-M" => "PML",
        "MTP-N" => "PMNL",
        "MTPQ" => "HUPM",
        "MTPQ NN" => "PMNL-LD",
        "MTS-A" => "QEAM",
        "MTS-M" => "QEAM",
        "MTSV-A" => "QEAM",
        "MTSV-M" => "QEAM",
        "MTT" => "EML-C",
        "MTX" => "EML-AL",
    ];

    // Item Properties
    public $createdBy;
    public $part_number;

    public $part_number_mt;

    #[Validate('nullable|numeric', message: 'WB Part Number should be numeric')]
    public $part_number_wb;
    public $description;
    public $version;
    public $is_latest;

    public $all_revs = [];

    #[Validate('required', message: 'Please select product type')]
    public $product_type;

    #[Validate('required', message: 'Sellable product nomenclature is required')]
    public $nomenclature;
    public $mast_family_mt;
    public $mast_family_wb;
    public $drive_type;

    #[Validate('nullable|numeric', message: 'Extended height should be numeric')]
    public $extended_height_mm;
    public $extended_height_in;

    #[Validate('nullable|numeric', message: 'Nested height should be numeric')]
    public $nested_height_mm;
    public $nested_height_in;

    #[Validate('nullable|numeric', message: 'Weight should be numeric')]
    public $product_weight_kg;

    #[Validate('nullable|numeric', message: 'Load capacity should be numeric')]
    public $max_payload_kg;
    public $max_payload_lb;

    #[Validate('nullable|numeric', message: 'Sail area should be numeric')]
    public $design_sail_area = 1.5;
    public $design_drag_coefficient = 1.5;

    #[Validate('nullable|numeric', message: 'Operational wind speed should be numeric')]
    public $max_operational_wind_speed;

    #[Validate('nullable|numeric', message: 'Survival wind speed should be numeric')]
    public $max_survival_wind_speed;

    #[Validate('nullable|numeric', message: 'Number of sections should be numeric')]
    public $number_of_sections;

    #[Validate('nullable|string', message: 'Please indicate whether product has locking capability')]
    public $has_locking;

    public $lock_types = [
        "N" => "Non-Locking",
        "ML" => "Manual Lock",
        "AL" => "Automatic Lock"
    ];


    public $max_pressure_in_bar = 2.0;

    #[Validate('nullable|numeric', message: 'Product manual document number should be numeric')]
    public $manual_doc_id;
    public $manual_doc_number;
    public $manual_doc_title;

    public $toggleManualSelect = false; // Show/Hide Manual Select Form

    public $payload_interface = true;
    public $roof_interface = false;
    public $side_interface = true;
    public $bottom_interface = true;
    public $guying_interface = true;
    public $number_of_guying_interfaces;
    public $hoisting_interface = true;
    public $lubrication_interface = false;
    public $manual_override_interface = false;
    public $wire_management = false;
    public $wire_basket = false;
    public $drainage = false;
    public $vdc12_interface = false;
    public $vdc24_interface = false;
    public $vdc28_interface = false;
    public $ac110_interface = false;
    public $ac220_interface = false;
    public $material;
    public $checker_id;
    public $approver_id;
    public $reject_reason_check;
    public $reject_reason_app;
    public $check_reviewed_at;
    public $app_reviewed_at;
    public $finish;
    public $remarks;
    public $status;

    public $created_by;
    public $created_at;
    public $updated_by;
    public $updated_at;



    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->uid = request('id');
        }

        $this->constants = config('endproducts');

        $this->getEProps();
    }


    public function render() {
        return view('products.endproducts.ep',[
            'endproducts' => $this->getEndProducts(),
            'manuals' => $this->getManuals()
        ]);
    }


    public function updated($property)
    {
        // $property: The name of the current property that was updated
        // if ($property === 'manual_doc_number') {

            // $this->manual_doc_number_exists = 'no';

            // $manual = Document::where(
            //     ['document_no' => $this->manual_doc_number],
            //     ['is_latest' => true]
            // )->first();

            // if ($manual) {
            //     $this->manual_doc_number_exists = 'D'.$this->manual_doc_number.' R'.$manual->revision.' '.$manual->title;
            // }
        // }
    }


    public function getEndProducts() {

        if ( $this->action == 'FORM'  && !$this->uid) {
            return collect([]);
        }

        if ( strlen($this->query) > 1) {

            return  EProduct::when($this->show_latest, function ($query) {
                    $query->where('is_latest', true);
                })
                ->where('nomenclature', 'LIKE', "%".$this->query."%")
                ->orWhere('part_number','LIKE',"%".$this->query."%")
                ->orWhere('part_number_mt','LIKE',"%".$this->query."%")
                ->orWhere('part_number_wb','LIKE',"%".$this->query."%")
                ->orWhere('material','LIKE',"%".$this->query."%")
                ->orWhere('finish','LIKE',"%".$this->query."%")
                ->orWhere('mast_family_mt','LIKE',"%".$this->query."%")
                ->orWhere('mast_family_wb','LIKE',"%".$this->query."%")
                ->orWhere('remarks','LIKE',"%".$this->query."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));

        } else {

            return EProduct::when($this->show_latest, function ($query) {
                $query->where('is_latest', true);
            })
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }
    }





    public function getManuals() {

        if ( $this->action != 'FORM'  && !$this->uid) {
            return collect([]);
        }

        if ( strlen($this->query) > 2 ) {

            return  Document::where('is_latest', true)
                ->where('doc_type', 'MN')
                ->orWhere('title', 'LIKE', "%".$this->query."%")
                ->orWhere('remarks','LIKE',"%".$this->query."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));

        } else {

            return  Document::where('is_latest', true)
                ->where('doc_type', 'MN')
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
        }
    }





    public function viewItem($uid) {

        $this->uid = $uid;
        $this->action = 'VIEW';
        $this->getEProps();
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

        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['part_number_mt'] = $this->part_number_mt;
        $props['part_number_wb'] = $this->part_number_wb;
        $props['product_type'] = $this->product_type;
        $props['nomenclature'] = $this->nomenclature;
        $props['description'] = $this->description;
        $props['mast_family_mt'] = $this->mast_family_mt;
        $props['mast_family_wb'] = $this->mast_family_mt ? $this->mast_families[$this->mast_family_mt] : '';
        $props['drive_type'] = $this->drive_type;
        $props['extended_height_mm'] = $this->extended_height_mm;
        $props['extended_height_in'] = $this->extended_height_in/25.4;
        $props['nested_height_mm'] = $this->nested_height_mm;
        $props['nested_height_in'] = $this->nested_height_in;
        $props['product_weight_kg'] = $this->product_weight_kg;
        $props['max_payload_kg'] = $this->max_payload_kg;
        $props['max_payload_lb'] = $this->max_payload_kg*2.20462;
        $props['design_sail_area'] = $this->design_sail_area;
        $props['design_drag_coefficient'] = $this->design_drag_coefficient;
        $props['max_operational_wind_speed'] = $this->max_operational_wind_speed;
        $props['max_survival_wind_speed'] = $this->max_survival_wind_speed;
        $props['number_of_sections'] = $this->number_of_sections;
        $props['has_locking'] = in_array($this->has_locking, array_keys($this->lock_types)

        ) ? $this->has_locking : '';
        $props['max_pressure_in_bar'] = $this->max_pressure_in_bar > 0 ? $this->max_pressure_in_bar :null;
        $props['manual_doc_number'] = $this->manual_doc_number;
        $props['payload_interface'] = $this->payload_interface;
        $props['roof_interface'] = $this->roof_interface;
        $props['side_interface'] = $this->side_interface;
        $props['bottom_interface'] = $this->bottom_interface;
        $props['guying_interface'] = $this->guying_interface;
        $props['number_of_guying_interfaces'] = $this->number_of_guying_interfaces;
        $props['hoisting_interface'] = $this->hoisting_interface;
        $props['lubrication_interface'] = $this->lubrication_interface;
        $props['manual_override_interface'] = $this->manual_override_interface;
        $props['wire_management'] = $this->wire_management;
        $props['wire_basket'] = $this->wire_basket;
        $props['drainage'] = $this->drainage;
        $props['vdc12_interface'] = $this->vdc12_interface;
        $props['vdc24_interface'] = $this->vdc24_interface;
        $props['vdc28_interface'] = $this->vdc28_interface;
        $props['ac110_interface'] = $this->ac110_interface;
        $props['ac220_interface'] = $this->ac220_interface;
        $props['material'] = $this->material;
        $props['remarks'] = $this->remarks;
        $props['finish'] = $this->finish;


        if ( $this->uid ) {
            // update
            EProduct::find($this->uid)->update($props);
            session()->flash('message','Sellable product has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $props['part_number'] = $this->getEProductNo();

            $this->uid = EProduct::create($props)->id;
            session()->flash('message','Sellable product has been created successfully.');
        }

        // ATTACHMENTS, TRIGGER ATTACHMENT COMPONENT
        $this->dispatch('triggerAttachment',modelId: $this->uid);

        $this->getEProps();

        $this->action = 'VIEW';

    }


    public function getEProps () {

        if ($this->uid && in_array($this->action,['VIEW','FORM']) ) {

            $ep = EProduct::find($this->uid);

            $this->part_number = $ep->part_number;
            $this->part_number_mt = $ep->part_number_mt;
            $this->part_number_wb = $ep->part_number_wb;
            $this->product_type = $ep->product_type;
            $this->nomenclature = $ep->nomenclature;
            $this->description = $ep->description;
            $this->version = $ep->version;
            $this->is_latest = $ep->is_latest;
            $this->mast_family_mt = $ep->mast_family_mt;
            $this->mast_family_wb = $ep->mast_family_wb;
            $this->drive_type = $ep->drive_type;
            $this->extended_height_mm = $ep->extended_height_mm;
            $this->extended_height_in = $ep->extended_height_in/25.4;
            $this->nested_height_mm = $ep->nested_height_mm;
            $this->nested_height_in = $ep->nested_height_in;
            $this->product_weight_kg = $ep->product_weight_kg;
            $this->max_payload_kg = $ep->max_payload_kg;
            $this->max_payload_lb = $ep->max_payload_kg*2.20462;
            $this->design_sail_area = $ep->design_sail_area;
            $this->design_drag_coefficient = $ep->design_drag_coefficient;
            $this->max_operational_wind_speed = $ep->max_operational_wind_speed;
            $this->max_survival_wind_speed = $ep->max_survival_wind_speed;
            $this->number_of_sections = $ep->number_of_sections;
            $this->has_locking = $ep->has_locking;
            $this->max_pressure_in_bar = $ep->max_pressure_in_bar;
            $this->manual_doc_number = $ep->manual_doc_number;
            $this->payload_interface = $ep->payload_interface ? true : false;
            $this->roof_interface = $ep->roof_interface ? true : false;
            $this->side_interface = $ep->side_interface ? true : false;
            $this->bottom_interface = $ep->bottom_interface ? true : false;
            $this->guying_interface = $ep->guying_interface ? true : false;
            $this->number_of_guying_interfaces = $ep->number_of_guying_interfaces;
            $this->hoisting_interface = $ep->hoisting_interface ? true : false;
            $this->lubrication_interface = $ep->lubrication_interface ? true : false;
            $this->manual_override_interface = $ep->manual_override_interface ? true : false;
            $this->wire_management = $ep->wire_management ? true : false;
            $this->wire_basket = $ep->wire_basket ? true : false;
            $this->drainage = $ep->drainage ? true : false;
            $this->vdc12_interface = $ep->vdc12_interface ? true : false;
            $this->vdc24_interface = $ep->vdc24_interface ? true : false;
            $this->vdc28_interface = $ep->vdc28_interface ? true : false;
            $this->ac110_interface = $ep->ac110_interface ? true : false;
            $this->ac220_interface = $ep->ac220_interface ? true : false;
            $this->material = $ep->material;
            $this->finish = $ep->finish;
            $this->remarks = $ep->remarks;
            $this->status = $ep->status;
            $this->created_by = User::find($ep->user_id);
            $this->created_at = $ep->created_at;
            $this->updated_by = User::find($ep->updated_uid);
            $this->updated_at = $ep->updated_at;
        }

        if ($this->manual_doc_number > 0) {
            $user_manual = Document::where('is_latest',true)->where('document_no', $this->manual_doc_number)->first();

            if($user_manual) {
                $this->manual_doc_id = $user_manual->id;
                $this->manual_doc_title = $user_manual->title;

            }
        }

        // Revisions
        foreach (EProduct::where('part_number',$this->part_number)->get() as $sellable) {
            $this->all_revs[$sellable->version] = $sellable->id;
        }

    }


    public function getEProductNo() {

        $parameter = 'end_product_no';
        $initial_no = config('appconstants.counters.end_product_no');
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

        $current_item = EProduct::find($this->uid);

        if ($current_item->version > 0) {

            $previous_item = EProduct::where("part_number",$current_item->part_number)
            ->where("version",$current_item->version-1)->first();

            //dd($previous_item);

            $previous_item->update(['is_latest' => true]);
        }

        $current_item->delete();
        $this->action = 'LIST';
    }








    public function addManual($idRecord) {

        $man = Document::find($idRecord);

        $this->manual_doc_id = $man->id;
        $this->manual_doc_number = $man->document_no;
        $this->manual_doc_title = $man->title;
    }





    public function freezeConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'freeze');
    }


    #[On('onFreezeConfirmed')]
    public function doFreeze() {
        EProduct::find($this->uid)->update(['status' =>'Frozen']);
        $this->action = 'VIEW';
        $this->getEProps();
    }


    public function reviseConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'revise');
    }


    #[On('onReviseConfirmed')]
    public function doRevise() {

        $original_part = EProduct::find($this->uid);

        $revised_part = $original_part->replicate();

        $revised_part->status = 'WIP';
        $revised_part->version = $original_part->version+1;
        $revised_part->save();

        // Do not Copy files!
        // Delibrate decision

        $original_part->update(['is_latest' => false]);

        $this->uid = $revised_part->id;
        $this->action = 'VIEW';

        $this->getEProps();


        // This refreshes new item attachments
        $this->dispatch('triggerAttachment',modelId: $this->uid);
    }



}
