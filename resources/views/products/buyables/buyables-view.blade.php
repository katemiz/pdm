<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Buyable Products</h1>
    <h2 class="subtitle has-text-weight-light">View Buyable Product Properties</h2>
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
                    <a href="/buyables/list">
                        <span class="icon is-small"><x-carbon-table /></span>
                        <span>List All</span>
                    </a>
                </p>

                <p class="level-item">
                    <a href="/buyables/form/">
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
                        <a href='/buyables/form/{{ $uid }}'>
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
                    <p class="subtitle has-text-weight-light is-size-6"><strong>{{$description}}</strong></p>

                    <p class="subtitle has-text-weight-light is-size-6"><strong>MT</strong> {{ $part_number_mt }} <strong>WB</strong> {{ $part_number_wb }}</p>


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
                            <td>{{$part_number}} / {{$part_number}}</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>


        <div class="column">

            <table class="table is-fullwidth">
                <thead>

                    <tr>
                        <th>Vendor</th>
                        <td class="has-text-right is-narrow">{{ $vendor }}</td>
                    </tr>

                    <tr>
                        <th>Vendor Part Number</th>
                        <td class="has-text-right">{{ $vendor_part_no }}</td>
                    </tr>

                    <tr>
                        <th>Weight</th>
                        <td class="has-text-right">{{ round($weight,1) }} kg</td>
                    </tr>

                    <tr>
                        <th>Web Site Link / URL</th>
                        <td class="has-text-right">{{ $url }}</td>
                    </tr>

                    <tr>
                        <th>Material</th>
                        <td class="has-text-right">{{ $material }}</td>
                    </tr>

                    <tr>
                        <th>Finish and Color</th>
                        <td class="has-text-right">{!! $finish !!}</td>
                    </tr>

                </thead>

            </table>

        </div>

        <div class="columns">

            <div class="column">
                @livewire('file-list', [
                    'with_icons' => true,
                    'icon_type' => 'Drawing',
                    'files_header' => 'Drawings',
                    'model' => 'Buyable',
                    'modelId' => $uid,
                    'tag' => 'Datasheet',
                ])
            </div>

            <div class="column">
                @livewire('file-list', [
                    'with_icons' => true,
                    'icon_type' => 'STEP',
                    'files_header' => 'STEP Files',
                    'model' => 'Buyable',
                    'modelId' => $uid,
                    'tag' => '3D',
                ])
            </div>




        </div>













        @if (strlen(trim($notes)) > 0)
        <div class="column has-text-grey">
            <strong>Notes</strong>
            {!! $notes !!}
        </div>
        @endif

















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
