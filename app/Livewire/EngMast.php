<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

class EngMast extends Component
{

    public $action;


    public $tubeOd = 100;
    public $tubeId;
    public $tubeThickness;
    public $tubeLength;
    public $tubePressureArea;


    public $safetyFactor;

    public $pressurePsi;
    public $pressureMPa;
    public $pressureMax;

    public $pressureLoadInN;
    public $pressureLoadInKg;



    public $factorOfSafety = 2.0; // Factor of Safety
    public $tubeBucklingLength = 3000; // mm
    public $E = 210000; // MPa for Aluminum
    public $yieldStrength = 170; // MPa
    public $ultimateStrength = 210; // MPa
    public $materialDensity = 2.7; // g/cm3
    public $pressure = 2; // Bars


    public $smallestTubeId = 44; // mm
    public $smallestTubeThickness = 2.0; // mm
    public $noOfTubes = 16; // mm
    public $gapBetweenTubes = 7; // mm
    public $thicknessIncrement = 0.2; // mm

    public $tubeData = [];


    public $NoOfSections = 6;
    public $LengthOfSections = 3000;
    public $OverlapOfSections = 800;
    public $HeadOfSections = 200;
    public $extendedHeight;
    public $nestedHeight;


    public function mount()
    {
        if (request('action')) {
            $this->action = request('action');
        }
    }


    public function render()
    {
        switch ($this->action) {



            case 'pneumatic':
                $this->pneumaticLiftCapacity();
                return view('engineering.mast.pneumatic');
                break;


            case 'mttubes':
                $this->MasttechProfiles();
                return view('engineering.mast.mttubes');
                break;


            case 'heights':
                $this->MastHeights();
                return view('engineering.mast.heights');
                break;






            default:
                # code...
                break;
        }

        return view('engineering.eng');
    }









    public function pneumaticLiftCapacity() {


        if ($this->pressure == null || $this->tubeOd == null ) {



            $this->tubePressureArea = 0;
            $this->pressureMPa = 0;
            $this->pressurePsi = 0;

            $this->pressureLoadInN = 0;
            $this->pressureLoadInKg = 0;

            return true;

        }

        $this->tubePressureArea = pi()*pow($this->tubeOd,2)/4;

        $this->pressureMPa = $this->pressure*0.1;
        $this->pressurePsi = 14.5038*$this->pressure;

        $this->pressureLoadInN = $this->pressureMPa*$this->tubePressureArea;
        $this->pressureLoadInKg = $this->pressureLoadInN/9.81;
    }














    function MasttechProfiles() {

        $id = $this->smallestTubeId;
        $t  = $this->smallestTubeThickness;
        $od = $this->smallestTubeId + 2*$this->smallestTubeThickness;

        for ($i = 0; $i < 16; $i++) {

            $moment         = $this->CalculateMomentCapability($od,$id);
            $mass           = $this->CalculateMass($od,$id);
            $pressureLoad   = $this->CalculateLiftCapacity($od);
            $criticalLoad   = $this->ProfileCriticalLoad($od,$id);

            $this->tubeData[] = [
                "od" => $od,
                "id" => $id,
                "thk" => $t,
                "mass" => $mass,
                "moment" => $moment,
                "pressureLoad" => $pressureLoad,
                "criticalLoad" => $criticalLoad,
            ];

            $id = $od+2*$this->gapBetweenTubes;
            $t = $t+$this->thicknessIncrement;
            $od = $id+2*$t;
        }
    }


    function MastHeights() {





        if ($this->NoOfSections == null || $this->LengthOfSections == null || $this->OverlapOfSections == null || $this->HeadOfSections == null) {

            $this->extendedHeight = 0;
            $this->nestedHeight   = 0;

            return true;
        }


        $this->extendedHeight   = $this->NoOfSections*$this->LengthOfSections-($this->NoOfSections-1)*$this->OverlapOfSections;
        $this->nestedHeight     = $this->LengthOfSections+($this->NoOfSections-1)*$this->HeadOfSections;


    }



    function CalculateMomentCapability($od,$id) {

        return $this->yieldStrength*pi()*(pow($od,4)-pow($id,4))/(32*$od*1000);
    }



    function CalculateMass($od,$id) {

        return $this->materialDensity *(pow($od,2)- pow($id,2))*pi()/4000; // kg/m
        // 1000 = 1m
    }



    function CalculateLiftCapacity($od) {

        // Circular Area
        $area = pi()/4*pow($od,2);
        $pi_mpa = $this->pressure*0.1;

        return $pi_mpa*$area;
    }



    function ProfileCriticalLoad($od,$id) {

        // Euler Column Critical Load Formula is used

        // Pcr = π^2EI/4L^2
        // E = Young's Modulus
        // I = Moment of Inertia
        // L = Length of the column
        // Pcr = Critical Load

        return pi()*$this->E*$this->HollowTubeInertia($od,$id)/(pow($this->tubeBucklingLength,2)*$this->factorOfSafety);
    }



    function HollowTubeInertia($od,$id) {

        // Moment of Inertia for a hollow tube
        // I = π/64*(od^4-id^4)
        // od = outer diameter
        // id = inner diameter

        return pi()/64*(pow($od,4)-pow($id,4));
    }


}
