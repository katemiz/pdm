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
                            <a href="/products/list" class="button is-info is-light is-small">
                            <span class="icon is-small"><x-carbon-list /></span>
                            </a>
                        </p>

                        <p class="control ml-5">
                            <a href="/products/form" class="button is-info is-light is-small">
                            {{-- <a wire:click="addNew()" class="button is-info is-light is-small"> --}}
                            <span class="icon is-small"><x-carbon-add /></span>
                            <span>Add New</span>
                            </a>
                        </p>

                        @if ($canEdit && $item->canEdit)
                        <p class="control ml-1">
                            <a class="button is-link is-light is-small" href='/products/form/{{ $item->id }}'>
                                <span class="icon is-small"><x-carbon-edit /></span>
                                <span>Edit</span>
                            </a>
                        </p>
                        @endif

                        @if ($canDelete && $item->canDelete)
                        <p class="control ml-1">
                            <button class="button is-danger is-light is-small" wire:click.prevent="startCRDelete({{$item->id}})">
                                <span class="icon is-small"><x-carbon-trash-can /></span>
                                <span>Delete</span>
                            </button>
                        </p>
                        @endif

                    </div>
                </div>

                @if (in_array($status,['wip']))
                <div class="column">
                    <div class="field has-addons is-pulled-right">

                        <p class="control">
                            <a wire:click="closeECN({{ $item->id }})" class="button is-success is-light is-small">
                                <span class="icon is-small"><x-carbon-task-complete /></span>
                                <span>Finalize / Tamamla</span>
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
                @endif

            </div>
        </div>

        <div class="media">
            <div class="media-left has-text-centered">
                <figure class="image is-48x48">
                    <x-carbon-barcode />
                </figure>
            </div>
            <div class="media-content">
                <p class="title is-4"> {{ $item->id }}-{{ $item->version }}</p>
                <p class="subtitle is-6">{{ $item->description}}</p>
            </div>
        </div>

        <div class="block">
            <label class="label">Engineering Change Notice Number</label>
            <a href="/ecn/view/{{ $item->c_notice_id }}">ECN-{{ $item->c_notice_id }}</a>
        </div>

        <div class="block">
        <label class="label">Material</label>
        {{ $item->material_definition }}
        </div>

        <div class="block content">
            <label class="label">Product and Process Notes</label>
            <ul>
                @foreach ($item->notes as $note)
                <li>{{ $note->text_tr }}</li>
                @endforeach
            </ul>
        </div>



        <div class="columns">

            <div class="column">

                {{-- ATTACHMENTS --}}
                <div class="block">
                <label class="label">CAD Files</label>
                @livewire('file-list', [
                    'model' => 'Product',
                    'modelId' => $item->id,
                    'showMime' => false,
                    'showSize' => false,
                    'tag' => 'CAD',                          // Any tag other than model name
                ])
                </div>

            </div>

            <div class="column">

                <div class="block">
                    <label class="label">STEP/DXF Files</label>
                    @livewire('file-list', [
                        'model' => 'Product',
                        'modelId' => $item->id,
                        'showMime' => false,
                        'showSize' => false,
                        'tag' => 'STEP',                          // Any tag other than model name
                    ])
                </div>
            </div>

            <div class="column">
                <div class="block">
                    <label class="label">Drawing and BOM</label>
                    @livewire('file-list', [
                        'model' => 'Product',
                        'modelId' => $item->id,
                        'showMime' => false,
                        'showSize' => false,
                        'tag' => 'DWG-PDF',                          // Any tag other than model name
                    ])
                </div>

            </div>


        </div>













        @if ($item->remarks)
        <div class="block">
            <label class="label">Remarks/Notes</label>
            <div class="notification">
                {!! $item->remarks !!}
            </div>
        </div>
        @endif





        @livewire('tolerances')





        @livewire('info-box', [
            'createdBy' => $createdBy,
            'status' => $status,
            'created_at' => $created_at
        ])









    </div>

















</div>
