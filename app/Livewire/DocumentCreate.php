<?php
 
namespace App\Livewire;
 
use App\Livewire\Forms\DocumentForm;
use Livewire\Component;
use App\Models\Document;
 
class DocumentCreate extends Component
{
    public DocumentForm $form; 

    public $synopsis;


    public function mount() {

        $this->form->setDocumentProps();
    }

 
    public function save()
    {
        $this->form->store(); 
    
        return $this->redirect('/documents');
    }
 
    public function render()
    {

        //dd($this->form);
        return view('livewire.document-create');
    }
}