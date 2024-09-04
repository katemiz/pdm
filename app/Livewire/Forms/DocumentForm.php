<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Document;
use App\Models\Company;


class DocumentForm extends Form
{
    public ?Document $document;

    #[Validate('required|min:5')]
    public $title = '';
 


    // COMPANY
    public $company_id;
    public $company;
    public $companies = [];

    // DOCUMENT TYPE
    public $doc_types = [
        'GR' => 'General Document',
        'TR' => 'Test Report',
        'AR' => 'Analysis Report',
        'MN' => 'User Manual',
        'ME' => 'Memo',
        'PR' => 'Presentation'
    ];

    #[Validate('required', message: 'Please select document type')]
    public $doc_type = 'GR';

    public $languages = [
        'EN' => 'English',
        'TR' => 'Türkçe'
    ];


    // DOCUMENT SYNOPSIS
    #[Validate('required|min:5')]
    public $synopsis = 'Synopsis conetent';




    public function setDocumentProps() {

        foreach (Company::all() as $c) {
            $this->companies[$c->id] = $c->name;
        }
    

        $this->company_id =  Auth::user()->company_id;
        $this->company =  Company::find($this->company_id);


    }




     
    public function setPost(Document $document)
    {
        $this->document = $document;
 
        $this->title = $document->title;
 
        $this->synopsis = $document->synopsis;
    }




    public function store()
    {
        $this->validate();

        dd([$this->title,$this->synopsis,$this->company_id,$this->doc_type]);
 
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







 
