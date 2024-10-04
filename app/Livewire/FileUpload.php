<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;


class FileUpload extends Component
{
    use WithFileUploads;

    public Bool $is_multiple;
    public Array $attachments;


    public function mount($is_multiple = false, $attachments = []): void {
        $this->is_multiple = $is_multiple;
        $this->attachments = $attachments;
    }


    public function render()    {
        return view('livewire.file-upload');
    }


    public function removeFile($fileToRemove): void
    {

        foreach ($this->attachments as $key => $dosya) {
            if ($dosya->getClientOriginalName() == $fileToRemove) {
                unset($this->attachments[$key]);
            }
        }
    }


    #[On('startUpload')]
    public function uploadAttach(Int $mid,String $collection, String $model_name): void {

        //dd($this->attachments);

        Log::info('FILEUPLOAD ACTION 1, before uploading');
        Log::info(time());

        $model = $this->setModel($model_name,$mid);


        foreach ($this->attachments as $dosya) {
            $model->addMedia($dosya)->toMediaCollection($collection);
        }

        Log::info('FILEUPLOAD ACTION 2, uploads complete');
        Log::info(time());

    }


    public function setModel($model_name,$mid) {

        $model_full_path = '\\App\\Models\\'.$model_name;
        $model = new $model_full_path;

        return $model->find($mid);
    }
}
