<?php

use function Livewire\Volt\{state};

state(['did' => false]);  // Dropdown ID
state(['btitle' => "Dropdown Title"]);  // Triggering Button Title

state(['menu' => [
    [
        "title" => 'Menu Item',
        "href" => '/action'
    ],

    [
        "title" => 'Menu Item',
        "href" => '/action'
    ]
]]);




?>

<div class="relative">

    <button id="{{ $did }}Button"
        class="text-white hover:text-blue-800  focus:outline-none inline-flex items-center" type="button">
        <x-carbon-letter-aa class="w-8 h-8 me-2 text-amber-500" />
        {{ $btitle }}
        <x-carbon-chevron-down class="w-5 h-5 me-2 pl-1" />
    </button>

    <!-- Dropdown menu -->
    <div id="{{ $did }}Menu" class="z-10 absolute hidden bg-white divide-y divide-gray-100 shadow-lg w-44 dark:bg-gray-700">
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">

          @foreach ($menu as $item)
            <li>
                <a href="{{ $item['href'] }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $item['title'] }}</a>
            </li>
          @endforeach

        </ul>
    </div>

    <script>
        const triggerButton = document.getElementById("{{ $did }}Button");
        const menu = document.getElementById("{{ $did }}Menu");

        triggerButton.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        document.body.addEventListener('moseover',  () => {
            menu.classList.add('hidden');
        });
    </script>

</div>
