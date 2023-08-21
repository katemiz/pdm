<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On; 
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Article;
use App\Models\Attachment;


class AttachmentComponent extends Component
{
    public $idAttach;
    public $model;
    public $modelId;
    public $isMultiple = false;
    public $tag = false;
    public $canEdit = false;

    public $dosyalar = [];

    use WithFileUploads;

    public function render()
    {

        if ($this->tag) {
            $available_files = Attachment::where('model_name',$this->model)
            ->where('model_item_id',$this->modelId)
            ->where('tag',$this->tag)
            ->get(); 
        } else {
            $available_files = Attachment::where('model_name',$this->model)
            ->where('model_item_id',$this->modelId)
            ->get(); 
        }

        return view('livewire.attachment-component',[
            'attachments' => $available_files,
            'isMultiple' => $this->isMultiple,
            'tag' => $this->tag
        ]);
    }



    public function removeFile($fileToRemove) {

        foreach ($this->dosyalar as $key => $dosya) {
            
            if ($dosya->getClientOriginalName() == $fileToRemove) {
                unset($this->dosyalar[$key]);
            }
        }
    }


    public function deleteAttachConfirm($idAttach) {

        $this->idAttach = $idAttach;

        $this->dispatch('runConfirmDialog', title:'Do you really want to delete this file ?',text:'Once deleted, there is no turning back!');
    }

    #[On('runDelete')] 
    public function deleteAttach() {

        Attachment::find($this->idAttach)->delete();

        session()->flash('message','File Deleted Successfully!!');

        $this->dispatch('infoDeleted');
    }

    public function downloadFile($idAttach) {

        $d = Attachment::find($idAttach);

        if (!$this->checkPermission()) {
            abort(404, 'No permission!');
        }

        $dosya = Storage::path($d->stored_file_as);

        if (file_exists($dosya)) {
            $headers = [
                'Content-Type' => $d->mime_type,
            ];

            return response()->download(
                $dosya,
                $d->original_file_name,
                $headers,
                'inline'
            );
        } else {
            abort(404, 'File not found!');
        }
    }

    


    public function uploadAttach(Request $request)
    {
        foreach ($this->dosyalar as $dosya) {

            $props['user_id'] = 1;//Auth::id();
            $props['model_name'] = $this->model;
            $props['model_item_id'] = $this->modelId;
            $props['original_file_name'] = $dosya->getClientOriginalName();
            $props['mime_type'] = $dosya->getMimeType();
            $props['file_size'] = $dosya->getSize();
            $props['tag'] = $this->tag;

            $path = $props['model_name'].'/'.$props['model_item_id'];

            $stored_file_as = Storage::disk('local')->put($path, $dosya);

            $props['stored_file_as'] = $stored_file_as;

            Attachment::create($props);
        }

        $this->reset('dosyalar');
    }


    public function checkPermission()
    {
        if ( Auth::id() ) {
            return true;
        } else {
            return false;
        }
    }



}
