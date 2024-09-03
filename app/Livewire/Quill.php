<?php

namespace App\Livewire;

use Livewire\Component;

class Quill extends Component
{

    const EVENT_VALUE_UPDATED = 'quill_value_updated';

    public $value;
    public $quillId;
    public $label;

    public function mount($value = ''){
        $this->value = $value;
        $this->quillId = 'q'.rand(0, 1000);


    }

    
    public function updatedValue($value) {

        $this->dispatch(self::EVENT_VALUE_UPDATED, $this->value);
    }

 
    public function render()
    {
        return view('livewire.quill');
    }
}
