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

                <table class="table is-fullwidth">

                    <tbody>

                        <tr>
                            <th class="has-text-left font-bold">Material</th>
                            <td class="has-text-right">Aluminum</td>
                        </tr>

                        <tr>
                            <th class="has-text-left font-bold">Yield Strength</th>
                            <td class="has-text-right">{{ $yieldStrength }} MPa</td>
                        </tr>

                        <tr>
                            <th class="has-text-left font-bold">Tensile Strength</th>
                            <td class="has-text-right">{{ $ultimateStrength }} MPa</td>
                        </tr>

                        <tr>
                            <th class="has-text-left font-bold">Modulus of Elasticity</th>
                            <td class="has-text-right">{{ $E }} MPa</td>
                        </tr>

                        <tr>
                            <th class="has-text-left font-bold">Density</th>
                            <td class="has-text-right">{{ $materialDensity }} g/cm<sup>3</sup></td>
                        </tr>

                    </tbody>
                  </table>

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