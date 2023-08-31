



<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">{{ $constants['read']['title'] }}</h1>

    {{-- @if ( $constants('read.subtitle') )
        <h2 class="subtitle has-text-weight-light">{{ $constants('read.subtitle') }}</h2>
    @endif --}}
</header>

@if (session()->has('message'))
    <div class="notification">
        {{ session('message') }}
    </div>
@endif

@if ($item)
<span class="tag is-dark is-large">CR-{{ $item->id}}</span>
@endif

<div class="card">

    <div class="card-content">

        <div class="content">






            <div class="columns">

                <div class="column is-half">
                    <div class="field has-addons">

                        <p class="control">
                            <a href="/cr/list" class="button is-info is-light is-small">
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
                            <a href="/cr/form/{{ $item->id }}" class="button is-link is-light is-small">
                            {{-- <a class="button is-link is-light is-small" wire:click="editItem({{ $item->id }})"> --}}
                                <span class="icon is-small"><x-carbon-edit /></span>
                                <span>Edit</span>
                            </a>
                        </p>
                        @endif


                        @if ($canDelete)
                        <p class="control ml-1">
                            <button class="button is-danger is-light is-small" wire:click.prevent="deleteConfirm({{$item->id}})">
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
                <p class="title is-4"> CR-{{ $item->id }}</p>
                <p class="subtitle is-6">{{ $item->topic}}</p>
            </div>
        </div>

        @if ( $item->is_for_ecn === 1)
        <div class="notification is-info is-light">
            This CR is for new Design
        </div>
        @endif


        @if ( strlen($item->description) > 0)
        <div class="notification">
            {!! $item->description !!}
        </div>
        @endif

        <label class="label">Dosyalar</label>



        @livewire('attach-component', [
            'hasForm' => false,                      // true when possible to add/remove file otherwise false
            'model' => 'CR',
            'modelId' => $item->id,
            'isMultiple'=> false,                   // can multiple files be selected
            'tag' => 'CR',                          // Any tag other than model name
            'canEdit' => $canEdit], 'CR')





    </div>




</div>














