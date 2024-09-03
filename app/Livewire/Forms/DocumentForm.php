<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use App\Models\Document;


class DocumentForm extends Form
{
    public ?Document $document;

    #[Validate('required|min:5')]
    public $title = '';
 
    #[Validate('required|min:5')]
    public $content = '';



     
    public function setPost(Document $document)
    {
        $this->document = $document;
 
        $this->title = $document->title;
 
        $this->content = $document->content;
    }




    public function store()
    {
        $this->validate();
 
        Post::create($this->only(['title', 'content']));
    }


    public function update()
    {
        $this->validate();
 
        $this->document->update(
            $this->all()
        );
    }


}







 
