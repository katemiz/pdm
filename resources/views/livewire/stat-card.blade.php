<?php

use function Livewire\Volt\{state};

state(['img' => false]);
state(['title' => "Default Header Title"]);
state(['data' => "34645"]);
state(['content' => "Stat explanation"]);

?>

<div>
    <div class="flex items-center justify-center">
        <div class="w-full py-6 px-3">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="bg-cover bg-center h-56 p-4" >
                    <div class="flex justify-end">
                        <img src="{{asset("/images/$img")}}" alt="PDM Hero">
                    </div>
                </div>
                <div class="p-4">
                    <p class="uppercase tracking-wide text-sm font-bold text-gray-700">{{ $title}}</p>
                    <p class="text-3xl text-gray-900">{{ $data }}</p>
                    <p class="text-gray-700">{{ $content }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
