<section class="section container">

    <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
        <ul>
          <li><a href='/engineering/home'>Engineering</a></li>
          <li class="is-active"><a href="#" aria-current="page">Pneumatic Capacity Calculation</a></li>
        </ul>
    </nav>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">Mast Design Parameters</h1>
        <h2 class="subtitle has-text-weight-light">Pneumatic Capacity Calculation for Pressure Activated Masts</h2>
    </header>




    <div class="columns">

        <div class="column is-half">

            <figure class="image ">
                <img src="{{ asset('/images/PressureFigure.svg') }}" />
            </figure>

        </div>


        <div class="column">

            <div class="field">
                <label class="label">d, Diameter of Tube End (mm)</label>
                <div class="control">
                  <input class="input" type="text" placeholder="Outer Diameter of Tube" id="dia" wire:model.live="tubeOd" >
                </div>
            </div>


            <div class="field">
                <label class="label">p<sub>i</sub>, Internal Pressure, (bar)</label>
                <div class="control">
                  <input class="input" type="text" placeholder="Inner Pressure in Bar" id="pi" wire:model.live="pressure">
                </div>



                <table class="table is-fullwidth my-6">
                    <tr>
                        <th>Pressure</th>
                        <td class="has-text-right" id="pi_mpa">{{ round($pressureMPa,1) }}</td>
                        <th>MPa</th>
                    </tr>
                    <tr>
                        <th>Pressure</th>
                        <td class="has-text-right"  id="pi_psi">{{ round($pressurePsi,1) }}</td>
                        <th>psi</th>
                    </tr>


                    <tr>
                        <th>Area</th>
                        <td class="has-text-right"  id="a">{{ round($tubePressureArea,1) }}</td>
                        <th>mm<sup>2</sup></th>
                    </tr>
                </table>


                <nav class="level mt-6">

                    <div class="level-item has-text-centered">
                      <div>
                        <p class="heading">Total Force, F (N/kg)</p>
                        <p class="title" id="fN">{{ round($pressureLoadInN,0) }} / {{ round($pressureLoadInKg,0) }}</p>
                      </div>
                    </div>


                </nav>



            </div>


        </div>


    </div>













</section>
