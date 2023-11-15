<?php

namespace App\Livewire;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class CkEditor extends Component
{
    public $edId;
    public $varname;
    public $label;
    public $placeholder;

    #[Modelable]
    public $content;

    public function mount($content = ''){
        $this->content = $content;
    }

    public function render()
    {
        return view('components.elements.ck-editor');
    }
}
