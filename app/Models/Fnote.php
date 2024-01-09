<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fnote extends Model
{
    use HasFactory;

    protected $table = 'fnotes';

    protected $fillable = [
        'user_id',
        'item_id',
        'no',
        'text_tr',
        'text_en',
    ];
}

