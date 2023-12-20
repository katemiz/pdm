<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\CNotice;
use App\Models\Counter;
use App\Models\NoteCategory;
use App\Models\Item;
use App\Models\Fnote;
use App\Models\Pnote;
use App\Models\User;




class LwAssy extends Component
{

    public $uid;

    public $query = '';
    public $sortField = 'part_number';
    public $sortDirection = 'DESC';

    public $action;
    public $showNodeGui = false;
    public $constants;

    public $description;

    #[Validate('required|numeric', message: 'Please select ECN')]
    public $ecn_id;

    public $treeData;
    public $part_number;
    public $remarks;

    public $status;

    public $unit = 'mm';
    public $version;
    public $weight;



    public $ecns;

    public $fnotes  = [];
    public $pnotes  = [];
    public $ncategories = [];
    public $notes_id_array = [];

    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;


    public function mount()
    {
        if (request('id')) {
            $this->uid = request('id');
            $this->setFlagNotes();
        }

        $this->action = strtoupper(request('action'));

        $this->setNotes();
        $this->setECNs();

        $this->constants = config('assy_nodes');
    }


    public function render()
    {
        $this->getItemProps();

        return view('products.assy.assy',[
            'nodes' => $this->getNodes()
        ]);
    }


    public function setECNs() {
        $this->ecns =  CNotice::where('status','wip')->get();
    }


    public function setNotes() {
        $this->ncategories = NoteCategory::orderBy('text_tr')->get();
        $this->pnotes = Pnote::orderBy('text_tr')->get();
    }


    public function setFlagNotes() {
        foreach (Fnote::where('urun_id',$this->uid)->orderBy('text_tr')->get() as $r) {
            $this->fnotes[] = ['no' => $r->no,'text_tr' => $r->text_tr,'text_en' => $r->text_en];
        }
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





    public function getNodes() {

        if ( strlen($this->query) > 2 ) {

            return Item::where('part_number', 'LIKE', "%".$this->query."%")
                ->orWhere('description', 'LIKE', "%".$this->query."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));

        } else {

            return Item::orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
        }

    }




    public function addNode($idNode) {

        $p = Item::find($idNode);

        $this->dispatch('refreshTree',id: $p->id,name: $p->description);
    }








    public function storeItem()
    {
        $this->validate();
        try {
            $this->item = Item::create([
                'part_type' => 'assy',
                'description' => $this->description,
                'part_number' => $this->getProductNo(),
                'c_notice_id' => $this->ecn_id,
                'weight' => $this->weight,
                'unit' => $this->unit,
                'remarks' => $this->remarks,
                'user_id' => Auth::id()
            ]);
            session()->flash('success','Assy Part has been created successfully!');

            // Attach Notes to Product
            $this->item->pnotes()->attach($this->notes_id_array);

            $this->itemId = $this->item->id;

            // Flag Notes (Special Notes)
            foreach ($this->fnotes as $fnote) {

                $props['urun_id'] = $this->itemId;
                $props['no'] = $fnote['no'];
                $props['text_tr'] = $fnote['text_tr'];

                Fnote::create($props);

                //dd($fnote);
            }

            $this->dispatch('triggerAttachment',
                modelId: $this->itemId
            );

            $this->action = 'VIEW';

        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!'.$ex);
        }
    }



    public function getItemProps() {

        if ($this->uid && in_array($this->action,['VIEW','FORM']) ) {

            $item = Item::find($this->uid);

            if ($item->status == 'wip') {
                $this->isItemEditable = true;
                $this->isItemDeleteable = true;
            }

            $this->createdBy = User::find($item->user_id);
            $this->checkedBy = User::find($item->checker_id);
            $this->approvedBy = User::find($item->approver_id);

            $this->part_number = $item->part_number;
            $this->version = $item->version;
            $this->weight = $item->weight;
            $this->unit = $item->unit;

            $this->description = $item->description;
            $this->ecn_id = $item->c_notice_id;
            $this->remarks = $item->remarks;

            $this->status = $item->status;

            $this->created_at = $item->created_at;
            $this->check_reviewed_at = $item->check_reviewed_at;
            $this->app_reviewed_at = $item->app_reviewed_at;

            $this->notes_id_array = [];


            $this->notes = $item->notes;

            foreach ($item->pnotes as $note) {
                //array_push($this->notes,$note);
                array_push($this->notes_id_array,$note->id);
            }



            $this->created_at = $item->created_at;
            $this->updated_at = $item->updated_at;
            $this->created_by = User::find($item->user_id)->email;
            //$this->updated_by = User::find($item->updated_uid)->email;

















        }
    }





    public function getProductNo() {

        $parameter = 'product_no';
        $initial_no = config('appconstants.counters.product_no');
        $counter = Counter::find($parameter);

        if ($counter == null) {
            Counter::create([
                'counter_type' => $parameter,
                'counter_value' => $initial_no
            ]);

            return $initial_no;
        }

        $new_no = $counter->counter_value + 1;
        $counter->update(['counter_value' => $new_no]);         // Update Counter
        return $new_no;
    }





}
