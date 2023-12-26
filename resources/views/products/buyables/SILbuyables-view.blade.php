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

                    <a href="/parts/list" class="button is-outlined mr-2">
                        <span class="icon is-small"><x-carbon-show-data-cards /></span>
                        <span>List All</span>
                    </a>

                    {{-- <a href="/buyables/form/">
                        <span class="icon is-small"><x-carbon-add /></span>
                        <span>Add</span>
                    </a> --}}

                    <x-add-button />

            </div>

            <!-- Right side -->
            <div class="level-right">

                @role(['admin','EngineeringDept'])

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
            <p class="title has-text-weight-light is-size-2">{{$part_number}}-{{$version}}</p>
            <p class="subtitle has-text-weight-light is-size-6"><strong>{{$description}}</strong></p>

            @if ( strlen($part_number_mt) > 0 || strlen($part_number_wb))

            <p class="subtitle has-text-weight-light is-size-6">

                @if ($part_number_mt)
                <strong>MT</strong> {{ $part_number_mt }}
                @endif

                @if ($part_number_wb)
                <strong>WB</strong> {{ $part_number_wb }}
                @endif
            </p>

            @endif

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





        <div class="column">

            <table class="table is-fullwidth">
                <thead>

                    <tr>
                        <th>Vendor</th>
                        <td class="has-text-right">{{ $vendor }}</td>
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
                        <td class="has-text-right"><a href="{{ $url }}">Go to Part Web Site</a></td>
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
                    'icon_type' => 'File',
                    'files_header' => 'Datasheets/Drawings',
                    'model' => 'Buyable',
                    'modelId' => $uid,
                    'tag' => 'Datasheet',
                ])
            </div>

            <div class="column">
                @livewire('file-list', [
                    'with_icons' => true,
                    'icon_type' => '3D',
                    'files_header' => '3D Files',
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
