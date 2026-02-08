<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Support\Collection;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $guarded = [];


    public function getFullPartNumberAttribute()
    {
        if ($this->part_type == 'Standard') {

            $sf = Sfamily::find($this->standard_family_id);
            return $sf->standard_number.' '.$this->std_params;
        }

        if ($this->config_number > 0) {
            return $this->part_number.'-'.$this->config_number.'-'.$this->version;

        } else {
            return $this->part_number.'-'.$this->version;
        }

    }


    public function pnotes()
    {
        return $this->belongsToMany(Pnote::class)->withTimestamps();
    }


    public function flagnotes()
    {
        return $this->hasMany(Fnote::class);
    }






    /**
     * Get all child products (components) of this product
     */
    public function components(): BelongsToMany
    {
        return $this->belongsToMany(
            Item::class,
            'product_components',
            'parent_id',
            'child_id'
        )
        ->withPivot('quantity')
        ->withTimestamps()
        ->orderBy('product_components.parent_id');
    }



    public function getHasAssyComponent()
    {
        return $this->components()->where('part_type', 'Assy')->exists();
    }




    /**
     * Get all parent products that include this product as a component
     */
    public function usedIn(): BelongsToMany
    {
        return $this->belongsToMany(
            Item::class,
            'product_components',
            'child_id',
            'parent_id'
        )
        ->withPivot('quantity')
        ->withTimestamps();
    }







    /**
     * Get all components recursively with quantities adjusted for assembly count
     * 
     * @param int $assemblyQuantity Number of assemblies to build
     * @param int $maxDepth Maximum recursion depth
     * @return Collection
     */
    public function getAllComponents($assemblyQuantity = 1, $maxDepth = 20)
    {
        if ($this->part_type !== 'Assy') {
            return collect();
        }

        // Eager load to prevent N+1 queries
        $this->loadRecursiveComponents($maxDepth);

        return $this->getComponentsRecursive(1, $maxDepth, [], $assemblyQuantity);
    }

    /**
     * Eager load nested components up to max depth
     */
    protected function loadRecursiveComponents($depth)
    {
        $with = 'components';
        $relations = [$with];

        for ($i = 1; $i < $depth; $i++) {
            $with .= '.components';
            $relations[] = $with;
        }

        $this->load($relations);
    }

    /**
     * Recursive component retrieval with proper quantity calculation
     */
    protected function getComponentsRecursive(
        $currentLevel = 1,
        $maxDepth = 10,
        $parentPath = [],
        $parentQuantity = 1
    ) {
        // Depth limit
        if ($currentLevel > $maxDepth) {
            return collect();
        }

        // Circular reference check
        if (in_array($this->id, $parentPath)) {
            Log::warning("Circular reference detected", [
                'item_id' => $this->id,
                'path' => $parentPath
            ]);
            return collect();
        }

        $allComponents = collect();
        $parentPath[] = $this->id;

        foreach ($this->components as $index => $component) {
            // Calculate total quantity needed
            // parentQuantity already includes assembly quantity from top level
            $totalQuantity = $parentQuantity * $component->pivot->quantity;

            // Build component data
            $componentData = [
                'id' => $component->id,
                'part_number' => $component->part_number,
                'version' => $component->version,
                'description' => $component->description ?? '',
                'part_type' => $component->part_type,
                'level' => $currentLevel,
                'unit_quantity' => $component->pivot->quantity, // Qty per parent
                'total_quantity' => $totalQuantity, // Total qty needed
                'sort_order' => $component->pivot->sort_order ?? $index,
                'parent_id' => $this->id,
                'path' => implode(' → ', [...$parentPath, $component->id]),
                'path_ids' => [...$parentPath, $component->id],
                'indent' => str_repeat('  ', $currentLevel - 1),
            ];

            $allComponents->push($componentData);

            // Recursively get sub-components if this is an assembly
            if ($component->part_type === 'Assy') {
                $subComponents = $component->getComponentsRecursive(
                    $currentLevel + 1,
                    $maxDepth,
                    $parentPath,
                    $totalQuantity // Pass total quantity down the chain
                );

                $allComponents = $allComponents->merge($subComponents);
            }
        }

        return $allComponents;
    }








}
