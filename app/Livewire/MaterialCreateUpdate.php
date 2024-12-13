<?php

namespace App\Livewire;

use App\Livewire\Forms\MaterialForm;
use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Str;


use Livewire\Attributes\On;

use App\Models\Material;


class MaterialCreateUpdate extends Component
{
    use WithFileUploads;

    public MaterialForm $form;

    public $conf;

    public $id = false;

    #[Validate(['files.*' => 'max:50000'])]
    public $files = [];

    public function mount() {

        $this->conf = config('conf_materials');

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
        $model = Material::find($id);

        foreach ($this->files as $file) {
            $model->addMedia($file)->toMediaCollection('Material');
        }

        $redirect = Str::replace('{id}',$id,$this->conf['show']['route']);
        return redirect($redirect);
    }









    public function update()
    {
        // FORM PARAMETERS UPDATE
        $this->form->update($this->id);

        $model = Material::findOrFail($this->id);

        foreach ($this->files as $file) {
            $model->addMedia($file)->toMediaCollection('Material');
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
