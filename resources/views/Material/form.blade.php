<div>
    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">{{ $item ? $constants['update']['title'] : $constants['create']['title'] }}</h1>
        <h2 class="subtitle has-text-weight-light">{{ $item ? $constants['update']['subtitle'] : $constants['create']['subtitle']}}</h2>
    </header>

    @if ($item)
        <span class="tag is-dark is-large mb-6">CR-{{ $item->id}}</span>
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





        <div class="field">

            <label class="label" for="description">Material Descriptionu</label>
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


        <livewire:ck-editor
            edId="ed10"
            wire:model="remarks"
            label='Notes and/or Remarks'
            placeholder='Enter remarks/notes here'
            :content="$description"/>

        @error('description')
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

            {{-- @if ( count($cr_approvers) > 0) --}}

                {{-- @if ( $cr_approver )

                    <span class="is-size-4">{{ $cr_approver->name }} {{ $cr_approver->lastname }}</span>
                    <span class="is-size-6">{{ $cr_approver->email }}</span>

                    <input type="hidden" name="cr_approver" id="cr_approver" value="{{ $cr_approver->id}}">
                @else --}}
                    <div class="control">
                        <div class="select">
                            <select wire:model='status'>
                            <option value="A">Active</option>
                            <option value="I">Inactive</option>
                            </select>
                        </div>
                    </div>
                {{-- @endif --}}

            {{-- @else
                <div class="notification is-warning">
                    Şu anda tanımlı CR Onaylama Yetkisine sahip kimse bulunmamaktadır.
                </div>
            @endif --}}

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
