<section class="section container">

    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">Standard Families</h1>
        <h2 class="subtitle has-text-weight-light">{{ $uid ? 'Update Standard Family Attribues': 'Add New Standard Family' }}</h2>
    </header>

    @if ($uid)
    <p class="title has-text-weight-light is-size-2">{{ $standard_number }}</p>
    @endif


    <form method="POST" enctype="multipart/form-data">
        @csrf

        <div class="field">
            <label class="label">Standard Number</label>
            <div class="control">
                <input class="input" type="text" wire:model='standard_number' placeholder="eg DIN 912 ...">
            </div>

            @error('standard_number')
                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror

        </div>


        <div class="field">
            <label class="label">Standard Description</label>
            <div class="control">
                <input class="input" type="text" wire:model='description' placeholder="eg Hexagon Socket Head Shoulder Screws ...">
            </div>

            @error('description')
                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror

        </div>


        <livewire:ck-editor
            wire:model="remarks"
            cktype="STANDARD"
            label='Document Synopsis / Notes / Remarks'
            placeholder='Document Synopsis / Notes / Remarks ....'
            :content="$remarks"/>

        @error('remarks')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror

        <div class="field block">
            <label class="label">Attach Original Document</label>

            @livewire('file-list', [
                'canDelete' => true,
                'model' => 'Standard',
                'modelId' => $uid,
                'tag' => 'STD',                          // Any tag other than model name
            ])

            <div class="control">
                @livewire('file-upload', [
                    'model' => 'Standard',
                    'modelId' => $uid ? $uid : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'STD'                         // Any tag other than model name
                ])
            </div>
        </div>


        <div class="buttons is-right">
            <button wire:click.prevent="storeUpdateItem()" class="button is-dark">
                {{ $uid ? 'Update Standard Family' : 'Add New Standard Family'}}
            </button>
        </div>




    </form>

    {{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif --}}


</section>
