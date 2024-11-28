<?php

use function Livewire\Volt\{state};

state(['addBtn' => [
        'title' => 'Add User',
        'redirect' => '/usrs/form'
]]);

state(['noItemText' => "No items found in database!"]);

$addItem = fn () => $this->dispatch('addTriggered') ;

?>

<div class="flex flex-col">

    {{-- @role(['EngineeringDept'])
    <button wire:click='addItem' class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-900 font-medium rounded-lg text-sm px-4 py-2">
        <x-carbon-add class="h-5 w-5 mr-2"/>
        {{ $addtext }}
    </button>
    @endrole --}}

    <div class="p-4 my-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">

        <div class="flex flex-col md:flex-row justify-between">
            <div><span class="font-medium">No Item!</span> {{ $noItemText }}</div>
            <div class="text-right text-gray-400">{{ now() }}</div>
        </div>
    </div>
</div>

