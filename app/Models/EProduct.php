<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EProduct extends Model
{
    use HasFactory;


    protected $table = 'endproducts';

    protected $fillable = [

        'user_id',
        'updated_uid',
        'part_number',
        'part_number_mt',
        'part_number_wb',
        'product_type',
        'nomenclature',
        'description',
        'version',
        'is_latest',
        'mast_family_mt',
        'mast_family_wb',
        'drive_type',
        'extended_height_mm',
        'extended_height_in',
        'nested_height_mm',
        'nested_height_in',
        'product_weight_kg',
        'max_payload_kg',
        'max_payload_lb',
        'design_sail_area',
        'design_drag_coefficient',
        'max_operational_wind_speed',
        'max_survival_wind_speed',
        'number_of_sections',
        'has_locking',
        'max_pressure_in_bar',
        'manual_doc_number',
        'payload_interface',
        'roof_interface',
        'side_interface',
        'bottom_interface',
        'guying_interface',
        'number_of_guying_interfaces',
        'hoisting_interface',
        'lubrication_interface',
        'manual_override_interface',
        'wire_management',
        'drainage',
        'wire_basket',
        'vdc12_interface',
        'vdc24_interface',
        'vdc28_interface',
        'ac110_interface',
        'ac220_interface',
        'material',
        'finish',
        'checker_id',
        'approver_id',
        'reject_reason_check',
        'reject_reason_app',
        'check_reviewed_at',
        'app_reviewed_at',
        'remarks',
        'status'

    ];


    public function getPartNoAttribute($value) {
        return $this->part_number.' V'.$this->version;
    }



}
