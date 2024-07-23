<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

use App\Models\CNotice;
use App\Models\CRequest;
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
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $show_latest = true; /// Show only latest versions

    public $parts_uses_material = false;
    public $parts_by_ecn = false;

    public $ecns;
    public $constants;

    public $title = 'List of Components'; 
    public $subtitle = "List of all components [Detail, Assy, Buyable, MakeFrom, Standard]"; 

    public function mount()
    {
        if (request('parts_uses_material')) {
            $this->parts_uses_material = request('parts_uses_material');
            $malzeme = Malzeme::find($this->parts_uses_material);
            $this->title = 'List of Components By Material Used'; 
            $this->subtitle = $malzeme->description; 
        }

        if (request('parts_by_ecn')) {
            $this->parts_by_ecn = request('parts_by_ecn');
            $ecn = CNotice::find($this->parts_by_ecn);
            $crequest = CRequest::find($ecn->c_notice_id);
            $this->title = 'List of Components By ECN-'.$ecn->id; 
            $this->subtitle = 'ECN-'.$ecn->id.' '.$crequest->topic; 
        }

        $this->setECNs();
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

        if ( strlen($this->query) > 2 ) {

            // $items = Item::where('part_number', 'LIKE', "%".$this->query."%")
            // ->when($this->show_latest, function ($query) {
            //     $query->where('is_latest', true);
            // })
            // ->when($this->parts_uses_material, function ($query) {
            //     $query->where('malzeme_id', $this->parts_uses_material);
            // })
            // ->when($this->parts_by_ecn, function ($query) {
            //     $query->where('c_notice_id', $this->parts_by_ecn);
            // })
            // ->orWhere('standard_number', 'LIKE', "%".$this->query."%")
            // ->orWhere('description', 'LIKE', "%".$this->query."%")
            // ->orderBy($this->sortField,$this->sortDirection)
            // ->paginate(env('RESULTS_PER_PAGE'));

            $items = Item::
            when($this->show_latest, function ($query) {
                $query->where('is_latest', true);
            })
            ->when($this->parts_uses_material, function ($query) {
                $query->where('malzeme_id', $this->parts_uses_material);
            })
            ->when($this->parts_by_ecn, function ($query) {
                $query->where('c_notice_id', $this->parts_by_ecn);
            })
            ->whereAny(
                [
                    'part_number',
                    'standard_number',
                    'description'
                ] ,
                'LIKE',
                "%$this->query%"
            )
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));

        } else {

            $items = Item::orderBy($this->sortField,$this->sortDirection)
            ->when($this->show_latest, function ($query) {
                $query->where('is_latest', true);
            })
            ->when($this->parts_uses_material, function ($query) {
                $query->where('malzeme_id', $this->parts_uses_material);
            })
            ->when($this->parts_by_ecn, function ($query) {
                $query->where('c_notice_id', $this->parts_by_ecn);
            })
            ->paginate(env('RESULTS_PER_PAGE'));
        }

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
