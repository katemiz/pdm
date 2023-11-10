<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">End Products</h1>
    <h2 class="subtitle has-text-weight-light">View End Product Properties</h2>
</header>

@if (session()->has('message'))
    <div class="notification">
        {{ session('message') }}
    </div>
@endif

<div class="card">

    <div class="card-content">

        <nav class="level mb-6">
            <!-- Left side -->
            <div class="level-left">

                <p class="level-item">
                    <a href="/endproducts/list">
                        <span class="icon is-small"><x-carbon-table /></span>
                        <span>List All</span>
                    </a>
                </p>

                <p class="level-item">
                    <a href="/endproducts/form/">
                        <span class="icon is-small"><x-carbon-add /></span>
                        <span>Add</span>
                    </a>
                </p>

            </div>

            <!-- Right side -->
            <div class="level-right">

                @role(['admin','company_admin','requirement_engineer'])

                @if ($status == 'Frozen')

                    @if ($is_latest)
                    <p class="level-item">
                        <a wire:click='reviseConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-version /></span>
                            <span>Revise</span>
                        </a>
                    </p>
                    @endif

                @else

                    <p class="level-item">
                        <a href='/endproducts/form/{{ $uid }}'>
                            <span class="icon"><x-carbon-edit /></span>
                        </a>
                    </p>

                    <p class="level-item">
                        <a wire:click='freezeConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-stamp /></span>
                        </a>
                    </p>

                    <p class="level-item">
                        <a wire:click="triggerDelete('requirement',{{ $uid }})">
                            <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                        </a>
                    </p>
                @endif


                @endrole

            </div>
        </nav>

        <div class="column">
            <div class="columns">

                <div class="column is-8">
                    <p class="title has-text-weight-light is-size-2">{{$part_number}}-{{$version}}</p>
                    <p class="subtitle has-text-weight-light is-size-6"><strong>{{$nomenclature}}</strong></p>

                    {{-- @if (count($all_revs) > 1)
                    <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
                        <ul>
                        @foreach ($all_revs as $key => $revId)
                            @if ($key != $revision)
                            <li><a href="/requirements/view/{{$revId}}">R{{$key}}</a></li>
                            @endif
                        @endforeach
                        </ul>
                    </nav>
                    @endif --}}
                </div>

                <div class="column has-text-right is-4">


                    <table class="table is-fullwidth">
                        <tr>
                            <th>End Product Type</th>
                            <td>{{ !empty($product_type) ? $product_types[$product_type] : ''}}</td>
                        </tr>
                        <tr>
                            <th>Drive Type</th>
                            <td>{{ !empty($drive_type) ? $drive_types[$drive_type] : ''}}</td>
                        </tr>
                        <tr>
                            <th>Mast Family</th>
                            <td>{{$mast_family_mt}} / {{$mast_family_wb}}</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>


        <div class="column">

            <table class="table is-fullwidth">
                <thead>

                    <tr>
                        <th>Maximum Payload Capacity</th>
                        <td class="has-text-right">{{ $max_payload_kg }}</td>
                        <td class="is-narrow">kg</td>
                        <td class="has-text-right">{{ round($max_payload_kg*2.20462,0) }}</td>
                        <td class="is-narrow">lb</td>
                    </tr>

                    <tr>
                        <th>Extended Height</th>
                        <td class="has-text-right">{{ $extended_height_mm }}</td>
                        <td class="is-narrow">mm</td>
                        <td class="has-text-right">{{ round($extended_height_mm/25.4,1) }}</td>
                        <td class="is-narrow">in</td>
                    </tr>

                    <tr>
                        <th>Nested Height</th>
                        <td class="has-text-right">{{ $nested_height_mm }}</td>
                        <td class="is-narrow">mm</td>
                        <td class="has-text-right">{{ round($nested_height_mm/25.4,1) }}</td>
                        <td class="is-narrow">in</td>
                    </tr>

                    <tr>
                        <th>Weight</th>
                        <td class="has-text-right">{{ $product_weight_kg }}</td>
                        <td>kg</td>
                        <td class="has-text-right">{{ round($product_weight_kg*2.20462,0) }}</td>
                        <td>lb</td>
                    </tr>

                    <tr>
                        <th>Maximum Operational Wind Speed</th>
                        <td class="has-text-right">{{ $max_operational_wind_speed }}</td>
                        <td>km/h</td>
                        <td class="has-text-right">{{ round($max_operational_wind_speed*0.5399570136727677,0) }}</td>
                        <td>knots</td>
                    </tr>

                    <tr>
                        <th>Maximum Survival Wind Speed</th>
                        <td class="has-text-right">{{ $max_survival_wind_speed }}</td>
                        <td>km/h</td>
                        <td class="has-text-right">{{ round($max_survival_wind_speed*0.5399570136727677,0) }}</td>
                        <td>knots</td>
                    </tr>

                    <tr>
                        <th>Has Locking ?</th>
                        <td class="has-text-right">{{ $has_locking ? 'Yes' : 'No' }}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <th>Design Sail Area</th>
                        <td class="has-text-right">{{ $design_sail_area }}</td>
                        <td>m<sup>2</sup></td>
                        <td class="has-text-right">{{ round($design_sail_area*10.7639,1) }}</td>
                        <td>ft<sup>2</sup></td>

                        
                    </tr>

                    <tr>
                        <th>Design Drag Coefficient (C<sub>d</sub>)</th>
                        <td class="has-text-right">{{ $design_drag_coefficient }}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>


                    <tr>
                        <th>Max Pneumatic Pressure</th>
                        <td class="has-text-right">{{ $max_pressure_in_bar }}</td>
                        <td>bar</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <th>Descriptive Material</th>
                        <td>&nbsp;</td>
                        <td colspan="3">{{ $material }}</td>
                    </tr>

                </thead>

            </table>

        </div>










        <div class="column">
            <strong>Customer Drawing</strong>
            @livewire('file-list', [
                'canDelete' => true,
                'model' => 'EndProduct',
                'modelId' => $uid,
                'tag' => 'CustomerDrawings',                          // Any tag other than model name
            ])
        </div>













        @if (strlen(trim($remarks)) > 0)
        <div class="column has-text-grey">
            <strong>Remarks/Notes</strong>
            {!! $remarks !!}
        </div>
        @endif



        {{-- INTERFACES --}}
        <div class="column">
            <div class="columns is-vcentered">

                <div class="column content is-half">
                    <strong>Mechanical Interfaces</strong>

                    <ul>
                        @if ($payload_interface)
                        <li>Has Payload Interface</li>
                        @endif

                        @if ($roof_interface)
                        <li>Has Roof Interface (Vehicle)</li>
                        @endif

                        @if ($side_interface)
                        <li>Has Side Interface (Vehicle)</li>
                        @endif

                        @if ($bottom_interface)
                        <li>Has Bottom Interface</li>
                        @endif

                        @if ($guying_interface)
                        <li>Has Guying Interfaces</li>
                        @endif

                        @if ($hoisting_interface)
                        <li>Has Hoisting Interface</li>
                        @endif

                        @if ($lubrication_interface)
                        <li>Has Lubrication Interface</li>
                        @endif

                        @if ($manual_override_interface)
                        <li>Has Manual Override Interface</li>
                        @endif

                        @if ($wire_management)
                        <li>Has Wire Management Interface</li>
                        @endif

                        @if ($wire_basket)
                        <li>Has Wire Basket Interface</li>
                        @endif

                    </ul>


                </div>

                <div class="column content">

                    <strong>Electrical Interfaces</strong>

                    <ul>
                        @if ($vdc12_interface)
                        <li>Has 12 VDC Interface</li>
                        @endif

                        @if ($vdc24_interface)
                        <li>Has 12 VDC Interface</li>
                        @endif

                        @if ($vdc28_interface)
                        <li>Has 28 VDC Interface</li>
                        @endif

                        @if ($ac110_interface)
                        <li>Has 110 AC Interface</li>
                        @endif

                        @if ($ac220_interface)
                        <li>Has 220 AC Interface</li>
                        @endif


                    </ul>


                </div>

            </div>
        </div>
















        <div class="columns is-size-7 has-text-grey mt-6">

            <div class="column">
                <p>{{ $created_by->email }}</p>
                <p>{{ $created_at }}</p>
            </div>

            <div class="column has-text-right">
                <p>{{ $updated_by->email }}</p>
                <p>{{ $updated_at }}</p>
            </div>

        </div>

    </div>

</div>
