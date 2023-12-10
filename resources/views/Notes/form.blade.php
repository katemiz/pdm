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



        <div class="field">

            <label class="label" for="topic">Notes Category</label>
            <div class="control">
                <div class="select">
                    <select wire:model='category_id'>
                    <option>Select Category</option>

                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" @selected( $item && $item->category_id == $category->id )>
                            {{$category->text_en}} / {{$category->text_tr}}
                        </option>
                    @endforeach
                    </select>
                </div>
            </div>

            @error('category_id')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>




        <div class="field">

            <label class="label" for="description">Product and Process Note (Türkçe)</label>
            <div class="control">

                <input
                    class="input"
                    id="text_tr"
                    wire:model="text_tr"
                    type="text"
                    value="{{ $item ? $item->text_tr : ''}}"
                    placeholder="Parça ve işleme notunu buraya yazınız" required>
            </div>

            @error('text_tr')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>




        <div class="field">

            <label class="label" for="description">Product and Process Note (English)</label>
            <div class="control">

                <input
                    class="input"
                    id="text_en"
                    wire:model="text_en"
                    type="text"
                    value="{{ $item ? $item->text_en : ''}}"
                    placeholder="Write here product and/or process note" required>
            </div>

            @error('text_en')
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
                'model' => 'UrunNotu',
                'modelId' => $item->id,
                'tag' => 'UrunNotu',                          // Any tag other than model name
            ])
            @endif

            <div class="control">

                @livewire('file-upload', [
                    'hasForm' => true,                      // true when possible to add/remove file otherwise false
                    'model' => 'UrunNotu',
                    'modelId' => $item ? $item->id : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'UrunNotu',                          // Any tag other than model name
                    'canEdit' => $canEdit])
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
