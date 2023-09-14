<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Malzeme extends Model
{
    use HasFactory;

    protected $table = 'materials';

    protected $fillable = [
        'user_id',
        'form',
        'family',
        'description',
        'density',
        'specification',
        'link',
        'remarks',
        'status'
    ];


    // protected function familyName(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => config('material')['family'][$value],
    //     );
    // }

    // protected function formName(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => config('material')['form'][$value],
    //     );
    // }



    // protected function family(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => $value*$value,
    //     );
    // }


    public function getFamilyNameAttribute($value) {
        return config('material')['family'][$this->family];
    }

    public function getFormNameAttribute($value) {
        return config('material')['form'][$this->form];
    }


    public function getMaterialDefinitionAttribute($value) {
        return config('material')['family'][$this->family] . ' | ' . config('material')['form'][$this->form] .' | '. $this->description.' | '.$this->specification;
    }








}
