<div>

    @switch($action)

        @case('CFORM')
            @include('documents.html-cover-form')
            @break

        @case('CVIEW')
            @include('documents.html-cover-view')
            @break

        @case('PFORM')
            @include('documents.html-page-form')
            @break

        @case('PVIEW')
            @include('documents.html-page-view')
            @break

    @endswitch

</div>