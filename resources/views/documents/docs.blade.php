<section class="section container">

    <script src="{{ asset('/js/confirm_modal.js') }}"></script>

    @switch($action)

        @case('FORM')
            @include('documents.docs-form')
            @break

        @case('VIEW')
            @include('documents.docs-view')
            @break

        @case('LIST')
        @default
            @include('documents.docs-list')
            @break

    @endswitch

</section>
