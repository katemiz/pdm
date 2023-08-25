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
                  <input type="radio" name="is_for_ecn" value="1" @checked( $cr->is_for_ecn )>
                  Yes
                </label>
                <label class="radio">
                  <input type="radio" name="is_for_ecn" value="0" @checked( !$cr->is_for_ecn )>
                  No
                </label>
            </div>

            @error('is_for_ecn')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>
        @endcan

        <x-editor :params="config('crs.form.description')" value="{{ $cr ? $cr->description : '' }}"/>

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
