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




        {{--
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

        </div> --}}





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



        <div class="field">

            <label class="label" for="topic">Buyable Product Title/Description</label>
            <div class="control">

                <input
                    class="input"
                    id="description"
                    wire:model="description"
                    type="text"
                    value="{{ $uid ? $description : ''}}"
                    placeholder="Write Buyable Product Title/Description" required>
            </div>

            @error('description')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>

















        <div class="columns">

            <div class="column is-half">
                <div class="field">

                    <label class="label">Vendor Name</label>
                    <div class="control">
                        <input
                            class="input"
                            id="vendor"
                            wire:model="vendor"
                            type="text"
                            value="{{ $uid ? $vendor : ''}}"
                            placeholder="Vendor name ..." required>
                    </div>

                    @error('vendor')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="column is-half">
                <div class="field">

                    <label class="label">Vendor Part Number</label>
                    <div class="control">
                        <input
                            class="input"
                            id="vendor_part_no"
                            wire:model="vendor_part_no"
                            type="text"
                            value="{{ $uid ? $vendor_part_no : ''}}"
                            placeholder="Vendor part number ..." required>
                    </div>

                    @error('vendor_part_no')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>



        </div>








        <div class="field">

            <label class="label">Part Web Site / URL</label>
            <div class="control">
                <input
                    class="input"
                    id="url"
                    wire:model="url"
                    type="text"
                    value="{{ $uid ? $url : ''}}"
                    placeholder="Part Web Site / URL" required>
            </div>

            @error('url')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>











        <div class="columns">

            <div class="column is-half">
                <div class="field">

                    <label class="label">Weight (kg)</label>
                    <div class="control">
                        <input
                            class="input"
                            id="weight"
                            wire:model="weight"
                            type="text"
                            value="{{ $uid ? $weight : ''}}"
                            placeholder="Weight (kg)" required>
                    </div>

                    @error('weight')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="column is-half">
                <div class="field">

                    <label class="label">Material</label>
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


        </div>




        <livewire:ck-editor
            wire:model="remarks"
            label='Notes and Remarks'
            placeholder='notes ...'
            :content="$remarks"/>

        @error('remarks')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror





        <div class="field block">
            <label class="label">Datasheets/Documents</label>

            @if ($uid)
            @livewire('file-list', [
                'canDelete' => true,
                'model' => 'Product',
                'modelId' => $uid,
                'tag' => 'Datasheet',                          // Any tag other than model name
            ])
            @endif

            <div class="control">
                @livewire('file-upload', [
                    'model' => 'Product',
                    'modelId' => $uid ? $uid : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'Datasheet',                          // Any tag other than model name
                    'canEdit' => true])
            </div>
        </div>

        <div class="field block">
            <label class="label">3D Files</label>

            @if ($uid)
                @livewire('file-list', [
                    'canDelete' => true,
                    'model' => 'Product',
                    'modelId' => $uid,
                    'tag' => '3D',                          // Any tag other than model name
                ])
            @endif

            <div class="control">

                @livewire('file-upload', [
                    'model' => 'Product',
                    'modelId' => $uid ? $uid : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => '3D',                          // Any tag other than model name
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
