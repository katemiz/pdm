<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">{{ $constants['read']['title'] }}</h1>

    @if ( $constants['read']['subtitle'] )
        <h2 class="subtitle has-text-weight-light">{{ $constants['read']['subtitle'] }}</h2>
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
                            <a href="/notes/list" class="button is-info is-light is-small">
                            <span class="icon is-small"><x-carbon-list /></span>
                            </a>
                        </p>

                        <p class="control ml-5">
                            <a href="/notes/form" class="button is-info is-light is-small">
                            {{-- <a wire:click="addNew()" class="button is-info is-light is-small"> --}}
                            <span class="icon is-small"><x-carbon-add /></span>
                            <span>Add New</span>
                            </a>
                        </p>

                        @if ($canEdit && $item->canEdit)
                        <p class="control ml-1">
                            <a class="button is-link is-light is-small" href='/notes/form/{{ $item->id }}'>
                                <span class="icon is-small"><x-carbon-edit /></span>
                                <span>Edit</span>
                            </a>
                        </p>
                        @endif

                        {{-- @if ($canDelete && $item->canDelete)
                        <p class="control ml-1">
                            <button class="button is-danger is-light is-small" wire:click.prevent="startCRDelete({{$item->id}})">
                                <span class="icon is-small"><x-carbon-trash-can /></span>
                                <span>Delete</span>
                            </button>
                        </p>
                        @endif --}}

                    </div>
                </div>

                {{-- @if (in_array($status,['wip']))
                <div class="column">
                    <div class="field has-addons is-pulled-right">

                        <p class="control">
                            <a wire:click="acceptCR({{ $item->id }})" class="button is-success is-light is-small">
                                <span class="icon is-small"><x-carbon-thumbs-up /></span>
                                <span>Accept / Kabul</span>
                            </a>
                        </p>

                        <p class="control ml-5">
                            <a onclick="showModal('m20')" class="button is-danger is-light is-small">
                                <span class="icon is-small"><x-carbon-thumbs-down /></span>
                                <span>Reject / Red</span>
                            </a>
                        </p>

                    </div>
                </div>
                @endif --}}

            </div>
        </div>

        <div class="media">
            <div class="media-left">
                <figure class="image is-48x48">
                    <x-carbon-catalog />
                </figure>
            </div>
            <div class="media-content">
                <p class="title is-4"> N-{{ $item->id }}</p>
            </div>
        </div>

        <label class="label">Not (Türkçe)</label>

        <p class="mb-3"> {{ $item->text_tr }}</p>

        <label class="label">Note (in English)</label>
        <p> {{ $item->text_en }}</p>

        @if ( strlen($item->remarks) > 0)
        <div class="notification">
            <label class="label">Remarks</label>
            {!! $item->remarks !!}
        </div>
        @endif


        @livewire('file-list', [
            'model' => 'UrunNotu',
            'modelId' => $item->id,
            'tag' => 'UrunNotu',                          // Any tag other than model name
        ])




        <hr>

        <table class="table is-fullwidth">
            <tr>
                <td class="is-half">
                    <label class="label">Created By</label>
                    <p>{{ $createdBy->name }} {{ $createdBy->lastname }}</p>
                    <p>{{ $created_at }}</p>
                </td>
                <td class="has-text-right">
                    <label class="label">Status</label>

                    @switch($status)
                    @case('A')
                        <p>Active</p>
                        @break
                    @case('I')
                        <p>Inactive</span>
                        @break
                    @endswitch

                </td>
            </tr>
        </table>

    </div>







</div>
