<div>
    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">{{ $item ? $constants['update']['title'] : $constants['create']['title'] }}</h1>
        <h2 class="subtitle has-text-weight-light">{{ $item ? $constants['update']['subtitle'] : $constants['create']['subtitle']}}</h2>
    </header>

    @if ($item)
        <span class="tag is-dark is-large mb-6">M-{{ $item->id}}</span>
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


        <div class="field ">

            <div class="field-body">

                <div class="field">

                    <label class="label" for="topic">Material Family</label>
                    <div class="control">
                        <div class="select">
                            <select wire:model='family'>
                            <option>Select Family</option>

                            @foreach ($constants['family'] as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    @error('family')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">

                    <label class="label" for="topic">Material Form</label>
                    <div class="control">
                        <div class="select">
                            <select wire:model='form'>
                            <option>Select Form</option>

                            @foreach ($constants['form'] as $key => $value)
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
        </div>


        <div class="field">

            <label class="label" for="description">Material Description</label>
            <div class="control">

                <input
                    class="input"
                    id="description"
                    wire:model="description"
                    type="text"
                    value="{{ $item ? $item->description : ''}}"
                    placeholder="eg 6061 T6" required>
            </div>

            @error('description')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>



        <div class="field">

            <label class="label" for="specification">Material Specification</label>
            <div class="control">

                <input
                    class="input"
                    id="specification"
                    wire:model="specification"
                    type="text"
                    value="{{ $item ? $item->specification : ''}}"
                    placeholder="eg 6061 T6" required>
            </div>

            @error('specification')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>




        <livewire:ck-editor
            wire:model="remarks"
            label='Notes and/or Remarks'
            placeholder='Enter remarks/notes here'
            :content="$remarks"/>

        @error('remarks')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror

        <div class="field">
            <label class="label">Dosyalar / Files</label>

            @if ($item)
            @livewire('file-list', [
                'canDelete' => true,
                'model' => 'CR',
                'modelId' => $item->id,
                'tag' => 'CR',                          // Any tag other than model name
            ], 'CR')
            @endif

            <div class="control">

                @livewire('file-upload', [
                    'hasForm' => true,                      // true when possible to add/remove file otherwise false
                    'model' => 'CR',
                    'modelId' => $item ? $item->id : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'CR',                          // Any tag other than model name
                    'canEdit' => $canEdit], 'CR')
            </div>
        </div>

        <div class="field">

            <label class="label" for="is_new">Status</label>

            <div class="control">
                <div class="select">
                    <select wire:model='status'>
                    <option value="A">Active</option>
                    <option value="I">Inactive</option>
                    </select>
                </div>
            </div>

            @error('is_for_ecn')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
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
