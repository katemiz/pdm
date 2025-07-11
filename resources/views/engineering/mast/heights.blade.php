<div>

    <div class="card p-6">





     @if ($error)
         <div class="notification is-danger">
             {{ $error }}
         </div>

        @else 

               <h1 class="title">Mast and Operational Parameters - [ {{$noOfActiveTubes}} Sections ]</h1>

     @endif


        <div class="columns">

            <div class="column field is-3">

                <label class="label">Top Tube Dia</label>

                <div class="control">

                    <div class="select is-fullwidth">
                        <select wire:model.live="startTubeNo" >

                            @foreach ($tubeData as $tube)

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


            <div class="column field is-3">
                <label class="label">Bottom Tube OD, mm</label>


                <div class="control">

                    <div class="select is-fullwidth" >
                        <select wire:model.live="endTubeNo" >

                            @foreach ($tubeData as $tube)

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


            <div class="column field is-6">
                <label class="label">Length of Sections (mm)</label>
                <div class="control">
                <input class="input" type="number" placeholder="Tube Lengths" wire:model.live="lengthMTTubes" min="500"  max="10000" step="50">
                </div>
            </div>

        </div>


        <div class="columns">

            <div class="column field is-half">
                <label class="label">Overlap Length (mm)</label>
                <div class="control">
                <input class="input" type="number" placeholder="Overlap Length" wire:model.live="overlapMTTubes" min="50"  max="3000" step="10">
                </div>
            </div>


            <div class="column field">
                <label class="label">Head Distance (mm)</label>
                <div class="control">
                <input class="input" type="number" placeholder="Head Distance" wire:model.live="headMTTubes" min="0"  max="600" step="1">
                </div>
            </div>

        </div>



       @if ($action == 'deflection')

        <div class="columns">

          <div class="column field is-4">
              <label class="label">X-Offset (mm) <a wire:click="toggleHelpModal('mparams')">?</a></label>
              <div class="control">
                <input class="input" type="number" placeholder="Payload X-Offset Distance" wire:model.live="xOffset" min="50"  max="3000" step="10">
              </div>
          </div>

          <div class="column field is-4">
              <label class="label">Z-Offset (mm) <a wire:click="toggleHelpModal('mparams')">?</a></label>
              <div class="control">
                <input class="input" type="number" placeholder="Payload Z-Offset Distance" wire:model.live="zOffset" min="0"  max="600" step="1">
              </div>
          </div>

          <div class="column field is-4">
              <label class="label">Terrain Category <a wire:click="toggleHelpModal('terrain')">?</a></label>

                <div class="control">

                    <div class="select is-fullwidth">
                        <select wire:model.live="activeTerrainCategory" >

                            @foreach ($terrainCategory as $key => $terrain)

                            <option value="{{ $key }}">{{ $terrain["no"] }}</option>

                            @endforeach

                        </select>
                    </div>

                </div>

          </div>




        </div>



        <div class="columns">


          <div class="column field is-4">
              <label class="label">Wind Speed (km/h) </label>
              <div class="control">
                <input class="input" type="number" placeholder="Wind Speed" wire:model.live="windspeed" min="40"  max="200" step="1">
              </div>
          </div>


          <div class="column field is-4">
              <label class="label">Sail Area (m<sup>2</sup>)</label>
              <div class="control">
              <input class="input" type="number" placeholder="Sail Area" wire:model.live="sailarea" min="0.1"  max="15" step="0.1">
              </div>
          </div>


          <div class="column field is-4">
              <label class="label">Payload Mass (kg)</label>
              <div class="control">
              <input class="input" type="number" placeholder="Payload Mass" wire:model.live="payloadMass" min="0"  max="1000" step="1">
              </div>
          </div>


        </div>
































      @endif

      </div>




    </div>


    <div class="card has-background-white py-3 my-2">

        <nav class="level">
            <div class="level-item has-text-centered">
              <div>
                <p class="heading">Extended Height</p>
                <p class="title" >{{ $extendedHeight }}</p>
                <p class="heading">mm</p>

              </div>
            </div>
            <div class="level-item has-text-centered">
              <div>
                <p class="heading">Nested Height</p>
                <p class="title" >{{ $nestedHeight }}</p>
                <p class="heading">mm</p>

              </div>
            </div>

          </nav>
    </div>






</div>

