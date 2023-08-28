
<section class="section container">

    @switch($action)

        @case('FORM')
            @include('CR.form')
            @break

        @case('VIEW')
            @include('CR.view')
        @break

        @case('LIST')
        @default
            @include('CR.list')
            @break

            
    @endswitch
</section>

