<?php

namespace App\Livewire;

use Livewire\Attributes\On;


use Livewire\Component;

class Geometry extends Component
{
    public $shape;

    // L-Shaped Sections
    public $lshape_width = 120;
    public $lshape_height = 60;
    public $lshape_thk1 = 11;
    public $lshape_thk2 = 10;
    public $lshape_radius = 5;

    // Circular Sections
    public $circ_od;
    public $circ_thk;

    // Rectangular Sections
    public $width;
    public $height;
    public $rect_thk;
    public $rect_rout;
    public $rect_rinner;

    public function render()
    {


        if ($this->shape == 'lshape') {



            $this->dispatch('repaint',
                width:$this->lshape_width,
                height:$this->lshape_height,
                thk1:$this->lshape_thk1,
                thk2:$this->lshape_thk2,
                radius:$this->lshape_radius
            );



            return view('engineering.geometry.lshape');

        }
    }



























}
