<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\CNotice;
use App\Models\NoteCategory;
use App\Models\Urun;
use App\Models\Yaptirga;





class LwAssy extends Component
{

    public $uid;

    public $query = '';
    public $sortField = 'product_no';
    public $sortDirection = 'DESC';

    public $action;
    public $showNodeGui = false;
    public $constants;



    public $description;

    #[Rule('required|numeric', message: 'Please select ECN')]
    public $ecn_id;


    public $treeData;
    public $remarks;

    public $unit = 'mm';
    public $weight;



    public $fnotes  = [];
    public $pnotes  = [];
    public $ncategories = [];
    public $notes_id_array = [];




    public function mount()
    {
        if (request('id')) {
            $this->uid = request('id');
            $this->setFlagNotes();
        }

        $this->getNotes();

        // $this->action = strtoupper(request('action'));
        $this->constants = config('assy_nodes');
    }


    public function render()
    {
        return view('products.assy.assy-form',[
            'ecns' => $this->getECNs(),
            'nodes' => $this->getNodes()
        ]);
    }


    public function getECNs() {
        return CNotice::where('status','wip')->get();
    }


    public function getNotes() {
        $this->ncategories = NoteCategory::orderBy('text_tr')->get();
        $this->pnotes = Yaptirga::orderBy('text_tr')->get();
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

            return Urun::where('product_no', 'LIKE', "%".$this->query."%")
                ->orWhere('description', 'LIKE', "%".$this->query."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));

        } else {

            return Urun::orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
        }

    }




    public function addNode($idNode) {

        $p = Urun::find($idNode);

        $this->dispatch('refreshTree',id: $p->id,name: $p->description);







    }





}
