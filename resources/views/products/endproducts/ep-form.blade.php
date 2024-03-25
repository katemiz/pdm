<div>
    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">{{ $uid ? $constants['update']['title'] : $constants['create']['title'] }}</h1>
        <h2 class="subtitle has-text-weight-light">{{ $uid ? $constants['update']['subtitle'] : $constants['create']['subtitle']}}</h2>
    </header>

    @if ($uid)
        <div class="control">
            <div class="tags has-addons">
                <span class="tag is-dark is-large mb-6">{{ $part_number}}-{{ $version }}</span>
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
            <label class="label">Sellable Product Type</label>

            <div class="control">

                @foreach ($product_types as $k => $eptype)

                    <label class="checkbox is-block">
                        <input type="radio" wire:model.live="product_type" value="{{ $k }}"> {{ $eptype }}
                    </label>

                @endforeach

            </div>

            @error('product_type')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>



        <div class="columns">

            <div class="column is-half">

                <div class="field">

                    <label class="label" for="topic">Masttech Part Number</label>
                    <div class="control">

                        <input
                            class="input"
                            id="part_number_mt"
                            wire:model="part_number_mt"
                            type="text"
                            value="{{ $uid ? $part_number_mt : ''}}"
                            placeholder="Write Masstech Part Number" required>
                    </div>

                    @error('part_number_mt')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>


            <div class="column is-half">

                <div class="field">

                    <label class="label" for="topic">Will-Burt Part Number</label>
                    <div class="control">

                        <input
                            class="input"
                            id="part_number_wb"
                            wire:model="part_number_wb"
                            type="text"
                            value="{{ $uid ? $part_number_wb : ''}}"
                            placeholder="Write WB Part Number" required>
                    </div>

                    @error('part_number_wb')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>

        </div>









        <div class="field">

            <label class="label" for="topic">Sellable Product Nomenclature</label>
            <div class="control">

                <input
                    class="input"
                    id="nomenclature"
                    wire:model="nomenclature"
                    type="text"
                    value="{{ $uid ? $nomenclature : ''}}"
                    placeholder="Write sellable product Nomenclature (eg EML-AL MAST 1-2.5M LOCKING)" required>
            </div>

            @error('nomenclature')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>




        <livewire:ck-editor
            wire:model="description"
            cktype="STANDARD"
            label='Sellable Product Description'
            placeholder='General description of Sellable product'
            :content="$description"/>

        @error('description')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror






        @if ($product_type == 'MST')

        <div class="columns">

            <div class="column is-4">
                <div class="field">

                    <label class="label">Drive Type</label>
                    <div class="control">
                        <div class="select">
                            <select wire:model='drive_type'>
                            <option>Select Drive Type</option>

                            @foreach ( $drive_types as $key => $value)
                                <option value="{{$key}}" @selected( $uid && $drive_type == $key )>{{$value}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    @error('drive_type')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="column is-4">
                <div class="field">

                    <label class="label">MT Mast Family</label>
                    <div class="control">
                        <div class="select">
                            <select wire:model='mast_family_mt'>
                            <option>Select MT Mast Family</option>
                            @foreach ( array_keys($mast_families) as $family)
                                <option value="{{$family}}" @selected( $uid && $mast_family_mt == $family )>{{$family}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    @error('mast_family_mt')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="column is-4">
                <div class="field">

                    <label class="label">Number of Sections</label>
                    <div class="control">
                        <input
                            class="input"
                            id="number_of_sections"
                            wire:model="number_of_sections"
                            type="text"
                            value="{{ $uid ? $number_of_sections : ''}}"
                            placeholder="Number of sections" required>
                    </div>

                    @error('number_of_sections')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        </div>


        <div class="columns">

            <div class="column is-4">
                <div class="field">

                    <label class="label">Maximum Payload Capacity (kg)</label>
                    <div class="control">
                        <input
                            class="input"
                            id="max_payload_kg"
                            wire:model="max_payload_kg"
                            type="text"
                            value="{{ $uid ? $max_payload_kg : ''}}"
                            placeholder="Maximum Payload Capacity (kg)" required>
                    </div>

                    @error('max_payload_kg')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="column is-4">
                <div class="field">

                    <label class="label">Extended Height (mm)</label>
                    <div class="control">
                        <input
                            class="input"
                            id="extended_height_mm"
                            wire:model="extended_height_mm"
                            type="text"
                            value="{{ $uid ? $extended_height_mm : ''}}"
                            placeholder="Extended height in mm" required>
                    </div>

                    @error('extended_height_mm')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="column is-4">
                <div class="field">

                    <label class="label">Nested Height (mm)</label>
                    <div class="control">
                        <input
                            class="input"
                            id="nested_height_mm"
                            wire:model="nested_height_mm"
                            type="text"
                            value="{{ $uid ? $extended_height_mm : ''}}"
                            placeholder="Nested height in mm" required>
                    </div>

                    @error('nested_height_mm')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        </div>


        <div class="columns">

            <div class="column is-4">
                <div class="field">

                    <label class="label">Max Operational Wind Speed (km/h)</label>
                    <div class="control">
                        <input
                            class="input"
                            id="max_operational_wind_speed"
                            wire:model="max_operational_wind_speed"
                            type="text"
                            value="{{ $uid ? $max_operational_wind_speed : ''}}"
                            placeholder="Max Operational Wind Speed (km/h)" required>
                    </div>

                    @error('max_operational_wind_speed')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="column is-4">
                <div class="field">

                    <label class="label">Max Survival Wind Speed (km/h)</label>
                    <div class="control">
                        <input
                            class="input"
                            id="max_survival_wind_speed"
                            wire:model="max_survival_wind_speed"
                            type="text"
                            value="{{ $uid ? $max_survival_wind_speed : ''}}"
                            placeholder="Max Survival Wind Speed (km/h)" required>
                    </div>

                    @error('max_survival_wind_speed')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="column is-4">
                <div class="field">

                    <label class="label">Locking Type</label>
                    <div class="control">
                        <div class="select">
                            <select wire:model='has_locking'>
                            <option>Select Lock Type</option>
                            @foreach ( $lock_types as $key => $opt)
                                <option value="{{$key}}">{{$opt}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    @error('has_locking')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        </div>

        @endif



        <div class="columns">

            <div class="column is-4">
                <div class="field">

                    <label class="label">Weight (kg)</label>
                    <div class="control">
                        <input
                            class="input"
                            id="product_weight_kg"
                            wire:model="product_weight_kg"
                            type="text"
                            value="{{ $uid ? $product_weight_kg : ''}}"
                            placeholder="Weight (kg)" required>
                    </div>

                    @error('product_weight_kg')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            @if ($product_type == 'MST')


            <div class="column is-4">
                <div class="field">

                    <label class="label">Design Sail Area (m<sup>2</sup>)</label>
                    <div class="control">
                        <input
                            class="input"
                            id="design_sail_area"
                            wire:model="design_sail_area"
                            type="text"
                            value="{{ $uid ? $design_sail_area : ''}}"
                            placeholder="Design Sail Area (m<sup>2</sup>)" required>
                    </div>

                    @error('design_sail_area')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="column is-4">
                <div class="field">

                    <label class="label">Design Drag Coefficient C<sub>d</sub>[Payload]</label>
                    <div class="control">
                        <input
                            class="input"
                            id="design_drag_coefficient"
                            wire:model="design_drag_coefficient"
                            type="text"
                            value="{{ $uid ? $design_drag_coefficient : ''}}"
                            placeholder="Design Drag Coefficient, Default 1.5" required>
                    </div>

                    @error('design_drag_coefficient')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @endif

        </div>


        @if ($product_type == 'MST')

        <div class="columns">

            <div class="column is-8">
                <div class="field">

                    <label class="label">Descriptive Material</label>
                    <div class="control">
                        <input
                            class="input"
                            id="material"
                            wire:model="material"
                            type="text"
                            value="{{ $uid ? $material : ''}}"
                            placeholder="Descriptive material of product" required>
                    </div>

                    @error('material')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>



            <div class="column is-4">
                <div class="field">
                    <label class="label">Maximum Pressure (bar)</label>
                    <div class="control">
                        <input
                            class="input"
                            id="max_pressure_in_bar"
                            wire:model="max_pressure_in_bar"
                            type="text"
                            value="{{ $uid ? $max_pressure_in_bar : ''}}"
                            placeholder="Max pressure, Default 2 bar" required>
                    </div>

                    @error('max_pressure_in_bar')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        </div>

        @endif





        <div class="columns">


            <div class="column is-narrow">

                <label class="label">Product Manual Number</label>

                @if ($manual_doc_number)
                    <p><a href="/documents/view/{{$manual_doc_id}}" target="_blank">{{ $manual_doc_number.' '.$manual_doc_title }}</a></p>
                @else
                    <p>No Manual Selected</p>
                @endif

            </div>

            {{-- <div class="column">

                <button wire:click="$toggle('toggleManualSelect')" class="button is-light ml-6">

                    <span class="icon is-small">
                        @if ($toggleManualSelect)
                            <x-carbon-view-off />
                        @else
                            <x-carbon-view />
                        @endif
                    </span>

                </button>

            </div> --}}


        </div>










        {{-- @if ($toggleManualSelect) --}}
        @include('products.endproducts.manual-selection')

        {{-- @endif --}}








        <div class="field ">
            <label class="label">Interfaces</label>

            <div class="field-body">

                @if ($product_type == 'MST')

                <div class="field">

                    <label class="label">Mechanical Interfaces</label>

                    <div class="control">
                        <input type="checkbox" wire:model="payload_interface" wire:click="$toggle('payload_interface')"> Payload Interface<br>
                        <input type="checkbox" wire:model="roof_interface" wire:click="$toggle('roof_interface')"> Roof Interface<br>
                        <input type="checkbox" wire:model="side_interface" wire:click="$toggle('side_interface')"> Side Interface<br>
                        <input type="checkbox" wire:model="bottom_interface" wire:click="$toggle('bottom_interface')"> Bottom Interface<br>
                        <input type="checkbox" wire:model="guying_interface" wire:click="$toggle('guying_interface')"> Guying Interface<br>
                        <input type="checkbox" wire:model="hoisting_interface" wire:click="$toggle('hoisting_interface')"> Hoisting Interface<br>
                        <input type="checkbox" wire:model="lubrication_interface" wire:click="$toggle('lubrication_interface')"> Lubrication Interface<br>
                        <input type="checkbox" wire:model="manual_override_interface" wire:click="$toggle('manual_override_interface')"> Manual Override Interface<br>
                        <input type="checkbox" wire:model="wire_management" wire:click="$toggle('wire_management')"> Wire Management Interface<br>
                        <input type="checkbox" wire:model="wire_basket" wire:click="$toggle('wire_basket')"> Wire Basket Interface<br>
                        <input type="checkbox" wire:model="drainage" wire:click="$toggle('drainage')"> Drainage Interface<br>
                    </div>

                </div>

                @endif

                <div class="field">

                    <label class="label">Electrical Interfaces</label>
                    <div class="control">
                        <input type="checkbox" wire:model="vdc12_interface" wire:click="$toggle('vdc12_interface')"> 12 VDC Interface<br>
                        <input type="checkbox" wire:model="vdc24_interface" wire:click="$toggle('vdc24_interface')"> 24 VDC Interface<br>
                        <input type="checkbox" wire:model="vdc28_interface" wire:click="$toggle('vdc28_interface')"> 28 VDC Interface<br>
                        <input type="checkbox" wire:model="ac110_interface" wire:click="$toggle('ac110_interface')"> 110 AC Interface<br>
                        <input type="checkbox" wire:model="ac220_interface" wire:click="$toggle('ac220_interface')"> 220 AC Interface<br>
                    </div>

                </div>

            </div>
        </div>

        <livewire:ck-editor
            wire:model="finish"
            label='Finish and Color'
            placeholder='Describe mast finish and color'
            :content="$finish"/>

        @error('remarks')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror

        <livewire:ck-editor
            wire:model="remarks"
            label='Notes and Remarks'
            placeholder='Any kind of remarks/notes about part/product.'
            :content="$remarks"/>

        @error('remarks')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror


        <div class="field block">
            <label class="label">Customer Drawings</label>

            @if ($uid)
            @livewire('file-list', [
                'canDelete' => true,
                'model' => 'Sellable',
                'modelId' => $uid,
                'tag' => 'CustomerDrawings',                          // Any tag other than model name
            ])
            @endif

            <div class="control">
                @livewire('file-upload', [
                    'model' => 'Sellable',
                    'modelId' => $uid ? $uid : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'CustomerDrawings',                          // Any tag other than model name
                    'canEdit' => true])
            </div>
        </div>

        <div class="field block">
            <label class="label">STEP Files</label>

            @if ($uid)
                @livewire('file-list', [
                    'canDelete' => true,
                    'model' => 'Sellable',
                    'modelId' => $uid,
                    'tag' => 'STEP',                          // Any tag other than model name
                ])
            @endif

            <div class="control">

                @livewire('file-upload', [
                    'model' => 'Sellable',
                    'modelId' => $uid ? $uid : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'STEP',                          // Any tag other than model name
                    'canEdit' => true])
            </div>
        </div>

        <div class="buttons is-right">
            @if ($uid)
                <button wire:click.prevent="storeUpdateItem()" class="button is-dark">{{ $constants['update']['submitText'] }}</button>
            @else
                <button wire:click.prevent="storeUpdateItem()" class="button is-dark">{{ $constants['create']['submitText'] }}</button>
            @endif
        </div>

    </form>

</div>
