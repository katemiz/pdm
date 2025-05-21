{{-- <section class="section container"> --}}

    {{-- <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
        <ul>
          <li><a href='/engineering/home'>Engineering</a></li>
          <li class="is-active"><a href="#" aria-current="page">Mast Nested/Extended Heights</a></li>
        </ul>
    </nav>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">No of Sections - Extended Height - Nested Height</h1>
        <h2 class="subtitle has-text-weight-light">Relationship between three parameters</h2>
    </header> --}}

    <div>

    <div class="card p-6">

        <div class="columns">

            {{-- <div class="column field is-half">
                <label class="label">Number of Sections</label>
                <div class="control">
                <input class="input" type="number" placeholder="Number of Sections" wire:model.live="noOfMTTubes" min="2"  max="15" step="1">
                </div>
            </div> --}}



            <div class="column field is-3">

                <label class="label">Top Tube Dia</label>
                {{-- <div class="control">
                    <input class="input" type="number" placeholder="Start Tube Number" wire:model.live="startTubeNo" min="1"  max="14" step="1">
                </div> --}}

                <div class="control">

                    <div class="select is-fullwidth" style="direction: rtl;">
                        <select wire:model="startTubeNo" >

                            @foreach ($tubeData as $tube)

                            <option value="{{ $tube["no"] }}">
                                {{ sprintf("%.2f",round($tube["od"],2)) }}
                            </option>

                            @endforeach

                        </select>
                    </div>

                </div>

            </div>


            <div class="column field is-3">
                <label class="label">Bottom Tube OD, mm</label>
                {{-- <div class="control">
                    <input class="input" type="number" placeholder="End Tube Number" wire:model.live="endTubeNo" min="2"  max="15" step="1">
                </div> --}}


                <div class="control">

                    <div class="select is-fullwidth" style="direction: rtl;">
                        <select wire:model="endTubeNo" >

                            @foreach ($tubeData as $tube)

                            <option value="{{ $tube["no"] }}">
                                {{ sprintf("%.2f",round($tube["od"],2)) }}
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


          <div class="column field is-3">
              <label class="label">X-Offset (mm) <a>?</a></label>
              <div class="control">
                <input class="input" type="number" placeholder="Payload X-Offset Distance" wire:model.live="xOffset" min="50"  max="3000" step="10">
              </div>
          </div>

          <div class="column field is-3">
              <label class="label">Z-Offset (mm)</label>
              <div class="control">
                <input class="input" type="number" placeholder="Payload Z-Offset Distance" wire:model.live="zOffset" min="0"  max="600" step="1">
              </div>
          </div>

          <div class="column field is-3">
            <label class="label">Start Tube Number</label>
            <div class="control">
                <input class="input" type="number" placeholder="Start Tube Number" wire:model.live="startTubeNo" min="1"  max="14" step="1">
          </div>

          </div>


          <div class="column field is-3">
            <label class="label">End Tube Number</label>
            <div class="control">
                <input class="input" type="number" placeholder="End Tube Number" wire:model.live="endTubeNo" min="2"  max="15" step="1">
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

{{-- </section> --}}