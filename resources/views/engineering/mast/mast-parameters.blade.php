<div class="column p-4">

    @if ($error)
        <div class="notification is-danger">{{ $error }}</div>
    @else
        <h1 class="title">[ {{$noOfActiveTubes}} Sections ]</h1>
    @endif


    <div class="fixed-grid has-4-cols">

        <div class="grid">

            <div class="cell my-2">
                <label class="label">Top Tube Dia<br>[mm]</label>

                <div class="control">

                    <div class="select is-fullwidth">
                        <select wire:model.live="startTubeNo">

                            @foreach ($allTubes as $tube)

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

            <div class="cell my-2">
                <label class="label">Bottom Tube OD<br>[mm]</label>

                <div class="control">

                    <div class="select is-fullwidth">
                        <select wire:model.live="endTubeNo">

                            @foreach ($allTubes as $tube)

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

            <div class="cell my-2">
                <label class="label">Length of Sections<br>[mm]</label>
                <div class="control">
                    <input class="input" type="number" placeholder="Tube Lengths" wire:model.live="lengthMTTubes"
                        min="500" max="10000" step="50">
                </div>
            </div>

            <div class="cell my-2">
                <label class="label">Overlap Length<br>[mm]</label>
                <div class="control">
                    <input class="input" type="number" placeholder="Overlap Length" wire:model.live="overlapMTTubes"
                        min="50" max="3000" step="10">
                </div>
            </div>

            <div class="cell my-2">
                <label class="label">Head Distance<br>[mm]</label>
                <div class="control">
                    <input class="input" type="number" placeholder="Head Distance" wire:model.live="headMTTubes" min="0"
                        max="600" step="1">
                </div>
            </div>

            <div class="cell my-2">
                <label class="label">X-Offset <a wire:click="toggleHelpModal('mparams')">?</a><br>[mm] </label>
                <div class="control">
                    <input class="input" type="number" placeholder="Payload X-Offset Distance" wire:model.live="xOffset"
                        min="50" max="3000" step="10">
                </div>
            </div>

            <div class="cell my-2">
                <label class="label">Z-Offset <a wire:click="toggleHelpModal('mparams')">?</a><br>[mm]</label>
                <div class="control">
                    <input class="input" type="number" placeholder="Payload Z-Offset Distance" wire:model.live="zOffset"
                        min="0" max="600" step="1">
                </div>
            </div>

            <div class="cell my-2">
                <label class="label">Terrain Category<br><a wire:click="toggleHelpModal('terrain')">?</a></label>

                <div class="control">

                    <div class="select is-fullwidth">
                        <select wire:model.live="activeTerrainCategory">

                            @foreach ($terrainCategory as $key => $terrain)

                                <option value="{{ $key }}">{{ $terrain["no"] }}</option>

                            @endforeach

                        </select>
                    </div>

                </div>

            </div>

            <div class="cell my-2">
                <label class="label">Wind Speed<br>[km/h] </label>
                <div class="control">
                    <input class="input" type="number" placeholder="Wind Speed" wire:model.live="windspeed" min="40"
                        max="200" step="1">
                </div>
            </div>

            <div class="cell my-2">
                <label class="label">Sail Area<br>[m<sup>2</sup>]</label>
                <div class="control">
                    <input class="input" type="number" placeholder="Sail Area" wire:model.live="sailarea" min="0.1"
                        max="15" step="0.1">
                </div>
            </div>

            <div class="cell my-2">
                <label class="label">Payload Mass<br>[kg]</label>
                <div class="control">
                    <input class="input" type="number" placeholder="Payload Mass" wire:model.live="payloadMass" min="0"
                        max="1000" step="1">
                </div>
            </div>

            <div class="cell my-2">

                <label class="label">Payload Adapter<br>Thickness [mm]</label>
                <div class="control">
                    <input class="input" type="number" placeholder="Head Dimension" wire:model.live="topAdapterThk"
                        step="1">
                </div>
            </div>

            <div class="cell my-2">

                <label class="label">Base Support<br>Thickness [mm]</label>
                <div class="control">
                    <input class="input" type="number" placeholder="Head Dimension" wire:model.live="baseAdapterThk"
                        step="1">
                </div>
            </div>



            <div class="cell my-2">

                <label class="label">Maximum Payload<br>Capacity [kg]</label>
                <div class="control">
                    <input class="input" type="number" placeholder="Head Dimension" wire:model.live="maxPayloadCapacity"
                        step="1">
                </div>
            </div>




        </div>

    </div>



    <div class="card has-background-white-ter py-3 my-2">

        <nav class="level">

            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Extended Height</p>
                    <p class="title">{{ $extendedHeight }}</p>
                    <p class="heading">mm</p>
                </div>
            </div>

            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Nested Height</p>
                    <p class="title">{{ $nestedHeight }}</p>
                    <p class="heading">mm</p>
                </div>
            </div>



            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Wind Load on Payload</p>
                    <p class="title">{{ round($windLoadOnPayload, 0) }}</p>
                    <p class="heading">N</p>
                </div>
            </div>


            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Mast Tubes Weight</p>
                    <p class="title">{{ round($mastWeight, 0) }}</p>
                    <p class="heading">kg</p>
                </div>
            </div>


        </nav>
    </div>






</div>