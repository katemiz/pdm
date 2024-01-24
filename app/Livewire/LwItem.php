<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

use App\Models\CNotice;
use App\Models\Counter;
use App\Models\Fnote;
use App\Models\Malzeme;
use App\Models\Item;
use App\Models\User;

class LwItem extends Component
{

    use WithPagination;

    public $action = 'LIST';

    public $query = '';
    public $sortField = 'part_number';
    public $sortDirection = 'DESC';

    public $show_latest = true; /// Show only latest versions


    public $ecns;
    public $constants;

    public function mount()
    {

        $this->setECNs();
        //$this->action = strtoupper(request('action'));
        $this->constants = config('product');
    }




    public function render()
    {
        return view('products.parts-list',[
            'items' => $this->getParts()
        ]);
    }


    public function setECNs() {
        $this->ecns =  CNotice::where('status','wip')->get();
    }


    public function getParts() {


        $this->sortDirection = $this->constants['list']['headers'][$this->sortField]['direction'];

        $items = Item::where('part_number', 'LIKE', "%".$this->query."%")
                    ->orWhere('description', 'LIKE', "%".$this->query."%")
                    ->orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));

        foreach ($items as $key => $item) {
            $items[$key]['isItemEditable'] = false;
            $items[$key]['isItemDeleteable'] = false;

            if ($item->status == 'WIP') {
                $items[$key]['isItemEditable'] = true;
                $items[$key]['isItemDeleteable'] = true;
            }
        }

        return $items;
    }



    public function resetFilter() {
        $this->query = '';
    }


    public function changeSortDirection ($key) {

        $this->sortField = $key;

        if ($this->constants['list']['headers'][$key]['direction'] == 'asc') {
            $this->constants['list']['headers'][$key]['direction'] = 'desc';
        } else {
            $this->constants['list']['headers'][$key]['direction'] = 'asc';
        }

        $this->sortDirection = $this->constants['list']['headers'][$key]['direction'];
    }

}
