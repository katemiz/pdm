<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;


use App\Models\Counter;
use App\Models\EProduct;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EndProduct extends Component
{
    public $uid;
    public $action = 'LIST'; // LIST,FORM,VIEW

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $constants;


    // Constants

    public $product_types = [

        "CMPRS" => "Compressor",
        "MST" => "Mast",
    ];


    public $drive_types = [
        "M" => "Manual",
        "P" => "Pneumatic",
        'H' => "Hydraulic",
        "E" => "Electrical",
        "EM" => "Electromechanical"
    ];

    public $mast_families = [
        "MTX" => "EML",
        "MTH" => "CDL"
    ];

    


    // Item Properties
    public $createdBy;
    public $part_number;
    public $description;
    public $version;

    #[Rule('required', message: 'Please select product type')]
    public $product_type;

    #[Rule('required', message: 'End Product nomenclature is required')]
    public $nomenclature;
    public $mast_family_mt;
    public $mast_family_wb;
    public $drive_type;
    public $extended_height_mm;
    public $extended_height_in;
    public $nested_height_mm;
    public $nested_height_in;
    public $product_weight_kg;
    public $max_payload_kg;
    public $max_payload_lb;
    public $design_sail_area = 1.5;
    public $design_drag_coefficient = 1.5;
    public $max_operational_wind_speed;
    public $max_survival_wind_speed;
    public $number_of_sections;

    #[Rule('required', message: 'Please indicate whether product has locking capability')]
    public $has_locking;
    public $max_pressure_in_bar = 2.0;
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
    public $remarks;
    public $status;

    public $created_at;
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
    }



    public function render() {

        $this->getEPPops();

        return view('products.endproducts.ep',[
            'endproducts' => $this->getEndProducts()
        ]);
    }


    public function getEndProducts() {

        if ( $this->action != 'FORM' ) {
            return collect([]);
        }
    }
















    public function storeUpdateItem () {

        $this->validate();
        
        $props['part_number'] = $this->getEProductNo();
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
        $props['has_locking'] = $this->has_locking;
        $props['max_pressure_in_bar'] = $this->max_pressure_in_bar;
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
        $props['vdc12_interface'] = $this->vdc12_interface;
        $props['vdc24_interface'] = $this->vdc24_interface;
        $props['vdc28_interface'] = $this->vdc28_interface;
        $props['ac110_interface'] = $this->ac110_interface;
        $props['ac220_interface'] = $this->ac220_interface;
        $props['material'] = $this->ac220_interface;        
        $props['remarks'] = $this->remarks;

        if ( $this->uid ) {
            // update
            EProduct::find($this->uid)->update($props);
            session()->flash('message','Requirement has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $this->uid = EProduct::create($props)->id;
            session()->flash('message','Requirement has been created successfully.');
        }

        // ATTACHMENTS, TRIGGER ATTACHMENT COMPONENT
        $this->dispatch('triggerAttachment',modelId: $this->uid);
        $this->action = 'VIEW';
    }








    public function getEPPops () {

        if ($this->uid && in_array($this->action,['VIEW','FORM']) ) {

            $ep = EProduct::find($this->uid);

            $this->part_number = $ep->part_number;
            $this->product_type = $ep->product_type;
            $this->nomenclature = $ep->nomenclature;
            $this->description = $ep->description;
            $this->version = $ep->version;
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
            $this->payload_interface = $ep->payload_interface;
            $this->roof_interface = $ep->roof_interface;
            $this->side_interface = $ep->side_interface;
            $this->bottom_interface = $ep->bottom_interface;
            $this->guying_interface = $ep->guying_interface;
            $this->number_of_guying_interfaces = $ep->number_of_guying_interfaces;
            $this->hoisting_interface = $ep->hoisting_interface;
            $this->lubrication_interface = $ep->lubrication_interface;
            $this->manual_override_interface = $ep->manual_override_interface;
            $this->wire_management = $ep->wire_management;
            $this->wire_basket = $ep->wire_basket;
            $this->vdc12_interface = $ep->vdc12_interface;
            $this->vdc24_interface = $ep->vdc24_interface;
            $this->vdc28_interface = $ep->vdc28_interface;
            $this->ac110_interface = $ep->ac110_interface;
            $this->ac220_interface = $ep->ac220_interface;
            $this->material = $ep->ac220_interface;        
            $this->remarks = $ep->remarks;
            $this->status = $ep->status;

            $this->created_at = $ep->created_at;
            $this->updated_at = $ep->updated_at;
        }

    }
















    public function getEProductNo() {

        $counter = Counter::find(1);

        if ($counter == null) {
            Counter::create([
                'id' => 1,
                'product_no' => config('appconstants.counters.product_no'),
                'end_product_no' => config('appconstants.counters.end_product_no')
            ]);

            return config('appconstants.counters.end_product_no');
        }

        $new_no = $counter->end_product_no+1;
        $counter->update(['end_product_no' => $new_no]);         // Update Counter
        return $new_no;
    }






}
