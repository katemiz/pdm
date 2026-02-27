<?php

namespace App\Livewire;

use Livewire\Component;

class Configurator extends Component
{
    public $action = 'deflection';

    public $graphType = 'Nested';

    public $showModalTerrain = false;
    public $showModalOffsets = false;

    public $modalType;

    public $mastType = 'MTNX'; // 'MTPR' , 'MTWR' or 'MTNX'

    //public $overlapDimension = 500;  // m

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

    public $showOtherParams = false;

    public $error;

    public $noOfMTTubes = 15; // quantity

    public $noOfActiveTubes = 15; // quantity

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

    public $headMTTubes; // mm

    public $xOffset = 100;

    public $zOffset = 500;

    public $smallestTubeId = 44; // mm

    public $smallestTubeThickness = 2; // mm

    public $gapBetweenTubes = 7; // mm

    public $thicknessIncrement = 0.2; // mm

    public $mastWeight = 0; // kg
    public $mastLiftedWeight = 0; // kg
    public $mastWeightBreakdown = []; // kg


    public $maxPayloadCapacity = 1000; // kg


    public $capacity =[

        'MTPR' => [
            'maxPayload' => 500,
            'minPayload' => 16,
            'maxExtendedHeight' => 25,
            'minExtendedHeight' => 3.0,
            'color' => 'blue',
        ],
        'MTWR' => [
            'maxPayload' => 350,
            'minPayload' => 16,
            'maxExtendedHeight' => 25,
            'minExtendedHeight' => 3.0,
            'color' => 'red',
        ],

        'MTNX' => [
            'maxPayload' => 550,
            'minPayload' => 50,
            'maxExtendedHeight' => 25,
            'minExtendedHeight' => 4.0,
            'color' => 'green',
        ]

    ];

    public $capacityChartDataset = [
        'datasets' => [] 
    ];



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
            $this->mastType = floatval($qr[8]);

        } else {

            $this->endTubeNo = count($this->realTubeData);
        }

       $this->runCapacityChartData();
    }


    public function render()
    {

        $this->initializeHeadDimensison(); 

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
        $this->CalculateDeflection();



        $this->prepareAllData();

        $this->dispatch('triggerCanvasDraw', data : $this->allData);

        return view('engineering.configurator');
    }


    public function toggleModal($modalType)
    {
        $this->modalType = $modalType;


        switch ($modalType) {
            case 'modalTerrain':
                $this->showModalTerrain = ! $this->showModalTerrain;
                break;
            case 'modalOffsets':
                $this->showModalOffsets = ! $this->showModalOffsets;
                break;
        }
    }




    public function initializeHeadDimensison()
    {
        if ($this->mastType == 'MTPR' ) {
            $this->headMTTubes = 55;
        }

        if ($this->mastType == 'MTWR' ) {
            $this->headMTTubes = 42;
        }


        if ($this->mastType == 'MTNX' ) {
            $this->headMTTubes = 55;
            $this->topAdapterThk = 15;
            $this->baseAdapterThk = 50;
        }
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

        $this->maxPayloadCapacity = $this->calculateMaxPayload();

        $this->allData['maxPayloadCapacity'] = $this->maxPayloadCapacity; // kg

        $this->allData['mastLiftedWeight'] = $this->mastLiftedWeight;

        $q = [
            $this->maxPayloadCapacity,
            $this->startTubeNo,
            $this->endTubeNo,
            $this->lengthMTTubes,
            $this->overlapMTTubes,
            $this->headMTTubes,
            $this->windspeed,
            $this->sailarea,
            $this->mastType 
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

        switch ($this->mastType) {
            case 'MTPR':
                $this->calculateMTPRMass();
                break;
            case 'MTWR':
                $this->calculateMTWRMass();
                break;
            case 'MTNX':
                $this->calculateMTNXMass();
                break;
        }

        return true;
    }



    public function calculateMaxPayload()
    {
        $minCriticalLoad = collect($this->mastTubes)->min('criticalLoad');  // N

        // Divide by 10 and convert to kg
        $minCriticalLoad = round($minCriticalLoad / 98.1, 0); //

        $minPressureLoad = collect($this->mastTubes)->min('pressureLoad'); // N 

        $this->maxPayloadCapacity = round(min($minCriticalLoad, 500), 0); // Critical load is divided : kg

        if ($this->mastType == 'MTPR' ) {
            $minCapability = min($minCriticalLoad, $minPressureLoad); // N
            return round(min($minCapability, $this->capacity[$this->mastType]['maxPayload']), 0);
        }

        if ($this->mastType == 'MTWR' ) {
            return round(min($minCriticalLoad, $this->capacity[$this->mastType]['maxPayload']), 0);
        }

        if ($this->mastType == 'MTNX' ) {


            $this->calculateMTNXMass();

            return round(min($minCriticalLoad, $this->capacity[$this->mastType]['maxPayload']), 0);
        }

    }



    public function runCapacityChartData()
    { 

        $maxHeight = collect($this->capacity)->pluck('maxExtendedHeight')->max();
        $xAxisData = range(0, $maxHeight) ;

        foreach ($this->capacity as $mastType => $capacityData) {

            $data =[
                [
                    'x' => 0,
                    'y' => $capacityData['maxPayload']
                ],
                [
                    'x' => $capacityData['minExtendedHeight'],
                    'y' => $capacityData['maxPayload']
                ],
                [
                    'x' => $capacityData['maxExtendedHeight'],
                    'y' => $capacityData['minPayload']      
                ] 
            ] ;

            $this->capacityChartDataset['labels'] = $xAxisData;

            array_push ($this->capacityChartDataset['datasets'] ,[
                'label' => $mastType,
                'data' => $data,
                'backgroundColor' => $capacityData['color'],
                'borderColor' => $capacityData['color'],
            ]);

        } 
    }




    /*
    WIND LOADS ON EACH SECTION
    */


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

        $this->calculateReferenceArea(); 




        foreach ($this->mastTubes as $key => $tube) {

            // WindLoadParameters
            $paramsArray = [];

            // Reference Area
            $paramsArray["referenceArea"] = $tube['referenceArea'];

            // Reference Height
            $Ze = ($tube["bottomCenterPointExtended"] +$tube["length"] ) / 1000; // Extended top height in meters
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

            $this->mastTubes[$key]["windLoadParameters"] = $paramsArray;

            // Total Wind Force
            // Total Wind Force Formula: Fw = Structural Factor * Force Coefficient * Peak Velocity Pressure * Reference Area
            $this->mastTubes[$key]["windForce"] = $structuralFactor * $forceCoefficient * $qp * $tube['referenceArea'];
        }

        return true;
    }



    function calculateReferenceArea(){

        foreach ($this->mastTubes as $i => $tube) {

            if ($i == 0 ){
                $refArea = $tube['od']*$tube['length'];
                $this->mastTubes[$i]['windLoadActingZ'] =$this->baseAdapterThk + $tube['length']/2;


            } else{
                $refArea = $tube['od']* ($tube['length'] - $this->overlapMTTubes);
                $this->mastTubes[$i]['windLoadActingZ'] =$tube['bottomCenterPointExtended'] + ($tube['length'] + $this->overlapMTTubes) / 2;
            } 

            $this->mastTubes[$i]['referenceArea'] = $refArea/1000000;
        }

        //dd($this->mastTubes);
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














    function CalculateDeflection(){

        //dd($this->mastTubes);

        // foreach ($this->mastTubes as $key => $tube) {

        // } 


    } 





    function deflectionForOneLoadOnCantileverBeam ($a, $x,$l,$P) {

        /*
        y = Px^2(3a-x)/[6EI] when 0<x<a
        y = Px^2(3a-x)/[6EI] when a<x<l

        $a : Distance from root to LOAD acting point
        $x : Distance at which deflection is calculated
        $l: Length of Beam
        $P: Load in N   

        $deflection : deflection value WITHOUT 1/EI 
        */

        if ($x > 0 & $x < $a ) {
           $deflection = $P * pow($x,2) * (3 * $a - $x);
        }

        if ($x > $a & $x < $l ) {
           $deflection = $P * pow($a,2) * (3 * $x - $a);
        }

        return $deflection/6; // NOTICE: Without 1/EI
    }





    function deflectionForCoupleMomentAtFreeEndCantileverBeam ($x,$M) {

        /*
        y = Mx^2/[2EI]

        $x : Distance at which deflection is calculated
        $M: Couple Moment at FREE end of cantilever beam   

        $deflection : deflection value WITHOUT 1/EI 
        */

        if ($x > 0 & $x < $a ) {
           $deflection = $M * pow($x,2) / 2;
        }

        return $deflection; // NOTICE: Without 1/EI
    }






    public function calculateMTPRMass()
    {
        $this->mastWeight = 0;
        $this->mastWeightBreakdown = [];
        $this->mastLiftedWeight = 0;

        foreach ($this->mastTubes as $key => $section) {
            $tube_weight = $section['mass'] * $this->lengthMTTubes / 1000; // kg
            $this->mastWeightBreakdown['tubes'][$section['no']] = $tube_weight;
            $this->mastWeight += $tube_weight; // kg;
        }

        // PNEUMATIC MAST EQUATIONS
        // Base Fitting Interface
        $this->mastWeightBreakdown['baseFlange'] = 0.755 * ($this->endTubeNo - 4) + 3.3; // kg

        $this->mastWeight += $this->mastWeightBreakdown['baseFlange']; // kg;

        // Fixed Tube Head Flanges
        foreach ($this->mastTubes as $key => $tube) {
            $fixedFlangeWeight = 0.047 * ($tube['no'] - 10) + 0.8; // kg
            $this->mastWeightBreakdown['fixedTubeHeadFlanges'][$tube['no']] = $fixedFlangeWeight; // kg
            $this->mastWeight += $fixedFlangeWeight; // kg;
        }

        // Ring Holder Flanges
        foreach ($this->mastTubes as $key => $tube) {
            if ($tube['no'] != $this->endTubeNo) {
                $ringHolderFlangeWeight = 0.133 * ($tube['no'] - 8) + 2; // kg
                $this->mastWeightBreakdown['ringHolderFlanges'][$tube['no']] = $ringHolderFlangeWeight; // kg
                $this->mastWeight += $ringHolderFlangeWeight; // kg 
            }
        }

        // Rings
        foreach ($this->mastTubes as $key => $tube) {
            if ($tube['no'] != $this->endTubeNo) {
                $ringWeight = 0.157 * ($tube['no'] - 11) + 1.6; // kg
                $this->mastWeightBreakdown['rings'][$tube['no']] = $ringWeight; // kg
                $this->mastWeight += $ringWeight; // kg
            }
        }


        // Ice Breakers
        foreach ($this->mastTubes as $key => $tube) {
            if ($tube['no'] != $this->endTubeNo) {
                $iceBreakerWeight = 0.014 * ($tube['no'] - 11) + 0.3; // kg
                $this->mastWeightBreakdown['iceBreakers'][$tube['no']] = $iceBreakerWeight; // kg
                $this->mastWeight += $iceBreakerWeight; // kg
            }
        }

        // Payload Adapter
        $this->mastWeightBreakdown['payloadAdapter'] = 0.3 * ($this->startTubeNo - 9) + 2.9; // kg
        $this->mastWeight += $this->mastWeightBreakdown['payloadAdapter']* 1.05; // kg with 5% extra for bolts and nuts

        return true;
    }


    public function calculateMTWRMass()
    {
        $this->mastWeight = 0;
        $this->mastWeightBreakdown = [];
        $this->mastLiftedWeight = 0;

        foreach ($this->mastTubes as $key => $tube) {
            $tube_weight = $tube['mass'] * $this->lengthMTTubes / 1000; // kg
            $this->mastWeightBreakdown['tubes'][$tube['no']] = $tube_weight;
            $this->mastWeight += $tube_weight; // kg;
        }

        // WIRE ROPE MAST EQUATIONS
        // Fixed Tube Head Flanges
        foreach ($this->mastTubes as $key => $tube) {
            $fixedFlangeWeight = 0.0688 * ($tube['no'] - 6) + 0.35; // kg
            $this->mastWeightBreakdown['fixedTubeHeadFlanges'][$tube['no']] = $fixedFlangeWeight; // kg
            $this->mastWeight += $fixedFlangeWeight; // kg;
        }

        // Top Roller Holder Flanges
        foreach ($this->mastTubes as $key => $tube) {

            if ($tube['no'] != $this->endTubeNo) {
                $topRollerHolderFlangeWeight = 0.05556 * ($tube['no'] - 6) + 0.75; // kg
                $this->mastWeightBreakdown['topRollerHolderFlanges'][$tube['no']] = $topRollerHolderFlangeWeight; // kg
                $this->mastWeight += $topRollerHolderFlangeWeight; // kg;
            }
        }

        //Roller Weights
        $noOfRollers = count($this->mastTubes) *2;

        $this->mastWeightBreakdown['rollerWeights'] = 0.12* $noOfRollers; // 0.12 kg/roller
        $this->mastWeight += $this->mastWeightBreakdown['rollerWeights']; // kg;

        // Base Adapter weight: Only one base adapter for MTWR
        $this->mastWeightBreakdown['baseAdapter'] = 0.32225 * ($this->endTubeNo - 6) + 3.5; // kg
        $this->mastWeight += $this->mastWeightBreakdown['baseAdapter']; // kg;

        // Bottom Roller Holder Flanges
        foreach ($this->mastTubes as $key => $tube) {

            if ($tube['no'] != $this->endTubeNo) {
                $bottomRollerHolderFlangeWeight = 0.08889 * ($tube['no'] - 6) + 0.4; // kg
                $this->mastWeightBreakdown['bottomRollerHolderFlanges'][$tube['no']] = $bottomRollerHolderFlangeWeight; // kg
                $this->mastWeight += $bottomRollerHolderFlangeWeight; // kg;
            }
        }

        // Fixed Rollers Holder Part Weigts
        $noOfFixedRollerHolderParts = (count($this->mastTubes) -2) *2;
        $this->mastWeightBreakdown['fixedRollerHolderParts'] = 0.04 * $noOfFixedRollerHolderParts; // 0.04 kg/roller
        $this->mastWeight += $this->mastWeightBreakdown['fixedRollerHolderParts']; // kg;

        // Payload Adapter
        $this->mastWeightBreakdown['payloadAdapter'] = 0.3567 * ($this->startTubeNo - 6) + 1.74; // kg
        $this->mastWeight += $this->mastWeightBreakdown['payloadAdapter']* 1.05; // kg with 5% extra for bolts and nuts

        // Steel Wire Weight
        $wireLength = 2.05*count($this->mastTubes) * $this->lengthMTTubes / 1000; // meters
        $this->mastWeightBreakdown['steelWire'] = 0.12 * $wireLength; // kg (2.5 kg/meter)
        $this->mastWeight += $this->mastWeightBreakdown['steelWire']; // kg;

        $this->mastWeight = $this->mastWeight * 1.05; // kg with 5% extra for bolts and nuts
        return true;
    }


    public function calculateMTNXMass() {

        $totalMass = 0;
        $fixed_weight = 0;

        $is_bottom_tube = false;
        $is_top_tube = false;

        $path = resource_path('js/mtnx_weight_data.json');
        $json  = file_get_contents($path);
        $mtnx_weight_data = json_decode($json, true);  // associative array

        $weight_breakdown = [];

        foreach ($this->mastTubes as $tube) {

            // Check if the tube is the bottom tube
            if ( $this->mastTubes["0"]["no"] === $tube["no"]) {
                $is_bottom_tube = true;
            } else {
                $is_bottom_tube = false;
            }

            // Check if the tube is the top tube
            if ( $this->mastTubes[count($this->mastTubes)-1]["no"] === $tube["no"]) {
                $is_top_tube = true;
            } else {
                $is_top_tube = false;   
            }

            // Base Structure Mass Calculation
            if ($is_bottom_tube) {
                $base_structure_weight = $mtnx_weight_data['bottom_structure']['C'. $tube['no']]['with_accessories']['weight'];
                $weight_breakdown['base_structure']['C'. $tube['no']] = $base_structure_weight;
                $totalMass += $base_structure_weight;

                $fixed_weight += $base_structure_weight;
            }

            // Tubes Weight Calculation
            $tube_weight = $mtnx_weight_data['sections']['tubes']['C'. $tube['no']]['weight_m']*$this->allData["tubeLength"]/1000; // kg
            $weight_breakdown['tubes']['C'. $tube['no']] = $tube_weight;
            $totalMass += $tube_weight;

            if ($is_bottom_tube) {
                $fixed_weight += $tube_weight;
            }

            // Fixed Flange Weight Calculation
            $fixed_flange_weight = $mtnx_weight_data['sections']['fixed_flange']['C'. $tube['no']]["average"]['weight'];
            $weight_breakdown['fixed_flange']['C'. $tube['no']] = $fixed_flange_weight;
            $totalMass += $fixed_flange_weight;

            if ($is_bottom_tube) {
                $fixed_weight += $fixed_flange_weight;
            }

            // Ice Breaker Mass Calculation
            if (!$is_top_tube) {
                $ice_breaker_weight = $mtnx_weight_data['sections']['ice_breaker']['C'. $tube['no']]['weight'];
                $weight_breakdown['ice_breaker']['C'. $tube['no']] = $ice_breaker_weight;
                $totalMass += $ice_breaker_weight;
            }

            if ($is_bottom_tube) {
                $fixed_weight += $ice_breaker_weight;
            }

            // Power Screw Frame Breaker Mass Calculation
            if (!$is_bottom_tube) {
                $weight_breakdown['power_screw_frame']['C'. $tube['no']] = $mtnx_weight_data['sections']['power_screw_frame']['C'. $tube['no']]["assy"]['weight'];
                $totalMass += $weight_breakdown['power_screw_frame']['C'. $tube['no']];
            }

            // Lower Key Guides Mass Calculation
            if (!$is_bottom_tube) {
                $numberOfLowerKeyGuides = $mtnx_weight_data['key_numbers']['C'. $tube['no']];
                $weight_breakdown['lower_key_guides']['C'. $tube['no']] = $mtnx_weight_data['sections']['lower_key_guides']['C'. $tube['no']]['weight'] * $numberOfLowerKeyGuides;
                $totalMass += $weight_breakdown['lower_key_guides']['C'. $tube['no']];
            }
            
            // Upper Key Guides Mass Calculation
            if (!$is_top_tube) {
                $numberOfUpperKeyGuides = $mtnx_weight_data['key_numbers']['C'. $tube['no']];
                $upper_keys_weight = $mtnx_weight_data['sections']['upper_key_guides']['C'. $tube['no']]['weight'] * $numberOfUpperKeyGuides;
                $weight_breakdown['upper_key_guides']['C'. $tube['no']] = $upper_keys_weight;
                $totalMass += $upper_keys_weight ;
            }

            if ($is_bottom_tube) {
                $fixed_weight += $upper_keys_weight;
            }
            
            // Euler Fixer Mass Calculation
            if ($is_top_tube) {
                $weight_breakdown['euler_fixer']['C'. $tube['no']] = $mtnx_weight_data['sections']['euler_fixer']['C'. $tube['no']]['weight'];
                $totalMass += $weight_breakdown['euler_fixer']['C'. $tube['no']];
            }

            // Payload Interface Mass Calculation
            if ($is_top_tube) {
                $weight_breakdown['payload_interface']['C'. $tube['no']] = $mtnx_weight_data['sections']['payload_interface']['C'. $tube['no']]['weight'];
                $totalMass += $weight_breakdown['payload_interface']['C'. $tube['no']];
            }

            // Lock Stopper Mass Calculation
            if (!$is_bottom_tube) {
                $weight_breakdown['lock_stopper_on_tubes']['C'. $tube['no']] = $mtnx_weight_data['sections']['lock_stopper_on_tubes']['C'. $tube['no']]['weight']*2;
                $totalMass += $weight_breakdown['lock_stopper_on_tubes']['C'. $tube['no']];
            }

            // Lock Key Mass Calculation
            if (!$is_top_tube) {
                $weight_breakdown['lock_key']['C'. $tube['no']] = $mtnx_weight_data['sections']['lock_key']['C'. $tube['no']]['weight']*2; // 2 lock keys per tube
                $totalMass += $weight_breakdown['lock_key']['C'. $tube['no']];
            }

            // Lock Mechanism Mass Calculation
            if (!$is_top_tube && !$is_bottom_tube) {
                $weight_breakdown['lock_mechanism']['C'. $tube['no']] = $mtnx_weight_data['sections']['lock_mechanism']['C'. $tube['no']]['weight']*2; // 2 lock mechanisms per tube
                $totalMass += $weight_breakdown['lock_mechanism']['C'. $tube['no']];
            }

            if ($is_bottom_tube) {
                $fixed_weight += $weight_breakdown['lock_key']['C'. $tube['no']];
            }
        }

        // Power Screw Mass Calculation
        $power_screw_length = ($this->allData['nestedHeight'] -75) / 1000; // Convert to meters
        $power_screw_volume = pi() * pow($mtnx_weight_data['power_screw']['diameter']/1000, 2) / 4 * $power_screw_length; // Volume of the power screw in m3 (assuming diameter of 50mm)
        $power_screw_mass = $power_screw_volume * $mtnx_weight_data['power_screw']['density']; // Mass of the power screw in kg (assuming density of steel is 7850 kg/m3)
        $weight_breakdown['power_screw'] = $power_screw_mass*0.9; // 10% weight reduction for threads and undercuts the power screw
        $totalMass += $weight_breakdown['power_screw'];

        $fixed_weight += $weight_breakdown['power_screw'];

        // Gear Box Mass Calculation
        $weight_breakdown['gear_box'] = $mtnx_weight_data['gear_box']['weight'];
        $totalMass += $weight_breakdown['gear_box'];

        $fixed_weight += $weight_breakdown['gear_box'];

        // Motor Mass Calculation
        $weight_breakdown['motor'] = $mtnx_weight_data['motor']['weight'];
        $totalMass += $weight_breakdown['motor'] ;

        $fixed_weight += $weight_breakdown['motor'];


        //dd($totalMass, $weight_breakdown);
        $this->mastWeight = $totalMass;
        $this->mastWeightBreakdown = $weight_breakdown;

        $this->mastLiftedWeight = $totalMass - $fixed_weight; // kg

        return true;
    }






}
