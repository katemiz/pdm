<?php

namespace App\Livewire;

use App\Livewire\Forms\DocumentForm;
use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Document;


class DocumentCreate extends Component
{
    public DocumentForm $form;

    public function mount() {

        $this->form->setDocumentProps();
    }


    public function save()
    {
        // FORM PARAMETERS SAVE
        $id = $this->form->store();

        // ATTACHMENTS
        $this->dispatch('triggerAttachment', mid: $id,collection:"Doc",model_name:"Document" )->to(FileUpload::class);

        return $this->redirect('/document/view/'.$id);
    }

    public function render()
    {

        // dd($this->form);
        return view('documents.docs-form');
    }

}
