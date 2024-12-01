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
    #[Validate('min:16', message: 'Document title is too short. At least 16 characters')]
    public String $title = '';

    // RECORD ID
    public $uid;

    // DOC NO WITH REVISION
    public $docNo = false;

    // COMPANY
    public $company_id;
    public $company;
    public $companies = [];


    #[Validate('required', message: 'Please select document type')]
    public $doc_type = 'GR';


    #[Validate('required', message: 'Please select document language')]
    public String $language = 'TR';


    // DOCUMENT SYNOPSIS
    #[Validate('required', message: 'Please add a synopsis for document content.')]
    #[Validate('min:16', message: 'Synopsis is too short. At least 16 characters')]
    public String $synopsis = '';


    // FILES
    public $files = [];


    public function setDocumentProps() {

        foreach (Company::all() as $c) {
            $this->companies[$c->id] = $c->name;
        }

        $this->company_id =  Auth::user()->company_id;
        $this->company =  Company::find($this->company_id);
    }





    public function setDocument(Int $id)
    {
        $this->uid = $id;
        $this->document = Document::find($id);
        $this->docNo = $this->document->docNo;
        $this->title = $this->document->title;
        $this->synopsis = $this->document->remarks ? $this->document->remarks:'';
        $this->doc_type = $this->document->doc_type;
        $this->language = $this->document->language;
        $this->company_id =  $this->document->company_id;
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


    public function update($id)
    {
        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['doc_type'] = $this->doc_type;
        $props['language'] = $this->language;
        $props['company_id'] = $this->company_id;
        $props['title'] = $this->title;
        $props['remarks'] = $this->synopsis;

        $props['toc'] = json_encode([]);

        $document = Document::findOrFail($id);

        $document->update($props);

        session()->flash('msg',[
            'type' => 'success',
            'text' => 'Document has been updated successfully.'
        ]);

        return true;
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








