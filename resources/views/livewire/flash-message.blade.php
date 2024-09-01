<?php

use function Livewire\Volt\{state};
use function Livewire\Volt\{computed};

state(['msg' => ["type" => "default","text"=> "successfully completed"]]);

$css = computed(function () {

    switch ($this->msg['type']) {

        case 'info':

            return [
                'text-color' => 'text-blue-800',
                'bg-color' => 'bg-blue-100',
                'type-text' => 'Info Alert!'
            ];
            break;

        case 'success':

            return [
                'text-color' => 'text-green-800',
                'bg-color' => 'bg-green-100',
                'type-text' => 'Success Alert!'
            ];
            break;

        case 'warning':

            return [
                'text-color' => 'text-green-800',
                'bg-color' => 'bg-green-100',
                'type-text' => 'Success Alert!'
            ];
            break;

        case 'error':

            return [
                'text-color' => 'text-yellow-800',
                'bg-color' => 'bg-yellow-50',
                'type-text' => 'Warning Alert!'
            ];
            break;

        default:

            return [
                    'text-color' => 'text-gray-800',
                    'bg-color' => 'bg-gray-50',
                    'type-text' => 'Alert!'
                ];
            break;
    }

});

?>

<div class="p-4 mb-4 text-sm {{ $this->css['text-color'] }} rounded-lg {{ $this->css['bg-color'] }}" role="alert">
    <span class="font-medium">{{ $this->css['type-text'] }}</span> {{ $this->msg['text'] }}.
</div>
