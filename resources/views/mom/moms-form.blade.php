<section class="section container">

    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    @assets
    <script src="{{ asset('/js/air-datepicker.js') }}" defer></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/js/air-datepicker.css') }}">
    @endassets

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">MOMs - Minutes of Meetings</h1>
        <h2 class="subtitle has-text-weight-light">{{ $uid ? 'Update MOM Attibutes' : 'Add New MOM' }}</h2>
    </header>

    @if ($uid)
    <p class="title has-text-weight-light is-size-2">{{'MOM-'.$mom_no }}</p>
    @endif


    <form method="POST" enctype="multipart/form-data">
        @csrf

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

                <div class="field is-narrow">
                    <label class="label">Toplantının Tarihi / Meeting Date</label>
                    <div class="control">
                        <input class="input" type="label" id="meeting_dates" placeholder="Tarih ..." readonly>
                    </div>
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
            cktype="FULL"
            label='Toptantı Tutanağı / Meeting Minutes'
            placeholder='Tutanak / Minutes ....'
            :content="$minutes"/>

        @error('minutes')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror


        <livewire:ck-editor
            wire:model="remarks"
            cktype="STD"
            label='Notlar / Remarks'
            placeholder='....'
            :content="$remarks"/>

        @error('remarks')
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

    new AirDatepicker('#meeting_dates', {
        range: true,
        multipleDatesSeparator: ' - ',
        multipleDates: true,
        locale: {
            days: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
            daysShort: ['Pzr', 'Pts', 'Sl', 'Çar', 'Per', 'Cum', 'Cts'],
            daysMin: ['Pa', 'Pt', 'Sl', 'Ça', 'Pe', 'Cu', 'Ct'],
            months: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
            monthsShort: ['Oca', 'Şbt', 'Mrt', 'Nsn', 'Mys', 'Hzr', 'Tmz', 'Ağt', 'Eyl', 'Ekm', 'Ksm', 'Arl'],
            today: 'Bugün',
            clear: 'Temizle',
            dateFormat: 'dd-MM-yyyy',
            timeFormat: 'hh:mm aa',
            firstDay: 1
        },
        onSelect: (dp) => {
            console.log(dp.formattedDate)
            Livewire.dispatch('onCalendarClicked',  { meeting_dates: dp.formattedDate })
        },

        selectedDates: @json($mom_date)
    })

</script>
@endscript
