@props(['name' => false])
@props(['size' => false])


@switch($size)
    @case("XS")
        @php
        $size = 'w-3 h-3'
        @endphp
        @break

    @case("S")
        @php
        $size = 'w-4 h-4'
        @endphp
        @break

    @case("M")
        @php
        $size = 'w-5 h-5'
        @endphp
        @break

    @case("L")
        @php
        $size = 'w-6 h-6'
        @endphp
        @break

    @case("XL")
        @php
        $size = 'w-7 h-7'
        @endphp
        @break

    @case("XXL")
        @php
        $size = 'w-8 h-8'
        @endphp
        @break

    @default
        @php
        $size = 'w-4 h-4'
        @endphp

@endswitch



@switch($name)

    @case("Add")
        <x-carbon-add-large class="{{ $size }}" />
        @break

    @case("Delete")
        <x-carbon-trash-can class="{{ $size }} text-red-600" />
        @break

    @case("Edit")
        <x-carbon-pen class="{{ $size }}" />
        @break

    @case("Freeze")
        <x-carbon-stamp class="{{ $size }}" />
        @break

    @case("List")
        <x-carbon-list class="{{ $size }}" />
        @break

    @case("More")
        <x-carbon-overflow-menu-vertical class="{{ $size }}" />
        @break

    @case("Release")
        <x-carbon-send class="{{ $size }}" />
        @break

    @case("Revise")
        <x-carbon-version class="{{ $size }}" />
        @break

    @case("Sort")
        <x-carbon-chevron-sort class="{{ $size }}" />
        @break

    @case("SortUp")
        <x-carbon-chevron-up-outline class="{{ $size }}" />
        @break

    @case("SortDown")
        <x-carbon-chevron-down-outline class="{{ $size }}" />
        @break


    @case("View")
        <x-carbon-view class="{{ $size }}" />
        @break


    @default
        <x-carbon-pen class="{{ $size }}" />
        @break

@endswitch


