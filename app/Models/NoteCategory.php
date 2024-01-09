<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Pnote;


class NoteCategory extends Model
{
    use HasFactory;

    protected $table = 'ncategories';

    protected $fillable = [
        'user_id',
        'text_tr',
        'text_en',
        'status'
    ];


    public function productNotes()
    {
        return $this->hasMany(Pnote::class);
    }

}
