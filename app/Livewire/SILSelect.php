<?php

namespace App\Livewire;

use Livewire\Component;

class Select extends Component
{

    public $name;
    public $label;
    public $select_label;
    public $options;
    public $selected;

    public function render()
    {
        return view('livewire.select');
    }
}
