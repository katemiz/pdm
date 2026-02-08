<script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Assembled Products</h1>
    <h2 class="subtitle has-text-weight-light">{{ $uid ? 'Update Assembly Properties' : 'Add New Assembly'}}</h2>
</header>

@if (session()->has('error'))
    <div class="notification is-danger is-light">
        {{ session('error') }}
    </div>
@endif

@if (session()->has('message'))
    <div class="notification is-info is-light">
        {{ session('message') }}
    </div>
@endif


<div class="columns">


    <div class="column is-3 has-background-warning">

        <div class="card">
            <header class="card-header">

                @if ($uid)
                        <p class="card-header-title">{{ $part_number}}-{{ $version }}</p>
                        <a wire:click="$toggle('showSelectComponentsDiv')" class="card-header-icon has-text-link" aria-label="more options">

                        @if(!$hasConfigurations)
                            <span class="icon"><x-carbon-tree-view /></span>
                        @endif
                    </a>
                @else
                    <p class="card-header-title">New Assembly</p>
                @endif

            </header>
        </div>

        @if ($uid)

            <h2 class="subtitle has-text-weight-light">{{ $hasConfigurations ? 'Configurations' : 'Assy Components' }}</h2>
            <livewire:lw-tree :uid="$uid"/>

            @if ($hasConfigurations)

                @if (count($configurations) > 0)

                    <div class="accordion">
                        @foreach ($configurations as $configuration)

                            <div class="card my-1">

                                <header class="card-header">
                                    <p class="card-header-title" wire:click="setCurrentConfigId({{ $configuration->id }})">{{ $configuration->part_number }}-{{ $configuration->config_number }}</p>
                                    <button class="card-header-icon" aria-label="more options">
                                    <span wire:click="setCurrentConfig({{ $configuration->id }})" class="icon has-text-link"><x-carbon-edit /></span>
                                    <span class="icon has-text-link"><x-carbon-tree-view /></span>

                                    </button>
                                </header>

                                @if ($currentConfigId == $configuration->id)

                                    <div class="card-content">
                                        <livewire:lw-tree :uid="$uid"/>
                                    </div>

                                @endif

                            </div>

                        @endforeach
                    </div>

                @else
                    <div class="notification is-warning is-light">No configurations found for this assembly.</div>  
                @endif

                <button  wire:click="confModalToggle()" class="button is-dark is-fullwidth my-3">Add New Configuration</button>

            @endif

        @endif

    </div>


    <div class="column">

        @if ($showSelectComponentsDiv)

            <header class="mb-2">
                <h2 class="subtitle has-text-weight-light has-text-info">Select Components</h2>
            </header>

            <nav class="level my-6">
                <!-- Left side -->
                <div class="level-left">
                    <div class="level-item has-text-centered">
                        <button wire:click="$toggle('showSelectComponentsDiv')" class="button is-light is-small">
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
                            @if (strlen($query) > 0)
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

                    <caption>{{ $nodes->total() }} {{ $nodes->total() > 1 ? ' Records' : ' Record' }}</caption>

                    <thead>
                        <tr>
                            @foreach ($constants['list']['headers'] as $col_name => $headerParams)
                                <th class="has-text-{{ $headerParams['align'] }}">
                                    {{ $headerParams['title'] }}

                                    @if ($headerParams['sortable'])

                                        <a class="{{ $headerParams['direction'] == 'asc' ? 'is-hidden' : '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                            <span class="icon has-text-link">
                                                <x-carbon-chevron-sort-up />
                                            </span>
                                        </a>

                                        <a class="{{ $headerParams['direction'] == 'desc' ? 'is-hidden' : '' }}" wire:click="changeSortDirection('{{$col_name}}')">
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

                            @if ($record->part_number != $part_number)
                                <tr wire:key="{{ $record->id }}">

                                    <td>{{ $record->full_part_number }}</td>
                                    <td>{{ $record->c_notice_id }}</td>
                                    <td>{{ $record->part_type }}</td>
                                    <td>{{ $record->description }}</td>
                                    <td>{{ $record->created_at }}</td>

                                    <td class="has-text-right">
                                        <a wire:click="addChild({{ $uid }},{{ $record->id }})" class="ml-2">
                                            <span class="icon"><x-carbon-add-child-node /></span>
                                        </a>
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

            <div class="columns">

                <div class="column is-8">
                    <header class="mb-2">
                        <h2 class="subtitle has-text-weight-light has-text-info">Assembly Properties</h2>
                    </header>
                </div>

                <div class="column">
                    <div class="buttons is-right">

                        @if ($uid)
                            <a wire:click.prevent="updateItem()">
                        @else
                            <a wire:click.prevent="storeItem()" >
                        @endif

                        <span class="icon"><x-carbon-save /></span>
                        </a>

                    </div>
                </div>
            </div>


            <form method="POST" enctype="multipart/form-data">
                @csrf


                {{-- IS SELLABLE, HAS CONFIGURATIONS, UNIT SELECTION --}}

                <div class="fixed-grid has-3-cols">
                    <div class="grid">
                        <div class="cell field">

                            <label class="label">Is Sellable?</label>

                            <div class="control">
                                <label class="checkbox is-block">
                                    <input type="radio" wire:model="isSellable" value="1"> Yes
                                </label>

                                <label class="checkbox is-block">
                                    <input type="radio" wire:model="isSellable" value="0"> No
                                </label>

                            </div>

                            @error('isSellable')
                                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="cell field">
                            <label class="label">Has Configurations?</label>

                            <div class="control">
                                <label class="checkbox is-block">
                                    <input type="radio" wire:model="hasConfigurations" value="1"> Yes
                                </label>

                                <label class="checkbox is-block">
                                    <input type="radio" wire:model="hasConfigurations" value="0"> No
                                </label>
                            </div>

                            @error('hasConfigurations')
                                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="cell field">
                            <label class="label">Unit</label>

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

                    </div>

                </div>


                {{-- ASSY Description --}}

                <div class="field">

                    <label class="label" for="topic">Assy Description</label>
                    <div class="control">

                        <input
                            class="input"
                            id="description"
                            wire:model="description"
                            type="text"
                            value="{{ $uid ? $description : ''}}"
                            placeholder="Write assy description" required>
                    </div>

                    @error('description')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ECNs --}}

                <div class="field">
                    <label class="label">Available ECNs</label>

                    <div class="control">

                        @if ($ecns->count() > 0)

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

                {{-- NOTES --}}

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

                {{-- PART NOTES --}}

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


                {{-- WEIGHT --}}

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


                {{-- REMARKS --}}

                <livewire:ck-editor
                    wire:model="remarks"
                    label='Notes and/or remarks'
                    placeholder='Any kind of remarks/notes about part/product.'
                    :content="$remarks"/>

                @error('remarks')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                @enderror


                {{-- ATTACHMENTS : CAD Files --}}

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
                            'isMultiple' => true,                   // can multiple files be selected
                            'tag' => 'CAD',                          // Any tag other than model name
                            'canEdit' => true
                        ])
                    </div>
                </div>


                {{-- ATTACHMENTS : STEP Files --}}

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
                            'isMultiple' => true,                   // can multiple files be selected
                            'tag' => 'STEP',                          // Any tag other than model name
                            'canEdit' => true
                        ])
                    </div>
                </div>


                {{-- ATTACHMENTS : DRAWNG Files --}}

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
                            'isMultiple' => true,                   // can multiple files be selected
                            'tag' => 'DWG-BOM',                          // Any tag other than model name
                            'canEdit' => true
                        ])
                    </div>
                </div>

                {{-- BUTTON --}}

                <div class="buttons is-right">
                    @if ($uid)
                        <button wire:click.prevent="updateItem()" class="button is-dark">Update Assy</button>
                    @else
                        <button wire:click.prevent="storeItem()" class="button is-dark">Add New Assy</button>
                    @endif
                </div>

            </form>

        @endif

    </div>

</div>







{{-- MODAL FOR CONFIGURATON --}}

<div class="modal {{ $conf_modal_show ? 'is-active' : '' }}">
    <div class="modal-background" wire:click="confModalToggle()"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Configurations</p>
            <button class="delete" aria-label="close"  wire:click="confModalToggle()"></button>
        </header>

        <section class="modal-card-body">

            <div class="field is-3">

                <label class="label" for="topic">Configuration No</label>
                <div class="control">
                    <input class="input" type="text" placeholder="C04" wire:model="config_number">
                </div>

                @error('config_number')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="field ">

                <label class="label" for="topic">Configuration Description</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Configuration Description" wire:model="config_description">
                </div>

                @error('config_description')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                @enderror
            </div>

        </section>
        
        <footer class="modal-card-foot">
            <div class="buttons">
                <button class="button is-success" wire:click="saveConfiguration({{ $currentConfigId }})">{{ $currentConfigId ? 'Update Configuration' : 'Add New Configuration' }}</button>
                <button class="button" wire:click="confModalToggle()">Cancel</button>
            </div>
        </footer>
    </div>
</div>

