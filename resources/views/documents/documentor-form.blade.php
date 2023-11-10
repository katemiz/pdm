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
        <h1 class="title has-text-weight-light is-size-1">Write a Document</h1>
        <h2 class="subtitle has-text-weight-light">{{ $uid ? 'Write Documentation in Browser' : 'Edit Documentation in Browser' }}</h2>
    </header>




    <div class="columns">

        <div class="column is-3">

            <a wire:click='addPage' class="button is-success">
                <span class="icon is-small"><x-carbon-add /></span>
                <span>Page</span>
            </a>

            <div id="doctree" ></div>

        </div>

        <div class="column">

            @switch($action)
                @case('DOCFORM')

                    <p>Doc Form</p>
                    
                    @break
                @case('DOCVIEW')

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
