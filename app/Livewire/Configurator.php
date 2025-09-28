<?php

namespace App\Livewire;

use Livewire\Component;

use App\Livewire\EngMast;



class Configurator extends Component
{

    public $overlapDimension = 500;  // m
    public $headDimension = 60; // m
    public $n; // Number of Sections 
    public $n_min = 2; 
    public $n_max = 15; 

    public $x; // Tube length variable


    public $extendedHeight;
    public $targetExtendedHeightMax=15.2; // m
    public $targetExtendedHeightMin=14.8; // m


    public $nestedHeight;
    public $targetNestedHeightMax=2.60; // m
    public $targetNestedHeightMin=2.40; // m


    public $tube_length_min = 400;
    public $tube_length_max = 3400;

    public $tube_length_increment = 10;

    public $solutionSet;
    public $currentSolution = 0;
    public $solutionTubeData;


    public $topAdapterThk = 12;
    public $baseAdapterThk = 20;

    public $adapters = [];

    public $points = [];

    public $mtProfiles;
    public $startTubeNo = 1;
    public $endTubeNo;



    public $showOtherParams = false;
    public $svgType = 'Nested'; // 'Extended' or 'Nested'

  


    public function mount()
    {
        $mtProfiles = new EngMast();
        $mtProfiles->MasttechProfiles();
        $this->mtProfiles =  $mtProfiles->tubeData;

        $this->endTubeNo = count($this->mtProfiles);
    }


    public function render()
    {
        $this->solutionSet = [];
        $this->Optimizer();

        return view('engineering.configurator');
    }


    public function getExtendedHeight(){
        $this->extendedHeight = $this->n*$this->x-($this->n - 1)*$this->overlapDimension;
        return true;
    } 


    public function getNestedHeight(){
        $this->nestedHeight = $this->x+($this->n - 1)*$this->headDimension;
        return true;
    } 


    public function Optimizer() {

        $tempTargetExtendedHeightMax = $this->targetExtendedHeightMax * 1000 - $this->topAdapterThk - $this->baseAdapterThk;
        $tempTargetExtendedHeightMin = $this->targetExtendedHeightMin * 1000 - $this->topAdapterThk - $this->baseAdapterThk;
        $tempTargetNestedHeightMax = $this->targetNestedHeightMax * 1000 - $this->topAdapterThk - $this->baseAdapterThk;
        $tempTargetNestedHeightMin = $this->targetNestedHeightMin * 1000 - $this->topAdapterThk - $this->baseAdapterThk;

        for ($this->n = $this->n_min; $this->n <= $this->n_max ; $this->n++) { 
    
            for ($this->x = $this->tube_length_min; $this->x <= $this->tube_length_max ; $this->x += $this->tube_length_increment) { 

                $this->getExtendedHeight();
                $this->getNestedHeight();

                if (
                    $this->extendedHeight >= $tempTargetExtendedHeightMin &&
                    $this->extendedHeight <= $tempTargetExtendedHeightMax &&

                    $this->nestedHeight >= $tempTargetNestedHeightMin &&
                    $this->nestedHeight <= $tempTargetNestedHeightMax
                ) {

                    $sonuc2["noOfSections"]  = $this->n;
                    $sonuc2["extendedHeight"]  = $this->extendedHeight;
                    $sonuc2["nestedHeight"]  = $this->nestedHeight;
                    $sonuc2["tubeLength"]  = $this->x;

                    $this->solutionSet[] = $sonuc2;
                }
            }
        }

        $this->calculateTubePointCoordinates();

        $this->dispatch('drawSvg',
            [
                'solutionSet' => $this->solutionSet,
                'solutionTubeData' => $this->solutionTubeData, 
                'currentSolution' => $this->currentSolution,
                'svgType' => $this->svgType,
                'adapters' => $this->adapters
            ]);

        return true;
    }


    function setCurrentSolution($index) {
        $this->currentSolution = $index;
        $this->calculateTubePointCoordinates();
        $this->dispatch('drawSvg',['solutionSet' => $this->solutionSet,'solutionTubeData' => $this->solutionTubeData, 'currentSolution' => $this->currentSolution]);
        return true;
    }


    function toggleMastPosition($position) {
        $this->svgType = $position;
    }


    function calculateTubePointCoordinates() {

        $this->solutionTubeData = [];

        $this->adapters['base']['thickness'] = $this->baseAdapterThk;
        $this->adapters['top']['thickness'] = $this->topAdapterThk;

        // A,B,C,D points of the tube rectangle
        // D(dx,dy)----------------C(cx,cy)
        // |                           |
        // |                           |
        // A(ax,ay)----------------B(bx,by)

        // return true;

        $sol =  $this->solutionSet[$this->currentSolution];

        $noOfSections = $sol['noOfSections'];

        foreach ($this->mtProfiles as $k => $singleTubeData) {

            if ($singleTubeData['no'] >= $this->startTubeNo && $singleTubeData['no'] <= $this->endTubeNo && $k <= $noOfSections - 1) {
               $this->solutionTubeData[]  = $singleTubeData;
            } 
        }

        foreach ($this->solutionTubeData as $i => $profile) {

            $profile = (object) $profile;

            /**
            * 
            * EXTENDED
            * 
            */

            // EXTENDED state coordinates
            // dy in extended position
            // dy = (n-l)*length - (n-1)*overlap

            $n = count($this->solutionTubeData) - $i;

            // POINT D
            $dx = -$profile->od / 2;  // Centered at x=0
            $dy = $n * $profile->length - ($n - 1) * $this->overlapDimension + $this->baseAdapterThk;

            // dd($dx,$dy,$n,$profile->length,$this->overlapDimension);

            // POINT B
            $bx = $profile->od/ 2;  // Centered at x=0
            $by = $dy - $profile->length;

            // POINT C
            $cx = $bx;
            $cy = $dy;

            // POINT A
            $ax = $dx;
            $ay = $by;

            // Store the coordinates
            $tubeCoordinates = [
                'A' => ['x' => $ax, 'y' => $ay],
                'B' => ['x' => $bx, 'y' => $by],
                'C' => ['x' => $cx, 'y' => $cy],
                'D' => ['x' => $dx, 'y' => $dy],
            ];

            $this->solutionTubeData[$i]['extended'] = $tubeCoordinates;


            // TOP TUBE
            if ($i == 0) {
                $this->adapters['top']['points']['Extended'] = [
                    'A' => ['x' => -2.5*$profile->od/2, 'y' => $dy],
                    'B' => ['x' => 2.5*$profile->od/2, 'y' => $dy],
                    'C' => ['x' => 2.5*$profile->od/2, 'y' => $dy + $this->topAdapterThk],
                    'D' => ['x' => -2.5*$profile->od/2, 'y' => $dy + $this->topAdapterThk],
                ];
            }

            // BOTTOM TUBE
            if ($i == $noOfSections - 1) {
                $this->adapters['base']['points']['Extended'] = [
                    'A' => ['x' => -1.5*$profile->od/2, 'y' => -$this->baseAdapterThk],
                    'B' => ['x' => 1.5*$profile->od/2, 'y' => -$this->baseAdapterThk],
                    'C' => ['x' => 1.5*$profile->od/2, 'y' => 0],
                    'D' => ['x' => -1.5*$profile->od/2, 'y' => 0],
                ];
            }

           /**
            * 
            * NESTED
            * 
            */

            // NESTED state coordinates
            // dy in nested position
            // dy = length - i*headDimension

            // POINT D
            $dx = -$profile->od / 2;  // Centered at x=0
            $dy = $profile->length + ($n - 1) * $this->headDimension + $this->baseAdapterThk;

            // POINT B
            $bx =$dx + $profile->od/ 2;  // Centered at x=0
            $by = $dy - $profile->length;

            // POINT C
            $cx = $bx;
            $cy = $dy;

            // POINT A
            $ax = $dx;
            $ay = $by;

            // Store the coordinates
            $tubeCoordinates = [
                'A' => ['x' => $ax, 'y' => $ay],
                'B' => ['x' => $bx, 'y' => $by],
                'C' => ['x' => $cx, 'y' => $cy],
                'D' => ['x' => $dx, 'y' => $dy],
            ];


            // TOP TUBE
            if ($i == 0) {
                $this->adapters['top']['points']['Nested'] = [
                    'A' => ['x' => -2.5*$profile->od/2, 'y' => $dy],
                    'B' => ['x' => 2.5*$profile->od/2, 'y' => $dy],
                    'C' => ['x' => 2.5*$profile->od/2, 'y' => $dy + $this->topAdapterThk],
                    'D' => ['x' => -2.5*$profile->od/2, 'y' => $dy + $this->topAdapterThk],
                ];
            }

            // BOTTOM TUBE
            if ($i == $noOfSections - 1) {
                $this->adapters['base']['points']['Nested'] = [
                    'A' => ['x' => -1.5*$profile->od/2, 'y' => -$this->baseAdapterThk],
                    'B' => ['x' => 1.5*$profile->od/2, 'y' => -$this->baseAdapterThk],
                    'C' => ['x' => 1.5*$profile->od/2, 'y' => 0],
                    'D' => ['x' => -1.5*$profile->od/2, 'y' => 0],
                ];
            }

           $this->solutionTubeData[$i]['nested'] = $tubeCoordinates;
        }

        // dd($this->adapters);

        // dd($this->solutionSet);
        // dd(vars: $this->solutionTubeData);
    } 






}
