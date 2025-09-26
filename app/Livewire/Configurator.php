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
    public $targetExtendedHeightMax=15400;
    public $targetExtendedHeightMin=14800;


    public $nestedHeight;
    public $targetNestedHeightMax=2600;
    public $targetNestedHeightMin=2400;


    public $tube_length_min = 400;
    public $tube_length_max = 3400;

    public $tube_length_increment = 10;

    public $solutionSet;
    public $currentSolution = 0;
    public $solutionTubeData;


    public $payloadAdapterThickness = 12;
    public $baseSupportThickness = 20;

    public $mtProfiles;
    public $startTubeNo = 1;
    public $endTubeNo;



    public $showOtherParams = false;

  


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

        // $this->payloadAdapterThickness /= 1000;
        // $this->baseSupportThickness /= 1000;
        // $this->overlapDimension /= 1000;
        // $this->headDimension /= 1000;

        $this->Optimizer();

        return view('engineering.configurator');
    }


    public function getExtendedHeight(){

        $this->extendedHeight = $this->n*$this->x-($this->n - 1)*$this->overlapDimension + $this->payloadAdapterThickness + $this->baseSupportThickness;
        return true;
    } 


    public function getNestedHeight(){

        $this->nestedHeight = $this->x+($this->n - 1)*$this->headDimension + $this->payloadAdapterThickness + $this->baseSupportThickness;
        return true;
    } 


    public function Optimizer() {

        for ($this->n = $this->n_min; $this->n <= $this->n_max ; $this->n++) { 
    
            for ($this->x = $this->tube_length_min; $this->x <= $this->tube_length_max ; $this->x += $this->tube_length_increment) { 

                $this->getExtendedHeight();
                $this->getNestedHeight();

                // dd($this->extendedHeight,$this->nestedHeight);

                if (
                    $this->extendedHeight >= $this->targetExtendedHeightMin &&
                    $this->extendedHeight <= $this->targetExtendedHeightMax &&

                    $this->nestedHeight >= $this->targetNestedHeightMin &&
                    $this->nestedHeight <= $this->targetNestedHeightMax
                ) {

                    $sonuc = $this->n.' Sections, Extended Height: '.$this->extendedHeight.', Nested Height: '.$this->nestedHeight.' and Tube Length of '.$this->x;

                    $sonuc2["noOfSections"]  = $this->n;
                    $sonuc2["extendedHeight"]  = $this->extendedHeight;
                    $sonuc2["nestedHeight"]  = $this->nestedHeight;
                    $sonuc2["tubeLength"]  = $this->x;

                    // $this->solutionSet[$this->n][] = $this->x;
                    $this->solutionSet[] = $sonuc2;
                }
            }
        }

        // dd($this->solutionSet,$this->mtProfiles);
        // dd($this->mtProfiles);

                    // dd($this->extendedHeight,$this->nestedHeight,$this->solutionSet);


        $this->calculateTubePointCoordinates();
        $this->dispatch('drawSvg',['solutionSet' => $this->solutionSet,'solutionTubeData' => $this->solutionTubeData, 'currentSolution' => $this->currentSolution]);
        return true;
    }




    function calculateTubePointCoordinates() {

        // A,B,C,D points of the tube rectangle
        // D(dx,dy)----------------C(cx,cy)
        // |                           |
        // |                           |
        // A(ax,ay)----------------B(bx,by)

        // return true;

        $sol =  $this->solutionSet[$this->currentSolution];

        $curExtendedHeight = $sol["extendedHeight"];

        $noOfSections = $sol['noOfSections'];


        // dd($curExtendedHeight);

        // $this->startTubeNo = 16;
        // $this->endTubeNo = 16 - $sol['noOfSections'];
        // $this->mtProfiles = array_slice($this->mtProfiles, $this->endTubeNo-1, $sol['noOfSections']);


        foreach ($this->mtProfiles as $k => $singleTubeData) {

            if ($singleTubeData['no'] >= $this->startTubeNo && $singleTubeData['no'] <= $this->endTubeNo && $k <= $noOfSections - 1) {
               $this->solutionTubeData[]  = $singleTubeData;
            } 
        }



        foreach ($this->solutionTubeData as $i => $profile) {

            $profile = (object) $profile;

            // EXTENDED state coordinates
            // dy in extended position
            // dy = (n-l)*length - (n-1)*overlap

            $n = count($this->solutionTubeData) - $i;


            // POINT D
            $dx = -$profile->od / 2;  // Centered at x=0
            $dy = $n * $profile->length - ($n - 1) * $this->overlapDimension;

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

            // NESTED state coordinates
            // dy in nested position
            // dy = length - i*headDimension

            // POINT D
            $dx = -$profile->od / 2;  // Centered at x=0
            $dy = $profile->length + ($n - 1) * $this->headDimension;

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

           $this->solutionTubeData[$i]['nested'] = $tubeCoordinates;





        }

        // dd($this->solutionTubeData);





    } 






}
