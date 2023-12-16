<?php

namespace App\Livewire;

use Livewire\Component;

use App\Livewire\LwDocument;

class LwToc extends Component
{

    public $doctree;

    public function mount( $doctree = [])
    {
        $this->doctree = $doctree;
    }



    public function render()
    {
        return view('components.elements.toc-tree', [
            'doctree' => json_encode($this->doctree),
        ]);
    }



    public function handleNodeSelect($nodeId)
    {
        // Handle selection of a node with ID $nodeId
        // You can update state, perform actions, etc.
        dd($nodeId);
    }



}
