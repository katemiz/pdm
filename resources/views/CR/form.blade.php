
<script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>


<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">{{ $item ? $constants['update']['title'] : $constants['create']['title'] }}</h1>
    <h2 class="subtitle has-text-weight-light">{{ $item ? $constants['update']['subtitle'] : $constants['create']['subtitle']}}</h2>
</header>

@if ($item)
<span class="tag is-dark is-large mb-6">CR-{{ $item->id}}</span>                       
@endif

{{-- <form action="{{ $constants['cu_route'] }}{{ $cr ? $cr->id : '' }}" method="POST" enctype="multipart/form-data"> --}}
<form method="POST" enctype="multipart/form-data">
@csrf

    <div class="field">

        <label class="label" for="topic">Topic / Konu</label>
        <div class="control">

            <input
                class="input"
                name="topic"
                id="topic"
                type="text"
                value="{{ $item ? $item->topic : ''}}"
                placeholder="Konuyu yazınız" required>
        </div>

        @error('topic')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>

    @can('engineering')
    <div class="field">

        <label class="label" for="is_new">Is this request for an ECN authority?</label>

        <div class="control">
            <label class="radio">
                <input type="radio" name="is_for_ecn" value="1" @checked( $item && $item->is_for_ecn )>
                Yes
            </label>
            <label class="radio">
                <input type="radio" name="is_for_ecn" value="0" @checked( $item && !$item->is_for_ecn )>
                No
            </label>
        </div>

        @error('is_for_ecn')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>
    @endcan

    {{-- <x-editor :params="config('crs.form.description')" value="{{ $item ? $item->description : '' }}"/> --}}











        <div wire:ignore>
            <textarea wire:model="message"
                      class="min-h-fit h-48 "
                      name="message"
                      id="message"></textarea>
        </div>



        <div class="field">

            <div class="field">
              <label class="label">{{ $constants['form']['description']['label'] }}</label>
              <div wire:ignore class="control">
                <textarea class="textarea ckeditor" 
                    id="{{ $constants['form']['description']['name'] }}" 
                    name="{{ $constants['form']['description']['name'] }}" 
                    placeholder="{{ $constants['form']['description']['placeholder'] }}">
                    {!! $item ? $item->description : '' !!}
                </textarea>
              </div>
            </div>
          
            <script>
                ClassicEditor
                  .create( document.querySelector('#{{ $constants['form']['description']['name'] }}') )
                  .then( editor => {
                })
                .catch( error => {
                  console.error(error);
                });
            </script>
          
            @error($constants['form']['description']['name'])
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
          
        </div>





















    <div class="field">
        <label class="label">Dosyalar / Files</label>
        <div class="control">
            @livewire('attach-component',[
                'model' => 'CR',
                'modelId' => '0',
                'isMultiple' => false,
                'hasItsForm' => false,
                'tag' => 'CR',
                'canEdit' => true] , 'CR')
        </div>
    </div>



    @cannot('cr_approver')
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
    @endcan













    <div class="buttons is-right">
        <button class="button submit is-dark">{{ $item ? $constants['update']['submitText'] : $constants['create']['submitText'] }}</button>
    </div>

</form>

