<?php

namespace App\Livewire;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
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
        } else {

            dd('Ooops ...');
            return false;
        }
    }




    public function render()
    {
        $this->document = Document::find(request('id'));


        Log::info('VIEW ACTION , rendering');
        Log::info(time());


        return view('documents.docs-view');
    }



    #[On('showRevision')]
    public function showNewRevision(Int $id) {

        dd('showingNewRevision');

        $this->id = $id;
        $this->document = Document::find(request('id'));
    }


    public function edit() {
        return $this->redirect('/document/form/'.$this->id);
    }


    public function add() {
        return $this->redirect('/document/form');
    }



}
