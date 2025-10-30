<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

class Powerline extends Component
{

    public $motor_power = 500;  // Watts
    public $motor_rpm = 1400;
    public $motor_angular_velocity; // 1/sec

    public $motor_voltage = 24; // V
    public $motor_max_torque;

    public $motor_types = [
        [
            "id" => 1,
            "name"=> "12 VDC",
            "voltage"=> "12",
            "current"=> null,
        ],

        [
            "id"=> 2,
            "name"=> "24 VDC",
            "voltage"=> "24",
            "current"=> null,
        ],

        [
            "id"=> 3,
            "name"=> "28 VDC",
            "voltage" => 28,
            "current" => null
        ],
        
        [
            "id"=> 4,
            "name"=> "220 AC",
            "voltage"=> 220,
            "current"=> null
        ],
    ];

    public $ropeLoadCapacity = [];

    public $ropeGrades =["1180","1570","1770","1960","2160"]; // N/mm2"
    public $ropeDiameters = [3,4,5,6,7,8,9,10,12,14,16]; // mm

    public $fillFactor =[
        "min"=> 0.6226,
        "max"=> 0.755
    ];
    public $spinningLoadFactor = [
        "min"=> 0.81,
        "max"=> 0.85
    ];


    public $g = 9.81; // m/s2
    public $pulleyType = 1; 

    public $current_motor_id = 1;

    public $gearbox_reduction_ratio = 10;
    public $gearbox_output_torque = NUll;
    public $gearbox_allowable_max_torque = 70; //Nm
    public $gearbox_efficiency = 80;

    public $gearbox_angular_velocity_rpm;
    public $gearbox_angular_velocity_rad; // rad/s

    public $gearbox_output_power; // W

    
    public $drum_has_gearbox = false;
    public $drum_gearbox_reduction_ratio = 10;
    public $drum_gearbox_torque;
    public $drum_output_torque;

    public $drum_gearbox_allowable_max_torque = 50; //Nm

    public $drum_gearbox_efficiency = 87;

    public $drum_angular_velocity_rpm;
    public $drum_angular_velocity_rad;

    public $drum_output_power;

    public $drum_diameter = 80; // mm
    public $drum_wire_diameter = 8; // mm

    public $drum_pull_force_wound1;
    public $drum_pull_force_wound2;
    public $drum_pull_force_wound3;
    public $drum_pull_force_wound4;

    public $drum_pull_velocity_wound1;
    public $drum_pull_velocity_wound2;
    public $drum_pull_velocity_wound3;
    public $drum_pull_velocity_wound4;


    public $load = 120; // kg
    public $lift_speed_target = 0.1; // m/s
    public $power_required; // W
    public $force_required; // N

    public $lift_force_1;
    public $lift_force_2;
    public $lift_force_3;
    public $lift_force_4;



    public $lift_velocity_1;
    public $lift_velocity_2;
    public $lift_velocity_3;
    public $lift_velocity_4;        


    public $safety_factor = 1.5;

    public $k_coefficient;

    public $load_liftable_by_force_1 = false;
    public $load_liftable_by_force_2 = false;
    public $load_liftable_by_force_3 = false;
    public $load_liftable_by_force_4 = false;

    public $load_liftable_by_velocity_1 = false;
    public $load_liftable_by_velocity_2 = false;
    public $load_liftable_by_velocity_3 = false;
    public $load_liftable_by_velocity_4 = false;

    public function mount()
    {
       $this->ropeCalculations(); 
    }


    public function render()
    {
        $this->MotorCalculations();
        $this->GearBoxCalculations();
        $this->DrumCalculations();
        $this->LiftCalculations();
        $this->isLoadLiftable();

        if (request('rope')) {
            return view('engineering.wire_ropes');
        } else {
            return view('engineering.powerline');
        }
    }


    public function setPulleyType($typeNo){

        $this->pulleyType = $typeNo;

    } 


    public function MotorCalculations() {

        // P = T*n*2PI/60

        $this->motor_max_torque = 60*$this->motor_power/(2*pi()*$this->motor_rpm);
        $this->motor_angular_velocity = 2*pi()*$this->motor_rpm/60; // rad/sec

        return true;
    }


    public function GearBoxCalculations() {

        // P = T*n*2PI/60

        $this->gearbox_output_torque = $this->gearbox_efficiency*$this->motor_max_torque*$this->gearbox_reduction_ratio/100;

        $this->gearbox_angular_velocity_rpm = $this->motor_rpm/$this->gearbox_reduction_ratio;
        $this->gearbox_angular_velocity_rad = 2*pi()*$this->gearbox_angular_velocity_rpm/60; // rad/sec

        $this->gearbox_output_power = $this->motor_power*$this->gearbox_efficiency/100;

        return true;
    }



    public function DrumCalculations() {

        // P = T*n*2PI/60

        if ($this->drum_has_gearbox) {

            $this->drum_output_power = $this->gearbox_output_power*$this->drum_gearbox_efficiency/100;
            $this->drum_gearbox_torque = $this->drum_gearbox_efficiency*$this->gearbox_output_torque/$this->drum_gearbox_reduction_ratio;

            $this->drum_output_torque = $this->drum_gearbox_torque;

            $this->drum_angular_velocity_rpm = $this->gearbox_angular_velocity_rpm/$this->drum_gearbox_reduction_ratio;
            $this->drum_angular_velocity_rad = 2*pi()*$this->drum_angular_velocity_rpm/60; // rad/sec



        } else {

            $this->drum_output_torque = $this->gearbox_output_torque;
            $this->drum_output_power = $this->gearbox_output_power;

            $this->drum_angular_velocity_rpm = $this->gearbox_angular_velocity_rpm;
            $this->drum_angular_velocity_rad = 2*pi()*$this->drum_angular_velocity_rpm/60; // rad/sec
        }

        $moment_arm_wound1 = ($this->drum_wire_diameter+$this->drum_diameter)/2000; // Diameter to radius and to m
        $moment_arm_wound2 = ($this->drum_wire_diameter+2*$this->drum_diameter)/2000; // Diameter to radius and to m
        $moment_arm_wound3 = ($this->drum_wire_diameter+3*$this->drum_diameter)/2000; // Diameter to radius and to m
        $moment_arm_wound4 = ($this->drum_wire_diameter+4*$this->drum_diameter)/2000; // Diameter to radius and to m


        $this->drum_pull_force_wound1 = $this->drum_output_torque/$moment_arm_wound1;
        $this->drum_pull_force_wound2 = $this->drum_output_torque/$moment_arm_wound2;
        $this->drum_pull_force_wound3 = $this->drum_output_torque/$moment_arm_wound3;
        $this->drum_pull_force_wound4 = $this->drum_output_torque/$moment_arm_wound4;


        $this->drum_pull_velocity_wound1 = $moment_arm_wound1*$this->drum_angular_velocity_rad;
        $this->drum_pull_velocity_wound2 = $moment_arm_wound2*$this->drum_angular_velocity_rad;
        $this->drum_pull_velocity_wound3 = $moment_arm_wound3*$this->drum_angular_velocity_rad;
        $this->drum_pull_velocity_wound4 = $moment_arm_wound4*$this->drum_angular_velocity_rad;



        return true;
    }



    public function LiftCalculations() {

        switch ($this->pulleyType) {

            // Direct Lifting
            case 1:
                $this->lift_force_1 = $this->drum_pull_force_wound1/$this->safety_factor;
                $this->lift_force_2 = $this->drum_pull_force_wound2/$this->safety_factor;
                $this->lift_force_3 = $this->drum_pull_force_wound3/$this->safety_factor;
                $this->lift_force_4 = $this->drum_pull_force_wound4/$this->safety_factor;

                $this->lift_velocity_1 = $this->drum_pull_velocity_wound1;
                $this->lift_velocity_2 = $this->drum_pull_velocity_wound2;
                $this->lift_velocity_3 = $this->drum_pull_velocity_wound3;
                $this->lift_velocity_4 = $this->drum_pull_velocity_wound4;



                $this->power_required = $this->load*$this->g*$this->lift_speed_target*$this->safety_factor; 

                $this->force_required = $this->load*$this->g*$this->safety_factor; 


                break;

            // Load is Divided Lifting
            case 2:
                $this->lift_force_1 = $this->drum_pull_force_wound1/($this->safety_factor);
                $this->lift_force_2 = $this->drum_pull_force_wound2/($this->safety_factor);
                $this->lift_force_3 = $this->drum_pull_force_wound3/($this->safety_factor);
                $this->lift_force_4 = $this->drum_pull_force_wound4/($this->safety_factor);

                $this->lift_velocity_1 = $this->drum_pull_velocity_wound1;
                $this->lift_velocity_2 = $this->drum_pull_velocity_wound2;
                $this->lift_velocity_3 = $this->drum_pull_velocity_wound3;
                $this->lift_velocity_4 = $this->drum_pull_velocity_wound4;


                $this->power_required = $this->load*$this->g*$this->lift_speed_target*$this->safety_factor; 

                $this->force_required = $this->load*$this->g*$this->safety_factor/2;

                break;
        }

        return true;
    }


    public function isLoadLiftable() {

        // FORCE CHECK

        if ($this->lift_force_1 > $this->load*$this->g) {
           $this->load_liftable_by_force_1 = true; 
        }

        if ($this->lift_force_2 > $this->load*$this->g) {
           $this->load_liftable_by_force_2 = true; 
        }

        if ($this->lift_force_3 > $this->load*$this->g) {
           $this->load_liftable_by_force_3 = true; 
        }

        if ($this->lift_force_4 > $this->load*$this->g) {
           $this->load_liftable_by_force_4 = true; 
        }


        // VELOCITY CHECK

        if ($this->lift_velocity_1 > $this->lift_speed_target) {
           $this->load_liftable_by_velocity_1 = true; 
        }

        if ($this->lift_velocity_2 > $this->lift_speed_target) {
           $this->load_liftable_by_velocity_2 = true; 
        }

        if ($this->lift_velocity_3 > $this->lift_speed_target) {
           $this->load_liftable_by_velocity_3 = true; 
        }

        if ($this->lift_velocity_4 > $this->lift_speed_target) {
           $this->load_liftable_by_velocity_4 = true; 
        }

        return true;

    } 





    public function ropeCalculations() {





        foreach ($this->ropeDiameters as $diameter) {
            $rope_area = pi() * pow($diameter / 2, 2);

            foreach ($this->ropeGrades as $grade) {
                $rope_strength_min = $grade * $rope_area* $this->fillFactor["min"] * $this->spinningLoadFactor["min"];
                $rope_strength_max = $grade * $rope_area* $this->fillFactor["max"] * $this->spinningLoadFactor["max"];

              $this->ropeLoadCapacity[$diameter][$grade] = round($rope_strength_min, 0). ' - '.round($rope_strength_max, 0);
            }

        }

        return true;

    }






}
