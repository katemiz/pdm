<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Material extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'materials';

    protected $guarded = [];

    public function getFamilyNameAttribute($value) {
        return config('conf_materials')['families'][$this->family];
    }

    public function getFormNameAttribute($value) {
        return config('conf_materials')['formTypes'][$this->form];
    }


    public function getMaterialDefinitionAttribute($value) {
        return config('conf_materials')['families'][$this->family] . ' | ' . config('conf_materials')['formTypes'][$this->form] .' | '. $this->description.' | '.$this->specification;
    }

}
