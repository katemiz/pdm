<div>

    <script src="{{ asset('/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('/js/tree.jquery.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('/css/jqtree.css')}}">


    <!-- Main container -->
    <nav class="level m-2 mt-6">
        <!-- Left side -->
        <div class="level-left">
        <p class="level-item"><a class="button is-dark is-small" wire:click='addPage'>New</a></p>
        </div>
    
        <!-- Right side -->
        <div class="level-right">
        <p class="level-item"><a class="button is-dark is-small" wire:click='shotpdf'>New</a></p>
        </div>
    </nav>


    <p class="subtitle has-text-centered is-size-5 my-6 mx-2">Table Of Contents</p>

    @if ($toc)

        {{$toc}}
    @else 
        <p class="is-size-6 notification m-3">No content exists for this doc.</p>
        
    @endif

    



</div>
