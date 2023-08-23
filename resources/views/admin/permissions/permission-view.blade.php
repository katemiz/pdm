<x-pdm-layout>

    <script>
        function deleteConfirm (id) {
            Swal.fire({
            title: "Do you want to delete this role?",
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
                    window.location.href = '/admin/permissions/delete/'+id
                } else {
                    return false
                }
            })
        };
    </script>

    <div class="section container">

        <header class="mb-6">
            <h1 class="title has-text-weight-light is-size-1">{{ config('permissions.read.title') }}</h1>

            @if ( config('permissions.read.subtitle') )
                <h2 class="subtitle has-text-weight-light">{{ config('permissions.read.subtitle') }}</h2>
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
                                  <a href="/admin/permissions" class="button is-info is-light is-small">
                                    <span class="icon is-small"><x-carbon-list /></span>
                                  </a>
                                </p>

                                <p class="control ml-5">
                                  <a href="/admin/permissions/form" class="button is-link is-light is-small">
                                    <span class="icon is-small"><x-carbon-add /></span>
                                    <span>Add New</span>
                                  </a>
                                </p>


                                @if ($canEdit)
                                <p class="control ml-1">
                                    <a href="/admin/permissions/form/{{ $permission->id }}" class="button is-link is-light is-small">
                                      <span class="icon is-small"><x-carbon-edit /></span>
                                      <span>Edit</span>
                                    </a>
                                </p>

                                <p class="control ml-1">
                                    <button class="button is-danger is-light is-small" onclick="deleteConfirm({{ $permission->id }})">
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
                        <x-carbon-ticket />
                    </figure>
                    </div>
                    <div class="media-content">
                      <p class="title is-4">{{ $permission->name }}</p>
                      <p class="subtitle is-6">{{ $permission->created_at}}</p>
                    </div>
                </div>



            </div>




        </div>
</div>

</x-pdm-layout>













