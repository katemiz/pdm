@props(['type' => false])


@switch($type)

    @case("dark")
        @php
        $bg = 'bg-gray-800 text-gray-600 '
        @endphp
        @break

    @case("warning")
        @php
        $bg = 'bg-yellow-500 text-gray-600 '
        @endphp
        @break


    @default
        @php
        $bg = 'bg-gray-800 text-white'
        @endphp

@endswitch






<span class="inline-flex items-center rounded-md {{ $bg }} px-2 py-1 my-2 text-xs font-medium ring-1 ring-inset ring-gray-500/10">
{{$slot}}
</span>