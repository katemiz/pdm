<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use Livewire\Attributes\On;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileList extends Component
{
    public $id;
    public $model;
    public $is_editable = false;
    public $show_header = false;

    public $label;
    public $collection;
    public $media = [];

    public $media_id;

    public function mount($model,$label,$is_editable = false,$show_header=false) {

        $this->model = $model;
        $this->is_editable = $is_editable;
        $this->show_header = $show_header;
        $this->label = $label;
    }


    public function render()
    {
        $this->media = $this->model->getMedia($this->collection);
        return view('livewire.file-list');
    }


    public function triggerMediaDelete($idMedia) {

        $this->media_id = $idMedia;
        $this->dispatch('deleteConfirm', media_id:$idMedia);
    }


    #[On('deleteConfirmed')]
    public function deleteMedia() {

        $media = $this->model->media()->findOrFail($this->media_id);
        $media->delete();

        $this->dispatch('mediaDeleted');
    }


    public function downloadMedia(Int $idMedia) {

        $media = $this->model->getMedia('*');

        foreach ($media as $m) {

            if ($m->id == $idMedia) {
                return $m;
            }
        }
    }

}
