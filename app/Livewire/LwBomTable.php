<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;


class LwBomTable extends Component
{
    public $item;

    public $showFirstLevelBOM = true;  

    // public function mount($uid)
    // {
    //     $this->uid = $uid;
    // }


    public function render()
    {
        return view('components.elements.bom-table');
    }

}
