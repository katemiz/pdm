

<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">{{ $page_view_title }}</h1>
    <h2 class="subtitle has-text-weight-light">{{ $page_view_subtitle }}</h2>
</header>

@if (session()->has('message'))
    <div class="notification">
        {{ session('message') }}
    </div>
@endif


<div class="card">

    <div class="card-content">

        {{-- TOP ITEM MENU --}}
        <div class="column">
        <nav class="level mb-6">
            <!-- Left side -->

            <div class="level-left">
                    <a href="{{ $list_all_url }}" class="button is-outlined mr-2">
                        <span class="icon is-small"><x-carbon-show-data-cards /></span>
                        <span>List All</span>
                    </a>

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
                        <a href='{{ $item_edit_url }}/{{ $uid }}'>
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
        </div>



        {{-- PART NUMBER, NAME AND QR CODE SECTION --}}
        <div class="column">
        <div class="columns">

            <div class="column">
                <figure class="image is-64x64">
                    {!! QrCode::size(64)->generate(url('/').$item_view_url.'/'.$uid) !!}
                </figure>
            </div>

            <div class="column is-7">
                <p class="title has-text-weight-light is-size-2">{{$part_number}}<span class="has-text-grey-lighter">-{{$version}}</span></p>
                <p class="subtitle has-text-weight-light is-size-6">{{ $description }}</p>

                @if (count($all_revs) > 1)
                <div class="tags has-addons">
                    @foreach ($all_revs as $key => $revId)
                        @if ($key != $revision)
                            <a href="/{{$item_view_url}}/{{$revId}}"
                                class="tag {{ array_key_last($all_revs) == $key ? 'is-success':'' }} is-light mr-1">R{{$key}}</a>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>

            <div class="column has-text-right is-4">
                <table class="table is-fullwidth">
                    @if(!$has_vendor)
                    <tr>
                        <tr>
                            <th class="has-text-right">ECN</th>
                            <td class="has-text-right"><a class="tag is-link" href="/ecn/view/{{ $ecn_id }}">{{ $ecn_id }}</a></td>
                        </tr>
                    </tr>
                    @endif
                    <tr>
                        <th class="has-text-right">Unit</th>
                        <td class="has-text-right">{{ $unit }}</td>
                    </tr>
                    <tr>
                        <th class="has-text-right">Weight [kg]</th>
                        <td class="has-text-right">{{ $weight ? $weight :'-' }}</td>
                    </tr>
                </table>
            </div>

        </div>
        </div>


        {{-- MATERIAL --}}
        @if ($has_material)
        <div class="column">
            <label class="label">Material</label>
            {{ $material_definition }}
        </div>
        @endif

        {{-- STANDARD PART NOTES --}}
        @if ($has_notes)
        <div class="column content">
            <label class="label">General Part Notes</label>
            <ol>
                @foreach ($notes as $note)
                <li>{{ $note->text_tr }}</li>
                @endforeach
            </ol>
        </div>
        @endif


        {{-- FLAG NOTES --}}
        @if ($has_flag_notes)
        <div class="column content">
            <label class="label">Special Part Notes</label>
            @foreach ($fnotes as $flag)
            <p>{{ $flag['no'] }} - {{ $flag['text_tr'] }}</p>
            @endforeach
        </div>
        @endif


        {{-- IS THIS BUYABLE ITEM --}}
        @if ($has_vendor)
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

                    {{-- <tr>
                        <th>Finish and Color</th>
                        <td class="has-text-right">{!! $finish !!}</td>
                    </tr> --}}

                </thead>

            </table>

        </div>
        @endif




        {{-- BOM --}}
        @if ($has_bom)
        <div class="column">

            <table class="table is-fullwidth has-background-light">

                <caption>Bill of Materials</caption>

                @if ($treeData)s
                <thead>
                    <tr>
                        <th>Part Number</th>
                        <th>Description</th>
                        <th>Quantity</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($treeData as $i)
                        <tr>
                            <td class="is-narrow">{{ $i->name }}-{{ $i->version }}</td>
                            <td>{{ $i->description }}</td>
                            <td class="is-narrow has-text-right">{{ $i->qty }}</td>
                        </tr>
                    @endforeach
                </tbody>
                @endif

            </table>

        </div>
        @endif


        {{-- FILES --}}
        <div class="column">
            <div class="columns">

                @if ( !$has_vendor )
                <div class="column">

                    <div class="block">
                    <label class="label">CAD Files</label>
                    @livewire('file-list', [
                        'model' => 'Product',
                        'modelId' => $uid,
                        'showMime' => false,
                        'showSize' => false,
                        'tag' => 'CAD', // Any tag other than model name
                    ])
                    </div>

                </div>
                @endif


                <div class="column">

                    <div class="block">
                        <label class="label">{{ $has_vendor ? '3D Files':'STEP/DXF Files' }}</label>
                        @livewire('file-list', [
                            'model' => 'Product',
                            'modelId' => $uid,
                            'showMime' => false,
                            'showSize' => false,
                            'tag' => $has_vendor ? '3D':'STEP' ,                          // Any tag other than model name
                        ])
                    </div>
                </div>

                <div class="column">
                    <div class="block">
                        <label class="label">{{ $has_vendor ? 'Datasheest/Documents' : 'Drawing/BOM Files'}}</label>
                        @livewire('file-list', [
                            'model' => 'Product',
                            'modelId' => $uid,
                            'showMime' => false,
                            'showSize' => false,
                            'tag' => $has_vendor ? 'Datasheet':'DWG-BOM',                          // Any tag other than model name
                        ])
                    </div>

                </div>

            </div>
        </div>





        {{-- REMARKS --}}
        @if ($remarks)
        <div class="column">
            <label class="label">Remarks/Notes</label>
            <div class="notification">
                {!! $remarks !!}
            </div>
        </div>
        @endif


        {{-- DATE, USER INFO --}}
        <div class="column">
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

</div>
