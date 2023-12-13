<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\CNotice;
use App\Models\NoteCategory;
use App\Models\Yaptirga;




class LwAssy extends Component
{

    public $uid;

    public $description;

    #[Rule('required|numeric', message: 'Please select ECN')]
    public $ecn_id;


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
        // $this->constants = config('product');
    }


    public function render()
    {
        return view('products.assy.assy-form',[
            'ecns' => $this->getECNs()
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




}
