

<section class="section container has-background-white">






    {{-- <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script> --}}







    <!-- QUILL EDITOR-->
    <link href="{{asset("/css/quill.snow.css")}}" rel="stylesheet">
    <script src="{{asset("/js/quill.js")}}"></script>















    <script src="{{ asset('/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('/js/tree.jquery.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('/css/jqtree.css')}}">









    <script src="{{ asset('/js/confirm_modal.js') }}"></script>

    <script src="{{ asset('/js/product_tree.js') }}"></script>

















    <script>



    function toggleDropdown() {

        let dd = document.getElementById('dmenu')

        if (dd.classList.contains('is-active')) {
            dd.classList.remove('is-active')
        } else {
            dd.classList.add('is-active')
        }

        //console.log(event.target)
      }










    </script>




    <header class="mb-6">



            <h1 class="title has-text-weight-light is-size-1">Products</h1>
            <h2 class="subtitle has-text-weight-light">Add Edit Product Properties</h2>


    </header>


























   @if ($part_type == "Assy")

        <div class="columns">

        <div class="column is-3 has-background-lighter">

            @if ($uid)

            <div class="card">
                <header class="card-header">

                    @if ($uid)
                        <p class="card-header-title">{{ $product->part_number}}-{{ $product->version }}</p>
                    @endif


                    {{-- <a wire:click="$toggle('showNodeGui')" class="button is-small is-link" aria-label="more options">
                        <span class="icon"><x-carbon-edit /></span>
                    </a> --}}



                </header>
            </div>

            @endif







            <nav class="level">
                <!-- Left side -->
                <div class="level-left">
                    <h3 class="subtitle has-text-weight-light">Product Tree</h3>
                </div>

                <!-- Right side -->
                <div class="level-right is-2">

                    @if ( !$showNodeGui )
                    <div>
                        <a wire:click="$toggle('showNodeGui')" class="button is-small is-link" aria-label="more options">
                            <span class="icon">
                                @if ( count($treeData) > 0 )
                                    <x-carbon-edit />
                                @else
                                    <x-carbon-add />
                                @endif
                            </span>
                        </a>
                    </div>
                    @endif

                </div>
            </nav>

            <livewire:lw-tree :treeData="$treeData" :label="Remarks"/>


            {{-- <p class="has-text-centered" id="noparts">
            @if ( count($treeData) < 1 )
                No parts yet
            @endif
            </p> --}}




        </div>


        <div class="column">


            {{-- ADD CHILDREN GUI --}}
            @if ($showNodeGui)


                <header class="mb-2">
                    <h2 class="subtitle has-text-weight-light has-text-info">Assembly Tree Nodes</h2>
                </header>


                <div class="notification is-info is-light">
                    Click icon to add parts to Product Tree. For multiple instance click again
                </div>

                <nav class="level my-6">
                    <!-- Left side -->
                    <div class="level-left">
                        <div class="level-item has-text-centered">
                            <button wire:click="$toggle('showNodeGui')" class="button is-light is-small">
                                <span class="icon is-small"><x-carbon-chevron-left /></span>
                                <span>Back to Form</span>
                            </button>
                        </div>
                    </div>
                    <div class="level-right">

                        <div class="field has-addons">
                            <div class="control">
                            <input class="input is-small" type="text" wire:model.live="query" placeholder="Search ...">
                            </div>
                            <div class="control">
                            <a class="button is-link is-light is-small">
                                @if ( strlen($query) > 0)
                                    <span class="icon is-small is-left" wire:click="resetFilter">
                                        <x-carbon-close />
                                    </span>
                                @else
                                    <span class="icon is-small"><x-carbon-search /></span>
                                @endif
                            </a>
                            </div>
                        </div>

                    </div>
                </nav>


                @if ($nodes->count() > 0)
                <table class="table is-fullwidth">

                    <caption>{{ $nodes->total() }} {{ $nodes->total() > 1 ? ' Records' :' Record' }}</caption>

                    <thead>
                        <tr>
                            @foreach ($constants['list']['headers'] as $col_name => $headerParams)
                                <th class="has-text-{{ $headerParams['align'] }}">
                                    {{ $headerParams['title'] }}

                                    @if ($headerParams['sortable'])

                                        <a class="{{ $headerParams['direction'] == 'asc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                            <span class="icon has-text-link">
                                                <x-carbon-chevron-sort-up />
                                            </span>
                                        </a>

                                        <a class="{{ $headerParams['direction'] == 'desc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                            <span class="icon has-text-link">
                                                <x-carbon-chevron-sort-down />
                                            </span>
                                        </a>

                                    @endif
                                </th>
                            @endforeach

                            <th class="has-text-right"><span class="icon"><x-carbon-user-activity /></span></th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($nodes as $record)

                            @if (!$product || $record->part_number != $product->part_number)
                            <tr wire:key="{{ $record->id }}">

                                <td>{{ $record->full_part_number }}</td>
                                <td>{{ $record->c_notice_id }}</td>
                                <td>{{ $record->part_type }}</td>
                                <td>{{ $record->description }}</td>
                                <td>{{ $record->created_at }}</td>

                                <td class="has-text-right">

                                    @if ($record->part_type == 'Standard')
                                        <a href="javascript:addNodeJS({{ $uid ? $uid : 0 }},{{ $record->id }},'{{ addslashes($record->standard_number. " ". $record->std_params) }}','{{ addslashes($record->description) }}','{{ $record->version }}','{{ $record->part_type }}')">
                                            <span class="icon"><x-carbon-checkmark /></span>
                                        </a>
                                    @else
                                        <a href="javascript:addNodeJS({{ $uid ? $uid : 0 }},{{ $record->id }},'{{ $record->full_part_number }}','{{ addslashes($record->description) }}','{{ $record->version }}','{{ $record->part_type }}')">
                                            <span class="icon"><x-carbon-checkmark /></span>
                                        </a>
                                    @endif

                                </td>

                            </tr>
                            @endif

                        @endforeach

                    </tbody>
                </table>

                {{ $nodes->withQueryString()->links('components.pagination.bulma') }}

                @else
                    <div class="notification is-warning is-light">No nodes found in database</div>
                @endif


            @else
                <form method="POST" enctype="multipart/form-data">
                    @csrf


                        @if ($part_type != 'Standard')

                        <div class="field">
                            <label class="label">Part Unit</label>

                            <div class="control">
                                <label class="checkbox is-block">
                                    <input type="radio" wire:model="unit" value="mm"> Metric (mm)
                                </label>

                                <label class="checkbox is-block">
                                    <input type="radio" wire:model="unit" value="in"> Imperial (in)
                                </label>
                            </div>

                            @error('unit')
                            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        @endif

                        @if ($part_type == 'Standard')


                            <div class="field">

                                <label class="label has-text-weight-normal" for="topic">Select Standard Family</label>
                                <div class="control">
                                    <div class="select">
                                        <select wire:model='standard_family_id'>
                                        <option>Select Family</option>

                                        @foreach ( $sfamilies as $sfamily)
                                            <option value="{{ $sfamily->id }}" @selected( $standard_family_id == $sfamily->id )>{{$sfamily->standard_number}} {{$sfamily->description}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                @error('standard_family_id')
                                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="field">

                                <label class="label" for="topic">Standard (Part) Parameters</label>
                                <div class="control">

                                    <input
                                        class="input"
                                        id="description"
                                        wire:model="std_params"
                                        type="text"
                                        value="{{ $uid ? $std_params : ''}}"
                                        placeholder=" eg M10X50" required>
                                </div>

                                @error('std_params')
                                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif


                        @if ($part_type != 'Standard')

                        <div class="field">

                            <label class="label" for="topic">Part/Product/Item Description/Title</label>
                            <div class="control">

                                <input
                                    class="input"
                                    id="description"
                                    wire:model="description"
                                    type="text"
                                    value="{{ $uid ? $description : ''}}"
                                    placeholder="Write part descrition/title" required>
                            </div>

                            @error('description')
                            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Available ECNs</label>

                            <div class="control">

                                @if ( $ecns->count() > 0)

                                    @foreach ($ecns as $ecn)
                                        <label class="checkbox is-block">
                                            <input type="radio" wire:model="c_notice_id" value="{{$ecn->id}}"
                                            @checked($uid && $ecn->id == $c_notice_id)> ECN-{{ $ecn->id }} {{ $ecn->cr_topic }}
                                        </label>
                                    @endforeach

                                @else
                                    <p>No usable ECNs found in database</p>
                                @endif

                            </div>

                            @error('c_notice_id')
                            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        @endif

                        @if ($part_type == 'Detail')

                        <div class="field ">

                            <label class="label">Material</label>

                            <div class="field-body">

                                <div class="field">

                                    <label class="label has-text-weight-normal" for="topic">Material Family</label>
                                    <div class="control">
                                        <div class="select">
                                            <select wire:model='mat_family' wire:change="getMaterialList">
                                            <option>Select Family</option>

                                            @foreach (config('material.family') as $key => $value)
                                                <option value="{{$key}}" @selected( $uid && $family == $key )>{{$value}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @error('family')
                                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="field">

                                    <label class="label has-text-weight-normal" for="topic">Material Form</label>
                                    <div class="control">
                                        <div class="select">
                                            <select wire:model='mat_form' wire:change="getMaterialList">
                                            <option>Select Form</option>
                                                @foreach (config('material.form') as $key => $value)
                                                    <option value="{{$key}}" @selected( $uid && $form == $key )>{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @error('form')
                                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="field">

                                    <label class="label has-text-weight-normal" for="topic">Material Description</label>

                                    @if (count($materials) > 0)

                                        <div class="control">
                                            <div class="select">
                                                <select wire:model='malzeme_id'>
                                                <option>Select Material</option>

                                                @foreach ($materials as $material)
                                                    <option value="{{$material->id}}">{{$material->description}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @else
                                        <p>No materials</p>
                                    @endif

                                    @error('malzeme_id')
                                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        @endif



                        @if ($part_type == 'MakeFrom')

                            <div class="field">

                                <label class="label">Make From Part Number</label>
                                <div class="control">

                                {{ $makefrom_part_item ? $makefrom_part_item->full_part_number : 'None yet, select from the following list' }}
                                </div>

                            </div>





                            <div class="column card has-background-white-ter mb-5">

                                <div class="level-right">

                                    <div class="field has-addons">
                                        <div class="control">
                                        <input class="input is-small" type="text" wire:model.live="query" placeholder="Search ...">
                                        </div>
                                        <div class="control">
                                        <a class="button is-link is-light is-small">
                                            @if ( strlen($query) > 0)
                                                <span class="icon is-small is-left" wire:click="resetFilter">
                                                    <x-carbon-close />
                                                </span>
                                            @else
                                                <span class="icon is-small"><x-carbon-search /></span>
                                            @endif
                                        </a>
                                        </div>
                                    </div>

                                </div>

                                @if ($nodes->count() > 0)
                                    <table class="table is-fullwidth">

                                        <caption>{{ $nodes->total() }} {{ $nodes->total() > 1 ? ' Records' :' Record' }}</caption>

                                        <thead>
                                            <tr>
                                                @foreach ($constants['list']['headers'] as $col_name => $headerParams)
                                                    <th class="has-text-{{ $headerParams['align'] }}">
                                                        {{ $headerParams['title'] }}

                                                        @if ($headerParams['sortable'])

                                                            <a class="{{ $headerParams['direction'] == 'asc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                                                <span class="icon has-text-link">
                                                                    <x-carbon-chevron-sort-up />
                                                                </span>
                                                            </a>

                                                            <a class="{{ $headerParams['direction'] == 'desc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                                                <span class="icon has-text-link">
                                                                    <x-carbon-chevron-sort-down />
                                                                </span>
                                                            </a>

                                                        @endif
                                                    </th>
                                                @endforeach

                                                <th class="has-text-right"><span class="icon"><x-carbon-user-activity /></span></th>

                                            </tr>
                                        </thead>


                                        <tbody>

                                            @foreach ($nodes as $record)

                                                @if ( !isset($part_number) || $record->part_number != $part_number)
                                                <tr wire:key="{{ $record->id }}">

                                                    <td>{{ $record->full_part_number }}</td>
                                                    <td>{{ $record->part_type }}</td>
                                                    <td>{{ $record->c_notice_id }}</td>
                                                    <td>{{ $record->description }}</td>
                                                    <td>{{ $record->created_at }}</td>

                                                    {{-- @foreach (array_keys($constants['list']['headers']) as $col_name)
                                                        <td class="has-text-{{ $constants['list']['headers'][$col_name]['align'] ? $constants['list']['headers'][$col_name]['align'] : 'left' }}">
                                                            @if (isset($constants['list']['headers'][$col_name]['is_html']) && $constants['list']['headers'][$col_name]['is_html'])
                                                                {!! $record[$col_name] !!}
                                                            @else
                                                                {{ $record[$col_name] }}
                                                            @endif
                                                        </td>
                                                    @endforeach --}}

                                                    <td class="has-text-right">
                                                        <a wire:click="addSourcePart( {{ $record->id }}, '{{ $record->full_part_number }}' )"><span class="icon"><x-carbon-checkmark /></span></a>
                                                    </td>

                                                </tr>
                                                @endif

                                            @endforeach

                                        </tbody>
                                    </table>

                                    {{ $nodes->withQueryString()->links('components.pagination.bulma') }}

                                @else
                                    <div class="notification is-warning is-light">No nodes found in database</div>
                                @endif

                            </div>

                        @endif


                        @if ($part_type != 'Standard')

                            <div class="field">
                                <label class="label">Notes, Select All Applicable</label>

                                <div class="control">

                                    @foreach ($ncategories as $ncategory)

                                        <p class="has-text-info has-text-7 mt-3">{{ $ncategory->text_tr }} / {{ $ncategory->text_en }}</p>
                                        @foreach ($ncategory->productNotes as $note)
                                        <label wire:key="{{ $note->id }}" class="checkbox is-block ">
                                            <input type="checkbox" wire:model="notes_id_array" value="{{ $note->id }}"> {{ $note->text_tr }}
                                        </label>
                                        @endforeach

                                    @endforeach

                                </div>

                                @error('notes_id_array')
                                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="field ">
                                <label class="label">Special Part Notes [Flag Notes]</label>

                                <div class="columns">

                                    <div class="column is-1">
                                        <a wire:click='addSNote' class="button is-small is-link"><span class="icon"><x-carbon-add /></span></a>
                                    </div>

                                    <div class="column">

                                        @foreach ($fnotes as $index => $fnote)
                                        <div class="field-body">

                                        <div class="field is-narrow">
                                            @if ($index == 0)
                                            <label class="label has-text-weight-normal">No</label>
                                            @endif

                                            <p class="control">
                                            <input class="input" type="text" placeholder="No" wire:model="fnotes.{{ $index }}.no">
                                            </p>
                                        </div>

                                        <div class="field">
                                            @if ($index == 0)
                                                <label class="label has-text-weight-normal">Flag Note</label>
                                            @endif

                                            <div class="columns">

                                                <div class="column">
                                                    <p class="control">
                                                        <input class="input" type="text" placeholder="Specific part note" wire:model="fnotes.{{ $index }}.text_tr">
                                                    </p>
                                                </div>

                                                <div class="column is-1">
                                                    <p class="control">
                                                        <a wire:click='deleteSNote("{{ $index }}")'><span class="icon is-small has-text-danger"><x-carbon-trash-can /></span></a>
                                                    </p>
                                                </div>

                                            </div>

                                        </div>

                                        </div>
                                        @endforeach

                                    </div>

                                </div>

                            </div>

                        @endif


                        <div class="field">

                            <label class="label" for="topic">Part Weight [kg]</label>
                            <div class="control">

                                <input
                                    class="input"
                                    id="weight"
                                    wire:model="weight"
                                    type="text"
                                    value="{{ $uid ? $weight : ''}}"
                                    placeholder="Estimated weight of part/product in kg" required>
                            </div>

                            @error('weight')
                            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- <livewire:ck-editor
                            wire:model="remarks"
                            label='Notes and/or remarks'
                            placeholder='Any kind of remarks/notes about part/product.'
                            :content="$remarks"/> --}}

                            <livewire:quill :value="$remarks" label="Remarks"/>


                        @error('remarks')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                        @enderror

                        @if ($part_type != 'Standard')

                            <div class="field block">
                                <label class="label">CAD Files</label>

                                @if ($uid)
                                @livewire('file-list', [
                                    'canDelete' => true,
                                    'model' => 'Product',
                                    'modelId' => $uid,
                                    'tag' => 'CAD',                          // Any tag other than model name
                                ])
                                @endif

                                <div class="control">

                                    @livewire('file-upload', [
                                        'model' => 'Product',
                                        'modelId' => $uid ? $uid : false,
                                        'isMultiple'=> true,                   // can multiple files be selected
                                        'tag' => 'CAD',                          // Any tag other than model name
                                        'canEdit' => $canUserEdit])
                                </div>
                            </div>

                            <div class="field block">
                                <label class="label">STEP/DXF Files</label>

                                @if ($uid)
                                @livewire('file-list', [
                                    'canDelete' => true,
                                    'model' => 'Product',
                                    'modelId' => $uid,
                                    'tag' => 'STEP',                          // Any tag other than model name
                                ])
                                @endif

                                <div class="control">

                                    @livewire('file-upload', [
                                        'model' => 'Product',
                                        'modelId' => $uid ? $uid : false,
                                        'isMultiple'=> true,                   // can multiple files be selected
                                        'tag' => 'STEP',                          // Any tag other than model name
                                        'canEdit' => $canUserEdit])
                                </div>
                            </div>


                            <div class="field block">
                                <label class="label">Drawing/BOM Files</label>

                                @if ($uid)
                                @livewire('file-list', [
                                    'canDelete' => true,
                                    'model' => 'Product',
                                    'modelId' => $uid,
                                    'tag' => 'DWG-BOM',                          // Any tag other than model name
                                ])
                                @endif

                                <div class="control">

                                    @livewire('file-upload', [
                                        'model' => 'Product',
                                        'modelId' => $uid ? $uid : false,
                                        'isMultiple'=> true,                   // can multiple files be selected
                                        'tag' => 'DWG-BOM',                          // Any tag other than model name
                                        'canEdit' => $canUserEdit])
                                </div>
                            </div>


                        @endif


                        <div class="buttons is-right">

                            @switch($part_type)

                                @case('Detail')

                                    @if ($uid)
                                        <button wire:click.prevent="updateItem()" class="button is-dark">Update Detail Part</button>
                                    @else
                                        <button wire:click.prevent="storeItem()" class="button is-dark">New Detail Part</button>
                                    @endif


                                    @break

                                @case('MakeFrom')
                                    @if ($uid)
                                        <button wire:click.prevent="updateItem()" class="button is-dark">Update Make From Part</button>
                                    @else
                                        <button wire:click.prevent="storeItem()" class="button is-dark">New Make From Part</button>
                                    @endif

                                    @break

                                @case('Standard')
                                    @if ($uid)
                                        <button wire:click.prevent="updateItem()" class="button is-dark">Update Standard Part</button>
                                    @else
                                        <button wire:click.prevent="storeItem()" class="button is-dark">New Standard Part</button>
                                    @endif
                                    @break

                            @endswitch

                        </div>



                        @foreach ($errors->all() as $error)
                        {{ $error }}<br/>
                    @endforeach

                </form>
            @endif

        </div>

        </div>

    @else

        <form method="POST" enctype="multipart/form-data">
            @csrf


                @if ($part_type != 'Standard')

                <div class="field">
                    <label class="label">Part Unit</label>

                    <div class="control">
                        <label class="checkbox is-block">
                            <input type="radio" wire:model="unit" value="mm"> Metric (mm)
                        </label>

                        <label class="checkbox is-block">
                            <input type="radio" wire:model="unit" value="in"> Imperial (in)
                        </label>
                    </div>

                    @error('unit')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                @endif

                @if ($part_type == 'Standard')


                    <div class="field">

                        <label class="label has-text-weight-normal" for="topic">Select Standard Family</label>
                        <div class="control">
                            <div class="select">
                                <select wire:model='standard_family_id'>
                                <option>Select Family</option>

                                @foreach ( $sfamilies as $sfamily)
                                    <option value="{{ $sfamily->id }}" @selected( $standard_family_id == $sfamily->id )>{{$sfamily->standard_number}} {{$sfamily->description}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        @error('standard_family_id')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="field">

                        <label class="label" for="topic">Standard (Part) Parameters</label>
                        <div class="control">

                            <input
                                class="input"
                                id="description"
                                wire:model="std_params"
                                type="text"
                                value="{{ $uid ? $std_params : ''}}"
                                placeholder=" eg M10X50" required>
                        </div>

                        @error('std_params')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                @endif


                @if ($part_type != 'Standard')

                <div class="field">

                    <label class="label" for="topic">Part/Product/Item Description/Title</label>
                    <div class="control">

                        <input
                            class="input"
                            id="description"
                            wire:model="description"
                            type="text"
                            value="{{ $uid ? $description : ''}}"
                            placeholder="Write part descrition/title" required>
                    </div>

                    @error('description')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label class="label">Available ECNs</label>

                    <div class="control">

                        @if ( $ecns->count() > 0)

                            @foreach ($ecns as $ecn)
                                <label class="checkbox is-block">
                                    <input type="radio" wire:model="c_notice_id" value="{{$ecn->id}}"
                                    @checked($uid && $ecn->id == $c_notice_id)> ECN-{{ $ecn->id }} {{ $ecn->cr_topic }}
                                </label>
                            @endforeach

                        @else
                            <p>No usable ECNs found in database</p>
                        @endif

                    </div>

                    @error('c_notice_id')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                @endif

                @if ($part_type == 'Detail')

                <div class="field ">

                    <label class="label">Material</label>

                    <div class="field-body">

                        <div class="field">

                            <label class="label has-text-weight-normal" for="topic">Material Family</label>
                            <div class="control">
                                <div class="select">
                                    <select wire:model='mat_family' wire:change="getMaterialList">
                                    <option>Select Family</option>

                                    @foreach (config('material.family') as $key => $value)
                                        <option value="{{$key}}" @selected( $uid && $family == $key )>{{$value}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            @error('family')
                            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">

                            <label class="label has-text-weight-normal" for="topic">Material Form</label>
                            <div class="control">
                                <div class="select">
                                    <select wire:model='mat_form' wire:change="getMaterialList">
                                    <option>Select Form</option>
                                        @foreach (config('material.form') as $key => $value)
                                            <option value="{{$key}}" @selected( $uid && $form == $key )>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @error('form')
                            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">

                            <label class="label has-text-weight-normal" for="topic">Material Description</label>

                            @if (count($materials) > 0)

                                <div class="control">
                                    <div class="select">
                                        <select wire:model='malzeme_id'>
                                        <option>Select Material</option>

                                        @foreach ($materials as $material)
                                            <option value="{{$material->id}}">{{$material->description}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                <p>No materials</p>
                            @endif

                            @error('malzeme_id')
                            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                @endif



                @if ($part_type == 'MakeFrom')

                    <div class="field">

                        <label class="label">Make From Part Number</label>
                        <div class="control">

                        {{ $makefrom_part_item ? $makefrom_part_item->full_part_number : 'None yet, select from the following list' }}
                        </div>

                    </div>

                    <div class="column card has-background-white-ter mb-5">

                        <div class="level-right">

                            <div class="field has-addons">
                                <div class="control">
                                <input class="input is-small" type="text" wire:model.live="query" placeholder="Search ...">
                                </div>
                                <div class="control">
                                <a class="button is-link is-light is-small">
                                    @if ( strlen($query) > 0)
                                        <span class="icon is-small is-left" wire:click="resetFilter">
                                            <x-carbon-close />
                                        </span>
                                    @else
                                        <span class="icon is-small"><x-carbon-search /></span>
                                    @endif
                                </a>
                                </div>
                            </div>

                        </div>

                        @if ($nodes->count() > 0)
                            <table class="table is-fullwidth">

                                <caption>{{ $nodes->total() }} {{ $nodes->total() > 1 ? ' Records' :' Record' }}</caption>

                                <thead>
                                    <tr>
                                        @foreach ($constants['list']['headers'] as $col_name => $headerParams)
                                            <th class="has-text-{{ $headerParams['align'] }}">
                                                {{ $headerParams['title'] }}

                                                @if ($headerParams['sortable'])

                                                    <a class="{{ $headerParams['direction'] == 'asc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                                        <span class="icon has-text-link">
                                                            <x-carbon-chevron-sort-up />
                                                        </span>
                                                    </a>

                                                    <a class="{{ $headerParams['direction'] == 'desc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                                        <span class="icon has-text-link">
                                                            <x-carbon-chevron-sort-down />
                                                        </span>
                                                    </a>

                                                @endif
                                            </th>
                                        @endforeach

                                        <th class="has-text-right"><span class="icon"><x-carbon-user-activity /></span></th>

                                    </tr>
                                </thead>


                                <tbody>

                                    @foreach ($nodes as $record)

                                        @if ( !isset($part_number) || $record->part_number != $part_number)
                                        <tr wire:key="{{ $record->id }}">

                                            <td>{{ $record->full_part_number }}</td>
                                            <td>{{ $record->part_type }}</td>
                                            <td>{{ $record->c_notice_id }}</td>
                                            <td>{{ $record->description }}</td>
                                            <td>{{ $record->created_at }}</td>

                                            {{-- @foreach (array_keys($constants['list']['headers']) as $col_name)
                                                <td class="has-text-{{ $constants['list']['headers'][$col_name]['align'] ? $constants['list']['headers'][$col_name]['align'] : 'left' }}">
                                                    @if (isset($constants['list']['headers'][$col_name]['is_html']) && $constants['list']['headers'][$col_name]['is_html'])
                                                        {!! $record[$col_name] !!}
                                                    @else
                                                        {{ $record[$col_name] }}
                                                    @endif
                                                </td>
                                            @endforeach --}}

                                            <td class="has-text-right">
                                                <a wire:click="addSourcePart( {{ $record->id }}, '{{ $record->full_part_number }}' )"><span class="icon"><x-carbon-checkmark /></span></a>
                                            </td>

                                        </tr>
                                        @endif

                                    @endforeach

                                </tbody>
                            </table>

                            {{ $nodes->withQueryString()->links('components.pagination.bulma') }}

                        @else
                            <div class="notification is-warning is-light">No nodes found in database</div>
                        @endif

                    </div>

                @endif


                @if ($part_type != 'Standard')

                    <div class="field">
                        <label class="label">Notes, Select All Applicable</label>

                        <div class="control">

                            @foreach ($ncategories as $ncategory)

                                <p class="has-text-info has-text-7 mt-3">{{ $ncategory->text_tr }} / {{ $ncategory->text_en }}</p>
                                @foreach ($ncategory->productNotes as $note)
                                <label wire:key="{{ $note->id }}" class="checkbox is-block ">
                                    <input type="checkbox" wire:model="notes_id_array" value="{{ $note->id }}"> {{ $note->text_tr }}
                                </label>
                                @endforeach

                            @endforeach

                        </div>

                        @error('notes_id_array')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="field ">
                        <label class="label">Special Part Notes [Flag Notes]</label>

                        <div class="columns">

                            <div class="column is-1">
                                <a wire:click='addSNote' class="button is-small is-link"><span class="icon"><x-carbon-add /></span></a>
                            </div>

                            <div class="column">

                                @foreach ($fnotes as $index => $fnote)
                                <div class="field-body">

                                <div class="field is-narrow">
                                    @if ($index == 0)
                                    <label class="label has-text-weight-normal">No</label>
                                    @endif

                                    <p class="control">
                                    <input class="input" type="text" placeholder="No" wire:model="fnotes.{{ $index }}.no">
                                    </p>
                                </div>

                                <div class="field">
                                    @if ($index == 0)
                                        <label class="label has-text-weight-normal">Flag Note</label>
                                    @endif

                                    <div class="columns">

                                        <div class="column">
                                            <p class="control">
                                                <input class="input" type="text" placeholder="Specific part note" wire:model="fnotes.{{ $index }}.text_tr">
                                            </p>
                                        </div>

                                        <div class="column is-1">
                                            <p class="control">
                                                <a wire:click='deleteSNote("{{ $index }}")'><span class="icon is-small has-text-danger"><x-carbon-trash-can /></span></a>
                                            </p>
                                        </div>

                                    </div>

                                </div>

                                </div>
                                @endforeach

                            </div>

                        </div>

                    </div>

                @endif


                <div class="field">

                    <label class="label" for="topic">Part Weight [kg]</label>
                    <div class="control">

                        <input
                            class="input"
                            id="weight"
                            wire:model="weight"
                            type="text"
                            value="{{ $uid ? $weight : ''}}"
                            placeholder="Estimated weight of part/product in kg" required>
                    </div>

                    @error('weight')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>


                {{-- <livewire:ck-editor
                    wire:model="remarks"
                    label='Notes and/or remarks'
                    placeholder='Any kind of remarks/notes about part/product.'
                    :content="$remarks"/> --}}

                    <livewire:quill :value="$remarks" label="Remarks"/>


                @error('remarks')
                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                @enderror

                @if ($part_type != 'Standard')

                    <div class="field block">
                        <label class="label">CAD Files</label>

                        @if ($uid)
                        @livewire('file-list', [
                            'canDelete' => true,
                            'model' => 'Product',
                            'modelId' => $uid,
                            'tag' => 'CAD',                          // Any tag other than model name
                        ])
                        @endif

                        <div class="control">

                            @livewire('file-upload', [
                                'model' => 'Product',
                                'modelId' => $uid ? $uid : false,
                                'isMultiple'=> true,                   // can multiple files be selected
                                'tag' => 'CAD',                          // Any tag other than model name
                                'canEdit' => $canUserEdit])
                        </div>
                    </div>

                    <div class="field block">
                        <label class="label">STEP/DXF Files</label>

                        @if ($uid)
                        @livewire('file-list', [
                            'canDelete' => true,
                            'model' => 'Product',
                            'modelId' => $uid,
                            'tag' => 'STEP',                          // Any tag other than model name
                        ])
                        @endif

                        <div class="control">

                            @livewire('file-upload', [
                                'model' => 'Product',
                                'modelId' => $uid ? $uid : false,
                                'isMultiple'=> true,                   // can multiple files be selected
                                'tag' => 'STEP',                          // Any tag other than model name
                                'canEdit' => $canUserEdit])
                        </div>
                    </div>


                    <div class="field block">
                        <label class="label">Drawing/BOM Files</label>

                        @if ($uid)
                        @livewire('file-list', [
                            'canDelete' => true,
                            'model' => 'Product',
                            'modelId' => $uid,
                            'tag' => 'DWG-BOM',                          // Any tag other than model name
                        ])
                        @endif

                        <div class="control">

                            @livewire('file-upload', [
                                'model' => 'Product',
                                'modelId' => $uid ? $uid : false,
                                'isMultiple'=> true,                   // can multiple files be selected
                                'tag' => 'DWG-BOM',                          // Any tag other than model name
                                'canEdit' => $canUserEdit])
                        </div>
                    </div>


                @endif


                <div class="buttons is-right">

                    @switch($part_type)

                        @case('Detail')

                            @if ($uid)
                                <button wire:click.prevent="updateItem()" class="button is-dark">Update Detail Part</button>
                            @else
                                <button wire:click.prevent="storeItem()" class="button is-dark">New Detail Part</button>
                            @endif


                            @break

                        @case('MakeFrom')
                            @if ($uid)
                                <button wire:click.prevent="updateItem()" class="button is-dark">Update Make From Part</button>
                            @else
                                <button wire:click.prevent="storeItem()" class="button is-dark">New Make From Part</button>
                            @endif

                            @break

                        @case('Standard')
                            @if ($uid)
                                <button wire:click.prevent="updateItem()" class="button is-dark">Update Standard Part</button>
                            @else
                                <button wire:click.prevent="storeItem()" class="button is-dark">New Standard Part</button>
                            @endif
                            @break

                    @endswitch

                </div>



                @foreach ($errors->all() as $error)
                {{ $error }}<br/>
            @endforeach

        </form>


    @endif

</section>
