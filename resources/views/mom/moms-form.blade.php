<section class="section container">

    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    @assets
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js" defer></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    @endassets

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">MOMs - Minutes of Meetings</h1>
        <h2 class="subtitle has-text-weight-light">{{ $uid ? 'Update MOM Attibutes' : 'Add New MOM' }}</h2>
    </header>

    @if ($uid)
    <p class="title has-text-weight-light is-size-2">{{'MOM-'.$id }}</p>
    @endif


    <form method="POST" enctype="multipart/form-data">
        @csrf



        <div class="field has-addons">
            <div class="control">
              <input class="input" type="text" placeholder="Find a repository" >
            </div>
            <div class="control">
              <a class="button is-info" data-deneme>
                Search
              </a>
            </div>
          </div>


        {{-- <div class="field">
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
        </div> --}}




        {{-- <div class="field">
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
        </div> --}}



        {{-- <div class="field">
            <label class="label">Document Language</label>
            <div class="control">
                @foreach ($languages as $key => $language)
                <label class="radio">
                    <input type="radio" value="{{$key}}" wire:model="language">
                    {{$language}}
                    </label>
                @endforeach
            </div>

            @error('language')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div> --}}


        <div class="field">

            <div class="field-body">

                <div class="field is-8">
                    <label class="label">Toplantı Yeri / Meeting Place</label>
                    <div class="control">
                        <input class="input" type="text" wire:model='place' placeholder="ör. Ankara / Online ...">
                    </div>

                    @error('place')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror

                </div>

                <div class="field">
                    <label class="label">Toplantının Tarihi / Meeting Date</label>
                    <div class="control">
                        <input class="input" type="label" wire:model='mom_start_date' placeholder="Tarih ..." readonly data-meetstart>
                    </div>

                    @error('mom_start_date')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror

                </div>

                <div class="field">
                    <label class="label">Toplantının Bitiş Tarihi / Meeting End Date</label>
                    <div class="control">
                        <input class="input" type="label" wire:model='mom_end_date' placeholder="Tarih ..." readonly data-meetend>
                    </div>

                    @error('mom_end_date')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror

                </div>

            </div>

        </div>








        <div class="field">
            <label class="label">Toplantının Konusu / Meeting Subject</label>
            <div class="control">
                <input class="input" type="text" wire:model='subject' placeholder="Toplantı konusu / meeting subject ...">
            </div>

            @error('subject')
                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror

        </div>


        <livewire:ck-editor
            wire:model="minutes"
            cktype="STANDARD"
            label='Toptantı Tutanağı / Meeting Minutes'
            placeholder='Tutanak / Minutes ....'
            :content="$minutes"/>

        @error('minutes')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror


        <div class="field block">
            <label class="label">Ekler / Attachments</label>

            @livewire('file-list', [
                'canDelete' => true,
                'model' => 'MOM',
                'modelId' => $uid,
                'tag' => 'attachment',                          // Any tag other than model name
            ])

            <div class="control">
                @livewire('file-upload', [
                    'model' => 'MOM',
                    'modelId' => $uid ? $uid : false,
                    'isMultiple'=> true,                   // can multiple files be selected
                    'tag' => 'attachment'                         // Any tag other than model name
                ])
            </div>
        </div>























        <div class="buttons is-right">
            <button wire:click.prevent="storeUpdateItem()" class="button is-dark">
                {{ $uid ? 'Update MOM' : 'Add MOM' }}
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


@script
<script>
    new Pikaday({ field: $wire.$el.querySelector('[data-meetstart]') });
    new Pikaday({ field: $wire.$el.querySelector('[data-meetend]') });

    new Pikaday({ field: $wire.$el.querySelector('[data-deneme]') });


</script>
@endscript
