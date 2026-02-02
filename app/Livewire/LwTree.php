<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;


class LwTree extends Component
{
    public $components;

    public function mount( $components = [])
    {
        $this->components = $components;
    }

    public function render()
    {

        // dd($this->components);
        return view('components.elements.bom-tree', [
            'components' => json_encode($this->components),
        ]);
    }

    public function handleNodeSelect($nodeId)
    {
        // Handle selection of a node with ID $nodeId
        // You can update state, perform actions, etc.
        dd($nodeId);
    }
}
