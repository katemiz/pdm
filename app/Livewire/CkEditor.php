<?php

namespace App\Livewire;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class CkEditor extends Component
{
    public $edId;
    public $cktype;
    public $edconfig;
    public $varname;
    public $label;
    public $placeholder;

    #[Modelable]
    public $content;

    public function mount($content = '',$cktype='MIN'){
        $this->content = $content;
        $this->edId = uniqid('ED');
        $this->cktype = $cktype;
    }

    public function render()
    {
        return view('components.elements.ck-editor');
    }
}
