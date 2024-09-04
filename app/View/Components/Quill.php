<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Quill extends Component
{
    public $label;
    public $name;
    public $value;
    public $qid;

    public $count;

    public function __construct($label= 'Default Label For Quill Editor',$name, $value = null)
    {
        $this->qid = 'q'.rand(0, 1000);

        $this->label = $label;
        $this->name = $name;
        $this->value = $value;


        $this->count = 55555;
    }

    public function render()
    {
        return view('components.quill');
    }
}