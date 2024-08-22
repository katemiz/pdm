<?php

use function Livewire\Volt\{state};

state(['type' => "Page"]);  // Hero, Page, Section

state(['title' => "Default Header Title"]);
state(['subtitle' => false]);

?>

<div class="pt-4 pb-8">



    @switch($type)

        @case("Hero")
            <h1 class="text-5xl font-light my-6">{!! $title !!}</h1>

            @if ($subtitle)
                <h2 class="text-2xl mb-8 text-gray-500">{!! $subtitle !!}</h2>
            @endif

            @break

        @default
        @case("Page")

            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">{!! $title !!}</h1>

            @if ($subtitle)
            <p class="mt-1.5 text-sm text-gray-500">{!! $subtitle !!}</p>
            @endif

            @break

        @case("Section")

            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">{!! $title !!}</h1>

            @if ($subtitle)
            <p class="mt-1.5 text-sm text-gray-500">{!! $subtitle !!}</p>
            @endif

            @break

    @endswitch

</div>
