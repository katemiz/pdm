<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Attachment;


class FileList extends Component
{
    public $idAttach;

    public $model;
    public $modelId;
    public $tag = false;

    public $attachments = [];
    public $canDelete = false;

    public function render() {
        $this->getAttachments();
        return view('livewire.file-list');
    }


    public function getAttachments() {
        if ($this->modelId) {
            if ($this->tag) {
                $this->attachments = Attachment::where('model_name',$this->model)
                ->where('model_item_id',$this->modelId)
                ->where('tag',$this->tag)
                ->get();
            } else {
                $this->attachments = Attachment::where('model_name',$this->model)
                ->where('model_item_id',$this->modelId)
                ->get();
            }
        }
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




    public function startAttachDelete($idAttach) {
        $this->idAttach = $idAttach;
        $this->dispatch('ConfirmDelete', type:'attach');
    }

    #[On('deleteAttach')]
    public function deleteAttach() {
        Attachment::find($this->idAttach)->delete();
        $this->dispatch('attachDeleted');
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


