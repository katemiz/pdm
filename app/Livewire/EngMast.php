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
    public $materialDensity = 2.704; // g/cm3
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
    public $airdensity = 1.25; // kg/m3 see NASA https://www.earthdata.nasa.gov/topics/atmosphere/air-mass-density
    public $hellman_coefficient = 0.25;       // Hellmann exponent; taken as 0.25 for all tubes

    public $windLoadOnPayload;
    public $payloadMass = 50;

    public $xOffset = 100;
    public $zOffset = 500;
    public $startTubeNo = 1;
    public $endTubeNo = 16;

    public $noOfMTTubes = 16; // quantity

    public $showModal = false;
    public $showHelpModal = false;


    public $data;
    public $error;
    public $modalType; 


    public $realTubeData = [
        [
            "no" => 1,
            "area" => 531.42,
            "inertia" => 144359.94,
        ],

        [
            "no" => 2,
            "area" => 657.93,
            "inertia" => 351727.54,
        ],
        [
            "no" => 3,
            "area" => 852.28,
            "inertia" => 733496.51,
        ],
        [
            "no" => 4,
            "area" => 1057.42,
            "inertia" => 1372498.49,
        ],
        [
            "no" => 5,
            "area" => 1290.94,
            "inertia" => 2372673.47,
        ],
        [
            "no" => 6,
            "area" => 1553.09,
            "inertia" => 3861481.58,
        ],

        [
            "no" => 7,
            "area" => 1844.42,
            "inertia" => 5992457.14,
        ],
        [
            "no" => 8,
            "area" => 2165.56,
            "inertia" => 8947902.11,
        ],
        [
            "no" => 9,
            "area" => 2517.21,
            "inertia" => 12941721.43,
        ],
        [
            "no" => 10,
            "area" => 2900.08,
            "inertia" => 18222403.31,
        ],
        [
            "no" => 11,
            "area" => 3538.49,
            "inertia" => 26761768.83,
        ],
        [
            "no" => 12,
            "area" => 3986.05,
            "inertia" => 35883568.00,
        ],
        [
            "no" => 13,
            "area" => 4467.07,
            "inertia" => 47211434.31,
        ],
        [
            "no" => 14,
            "area" => 4982.29,
            "inertia" => 61316545.00,
        ],
        [
            "no" => 15,
            "area" => 5532.44,
            "inertia" => 78621879.48,
        ],
        [
            "no" => 16,
            "area" => 6118.30,
            "inertia" => 99656139.01,
        ],

    ];   




    public $terrainCategory =[

       "0" => [ 
            "no" => "0",
            "description" => "Sea or coastal area exposed to the open sea",
            "z0" => 0.003, // Roughness length in meters
            "zmin" => 1, // Minimum height in meters
        ],
       "1" => [ 
            "no" => "I",
            "description" => "Lakes or flat and horizontal area with negligible vegetation and without obstacles",
            "z0" => 0.01, // Roughness length in meters
            "zmin" => 1, // Minimum height in meters
        ],
       "2" => [
            "no" => "II",
            "description" => "Area with low vegetation such as grass and isolated obstacles (trees, buildings) with separations of at least 20 obstacle heights",
            "z0" => 0.05, // Roughness length in meters
            "zmin" => 2, // Minimum height in meters
        ],
       "3" => [
            "no" => "III",
            "description" => "Area with regular cover of vegetation or buildings or with isolated obstacles with separations of maximum 20 obstacle heights (such as as villages, suburban terrain, permanent forest)",
            "z0" => 0.3, // Roughness length in meters
            "zmin" => 5, // Minimum height in meters
       ],

        "4" => [
            "no" => "IV",
            "description" => "Area in which at least 15 % of the surface is covered with buildings and their average height exceeds 15 m",
            "z0" => 1, // Roughness length in meters
            "zmin" => 10, // Minimum height in meters
       ],
    ];

    public $activeTerrainCategory = 2; // Default to category II 


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
                $this->calculateTubeWindLoads();
                break;

            case 'wloads':
                $this->WindLoadOnPayload();
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
