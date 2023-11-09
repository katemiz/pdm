<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    protected $primaryKey = 'counter_type';

    protected $fillable = [
        'counter_type',
        'counter_value'
    ];



}
