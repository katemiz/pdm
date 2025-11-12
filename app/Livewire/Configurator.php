<?php

namespace App\Livewire;

use Livewire\Component;

class Configurator extends Component
{
    public $action = 'deflection';

    public $graphType = 'Nested';

    public $showHelpModal = false;

    public $modalType;

    public $mastType = 'MTPX'; // 'MTPX' or 'MTWR'

    public $overlapDimension = 500;  // m

    public $headDimension = 60; // m

    public $n; // Number of Sections

    public $n_min = 2;

    public $n_max = 15;

    public $x; // Tube length variable

    public $extendedHeight;

    public $nestedHeight;

    public $tube_length_min = 400;

    public $tube_length_max = 3400;

    public $tube_length_increment = 10;

    public $maxMastTubeDia;

    public $topAdapterThk = 12;

    public $baseAdapterThk = 20;

    public $adapters = [];

    public $points = [];

    public $startTubeNo = 1;

    public $endTubeNo;

    public $showModal = false;

    public $showOtherParams = false;

    public $error;

    public $noOfMTTubes = 16; // quantity

    public $noOfActiveTubes = 16; // quantity

    public $allData = [];

    public $allTubes = [];

    public $mastTubes = [];

    public $cd = 1.5;

    public $sailarea = 1.50;

    public $windspeed = 120;

    public $airdensity = 1.25; // kg/m3 see NASA https://www.earthdata.nasa.gov/topics/atmosphere/air-mass-density

    public $hellman_coefficient = 0.25;       // Hellmann exponent; taken as 0.25 for all tubes

    public $realTubeData = [
        [
            'no' => 1,
            'area' => 531.42,
            'inertia' => 144359.94,
        ],

        [
            'no' => 2,
            'area' => 657.93,
            'inertia' => 351727.54,
        ],
        [
            'no' => 3,
            'area' => 852.28,
            'inertia' => 733496.51,
        ],
        [
            'no' => 4,
            'area' => 1057.42,
            'inertia' => 1372498.49,
        ],
        [
            'no' => 5,
            'area' => 1290.94,
            'inertia' => 2372673.47,
        ],
        [
            'no' => 6,
            'area' => 1553.09,
            'inertia' => 3861481.58,
        ],

        [
            'no' => 7,
            'area' => 1844.42,
            'inertia' => 5992457.14,
        ],
        [
            'no' => 8,
            'area' => 2165.56,
            'inertia' => 8947902.11,
        ],
        [
            'no' => 9,
            'area' => 2517.21,
            'inertia' => 12941721.43,
        ],
        [
            'no' => 10,
            'area' => 2900.08,
            'inertia' => 18222403.31,
        ],
        [
            'no' => 11,
            'area' => 3538.49,
            'inertia' => 26761768.83,
        ],
        [
            'no' => 12,
            'area' => 3986.05,
            'inertia' => 35883568.00,
        ],
        [
            'no' => 13,
            'area' => 4467.07,
            'inertia' => 47211434.31,
        ],
        [
            'no' => 14,
            'area' => 4982.29,
            'inertia' => 61316545.00,
        ],
        [
            'no' => 15,
            'area' => 5532.44,
            'inertia' => 78621879.48,
        ],
        [
            'no' => 16,
            'area' => 6118.30,
            'inertia' => 99656139.01,
        ],

    ];

    public $terrainCategory = [

        '0' => [
            'no' => '0',
            'description' => 'Sea or coastal area exposed to the open sea',
            'z0' => 0.003, // Roughness length in meters
            'zmin' => 1, // Minimum height in meters
        ],
        '1' => [
            'no' => 'I',
            'description' => 'Lakes or flat and horizontal area with negligible vegetation and without obstacles',
            'z0' => 0.01, // Roughness length in meters
            'zmin' => 1, // Minimum height in meters
        ],
        '2' => [
            'no' => 'II',
            'description' => 'Area with low vegetation such as grass and isolated obstacles (trees, buildings) with separations of at least 20 obstacle heights',
            'z0' => 0.05, // Roughness length in meters
            'zmin' => 2, // Minimum height in meters
        ],
        '3' => [
            'no' => 'III',
            'description' => 'Area with regular cover of vegetation or buildings or with isolated obstacles with separations of maximum 20 obstacle heights (such as as villages, suburban terrain, permanent forest)',
            'z0' => 0.3, // Roughness length in meters
            'zmin' => 5, // Minimum height in meters
        ],

        '4' => [
            'no' => 'IV',
            'description' => 'Area in which at least 15 % of the surface is covered with buildings and their average height exceeds 15 m',
            'z0' => 1, // Roughness length in meters
            'zmin' => 10, // Minimum height in meters
        ],
    ];

    public $activeTerrainCategory = 2; // Default to category II

    public $factorOfSafety = 2.0; // Factor of Safety

    public $tubeBucklingLength; // mm

    public $E = 70000; // MPa for Aluminum

    public $yieldStrength = 170; // MPa

    public $ultimateStrength = 210; // MPa

    public $materialDensity = 2.704; // g/cm3

    public $pressure = 2; // Bars

    public $windLoadOnPayload;

    public $lengthMTTubes = 2000; // mm

    public $overlapMTTubes = 500; // mm

    public $headMTTubes = 70; // mm

    public $xOffset = 100;

    public $zOffset = 500;

    public $smallestTubeId = 44; // mm

    public $smallestTubeThickness = 2; // mm

    public $gapBetweenTubes = 7; // mm

    public $thicknessIncrement = 0.2; // mm

    public $mastWeight = 0; // kg
    public $mastWeightBreakdown = []; // kg

    public $maxPayloadCapacity = 1000; // kg

    public function mount()
    {
        if (request()->has('qr')) {

            $qr = explode('-', request()->get('qr'));

            $this->maxPayloadCapacity = floatval($qr[0]);
            $this->startTubeNo = intval($qr[1]);
            $this->endTubeNo = intval($qr[2]);
            $this->lengthMTTubes = floatval($qr[3]);
            $this->overlapMTTubes = floatval($qr[4]);
            $this->headMTTubes = floatval($qr[5]);
            $this->windspeed = floatval($qr[6]);
            $this->sailarea = floatval($qr[7]);

        } else {

            $this->endTubeNo = count($this->realTubeData);
        }
    }

    public function render()
    {
        $this->error = null;

        if ($this->endTubeNo <= $this->startTubeNo) {

            $this->noOfActiveTubes = null;
            $this->error = 'End Tube Diameter must be greater than Start Tube Diameter';
        } else {

            $this->noOfActiveTubes = $this->endTubeNo - $this->startTubeNo + 1;
        }

        $this->MasttechProfiles();

        $this->WindLoadOnPayload();

        $this->getMastHeights();
        $this->calculateTubeWindLoads();
        $this->prepareAllData();

        $this->dispatch('triggerCanvasDraw', data : $this->allData);

        return view('engineering.configurator');
    }

    public function toggleHelpModal($modalType)
    {
        $this->modalType = $modalType;
        $this->showHelpModal = ! $this->showHelpModal;
    }

    public function getMastHeights()
    {

        if ($this->noOfActiveTubes == null || $this->lengthMTTubes == null || $this->overlapMTTubes == null || $this->headMTTubes == null) {

            $this->extendedHeight = 0;
            $this->nestedHeight = 0;

            return true;
        }

        $this->extendedHeight = $this->noOfActiveTubes * $this->lengthMTTubes - ($this->noOfActiveTubes - 1) * $this->overlapMTTubes + $this->topAdapterThk + $this->baseAdapterThk;
        $this->nestedHeight = $this->lengthMTTubes + ($this->noOfActiveTubes - 1) * $this->headMTTubes + $this->topAdapterThk + $this->baseAdapterThk;

        return true;
    }

    public function toggleGraphType($position)
    {
        $this->graphType = $position;
    }

    public function MasttechProfiles()
    {

        $id = $this->smallestTubeId;
        $t = $this->smallestTubeThickness;
        $od = $this->smallestTubeId + 2 * $this->smallestTubeThickness;

        for ($i = 0; $i < $this->noOfMTTubes; $i++) {

            $this->allTubes[$i] = [
                'no' => $i + 1,
                'od' => round($od, 2),
                'id' => round($id, 2),
                'thk' => round($t, 2),
                'pressureLoad' => $this->CalculateLiftCapacity($od),
                'length' => $this->lengthMTTubes,
            ];

            $this->CalculateArea($od, $id, $i);
            $this->CalculateMass($od, $id, $i);
            $this->CalculateInertia($od, $id, $i);
            $this->CalculateMomentCapability($od, $id, $i);
            $this->ProfileCriticalLoad($od, $id, $i);
            $this->EI($od, $id, $i);

            $id = $od + 2 * $this->gapBetweenTubes;
            $t += $this->thicknessIncrement;
            $od = $id + 2 * $t;
        }

        $this->getElementCoordinates();
    }

    public function getElementCoordinates()
    {

        $this->maxMastTubeDia = 0;

        $this->mastTubes = array_filter($this->allTubes, function ($element) {
            return $element['no'] >= $this->startTubeNo && $element['no'] <= $this->endTubeNo;
        });

        $this->mastTubes = array_reverse($this->mastTubes);

        foreach (array_reverse($this->mastTubes) as $i => $tube) {

            if ($tube['no'] >= $this->startTubeNo && $tube['no'] <= $this->endTubeNo) {

                $this->mastTubes[$i]['bottomCenterPointNested'] = $this->baseAdapterThk + $i * $this->headMTTubes;
                $this->mastTubes[$i]['bottomCenterPointExtended'] = $this->baseAdapterThk + $i * $this->lengthMTTubes - $i * $this->overlapMTTubes;
            }

            $this->maxMastTubeDia = max($this->maxMastTubeDia, $tube['od']);

        }

        $this->allData['baseAdapter']['bottomCenterPointNested'] = 0;
        $this->allData['baseAdapter']['bottomCenterPointExtended'] = 0;

        $this->allData['topAdapter']['bottomCenterPointNested'] = $this->nestedHeight - $this->topAdapterThk;
        $this->allData['topAdapter']['bottomCenterPointExtended'] = $this->extendedHeight - $this->topAdapterThk;
    }

    public function prepareAllData()
    {

        $this->allData['mastType'] = $this->mastType; 
        $this->allData['xOffset'] = floatval($this->xOffset);
        $this->allData['zOffset'] = floatval($this->zOffset);
        $this->allData['extendedHeight'] = $this->extendedHeight;
        $this->allData['nestedHeight'] = $this->nestedHeight;
        $this->allData['baseAdapterThk'] = $this->baseAdapterThk;
        $this->allData['topAdapterThk'] = $this->topAdapterThk;
        $this->allData['maxMastTubeDia'] = $this->maxMastTubeDia;
        $this->allData['tubeLength'] = $this->lengthMTTubes;
        $this->allData['noOfTubes'] = $this->noOfMTTubes;
        $this->allData['overlapLength'] = $this->overlapMTTubes;
        $this->allData['headLength'] = $this->headMTTubes;
        $this->allData['startTubeNo'] = intval($this->startTubeNo);
        $this->allData['endTubeNo'] = intval($this->endTubeNo);
        $this->allData['windLoadOnPayload'] = $this->windLoadOnPayload;
        $this->allData['allTubes'] = $this->allTubes;
        $this->allData['mastTubes'] = $this->mastTubes;

        $this->calculateMastWeight();
        $this->allData['mastWeight'] = $this->mastWeight;
        $this->allData['mastWeightBreakdown'] = $this->mastWeightBreakdown;

        $this->allData['windspeed'] = $this->windspeed;
        $this->allData['sailarea'] = $this->sailarea;

        $minCriticalLoad = collect($this->mastTubes)->min('criticalLoad') / 98.1; // Critical load is divided : kg

        $this->maxPayloadCapacity = round(min($minCriticalLoad, 500), 0); // Critical load is divided : kg

        $this->allData['maxPayloadCapacity'] = $this->maxPayloadCapacity; // kg

        $q = [
            $this->maxPayloadCapacity,
            $this->startTubeNo,
            $this->endTubeNo,
            $this->lengthMTTubes,
            $this->overlapMTTubes,
            $this->headMTTubes,
            $this->windspeed,
            $this->sailarea,
        ];

        $this->allData['qr'] = url('/engineering/configurator?qr=').implode('-', $q);
    }

    public function CalculateLiftCapacity($od)
    {
        // Circular Area
        $area = pi() / 4 * pow($od, 2);
        $pi_mpa = $this->pressure * 0.1;

        return $pi_mpa * $area;
    }

    public function CalculateArea($od, $id, $i)
    {
        $this->allTubes[$i]['areaBasic'] = (pow($od, 2) - pow($id, 2)) * pi() / 4; // mm2
        $this->allTubes[$i]['area'] = $this->realTubeData[$i]['area'];

        return true;
    }

    public function CalculateMass($od, $id, $i)
    {

        $this->allTubes[$i]['mass'] = $this->materialDensity * $this->realTubeData[$i]['area'] / 1000; // kg/m

        return true;
    }

    public function CalculateInertia($od, $id, $i)
    {

        // Moment of Inertia for a hollow tube
        // I = π/64*(od^4-id^4)
        // od = outer diameter
        // id = inner diameter

        $this->allTubes[$i]['inertiaBasic'] = pi() / 64 * (pow($od, 4) - pow($id, 4)); // mm4
        $this->allTubes[$i]['inertia'] = $this->realTubeData[$i]['inertia'];

        return true;
    }

    public function CalculateMomentCapability($od, $id, $i)
    {

        // Moment Capability
        // M = σ * I / y

        $this->allTubes[$i]['momentBasic'] = $this->yieldStrength * pi() * (pow($od, 4) - pow($id, 4)) / (32 * $od * 1000); // Nm
        $this->allTubes[$i]['moment'] = $this->yieldStrength * $this->realTubeData[$i]['inertia'] / (0.5 * $od * 1000); // Nm

        return true;
    }

    public function ProfileCriticalLoad($od, $id, $i)
    {

        // Euler Column Critical Load Formula is used

        // Pcr = π^2EI/4L^2
        // E = Young's Modulus
        // I = Moment of Inertia
        // L = Length of the column
        // Pcr = Critical Load

        $this->tubeBucklingLength = $this->lengthMTTubes * 1.5; // mm

        $this->allTubes[$i]['criticalLoad'] = pi() * $this->E * $this->realTubeData[$i]['inertia'] / (pow($this->tubeBucklingLength, 2) * $this->factorOfSafety);

        return true;
    }

    public function EI($od, $id, $i)
    {
        // EI = E*I
        // E = Young's Modulus
        // I = Moment of Inertia

        $this->allTubes[$i]['EI'] = $this->E * $this->realTubeData[$i]['inertia']; // Nmm2
    }

    public function WindLoadOnPayload()
    {
        if ($this->sailarea == null || $this->windspeed == null || $this->cd == null) {

            $this->windLoadOnPayload = 0;

            return true;
        }

        $this->windLoadOnPayload = 0.5 * $this->airdensity * $this->cd * $this->sailarea * pow($this->windspeed / 3.6, 2);
    }

    public function calculateMastWeight()
    {

        $this->mastWeight = 0;
        $this->mastWeightBreakdown = [];

        $tubesWeight = 0;

        foreach ($this->mastTubes as $key => $value) {
            $tubesWeight += $value['mass'] * $this->lengthMTTubes / 1000; // kg;
        }

        $this->mastWeightBreakdown['tubes'] = $tubesWeight; // kg

        // PNEUMATIC MAST EQUATIONS

        if ($this->mastType == 'MTPX') {

            // Base Fitting Interface
            $this->mastWeightBreakdown['baseFlange'] = 0.755 * ($this->endTubeNo - 4) + 3.3; // kg

            // Fixed Tube Head Flanges
            $fixedFlangeWeight = 0;

            foreach ($this->mastTubes as $key => $tube) {
                $fixedFlangeWeight += 0.047 * ($tube['no'] - 10) + 0.8; // kg
            }

            $this->mastWeightBreakdown['fixedTubeHeadFlanges'] = $fixedFlangeWeight;

            // Ring Holder Flanges
            $ringHolderFlangeWeight = 0;

            foreach ($this->mastTubes as $key => $tube) {

                if ($tube['no'] != $this->endTubeNo) {
                    $ringHolderFlangeWeight += 0.133 * ($tube['no'] - 8) + 2; // kg
                }
            }

            $this->mastWeightBreakdown['ringHolderFlanges'] = $ringHolderFlangeWeight;

            // Rings
            $ringWeight = 0;
            foreach ($this->mastTubes as $key => $tube) {

                if ($tube['no'] != $this->endTubeNo) {
                    $ringWeight += 0.157 * ($tube['no'] - 11) + 1.6; // kg
                }
            }

            $this->mastWeightBreakdown['rings'] = $ringWeight;

            // Ice Breakers
            $iceBreakerWeight = 0;
            foreach ($this->mastTubes as $key => $tube) {

                if ($tube['no'] != $this->endTubeNo) {
                    $iceBreakerWeight += 0.014 * ($tube['no'] - 11) + 0.3; // kg
                }
            }
            $this->mastWeightBreakdown['iceBreakers'] = $iceBreakerWeight;

            // Payload Adapter
            $this->mastWeightBreakdown['payloadAdapter'] = 0.3 * ($this->startTubeNo - 9) + 2.9; // kg
        }

        $this->mastWeight = array_sum($this->mastWeightBreakdown) * 1.05; // kg with 5% extra for bolts and nuts

        return true;
    }

    public function calculateTubeWindLoads()
    {

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

        // $this->getElementCoordinates();

        return true;

        foreach ($this->allTubes as $key => $tube) {

            // WindLoadParameters
            $paramsArray = [];

            // Reference Area
            $refArea = ($tube['heights']['eth'] - $tube['heights']['kinkh']) * $tube['od'] / 1000000; // m2
            $paramsArray['referenceArea'] = $refArea;

            // Reference Height
            $Ze = $tube['heights']['eth'] / 1000; // Extended top height in meters
            $paramsArray['Ze'] = $Ze;

            // Terrain Factor kr
            $Z0 = $this->terrainCategory[$this->activeTerrainCategory]['z0']; // Roughness length in meters
            $kr = 0.19 * pow($Z0 / 0.05, 0.07);
            $paramsArray['kr'] = $kr;

            // Roughness factor cr(ze) at the reference height
            $maxHeight = max($Ze, $this->terrainCategory[$this->activeTerrainCategory]['zmin']);
            $Cr = $kr * log($maxHeight / $Z0); // Roughness factor at the reference height

            $paramsArray['Cr'] = $Cr;
            $paramsArray['maxHeight'] = $maxHeight;

            // Calculate the mean wind speed at the height of the tube
            $Vm = $Cr * $this->windspeed / 3.6; // Convert to m/s
            $paramsArray['Vm'] = $Vm;

            // Turbulence Intensity
            $TI = 1.0 / (1.0 * log($maxHeight / $Z0));
            $paramsArray['TurbulenceIntensity'] = $TI; // Turbulence Intensity

            // Basic Velocity Pressure
            // Basic Velocity Pressure Formula: q = 0.5 * ρ * V^2

            $q = 0.5 * $this->airdensity * pow($this->windspeed / 3.6, 2); // Basic velocity pressure in N/m2
            $paramsArray['BasicVelocityPressure'] = $q; // Basic velocity pressure in N/m2

            // Peak Velocity Pressure
            // Peak Velocity Pressure Formula: qp =[ 1+ 7* TI ] * 0.5 *  ρ *  Vm^2
            $qp = (1 + 7 * $TI) * 0.5 * $this->airdensity * pow($Vm, 2); // Peak velocity pressure in N/m2
            $paramsArray['PeakVelocityPressure'] = $qp; // Peak velocity pressure in N/m2

            // Wind velocity corresponding to peak velocity pressure
            // Wind Velocity Formula: Vp = sqrt(2 * qp / ρ)
            $Vp = sqrt(2 * $qp / $this->airdensity); // Wind velocity in m/s corresponding to peak velocity pressure
            $paramsArray['WindVelocityForPeakVelocityPressure'] = $Vp; // Wind velocity in m/s corresponding to peak velocity pressure

            // Reynolds Number
            // Reynolds Number Formula: Re = ρ * Vp * D / μ
            // where:
            // Re = Reynolds number (dimensionless)
            // ρ = air density (kg/m3)
            // Vp = wind velocity (m/s) corresponding to peak velocity pressure
            // D = characteristic length (m) (outer diameter of the tube)
            // μ = dynamic viscosity of air (kg/(m·s)) (assumed to be 1.81e-5 kg/(m·s) at 20°C)
            $mu = 15e-6; // Dynamic viscosity of air in kg/(m·s) at 20°C
            $Re = ($Vp * $tube['od'] / 1000) / $mu; // Reynolds number (dimensionless)
            $paramsArray['ReynoldsNumber'] = $Re; // Reynolds number (dimensionless)

            // Structural Factor
            // Structural Factor is taken as 1.0 for this calculation
            $structuralFactor = 1.0; // Structural Factor (dimensionless)

            // Surface Roughness
            // Surface Roughness is taken as 0.1 for Aluminum coated tubes
            $surfaceRoughness = 0.2;
            $paramsArray['SurfaceRoughness'] = $surfaceRoughness; // Surface Roughness in mm

            // Effective Slenderness

            $l_b = $tube['length'] / $tube['od']; // Convert length to meters
            $paramsArray['l_b'] = $l_b; // Slenderness ratio (dimensionless)

            if ($tube['length'] / 1000 <= 15) {

                $effective_slenderness = min($l_b, 70); // Limit to a maximum of 70

            } else {
                $effective_slenderness = min(0.7 * $l_b, 70); // Limit to a maximum of 70
            }

            $paramsArray['EffectiveSlenderness'] = $effective_slenderness; // Effective Slenderness (dimensionless)

            // End Effect Factor
            if ($effective_slenderness <= 10) {
                // $end_effect_factor = 0.01 * $effective_slenderness + 0.59; // For slenderness less than or equal to 10
                $end_effect_factor = 0.6023079 * pow($effective_slenderness, 0.0657553); // For slenderness less than or equal to 10

            } else {
                $end_effect_factor = 0.698573 + 0.001977401 * $effective_slenderness + 0.00008741341 * pow($effective_slenderness, 2) - 0.00000103591 * pow($effective_slenderness, 3); // For slenderness greater than 10
            }

            $paramsArray['EndEffectFactor'] = $end_effect_factor; // End Effect Factor (dimensionless)

            // Force Coefficient without End Effect
            $k_b = $surfaceRoughness / $tube['od']; // Equivalent Roughness
            $paramsArray['k_b'] = $k_b; // Equivalent Roughness (dimensionless)

            $paramsArray['forceCoefficientWoEndEffect'] = $this->calculateForceCoefficientWOEndEffect($Re, $k_b);

            // Force Coefficient
            // EndEffect Facor * Force Coefficient without End Effect
            // Force Coefficient Formula: Cf = Cfw * EndEffectFactor
            // where:
            // Cf = Force Coefficient (dimensionless)
            // Cfw = Force Coefficient without End Effect (dimensionless)
            // EndEffectFactor = End Effect Factor (dimensionless)
            $forceCoefficient = $paramsArray['forceCoefficientWoEndEffect'] * $end_effect_factor; // Force Coefficient (dimensionless)
            $paramsArray['forceCoefficient'] = $forceCoefficient; // Force Coefficient (dimensionless)

            $this->allTubes[$key]['windLoadParameters'] = $paramsArray;

            // Total Wind Force
            // Total Wind Force Formula: Fw = Structural Factor * Force Coefficient * Peak Velocity Pressure * Reference Area
            $this->allTubes[$key]['windForce'] = $structuralFactor * $forceCoefficient * $qp * $refArea;

        }

        return true;
    }

}
