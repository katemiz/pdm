<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fnote extends Model
{
    use HasFactory;

    protected $table = 'snotes';

    protected $fillable = [
        'user_id',
        'urun_id',
        'no',
        'text_tr',
    ];
}

