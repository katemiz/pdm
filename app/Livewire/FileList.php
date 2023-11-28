<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Attachment;


class FileList extends Component
{

    /*
    @livewire('file-list', [
        'with_icons' => true,
        'icon_type' => 'Drawing',
        'files_header' => 'Customer Drawings',
        'model' => 'EndProduct',
        'modelId' => $uid,
        'tag' => 'CustomerDrawings',
    ])
    */

    public $idAttach;
    public $getById;
    public $model;
    public $modelId;
    public $tag = false;

    public $with_icons = false;
    public $icon_type = 'File';   // File, Drawing, STEP, Manual, 3D
    public $icon_name;

    public $files_header = 'Files';   // File, Drawing, STEP, Manual, 3D

    public $showMime = true;
    public $showSize = true;

    public $canDelete = false;


    #[On('refreshFileList')]
    public function render() {

        $this->setFileIcon();

        if ($this->with_icons) {
            return view('components.elements.file-list-w-icons',[
                'attachments' => $this->getAttachments()
            ]);

        } else {
            return view('components.elements.file-list',[
                'attachments' => $this->getAttachments()
            ]);
        }
    }


    #[On('refreshFileListNewId')]
    public function refreshWithNewId($modelId) {
        $this->modelId = $modelId;
    }


    public function setFileIcon() {

        switch ($this->icon_type) {
            case 'File':
            default:
                $this->icon_name = 'icon_file.svg';
                break;

            case 'Drawing':
                $this->icon_name = 'icon_drawing.svg';
                break;

            case '3D':
                $this->icon_name = 'icon_3d.svg';
                break;

            case 'Manual':
                $this->icon_name = 'icon_manual.svg';
                break;

            case 'STEP':
                $this->icon_name = 'icon_step.svg';
                break;
        }
    }


    public function getAttachments() {

        if ( $this->getById ) {
            $attachments = Attachment::where("model_name",$this->model)->where("model_item_id",$this->getById)->get();
            return $attachments;

        } else if ($this->modelId) {
            if ($this->tag) {
                $attachments = Attachment::where('model_name',$this->model)
                ->where('model_item_id',$this->modelId)
                ->where('tag',$this->tag)
                ->get();
            } else {
                $attachments = Attachment::where('model_name',$this->model)
                ->where('model_item_id',$this->modelId)
                ->get();
            }

            return $attachments;
        }

        return [];
    }


    public function downloadFile($idAttach) {

        $d = Attachment::find($idAttach);

        if (!$this->checkPermission()) {
            abort(404, 'No permission!');
        }

        $dosya = config('filesystems.disks.MyDisk.root').'/'.$d->stored_file_as;

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
        $this->dispatch('ConfirmModal', type:'attach');
    }


    #[On('deleteAttach')]
    public function deleteAttach() {
        Attachment::find($this->idAttach)->delete();
        $this->dispatch('attachDeleted');
    }


    public function checkPermission() {
        if ( Auth::id() ) {
            return true;
        } else {
            return false;
        }
    }

}


