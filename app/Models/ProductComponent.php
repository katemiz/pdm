<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductComponent extends Pivot
{
    protected $table = 'product_components';

    protected $fillable = [
        'parent_id',
        'child_id',
        'quantity',
    ];

    public function parent()
    {
        return $this->belongsTo(Item::class, 'parent_id');
    }

    public function child()
    {
        return $this->belongsTo(Item::class, 'child_id');
    }
}