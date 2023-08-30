<?php

namespace App\Livewire;

use Livewire\Component;

class QuillEditor extends Component
{

    public $value;
    
    // public $quillId;

    public function mount($value = ''){
        $this->value = $value;
        // $this->quillId = 'quill-'.uniqid();
    }


    public function updatedValue($value){
        dd($value);
    }

    public function render()
    {
        return view('livewire.quill-editor');
    }
}







