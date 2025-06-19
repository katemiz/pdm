<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatMaterial extends Model
{
    use HasFactory;

    protected $table = 'mat_materials';

    protected $fillable = [
        'name',
        'code',
        'description',
        'mat_family_id',
        'mat_form_id',
        
        // Mechanical Properties
        'tensile_strength',
        'yield_strength',
        'elongation',
        'hardness',
        'elastic_modulus',
        'density',
        'poisson_ratio',
        
        // Chemical Properties
        'carbon_content',
        'silicon_content',
        'manganese_content',
        'phosphorus_content',
        'sulfur_content',
        'chromium_content',
        'nickel_content',
        'molybdenum_content',
        'other_elements',
        
        // Physical Properties
        'melting_point',
        'thermal_conductivity',
        'electrical_resistivity',
        'coefficient_thermal_expansion',
        
        // Standards
        'astm_standard',
        'din_standard',
        'iso_standard',
        'other_standards',
        
        // Additional
        'custom_properties',
        'is_active',
        'supplier',
        'cost_per_unit',
        'cost_unit',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'other_elements' => 'array',
        'other_standards' => 'array',
        'custom_properties' => 'array',
        'tensile_strength' => 'decimal:2',
        'yield_strength' => 'decimal:2',
        'elongation' => 'decimal:2',
        'hardness' => 'decimal:2',
        'elastic_modulus' => 'decimal:2',
        'density' => 'decimal:4',
        'poisson_ratio' => 'decimal:3',
        'carbon_content' => 'decimal:3',
        'silicon_content' => 'decimal:3',
        'manganese_content' => 'decimal:3',
        'phosphorus_content' => 'decimal:3',
        'sulfur_content' => 'decimal:3',
        'chromium_content' => 'decimal:3',
        'nickel_content' => 'decimal:3',
        'molybdenum_content' => 'decimal:3',
        'melting_point' => 'decimal:2',
        'thermal_conductivity' => 'decimal:4',
        'electrical_resistivity' => 'decimal:6',
        'coefficient_thermal_expansion' => 'decimal:6',
        'cost_per_unit' => 'decimal:4',
    ];

    // Relationships
    public function family(): BelongsTo
    {
        return $this->belongsTo(MatFamily::class, 'mat_family_id');
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(MatForm::class, 'mat_form_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByFamily($query, $familyId)
    {
        return $query->where('mat_family_id', $familyId);
    }

    public function scopeByForm($query, $formId)
    {
        return $query->where('mat_form_id', $formId);
    }

    public function scopeByFamilyCode($query, $code)
    {
        return $query->whereHas('family', function ($q) use ($code) {
            $q->where('code', $code);
        });
    }

    public function scopeByFormCode($query, $code)
    {
        return $query->whereHas('form', function ($q) use ($code) {
            $q->where('code', $code);
        });
    }

    public function scopeWithTensileStrength($query, $min = null, $max = null)
    {
        if ($min !== null) {
            $query->where('tensile_strength', '>=', $min);
        }
        if ($max !== null) {
            $query->where('tensile_strength', '<=', $max);
        }
        return $query;
    }

    public function scopeWithYieldStrength($query, $min = null, $max = null)
    {
        if ($min !== null) {
            $query->where('yield_strength', '>=', $min);
        }
        if ($max !== null) {
            $query->where('yield_strength', '<=', $max);
        }
        return $query;
    }

    // Accessors & Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function setCostUnitAttribute($value)
    {
        $this->attributes['cost_unit'] = strtolower($value);
    }

    // Helper methods
    public function getFullNameAttribute(): string
    {
        return "{$this->family->name} - {$this->form->name} - {$this->name}";
    }

    public function getStrengthToWeightRatio(): ?float
    {
        if ($this->tensile_strength && $this->density) {
            return round($this->tensile_strength / ($this->density * 1000), 2); // Convert density to kg/m³
        }
        return null;
    }

    public function hasChemicalProperty($element): bool
    {
        $property = strtolower($element) . '_content';
        return isset($this->attributes[$property]) && $this->attributes[$property] !== null;
    }

    public function getChemicalProperty($element): ?float
    {
        $property = strtolower($element) . '_content';
        return $this->attributes[$property] ?? null;
    }

    public function setCustomProperty($key, $value): void
    {
        $properties = $this->custom_properties ?? [];
        $properties[$key] = $value;
        $this->custom_properties = $properties;
    }

    public function getCustomProperty($key, $default = null)
    {
        return $this->custom_properties[$key] ?? $default;
    }

    public function getMechanicalProperties(): array
    {
        return [
            'tensile_strength' => $this->tensile_strength,
            'yield_strength' => $this->yield_strength,
            'elongation' => $this->elongation,
            'hardness' => $this->hardness,
            'elastic_modulus' => $this->elastic_modulus,
            'density' => $this->density,
            'poisson_ratio' => $this->poisson_ratio,
        ];
    }

    public function getChemicalComposition(): array
    {
        return [
            'carbon' => $this->carbon_content,
            'silicon' => $this->silicon_content,
            'manganese' => $this->manganese_content,
            'phosphorus' => $this->phosphorus_content,
            'sulfur' => $this->sulfur_content,
            'chromium' => $this->chromium_content,
            'nickel' => $this->nickel_content,
            'molybdenum' => $this->molybdenum_content,
            'other_elements' => $this->other_elements,
        ];
    }

    public function getAllStandards(): array
    {
        $standards = [];
        
        if ($this->astm_standard) {
            $standards['ASTM'] = $this->astm_standard;
        }
        if ($this->din_standard) {
            $standards['DIN'] = $this->din_standard;
        }
        if ($this->iso_standard) {
            $standards['ISO'] = $this->iso_standard;
        }
        if ($this->other_standards) {
            $standards = array_merge($standards, $this->other_standards);
        }
        
        return $standards;
    }
}