<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use App\Livewire\FileList;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

use App\Models\Attachment;

use Illuminate\Support\Facades\Log;


class FileUpload extends Component
{
    use WithFileUploads;

    public $idAttach;
    public $hasForm = false;
    public $model;
    public $modelId;
    public $isMultiple = false;
    public $tag = false;
    public $canEdit = false;

    public $dosyalar = [];

    public function render()
    {
        return view('components.elements.file-upload');
    }


    public function removeFile($fileToRemove) {

        foreach ($this->dosyalar as $key => $dosya) {
            if ($dosya->getClientOriginalName() == $fileToRemove) {
                unset($this->dosyalar[$key]);
            }
        }
    }


    #[On('triggerAttachment')]
    public function uploadAttach($modelId = false) {

        if ($modelId) {
            $this->modelId = $modelId;
        }

        // if ($this->dosyalar) {
        //     dd($this->dosyalar);

        // }

        foreach ($this->dosyalar as $dosya) {

            $props['user_id'] = Auth::id();
            $props['model_name'] = $this->model;
            $props['model_item_id'] = $this->modelId;
            $props['original_file_name'] = $dosya->getClientOriginalName();
            $props['mime_type'] = $dosya->getMimeType();
            $props['file_size'] = $dosya->getSize();
            $props['tag'] = $this->tag;

            $path = $props['model_name'].'/'.$props['model_item_id'];
            $stored_file_as = Storage::disk('MyDisk')->put($path, $dosya);
            $props['stored_file_as'] = $stored_file_as;

            Attachment::create($props);
        }

        $this->reset('dosyalar');
        $this->dispatch('refreshFileList')->to(FileList::class); // Rerender FileList component
    }
}
