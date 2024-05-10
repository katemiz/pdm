<?php

namespace App\Livewire;

use Livewire\Component;

class CanvasLshape extends Component
{
    public $lshape_width;
    public $lshape_height;
    public $lshape_thk1;
    public $lshape_thk2;
    public $lshape_radius;

    public function render()
    {
        return view('livewire.canvas-lshape');
    }
}
