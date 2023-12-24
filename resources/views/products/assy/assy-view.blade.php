<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Assy Parts</h1>
    <h2 class="subtitle has-text-weight-light">Assembled products</h2>
</header>

@if (session()->has('message'))
    <div class="notification">
        {{ session('message') }}
    </div>
@endif

<script>
    function showReleaseModal(id) {
        alert(id)
    }
</script>



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

                        @role(['engineering'])
                        @if ($isItemEditable)

                        <p class="control ml-1">
                            <a class="button is-link is-light is-small" href='/products/form/{{ $itemId }}'>
                                <span class="icon is-small"><x-carbon-edit /></span>
                                <span>Edit</span>
                            </a>
                        </p>
                        @endif

                        @if ($isItemDeleteable)
                        <p class="control ml-1">
                            <button class="button is-danger is-light is-small" wire:click.prevent="startCRDelete({{$itemId}})">
                                <span class="icon is-small"><x-carbon-trash-can /></span>
                                <span>Delete</span>
                            </button>
                        </p>
                        @endif

                        @endrole

                    </div>
                </div>

                @if (in_array($status,['WIP']))
                <div class="column">
                    <div class="field has-addons is-pulled-right">

                        <p class="control">
                            <a wire:click='releaseStart' class="button is-success is-light is-small">
                                <span class="icon is-small"><x-carbon-send /></span>
                                <span>Start Release</span>
                            </a>
                        </p>

                        {{-- <p class="control ml-5">
                            <a onclick="showModal('m20')" class="button is-danger is-light is-small">
                                <span class="icon is-small"><x-carbon-thumbs-down /></span>
                                <span>Reject / Red</span>
                            </a>
                        </p> --}}

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
                <p class="title is-4"> {{ $part_number }}-{{ $version }}</p>
                <p class="subtitle is-6">{{ $description}}</p>
            </div>
        </div>





        <div class="columns">
            <div class="column block">
                <label class="label">Engineering Change Notice Number</label>
                <a href="/ecn/view/{{ $ecn_id }}">ECN-{{ $ecn_id }}</a>
            </div>

            <div class="column block has-text-right">
                <label class="label">Part Unit</label>
                {{ $unit }}
            </div>

            <div class="column block has-text-right">
                <label class="label">Part Weight [kg]</label>
                {{ $weight }}
            </div>
        </div>



        <div class="column">

            <table class="table is-fullwidth has-background-light">

                <caption>Bill of Materials</caption>

                @if ($bom)

                <thead>
                    <tr>
                        <th>Part Number</th>
                        <th>Description</th>
                        <th>Quantity</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($bom as $i)
                        <tr>
                            <td class="is-narrow">{{ $i->name }}</td>
                            <td>{{ $i->id }}</td>
                            <td class="is-narrow has-text-right">{{ $i->qty }}</td>
                        </tr>
                    
                    @endforeach
                </tbody>
                @endif



            </table>



        </div>

        <div class="block content">
            <label class="label">General Part Notes</label>
            <ol>
                @foreach ($pnotes as $note)
                <li>{{ $note->text_tr }}</li>
                @endforeach
            </ol>
        </div>


        <div class="block content">
            <label class="label">Special Part Notes</label>
            @foreach ($fnotes as $flag)
            <p>{{ $flag['no'] }} - {{ $flag['text_tr'] }}</p>
            @endforeach
        </div>



        <div class="columns">

            <div class="column">

                {{-- ATTACHMENTS --}}
                <div class="block">
                <label class="label">CAD Files</label>
                @livewire('file-list', [
                    'model' => 'Item',
                    'modelId' => $uid,
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
                        'model' => 'Item',
                        'modelId' => $uid,
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
                        'model' => 'Item',
                        'modelId' => $uid,
                        'showMime' => false,
                        'showSize' => false,
                        'tag' => 'DWG-PDF',                          // Any tag other than model name
                    ])
                </div>

            </div>

        </div>



        @if ($remarks)
        <div class="block">
            <label class="label">Remarks/Notes</label>
            <div class="notification">
                {!! $remarks !!}
            </div>
        </div>
        @endif


        {{-- @livewire('tolerances') --}}






        <div class="columns is-size-7 has-text-grey mt-6">

            <div class="column">
                <p>{{ $created_by }}</p>
                <p>{{ $created_at }}</p>
            </div>



            <div class="column has-text-right">
                <p>{{ $created_by }}</p>
                <p>{{ $created_at }}</p>
            </div>

        </div>

    </div>



















</div>

<div class="modal" id="m10">
    <div class="modal-background" onclick="hideModal('m10')"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Modal title</p>
        <button class="delete" aria-label="close" onclick="hideModal('m10')"></button>
      </header>
      <section class="modal-card-body">
        <!-- Content ... -->
      </section>
      <footer class="modal-card-foot">
        <button class="button is-success">Save changes</button>
        <button class="button" onclick="hideModal('m10')">Cancel</button>
      </footer>
    </div>
  </div>

