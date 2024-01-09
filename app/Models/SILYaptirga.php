<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Urun;
use App\Models\NoteCategory;



class Yaptirga extends Model
{
    use HasFactory;

    protected $table = 'pnotes';

    protected $fillable = [
        'user_id',
        'note_category_id',
        'text_tr',
        'text_en',
        'remarks',
        'status'
    ];

    public function products() {
        return $this->belongsToMany(Urun::class)->withTimestamps();
    }


    public function noteCategory()
    {
        return $this->belongsTo(NoteCategory::class);
    }



}
