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
use App\Models\Urun;
use App\Models\NoteCategory;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class LwProduct2 extends Component
{
    use WithPagination;



    public $uid = false;


    public $part_type = false;


    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $ecns = [];
    public $ncategories;
    public $fnotes  = [];




    public $mat_family = false;
    public $mat_form = false;
    public $materials = [];




    public $remarks;




    public $canUserAdd = true;
    public $canUserEdit = true;
    public $canUserDelete = true;




    public function mount()
    {
        $this->setPartType();

        $this->getMaterialList();


        $this->ecns = CNotice::where('status','wip')->get();
        $this->ncategories = NoteCategory::orderBy('text_tr')->get();


    }





    public function render()
    {


        //return view('products.product-view');




        return view('products.product-form',[
            // 'items' => $items,
            // 'ecns' => $ecns,
            // 'nodes' => $this->getNodes()
        ]);

    }










    public function setPartType() {


        if (!request('t')) {
            dd('no part_type defined');

        } else {
            switch (request('t')) {

                case 'd':
                    $this->part_type = 'Detail';
                    break;

                case 'a':
                    $this->part_type = 'Assy';
                    break;

                default:
                    $this->part_type = 'Detail';
                    break;
            }
        }



    }




    public function getMaterialList() {

        if ($this->mat_family && $this->mat_form) {
            $this->materials = Malzeme::where('family', $this->mat_family)
            ->where('form', $this->mat_form)
            ->orderBy($this->sortField,'asc')->get();
        }
    }








}
