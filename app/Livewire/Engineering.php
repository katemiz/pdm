<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

class Engineering extends Component
{

    public $action;
    public $is_hollow = true;

    public $odia = 100;
    public $idia = 90;

    public $width = 60;
    public $height = 100;
    public $thickness = 6;
    public $rout = 10;
    public $rinn = 4;

    public $area;
    public $inertia_xx;
    public $inertia_yy;


    public function mount()
    {
        if (request('action')) {
            $this->action = request('action');
        }
    }


    public function render()
    {
        switch ($this->action) {
            case 'geometry-circle':
                $this->geometryCircular();
                break;

            case 'geometry-rectangle':
                $this->geometryRectangle();
                break;


            case 'geometry-lshape':
                $this->geometryLshape();
                break;
    


            default:
                # code...
                break;
        }

        return view('engineering.eng');
    }


    public function selectAction($option)
    {
        $this->action = $option;
    }


    public function geometryCircular()
    {
        if ($this->is_hollow) {

            if ($this->odia < 0) {
                $this->odia = 0;
            }

            if ($this->idia < 0) {
                $this->idia = 0;
            }

            if ($this->odia == 0 || $this->odia === null || $this->odia <= $this->idia) {
                $this->area     = 'undefined';
                $this->inertia_xx  = 'undefined';
                return true;
            }

            $this->area     = round(pi()*(pow($this->odia/2,2) - pow($this->idia/2,2)),2);
            $this->inertia_xx  = round(pi()*(pow($this->odia,4) - pow($this->idia,4)) / 64,2);

        } else {

            if ($this->odia == 0 ) {
                $this->area     = 'undefined';
                $this->inertia_xx  = 'undefined';
                return true;
            }

            $this->area     = round(pi()*pow($this->odia/2,2),2);
            $this->inertia_xx  = round(pi()*pow($this->odia,4) / 64,2);
        }

        // $this->js("console.log('$this->area')");
        // $this->js("console.log('$this->inertia')");
    }


    public function geometryRectangle()
    {

        if ($this->width == 0 || $this->height == 0 ) {
            $this->area     = 'undefined';
            $this->inertia_xx  = 'undefined';
            $this->inertia_yy  = 'undefined';
            return true;
        }

        if ($this->thickness == 0) {
            $this->rinn = 0;
        }


        if ($this->rout > $this->width/2 || $this->rout > $this->height/2) {
            $this->rout = $this->width >= $this->height ? $this->height/2 : $this->width/2;
        }

        $area_outer = $this->width*$this->height + (pi() -4)*pow($this->rout,2);

        $outer_inertia_xx = $this->IRectangleWRadius($this->width,$this->height,$this->rout);
        $outer_inertia_yy = $this->IRectangleWRadius($this->height,$this->width,$this->rout);

        if ($this->is_hollow && $this->thickness > 0) {

            // AREA
            $w = $this->width -2*$this->thickness;
            $h = $this->height-2*$this->thickness;

            $area_inner = $w*$h + (pi() -4)*pow($this->rinn,2);

            $this->area =  round($area_outer- $area_inner,2);

            // INERTIA
            $inner_inertia_xx = $this->IRectangleWRadius($w,$h,$this->rinn);
            $inner_inertia_yy = $this->IRectangleWRadius($h,$w,$this->rinn);

            $this->inertia_xx = round($outer_inertia_xx - $inner_inertia_xx,2);
            $this->inertia_yy = round($outer_inertia_yy - $inner_inertia_yy,2);

            $this->js("console.log('DIS$outer_inertia_xx')");
            $this->js("console.log('IC$inner_inertia_xx')");


        } else {

            // AREA
            $this->area = round($area_outer,2);

            $this->inertia_xx = round($outer_inertia_xx,2);
            $this->inertia_yy = round($outer_inertia_yy,2);

            $this->js("console.log('Ixx$this->inertia_xx')");
            $this->js("console.log('Iyy$this->inertia_yy')");
        }
    }


    public function geometryLshape()
    {
        if ($this->width == 0 || $this->height == 0 ) {
            $this->area     = 'undefined';
            $this->inertia_xx  = 'undefined';
            $this->inertia_yy  = 'undefined';
            return true;
        }

        if ($this->thickness == 0) {
            $this->rinn = 0;
        }

        if ($this->rout > $this->width/2 || $this->rout > $this->height/2) {
            $this->rout = $this->width >= $this->height ? $this->height/2 : $this->width/2;
        }

        $area_outer = $this->width*$this->height + (pi() -4)*pow($this->rout,2);

        $outer_inertia_xx = $this->IRectangleWRadius($this->width,$this->height,$this->rout);
        $outer_inertia_yy = $this->IRectangleWRadius($this->height,$this->width,$this->rout);

        if ($this->is_hollow && $this->thickness > 0) {

            // AREA
            $w = $this->width -2*$this->thickness;
            $h = $this->height-2*$this->thickness;

            $area_inner = $w*$h + (pi() -4)*pow($this->rinn,2);

            $this->area =  round($area_outer- $area_inner,2);

            // INERTIA
            $inner_inertia_xx = $this->IRectangleWRadius($w,$h,$this->rinn);
            $inner_inertia_yy = $this->IRectangleWRadius($h,$w,$this->rinn);

            $this->inertia_xx = round($outer_inertia_xx - $inner_inertia_xx,2);
            $this->inertia_yy = round($outer_inertia_yy - $inner_inertia_yy,2);

            $this->js("console.log('DIS$outer_inertia_xx')");
            $this->js("console.log('IC$inner_inertia_xx')");


        } else {

            // AREA
            $this->area = round($area_outer,2);

            $this->inertia_xx = round($outer_inertia_xx,2);
            $this->inertia_yy = round($outer_inertia_yy,2);

            $this->js("console.log('Ixx$this->inertia_xx')");
            $this->js("console.log('Iyy$this->inertia_yy')");
        }
    }




    function areaRectangleWithRadius ($w,$h,$r) {
        return $w*$h-4*pow($r,2)+pi()*pow($r,2);
    }


    public function quarterCircleInertia($r,$h) {

        $d = ($h/2-$r) + $r/(3*pi())*(3*pi()-4);

        $inertia = pi()*pow($r,4)/16;

        $area = pi()*pow($r,2)/4;

        $inertia_xx = $inertia+$area*pow($d,2);

        // dd($inertia_xx);
        $this->js("console.log('kose$inertia_xx')");

        return $inertia_xx;
    }


    public function inertiaRectangleWithRadius($w,$h,$r) {

        $inertia_a = $w*pow($h-2*$r,3)/12;
        $inertia_b = 2*(($w-2*$r)*pow($r,3)/12+($w-2*$r)*$r*pow($h/2-$r/2,2));

        $inertia_k = $this->quarterCircleInertia($r,$h);

        $ab = $inertia_a+$inertia_b;

        $this->js("console.log('w$w')");
        $this->js("console.log('h$h')");
        $this->js("console.log('r$r')");

        $this->js("console.log('a$inertia_a')");
        $this->js("console.log('b$inertia_b')");

        $this->js("console.log('ab$ab')");

        $this->js("console.log('k$inertia_k')");
        $inertia = $inertia_a+$inertia_b+$inertia_k;

        // dd($inertia);

        $this->js("console.log('SON$inertia')");

        return $inertia;
    }


    function IRectangular($a,$b) {
        // a*b^3/12
        return ($a*pow($b,3)) / 12;
    }


    function ICircular($r) {
        // pi*r^4/4
        return (pi()*pow($r,4)) / 4;
    }


    function ICircularQuarter($r) {
        // pi*r^4/16
        return $this->ICircular($r)/4;
    }


    function IAxis($i,$A,$d) {
        // Ixx = Inertia + Area * d^2
        return $i+$A*pow($d,2);
    }


    function IRectangleWRadius($a,$b,$r) {

        $inertia_rect_1 = $this->IRectangular($a,$b-2*$r);

        $this->js("console.log('I1a $inertia_rect_1')");


        $d1 = $b/2+$r/2;
        $inertia_rect_2 = $this->IRectangular($a-2*$r,$b-2*$r) + ($a-2*$r)*$r*pow($d1,2);

        $this->js("console.log('I2a $inertia_rect_2')");


        $inertia_4_quar = $this->ICircular($r);

        // Four quarter circles, add up to one full circle
        $d = $b/2-$r;

        $circle_wrt_axis = $this->IAxis( $this->ICircular($r), pi()*pow($r,2), $d );

        return $inertia_rect_1 + $inertia_rect_2 +  $circle_wrt_axis;
    }
}
