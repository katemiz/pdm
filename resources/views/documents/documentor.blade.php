<section class="m-5 ">



    @switch($action)

        @case('DOCFORM')
            @include('documents.documentor-form')
            @break

        @case('DOCVIEW')
            @include('documents.documentor-view')
            @break



    @endswitch

</section>
