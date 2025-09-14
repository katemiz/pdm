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

    public $drum_wire_force_wound1;
    public $drum_wire_force_wound2;
    public $drum_wire_force_wound3;
    public $drum_wire_force_wound4;


    public $load = 120; // kg
    public $load_divider = 1;

    public $lift_speed;

    public $safety_factor = 2;

    public $k_coefficient;




    public function mount()
    {

        $this->k_coefficient = $this->safety_factor/$this->gearbox_efficiency;

    }


    public function render()
    {

        $this->MotorCalculations();
        $this->GearBoxCalculations();
        $this->DrumCalculations();




        return view('engineering.powerline');
    }



    public function MotorCalculations() {

        // P = T*n*2PI/60

        $this->motor_max_torque = 60*$this->motor_power/(2*pi()*$this->motor_rpm);


        $this->motor_angular_velocity = 2*pi()*$this->motor_rpm/60; // rad/sec
        return true;
    }


    public function GearBoxCalculations() {

        // P = T*n*2PI/60

        $this->gearbox_output_torque = $this->gearbox_efficiency*$this->motor_max_torque/$this->gearbox_reduction_ratio;

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


        $this->drum_wire_force_wound1 = $this->drum_output_torque/$moment_arm_wound1;
        $this->drum_wire_force_wound2 = $this->drum_output_torque/$moment_arm_wound2;
        $this->drum_wire_force_wound3 = $this->drum_output_torque/$moment_arm_wound3;
        $this->drum_wire_force_wound4 = $this->drum_output_torque/$moment_arm_wound4;


        return true;
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

            // $moment         = $this->CalculateMomentCapability($od,$id, $i);
            // $mass           = $this->CalculateMass($od,$id, $i);
            // $pressureLoad   = $this->CalculateLiftCapacity($od);
            // $criticalLoad   = $this->ProfileCriticalLoad($od,$id, $i);

            $this->tubeData[$i] = [
                "no" => $i+1,
                "od" => $od,
                "id" => $id,
                "thk" => $t,
                // "massBasic" => $mass,
                // "moment" => $moment,
                // "areaBasic" => $this->CalculateArea($od,$id),
                // "area" => $this->realTubeData[$i]['area'],
                // "inertiaBasic" => $this->HollowTubeInertia($od,$id),
                // "inertia" => $this->realTubeData[$i]['inertia'],
                // "EI" => $this->EI($od,$id),
                "pressureLoad" => $this->CalculateLiftCapacity($od),
                // "criticalLoad" => $criticalLoad,
                "length" =>$this->lengthMTTubes
            ];

            // $this->tubeData[$i]['mass'] = $this->tubeData[$i]['area'] * $this->materialDensity;

            $this->CalculateArea($od,$id,$i);
            $this->CalculateMass($od,$id, $i);
            $this->CalculateInertia($od,$id, $i);
            $this->CalculateMomentCapability($od,$id, $i);

            $this->ProfileCriticalLoad($od,$id, $i);

            $this->EI($od,$id,$i);


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

        $maxDia = 0;
        $i = 0;

        for ($n = $this->noOfMTTubes; $n > 0; $n--) {

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
                'nbh' => $nbh
            ];

            $maxDia = max($maxDia,$this->tubeData[$i]['od']);

            $i++;
        }

        // Add kink height data to array [top kink point]
        foreach ($this->tubeData as $i => $tube) {

            if ($i < $this->noOfMTTubes -1) {
                $this->tubeData[$i]['heights']['kinkh'] = $this->tubeData[$i+1]['heights']['eth'];
            } else {
                $this->tubeData[$i]['heights']['kinkh'] = 0;
            }

            // Wind Force Application Height
            $this->tubeData[$i]['heights']['wforceh'] = ($this->tubeData[$i]['heights']['eth'] + $this->tubeData[$i]['heights']['kinkh']) / 2;
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

        $this->data["windLoadOnPayload"] = 1000;

        $this->data["tubes"] = $this->tubeData;

        $this->dispatch('triggerCanvasDraw',data : $this->data);

        $this->WindLoadOnPayload();

        return true;
    }


    function WindLoadOnPayload() {

        if ($this->sailarea == null || $this->windspeed == null|| $this->cd == null) {

            $this->windLoadOnPayload = 0;
            return true;
        }

        $this->windLoadOnPayload = 0.5*$this->airdensity*$this->cd*$this->sailarea*pow($this->windspeed/3.6,2);
    }


    function GetMore($tubeNo) {

        $this->showModal = true;
        $this->singleTubeData = $this->tubeData[$tubeNo];
    }


    function toggleModal() {

        $this->showModal = !$this->showModal;
    }


    function toggleHelpModal($modalType) {

        $this->modalType = $modalType; 
        $this->showHelpModal = !$this->showHelpModal;
    }


    function CalculateMomentCapability($od,$id,$i) {

        // Moment Capability
        // M = σ * I / y

        $this->tubeData[$i]['momentBasic'] = $this->yieldStrength*pi()*(pow($od,4)-pow($id,4))/(32*$od*1000); // Nm
        $this->tubeData[$i]['moment'] = $this->yieldStrength*$this->realTubeData[$i]['inertia']/(0.5*$od*1000); // Nm

        return true;
    }


    function CalculateMass($od,$id,$i) {

        $this->tubeData[$i]['mass'] = $this->materialDensity * $this->realTubeData[$i]['area']/1000; // kg/m
        return true;
    }


    function CalculateArea($od,$id,$i) {

        $this->tubeData[$i]['areaBasic'] = (pow($od,2)- pow($id,2))*pi()/4; // mm2
        $this->tubeData[$i]['area'] = $this->realTubeData[$i]['area'];

        return true;
    }


    function CalculateLiftCapacity($od) {

        // Circular Area
        $area = pi()/4*pow($od,2);
        $pi_mpa = $this->pressure*0.1;

        return $pi_mpa*$area;
    }



    function ProfileCriticalLoad($od,$id,$i) {

        // Euler Column Critical Load Formula is used

        // Pcr = π^2EI/4L^2
        // E = Young's Modulus
        // I = Moment of Inertia
        // L = Length of the column
        // Pcr = Critical Load


       $this->tubeData[$i]['criticalLoad'] = pi()*$this->E*$this->realTubeData[$i]['inertia']/(pow($this->tubeBucklingLength,2)*$this->factorOfSafety);

       return true;

        // return pi()*$this->E*$this->HollowTubeInertia($od,$id)/(pow($this->tubeBucklingLength,2)*$this->factorOfSafety);
    }



    function CalculateInertia($od,$id,$i) {

        // Moment of Inertia for a hollow tube
        // I = π/64*(od^4-id^4)
        // od = outer diameter
        // id = inner diameter

        $this->tubeData[$i]['inertiaBasic'] = pi()/64*(pow($od,4)-pow($id,4)); // mm4
        $this->tubeData[$i]['inertia'] = $this->realTubeData[$i]['inertia'];

        return true;
    }






    function EI($od,$id,$i) {
        // EI = E*I

        // E = Young's Modulus
        // I = Moment of Inertia

       $this->tubeData[$i]['EI'] = $this->E*$this->realTubeData[$i]['inertia']; // Nmm2 

        //return $this->E*$this->HollowTubeInertia($od,$id);
    }
    









    function calculateTubeWindLoads() {

        /*
        1. Calculate Reference Area
        2. Calculate Reference Height
        3. Calculate Terrain Factor kr
        4. Calculate The roughness factor cr(ze) at the reference height
        5. Cacculate Mean Velocity
        6. Calculate Turbulence Intensity
        7. Calculate Basic Velocity Pressure
        8. Calculate Peak Velocity Pressure
        9. Calculate Wind velocity corresponding to peak velocity pressure
        10. Calculate Reynolds Number
        11. Surface Roughness taken as 0.1 for Aluminum coated
        12. Calculate Structural Factor
        13. Calculate Effective Slenderness
        14. Calculate End Effect factor for structural solidity of 1.0
        15. Calculate Force Coefficient without End Effect
        16. Calculate Force Coefficient
        17. Calculate Total Wind Force

        */


        foreach ($this->tubeData as $key => $tube) {

            // WindLoadParameters
            $paramsArray = [];

            // Reference Area
            $refArea = ($tube["heights"]["eth"] - $tube["heights"]["kinkh"]) * $tube["od"] / 1000000; // m2
            $paramsArray["referenceArea"] = $refArea;

            // Reference Height
            $Ze = $tube["heights"]["eth"] / 1000; // Extended top height in meters
            $paramsArray["Ze"] = $Ze;

            // Terrain Factor kr
            $Z0 = $this->terrainCategory[$this->activeTerrainCategory]["z0"]; // Roughness length in meters 
            $kr = 0.19 * pow($Z0/0.05, 0.07);
            $paramsArray["kr"] = $kr;
            
            // Roughness factor cr(ze) at the reference height
            $maxHeight = max($Ze ,$this->terrainCategory[$this->activeTerrainCategory]["zmin"]);
            $Cr = $kr * log($maxHeight / $Z0); // Roughness factor at the reference height

            $paramsArray["Cr"] = $Cr;
            $paramsArray["maxHeight"] = $maxHeight;

            // Calculate the mean wind speed at the height of the tube
            $Vm = $Cr * $this->windspeed / 3.6; // Convert to m/s  
            $paramsArray["Vm"] = $Vm;

            // Turbulence Intensity
            $TI = 1.0 / ( 1.0 * log($maxHeight / $Z0) );
            $paramsArray["TurbulenceIntensity"] = $TI; // Turbulence Intensity

            // Basic Velocity Pressure
            // Basic Velocity Pressure Formula: q = 0.5 * ρ * V^2

            $q = 0.5 * $this->airdensity * pow($this->windspeed / 3.6, 2); // Basic velocity pressure in N/m2 
            $paramsArray["BasicVelocityPressure"] = $q; // Basic velocity pressure in N/m2

            // Peak Velocity Pressure
            // Peak Velocity Pressure Formula: qp =[ 1+ 7* TI ] * 0.5 *  ρ *  Vm^2
            $qp = (1 + 7 * $TI) * 0.5 * $this->airdensity * pow($Vm, 2); // Peak velocity pressure in N/m2
            $paramsArray["PeakVelocityPressure"] = $qp; // Peak velocity pressure in N/m2

            // Wind velocity corresponding to peak velocity pressure
            // Wind Velocity Formula: Vp = sqrt(2 * qp / ρ)
            $Vp = sqrt(2 * $qp / $this->airdensity); // Wind velocity in m/s corresponding to peak velocity pressure
            $paramsArray["WindVelocityForPeakVelocityPressure"] = $Vp; // Wind velocity in m/s corresponding to peak velocity pressure

            // Reynolds Number
            // Reynolds Number Formula: Re = ρ * Vp * D / μ
            // where:
            // Re = Reynolds number (dimensionless)
            // ρ = air density (kg/m3)
            // Vp = wind velocity (m/s) corresponding to peak velocity pressure
            // D = characteristic length (m) (outer diameter of the tube)
            // μ = dynamic viscosity of air (kg/(m·s)) (assumed to be 1.81e-5 kg/(m·s) at 20°C)
            $mu = 15e-6; // Dynamic viscosity of air in kg/(m·s) at 20°C
            $Re = ( $Vp * $tube["od"] / 1000) / $mu; // Reynolds number (dimensionless)
            $paramsArray["ReynoldsNumber"] = $Re; // Reynolds number (dimensionless)

            // Structural Factor
            // Structural Factor is taken as 1.0 for this calculation
            $structuralFactor = 1.0; // Structural Factor (dimensionless)

            // Surface Roughness
            // Surface Roughness is taken as 0.1 for Aluminum coated tubes
            $surfaceRoughness = 0.2; 
            $paramsArray["SurfaceRoughness"] = $surfaceRoughness; // Surface Roughness in mm

            // Effective Slenderness

            $l_b = $tube["length"] / $tube["od"]; // Convert length to meters
            $paramsArray["l_b"] = $l_b; // Slenderness ratio (dimensionless)

            if ($tube["length"]/1000 <= 15) {

                $effective_slenderness  = min($l_b, 70); // Limit to a maximum of 70

            } else {
                $effective_slenderness  = min(0.7 * $l_b, 70); // Limit to a maximum of 70
            }

            $paramsArray["EffectiveSlenderness"] = $effective_slenderness; // Effective Slenderness (dimensionless)

            // End Effect Factor
            if ($effective_slenderness <= 10 ) {
                // $end_effect_factor = 0.01 * $effective_slenderness + 0.59; // For slenderness less than or equal to 10
                $end_effect_factor = 0.6023079 * pow($effective_slenderness,0.0657553); // For slenderness less than or equal to 10

            } else {
                $end_effect_factor = 0.698573 + 0.001977401 * $effective_slenderness + 0.00008741341 * pow($effective_slenderness, 2) - 0.00000103591 * pow($effective_slenderness, 3); // For slenderness greater than 10
            } 

            $paramsArray["EndEffectFactor"] = $end_effect_factor; // End Effect Factor (dimensionless)

            // Force Coefficient without End Effect
            $k_b = $surfaceRoughness / $tube["od"]; // Equivalent Roughness
            $paramsArray["k_b"] = $k_b; // Equivalent Roughness (dimensionless)

            $paramsArray["forceCoefficientWoEndEffect"] = $this->calculateForceCoefficientWOEndEffect($Re, $k_b);

            // Force Coefficient
            // EndEffect Facor * Force Coefficient without End Effect
            // Force Coefficient Formula: Cf = Cfw * EndEffectFactor
            // where:
            // Cf = Force Coefficient (dimensionless)
            // Cfw = Force Coefficient without End Effect (dimensionless)
            // EndEffectFactor = End Effect Factor (dimensionless)
            $forceCoefficient = $paramsArray["forceCoefficientWoEndEffect"] * $end_effect_factor; // Force Coefficient (dimensionless)
            $paramsArray["forceCoefficient"] = $forceCoefficient; // Force Coefficient (dimensionless)

            $this->tubeData[$key]["windLoadParameters"] = $paramsArray;

            // Total Wind Force
            // Total Wind Force Formula: Fw = Structural Factor * Force Coefficient * Peak Velocity Pressure * Reference Area
            $this->tubeData[$key]["windForce"] = $structuralFactor * $forceCoefficient * $qp * $refArea;

        }

        return true;
    }




    function calculateForceCoefficientWOEndEffect($Re,$k_b) {

        $coefficent = 1.2 + (0.18 * log10(10 * $k_b)) / (1 + 0.4 * log10($Re/1e6));

        if ($Re < 1.8e5) {

            // For Reynolds number less than 1.8e5, use a different formula
            return 1.2;

        } elseif ($Re >= 1.85e5 && $Re < 4e5) {

            $tempcoefficient = 0.11 / pow($Re / 1e6,1.4);

            if ( $coefficent > $tempcoefficient) {
                return $coefficent;
            } else {
                return $tempcoefficient;
            }
        }

        if ( $coefficent <= 0.4) {
            return 0.4;
        }

        return $coefficent;
    }












}
