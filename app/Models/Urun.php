<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Pnote;


class Urun extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'user_id',
        'c_notice_id',
        'malzeme_id',
        'product_no',
        'unit',
        'weight',
        'version',
        'description',
        'checker_id',
        'approver_id',
        'reject_reason_check',
        'reject_reason_app',
        'check_reviewed_at',
        'app_reviewed_at',
        'remarks',
        'status'
    ];


    public function getPartNumberAttribute()
    {
        return $this->product_no.'-'.$this->version;
    }



    public function notes()
    {
        return $this->belongsToMany(Pnote::class)->withTimestamps();
    }

    public function snotes()
    {
        return $this->hasMany(Fnote::class);
    }


}
