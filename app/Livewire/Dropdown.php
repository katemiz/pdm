<?php

namespace App\Livewire;

use Livewire\Component;

class Dropdown extends Component
{
    public function __construct(
        public String $title = 'More ...',
        public Array $menu = [
            [
                "title" => 'Menu Item',
                "href" => '/action',
                "icon" => 'Edit'
            ],

            [
                "title" => 'Menu Item',
                "href" => '/action',
                "icon" => 'View'
            ]
        ])
    {}

    public function render()
    {
        return view('livewire.dropdown');
    }


    public function triggerModal($actionType,$modelName) {

        $this->dispatch('ConfirmModal',type:$actionType,name:$modelName);
    }
}
