<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'user_id',
        'updated_uid',
        'part_type',
        'c_notice_id',
        'malzeme_id',
        'unit',
        'part_number',
        'description',
        'part_number_mt',
        'part_number_wb',
        'standard_number',
        'makefrom_part_number',
        'version',
        'is_latest',
        'vendor',
        'vendor_part_no',
        'url',
        'weight',
        'material_text',
        'finish_text',
        'remarks',
        'status',
        'checker_id',
        'approver_id',
        'reject_reason_check',
        'reject_reason_app',
        'check_reviewed_at',
        'app_reviewed_at',
    ];

    public function getFullPartNumberAttribute()
    {
        return $this->part_number.'-'.$this->version;
    }

    public function pnotes()
    {
        return $this->belongsToMany(Pnote::class)->withTimestamps();
    }

    public function flagnotes()
    {
        return $this->hasMany(Fnote::class);
    }
















}
