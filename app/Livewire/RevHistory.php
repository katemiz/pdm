<?php

namespace App\Livewire;

use Illuminate\Http\Request;

use Livewire\Component;


class RevHistory extends Component
{
    public $model;
    public $redirect;
    public $revisions = [];
    public $rev;

    public function mount($model,$redirect) {

        $this->model = $model;
        $this->revisions = $model->revisions;

        $this->redirect = $redirect;


        $this->id = $model->id;
    }


    public function render()
    {
        return view('livewire.rev-history');
    }


    public function showRevision($newRevisionItemId)
    {
        redirect($this->redirect.$newRevisionItemId);
    }
}
