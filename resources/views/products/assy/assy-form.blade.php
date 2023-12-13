<section class="section container">


<div>
    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <script src="{{ asset('/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('/js/tree.jquery.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('/css/jqtree.css')}}">

    <script>
    var data = [
        {
            name: 'node1',
            children: [
                { name: 'child1' },
                { name: 'child2' }
            ]
        },
        {
            name: 'node2',
            children: [
                { name: 'child3' }
            ]
        }
    ];

    $(function() {
    $('#doctree').tree({
        data: data
    });
});

    </script>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">Assemblies</h1>
        <h2 class="subtitle has-text-weight-light">{{ $uid ? 'Update Assembly Properties' : 'Add New Assembly'}}</h2>
    </header>

    @if ($uid)
        <div class="control">
            <div class="tags has-addons">
                <span class="tag is-dark is-large mb-6">{{ $part_number}}-{{ $version }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="notification is-danger is-light">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('message'))
        <div class="notification is-info is-light">
            {{ session('message') }}
        </div>
    @endif


    <div class="columns">

        <div class="column is-3">


            <nav class="breadcrumb" aria-label="breadcrumbs">
                <ul>
                  <li>
                    <a href="#">
                      <span class="icon is-small">
                        <x-carbon-tree-view-alt />
                      </span>
                      <span>Product Tree</span>
                    </a>
                  </li>

                </ul>
              </nav>

              <div id="doctree" class="notification" ></div>




        </div>

        <div class="column">
            <form method="POST" enctype="multipart/form-data">
                @csrf

                    <div class="field">
                        <label class="label">Part Unit</label>

                        <div class="control">
                            <label class="checkbox is-block">
                                <input type="radio" wire:model="unit" value="mm"> Metric (mm)
                            </label>

                            <label class="checkbox is-block">
                                <input type="radio" wire:model="unit" value="in"> Imperial (in)
                            </label>
                        </div>

                        @error('unit')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="field">

                        <label class="label" for="topic">Part/Product/Item Description/Title</label>
                        <div class="control">

                            <input
                                class="input"
                                id="description"
                                wire:model="description"
                                type="text"
                                value="{{ $uid ? $description : ''}}"
                                placeholder="Write part descrition/title" required>
                        </div>

                        @error('description')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="field">
                        <label class="label">Available ECNs</label>

                        <div class="control">

                            @if ( $ecns->count() > 0)

                                @foreach ($ecns as $ecn)

                                    <label class="checkbox is-block">
                                        <input type="radio" wire:model="ecn_id" value="{{$ecn->id}}"
                                        @checked($uid && $ecn->id == $ecn_id)> ECN-{{ $ecn->id }}
                                    </label>

                                @endforeach

                            @else
                                <p>No usable ECNs found in database</p>
                            @endif

                        </div>

                        @error('ecn_id')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                        @enderror
                    </div>





                    <div class="field">
                        <label class="label">Notes, Select All Applicable</label>

                        <div class="control">

                            @foreach ($ncategories as $ncategory)

                                <p class="has-text-info has-text-7 mt-3">{{ $ncategory->text_tr }} / {{ $ncategory->text_en }}</p>
                                @foreach ($pnotes as $note)
                                    @if ($note->note_category_id == $ncategory->id)
                                    <label wire:key="{{ $note->id }}" class="checkbox is-block ">
                                        <input type="checkbox" wire:model="notes_id_array" value="{{ $note->id }}"> {{ $note->text_tr }}
                                    </label>
                                    @endif
                                @endforeach

                            @endforeach

                        </div>

                        @error('notes_id_array')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="field ">
                        <label class="label">Special Part Notes [Flag Notes]</label>

                        <div class="columns">

                            <div class="column is-1">
                                <a wire:click='addSNote' class="button is-small is-link"><span class="icon"><x-carbon-add /></span></a>
                            </div>

                            <div class="column">

                                @foreach ($fnotes as $index => $fnote)
                                <div class="field-body">

                                  <div class="field is-narrow">
                                    @if ($index == 0)
                                    <label class="label has-text-weight-normal">No</label>
                                    @endif

                                    <p class="control">
                                      <input class="input" type="text" placeholder="No" wire:model="fnotes.{{ $index }}.no">
                                    </p>
                                  </div>

                                  <div class="field">
                                    @if ($index == 0)
                                        <label class="label has-text-weight-normal">Flag Note</label>
                                    @endif

                                    <div class="columns">

                                        <div class="column">
                                            <p class="control">
                                                <input class="input" type="text" placeholder="Specific part note" wire:model="fnotes.{{ $index }}.text_tr">
                                            </p>
                                        </div>

                                        <div class="column is-1">
                                            <p class="control">
                                                <a wire:click='deleteSNote("{{ $index }}")'><span class="icon is-small has-text-danger"><x-carbon-trash-can /></span></a>
                                            </p>
                                        </div>

                                    </div>

                                  </div>

                                </div>
                                @endforeach

                            </div>

                        </div>

                    </div>


                    <div class="field">

                        <label class="label" for="topic">Part Weight [kg]</label>
                        <div class="control">

                            <input
                                class="input"
                                id="weight"
                                wire:model="weight"
                                type="text"
                                value="{{ $uid ? $weight : ''}}"
                                placeholder="Estimated weight of part/product in kg" required>
                        </div>

                        @error('weight')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                        @enderror
                    </div>


                    <livewire:ck-editor
                        wire:model="remarks"
                        label='Notes and/or remarks'
                        placeholder='Any kind of remarks/notes about part/product.'
                        :content="$remarks"/>

                    @error('remarks')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror


                    <div class="field block">
                        <label class="label">CAD Files</label>

                        @if ($uid)
                        @livewire('file-list', [
                            'canDelete' => true,
                            'model' => 'Product',
                            'modelId' => $uid,
                            'tag' => 'CAD',                          // Any tag other than model name
                        ])
                        @endif

                        <div class="control">

                            @livewire('file-upload', [
                                'model' => 'Product',
                                'modelId' => $uid ? $uid : false,
                                'isMultiple'=> true,                   // can multiple files be selected
                                'tag' => 'CAD',                          // Any tag other than model name
                                'canEdit' => true])
                        </div>
                    </div>

                    <div class="field block">
                        <label class="label">STEP and DXF Files</label>

                        @if ($uid)
                        @livewire('file-list', [
                            'canDelete' => true,
                            'model' => 'Product',
                            'modelId' => $uid,
                            'tag' => 'STEP',                          // Any tag other than model name
                        ])
                        @endif

                        <div class="control">

                            @livewire('file-upload', [
                                'model' => 'Product',
                                'modelId' => $uid ? $uid : false,
                                'isMultiple'=> true,                   // can multiple files be selected
                                'tag' => 'STEP',                          // Any tag other than model name
                                'canEdit' => true])
                        </div>
                    </div>


                    <div class="field block">
                        <label class="label">Drawing and BOM in PDF Format</label>

                        @if ($uid)
                        @livewire('file-list', [
                            'canDelete' => true,
                            'model' => 'Product',
                            'modelId' => $uid,
                            'tag' => 'DWG-PDF',                          // Any tag other than model name
                        ])
                        @endif

                        <div class="control">

                            @livewire('file-upload', [
                                'model' => 'Product',
                                'modelId' => $uid ? $uid : false,
                                'isMultiple'=> true,                   // can multiple files be selected
                                'tag' => 'DWG-PDF',                          // Any tag other than model name
                                'canEdit' => true])
                        </div>
                    </div>


                    <div class="buttons is-right">
                        @if ($uid)
                            <button wire:click.prevent="updateItem()" class="button is-dark">Update Assy</button>
                        @else
                            <button wire:click.prevent="storeItem()" class="button is-dark">Add New Assy</button>
                        @endif
                    </div>

                </form>
        </div>

    </div>









</div>

</section>

