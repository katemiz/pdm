<?php

namespace App\Livewire;

use App\Livewire\Forms\DocumentForm;
use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Str;

use Livewire\Attributes\On;

use App\Models\Document;


class DocumentCreateUpdate extends Component
{
    use WithFileUploads;

    public DocumentForm $form;

    public $conf;

    public $id = false;

    #[Validate(['files.*' => 'max:50000'])]
    public $files = [];

    public function mount($id = null) {

        $this->conf = config('conf_documents');

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

        $redirect = Str::replace('{id}',$id,$this->conf['show']['route']);
        return redirect($redirect);
    }


    public function update()
    {
        // FORM PARAMETERS UPDATE
        $this->form->update($this->id);

        $model = Document::findOrFail($this->id);

        foreach ($this->files as $file) {
            $model->addMedia($file)->toMediaCollection('Doc');
        }

        $redirect = Str::replace('{id}',$this->id,$this->conf['show']['route']);
        return redirect($redirect);
    }


    public function removeFile($fileToRemove) {

        foreach ($this->files as $key => $dosya) {
            if ($dosya->getClientOriginalName() == $fileToRemove) {
                unset($this->files[$key]);
            }
        }
    }

}
