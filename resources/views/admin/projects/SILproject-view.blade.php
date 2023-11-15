<x-pdm-layout>

    <script>
        function deleteConfirm (id) {
            Swal.fire({
            title: "Do you want to delete this company?",
            text: "Once deleted, there is no turning back!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Ooops ...',

            }).then((result) => {
                if (result.isConfirmed) {
                    // this.Livewire.emit('runDelete',e.detail.id)
                    window.location.href = '/admin/projects/delete/'+id
                } else {
                    return false
                }
            })
        };
    </script>

    <div class="section container">

        <header class="mb-6">
            <h1 class="title has-text-weight-light is-size-1">{{ config('projects.read.title') }}</h1>

            @if ( config('projects.read.subtitle') )
                <h2 class="subtitle has-text-weight-light">{{ config('projects.read.subtitle') }}</h2>
            @endif
        </header>

        @if (session()->has('message'))
            <div class="notification">
                {{ session('message') }}
            </div>
        @endif

        <div class="card">

            <div class="card-content">

                <div class="content">

                    <div class="columns">

                        <div class="column is-half">
                            <div class="field has-addons">

                                <p class="control">
                                  <a href="/admin/projects" class="button is-info is-light is-small">
                                    <span class="icon is-small"><x-carbon-list /></span>
                                  </a>
                                </p>

                                <p class="control ml-5">
                                  <a href="/admin/projects/form" class="button is-link is-light is-small">
                                    <span class="icon is-small"><x-carbon-add /></span>
                                    <span>Add New</span>
                                  </a>
                                </p>


                                @if ($canEdit)
                                <p class="control ml-1">
                                    <a href="/admin/projects/form/{{ $project->id }}" class="button is-link is-light is-small">
                                      <span class="icon is-small"><x-carbon-edit /></span>
                                      <span>Edit</span>
                                    </a>
                                </p>

                                <p class="control ml-1">
                                    <button class="button is-danger is-light is-small" onclick="deleteConfirm({{ $project->id }})">
                                        <span class="icon is-small"><x-carbon-trash-can /></span>
                                        <span>Delete</span>
                                    </button>
                                </p>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

                <div class="media">
                    <div class="media-left">
                      <figure class="image is-48x48">
                        <x-carbon-building />
                      </figure>
                    </div>
                    <div class="media-content">
                      <p class="title is-4"> {{ $project->shortname }}</p>
                      <p class="subtitle is-6">{{ $project->fullname}}</p>
                    </div>
                </div>

                @if ( strlen($project->remarks) > 0)
                <div class="notification">
                    {!! $project->remarks !!}
                </div>
                @endif


                {{-- @if ($attachments->count() > 0)

                <table class="table is-fullwidth is-size-7">

                    @foreach ($attachments as $key => $attachment)
                    <tr class="my-0">
                        <td class="is-narrow">{{ ++$key }}</td>
                        <td>
                            <a wire:click="downloadFile('{{ $attachment->id }}')">{{ $attachment->original_file_name }}</a>
                        </td>
                        <td class="is-narrow">{{ $attachment->mime_type }}</td>
                        <td class="is-narrow">{{ $attachment->file_size }}</td>
                    </tr>
                    @endforeach

                </table>
                @endif --}}

                {{-- <div class="field"> --}}

                    {{-- <label class="label" for="description">Photo</label> --}}

                    {{-- @livewire('attachment-component', [
                        'model' => 'User',
                        'modelId' => $project ? $project->id : '' ,
                        'isMultiple'=> false,
                        'tag' => 'Photo',
                        'canEdit' => $canEdit], 'Photo') --}}
                {{-- </div> --}}





            </div>




        </div>
</div>

</x-pdm-layout>













