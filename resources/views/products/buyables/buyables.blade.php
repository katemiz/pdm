<section class="section container has-background-white">

    <script src="{{ asset('/js/confirm_modal.js') }}"></script>

    @switch($action)

        @case('FORM')
            @include('products.buyables.buyables-form')
            @break

        @case('VIEW')
            @include('products.items-view')
            @break

        @case('LIST')
        @default
            @include('products.buyables.buyables-list')
            @break

    @endswitch

</section>
