<?php

namespace App\Livewire;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class CkEditor extends Component
{
    public $edId;
    public $ed_type;
    public $edconfig;
    public $varname;
    public $label;
    public $placeholder;

    #[Modelable]
    public $content;

    public function mount($content = '',$ed_type='STANDARD'){
        $this->content = $content;
        $this->edId = uniqid('ED');
        $this->ed_type = $ed_type;
    }

    public function render()
    {
        return view('components.elements.ck-editor');
    }
}
