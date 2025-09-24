<section class="section container">


    {{-- <style>
        #svg {
    display: block;  /* This removes the inline spacing */
    vertical-align: top; 
}
    </style> --}}


    <script src="{{ asset(path: '/js/svgClass.js') }}"></script>

    <script>


        document.addEventListener('drawSvg', event => {

            const solutionSet = event.detail[0].solutionSet;
            const solutionTubeData = event.detail[0].solutionTubeData;
            const currentSolution = event.detail[0].currentSolution;

            const svg = document.getElementById('svg');

            // Clear previous content
            while (svg.firstChild) {
                svg.removeChild(svg.firstChild);
            }

            let newImage = new svgClass(solutionSet,solutionTubeData,currentSolution);
        });

    </script>

    <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
        <ul>
            <li><a href='/engineering/home'>Engineering</a></li>
            <li class="is-active"><a href="#" aria-current="page">Mast Configurator</a></li>
        </ul>
    </nav>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">Mast Configurator</h1>
        <h2 class="subtitle has-text-weight-light">Motor - GearBox - Cable Drum - Load</h2>
    </header>


    <div class="card p-6">

        <div class="columns">

            <div class="column field is-half">

                <span class="tag is-large is-warning">Target Extended Height</span>
                <div class="field mt-4">

                    <label class="label">Maximum [m]</label>
                    <div class="control">
                        <input class="input" type="number" placeholder="Target Extended Height"
                            wire:model.live="targetExtendedHeightMax" step="10">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Minimum [m]</label>
                    <div class="control">
                        <input class="input" type="number" placeholder="Target Nested Height"
                            wire:model.live="targetExtendedHeightMin" step="10">
                    </div>
                </div>

            </div>

            <div class="column field is-half">

                <span class="tag is-large is-warning">Target Nested Height</span>
                <div class="field mt-4">

                    <label class="label">Maximum [m]</label>
                    <div class="control">
                        <input class="input" type="number" placeholder="Maximum Nested Height"
                            wire:model.live="targetNestedHeightMax" step="1">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Minimum [m]</label>
                    <div class="control">
                        <input class="input" type="number" placeholder="Minimum Nested Height"
                            wire:model.live="targetNestedHeightMin" step="1">
                    </div>
                </div>

            </div>



        </div>

        <div class="column has-text-right">

            <button class="button is-ghost" wire:click="$toggle('showOtherParams')">
                <span class="icon">

                    @if (!$showOtherParams)
                        <x-carbon-chevron-down />
                    @else
                        <x-carbon-chevron-up />
                    @endif
                </span>
            </button>

        </div>


        <div class="fixed-grid has-4-cols {{ $showOtherParams ? '' : 'is-hidden'}}">

            <div class="grid">

                <div class="cell">

                    <div class="field mt-4">

                        <label class="label">Overlap Length [mm]</label>
                        <div class="control">
                            <input class="input" type="number" placeholder="Overlap Dimension"
                                wire:model.live="overlapDimension" step="1">
                        </div>
                    </div>

                </div>

                <div class="cell">

                    <div class="field mt-4">

                        <label class="label">Head Length [mm]</label>
                        <div class="control">
                            <input class="input" type="number" placeholder="Head Dimension"
                                wire:model.live="headDimension" step="1">
                        </div>
                    </div>
                </div>


                <div class="cell">

                    <div class="field mt-4">

                        <label class="label">Payload Adapter Thickness [mm]</label>
                        <div class="control">
                            <input class="input" type="number" placeholder="Head Dimension"
                                wire:model.live="payloadAdapterThickness" step="1">
                        </div>
                    </div>
                </div>


                <div class="cell">

                    <div class="field mt-4">

                        <label class="label">Base Support Thickness [mm]</label>
                        <div class="control">
                            <input class="input" type="number" placeholder="Head Dimension"
                                wire:model.live="baseSupportThickness" step="1">
                        </div>
                    </div>
                </div>

            </div>


            <div class="grid">

                <div class="cell field ">

                    <label class="label">Top Tube Dia</label>

                    <div class="control">

                        <div class="select is-fullwidth">
                            <select wire:model.live="startTubeNo" >

                                @foreach ($mtProfiles as $tube)

                                <option value="{{ $tube["no"] }}">
                                    MT-{{ sprintf("%02d",$tube["no"]) }}
                                    &nbsp; &nbsp;&nbsp;&nbsp; &#8960;
                                    {{ sprintf("%6.2f",round($tube["od"],2)) }}
                                </option>

                                @endforeach

                            </select>
                        </div>

                    </div>

                </div>


                <div class="cell field ">
                    <label class="label">Bottom Tube OD, mm</label>

                    <div class="control">

                        <div class="select is-fullwidth" >
                            <select wire:model.live="endTubeNo" >

                                @foreach ($mtProfiles as $tube)

                                <option value="{{ $tube["no"] }}">
                                    MT-{{ sprintf("%02d",$tube["no"]) }}
                                    &nbsp; &nbsp;&nbsp;&nbsp; &#8960;
                                    {{ sprintf("%6.2f",round($tube["od"],2)) }}
                                </option>

                                @endforeach

                            </select>
                        </div>

                    </div>

                </div>

                {{ $startTubeNo }} - {{ $endTubeNo }}

            </div>

        </div>




    </div>












    <div class="card p-6">


        @foreach ($solutionSet as $solution)

            <p>{{ $solution["noOfSections"]  }}</p>

        @endforeach


    </div>





    <div class="p-0" id="myDiv" >

        <svg  id="svg">
        </svg>

    </div>





{{-- <svg width="400" height="400" viewBox="0 0 100 100" style="border: 1px solid black;">
  <line x1="0" y1="0" x2="100" y2="100" stroke="red" stroke-width="2" />
</svg>

<svg width="200" height="200" viewBox="0 0 100 100" preserveAspectRatio="none" style="border: 1px solid black;">
  <line x1="0" y1="0" x2="100" y2="100" stroke="blue" stroke-width="2" />
</svg> --}}








</section>