<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','updated_uid','name', 'fullname','remarks'];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
