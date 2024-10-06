<?php

namespace App\Livewire;

use App\Livewire\Forms\DocumentForm;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

use Livewire\WithFileUploads;

use App\Models\Document;

class DocumentUpdate extends Component
{
    // use WithFileUploads;

    // public DocumentForm $form;

    // public Int $id;

    // #[Validate(['files.*' => 'image|max:1024'])]
    // public $files = [];


    public function mountOK()
    {
        $this->form->setDocumentProps();

        if (request('id')) {

            $this->id = request('id');
            $this->form->setDocument($this->id);
        } else {
            dd('Ooops...');
        }
    }


    public function updateOK()
    {


        // FORM PARAMETERS UPDATE
        $this->form->update($this->id);

        $model = Document::find($this->id);

        foreach ($this->files as $file) {
            $model->addMedia($file)->toMediaCollection('Doc');
        }



        //return $this->redirect('/document/list');

        return to_route('docView', ['id' => $this->id]);

        //return view('documents.docs-view');

        //return $this->redirect('/document/view/'.$this->id);
    }

    public function renderOK()
    {
        return view('documents.docs-form');
    }



    public function removeFileOK() {
        dd('sdfdsf');
    }



}
