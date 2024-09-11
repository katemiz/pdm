<?php

namespace App\Livewire;

use App\Livewire\Forms\DocumentForm;
use Livewire\Component;
use App\Models\Post;

class DocumentUpdate extends Component
{
    public DocumentForm $form;

    public $id;

    public function mount()
    {
        $this->form->setDocumentProps();

        if (request('id')) {

            $this->id = request('id');
            $this->form->setDocument(request('id'));
        } else {
            dd('Ooops...');
        }

    }

    public function update()
    {
        // FORM PARAMETERS UPDATE
        $id = $this->form->update($this->id);

        // ATTACHMENTS
        $this->dispatch('triggerAttachment', mid: $id,collection:"Doc",model_name:"Document" )->to(FileUpload::class);

        return $this->redirect('/document/view/'.$this->id);
    }

    public function render()
    {
        return view('documents.docs-form');
    }
}
