<?php

namespace App\Livewire;

use Livewire\Component;

use App\Livewire\LwDocument;

class LwToc extends Component
{

    public $toc;


    public function render()
    {
        return view('documents.documentor-toc');
    }



    public function addPage()
    {
        $this->dispatch('addContent')->to(LwDocument::class); // Rerender FileList component
    }


}
