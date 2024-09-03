<?php

namespace App\Livewire;

use Livewire\Component;

class FormInput extends Component
{
    public $type = 'text';
    public $label = 'Default Label For Input Field';
    public $name;
    public $value = '';
    public $placeholder = 'Default placeholder for input';




    public $girdi ='İlk Değer';

    // public function mount($girdi = '')
    // {
    //     $this->girdi = $girdi;
    // }




    public function updated($propertyName)
    {
dd('dd');
        dump($propertyName);
        // Handle updates to properties here
        if ($propertyName === $this->name) {

            $this->value = $this->name;

            dd($this->name);
            // Handle changes to this specific input
        }


        // Handle updates to properties here
        if ($propertyName === 'girdi') {

            dd($this->girdi);

        }



    }





    public function render()
    {
        return view('livewire.form-input');
    }
}