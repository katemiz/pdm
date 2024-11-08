<?php

use function Livewire\Volt\{state};
use function Livewire\Volt\{computed};

state(['title' => "More ..."]);  // Triggering Button Title

state(['menu' => [
    [
        "title" => 'Menu Item',
        "href" => '/action',
        "icon" => 'chevron-down'
    ],

    [
        "title" => 'Menu Item',
        "href" => '/action',
        "icon" => 'chevron-down'
    ]
]]);

$id = computed(function () {
    return 'u'.rand(0, 1000);
})

?>

<div class="relative inline-flex ">

    <button
        id="{{ $this->id }}"
        data-dropdown-toggle="dropdownHover"
        data-dropdown-trigger="hover"
        class="ml-16 bg-gray-700 hover:bg-gray-800 text-white p-2 rounded inline-flex items-center"
        type="button"
        >
        <x-carbon-overflow-menu-vertical class="w-5"/>
    </button>

    <!-- Dropdown menu -->
    <div id="{{ $this->id }}Menu" class="z-10 absolute right-0 top-10 text-left hidden bg-[#3b5998] divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">

        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">

          @foreach ($this->menu as $row)
            <li>

                {{-- @if ( isset($row['icon']) )
                <a class="text-white bg-[#3b5998] hover:bg-gray-100 hover:text-gray-600 w-full ml-2 text-sm inline-flex items-center">
                    <x-carbon-overflow-menu-vertical class="w-5"/>
                    {{ $row['title'] }}
                </a>
                @endif --}}

                @if ( isset($row['href']) )
                <a href="{{ $row['href'] }}" class="px-4 py-2 hover:bg-gray-100 inline-flex text-white hover:text-gray-600">
                    <x-carbon-{{ $row['icon'] }} class="w-5"/>
                    {{ $row['title'] }}
                </a>
                @endif

                @if ( isset($row['wireclick']) )
                <a wire.click="{{ $row['wireclick'] }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    {{ $row['title'] }}
                </a>
                @endif

            </li>
          @endforeach

        </ul>
    </div>







    <div class="mx-auto flex  w-full items-center justify-center bg-gray-200 py-20">
        <div class="group relative cursor-pointer py-2">
    
            <div class="flex items-center justify-between space-x-5 bg-white px-4">
                <a class="menu-hover my-2 py-2 text-base font-medium text-black lg:mx-4" onClick="">
                    Choose Day
                </a>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </span>
            </div>
    
            <div
                class="invisible absolute z-50 flex w-full flex-col bg-gray-100 py-1 px-4 text-gray-800 shadow-xl group-hover:visible">
    
                <a class="my-2 block border-b border-gray-100 py-1 font-semibold text-gray-500 hover:text-black md:mx-2">
                    Sunday
                </a>
    
                <a class="my-2 block border-b border-gray-100 py-1 font-semibold text-gray-500 hover:text-black md:mx-2">
                    Monday
                </a>
    
                <a class="my-2 block border-b border-gray-100 py-1 font-semibold text-gray-500 hover:text-black md:mx-2">
                    Tuesday
                </a>
    
                <a class="my-2 block border-b border-gray-100 py-1 font-semibold text-gray-500 hover:text-black md:mx-2">
                    Wednesday
                </a>
    
                <a class="my-2 block border-b border-gray-100 py-1 font-semibold text-gray-500 hover:text-black md:mx-2">
                    Thursday
                </a>
    
                <a class="my-2 block border-b border-gray-100 py-1 font-semibold text-gray-500 hover:text-black md:mx-2">
                    Friday
                </a>
    
                <a class="my-2 block border-b border-gray-100 py-1 font-semibold text-gray-500 hover:text-black md:mx-2">
                    Saturday
                </a>
    
            </div>
        </div>
    </div>


































    <script>
        const triggerButton = document.getElementById("{{ $this->id }}");
        const m = document.getElementById("{{ $this->id }}Menu");

        triggerButton.addEventListener('click', () => {
            m.classList.toggle('hidden');
        });

        // triggerButton.addEventListener('click',  () => {
        //     m.classList.toggle('hidden');
        // });
    </script>

</div>
