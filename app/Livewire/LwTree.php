<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;


class LwTree extends Component
{
    public $treeData;

    public function mount( $treeData = [])
    {
        $this->treeData = $treeData;
    }

    public function render()
    {
        return view('components.elements.bom-tree', [
            'treeData' => json_encode($this->treeData),
        ]);
    }

    public function handleNodeSelect($nodeId)
    {
        // Handle selection of a node with ID $nodeId
        // You can update state, perform actions, etc.
        dd($nodeId);
    }
}
