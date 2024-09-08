<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Document;
use App\Models\Company;
use App\Models\Counter;



class DocumentForm extends Form
{
    public ?Document $document;

    #[Validate('required', message: 'Please add document title')]
    #[Validate('min:16', message: 'Docuemnt title is too short. At least 16 characters')]
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

    // DOCUMENT TYPE
    public $languages = [
        'EN' => 'English',
        'TR' => 'Türkçe'
    ];

    #[Validate('required', message: 'Please select document language')]
    public $language = 'TR';


    // DOCUMENT SYNOPSIS
    #[Validate('required', message: 'Please add a synopsis for document content.')]
    #[Validate('min:16', message: 'Synopsis is too short. At least 16 characters')]
    public $synopsis = '';

    #[Validate('required', message: 'Please provide a post title')]
    #[Validate('min:3', message: 'This title is too short')]
    public $synopsis2 = '';





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

        $props['user_id'] = Auth::id();
        $props['document_no'] = $this->getDocumentNo();
        $props['updated_uid'] = Auth::id();
        $props['doc_type'] = $this->doc_type;
        $props['language'] = $this->language;
        $props['company_id'] = $this->company_id;
        $props['title'] = $this->title;
        $props['remarks'] = $this->synopsis;

        $props['toc'] = json_encode([]);


        $id = Document::create($props)->id;

        session()->flash('msg',[
            'type' => 'success',
            'text' => 'Document has been created successfully.'
        ]);

        return $id;

    }


    public function update()
    {
        $this->validate();

        $this->document->update(
            $this->all()
        );
    }



    public function getDocumentNo() {

        $parameter = 'document_no';
        $initial_no = config('appconstants.counters.document_no');
        $counter = Counter::find($parameter);

        if ($counter == null) {
            Counter::create([
                'counter_type' => $parameter,
                'counter_value' => $initial_no
            ]);

            return $initial_no;
        }

        $new_no = $counter->counter_value + 1;
        $counter->update(['counter_value' => $new_no]);         // Update Counter
        return $new_no;
    }















}








