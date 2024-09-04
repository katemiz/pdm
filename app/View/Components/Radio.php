<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Radio extends Component
{
    public $label;
    public $name;
    public $options;
    public $selected;

    public function __construct($label= 'Default Label For Radio Group',$name, $options, $selected = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
    }

    public function render()
    {
        return view('components.radio');
    }
}