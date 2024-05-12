<?php

namespace App\Livewire;

use Livewire\Attributes\On;


use Livewire\Component;

class Geometry extends Component
{
    public $shape;
    public $area;

    public $cx;
    public $cy;

    public $ixx;
    public $iyy;

    // L-Shaped Sections
    public $lshape_width = 100;
    public $lshape_height = 100;
    public $lshape_thk1 = 20;
    public $lshape_thk2 = 20;
    public $lshape_radius = 0;

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

            $this->areaLShape();
            $this->inertiaLShape();




            $this->dispatch('repaint',
                width:$this->lshape_width,
                height:$this->lshape_height,
                thk1:$this->lshape_thk1,
                thk2:$this->lshape_thk2,
                radius:$this->lshape_radius,
                area:$this->area,
                cx:$this->cx,
                cy:$this->cy,
                ixx:$this->ixx,
                iyy:$this->iyy
            );



            return view('engineering.geometry.lshape');

        }




    }



    public function areaLShape () {

        $area1 = $this->lshape_thk1*$this->lshape_thk2;
        $area2 = ($this->lshape_height-$this->lshape_thk2)*$this->lshape_thk1;
        $area3 = ($this->lshape_width-$this->lshape_thk1)*$this->lshape_thk2;
        $area4 = 0.25*pow($this->lshape_radius,2)*pi();

        $this->area = $area1 + $area2 + $area3 + $area4;

        $this->cx = (($this->lshape_thk1*($area1+$area2)/2.0) + $area3*(($this->lshape_width-$this->lshape_thk1)/2.0+$this->lshape_thk1))/$this->area;
        $this->cy = (($this->lshape_height*($area1+$area2)/2.0) + $area3*$this->lshape_thk2/2.0)/$this->area;
    }


    public function inertiaLShape() {


        $inertia1x = 1/12*($this->lshape_width-$this->lshape_thk1)*pow($this->lshape_thk2,3)+($this->lshape_width-$this->lshape_thk1)*$this->lshape_thk2*pow($this->lshape_thk2/2,2);
        $inertia2x = 1/12*$this->lshape_thk1*pow($this->lshape_height,3)+$this->lshape_thk1*$this->lshape_height*pow($this->lshape_height/2,2);

        $inertia1y = 1/12*($this->lshape_height)*pow($this->lshape_thk1,3)+$this->lshape_height*$this->lshape_thk1*pow($this->lshape_thk1/2,2);
        $inertia2y = 1/12*$this->lshape_thk2*pow($this->lshape_width-$this->lshape_thk1,3)+($this->lshape_width-$this->lshape_thk1)*$this->lshape_thk2*pow($this->lshape_thk1+($this->lshape_width-$this->lshape_thk1)/2,2);

        $this->ixx = $inertia1x+$inertia2x;
        $this->iyy = $inertia1y+$inertia2y;



    }



























}
