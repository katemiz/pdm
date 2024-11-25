<span x-data="{ open: false }" class="has-tooltip relative" @click.outside="open = false">

    <a @click="open = !open" class="ml-12 bg-gray-700 cursor-pointer hover:bg-gray-800 text-white p-2 rounded inline-flex items-center">
        <x-ikon name="More"/>
    </a>

    <x-tooltip>More</x-tooltip>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute top-8 right-0 w-64 px-2 py-2 bg-white rounded-lg shadow border">

        <ul class="space-y-1">

            @foreach ($menu as $row)
            <li class="font-medium p-2 hover:bg-gray-200">

                <a
                    @if ( isset($row["href"]) )
                    href="{{ $row["href"] }}"
                    @endif

                    @if ( isset($row["wireclick"]) )
                    wire:click="{{ $row["wireclick"] }}"
                    @endif

                    class="flex items-center cursor-pointer transform transition-colors duration-200 border-r-4 border-transparent hover:border-indigo-700">
                    <div class="mr-3 text-blue-700">
                        <x-ikon name="{{ $row['icon'] }}" />
                    </div>
                    {{ $row['title'] }}
                </a>

            </li>
            @endforeach

        </ul>
    </div>

  </span>

