<x-pdm-layout>

    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <div class="section container">

        @if ($permission)


            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">{{ config('permissions.update.title') }}</h1>

                @if ( config('permissions.update.subtitle') )
                    <h2 class="subtitle has-text-weight-light">{{ config('permissions.update.subtitle') }}</h2>
                @endif
            </header>


        @else
            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">{{ config('permissions.create.title') }}</h1>

                @if ( config('permissions.create.subtitle') )
                    <h2 class="subtitle has-text-weight-light">{{ config('permissions.create.subtitle') }}</h2>
                @endif
            </header>
        @endif

        <form action="{{ config('permissions.cu_route') }}{{ $permission ? $permission->id : '' }}" method="POST" enctype="multipart/form-data">
        @csrf


        <div class="field">

            <label class="label" for="name">Name</label>

            <div class="control has-icons-right">

                <input
                    class="input"
                    name="name"
                    id="name"
                    type="text"
                    value="{{ $permission ? $permission->name : ''}}"
                    placeholder="Name" required>
            </div>

            @error('name')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>









        <div class="buttons is-right">
            @if ($permission)
            <button class="button is-dark">{{ config('permissions.update.submitText') }}</button>
            @else
            <button class="button is-dark">{{ config('permissions.create.submitText') }}</button>
            @endif
        </div>

        </form>



    </div>
</x-pdm-layout>
