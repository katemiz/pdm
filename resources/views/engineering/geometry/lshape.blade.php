<section class="section container">


<nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
    <ul>
      <li><a href="/engineering/home">Engineering</a></li>
      <li><a href="/engineering/geometry">Geometry</a></li>
      <li class="is-active"><a href="#" aria-current="page">L-Shaped Sections</a></li>
    </ul>
</nav>

<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">L-Shaped Sections</h1>
    <h2 class="subtitle has-text-weight-light">Area and Area Inertia Calculations for Rectangular Sections</h2>
</header>

<div class="columns">

    @livewire('canvas-lshape', [
        'lshape_width' => "$lshape_width",
        'lshape_height' => "$lshape_height",
        "lshape_thk1"=>"$lshape_thk1",
        "lshape_thk2"=>"$lshape_thk2",
        "lshape_radius" => "$lshape_radius",
        "area" => "$area",
        "cx" => "cx",
        "cy" => "cy"], key(1234))


    <div class="column">



        <div class="field ">
            <div class="field-body">

                <div class="field">
                    <label class="label">Width</label>
                    <div class="control">
                    <input class="input" type="number" placeholder="Width of Shape" wire:model.live="lshape_width">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Height</label>
                    <div class="control">
                    <input class="input" type="number" placeholder="Height of Shape" wire:model.live="lshape_height">
                    </div>
                </div>

            </div>
        </div>


        <div class="field ">
            <div class="field-body">

                    <div class="field">
                        <label class="label">Thickness 1, thk</label>
                        <div class="control">
                        <input class="input" type="number" placeholder="Thickness" wire:model.live="lshape_thk1" min="0">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Thickness 2, thk</label>
                        <div class="control">
                        <input class="input" type="number" placeholder="Thickness" wire:model.live="lshape_thk2" min="0">
                        </div>
                    </div>

                    {{-- <div class="field">
                        <label class="label">Radius, R</label>
                        <div class="control">
                        <input class="input" type="number" placeholder="Height of Section" wire:model.live="rinn" min="0">
                        </div>
                    </div> --}}
            </div>
        </div>



        <table class="table is-fullwidth">
            <tbody><tr>
                <th>Area</th>
                <td class="has-text-right">{{ number_format($area, 2, '.', ' ') }}</td>
                <td>mm<sup>2</sup></td>
            </tr>

            <tr>
                <th>Inertia<sub>xx</sub></th>
                <td class="has-text-right">{{ number_format($ixx, 2, '.', ' ') }}</td>
                <td>mm<sup>4</sup></td>

            </tr>

            <tr>
                <th>Inertia<sub>yy</sub></th>
                <td class="has-text-right">{{ number_format($iyy, 2, '.', ' ') }}</td>
                <td>mm<sup>4</sup></td>
            </tr>

        </tbody></table>

    </div>

</div>

</section>
