<section class="section container">


    <script src="{{ asset('/js/DrawMastTubesClass.js') }}"> </script>



    <script>

        window.addEventListener("triggerCanvasDraw",function(e) {
            drawCanvas(e.detail.data)
        })


        // window.addEventListener("triggerCanvasRefresh",function(e) {
        //     redrawCanvas(e.detail.data)
        // })

    </script>





    @switch($action)

        @case("mttubes")

            <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
                <ul>
                    <li><a href='/engineering/home'>Engineering</a></li>
                    <li class="is-active"><a href="#" aria-current="page">Standard Masttech Profiles</a></li>
                </ul>
            </nav>

            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">Masttech Tube Profiles</h1>
                <h2 class="subtitle has-text-weight-light">All Rights Reserved &copy; 2025</h2>
            </header>

            @break





        @case("heights")

            <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
                <ul>
                  <li><a href='/engineering/home'>Engineering</a></li>
                  <li class="is-active"><a href="#" aria-current="page">Mast Nested/Extended Heights</a></li>
                </ul>
            </nav>

            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">No of Sections - Extended Height - Nested Height</h1>
                <h2 class="subtitle has-text-weight-light">Relationship between three parameters</h2>
            </header>
           @break









        @default
        @case("deflection")

            <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
                <ul>
                    <li><a href='/engineering/home'>Engineering</a></li>
                    <li class="is-active"><a href="#" aria-current="page">Mast Nested/Extended Heights</a></li>
                </ul>
            </nav>

            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">Mast Deflections</h1>
                <h2 class="subtitle has-text-weight-light">Bending Moment and Deflection Calculation for Variable Section Mast Structures</h2>
            </header>

            @break


        @case("wloads")

            <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
                <ul>
                <li><a href='/engineering/home'>Engineering</a></li>
                <li class="is-active"><a href="#" aria-current="page">Wind Forces on Payloads</a></li>
                </ul>
            </nav>

            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">Wind Forces on Payloads</h1>
                <h2 class="subtitle has-text-weight-light">Wind Speed/Sail Area</h2>
            </header>

            @break






        @case("pneumatic")

            <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
                <ul>
                <li><a href='/engineering/home'>Engineering</a></li>
                <li class="is-active"><a href="#" aria-current="page">Pneumatic Capacity Calculation</a></li>
                </ul>
            </nav>

            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">Pressure Loads</h1>
                <h2 class="subtitle has-text-weight-light">Pneumatic Capacity Calculation for Pressure Activated Masts</h2>
            </header>

            @break














    @endswitch








    @if ($action == 'deflection' || $action == 'heights')

        @include('engineering.mast.heights')



    @endif



    @if ($action == 'deflection')

        {{-- CANVAS FOR MAST TUBES --}}

        <div class="card my-4 has-text-centered" id="canvasDiv" wire:ignore></div>


    @endif



    @if ($action == 'deflection' || $action == 'mttubes')

        @include('engineering.mast.info')
        @include('engineering.mast.tubestable')

    @endif


    @if ($action == 'wloads')

        @include('engineering.mast.wloads')

    @endif



    @if ($action == 'pneumatic')

        @include('engineering.mast.pneumatic')

    @endif







    @if ($action == 'deflection' || $action == 'mttubes')


        <div class="modal {{ $showModal ? 'is-active' :'' }}" id="modal">
            <div class="modal-background" wire:click="toggleModal"></div>
            <div class="modal-content box">
                <h1 class="title">Tube 1 Details</h1>
                <table class="table is-fullwidth">



                    <tr>
                        <th>Outside Diameter</th>
                        <td class="has-text-right">{{ !empty($singleTubeData) ? Number::format($singleTubeData["od"],locale:'de',precision:2) : '' }} mm</td>
                    </tr>


                    <tr>
                        <th>Inside Diameter</th>
                        <td class="has-text-right">{{ !empty($singleTubeData) ? Number::format($singleTubeData["id"],locale:'de',precision:2) : '' }} mm</td>
                    </tr>


                    <tr>
                        <th>Thickness</th>
                        <td class="has-text-right">{{ !empty($singleTubeData) ? Number::format($singleTubeData["thk"],locale:'de',precision:2) : '' }} mm</td>
                    </tr>


                    <tr>
                        <th>Area</th>
                        <td class="has-text-right">{{ !empty($singleTubeData) ? Number::format($singleTubeData["area"],locale:'de',precision:0) : '' }} mm<sup>2</sup></td>
                    </tr>
                    <tr>
                        <th>Inertia</th>
                        <td class="has-text-right">{{ !empty($singleTubeData) ? Number::format($singleTubeData["inertia"],locale:'de',precision:0) : '' }} mm<sup>4</sup></td>
                    </tr>
                    <tr>
                        <th>Pneumatic Load Capacity</th>
                        <td class="has-text-right">{{ !empty($singleTubeData) ? Number::format($singleTubeData["pressureLoad"],locale:'de',precision:0) : '' }} N
                        </td>
                    </tr>


                    <tr>
                        <th>Critical Load (Compression)</th>
                        <td class="has-text-right">{{ !empty($singleTubeData) ? Number::format($singleTubeData["criticalLoad"],locale:'de',precision:0) : '' }} N</td>
                    </tr>

                    <tr>
                        <th>EI</th>
                        <td class="has-text-right">{{ !empty($singleTubeData) ? Number::format($singleTubeData["EI"],locale:'de',precision:0) : '' }} Nmm<sup>2</sup></td>
                    </tr>

                </table>
            </div>
            <button class="modal-close is-large" aria-label="close" wire:click="toggleModal"></button>
        </div>

    @endif



    @if ($action == 'deflection' )

        <div class="modal {{ $showHelpModal ? 'is-active' :'' }}" id="modalHelp">
            <div class="modal-background" wire:click="toggleHelpModal('mparams')"></div>
            <div class="modal-content box">



               @switch($modalType)
                @case("mparams")
                    <h1 class="title">Mast Parameters</h1>
                    <p class="image is-4by3">
                        <img src="https://bulma.io/assets/images/placeholders/1280x960.png" alt="">
                    </p>
                    
                    @break


                @case("terrain")

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
                    @break

                @default
                    
               @endswitch 






            </div>
            <button class="modal-close is-large" aria-label="close" wire:click="toggleHelpModal('{{ $modalType }}')"></button>
        </div>

    @endif





</section>



