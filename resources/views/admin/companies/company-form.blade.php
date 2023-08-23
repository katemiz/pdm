<x-pdm-layout>

    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <div class="section container">

        @if ($company)


            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">{{ config('companies.update.title') }}</h1>

                @if ( config('companies.update.subtitle') )
                    <h2 class="subtitle has-text-weight-light">{{ config('companies.update.subtitle') }}</h2>
                @endif
            </header>


        @else
            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">{{ config('companies.create.title') }}</h1>

                @if ( config('companies.create.subtitle') )
                    <h2 class="subtitle has-text-weight-light">{{ config('companies.create.subtitle') }}</h2>
                @endif
            </header>
        @endif

        <form action="{{ config('companies.cu_route') }}{{ $company ? $company->id : '' }}" method="POST" enctype="multipart/form-data">
        @csrf


        <div class="field">

            <label class="label" for="shortname">Company Short Name</label>

            <div class="control has-icons-right">

                <input
                    class="input"
                    name="shortname"
                    id="shortname"
                    type="text"
                    value="{{ $company ? $company->shortname : ''}}"
                    placeholder="Company Short Name" required>
            </div>

            @error('shortname')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">

            <label class="label" for="fullname">Company Full Name</label>

            <div class="control has-icons-right">

                <input
                    class="input"
                    name="fullname"
                    id="fullname"
                    type="text"
                    value="{{ $company ? $company->fullname : ''}}"
                    placeholder="Lastame" required>
            </div>

            @error('lastname')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>









        <x-editor :params="config('companies.form.remarks')" value="{{ $company ? $company->remarks : '' }}"/>







        <div class="buttons is-right">
            @if ($company)
            <button class="button is-dark">{{ config('companies.update.submitText') }}</button>
            @else
            <button class="button is-dark">{{ config('companies.create.submitText') }}</button>
            @endif
        </div>

        </form>



    </div>
</x-pdm-layout>
