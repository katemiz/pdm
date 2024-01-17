<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sfamily extends Model
{
    use HasFactory;

    protected $table = 'standard_families';

    protected $fillable = [

        'user_id',
        'updated_uid',
        'standard_number',
        'description',
        'remarks',
        'status',
    ];




}
