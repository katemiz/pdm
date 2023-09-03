<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

use App\Models\Attachment;

use Illuminate\Support\Facades\Log;



class AttachComponent extends Component
{
    public $idAttach;
    public $hasForm = false;
    public $model;
    public $modelId;
    public $isMultiple = false;
    public $tag = false;
    public $canEdit = false;

    public $hasItsForm = false; // Does componenet has its own form, independently file uploads

    public $dosyalar = [];
    //public $attachments = [];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public $sayac = 0;

    public $isBirsey = 'OLUMSUZ';


    use WithFileUploads;

    

    #[On('refreshAttach')]
    public function deneme()
    {
        $this->isBirsey = 'OLUMLU';
        Log::info('OLUYOR');
    }

    public function render()
    {

        Log::info($this->isBirsey);


        $attachments = $this->getAttachments();
        return view('livewire.attach-component',[
            'attachments' => $attachments
        ]);
    }


    public function getAttachments()
    {
        if ($this->modelId) {
            if ($this->tag) {
                $attachments = Attachment::where('model_name',$this->model)
                ->where('model_item_id',$this->modelId)
                ->where('tag',$this->tag)
                ->get();
            } else {
                $$attachments = Attachment::where('model_name',$this->model)
                ->where('model_item_id',$this->modelId)
                ->get();
            }

            // Log::info($this->sayac++);
            // Log::info($attachments);

            return $attachments;

        }

        return [];
    }



    public function removeFile($fileToRemove) {

        foreach ($this->dosyalar as $key => $dosya) {

            if ($dosya->getClientOriginalName() == $fileToRemove) {
                unset($this->dosyalar[$key]);
            }
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




    #[On('triggerAttachment')]
    public function uploadAttach(Request $request)
    {
        foreach ($this->dosyalar as $dosya) {

            $props['user_id'] = Auth::id();
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

        // Log::info($this->attachments);


        // $this->getAttachments();
        // Log::info($this->attachments);

        // dd(json_encode($this->attachments));
        // session()->put('after', json_encode($this->attachments));
        // session()->flash('success','Change Request Created Successfully!');

        $this->reset('dosyalar');

        $this->dispatch('refreshAttachments'); 
        //$this->mount();
        //return redirect('/admin/companies/view/'.$id);

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
