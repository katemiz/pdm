<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Quill extends Component
{
    public $label;
    public $name;
    public $value;
    public $qid;
    public $placeholder;

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