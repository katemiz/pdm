<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Radio extends Component
{
    public String $label;
    public String $name;
    public Array $options;
    public ?String $selected;

    public function __construct($name, $options, $label= 'Default Label For Radio Group',$selected = null)
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



