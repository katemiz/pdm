<?php

namespace App\Livewire;

use Livewire\Component;

class CkEditor extends Component
{
    public $varname;
    public $label;
    public $placeholder;
    public $content;

    public $message;

    public function render()
    {
        return view('livewire.ck-editor');
    }
}
