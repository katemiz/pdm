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

            {{-- @if ($isForNewProduct)
                <span class="tag is-success is-large mb-6">New</span>
            @else
                <span class="tag is-warning is-large mb-6">Change</span>
            @endif --}}

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
                            @checked($item && $ecn->id == $item->c_notice_id))> ECN-{{ $ecn->id }}
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







        <div class="columns">

            <div class="column is-4">

                <div class="field">

                    <label class="label" for="topic">Material Family</label>
                    <div class="control">
                        <div class="select">
                            <select wire:model='mat_family'>
                            <option>Select Family</option>
        
                            @foreach (config('material.family') as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
        
                    @error('family')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="column is-4">
                <div class="field">

                    <label class="label" for="topic">Material Form</label>
                    <div class="control">
                        <div class="select">
                            <select wire:model='mat_form'>
                            <option>Select Form</option>
        
                            @foreach (config('material.form') as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
        
                    @error('form')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="column is-4">
ddd
            </div>

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

        <div class="field">
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

        <div class="field">
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

        <div class="buttons is-right">
            @if ($item)
                <button wire:click.prevent="updateItem()" class="button is-dark">{{ $constants['update']['submitText'] }}</button>
            @else
                <button wire:click.prevent="storeItem()" class="button is-dark">{{ $constants['create']['submitText'] }}</button>
            @endif
        </div>

    </form>

</div>
