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