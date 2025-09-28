<section class="section container">

    <script src="{{ asset(path: '/js/svgClass.js') }}"></script>

    <script>

        document.addEventListener('drawSvg', event => {

            const solutionSet = event.detail[0].solutionSet;
            const solutionTubeData = event.detail[0].solutionTubeData;
            const currentSolution = event.detail[0].currentSolution;
            const svgType = event.detail[0].svgType;
            const adapters = event.detail[0].adapters

            if (document.getElementById('svg')) {
                document.getElementById('svg').remove()
            }

            let p = new svgClass(solutionSet, solutionTubeData, currentSolution, svgType, adapters);

            p.run()
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
                            wire:model.live="targetExtendedHeightMax" step="0.1">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Minimum [m]</label>
                    <div class="control">
                        <input class="input" type="number" placeholder="Target Nested Height"
                            wire:model.live="targetExtendedHeightMin" step="0.1">
                    </div>
                </div>

            </div>

            <div class="column field is-half">

                <span class="tag is-large is-warning">Target Nested Height</span>
                <div class="field mt-4">

                    <label class="label">Maximum [m]</label>
                    <div class="control">
                        <input class="input" type="number" placeholder="Maximum Nested Height"
                            wire:model.live="targetNestedHeightMax" step="0.01">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Minimum [m]</label>
                    <div class="control">
                        <input class="input" type="number" placeholder="Minimum Nested Height"
                            wire:model.live="targetNestedHeightMin" step="0.01">
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
                                wire:model.live="topAdapterThk" step="1">
                        </div>
                    </div>
                </div>


                <div class="cell">

                    <div class="field mt-4">

                        <label class="label">Base Support Thickness [mm]</label>
                        <div class="control">
                            <input class="input" type="number" placeholder="Head Dimension"
                                wire:model.live="baseAdapterThk" step="1">
                        </div>
                    </div>
                </div>

            </div>


            <div class="grid">

                <div class="cell field ">

                    <label class="label">Top Tube Dia</label>

                    <div class="control">

                        <div class="select is-fullwidth">
                            <select wire:model.live="startTubeNo">

                                @foreach ($mtProfiles as $tube)

                                    <option value="{{ $tube["no"] }}">
                                        MT-{{ sprintf("%02d", $tube["no"]) }}
                                        &nbsp; &nbsp;&nbsp;&nbsp; &#8960;
                                        {{ sprintf("%6.2f", round($tube["od"], 2)) }}
                                    </option>

                                @endforeach

                            </select>
                        </div>

                    </div>

                </div>


                <div class="cell field ">
                    <label class="label">Bottom Tube OD, mm</label>

                    <div class="control">

                        <div class="select is-fullwidth">
                            <select wire:model.live="endTubeNo">

                                @foreach ($mtProfiles as $tube)

                                    <option value="{{ $tube["no"] }}">
                                        MT-{{ sprintf("%02d", $tube["no"]) }}
                                        &nbsp; &nbsp;&nbsp;&nbsp; &#8960;
                                        {{ sprintf("%6.2f", round($tube["od"], 2)) }}
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

        <header class="mb-6">
            <h2 class="subtitle has-text-weight-light">Possible Solutions</h2>
        </header>

        <div class="fixed-grid has-5-cols">
            <div class="grid">
                @foreach ($solutionSet as $k => $solution)




                    <div class="cell card field is-grouped is-grouped-multiline {{ $currentSolution === $k ? ' has-background-success-light' : 'has-background-warning-light' }}"
                        wire:click="setCurrentSolution({{ $k }})" style="cursor: pointer;">
                        <div class="control">
                            <div class="tags has-addons">
                                <span class="tag is-dark">Sections</span>
                                <span class="tag is-info">{{ $solution["noOfSections"]  }}</span>
                            </div>
                        </div>

                        <div class="control">
                            <div class="tags has-addons">
                                <span class="tag is-dark">Extended</span>
                                <span class="tag is-success">{{ $solution["extendedHeight"]  }}</span>
                            </div>
                        </div>

                        <div class="control">
                            <div class="tags has-addons">
                                <span class="tag is-dark">Nested</span>
                                <span class="tag is-primary">{{ $solution["nestedHeight"]  }}</span>
                            </div>
                        </div>

                        <div class="tags has-addons">
                            <span class="tag">Tube</span>
                            <span class="tag is-primary">{{ $solution["tubeLength"]  }}</span>
                        </div>
                    </div>




                @endforeach
            </div>
        </div>

    </div>


    <div class="tabs">
        <ul>
            <li class="{{$svgType === 'Extended' ? ' is-active' : ''}}">
                <a wire:click="toggleMastPosition('Extended')">Extended Position</a>
            </li>
            <li class="{{$svgType === 'Nested' ? ' is-active' : ''}}">
                <a wire:click="toggleMastPosition('Nested')">Nested Position</a>
            </li>
        </ul>
    </div>







    <div class="p-0" id="svgDiv" wire:ignore>

        <header class="mb-6">
            <h1 class="title has-text-weight-light is-size-1">{{ $svgType }} Position</h1>
        </header>

        {{-- svg to be added dynamically here --}}

    </div>













</section>