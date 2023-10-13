<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;

// use App\Models\Company;
// use App\Models\Endproduct;
// use App\Models\Moc;
// use App\Models\Phase;
// use App\Models\Project;
// use App\Models\User;



class Engineering extends Component
{
    use WithPagination;

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

            if ($this->odia == 0 || $this->odia === null || $this->odia <= $this->idia ) {
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

        if ($this->is_hollow) {

            // AREA
            $this->area = round($this->areaRectangleWithRadius($this->width,$this->height,$this->rout) - $this->areaRectangleWithRadius($this->width-2*$this->thickness,$this->height-2*$this->thickness,$this->rinn),2);

            $outer_inertia_xx = $this->inertiaRectangleWithRadius($this->width,$this->height,$this->rout);

            // dd($outer_inertia_xx);
            $inner_inertia_xx = $this->inertiaRectangleWithRadius($this->width-2*$this->thickness,$this->height-2*$this->thickness,$this->rinn);

            $outer_inertia_yy = $this->inertiaRectangleWithRadius($this->height,$this->width,$this->rout);
            $inner_inertia_yy = $this->inertiaRectangleWithRadius($this->height-2*$this->thickness,$this->width-2*$this->thickness,$this->rinn);

            $this->inertia_xx = round($outer_inertia_xx - $inner_inertia_xx,2);
            $this->inertia_yy = round($outer_inertia_yy - $inner_inertia_yy,2);

            $this->js("console.log('DIS$outer_inertia_xx')");
            $this->js("console.log('IC$inner_inertia_xx')");


        } else {

            // AREA
            $this->area = round($this->areaRectangleWithRadius($this->width,$this->height,$this->rout),2);

            $this->inertia_xx = $this->inertiaRectangleWithRadius($this->width,$this->height,$this->rout);
            $this->inertia_yy = $this->inertiaRectangleWithRadius($this->height,$this->width,$this->rout);

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











}
