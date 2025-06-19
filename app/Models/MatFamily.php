<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatFamily extends Model
{
    use HasFactory;

    protected $table = 'mat_families';

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function materials(): HasMany
    {
        return $this->hasMany(MatMaterial::class);
    }

    public function activeMaterials(): HasMany
    {
        return $this->hasMany(MatMaterial::class)->where('is_active', true);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    // Accessors & Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(strtolower($value));
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    // Helper methods
    public function getMaterialsCount(): int
    {
        return $this->materials()->count();
    }

    public function getActiveMaterialsCount(): int
    {
        return $this->activeMaterials()->count();
    }
}