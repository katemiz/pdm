@props(['type' => false])


@switch($type)

    @case("dark")
        @php
        $bg = 'bg-gray-700 text-white'
        @endphp
        @break

    @case("warning")
        @php
        $bg = 'bg-orange-700 text-white'
        @endphp
        @break


    @default
        @php
        $bg = 'bg-gray-800 text-white'
        @endphp

@endswitch






<span
    {{ $attributes->merge(['class' => 'inline-flex rounded-md px-2 py-1 my-2 text-xs font-light '.$bg]) }}>
    {{ $slot }}
</span>
