<header class="mb-6">
    @switch($part_type)

        @case('Detail')
            <h1 class="title has-text-weight-light is-size-1">Detail Parts</h1>
            <h2 class="subtitle has-text-weight-light">Detail Part Properties</h2>
            @break

        @case('MakeFrom')
            <h1 class="title has-text-weight-light is-size-1">Make From Parts</h1>
            <h2 class="subtitle has-text-weight-light">Make From Part Properties</h2>
            @break


        @case('Buyable')
            <h1 class="title has-text-weight-light is-size-1">Buyable Parts</h1>
            <h2 class="subtitle has-text-weight-light">Buyable Part Properties</h2>
            @break


        @case('Standard')
            <h1 class="title has-text-weight-light is-size-1">Standard Parts</h1>
            <h2 class="subtitle has-text-weight-light">Standard Part Properties</h2>
            @break

    @endswitch
</header>


@if (session()->has('message'))
    <div class="notification">
        {{ session('message') }}
    </div>
@endif




<div class="card has-background-lighter">

    <div class="card-content">

        {{-- TOP ITEM MENU --}}
        <div class="column">
        <nav class="level mb-6">
            <!-- Left side -->

            <div class="level-left">
                    <a href="{{ $list_all_url }}" class="button mr-2">
                        <span class="icon is-small"><x-carbon-show-data-cards /></span>
                        <span>List All</span>
                    </a>

                    <x-add-button/>



                    @if ($part_type == 'Detail')
                    <a wire:click="replicateConfirm({{ $uid }})" class="button mx-2 ">
                        <span class="icon is-small"><x-carbon-replicate /></span>
                    </a>
                    @endif



                    @if ($part_type == 'Detail' && !$has_mirror && !$is_mirror_of  )
                    <a wire:click="mirrorConfirm({{ $uid }})" class="button mx-2 ">
                        <span class="icon is-small"><x-carbon-crossroads /></span>
                    </a>
                    @endif


                    @if ($part_type != 'Standard')
                    <a href="/pdf/bom/{{$uid}}" class="button  mx-2 has-text-danger">
                        <span class="icon is-small"><x-carbon-document-pdf /></span>
                    </a>
                    @endif


                    @if ($part_type == 'Assy')
                    <a href="/pdf/cascadedbom/{{$uid}}" class="button mx-2 ">
                        <span class="icon is-small"><x-carbon-volume-file-storage /></span>
                    </a>
                    @endif
            </div>

            <!-- Right side -->
            <div class="level-right">

                @role(['admin','EngineeringDept'])
                @if ( in_array($status,['Frozen','Released'])  && $part_type != 'Standard' )

                    @if ($is_latest)
                    <p class="level-item">
                        <a wire:click='reviseConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-version /></span>
                            <span>Revise</span>
                        </a>
                    </p>
                    @endif

                @endif

                @if ( !in_array($status,['Released','Frozen']) )

                    @if (!$is_mirror_of)
                    <p class="level-item">
                        <a href='{{ $item_edit_url }}/{{ $uid }}'>
                            <span class="icon"><x-carbon-edit /></span>
                        </a>
                    </p>
                    @endif

                    @role(['Approver'])
                    <p class="level-item">
                        <a wire:click='freezeConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-stamp /></span>
                        </a>
                    </p>

                    @if ($part_type != 'Standard')
                    <p class="level-item">
                        <a wire:click='releaseConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-send /></span>
                        </a>
                    </p>
                    @endif
                    @endrole

                    @if ($part_type != 'Standard')
                    <p class="level-item">
                        <a wire:click="deleteConfirm({{ $uid }})">
                            <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                        </a>
                    </p>
                    @endif
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

                    @switch($part_type)
                        @case('Assy')
                            <x-carbon-asset />
                            @break

                        @case('Detail')
                            <x-carbon-qr-code />
                            @break

                        @case('Buyable')
                            <x-carbon-shopping-cart-arrow-down />
                            @break

                        @case('MakeFrom')
                            <x-carbon-change-catalog />
                            @break

                        @case('Standard')
                            <x-carbon-change-catalog />
                            @break


                        @case('Chemical')
                            <x-carbon-chemistry />
                            @break

                    @endswitch

                </figure>
            </div>

            <div class="column is-7">

                <div class="columns">

                <div class="column">

                    @if ($part_type == 'Standard')
                        <p class="title has-text-weight-light is-size-2">{{$standard_number}} {{$std_params}}</p>
                        <p class="subtitle has-text-weight-light is-size-6">{{ $description }}</p>
                    @else
                        <p class="title has-text-weight-light is-size-2">{{$part_number}}<span class="has-text-grey-lighter">-{{$version}}</span></p>
                        <p class="subtitle has-text-weight-light is-size-6">{{ $description }}</p>
                    @endif

                    @if (count($all_revs) > 1)
                    <div class="tags has-addons">
                        @foreach ($all_revs as $key => $revId)
                            @if ($key != $version)
                                <a href="{{$item_view_url}}/{{$revId}}" class="tag {{ array_key_last($all_revs) == $key ? 'is-success':'' }} is-light mr-1">R{{$key}}</a>
                            @endif
                        @endforeach
                    </div>
                    @endif

                </div>


                @if  ($mirror_part_number)
                    <div class="column is-4">
                    <p class="title has-text-weight-light is-size-2"><a href="/details/Detail/view/{{$has_mirror}}">{{$mirror_part_number}}<span class="has-text-grey-lighter">-{{$mirror_part_version}}</span></a></p>
                    <p class="subtitle has-text-weight-light is-size-6">{{ $mirror_part_description }}</p>
                    </div>
                @endif


                @if  ($is_mirror_of)
                <div class="column is-8">
                <p class="title has-text-weight-light is-size-2"><a href="/details/Detail/view/{{$is_mirror_of}}">{{$is_mirror_of_part_number}}<span class="has-text-grey-lighter">-{{$is_mirror_of_part_version}}</span></a></p>
                <p class="subtitle has-text-weight-light is-size-6">{{ $is_mirror_of_part_description }}</p>
                </div>
                @endif

                </div>

            </div>




            <div class="column has-text-right is-4">

                @if ($part_type != 'Standard')

                <table class="table has-background-lighter is-fullwidth">
                    <tr>
                        <tr>
                            <th class="has-text-right">ECN</th>
                            <td class="has-text-right"><a class="tag is-link" href="/ecn/view/{{ $c_notice_id }}">{{ $c_notice_id }}</a></td>
                        </tr>
                    </tr>
                    <tr>
                        <th class="has-text-right">Unit</th>
                        <td class="has-text-right">{{ $unit }}</td>
                    </tr>
                    <tr>
                        <th class="has-text-right">Weight [kg]</th>
                        <td class="has-text-right">{{ $weight ? $weight :'-' }}</td>
                    </tr>
                </table>
                @endif

            </div>



        </div>
        </div>






        @if ($release_errors)

            <article class="message is-danger">
                <div class="message-header">
                <p>Assy Release Not Performed : Missing Actions!</p>
                </div>

                <div class="message-body">

                    <p class="my-4">Please complete following actions/points to release this dataset.</p>

                    <table class="table is-fullwidth has-background-danger-light is-light">
                        @foreach ($release_errors as $part => $perrors)
                            <tr>
                                <th>{{$part}}</th>
                                <td>
                                    <ol>
                                    @foreach ($perrors as $perror)
                                        <li>{{ $perror['error'] }}</li>
                                    @endforeach
                                    </ol>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </article>

        @endif





        {{-- SOURCE PART NUMBER --}}
        @if ($part_type == 'MakeFrom')
        <div class="column">
            <label class="label">Source Part Number</label>

            @if ($makefrom_part_item)

                @switch($makefrom_part_item->part_type)
                    @case('Buyable')
                        <a href="/buyables/view/{{ $makefrom_part_item->id}}" target="_blank">{{ $makefrom_part_item->full_part_number}} {{ $makefrom_part_item->description}}</a>
                        @break

                    @case('Assy')
                        <a href="/products-assy/view/{{ $makefrom_part_item->id}}" target="_blank">{{ $makefrom_part_item->full_part_number}} {{ $makefrom_part_item->description}}</a>
                        @break

                    @case('Detail')
                    @case('MakeFrom')
                    @case('Standard')

                        <a href="/details/{{ $makefrom_part_item->part_type }}/view/{{ $makefrom_part_item->id}}" target="_blank">{{ $makefrom_part_item->full_part_number}} {{ $makefrom_part_item->description}}</a>
                        @break

                    @default

                @endswitch

            @else

            Not defined yet

            @endif


        </div>
        @endif





        {{-- MATERIAL --}}
        @if ($has_material)
        <div class="column">
            <label class="label">Material</label>
            <a href="/material/view/{{$malzeme_id}}" target="_blank">{{ $material_definition }}</a>
        </div>
        @endif

        {{-- STANDARD PART NOTES --}}
        @if ($has_notes && $part_type != 'Standard')
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
        @if ($has_flag_notes  && $part_type != 'Standard')
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
                        <td class="has-text-right">{{ round($weight,3) }} kg</td>
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

                @if ($treeData)
                <thead>
                    <tr>
                        <th>Part Number</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Quantity</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($treeData as $i)
                        <tr>
                            <td class="is-narrow">

                                @switch($i->part_type)

                                    @case('Detail')
                                        <a href="/details/Detail/view/{{$i->id}}" target="_blank">
                                        @break

                                    @case('Assy')
                                        <a href="/products-assy/view/{{$i->id}}" target="_blank">
                                        @break

                                    @case('Buyable')
                                        <a href="/buyables/view/{{$i->id}}" target="_blank">
                                        @break

                                    @case('MakeFrom')
                                        <a href="/details/MakeFrom/view/{{$i->id}}" target="_blank">
                                        @break

                                    @case('Standard')
                                        <a href="/details/Standard/view/{{$i->id}}" target="_blank">
                                        @break

                                @endswitch
                                {{ $i->name }}</a>

                            </td>
                            <td>{{ $i->part_type }}</td>
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
        @if ($part_type != 'Standard')
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
        @endif


        @if ( $part_type == 'Standard' )
        <div class="column">

            <div class="block">
            <label class="label">Standard</label>
            @livewire('file-list', [
                'model' => 'Standard',
                'modelId' => $standard_family_id,
                'showMime' => false,
                'showSize' => false,
                'tag' => 'STD', // Any tag other than model name
            ])
            </div>

        </div>
        @endif





        {{-- REMARKS --}}
        @if ($remarks)
        <div class="column">
            <label class="label">Remarks/Notes</label>
            <div class="notification">
                {!! $remarks !!}
            </div>
        </div>
        @endif

        <div class="column">
            <label class="label">Where Used / Parent Assemblies</label>

            {{-- <div class="notification"> --}}

                @if (count($parents) > 0)
                    <table class="table is-fullwidth">
                    <tbody>
                        @foreach ($parents as $key => $parent)
                        <tr>
                            <th class="is-narrow">

                                @switch($parent->part_type)

                                    @case('Detail')
                                        <a href="/details/Detail/view/{{$parent->id}}" target="_blank">
                                        @break

                                    @case('Assy')
                                        <a href="/products-assy/view/{{$parent->id}}" target="_blank">
                                        @break

                                    @case('Buyable')
                                        <a href="/buyables/view/{{$parent->id}}" target="_blank">
                                        @break

                                    @case('MakeFrom')
                                        <a href="/details/MakeFrom/view/{{$parent->id}}" target="_blank">
                                        @break

                                    @case('Standard')
                                        <a href="/details/Standard/view/{{$parent->id}}" target="_blank">
                                        @break

                                @endswitch
                                {{ $parent->part_number }}-{{ $parent->version }}
                                </a>
                            </th>
                            <td>{{ $parent->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                @else

                No parent assembly exists.

                @endif

            {{-- </div> --}}
        </div>







        {{-- DATE, USER INFO --}}
        <div class="column">
            <div class="columns is-size-7 has-text-grey mt-6">

                <div class="column">
                    <p>{{ $created_by->email }}</p>
                    <p>{{ $created_at }}</p>
                </div>

                <div class="column has-text-centered">

                    Status
                    <div class="card-image has-text-centered">
                        <figure class="image is-64x64 is-inline-block">
                            {!! QrCode::size(64)->generate(url('/').$item_view_url.'/'.$uid) !!}
                        </figure>
                    </div>

                    {{$status}}
                </div>

                <div class="column has-text-right">
                    <p>{{ $updated_by->email }}</p>
                    <p>{{ $updated_at }}</p>
                </div>

            </div>
        </div>



    </div>

</div>
