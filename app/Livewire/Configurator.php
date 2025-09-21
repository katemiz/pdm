<?php

namespace App\Livewire;

use Livewire\Component;


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


    public $payloadAdapterThickness = 12;
    public $baseSupportThickness = 20;





    public $showOtherParams = false;

  


    public function mount()
    {
        // $this->targetExtendedHeightMin = $this->targetExtendedHeight-0.4;
        // $this->targetExtendedHeightMax = $this->targetExtendedHeight+0.4;

        // $this->targetNestedHeightMin = $this->targetNestedHeight-0.2;
        // $this->targetNestedHeightMax = $this->targetNestedHeight+0.2;
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

                    // $this->solutionSet[$this->n][] = $this->x;
                    $this->solutionSet[] = $sonuc;

                }
            }

        }

        // dd($this->solutionSet);



        return true;
    }










}
