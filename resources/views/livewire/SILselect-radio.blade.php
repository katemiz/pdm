<?php

use Livewire\Volt\Component;

new class extends Component {

    public $company_id;
    public $selectValue;
    public $dizin;

    public function resetQuery()
    {
        $this->query = '';
        $this->dispatch('queryChanged', query:'');
    }

    public function updated($selectValue) {

        dd($selectValue);

        if ($variable == 'selectValue') {
            $this->dispatch('radioValueChanged', selectValue:$this->selectValue,variable:$this->variable);
        }
    }


    public function tikla() {

        dd($this->selectValue);


    }
}

?>



<div class="flex flex-wrap">

    <label class="flex flex-col mb-2 font-medium text-gray-900">First name</label>


    @foreach ($dizin as $value => $text)

    <div class="flex items-center me-4">



        <input type="radio" value="{{ $value }}" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300" wire:model="selectValue" wire:click='tikla'>
        <label  class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $text }}</label>
    </div>

    @endforeach

</div>




