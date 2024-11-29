<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use Livewire\Component;
use Livewire\WithFileUploads;

use Livewire\Attributes\On;

use App\Models\User;


class RoleCreateUpdate extends Component
{
    use WithFileUploads;

    public UserForm $form;

    public $id = false;

    #[Validate(['files.*' => 'max:50000'])]
    public $files = [];

    public function mount() {

        $this->form->setRelatedProps();

        if (request('id')) {
            $this->id = request('id');
            $this->form->setUser($this->id);
        }
    }


    public function render()
    {
        return view('admin.users.form');
    }


    public function save()
    {
        // FORM PARAMETERS SAVE
        $id = $this->form->store();

        // ATTACHMENTS
        $model = User::find($id);

        foreach ($this->files as $file) {
            $model->addMedia($file)->toMediaCollection('User');
        }

        return $this->redirect('/usrs/'.$id);
    }


    public function update()
    {
        // FORM PARAMETERS UPDATE
        $this->form->update($this->id);

        $model = User::findOrFail($this->id);

        foreach ($this->files as $file) {
            $model->addMedia($file)->toMediaCollection('User');
        }

        return $this->redirect('/usrs/'.$this->id);
    }


    public function removeFile($fileToRemove) {

        foreach ($this->files as $key => $dosya) {
            if ($dosya->getClientOriginalName() == $fileToRemove) {
                unset($this->files[$key]);
            }
        }
    }

}
