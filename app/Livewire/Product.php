<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

use App\Models\CNotice;
use App\Models\Urun;
use App\Models\User;


class Product extends Component
{

    use WithPagination;


    public $action = 'LIST'; // LIST,FORM,VIEW

    public $itemId = false;
    public $item = false;

    public $isAdd = false;
    public $isEdit = false;
    public $isList = true;
    public $isView = false;

    public $canAdd = true;
    public $canEdit = true;
    public $canDelete = true;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection;

    public $constants;

    // Item Props
    public $description;
    public $ecn_id;
    public $status;
    public $rejectReason;
    public $createdBy;
    public $engBy;

    public $created_at;
    public $req_reviewed_at;
    public $eng_reviewed_at;

    public $remarks;






    public function mount()
    {
        // $this->ptype = request('ptype');
        $this->action = strtoupper(request('action'));

        $this->constants = config('product');

    }








    public function render()
    {

        $ecns = CNotice::where('status','wip');



        $items = false;

        if ( $this->action === 'VIEW') {
            $this->setUnsetProps();
        }

        if ( $this->action === 'FORM' && $this->itemId) {



            $this->setUnsetProps();
        }

        if ( $this->action === 'LIST') {

            $this->sortDirection = $this->constants['list']['headers'][$this->sortField]['direction'];

            $items = Urun::where('partno', 'LIKE', "%".$this->search."%")
            ->orWhere('description', 'LIKE', "%".$this->search."%")
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));

            foreach ($items as $key => $item) {
                $items[$key]['canEdit'] = false;
                $items[$key]['canDelete'] = false;

                if ($item->status == 'wip') {
                    $items[$key]['canEdit'] = true;
                    $items[$key]['canDelete'] = true;
                }
            }
        }


        return view('products.products',[
            'items' => $items,
            'ecns' => $ecns
        ]);






















        return view('products.product');
    }
}
