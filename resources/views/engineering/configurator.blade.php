<section class="section container">

    {{-- <script src="{{ asset('/js/CanvasDraw.js') }}"> </script> --}}
    {{-- <script src="{{ asset('/js/productBrochure.js') }}"> </script> --}}



    <script>




        window.addEventListener("triggerCanvasDraw", function (e) {

            if (document.getElementById('svg')) {
                document.getElementById('svg').remove()
            }

            let pNested = new MastDraw(e.detail.data, 'Nested');
            pNested.run()

            let pExtended = new MastDraw(e.detail.data, 'Extended');
            pExtended.run()
        })

        async function exportToPdf() {

            const data = JSON.parse(localStorage.getItem('data'));

            let brochure = new GenerateBrochure(data)

            await brochure.init();  // ✅ Initialize QR code first
            brochure.run();
        }


        function toggleGraph(jsGraphType) {

            document.getElementById('divSvgNested').classList.add('is-hidden');
            document.getElementById('divSvgExtended').classList.add('is-hidden');
            document.getElementById('divSvgLoads').classList.add('is-hidden');

            document.getElementById('liSvgNested').classList.remove('is-active');
            document.getElementById('liSvgExtended').classList.remove('is-active');
            document.getElementById('liSvgLoads').classList.remove('is-active');

            if (jsGraphType === 'Nested') {
                document.getElementById('divSvgNested').classList.remove('is-hidden');
                document.getElementById('svgHeader').innerHTML = "Nested Position";
                document.getElementById('liSvgNested').classList.add('is-active');

            } else if (jsGraphType === 'Extended') {
                document.getElementById('divSvgExtended').classList.remove('is-hidden');
                document.getElementById('svgHeader').innerHTML = "Extended Position";
                document.getElementById('liSvgExtended').classList.add('is-active');

            } else if (jsGraphType === 'Loads') {
                document.getElementById('divSvgLoads').classList.remove('is-hidden');
                document.getElementById('svgHeader').innerHTML = "Loads Analysis";
                document.getElementById('liSvgLoads').classList.add('is-active');
            }
        }





    </script>

    <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
        <ul>
            <li><a href='/engineering/home'>Engineering</a></li>
            <li class="is-active"><a href="#" aria-current="page">Mast Configurator</a></li>
        </ul>
    </nav>



    <div class="fixed-grid has-2-cols">

        <div class="grid">

            <div class="cell">

                <header class="mb-6">
                    <h1 class="title has-text-weight-light is-size-1">Mast Configurator</h1>
                    <h2 class="subtitle has-text-weight-light">Payload - Extended / Nested Height - Weight</h2>
                </header>

            </div>

            <div class="cell has-text-right">
                <a href="javascript:exportToPdf('data')" class="button is-danger is-light">
                    <span class="icon has-text-danger"><x-carbon-document-pdf /></span>
                </a>
            </div>

        </div>

    </div>









    @include('engineering.mast.mast-parameters')


















    <div class="tabs" wire:ignore>
        <ul>
            <li id="liSvgLoads">
                <a href="javascript:void(0)" onclick="toggleGraph('Loads')">Loads Analysis</a>
            </li>

            <li id="liSvgExtended" >
                <a href="javascript:void(0)" onclick="toggleGraph('Extended')">Extended Position</a>
            </li>
            <li id="liSvgNested" class="is-active">
                <a href="javascript:void(0)" onclick="toggleGraph('Nested')">Nested Position</a>
            </li>
        </ul>
    </div>





    <div id='svgDivs' class="p-0" wire:ignore>

        <header class="mb-6">
            <h1 class="title has-text-weight-light is-size-1" id="svgHeader"></h1>
        </header>

        <div id="divSvgNested">
            {{-- svg to be added dynamically here --}}
        </div>
        <div id="divSvgExtended" class="is-hidden">
            {{-- svg to be added dynamically here --}}
        </div>
        <div id="divSvgLoads" class="is-hidden">
            {{-- svg to be added dynamically here --}}
        </div>

    </div>




    @include('engineering.mast.info')































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


    {{-- // HIDDEN IMAGES --}}
    <div class="column ">

        <img id="graphImage" alt="Mast Configurator Diagram">
        <img src="{{ asset(path: 'images/mtwr_background.png') }}" alt="MTWR" id="MTWR">
        <img src="{{ asset(path: 'images/mtpr_background.png') }}" alt="MTPR" id="MTPR">

        <img id="NestedSvgImage" alt="Nested Position Diagram">
        <img id="ExtendedSvgImage" alt="Extended Position Diagram">

        <img src="{{ asset(path: 'images/masttech.png') }}" alt="masttech" id="masttech">

        <img src="{{ asset(path: 'images/arrows-vertical.png') }}" alt="icon" id="heightIcon">
        <img src="{{ asset(path: 'images/barbell.png') }}" alt="icon" id="barbellIcon">
        <img src="{{ asset(path: 'images/engine.png') }}" alt="icon" id="engineIcon">
        <img src="{{ asset(path: 'images/person-simple-ski.png') }}" alt="icon" id="personIcon">
        <img src="{{ asset(path: 'images/wind.png') }}" alt="icon" id="windIcon">

        <img src="{{ asset(path: 'images/Compressor.png') }}" alt="icon" id="compressorIcon">
        <img src="{{ asset(path: 'images/NoPressureNeeded.png') }}" alt="icon" id="noPressureNeededIcon">

        <img src="{{ asset(path: 'images/AutoLocking.png') }}" alt="icon" id="autoLockingIcon">

        <img src="{{ asset(path: 'images/dot-outline.png') }}" alt="icon" id="dot">


                <img src="{{ asset(path: 'images/Accessory1.png') }}" alt="icon" id="accessory1">
                                <img src="{{ asset(path: 'images/Accessory2.png') }}" alt="icon" id="accessory2">
                <img src="{{ asset(path: 'images/Accessory3.png') }}" alt="icon" id="accessory3">
                <img src="{{ asset(path: 'images/Accessory4.png') }}" alt="icon" id="accessory4">



    </div>

</section>