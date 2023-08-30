<?php

namespace App\Livewire;

// use Livewire\Attributes\Reactive;
use Livewire\Component;

class CkEditor extends Component
{
    public $varname;
    public $label;
    public $placeholder;

    // #[Reactive] 
    public $content;

    // public $message;

    public function mount($content = ''){
        $this->content = $content;
    }




    public function render()
    {
        return view('livewire.ck-editor');
    }
}
