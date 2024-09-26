<?php

namespace App\Livewire;

use App\Livewire\Forms\DocumentForm;
use Livewire\Component;

class DocumentUpdate extends Component
{
    public DocumentForm $form;

    public Int $id;

    public function mount()
    {
        $this->form->setDocumentProps();

        if (request('id')) {

            $this->id = request('id');
            $this->form->setDocument($this->id);
        } else {
            dd('Ooops...');
        }

    }

    public function update()
    {
        // ATTACHMENTS
        $this->dispatch('startUpload', mid: $this->id,collection:"Doc",model_name:"Document" )->to(FileUpload::class);



        // FORM PARAMETERS UPDATE
        $this->form->update($this->id);

        //return $this->redirect('/document/view/'.$this->id);
    }

    public function render()
    {
        return view('documents.docs-form');
    }
}
