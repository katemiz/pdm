<section class="section container">







    <!-- TABLE: TUBE GEOMETRY AND PARAMS -->
    <div class="card my-4 has-text-centered" id="propsTable">
        <!-- tubestable.blade.php -->
    </div>


    {{-- CONFIGURATONS --}}

    <div id="configurations" class="card my-4 p-8">

        <table class="table is-fullwidth">

            <caption class="my-3  is-size-4 ">Mast Configurations By Section Number</caption>

            <thead>
              <tr>
                <th>Section Number</th>
                <th>Tube Diameters</th>
                <th class="has-text-right">Nested Height (mm)</th>
                <th class="has-text-right">Extended Height (mm)</th>
                <th class="has-text-right">Mast Sections Weight (kg)</th>
                <th class="has-text-right">Mast Tip Deflection (mm)</th>
              </tr>
            </thead>

            <tbody id="confBody">
                <!-- functions.js -->
                <!-- Content Populated by getMastConfigurations() -->
            </tbody>

        </table>
    </div>


    {{-- DEFLECTION PLOT --}}

    <div id="bm_deflection" class="card my-4 p-8">

        Deflections
    </div>






    <div class="modal" id="modal">
        <div class="modal-background" wire:click="toggleModal()"></div>
        <div class="modal-content box">
            <h1 class="title">Tube 1 Details</h1>
            <table class="table is-fullwidth">
                <tr>
                    <th>Area, mm<sup>2</sup></th>
                    <td class="has-text-right">4.634e+3<br>4633.849</td>
                </tr>
                <tr>
                    <th>Inertia, mm<sup>4</sup></th>
                    <td class="has-text-right">1.008e+8<br>100844142.433</td>
                </tr>
                <tr>
                    <th>Young Modulus, MPa</th>
                    <td class="has-text-right">7.000e+4<br>70000.000</td>
                </tr>
                <tr>
                    <th>EI, Nmm<sup>2</sup></th>
                    <td class="has-text-right">7.059e+12<br>7059089970276.968</td>
                </tr>
                <tr>
                    <th>M, Nm</th>
                    <td class="has-text-right">-1.500e+7<br>-15000000.000</td>
                </tr>
                <tr>
                    <th>M/EI (Bottom), m<sup>-1</sup></th>
                    <td class="has-text-right">-2.125e-6<br>-0.000</td>
                </tr>
                <tr>
                    <th>M/EI (Top), m<sup>-1</sup></th>
                    <td class="has-text-right">-1.813e-6<br>-0.000</td>
                </tr>
                <tr>
                    <th>Movement, mm</th>
                    <td class="has-text-right">0.000e+0<br>0.000</td>
                </tr>
            </table>
        </div>
        <button class="modal-close is-large" aria-label="close" wire:click="toggleModal"></button>
    </div>





</section>