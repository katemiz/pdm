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


    protected function family(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => config('material')['family'][$value],
        );
    }

    protected function form(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => config('material')['form'][$value],
        );
    }


}
