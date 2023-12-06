<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyable extends Model
{
    use HasFactory;


    protected $table = 'buyables';

    protected $fillable = [

        'user_id',
        'updated_uid',
        'part_number',
        'part_number_mt',
        'part_number_wb',
        'vendor',
        'vendor_part_no',
        'url',
        'description',
        'version',
        'is_latest',
        'weight',
        'material',
        'finish',
        'notes',
        'status'
    ];


    public function getPartNoAttribute($value) {
        return $this->part_number.' V'.$this->version;
    }



}
