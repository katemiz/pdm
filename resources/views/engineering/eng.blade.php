
<div>


    @switch($action)

        @case('geometry')
            @include('engineering.geometry.geometry')
            @break

        @case('geometry-circle')
            @include('engineering.geometry.circle')
            @break

        @case('geometry-rectangle')
            @include('engineering.geometry.rectangle')
            @break


        @default
            @include('engineering.eng-menu')
            @break



    @endswitch




</div>

