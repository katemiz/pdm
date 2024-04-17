<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Document;


class LwToc extends Component
{

    public $uid;

    public function mount( $uid = false)
    {
        $this->uid = $uid;
    }



    public function render()
    {
        return view('components.elements.toc-tree', [
            'doctree' => $this->getDoctree(),
        ]);
    }



    public function getDoctree() {

        if ($this->uid) {
            return json_encode(Document::find($this->uid)->toc);
        } else {
            return false;
        }
    }


    #[On('addTreeTriggered')]
    public function yepYeni()
    {
        $this->dispatch('childTriggered');

    }




    #[On('addNode')]
    public function addNode($node)
    {

        $this->dispatch('nodeAddedUpdateTree',parentId:false,id:$node['id'],name:$node['name']);


    }

    public function handleNodeSelect($nodeId)
    {
        // Handle selection of a node with ID $nodeId
        // You can update state, perform actions, etc.
        dd($nodeId);
    }



}
