<section class="section container">

    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <script src="{{ asset('/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('/js/tree.jquery.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('/css/jqtree.css')}}">


    {{-- <script>


    window.addEventListener('addNodeToTree',function(e) {

        let newNode = {
            name: e.detail.id,
            id: e.detail.name
        }

        if (e.detail.topNodeId) {

            $('#toc').tree('appendNode', newNode)


        } else {
            $('#toc').tree('appendNode', newNode)
        }

    })



    </script> --}}


    <div class="columns">

        <div class="column">
            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1 mt-0">{{ $uid ? 'D'.$document_no.' R'.$revision:'Write Document'}}</h1>
                <h2 class="subtitle has-text-weight-light">{{ $uid ? $title : 'Write a document in your browser'}}</h2>
            </header>
        </div>

        <div class="column is-narrow">
                <a href="/documents/file/list">
                    <span class="icon is-small"><x-carbon-document-multiple-02 /></span>
                    <span>List All</span>
                </a>

                

                @role(['admin','company_admin','engineer'])

                <div class="buttons mt-3">
    
                @if ($status == 'Frozen')

                    @if ($is_latest)
                    <p class="level-item">
                        <a wire:click='reviseConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-version /></span>
                            <span>Revise</span>
                        </a>
                    </p>
                    @endif

                @else

                        <a wire:click='editCover({{ $uid }})'>
                            <span class="icon"><x-carbon-edit /></span>
                        </a>

                        <a wire:click='freezeConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-stamp /></span>
                        </a>

                        <a wire:click="triggerDelete('document',{{ $uid }})">
                            <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                        </a>
                @endif

                </div>


                @endrole

        </div>
    </div>





    <div class="columns">

        <div class="column is-3">


            @if ($uid)

                <h2 class="subtitle has-text-weight-light">Table of Contents</h2>


                <button wire:click="addPage()" class="button is-dark is-small is-fullwidth mb-2">
                    <span class="icon is-small"><x-carbon-add /></span>
                    <span>Add Page</span>
                </button>

                <a wire:click='viewCover()'>Cover Page</a>

                <livewire:lw-toc uid="{{ $uid }}"/>

            @endif

        </div>

        <div class="column">

            @switch($action)
                @case("cover-form")
                    @include('documents.html-cover-form')
                    @break

                @case("cover-view")
                    @include('documents.html-cover-view')                    
                    @break

                @case("page-form")
                    @include('documents.html-page-form')                    
                    @break

                @case("page-view")
                    @include('documents.html-page-view')                   
                    @break

                @default
                    
            @endswitch
        </div>


    </div>



</section>