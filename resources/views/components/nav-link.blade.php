@props(['id' => false])
@props(['type' => 'main'])
@props(['active' => false])


@switch($type)

    @case('dropdown')

        {{-- DROPDOWN BUTTON --}}
        <button id="{{ $id }}" class="inline-flex items-center font-extrabold md:font-normal w-full p-4 md:p-0 border border-gray-400 md:border-0">
            <x-nav-icon>{{ $slot }}</x-nav-icon>
            <span class="px-2">{{ $slot }}</span>
            <x-carbon-chevron-down class="w-5"/>
        </button>

        @break

    @case('submenu')

        {{-- SUBMENU --}}
        <li class="hover:bg-gray-800 hover:text-white w-full pl-4 py-2 md:pl-2">
            <a {{ $attributes }} class="inline-flex items-center">
                <div class="text-blue-600">
                    <x-nav-icon>{{ $slot }}</x-nav-icon>
                </div>
                <span class="px-2 whitespace-nowrap">{{ $slot }}</span>
            </a>
        </li>

        @break


    @case('menu_link')

        <li class="hover:bg-sky-900 p-2 md:text-white {{ $active ? 'bg-sky-900':'' }}">
            <a {{ $attributes }} class="inline-flex items-center font-extrabold md:font-normal">
                <x-nav-icon>{{ $slot }}</x-nav-icon>
                <span class="px-2">{{ $slot }}</span>
            </a>
        </li>

@endswitch
