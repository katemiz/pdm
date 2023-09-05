<x-pdm-layout>

    <script>
        function deleteConfirm (id) {
            Swal.fire({
            title: "Do you want to delete this CR?",
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
                    window.location.href = '/cr/delete/'+id
                } else {
                    return false
                }
            })
        };
    </script>

    <div class="section container">

        <header class="mb-6">
            <h1 class="title has-text-weight-light is-size-1">{{ config('crs.read.title') }}</h1>

            @if ( config('crs.read.subtitle') )
                <h2 class="subtitle has-text-weight-light">{{ config('crs.read.subtitle') }}</h2>
            @endif
        </header>

        @if (session()->has('message'))
            <div class="notification">
                {{ session('message') }}
            </div>
        @endif

        @if ($cr)
        <span class="tag is-dark is-large">CR-{{ $cr->id}}</span>                       
        @endif

        <div class="card">

            <div class="card-content">

                <div class="content">






                    <div class="columns">

                        <div class="column is-half">
                            <div class="field has-addons">

                                <p class="control">
                                  <a href="/cr" class="button is-info is-light is-small">
                                    <span class="icon is-small"><x-carbon-list /></span>
                                  </a>
                                </p>

                                <p class="control ml-5">
                                  <a href="/cr/form" class="button is-link is-light is-small">
                                    <span class="icon is-small"><x-carbon-add /></span>
                                    <span>Add New</span>
                                  </a>
                                </p>


                                @if ($canEdit)
                                <p class="control ml-1">
                                    <a href="/cr/form/{{ $cr->id }}" class="button is-link is-light is-small">
                                      <span class="icon is-small"><x-carbon-edit /></span>
                                      <span>Edit</span>
                                    </a>
                                </p>

                                <p class="control ml-1">
                                    <button class="button is-danger is-light is-small" onclick="deleteConfirm({{ $cr->id }})">
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
                        <x-carbon-document-epdf />
                      </figure>
                    </div>
                    <div class="media-content">
                      <p class="title is-4"> CR-{{ $cr->id }}</p>
                      <p class="subtitle is-6">{{ $cr->topic}}</p>
                    </div>
                </div>

                @if ( $cr->is_for_ecn === 1)
                <div class="notification is-info is-light">
                    This CR is for new Design
                </div>
                @endif


                @if ( strlen($cr->description) > 0)
                <div class="notification">
                    {!! $cr->description !!}
                </div>
                @endif



                {{-- @livewire('attachments', [
                    'model' => 'CR',
                    'modelId' => $cr->id,
                    'isMultiple'=> false,
                    'tag' => 'CR',
                    'canEdit' => $canEdit], 'CR') --}}





            </div>




        </div>
</div>

</x-pdm-layout>













