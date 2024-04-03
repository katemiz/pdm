<section class="section container">

    <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
        <ul>
          <li><a href='/engineering/home'>Engineering</a></li>
          <li><a href='/engineering/geometry'>Geometry</a></li>
          <li class="is-active"><a href="#" aria-current="page">Rectangular Sections</a></li>
        </ul>
    </nav>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">Rectangular Sections</h1>
        <h2 class="subtitle has-text-weight-light">Area and Area Inertia Calculations for Rectangular Sections</h2>
    </header>

    <div class="columns">

        <div class="column is-4">
            <figure class="image is-fluid">
                @if ($is_hollow)
                    <img src="{{ asset('/images/RectangleHollow.svg') }}">
                @else
                    <img src="{{ asset('/images/RectangleSolid.svg') }}">
                @endif
            </figure>

            <footer class="card-footer">
                <a wire:click="$toggle('is_hollow')" class="card-footer-item">{{ $is_hollow ? 'Solid Section' : 'Hollow Section'}}</a>
                {{-- <a wire:click="$toggle('is_hollow')" class="card-footer-item">Hollow Section</a> --}}
            </footer>
        </div>
        
        <div class="column">

            <div class="field ">
                <div class="field-body">
                    <div class="field">
                        <label class="label">Width, w</label>
                        <div class="control">
                        <input class="input" type="number" placeholder="Outside diameter" wire:model.live="width">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Height, h</label>
                        <div class="control">
                        <input class="input" type="number" wire:model.live="height" placeholder="Height of Section">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ $is_hollow ? 'Outer' : '' }} Radius, R<sub>out</sub></label>
                        <div class="control">
                        <input class="input" type="number" placeholder="Outside diameter" wire:model.live="rout" min="0">
                        </div>
                    </div>
                </div>
            </div>


            <div class="field ">
                <div class="field-body">

                    @if ($is_hollow)

                        <div class="field">
                            <label class="label">Thickness, thk</label>
                            <div class="control">
                            <input class="input" type="number" placeholder="Thickness" wire:model.live="thickness" min="0">
                            </div>
                        </div>

                    @endif

                    @if ($is_hollow)
                        <div class="field">
                            <label class="label">Inner Radius, R<sub>inn</sub></label>
                            <div class="control">
                            <input class="input" type="number" placeholder="Height of Section" wire:model.live="rinn" min="0">
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
                    <th>Inertia<sub>xx</sub></th>
                    <td class="has-text-right">{{ $inertia_xx }}</td>
                    <td>mm<sup>4</sup></td>
                </tr>

                <tr>
                    <th>Inertia<sub>yy</sub></th>
                    <td class="has-text-right">{{ $inertia_yy }}</td>
                    <td>mm<sup>4</sup></td>
                </tr>

            </table>

        </div>

    </div>

</section>
