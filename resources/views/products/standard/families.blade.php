<section class="section container">

    <script src="{{ asset('/js/confirm_modal.js') }}"></script>

    @switch($action)

        @case('FORM')
            @include('products.standard.families-form')
            @break

        @case('VIEW')
            @include('products.standard.families-view')
            @break

        @case('LIST')
        @default
            @include('products.standard.families-list')
            @break

    @endswitch

</section>
