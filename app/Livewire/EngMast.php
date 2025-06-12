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
    public $smallestTubeThickness = 2; // mm
    public $noOfActiveTubes = 16; // quantity
    public $gapBetweenTubes = 7; // mm
    public $thicknessIncrement = 0.2; // mm

    public $tubeData = [];

    public $extendedHeight;
    public $nestedHeight;

    public $lengthMTTubes = 2000; // mm
    public $overlapMTTubes = 500; // mm
    public $headMTTubes = 70; // mm


    public $cd = 1.5;
    public $sailarea = 1.50;
    public $windspeed = 120;
    public $airdensity = 1.293; // kg/m3
    public $windload;

    public $xOffset = 100;
    public $zOffset = 500;
    public $startTubeNo = 1;
    public $endTubeNo = 16;

    public $noOfMTTubes = 16; // quantity


    public $showModal = false;
    public $showHelpModal = false;


    public $data;

    public $error;


    public $realTubeData = [
       [
           "no" => 1,
           "realArea" => 2,
           "realInertia" => 1000,
       ],

    ];   


    public function mount()
    {
        if (request('action')) {
            $this->action = request('action');
        }
    }


    public function render()
    {


       $this->error = null; 

        if ($this->endTubeNo <= $this->startTubeNo) {

            $this->noOfActiveTubes = null;
            $this->error = "End Tube Diameter must be greater than Start Tube Diameter"; 
        } else {

            $this->noOfActiveTubes = $this->endTubeNo - $this->startTubeNo + 1; 
        }







        switch ($this->action) {

            case 'pneumatic':
                $this->pneumaticLiftCapacity();
                break;

            default:
            case 'mttubes':
                $this->MasttechProfiles();
                break;

            case 'heights':
                $this->MastHeights();
                break;

            case 'deflection':
                $this->MastDeflections();
                $this->data["deneed"] = time();

                break;

            case 'wloads':
                $this->WindLoads();
                break;
        }





        return view('engineering.mast.mast');
    }




    public function increasePressure()
    {
        $this->pressure += 0.1;
        $this->pneumaticLiftCapacity();
    }

    public function decreasePressure()
    {
        $this->pressure -= 0.1;
        $this->pneumaticLiftCapacity();
    }

    public function increaseBucklingLength() {
        $this->tubeBucklingLength += 100;
        $this->MasttechProfiles();
    }

    public function decreaseBucklingLength() {
        $this->tubeBucklingLength -= 100;
        $this->MasttechProfiles();
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
                "no" => $i+1,
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
                "length" =>$this->lengthMTTubes
            ];

            $id = $od+2*$this->gapBetweenTubes;
            $t = $t+$this->thicknessIncrement;
            $od = $id+2*$t;
        }

    }


    function MastHeights() {

        $this->MasttechProfiles();

        if ($this->noOfActiveTubes == null || $this->lengthMTTubes == null || $this->overlapMTTubes == null || $this->headMTTubes == null) {

            $this->extendedHeight = 0;
            $this->nestedHeight   = 0;

            return true;
        }

        $this->extendedHeight   = $this->noOfActiveTubes*$this->lengthMTTubes-($this->noOfActiveTubes-1)*$this->overlapMTTubes;
        $this->nestedHeight     = $this->lengthMTTubes+($this->noOfActiveTubes-1)*$this->headMTTubes;
    }


    function MastDeflections() {

        $this->MastHeights();


        // $this->extendedHeight   = $this->noOfMTTubes*$this->lengthMTTubes-($this->noOfMTTubes-1)*$this->overlapMTTubes;
        // $this->nestedHeight     = $this->lengthMTTubes+($this->noOfMTTubes-1)*$this->headMTTubes;

        $n = $this->noOfMTTubes;
        // $n = $this->noOfActiveTubes;


        $maxDia = 0;

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

            $maxDia = max($maxDia,$this->tubeData[$i]['od']);
        }

        $this->data["xOffset"] = floatval($this->xOffset);
        $this->data["zOffset"] = floatval($this->zOffset);
        $this->data["extendedHeight"] = $this->extendedHeight;
        $this->data["nestedHeight"] = $this->nestedHeight;
        $this->data["maxDia"] = $maxDia;

        $this->data["tubeLength"] = $this->lengthMTTubes;
        $this->data["noOfTubes"] = $this->noOfMTTubes;
        $this->data["overlapLength"] = $this->overlapMTTubes;
        $this->data["headLength"] = $this->headMTTubes;

        $this->data["startTubeNo"] = intval($this->startTubeNo);
        $this->data["endTubeNo"] = intval($this->endTubeNo);

        $this->data["windLoad"] = 1000;


        $this->data["tubes"] = $this->tubeData;


        $this->dispatch('triggerCanvasDraw',data : $this->data);

        return true;
    }






    function WindLoads() {

        if ($this->sailarea == null || $this->windspeed == null|| $this->cd == null) {

            $this->windload = 0;
            return true;
        }

        $this->windload = 0.5*$this->airdensity*$this->cd*$this->sailarea*pow($this->windspeed/3.6,2);
    }



    function GetMore($tubeNo) {

        $this->showModal = true;
        $this->singleTubeData = $this->tubeData[$tubeNo];
    }


    function toggleModal() {

        $this->showModal = !$this->showModal;
    }


    function toggleHelpModal() {

        $this->showHelpModal = !$this->showHelpModal;
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
