<div>
    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">{{ $item ? $constants['update']['title'] : $constants['create']['title'] }}</h1>
        <h2 class="subtitle has-text-weight-light">{{ $item ? $constants['update']['subtitle'] : $constants['create']['subtitle']}}</h2>
    </header>

    @if ($item)
    <div class="control">
        <div class="tags has-addons">
            <span class="tag is-dark is-large mb-6">{{ $item->id}}</span>
        </div>
    </div>
    @endif

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

    <form method="POST" enctype="multipart/form-data">
    @csrf

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


        <div class="field">

            <label class="label" for="topic">Part/Product/Item Description/Title</label>
            <div class="control">

                <input
                    class="input"
                    id="description"
                    wire:model="description"
                    type="text"
                    value="{{ $item ? $item->topic : ''}}"
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
                            <input type="radio" wire:model="ecn_id" value="{{$ecn->id}}"
                            @checked($item && $ecn->id == $item->c_notice_id)> ECN-{{ $ecn->id }}
                        </label>

                    @endforeach

                @else
                    <p>No usable ECNs found in database</p>
                @endif

            </div>

            @error('ecn_id')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>


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
                                <option value="{{$key}}" @selected( $item && $item->family == $key )>{{$value}}</option>
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
                                <option value="{{$key}}" @selected( $item && $item->form == $key )>{{$value}}</option>
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
                                <select wire:model='mat_id'>
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

                    @error('mat_id')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>


        <div class="field">
            <label class="label">Notes, Select All Applicable</label>

            <div class="control">

                @foreach ($ncategories as $ncategory)

                    <p class="has-text-info has-text-7 ml-4 mt-3">{{ $ncategory->text_en }}</p>
                    @foreach ($ncategory->productNotes as $note)
                    <label wire:key="{{ $note->id }}" class="checkbox is-block ">
                        <input type="checkbox" wire:model="notes_id_array" value="{{ $note->id }}"
                        > {{ $note->text_en }}
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


        <div class="field">

            <label class="label" for="topic">Part Weight [kg]</label>
            <div class="control">

                <input
                    class="input"
                    id="weight"
                    wire:model="weight"
                    type="text"
                    value="{{ $item ? $item->weight : ''}}"
                    placeholder="Estimated weight of part/product in kg" required>
            </div>

            @error('weight')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>


        <livewire:ck-editor
            edId="ed10"
            wire:model="remarks"
            label='Notes and/or remarks'
            placeholder='Any kind of remarks/notes about part/product.'
            :content="$remarks"/>

        @error('remarks')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror


        <div class="field block">
            <label class="label">CAD Files</label>

            @if ($item)
            @livewire('file-list', [
                'canDelete' => true,
                'model' => 'Product',
                'modelId' => $item->id,
                'tag' => 'CAD',                          // Any tag other than model name
            ])
            @endif

            <div class="control">

                @livewire('file-upload', [
                    'model' => 'Product',
                    'modelId' => $item ? $item->id : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'CAD',                          // Any tag other than model name
                    'canEdit' => $canEdit])
            </div>
        </div>

        <div class="field block">
            <label class="label">STEP and DXF Files</label>

            @if ($item)
            @livewire('file-list', [
                'canDelete' => true,
                'model' => 'Product',
                'modelId' => $item->id,
                'tag' => 'STEP',                          // Any tag other than model name
            ])
            @endif

            <div class="control">

                @livewire('file-upload', [
                    'model' => 'Product',
                    'modelId' => $item ? $item->id : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'STEP',                          // Any tag other than model name
                    'canEdit' => $canEdit])
            </div>
        </div>


        <div class="field block">
            <label class="label">Drawing and BOM in PDF Format</label>

            @if ($item)
            @livewire('file-list', [
                'canDelete' => true,
                'model' => 'Product',
                'modelId' => $item->id,
                'tag' => 'DWG-PDF',                          // Any tag other than model name
            ])
            @endif

            <div class="control">

                @livewire('file-upload', [
                    'model' => 'Product',
                    'modelId' => $item ? $item->id : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'DWG-PDF',                          // Any tag other than model name
                    'canEdit' => $canEdit])
            </div>
        </div>


        <div class="buttons is-right">
            @if ($item)
                <button wire:click.prevent="updateItem()" class="button is-dark">{{ $constants['update']['submitText'] }}</button>
            @else
                <button wire:click.prevent="storeItem()" class="button is-dark">{{ $constants['create']['submitText'] }}</button>
            @endif
        </div>

    </form>

</div>
