<div>




    <div class="columns">

        <div class="column is-3"></div>

        <div class="column is-half">
            <figure class="image mb-4 p-8">
                <img src="{{ asset('/images/fpayload.png') }}" />
            </figure>
        </div>

        <div class="column is-3"></div>


      </div>





    <div class="card p-6">

        <div class="columns">

            <div class="column field is-half">
                <label class="label">Wind Speed (kph)</label>
                <div class="control">
                <input class="input" type="number" placeholder="Wind Speed" wire:model.live="windspeed" min="50"  max="200" step="1">
                </div>
            </div>


            <div class="column field">
                <label class="label">Sail Area (m<sup>2</sup>)</label>
                <div class="control">
                <input class="input" type="number" placeholder="Sail Area" wire:model.live="sailarea" min="0.3"  max="10" step="0.1">
                </div>
            </div>

        </div>


        <div class="columns">


            <div class="column field is-half">
                <label class="label">Drag Coefficient</label>
                <div class="control">
                <input class="input" type="number" placeholder="Drag Coefficient" wire:model.live="cd" min="1"  max="2" step="0.05">
                </div>
            </div>


            <div class="column field">
                <label class="label">Air density (kg/m<sup>3</sup>)</label>
                <div class="control">
                <input class="input" type="text" placeholder="Air density" wire:model.live="airdensity" readonly>
                </div>
            </div>

        </div>

    </div>


    <div class="card has-background-grey-lighter p-6">

        <nav class="level">
            <div class="level-item has-text-centered">
              <div>
                <p class="heading">Wind Force on Payload</p>
                <p class="title" >{{ round($windload,0) }} N</p>
                {{-- <p class="heading">N</p> --}}
              </div>
            </div>
        </nav>

    </div>

</div>