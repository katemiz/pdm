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
    public $lshape_radius = 10;

    // Circular Sections
    public $circle_od = 40;
    public $circle_id = 32;


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


        if ($this->shape == 'circle') {

            $this->areaCircle();
            $this->inertiaCircularSection();

            $this->dispatch('repaint',
                circle_od:$this->circle_od,
                circle_id:$this->circle_id,
                area:$this->area,
                ixx:$this->ixx,
                iyy:$this->iyy
            );

            return view('engineering.geometry.circle2');
        }




    }







    public function areaCircle () {

        $this->area = pi()/4*(pow($this->circle_od,2)-pow($this->circle_id,2));
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




    public function inertiaCircularSection() {

        // XX
        $this->ixx = pi()/4*(pow($this->circle_od,4)-pow($this->circle_id,4));
        $this->iyy = $this->ixx;


    }








    public function inertiaLShape() {

        // XX
        $this->ixx = $this->inertiaLShapeBase($this->lshape_width,$this->lshape_height,$this->lshape_thk2,$this->lshape_thk1,$this->lshape_radius,0);

        // YY
        $this->ixx = $this->inertiaLShapeBase($this->lshape_height,$this->lshape_width,$this->lshape_thk1,$this->lshape_thk2,$this->lshape_radius,0);

    }




    public function inertiaLShapeBase($w,$h,$wthk,$hthk,$r,$rc) {

        $i1 = $this->inertiaRectangle($hthk,$h,$h/2);
        $i2 = $this->inertiaRectangle($w-$hthk,$wthk,$wthk/2);


        // INNER CORNER RADIUS
        $iradius = $this->inertiaCorner($r,$wthk,'int');

        //dd($iradius);
        //dd([$i1,$i2,$i_radius_add,$i_radius_subtract]);


        return $i1+$i2+$iradius;

    }




    public function inertiaRectangle($width,$height,$d=0) {

        //dd([ $width,$height,$d,$width*pow($height,3)/12,$width*$height*pow($d,2)]);


        return $width*pow($height,3)/12+$width*$height*pow($d,2);
    }

    public function inertiaCircle($radius,$angle=360,$d=0) {



        $area = pi()*pow($radius,2)*$angle/360;

        //dd( [$angle*pi()*pow($radius,4)/(4*360),$area,$d,$angle*pi()*pow($radius,4)/(4*360)+$area*pow($d,2)]);



        return $angle*pi()*pow($radius,4)/(4*360)+$area*pow($d,2);
    }


    public function inertiaCorner($radius,$lower_right_point,$t = 'int') {

        $rect = $this->inertiaRectangle($radius,$radius,$lower_right_point+$radius/2);


        if ($t == 'int') {
            $dist = $lower_right_point+$radius-4*$radius/(3*pi());
            $qcircle = $this->inertiaCircle($radius,$angle=90,$dist);

            // dd($qcircle);

            return $rect-$qcircle;
        }

        if ($t == 'ext') {
            $dist = $lower_right_point+4*$radius/(3*pi());
            $qcircle = $this->inertiaCircle($radius,$angle=90,$dist);



            return $qcircle-$rect;
        }

        return false;
    }



























}
