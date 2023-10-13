<section class="section container">

    <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
        <ul>
          <li><a href='/engineering/home'>Engineering</a></li>
          <li><a href='/engineering/geometry'>Geometry</a></li>
          <li class="is-active"><a href="#" aria-current="page">Circular/Hollow Sections</a></li>
        </ul>
    </nav>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">Circular/Hollow Sections</h1>
        <h2 class="subtitle has-text-weight-light">Area and Area Inertia Calculations for Circular/Hollow Sections</h2>
    </header>







    <div class="columns">

        <div class="column is-4">
            <figure class="image is-fluid">
                @if ($is_hollow)
                    <img src="{{ asset('/images/CircleHollow.svg') }}">
                @else
                    <img src="{{ asset('/images/CircleSolid.svg') }}">
                @endif
            </figure>

            <footer class="card-footer">
                <a wire:click="$toggle('is_hollow')" class="card-footer-item">Solid Section</a>
                <a wire:click="$toggle('is_hollow')" class="card-footer-item">Hollow Section</a>
            </footer>
        </div>
        <div class="column">

            <div class="field ">
                <div class="field-body">
                    <div class="field">
                        <label class="label">Outside Diameter, OD</label>
                        <div class="control">
                        <input class="input" type="number" placeholder="Outside diameter" wire:model.live="odia">
                        </div>
                    </div>

                    @if ($is_hollow)
                    <div class="field">
                        <label class="label">Inside Diameter, ID</label>
                        <div class="control">
                        <input class="input" type="number" placeholder="Inside diameter" wire:model.live="idia">
                        </div>
                    </div>
                    @endif
                </div>
            </div>


            <table class="table is-fullwidth">
                <tr>
                    <th>Area</th>
                    <td class="has-text-right">{{ $area }}</td>
                    <td>mm<sup>2</sup></td>
                </tr>

                <tr>
                    <th>Inertia</th>
                    <td class="has-text-right">{{ $inertia_xx }}</td>
                    <td>mm<sup>4</sup></td>
                </tr>

            </table>



        </div>

    </div>











</section>
