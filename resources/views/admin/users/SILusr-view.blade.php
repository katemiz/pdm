<x-pdm-layout>

    <script>
        function deleteConfirm (id) {
            Swal.fire({
            title: "Do you want to delete this user?",
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
                    window.location.href = '/admin/users/delete/'+id
                } else {
                    return false
                }
            })
        };
    </script>

    <div class="section container">

        <header class="mb-6">
            <h1 class="title has-text-weight-light is-size-1">{{ config('users.read.title') }}</h1>

            @if ( config('users.read.subtitle') )
                <h2 class="subtitle has-text-weight-light">{{ config('users.read.subtitle') }}</h2>
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
                                  <a href="/admin/users" class="button is-info is-light is-small">
                                    <span class="icon is-small"><x-carbon-list /></span>
                                  </a>
                                </p>

                                <p class="control ml-5">
                                  <a href="/admin/users/form" class="button is-link is-light is-small">
                                    <span class="icon is-small"><x-carbon-add /></span>
                                    <span>Add New</span>
                                  </a>
                                </p>


                                @if ($canEdit)
                                <p class="control ml-1">
                                    <a href="/admin/users/form/{{ $usr->id }}" class="button is-link is-light is-small">
                                      <span class="icon is-small"><x-carbon-edit /></span>
                                      <span>Edit</span>
                                    </a>
                                </p>

                                <p class="control ml-1">
                                    <button class="button is-danger is-light is-small" onclick="deleteConfirm({{ $usr->id }})">
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
                        <x-carbon-user />
                      </figure>
                    </div>
                    <div class="media-content">
                      <p class="title is-4"> {{ $usr->name }} {{ strtoupper($usr->lastname) }}</p>
                      <p class="subtitle is-6">{{ $usr->email}}</p>
                    </div>
                </div>

                @if ( strlen($usr->remarks) > 0)
                <div class="notification">
                    {!! $usr->remarks !!}
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
                        'modelId' => $usr ? $usr->id : '' ,
                        'isMultiple'=> false,
                        'tag' => 'Photo',
                        'canEdit' => $canEdit], 'Photo') --}}
                {{-- </div> --}}



                <table class="table is-fullwidth">

                    <tbody>
                      <tr>
                        <th>User Roles</th>
                        <th>User Permissions</th>
                      </tr>

                      <tr>
                        <td>
                          @foreach ($usr->roles as $role)
                            <p>{{ $role->name}}</p>
                          @endforeach
                        </td>

                        <td>
                          @foreach ($usr->permissions as $perm)
                            <p>{{ $perm->name}}</p>
                          @endforeach
                        </td>
                      </tr>
                    </tbody>
                </table>

            </div>




        </div>
</div>

</x-pdm-layout>













