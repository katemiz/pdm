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


    public $odia = 100;
    public $idia = 90;

    public $width = 50;
    public $height = 150;
    public $thickness = 5;
    public $rout = 10;
    public $rinn = 5;



    public $area;
    public $inertia;






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

        if ($this->odia == 0 || $this->odia === null || $this->odia <= $this->idia ) {
            $this->area     = 'undefined';
            $this->inertia  = 'undefined';

            return true;
        }

        $this->area     = round(pi()*(pow($this->odia/2,2) - pow($this->idia/2,2)),2);
        $this->inertia  = round(pi()*(pow($this->odia,4) - pow($this->idia,4)) / 64,2);

        $this->js("console.log('$this->area')");
        $this->js("console.log('$this->inertia')");

    }


    public function geometryRectangle()
    {






        if ($this->odia == 0 || $this->odia === null || $this->odia <= $this->idia ) {
            $this->area     = 'undefined';
            $this->inertia  = 'undefined';

            return true;
        }

        $this->area     = round($this->width*$this->height - ($this->width-$this->thickness*2)*($this->heightround-$this->thickness*2)+ pi()*(pow($this->rinn,2) - pow($this->rout,2)),2);


        $this->inertia  = round(pi()*(pow($this->odia,4) - pow($this->idia,4)) / 64,2);

        $this->js("console.log('$this->area')");
        $this->js("console.log('$this->inertia')");

    }










}
