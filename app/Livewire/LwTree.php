<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\DB;

class LwTree extends Component
{
    public $uid;

    public function mount($uid)
    {
        $this->uid = $uid;
    }


    // Computed property - always fresh
    public function getComponentsProperty()
    {
        return Item::find($this->uid)->components;
    }


    #[On('components-updated')]
    public function refreshComponent()
    {
        // Just being here triggers re-render
    }


    public function increaseQty($componentId)
    {
        Item::find($this->uid)
            ->components()
            ->updateExistingPivot($componentId, [
                'quantity' => DB::raw('quantity + 1'),
            ]);
    }

    public function decreaseQty($componentId)
    {
        $item = Item::find($this->uid);
        $component = $item->components()->where('child_id', $componentId)->first();
        
        if ($component && $component->pivot->quantity > 1) {
            $item->components()->updateExistingPivot($componentId, [
                'quantity' => DB::raw('quantity - 1'),
            ]);
        }
    }

    public function removeComponent($componentId)
    {
        Item::find($this->uid)->components()->detach($componentId);
    }

    public function render()
    {
        return view('components.elements.bom-tree');
    }

}
