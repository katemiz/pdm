<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrunNotu extends Model
{
    use HasFactory;

    protected $table = 'pnotes';

    protected $fillable = [
        'user_id',
        'category',
        'text_tr',
        'text_en',
        'status'
    ];

}
