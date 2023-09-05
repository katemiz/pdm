<x-pdm-layout title="Değişiklik Talebi - Change Requests">

    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <div class="section container">

        @if ($cr)

            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">{{ config('crs.update.title') }}</h1>

                @if ( config('crs.update.subtitle') )
                    <h2 class="subtitle has-text-weight-light">{{ config('crs.update.subtitle') }}</h2>
                @endif
            </header>

            @if ($cr)
            <span class="tag is-dark is-large mb-6">CR-{{ $cr->id}}</span>
            @endif

        @else
            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">{{ config('crs.create.title') }}</h1>

                @if ( config('crs.create.subtitle') )
                    <h2 class="subtitle has-text-weight-light">{{ config('crs.create.subtitle') }}</h2>
                @endif
            </header>
        @endif

        <form action="{{ config('crs.cu_route') }}{{ $cr ? $cr->id : '' }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="field">

            <label class="label" for="topic">Topic / Konu</label>
            <div class="control has-icons-right">

                <input
                    class="input"
                    name="topic"
                    id="topic"
                    type="text"
                    value="{{ $cr ? $cr->topic : ''}}"
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
                  <input type="radio" name="is_for_ecn" value="1" @checked( $cr && $cr->is_for_ecn )>
                  Yes
                </label>
                <label class="radio">
                  <input type="radio" name="is_for_ecn" value="0" @checked( $cr && !$cr->is_for_ecn )>
                  No
                </label>
            </div>

            @error('is_for_ecn')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>
        @endcan

        <x-editor :params="config('crs.form.description')" value="{{ $cr ? $cr->description : '' }}"/>


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








        @livewire('ck-editor',[
            'label' => 'Değişiklik İçeriği / CR Content',
            'varname' => 'cr_content',
            'placeholder' => 'Değişikliği ayrıntılı bir şekilde tarif ediniz.',
            'content' => ''
        ])




        <div class="buttons is-right">
            @if ($cr)
            <button class="button submit is-dark">{{ config('crs.update.submitText') }}</button>
            @else
            <button class="button submit is-dark">{{ config('crs.create.submitText') }}</button>
            @endif
        </div>

        </form>

    </div>
</x-pdm-layout>
