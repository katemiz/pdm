<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Company;
use App\Models\Counter;



class UserForm extends Form
{
    public ?User $user;

    #[Validate('required', message: 'Please add user name')]
    #[Validate('min:2', message: 'Name is too short. At least 2 characters')]
    public String $name = '';

    #[Validate('required', message: 'Please add user lastname')]
    #[Validate('min:3', message: 'Lastname is too short. At least 3 characters')]
    public String $lastname = '';


    #[Validate('required', message: 'Please add user lastname')]
    #[Validate('min:3', message: 'Lastname is too short. At least 3 characters')]
    public String $lastname = '';

    // RECORD ID
    public $uid;

    // DOC NO WITH REVISION
    public $docNo = false;

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





    public function setUser(Int $id)
    {
        $this->uid = $id;
        $this->user = User::find($id);
        $this->name = $this->user->name;
        $this->lastname = $this->user->lastname;
        $this->email = $this->user->email ? $this->user->email:'';
        $this->password = $this->user->password;
        $this->status = $this->user->status;
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








