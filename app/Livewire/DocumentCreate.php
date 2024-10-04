<?php

namespace App\Livewire;

use App\Livewire\Forms\DocumentForm;
use Livewire\Component;
use Livewire\WithFileUploads;

use Livewire\Attributes\On;

use App\Models\Document;


class DocumentCreate extends Component
{
    use WithFileUploads;

    public DocumentForm $form;



    #[Validate(['files.*' => 'max:50000'])]
    public $files = [];



    public function mount() {

        $this->form->setDocumentProps();
    }


    public function save()
    {
        // FORM PARAMETERS SAVE
        $id = $this->form->store();

        // ATTACHMENTS
        $model = Document::find($this->id);

        foreach ($this->files as $file) {
            $model->addMedia($file)->toMediaCollection('Doc');
        }

        //$this->dispatch('startUpload', mid: $id,collection:"Doc",model_name:"Document" )->to(FileUpload::class);

        return $this->redirect('/document/view/'.$id);
    }

    public function render()
    {

        // dd($this->form);
        return view('documents.docs-form');
    }

}
