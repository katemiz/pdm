<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Counter;
use App\Models\Company;
use App\Models\Document;
use App\Models\Page;
use App\Models\User;



class LwHtmlDocument extends Component
{
    public $uid;
    public $pid;


    public $action = 'cover-form'; // cover-form, cover-view, page-form, page-form
    public $all_revs = [];


    public $constants;

    public $document_no;

    public $doctree;

    public $company;
    public $companies = [];

    #[Validate('required', message: 'Please select company')]
    public $company_id;

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

    #[Validate('required', message: 'Please select document language')]
    public $language = 'TR';

    public $remarks;
    public $revision;
    public $status;


    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;

    public $title;
    public $toc = [];    /// Table of Contents


    public $ptitle;
    public $pcontent;

    public $pcreated_by;
    public $pupdated_by;
    public $pcreated_at;
    public $pupdated_at;





    public function mount()
    {
        if (request('id')) {
            $this->uid = request('id');

            // if (request('pid')) {
            //     $this->pid = request('pid');
            // }
        }

        if (request('action')) {
            $this->action = request('action');
        }

        $this->constants = config('documents');

        $this->setCompanyProps();
        $this->setDocProps();
        $this->setPageProps();
    }







    public function render()
    {


        return view('documents.html-docs');
    }


    public function setCompanyProps()
    {
        $this->companies = Company::all();
        $this->company_id =  Auth::user()->company_id;
        $this->company =  Company::find($this->company_id);
    }







    public function storeUpdateCover () {

        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['doc_type'] = $this->doc_type;
        $props['company_id'] = $this->company_id;
        $props['language'] = $this->language;
        $props['is_html'] = true;
        $props['toc'] = json_encode($this->toc);
        $props['title'] = $this->title;
        $props['remarks'] = $this->remarks;

        if ( $this->uid ) {
            // update
            Document::find($this->uid)->update($props);
            session()->flash('message','Document has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $props['toc'] = json_encode([]);
            $props['document_no'] = $this->getDocumentNo();
            $this->uid = Document::create($props)->id;
            session()->flash('message','Document has been created successfully.');
        }

        // ATTACHMENTS, TRIGGER ATTACHMENT COMPONENT
        $this->dispatch('triggerAttachment',modelId: $this->uid);


        $this->action = 'cover-view';

        $this->setDocProps();


    }



    public function viewCover() {
        $this->action = 'cover-view';
    }


    public function editCover() {
        $this->action = 'cover-form';
    }


    public function addPage()
    {
        $this->action = 'page-form';
        $this->pid = false;
    }

    public function editPage($pid)
    {
        $this->pid = $pid;
        $this->setPageProps();
        $this->action = 'page-form';
    }



    // public function addNode()
    // {
    //     $this->storeUpdatePage ();


    //     $this->dispatch('addNodeToTree',id: $this->pid,name:$this->ptitle);

    // }



    public function storeUpdatePage () {

        $this->validate();

        $props['document_id'] = $this->uid;
        $props['updated_uid'] = Auth::id();
        $props['title'] = $this->ptitle;
        $props['content'] = $this->pcontent;

        if ( $this->pid ) {
            // update
            Page::find($this->pid)->update($props);
            session()->flash('message','Page has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $this->pid = Page::create($props)->id;
            session()->flash('message','Page has been created successfully.');

            $node = ['id'=> $this->pid,'name' => $this->ptitle];

            $this->dispatch('addNode',$node)->to(LwToc::class);

        }

        $this->action = 'page-view';

        $this->setPageProps();
    }




    public function setDocProps() {

        if (!$this->uid) {
            return true;
        }

        $d = Document::find($this->uid);

        $this->document_no = $d->document_no;
        $this->revision = $d->revision;
        $this->is_latest = $d->is_latest;
        $this->doc_type = $d->doc_type;
        $this->language = $d->language;
        $this->company_id = $d->company_id;
        $this->title = $d->title;
        $this->doctree = json_decode($d->toc);
        $this->remarks = $d->remarks;
        $this->status = $d->status;
        $this->created_at = $d->created_at;
        $this->updated_at = $d->updated_at;
        $this->created_by = User::find($d->user_id)->email;
        $this->updated_by = User::find($d->updated_uid)->email;
    }


    public function setPageProps() {

        if (!$this->pid) {
            return true;
        }

        $p = Page::find($this->pid);

        $this->ptitle = $p->title;
        $this->pcontent = $p->content;
        $this->pcreated_at = $p->created_at;
        $this->pupdated_at = $p->updated_at;
        $this->pcreated_by = User::find($p->user_id)->email;
        $this->pupdated_by = User::find($p->updated_uid)->email;
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
