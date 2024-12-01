<?php

namespace App\Livewire;

use App\Livewire\Forms\DocumentForm;
use Livewire\Component;
use Livewire\WithFileUploads;

use Livewire\Attributes\On;

use App\Models\Document;


class DocumentCreateUpdate extends Component
{
    use WithFileUploads;

    public DocumentForm $form;

    public $id = false;

    #[Validate(['files.*' => 'max:50000'])]
    public $files = [];

    public function mount($id = null) {

        $this->form->setDocumentProps();

        if ($id) {
            $this->id = $id;
            $this->form->setDocument($this->id);
        }
    }


    public function render()
    {
        return view('documents.form');
    }


    public function save()
    {
        // FORM PARAMETERS SAVE
        $id = $this->form->store();

        // ATTACHMENTS
        $model = Document::find($id);

        foreach ($this->files as $file) {
            $model->addMedia($file)->toMediaCollection('Doc');
        }

        return $this->redirect('/docs/'.$id);
    }


    public function update()
    {
        // FORM PARAMETERS UPDATE
        $this->form->update($this->id);

        $model = Document::findOrFail($this->id);

        foreach ($this->files as $file) {
            $model->addMedia($file)->toMediaCollection('Doc');
        }

        return $this->redirect('/docs/'.$this->id);
    }


    public function removeFile($fileToRemove) {

        foreach ($this->files as $key => $dosya) {
            if ($dosya->getClientOriginalName() == $fileToRemove) {
                unset($this->files[$key]);
            }
        }
    }

}
