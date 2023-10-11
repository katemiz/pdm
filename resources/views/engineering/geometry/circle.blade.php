<section class="section container">

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">Circular/Hollow Sections</h1>
        <h2 class="subtitle has-text-weight-light">Area and Area Inertia Calculations for Circular/Hollow Sections</h2>
    </header>


    <nav class="breadcrumb has-bullet-separator my-5" aria-label="breadcrumbs">
        <ul>
          <li><a href='/engineering/home'>Engineering</a></li>
          <li><a href='/engineering/geometry'>Geometry</a></li>
          <li class="is-active"><a href="#" aria-current="page">Circular/Hollow Sections</a></li>
        </ul>
    </nav>




    <div class="columns">

        <div class="column is-4">
            <figure class="image is-fluid">
                <img src="{{ asset('/images/HollowCircle.png') }}">
            </figure>
        </div>
        <div class="column">

            <div class="field ">
                <div class="field-body">
                    <div class="field">
                        <label class="label">Outside Diameter, OD</label>
                        <div class="control">
                        <input class="input" type="text" placeholder="Outside diameter" wire:model.live="odia">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Inside Diameter, ID</label>
                        <div class="control">
                        <input class="input" type="text" wire:model.live="idia" placeholder="Inside diameter">
                        </div>
                    </div>
                </div>
            </div>


            <table class="table is-fullwidth">
                <tr>
                    <th>Area</th>
                    <td>{{ $area }}</td>
                    <td>mm<sup>2</sup></td>
                </tr>

                <tr>
                    <th>Inertia</th>
                    <td>{{ $inertia_xx }}</td>
                    <td>mm<sup>4</sup></td>
                </tr>

            </table>



        </div>

    </div>











</section>
