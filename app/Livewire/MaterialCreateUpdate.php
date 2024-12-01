<?php

namespace App\Livewire;

use App\Livewire\Forms\MaterialForm;
use Livewire\Component;
use Livewire\WithFileUploads;

use Livewire\Attributes\On;

use App\Models\Material;


class MaterialCreateUpdate extends Component
{
    use WithFileUploads;

    public MaterialForm $form;

    public $id = false;

    #[Validate(['files.*' => 'max:50000'])]
    public $files = [];

    public function mount() {

        //$this->form->setDocumentProps();

        if (request('id')) {

            $this->id = request('id');
            $this->form->setMaterial($this->id);
        }
    }


    public function render()
    {
        return view('materials.form');
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

        return $this->redirect('/materials/'.$id);
    }









    public function update()
    {
        // FORM PARAMETERS UPDATE
        $this->form->update($this->id);

        $model = Document::findOrFail($this->id);

        foreach ($this->files as $file) {
            $model->addMedia($file)->toMediaCollection('Doc');
        }

        return $this->redirect('/materials/'.$this->id);
    }







    public function removeFile($fileToRemove) {

        foreach ($this->files as $key => $dosya) {
            if ($dosya->getClientOriginalName() == $fileToRemove) {
                unset($this->files[$key]);
            }
        }
    }






}
