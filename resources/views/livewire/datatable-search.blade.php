<?php
use Livewire\Volt\Component;

new class extends Component {

    public $addBtnTitle = 'Add Item';
    public $addBtnRoute = '/';

    public $query = '';

    public function resetQuery()
    {
        $this->query = '';
        $this->dispatch('queryChanged', query:'');
    }


    public function addItem()
    {
        $this->query = '';
        $this->dispatch('addTriggered',redirect:$this->addBtnRoute);
    }


    public function updated($variable) {

        if ($variable == 'query') {
            $this->dispatch('queryChanged', query:$this->query);
        }
    }
}

?>







<div class="flex flex-col md:flex-row items-center justify-between my-4">

    <div class="md:w-1/2 flex gap-4">

      <button wire:click='addItem' class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-900 font-medium rounded-lg text-sm px-4 py-2">
          <x-carbon-add class="h-5 w-5 mr-2"/>
          {{ $this->addBtnTitle }}
      </button>

      <div class="flex items-center space-x-3 w-full md:w-auto">
          <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
            <x-carbon-chevron-down class="mr-2 w-5 h-5"/>
              Actions
          </button>
          <div id="actionsDropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
              <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                  <li>
                      <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass Edit</a>
                  </li>
              </ul>
              <div class="py-1">
                  <a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete all</a>
              </div>
          </div>

      </div>

    </div>

    <div class="md:w-1/2 text-right flex gap-4 items-center">

        <div class="relative w-full">
            <div class="absolute inset-y-0 start-0 flex items-center ps-2 pointer-events-none">
                <x-carbon-search class="w-5 h-5 ms-1.5"/>
            </div>
            <input type="text" type="text" wire:model.live.bounce300="query" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search ..." required />
            <button type="button" wire:click='resetQuery' class="absolute inset-y-0 end-0 flex items-center pe-3">
                <x-carbon-close class="w-5 h-5 ms-1.5"/>
            </button>
        </div>

        <div>
            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                <x-carbon-filter class="w-5 h-5 ms-1.5 mr-2"/>
                Filter
                <x-carbon-chevron-down class="-mr-1 ml-1.5 w-5 h-5"/>
            </button>

            <div id="filterDropdown" class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow">
                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose brand</h6>
                <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                    <li class="flex items-center">
                        <input id="apple" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="apple" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Apple (56)</label>
                    </li>
                    <li class="flex items-center">
                        <input id="fitbit" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="fitbit" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Microsoft (16)</label>
                    </li>
                    <li class="flex items-center">
                        <input id="razor" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="razor" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Razor (49)</label>
                    </li>
                    <li class="flex items-center">
                        <input id="nikon" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="nikon" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nikon (12)</label>
                    </li>
                    <li class="flex items-center">
                        <input id="benq" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="benq" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">BenQ (74)</label>
                    </li>
                </ul>
            </div>
        </div>

    </div>


  </div>


