<?php

use function Livewire\Volt\{state};

state(['type' => "Page"]);  // Hero, Page, Section

state(['title' => "Default Header Title"]);
state(['subtitle' => false]);

?>

<div class="flex flex-col pt-4 pb-8">

    @switch($type)

        @case("Hero")
            <h1 class="text-6xl font-light mt-6 sm:text-5xl">{!! $title !!}</h1>

            @if ($subtitle)
                <h2 class="text-2xl mb-8 text-gray-500">{!! $subtitle !!}</h2>
            @endif

            @break

        @default
        @case("Page")

            <h1 class="text-5xl font-light text-gray-800 sm:text-3xl">{!! $title !!}</h1>

            @if ($subtitle)
            <p class="mt-1 text-xl text-gray-500">{!! $subtitle !!}</p>
            @endif

            @break

        @case("Section")

            <h1 class="text-4xl font-light text-gray-700 sm:text-3xl">{!! $title !!}</h1>

            @if ($subtitle)
            <p class="text-lg text-gray-500">{!! $subtitle !!}</p>
            @endif

            @break

    @endswitch

</div>
