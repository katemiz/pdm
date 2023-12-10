<div>
    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">{{ $item ? $constants['update']['title'] : $constants['create']['title'] }}</h1>
        <h2 class="subtitle has-text-weight-light">{{ $item ? $constants['update']['subtitle'] : $constants['create']['subtitle']}}</h2>
    </header>

    @if ($item)
    <div class="control">
        <div class="tags has-addons">
            <span class="tag is-dark is-large mb-6">ECN-{{ $item->id}}</span>

            @if ($isForNewProduct)
                <span class="tag is-success is-large mb-6">New</span>
            @else
                <span class="tag is-warning is-large mb-6">Change</span>
            @endif

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

        <livewire:ck-editor
            wire:model="pre_description"
            label='Değişiklik İçeriği / CR Content'
            placeholder='Değişikliği ayrıntılı bir şekilde tarif ediniz.'
            :content="$pre_description"/>

        @error('pre_description')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror

        <div class="field">
            <label class="label">Dosyalar / Files</label>

            @if ($item)
            @livewire('file-list', [
                'canDelete' => true,
                'model' => 'ECN',
                'modelId' => $item->id,
                'tag' => 'ECN',                          // Any tag other than model name
            ], 'ECN')
            @endif

            <div class="control">

                @livewire('file-upload', [
                    'hasForm' => true,                      // true when possible to add/remove file otherwise false
                    'model' => 'ECN',
                    'modelId' => $item ? $item->id : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'ECN',                          // Any tag other than model name
                    'canEdit' => $canEdit], 'ECN')
            </div>
        </div>

        {{-- @cannot('cr_approver')
        <div class="field">

            <label class="label" for="is_new">Onaylayan / CR Request Appprover</label>

            @if ( count($cr_approvers) > 0)

                @if ( $cr_approver )

                    <span class="is-size-4">{{ $cr_approver->name }} {{ $cr_approver->lastname }}</span>
                    <span class="is-size-6">{{ $cr_approver->email }}</span>

                    <input type="hidden" name="cr_approver" id="cr_approver" value="{{ $cr_approver->id}}">
                @else
                    <div class="control">
                        <div class="select">
                            <select>
                            <option>Select dropdown</option>
                            <option>With options</option>
                            </select>
                        </div>
                    </div>
                @endif

            @else
                <div class="notification is-warning">
                    Şu anda tanımlı CR Onaylama Yetkisine sahip kimse bulunmamaktadır.
                </div>
            @endif

            @error('is_for_ecn')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>
        @endcan --}}

        <div class="buttons is-right">
            @if ($item)
                <button wire:click.prevent="updateItem()" class="button is-dark">{{ $constants['update']['submitText'] }}</button>
            @else
                <button wire:click.prevent="storeItem()" class="button is-dark">{{ $constants['create']['submitText'] }}</button>
            @endif
        </div>

    </form>

</div>
