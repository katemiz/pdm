<?php

namespace App\Livewire;

use App\Livewire\Forms\DocumentForm;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

use Livewire\WithFileUploads;

use App\Models\Document;

class DocumentUpdate extends Component
{
    use WithFileUploads;

    public DocumentForm $form;

    public Int $id;

    #[Validate(['files.*' => 'image|max:1024'])]
    public $files = [];
 

    public function mount()
    {
        $this->form->setDocumentProps();

        if (request('id')) {

            $this->id = request('id');
            $this->form->setDocument($this->id);
        } else {
            dd('Ooops...');
        }
    }


    public function update()
    {

//        Log::info('FIRST ACTION , dispatch');
//        Log::info(time());


        // ATTACHMENTS
        // $this->dispatch('startUpload', mid: $this->id,collection:"Doc",model_name:"Document" )->to(FileUpload::class);

//        Log::info('SECOND ACTION , update record');
//        Log::info(time());

        // FORM PARAMETERS UPDATE
        $this->form->update($this->id);

        $model = Document::find($this->id);

        foreach ($this->files as $file) {
            $model->addMedia($file)->toMediaCollection('Doc');
        }



        //return $this->redirect('/document/list');

        return to_route('docView', ['id' => $this->id]);

        //return view('documents.docs-view');

        //return $this->redirect('/document/view/'.$this->id);
    }

    public function render()
    {
        return view('documents.docs-form');
    }
}
