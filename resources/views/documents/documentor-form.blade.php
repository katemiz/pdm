<div class="">

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
        <h1 class="title has-text-weight-light is-size-1">HTML Document</h1>
        <h2 class="subtitle has-text-weight-light">{{ $uid ? 'Edit HTML Document in Browser' : 'Write HTML Document in Browser' }}</h2>
    </header>




    <div class="columns">


        @if ($uid)

            <div class="column is-3">

                <a wire:click='addPage' class="button is-success">
                    <span class="icon is-small"><x-carbon-add /></span>
                    <span>Page</span>
                </a>

                <div id="doctree" ></div>

            </div>
            
        @endif



        <div class="column">

            @switch($action)
                @case('FORM')


                

                <div class="field">
                    <label class="label">Select Document Type</label>
                    <div class="control">
                        @foreach ($doc_types as $abbr => $type_name)
                        <label class="radio">
                            <input type="radio" value="{{$abbr}}" wire:model="doc_type">
                            {{$type_name}}
                            </label>
                        @endforeach
                    </div>
        
                    @error('doc_type')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
                </div>
        
        
                <div class="field">
                    <label class="label">Document Title</label>
                    <div class="control">
                        <input class="input" type="text" wire:model='title' placeholder="Document title/description ...">
                    </div>
        
                    @error('title')
                        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                    @enderror
        
                </div>
        
        
        
        
        
        
        
                <livewire:ck-editor
                    wire:model="remarks"
                    label='Document Synopsis / Notes / Remarks'
                    placeholder='Document Synopsis / Notes / Remarks ....'
                    :content="$remarks"/>
        
                @error('remarks')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                @enderror
        




                <div class="buttons is-right">
                    <button wire:click.prevent="storeUpdateItem()" class="button is-dark">
                        {{ $uid ? 'Update Document' : 'New Document'}}
                    </button>
                </div>
        















                    
                    @break
                @case('VIEW')

                    <p>Doc View</p>


                    @break

                @case('PAGEFORM')

                    @livewire('lw-page', [
                        'pid' => $pid
                    ])
                    
                    @break
                @case('PAGEVIEW')

                    <p>Page View</p>

                    
                    @break
                    
            @endswitch




        </div>

    </div>




</div>
