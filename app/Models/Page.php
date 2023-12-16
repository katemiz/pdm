<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'updated_uid',
        'document_id',
        'title',
        'content'
    ];

}
