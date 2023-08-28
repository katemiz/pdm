<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CRequest extends Model
{
    use HasFactory;

    protected $table = 'crequests';

    protected $fillable = [
        'user_id',
        'topic',
        'is_for_ecn',
        'req_app_id',
        'eng_app_id',
        'rej_reason_req',
        'rej_reason_eng',
        'description',
        'status'
    ];


}
