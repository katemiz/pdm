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
    public $tubeArea;
    public $tubeInertia;

    public $singleTubeData = [];


    public $safetyFactor;

    public $pressurePsi;
    public $pressureMPa;
    public $pressureMax;

    public $pressureLoadInN;
    public $pressureLoadInKg;



    public $factorOfSafety = 2.0; // Factor of Safety
    public $tubeBucklingLength = 3000; // mm
    public $E = 70000; // MPa for Aluminum
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

    public $noOfMTTubes = 15;
    public $lengthMTTubes = 2000; // mm
    public $overlapMTTubes = 500; // mm
    public $headMTTubes = 70; // mm


    public $showModal = false;


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

            case 'deflection':
                $this->MastDeflections();
                return view('engineering.mast.deflection');
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

        for ($i = 0; $i < $this->noOfMTTubes; $i++) {

            $moment         = $this->CalculateMomentCapability($od,$id);
            $mass           = $this->CalculateMass($od,$id);
            $pressureLoad   = $this->CalculateLiftCapacity($od);
            $criticalLoad   = $this->ProfileCriticalLoad($od,$id);

            $this->tubeData[$i] = [
                "od" => $od,
                "id" => $id,
                "thk" => $t,
                "mass" => $mass,
                "moment" => $moment,
                "area" => $this->CalculateArea($od,$id),
                "inertia" => $this->HollowTubeInertia($od,$id),
                "EI" => $this->EI($od,$id),
                "pressureLoad" => $pressureLoad,
                "criticalLoad" => $criticalLoad,
                "length" =>$this->LengthOfSections
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


    function MastDeflections() {

        $this->MasttechProfiles();

        $this->extendedHeight   = $this->noOfMTTubes*$this->lengthMTTubes-($this->noOfMTTubes-1)*$this->overlapMTTubes;
        $this->nestedHeight     = $this->lengthMTTubes+($this->noOfMTTubes-1)*$this->headMTTubes;

        $n = $this->noOfMTTubes;

        for ($i = 0; $i < $this->noOfMTTubes; $i++) {

            if ($n > 1) {

                $eth    = $n*$this->lengthMTTubes-($n-1)*$this->overlapMTTubes;
                $ebh    = $eth-$this->lengthMTTubes;

                $nth    = $this->lengthMTTubes+($n-1)*$this->headMTTubes;
                $nbh    = $nth-$this->lengthMTTubes;

            } else {

                $eth    = $this->lengthMTTubes;
                $ebh    = $eth-$this->lengthMTTubes;

                $nth    = $this->lengthMTTubes;
                $nbh    = $nth-$this->lengthMTTubes;
            }

            $this->tubeData[$i]['heights'] = [
                'eth' => $eth,
                'ebh' => $ebh,
                'nth' => $nth,
                'nbh' => $nbh,
            ];

            $n--;
        }

        // dd([$this->tubeData,$this->extendedHeight,$this->nestedHeight]);

        // dd([$this->extendedHeight,$this->nestedHeight,$this->lengthMTTubes,$this->noOfMTTubes,$this->overlapMTTubes,$this->headMTTubes]);


    }


    function GetMore($tubeNo) {

        $this->showModal = true;

        //dd($this->tubeData);

        $this->singleTubeData = $this->tubeData[$tubeNo];

        //dd($this->singleTubeData);

    }


    function toggleModal() {


        $this->showModal = !$this->showModal;
    }



    function CalculateMomentCapability($od,$id) {

        return $this->yieldStrength*pi()*(pow($od,4)-pow($id,4))/(32*$od*1000);
    }



    function CalculateMass($od,$id) {

        return $this->materialDensity *$this->CalculateArea($od,$id)/1000; // kg/m
        // 1000 = 1m
    }




    function CalculateArea($od,$id) {

        return (pow($od,2)- pow($id,2))*pi()/4; // mm2
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






    function EI($od,$id) {
        // EI = E*I

        // E = Young's Modulus
        // I = Moment of Inertia

        return $this->E*$this->HollowTubeInertia($od,$id);
    }

}
