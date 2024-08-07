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
use App\Models\Item;

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

    public $showNodeGui = false;
    public $constants;


    public $ecns = [];
    public $ncategories;
    public $fnotes  = [];


    public $unit = 'mm';

    #[Validate('required', message: 'Please write part name/title')]
    public $description;

    #[Validate('required|numeric', message: 'Please select ECN')]
    public $c_notice_id;

    public $weight;

    public $mat_family = false;
    public $mat_form = false;
    public $materials = [];


    public $all_revs = [];

    public $treeData =[];



    public $product;


    public $remarks;



    public $listeners = [

        Quill::EVENT_VALUE_UPDATED

    ];

 














    public $notes_id_array = [];


    public $canUserAdd = true;
    public $canUserEdit = true;
    public $canUserDelete = true;




    public function mount()
    {
        $this->getId();
        $this->setPartType();

        $this->getMaterialList();

       $this->setConstants();


        $this->ecns = CNotice::where('status','wip')->get();
        $this->ncategories = NoteCategory::orderBy('text_tr')->get();


    }





    public function render()
    {


        //return view('products.product-view');




        return view('products.product-form',[
            // 'items' => $items,
            // 'ecns' => $ecns,
            'nodes' => $this->getNodes()
        ]);

    }



    public function setConstants(){



        switch (request('t')) {

            case 'd':
                $this->constants = config('product');
                break;

            case 'a':
                $this->constants = config('assy_nodes');
                break;

            case 'b':
                $this->constants = config('buyables');
                break;

            case 'mf':
                $this->constants = config('buyables');
                break;

            case 's':
                $this->constants = config('buyables');
                break;

            default:
                $this->constants = config('assy_nodes');
            break;
        }


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

                case 'b':
                    $this->part_type = 'Buyable';
                    break;

                case 'mf':
                    $this->part_type = 'MakeFrom';
                    break;

                case 's':
                    $this->part_type = 'Standard';
                    break;

                default:
                    $this->part_type = 'Detail';
                    break;
            }
        }
    }




    public function getId() {

        if (request('uid')) {
            $this->uid = request('uid');

            $this->getProps();
        }
    }




    public function getMaterialList() {

        if ($this->mat_family && $this->mat_form) {
            $this->materials = Malzeme::where('family', $this->mat_family)
            ->where('form', $this->mat_form)
            ->orderBy($this->sortField,'asc')->get();
        }
    }











    public function getProps() {

        if ( !$this->uid ) {
            return true;
        }

        $this->product = Item::find($this->uid);

        // $this->part_number = $item->part_number;
        // $this->version = $item->version;
        // $this->weight = $item->weight;
        // $this->unit = $item->unit;

        // $this->description = $item->description;
        // $this->c_notice_id = $item->c_notice_id;
        // $this->remarks = $item->remarks;
        // $this->status = $item->status;
        // $this->is_latest = $item->is_latest;

        $this->treeData =[];

        if ($this->product->bom) {

            $children = json_decode($this->product->bom);

            foreach ($children as $i) {
                $child = Item::find($i->id);
                $i->part_type = $child->part_type;
                $i->description = $child->description;

                array_push($this->treeData, $i);
            }
        }


        $this->created_by = User::find($this->product->user_id);
        $this->created_at = $this->product->created_at;
        $this->updated_by = User::find($this->product->updated_uid);
        $this->updated_at = $this->product->updated_at;
        // $this->checked_by = User::find($item->checker_id);
        // $this->approved_by = User::find($item->approver_id);

        // $this->check_reviewed_at = $item->check_reviewed_at;
        // $this->app_reviewed_at = $item->app_reviewed_at;

        $this->notes_id_array = [];
        $this->notes = $this->product->pnotes;

        foreach ($this->product->pnotes as $note) {
            array_push($this->notes_id_array,$note->id);
        }


        // Revisions
        foreach (Item::where('part_number',$this->product->part_number)->get() as $i) {
            $this->all_revs[$i->version] = $i->id;
        }

        // Get Parents
        $parents = Item::whereJsonContains('bom',['id' => (int) $this->uid])->get();
        if ($parents) {
            $this->parents = $parents;
        }


    }









    public function getNodes() {

        if ( strlen($this->query) > 2 ) {

            return Item::where('part_number', 'LIKE', "%".$this->query."%")
                ->orWhere('standard_number', 'LIKE', "%".$this->query."%")
                ->orWhere('description', 'LIKE', "%".$this->query."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));

        } else {

            return Item::orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
        }
    }





    #[On('addTreeToDB')]
    public function addTreeToDB($bomData) {

        if ($this->uid) {

            $props['bom'] = $bomData;

            // dd($props);

            $i = Item::find($this->uid);
            $sonuc = $i->update($props);

            $this->dispatch('saveResult');
            // Log::info($i);
            // Log::info($props);
        }
    }











    public function quill_value_updated($value){

        $this->remarks = $value;

    }




}
