<section class="section container">

    <script src="{{ asset('/js/charts.js') }}"></script>


    <script>

        window.addEventListener("triggerCanvasDraw", function (e) {

            if (document.getElementById('svg')) {
                document.getElementById('svg').remove()
            }

            let pNested = new MastDraw(e.detail.data, 'Nested');
            pNested.run()

            let pExtended = new MastDraw(e.detail.data, 'Extended');
            pExtended.run()


            let pLoads = new MastDraw(e.detail.data,'Loads');
            pLoads.run();
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
            document.getElementById('divChartCapacity').classList.add('is-hidden');

            document.getElementById('liSvgNested').classList.remove('is-active');
            document.getElementById('liSvgExtended').classList.remove('is-active');
            document.getElementById('liSvgLoads').classList.remove('is-active');
            document.getElementById('liSvgCapacity').classList.remove('is-active');

            if (jsGraphType === 'Nested') {
                document.getElementById('divSvgNested').classList.remove('is-hidden');
                document.getElementById('liSvgNested').classList.add('is-active');

            } else if (jsGraphType === 'Extended') {

                document.getElementById('divSvgExtended').classList.remove('is-hidden');
                document.getElementById('liSvgExtended').classList.add('is-active');

            } else if (jsGraphType === 'Loads') {

                document.getElementById('divSvgLoads').classList.remove('is-hidden');
                document.getElementById('liSvgLoads').classList.add('is-active');

            } else if (jsGraphType === 'Capacity') {
                document.getElementById('divChartCapacity').classList.remove('is-hidden');
                document.getElementById('liSvgCapacity').classList.add('is-active');

                drawChart();
            }
        }

        let capacityChartDrawn = false;

        function drawChart() {

            if (capacityChartDrawn) {
                return;
            }
            capacityChartDrawn = true;

            new Chart(document.getElementById('capacityChart'), {
                type: 'line',
                data: @json($capacityChartDataset),
                options: {
                    scales: {
                        x: {
                            title: {
                            color: 'blue',
                            display: true,
                            text: 'Maximum Extended Height (m)'
                            }
                        },
                        y: {
                            title: {
                            color: 'blue',
                            display: true,
                            text: 'Maximum Payload (kg)'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Mast Capacity Envelopes',
                            color: 'blue',
                        }
                    }
                }
            });

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
            <li id="liSvgCapacity">
                <a href="javascript:void(0)" onclick="toggleGraph('Capacity')">Mast Capacity Envelopes</a>
            </li>

            <li id="liSvgLoads">
                <a href="javascript:void(0)" onclick="toggleGraph('Loads')">Loads Analysis</a>
            </li>

            <li id="liSvgExtended">
                <a href="javascript:void(0)" onclick="toggleGraph('Extended')">Extended Position</a>
            </li>
            <li id="liSvgNested" class="is-active">
                <a href="javascript:void(0)" onclick="toggleGraph('Nested')">Nested Position</a>
            </li>
        </ul>
    </div>


    <div id='svgDivs' class="p-0" wire:ignore>

        <div id="divChartCapacity" class="is-hidden">
            {{-- Chart to be added dynamically here --}}
            <canvas id="capacityChart" class="p-6 "></canvas>
        </div>

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


    <div class="column">

    <table class="table is-fullwidth">


        <caption class="has-tex-cenetered subtitle">Wind Loads Data on Mast and Sections</caption>

        <thead>
            <tr>
                <th>Section Definition</th>
                <th class="has-text-right">Geometric Parameter</th>
                <th class="has-text-right">Load</th>
                <th class="has-text-right">Load Acting Height</th>
            </tr>
        </thead>

        @foreach ($mastTubes as $tube )
            <tr>
                <td> {{ $tube['no'] }} </td>
                <td class="has-text-right"> {{ sprintf("%.2f", round($tube["od"], 2)) }} mm</td>
                <td class="has-text-right"> {{ round($tube["windForce"], 0) }} N</td>
                <td class="has-text-right"> {{ round($tube["windLoadActingZ"], 1) }} mm</td>

            </tr>
        @endforeach 

        <tr>
            <td> Payload </td>
            <td class="has-text-right"> {{ sprintf("%.2f", round($sailarea, 1)) }} m<sup>2</sup></td>
            <td class="has-text-right"> {{ round($allData["windLoadOnPayload"], 0) }} N</td>
            <td class="has-text-right"> {{ round($extendedHeight + $zOffset, 0) }} mm</td>

        </tr>


    </table>




    </div>

    @include('engineering.mast.info')

    {{-- // MODALS --}}
    <div class="modal {{ $showModalTerrain ? 'is-active' : '' }}" >
        <div class="modal-background" wire:click="toggleModal('modalTerrain')"></div>
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
            wire:click="toggleModal('modalTerrain')">
        </button>
    </div>



    <div class="modal {{ $showModalOffsets ? 'is-active' : '' }}" >
        <div class="modal-background" wire:click="toggleModal('modalOffsets')"></div>
        <div class="modal-content box">

            <h1 class="title">X and Z Offset Definitions</h1>
            <figure class="image ">
                <img src="{{ asset(path: 'images/xz_offsets.svg') }}" alt="X and Z Offset Definitions">
            </figure>

        </div>

        <button class="modal-close is-large" aria-label="close"
            wire:click="toggleModal('modalOffsets')"></button>
    </div>














    {{-- // HIDDEN IMAGES --}}
    <div class="column is-hidden">

        <img id="graphImage" alt="Mast Configurator Diagram">
        <img src="{{ asset(path: 'images/mtwr_background.jpg') }}" alt="MTWR" id="MTWR">
        <img src="{{ asset(path: 'images/mtpr_background.jpg') }}" alt="MTPR" id="MTPR">

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


        <img src="{{ asset(path: 'images/Accessory1.jpg') }}" alt="icon" id="accessory1">
        <img src="{{ asset(path: 'images/Accessory2.jpg') }}" alt="icon" id="accessory2">
        <img src="{{ asset(path: 'images/Accessory3.jpg') }}" alt="icon" id="accessory3">
        <img src="{{ asset(path: 'images/Accessory4.jpg') }}" alt="icon" id="accessory4">



    </div>

</section>