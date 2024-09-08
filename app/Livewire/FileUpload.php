<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use App\Livewire\FileList;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;


use Illuminate\Support\Facades\Log;





class FileUpload extends Component
{
    use WithFileUploads;

    public $isMultiple = false;
    public $dosyalar = [];

    public function render()
    {
        return view('livewire.file-upload');
    }


    public function removeFile($fileToRemove) {

        foreach ($this->dosyalar as $key => $dosya) {
            if ($dosya->getClientOriginalName() == $fileToRemove) {
                unset($this->dosyalar[$key]);
            }
        }
    }


    #[On('triggerAttachment')]
    public function uploadAttach(Int $mid,String $collection, String $model_name) {

        $model = $this->setModel($model_name,$mid);

        foreach ($this->dosyalar as $dosya) {
            $model->addMedia($dosya)->toMediaCollection($collection);
        }
    }


    public function setModel($model_name,$mid) {

        $model_full_path = '\\App\\Models\\'.$model_name;
        $model = new $model_full_path;

        return $model->find($mid);
    }






}
