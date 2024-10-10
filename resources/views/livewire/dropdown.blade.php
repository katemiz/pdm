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
    <div id="{{ $this->id }}Menu" class="z-10 absolute right-0 top-10 text-left hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">

        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">

          @foreach ($this->menu as $row)
            <li>
                <a href="{{ $row['href'] }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    {{ $row['title'] }}
                </a>
            </li>
          @endforeach

        </ul>
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