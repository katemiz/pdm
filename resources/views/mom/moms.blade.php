<section class="section container">

    <script src="{{ asset('/js/confirm_modal.js') }}"></script>

    @switch($action)

        @case('FORM')
            @include('mom.moms-form')
            @break

        @case('VIEW')
            @include('mom.moms-view')
            @break

        @case('LIST')
        @default
            @include('mom.moms-list')
            @break

    @endswitch

</section>
