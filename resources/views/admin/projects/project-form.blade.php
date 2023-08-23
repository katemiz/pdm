<x-pdm-layout>

    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <div class="section container">

        @if ($project)


            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">{{ config('projects.update.title') }}</h1>

                @if ( config('projects.update.subtitle') )
                    <h2 class="subtitle has-text-weight-light">{{ config('projects.update.subtitle') }}</h2>
                @endif
            </header>


        @else
            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">{{ config('projects.create.title') }}</h1>

                @if ( config('projects.create.subtitle') )
                    <h2 class="subtitle has-text-weight-light">{{ config('projects.create.subtitle') }}</h2>
                @endif
            </header>
        @endif

        <form action="{{ config('projects.cu_route') }}{{ $project ? $project->id : '' }}" method="POST" enctype="multipart/form-data">
        @csrf


        <div class="field">

            <label class="label" for="shortname">Project Short Name</label>

            <div class="control has-icons-right">

                <input
                    class="input"
                    name="shortname"
                    id="shortname"
                    type="text"
                    value="{{ $project ? $project->shortname : ''}}"
                    placeholder="Project Short Name" required>
            </div>

            @error('shortname')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">

            <label class="label" for="fullname">Project Full Title</label>

            <div class="control has-icons-right">

                <input
                    class="input"
                    name="fullname"
                    id="fullname"
                    type="text"
                    value="{{ $project ? $project->fullname : ''}}"
                    placeholder="Project full title" required>
            </div>

            @error('lastname')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>









        <x-editor :params="config('projects.form.remarks')" value="{{ $project ? $project->remarks : '' }}"/>







        <div class="buttons is-right">
            @if ($project)
            <button class="button is-dark">{{ config('projects.update.submitText') }}</button>
            @else
            <button class="button is-dark">{{ config('projects.create.submitText') }}</button>
            @endif
        </div>

        </form>



    </div>
</x-pdm-layout>
