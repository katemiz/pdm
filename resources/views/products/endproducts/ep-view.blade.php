<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Sellable Products</h1>
    <h2 class="subtitle has-text-weight-light">View Sellable Product Properties</h2>
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
                        <a wire:click="deleteConfirm({{ $uid }})">
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

                    <p class="subtitle has-text-weight-light is-size-6"><strong>MT</strong> {{ $part_number_mt }} <strong>WB</strong> {{ $part_number_wb }}</p>

                    @if (count($all_revs) > 1)
                    <div class="tags has-addons">
                        @foreach ($all_revs as $key => $revId)
                            @if ($key != $version)
                                <a href="/endproducts/view/{{$revId}}" class="tag {{ array_key_last($all_revs) == $key ? 'is-success':'' }} is-light mr-1">R{{$key}}</a>
                            @endif
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="column has-text-right is-4">

                    <table class="table is-fullwidth">
                        <tr>
                            <th>End Product Type</th>
                            <td>{{ !empty($product_type) ? $product_types[$product_type] : ''}}</td>
                        </tr>

                        @if ($product_type == 'MST')

                        <tr>
                            <th>Drive Type</th>
                            <td>{{ !empty($drive_type) ? $drive_types[$drive_type] : ''}}</td>
                        </tr>
                        <tr>
                            <th>Mast Family</th>
                            <td>{{$mast_family_mt}} / {{$mast_family_wb}}</td>
                        </tr>
                        @endif
                    </table>
                </div>

            </div>
        </div>


        <div class="column">

            <table class="table is-fullwidth">
                <tbody>

                    @if ($product_type == 'MST')

                    <tr>
                        <th>Maximum Payload Capacity</th>
                        <td class="has-text-right">{{ $max_payload_kg }}</td>
                        <td class="has-text-grey-light is-narrow">kg</td>
                        <td class="has-text-right is-narrow">{{ round($max_payload_kg*2.20462,0) }}</td>
                        <td class="has-text-grey-light is-narrow">lb</td>
                    </tr>

                    <tr>
                        <th>Extended Height</th>
                        <td class="has-text-right">{{ $extended_height_mm }}</td>
                        <td class="has-text-grey-light is-narrow">mm</td>
                        <td class="has-text-right">{{ round($extended_height_mm/25.4,1) }}</td>
                        <td class="has-text-grey-light is-narrow">in</td>
                    </tr>

                    <tr>
                        <th>Nested Height</th>
                        <td class="has-text-right">{{ $nested_height_mm }}</td>
                        <td class="has-text-grey-light is-narrow">mm</td>
                        <td class="has-text-right is-narrow">{{ round($nested_height_mm/25.4,1) }}</td>
                        <td class="has-text-grey-light is-narrow">in</td>
                    </tr>

                    <tr>
                        <th>Maximum Operational Wind Speed</th>
                        <td class="has-text-right">{{ $max_operational_wind_speed }}</td>
                        <td class="has-text-grey-light">km/h</td>
                        <td class="has-text-right">{{ round($max_operational_wind_speed*0.5399570136727677,0) }}</td>
                        <td class="has-text-grey-light">knots</td>
                    </tr>

                    <tr>
                        <th>Maximum Survival Wind Speed</th>
                        <td class="has-text-right">{{ $max_survival_wind_speed }}</td>
                        <td class="has-text-grey-light">km/h</td>
                        <td class="has-text-right">{{ round($max_survival_wind_speed*0.5399570136727677,0) }}</td>
                        <td class="has-text-grey-light">knots</td>
                    </tr>

                    <tr>
                        <th>Design Sail Area</th>
                        <td class="has-text-right">{{ $design_sail_area }}</td>
                        <td class="has-text-grey-light">m<sup>2</sup></td>
                        <td class="has-text-right">{{ round($design_sail_area*10.7639,1) }}</td>
                        <td class="has-text-grey-light">ft<sup>2</sup></td>
                    </tr>

                    @if ($max_pressure_in_bar)
                    <tr>
                        <th>Max Pneumatic Pressure</th>
                        <td colspan="2">&nbsp;</td>
                        <td class="has-text-right">{{ $max_pressure_in_bar }}</td>
                        <td class="has-text-grey-light">bar</td>
                    </tr>
                    @endif

                    <tr>
                        <th>Number of Sections</th>
                        <td class="has-text-right" colspan="4">{{ $number_of_sections }}</td>
                    </tr>

                    <tr>
                        <th>Lock Type</th>
                        <td class="has-text-right" colspan="4">{{ $has_locking ? $lock_types[$has_locking] :'' }}</td>
                    </tr>

                    <tr>
                        <th>Design Drag Coefficient (C<sub>d</sub>)</th>
                        <td class="has-text-right" colspan="4">{{ $design_drag_coefficient }}</td>
                    </tr>

                    @endif

                    <tr>
                        <th>Weight</th>
                        <td class="has-text-right">{{ $product_weight_kg }}</td>
                        <td class="has-text-grey-light is-narrow">kg</td>
                        <td class="has-text-right">{{ round($product_weight_kg*2.20462,0) }}</td>
                        <td class="has-text-grey-light">lb</td>
                    </tr>


                    <tr>
                        <th>Descriptive Material</th>
                        <td class="has-text-right" colspan="4">{{ $material }}</td>
                    </tr>

                    <tr>
                        <th>Finish and Color</th>
                        <td colspan="4" class="has-text-right">{!! $finish !!}</td>
                    </tr>

                    @if (strlen($description) > 0)
                    <tr>
                        <th>Description and Other Parameters</th>
                        <td colspan="4" class="has-text-right">{!! $description !!}</td>
                    </tr>
                    @endif


                </tbody>

            </table>

        </div>



        <div class="columns">

            <div class="column">
                @livewire('file-list', [
                    'with_icons' => true,
                    'icon_type' => 'Drawing',
                    'files_header' => 'Drawings',
                    'model' => 'Sellable',
                    'modelId' => $uid,
                    'tag' => 'CustomerDrawings',
                ])
            </div>

            <div class="column">
                @livewire('file-list', [
                    'with_icons' => true,
                    'icon_type' => 'STEP',
                    'files_header' => 'STEP Files',
                    'model' => 'Sellable',
                    'modelId' => $uid,
                    'tag' => 'STEP',
                ])
            </div>


            <div class="column pt-4">

                @if ($manual_doc_number)

                    <div class="card">

                        <div class="card-content has-background-white-ter">
                        <div class="media ">
                            <div class="media-left">
                            <figure class="image is-48x48">
                                <img src="{{ asset('/images/icon_manual.svg') }}" alt="Type of Files">
                            </figure>
                            </div>
                            <div class="media-content">
                            <p class="subtitle is-6">User Manual</p>
                            </div>
                        </div>

                        <div class="content">
                            <a href="/documents/view/{{$manual_doc_id}}" target="_blank">{{ $manual_doc_number.' '.$manual_doc_title }}</a>
                        </div>
                        </div>
                    </div>

                @endif

                {{-- @livewire('file-list', [
                    'getById' => $manual_doc_id,
                    'with_icons' => true,
                    'icon_type' => 'Manual',
                    'files_header' => 'User Manual',
                    'model' => 'Document',
                    'modelId' => $uid,
                    'tag' => 'document',
                ]) --}}

            </div>

        </div>



        @if (strlen(trim($remarks)) > 0)
        <div class="column has-text-grey">
            <strong>Remarks/Notes</strong>
            {!! $remarks !!}
        </div>
        @endif



        {{-- INTERFACES --}}
        <div class="column">
            <div class="columns ">


                @if ($product_type == 'MST')

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

                @endif

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

            <div class="column has-text-centered">
                <p class="subtitle has-text-weight-light is-size-6"><strong>Status</strong><br>{{$status}}</p>
            </div>

            <div class="column has-text-right">
                <p>{{ $updated_by->email }}</p>
                <p>{{ $updated_at }}</p>
            </div>

        </div>

    </div>

</div>
