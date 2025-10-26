<section class="section container">

    {{--
    <script src="{{ asset(path: '/js/svgClass.js') }}"></script> --}}
    <script src="{{ asset('/js/CanvasDraw.js') }}"> </script>

    <script>

        // document.addEventListener('drawSvg', event => {

        //     const solutionSet = event.detail[0].solutionSet;
        //     const solutionTubeData = event.detail[0].solutionTubeData;
        //     const currentSolution = event.detail[0].currentSolution;
        //     const svgType = event.detail[0].svgType;
        //     const adapters = event.detail[0].adapters

        //     if (document.getElementById('svg')) {
        //         document.getElementById('svg').remove()
        //     }

        //     let p = new svgClass(solutionSet, solutionTubeData, currentSolution, svgType, adapters);

        //     p.run()
        // });



        window.addEventListener("triggerCanvasDraw", function (e) {

            if (document.getElementById('svg')) {
                document.getElementById('svg').remove()

                console.log('svg removed')
            }

            let p = new CanvasClass(e.detail.data, e.detail.graphType);

            p.run()
        })





    </script>

    <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
        <ul>
            <li><a href='/engineering/home'>Engineering</a></li>
            <li class="is-active"><a href="#" aria-current="page">Mast Configurator</a></li>
        </ul>
    </nav>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">Mast Configurator</h1>
        <h2 class="subtitle has-text-weight-light">Payload - Extended / Nested Height - Weight</h2>
    </header>







    @include('engineering.mast.mast-parameters')























    <div class="tabs">
        <ul>
            <li class="{{$graphType === 'Loads' ? ' is-active' : ''}}">
                <a wire:click="toggleGraphType('Loads')">Loads Analysis</a>
            </li>

            <li class="{{$graphType === 'Extended' ? ' is-active' : ''}}">
                <a wire:click="toggleGraphType('Extended')">Extended Position</a>
            </li>
            <li class="{{$graphType === 'Nested' ? ' is-active' : ''}}">
                <a wire:click="toggleGraphType('Nested')">Nested Position</a>
            </li>
        </ul>
    </div>



    <div class="p-0" id="svgDiv" wire:ignore>

        <header class="mb-6">
            <h1 class="title has-text-weight-light is-size-1" id="tabHeader"></h1>
        </header>

        {{-- svg to be added dynamically here --}}

    </div>




    @include('engineering.mast.info')
    {{-- @include('engineering.mast.tubestable') --}}































    {{-- // MODALS --}}


    <div class="modal {{ $showModal ? 'is-active' : '' }}" id="modal">
        <div class="modal-background" wire:click="toggleModal"></div>
        <div class="modal-content box">
            <h1 class="title">MT-{{ !empty($singleTubeData) ? sprintf("%02d", $singleTubeData["no"]) : '' }} Tube
                Details
            </h1>
            <table class="table is-fullwidth">

                <tr>
                    <th>Outside Diameter</th>
                    <td class="has-text-right">
                        {{ !empty($singleTubeData) ? Number::format($singleTubeData["od"], locale: 'de', precision: 2) : '' }}
                        mm
                    </td>
                </tr>


                <tr>
                    <th>Inside Diameter</th>
                    <td class="has-text-right">
                        {{ !empty($singleTubeData) ? Number::format($singleTubeData["id"], locale: 'de', precision: 2) : '' }}
                        mm
                    </td>
                </tr>


                <tr>
                    <th>Thickness</th>
                    <td class="has-text-right">
                        {{ !empty($singleTubeData) ? Number::format($singleTubeData["thk"], locale: 'de', precision: 2) : '' }}
                        mm
                    </td>
                </tr>

                <tr>
                    <th>Area (Basic Hollow Shape)</th>
                    <td class="has-text-right">
                        {{ !empty($singleTubeData) ? Number::format($singleTubeData["areaBasic"], locale: 'de', precision: 0) : '' }}
                        mm<sup>2</sup>
                    </td>
                </tr>


                <tr>
                    <th>Area</th>
                    <td class="has-text-right">
                        {{ !empty($singleTubeData) ? Number::format($singleTubeData["area"], locale: 'de', precision: 0) : '' }}
                        mm<sup>2</sup>
                    </td>
                </tr>

                <tr>
                    <th>Area Increase (%)</th>
                    <td class="has-text-right">
                        {{ !empty($singleTubeData) ? Number::format(($singleTubeData["area"] - $singleTubeData["areaBasic"]) / $singleTubeData["areaBasic"] * 100, locale: 'de', precision: 0) : '' }}
                        %
                    </td>
                </tr>



                <tr>
                    <th>Inertia (Basic Hollow Shape)</th>
                    <td class="has-text-right">
                        {{ !empty($singleTubeData) ? Number::format($singleTubeData["inertiaBasic"], locale: 'de', precision: 0) : '' }}
                        mm<sup>4</sup>
                    </td>
                </tr>



                <tr>
                    <th>Inertia</th>
                    <td class="has-text-right">
                        {{ !empty($singleTubeData) ? Number::format($singleTubeData["inertia"], locale: 'de', precision: 0) : '' }}
                        mm<sup>4</sup>
                    </td>
                </tr>


                <tr>
                    <th>Inertia Increase (%)</th>
                    <td class="has-text-right">
                        {{ !empty($singleTubeData) ? Number::format(($singleTubeData["inertia"] - $singleTubeData["inertiaBasic"]) / $singleTubeData["inertiaBasic"] * 100, locale: 'de', precision: 0) : '' }}
                        %
                    </td>
                </tr>



                <tr>
                    <th>Pneumatic Load Capacity</th>
                    <td class="has-text-right">
                        {{ !empty($singleTubeData) ? Number::format($singleTubeData["pressureLoad"], locale: 'de', precision: 0) : '' }}
                        N
                    </td>
                </tr>


                <tr>
                    <th>Critical Load (Compression)</th>
                    <td class="has-text-right">
                        {{ !empty($singleTubeData) ? Number::format($singleTubeData["criticalLoad"], locale: 'de', precision: 0) : '' }}
                        N
                    </td>
                </tr>

                <tr>
                    <th>EI</th>
                    <td class="has-text-right">
                        {{ !empty($singleTubeData) ? Number::format($singleTubeData["EI"], locale: 'de', precision: 0) : '' }}
                        Nmm<sup>2</sup>
                    </td>
                </tr>

            </table>
        </div>
        <button class="modal-close is-large" aria-label="close" wire:click="toggleModal"></button>
    </div>




    <div class="modal {{ $showHelpModal ? 'is-active' : '' }}" id="modalHelp">
        <div class="modal-background" wire:click="toggleHelpModal('mparams')"></div>
        <div class="modal-content box">

            <h1 class="title">Terrain Categories</h1>

            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Description</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($terrainCategory as $terrain)

                        <tr>
                            <th class="is-4">{{ $terrain["no"] }}</th>
                            <td>{{ $terrain["description"] }}</td>
                        </tr>

                    @endforeach
                </tbody>
            </table>

        </div>

        <button class="modal-close is-large" aria-label="close"
            wire:click="toggleHelpModal('{{ $modalType }}')"></button>
    </div>



</section>