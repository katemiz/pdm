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

        // $this->treeData = new Collection([
        //     [
        //         'id' => 1,
        //         'name' => 'Root Node',
        //         'children' => [
        //             [
        //                 'id' => 2,
        //                 'name' => 'Child Node 1',
        //                 'children' => [],
        //             ],
        //             [
        //                 'id' => 3,
        //                 'name' => 'Child Node 2',
        //                 'children' => [
        //                     [
        //                         'id' => 4,
        //                         'name' => 'Grandchild Node',
        //                         'children' => [],
        //                     ],
        //                 ],
        //             ],
        //         ],
        //     ],
        // ]);
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
