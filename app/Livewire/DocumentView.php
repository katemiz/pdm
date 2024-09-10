<?php

namespace App\Livewire;

use Illuminate\Http\Request;

use Livewire\Component;
use Livewire\Attributes\On;


use App\Models\Document;



class DocumentView extends Component
{
    public $id;
    public $document;


    public function mount() {

        if (request('id')) {
            $this->id = request('id');
            $this->document = Document::find(request('id'));

        } else {

            dd('Ooops ...');
            return false;
        }
    }




    public function render()
    {
        return view('documents.docs-view');
    }



    #[On('showRevision')]
    public function showNewRevision(Int $id) {

        dd('showingNewRevision');

        $this->id = $id;
        $this->document = Document::find(request('id'));
    }






}
