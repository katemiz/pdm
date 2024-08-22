<?php

namespace App\Livewire;

use Livewire\Component;

class Welcome extends Component
{


    public $mottos = [

        [
            "img" => "dds.svg",
            "title" => "Data-Driven Success",
            "content" => "PDM empowers businesses by organizing, tracking, and optimizing product-related data. Success lies in harnessing this data effectively."
        ],

        [
            "img" => "dms.svg",
            "title" => "Data Make Sense",
            "content" => "PDM bridges the gap between raw information and actionable insights, leading to successful product development."
        ],
        [
            "img" => "oiydw.svg",
            "title" => "Order in Your Data World",
            "content" => "PDM brings structure and clarity, ensuring seamless collaboration across teams."
        ],

    ];







    public function render()
    {
        return view('welcome')->title('This is title of welcome page');
    }
}
