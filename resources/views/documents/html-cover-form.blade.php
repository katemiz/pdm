


    <header class="mb-6">
        <h2 class="subtitle has-text-weight-light has-text-info">{{ $uid ? 'Edit Doc Properties' : 'Doc Details' }}</h2>
    </header>

    <form method="POST" enctype="multipart/form-data">
        @csrf




        <div class="field">
            <label class="label">Select Company</label>
            <div class="control">
                @foreach ($companies as $company)
                <label class="radio">
                    <input type="radio" value="{{$company->id}}" wire:model="company_id">
                    {{$company->name}}
                    </label>
                @endforeach
            </div>

            @error('company_id')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>










        <div class="field">
            <label class="label">Select Document Type</label>
            <div class="control">
                @foreach ($doc_types as $abbr => $type_name)
                <label class="radio">
                    <input type="radio" value="{{$abbr}}" wire:model="doc_type">
                    {{$type_name}}
                    </label>
                @endforeach
            </div>

            @error('doc_type')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>


        <div class="field">
            <label class="label">Document Title</label>
            <div class="control">
                <input class="input" type="text" wire:model='title' placeholder="Document title/description ...">
            </div>

            @error('title')
                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror

        </div>







        <livewire:ck-editor
            wire:model="remarks"
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
                'model' => 'Document',
                'modelId' => $uid,
                'tag' => 'document',                          // Any tag other than model name
            ])

            <div class="control">
                @livewire('file-upload', [
                    'model' => 'Document',
                    'modelId' => $uid ? $uid : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'document'                         // Any tag other than model name
                ])
            </div>
        </div>























        <div class="buttons is-right">
            <button wire:click.prevent="storeUpdateCover()" class="button is-dark">
                @if ($uid)
                    {{ $constants['update']['submitText'] }}
                @else
                    {{ $constants['create']['submitText'] }}
                @endif
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


