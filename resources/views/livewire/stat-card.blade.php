<?php

use function Livewire\Volt\{state};

state(['img' => false]);
state(['title' => "Default Header Title"]);
state(['data' => "34645"]);
state(['content' => "Stat explanation"]);

?>

<div class="flex items-center justify-center">
    <div class="w-full">
        <div class="shadow-xl rounded-lg">
            <div class="flex justify-center bg-blue-50">
              <img class="object-scale-down" src="{{asset("/images/$img")}}" alt="{{ $title}}">
            </div>
            <div class="p-4">
                <p class="uppercase tracking-wide text-sm font-bold text-gray-700">{{ $title}}</p>
                <p class="text-3xl text-gray-900 font-extrabold">{{ $data}}</p>
                <p class="text-gray-700">{{ $content }}</p>
            </div>
        </div>
    </div>
</div>
