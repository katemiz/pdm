<?php

use function Livewire\Volt\{state};
use function Livewire\Volt\{computed};

state(
    ['msg' => 
        [
            "type" => "default",
            "header" => false,
            "text"=> "successfully completed"
        ]
    ]
);

$css = computed(function () {

    switch ($this->msg['type']) {

        case 'info':

            return [
                'text-color' => 'text-blue-800',
                'bg-color' => 'bg-blue-100',
            ];
            break;

        case 'success':

            return [
                'text-color' => 'text-green-800',
                'bg-color' => 'bg-green-100',
            ];
            break;

        case 'warning':

            return [
                'text-color' => 'text-amber-800',
                'bg-color' => 'bg-yellow-50',
            ];
            break;

        case 'error':

            return [
                'text-color' => 'text-yellow-800',
                'bg-color' => 'bg-yellow-50',
            ];
            break;

        default:

            return [
                    'text-color' => 'text-gray-800',
                    'bg-color' => 'bg-gray-50',
                ];
            break;
    }

});

?>

<div>
    @if(session('msg'))

        <div class="p-4 mb-4 text-sm rounded-lg {{ implode(' ',$this->css) }}" role="alert">

            @if ( isset($this->msg['header']) )
                <p class="font-medium pb-4">{{ $this->msg['header'] }}</p>
            @endif

            <div class="flex flex-col md:flex-row justify-between">
                <div>{{ $this->msg['text'] }} </div>
                <div class="text-right text-gray-400">{{ now() }}</div>
            </div>

        </div>

    @endif
</div>
