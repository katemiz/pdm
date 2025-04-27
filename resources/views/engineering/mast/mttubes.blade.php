<section class="section container">

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





    <div class="columns">

        <div class="column is-1/3">
            <div class="card">

                <div class="card-content">
                  <div class="media">

                    <div class="media-content">
                      <p class="title is-4">Material</p>
                    </div>
                  </div>

                  <div class="content">


                    <ol>
                        <li>Material: Aluminium</li>
                        <li>Yield Strength: {{ $yieldStrength }} MPa</li>
                        <li>Tensile Strength: {{ $ultimateStrength }} MPa</li>
                        <li>Modulus of Elasticity: {{ $E }} MPa</li>
                        <li>Density: {{ $materialDensity }} g/cm<sup>3</sup></li>
                    </ol>

                  </div>
                </div>
              </div>
        </div>





        <div class="column is-1/3">
            <div class="card">

                <div class="card-content">
                  <div class="media">

                    <div class="media-content">
                      <p class="title is-4">(1) Pneumatic Lift Capacity</p>
                    </div>
                  </div>

                  <div class="content">


                    <ol>
                        <li>{{ $pressure }} Bars is used to calculate lift capacity</li>
                        <li>For other values<a href="/engineering/mast/pneumatic"> click here</a></li>
                    </ol>

                  </div>
                </div>
              </div>
        </div>



        <div class="column is-1/3">
            <div class="card">

                <div class="card-content">
                  <div class="media">

                    <div class="media-content">
                      <p class="title is-4">(2) Critical Load</p>
                    </div>
                  </div>

                  <div class="content">

                    <p>Critical load is calculated using Euler Formula with a Factor of Safety of {{ $factorOfSafety }}</p>
                    <p>P<sub>cr</sub>=π<sup>2</sup>EI/4L<sup>2</sup></p>

                    <p>* L is taken as {{ $tubeBucklingLength }} mm</p>


                  </div>
                </div>
              </div>
        </div>




    </div>








    <table class="table is-fullwidth my-6">


        <thead>
            <tr><th class="has-text-left font-bold">#</th>
            <th class="has-text-right">OD</th>
            <th class="has-text-right">ID</th>
            <th class="has-text-right">THK</th>
            <th class="has-text-right">Mass</th>
            <th class="has-text-right">Moment<br>Capacity</th>
            <th class="has-text-centered has-background-white-ter" colspan="2">Pneumatic<br>Load Capacity<sup>(1)</sup>
                <br><br>

                <a class="" wire:click='decreasePressure'>
                    <i class="icon "><x-carbon-chevron-down /></i>
                </a>

                <span class="tag is-info">{{ $pressure }} Bars</span>
                <a class="" wire:click='increasePressure'>
                    <i class="icon "><x-carbon-chevron-up /></i>
                </a>

            </th>
            <th class="has-text-centered">P<sub>cr</sub><sup>(2)</sup>

                <br><br>

                <a class="" wire:click='decreaseBucklingLength'>
                    <i class="icon "><x-carbon-chevron-down /></i>
                </a>

                <span class="tag is-info">{{ $tubeBucklingLength }} mm</span>
                <a class="" wire:click='increaseBucklingLength'>
                    <i class="icon "><x-carbon-chevron-up /></i>
                </a>

            </th>



        </tr></thead>


        <tbody id="tableBody">

            @foreach ($tubeData as $i => $tube)


                <tr>
                    <th><a wire:click="GetMore({{ $i }})" >MT-{{ sprintf("%02d",$i) }}</a></th>
                    <td class="has-text-right">{{ sprintf("%.2f",round($tube["od"],2)) }} mm</td>
                    <td class="has-text-right">{{ sprintf("%.2f",round($tube["id"],2)) }} mm</td>
                    <td class="has-text-right">{{ sprintf("%.2f",round($tube["thk"],2)) }} mm</td>
                    <td class="has-text-right">{{ round($tube["mass"],1) }} kg/m</td>
                    <td class="has-text-right">{{ round($tube["moment"],0) }} Nm</td>
                    <td class="has-text-right has-background-white-ter">{{ round($tube["pressureLoad"],0) }} N</td>
                    <td class="has-text-right has-background-white-ter">{{ round($tube["pressureLoad"] / 9.81, 0) }} kg</td>
                    <td class="has-text-right">{{ round($tube["criticalLoad"],0) }} N</td>
                </tr>


            @endforeach


    </table>













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










</section>
