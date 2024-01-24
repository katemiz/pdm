<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CNotice extends Model
{
    use HasFactory;

    protected $table = 'ecns';

    protected $fillable = [
        'user_id',
        'c_notice_id',
        'pre_description'
    ];


    public function getCrTopicAttribute()
    {
        $cr = CRequest::find($this->c_notice_id);
        return $cr->topic;
    }


    public function getEcnNoAttribute()
    {
        return 'ECN '.$this->id;
    }


    public function getCrNoAttribute()
    {
        return 'CR '.$this->c_notice_id;
    }



}
