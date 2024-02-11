<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mom extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'company_id',
        'updated_uid',
        'mom_no',
        'revision',
        'is_latest',
        'meeting_type',
        'mom_start_date',
        'mom_end_date',
        'place',
        'subject',
        'minutes',
        'remarks',
        'published_by',
        'status'
    ];

}
