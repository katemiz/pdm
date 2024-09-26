<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Quill extends Component
{
    public String $label;
    public String $name;
    public ?String $value;
    public String $qid;
    public String $placeholder;

    public function __construct($name,$label= 'Default Label For Quill Editor', $placeholder = 'Default placeholder for editor', $value = null)
    {
        $this->qid = 'q'.rand(0, 1000);

        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;

    }

    public function render()
    {
        return view('components.quill');
    }
}
