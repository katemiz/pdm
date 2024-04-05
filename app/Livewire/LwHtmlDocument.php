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

    //public $doctree;

    public $action = 'cover-form'; // cover-form, cover-view, page-form, page-form, page-view
    public $all_revs = [];

    public $parent_node_id = false;

    public $constants;

    public $document_no;

    public $toc;

    public $page;

    public $company;
    public $companies = [];

    public $pnode_id;
    public $nnode_id;

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

            //$this->getDoctree();

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



    public function getDoctree() {

        if ($this->uid) {
            $this->doctree = json_decode(Document::find($this->uid)->toc);

            session(['toc' => $this->doctree]);

        } else {
            $this->doctree = false;
        }
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


    public function addPage($parent_node_id)
    {
        $this->action = 'page-form';
        $this->parent_node_id = $parent_node_id;
        $this->pid = false;
    }


    public function editPage($pid)
    {
        $this->pid = $pid;
        $this->setPageProps();
        $this->action = 'page-form';
    }


    public function storeUpdatePage ($parent_node_id,$pid) {

        $this->validate();

        $props['document_id'] = $this->uid;
        $props['updated_uid'] = Auth::id();
        $props['title'] = $this->ptitle;
        $props['content'] = $this->pcontent;

        $is_update = false;

        if ( $pid > 0 ) {
            // update
            Page::find($pid)->update($props);
            session()->flash('info','Page has been updated successfully.');
            $this->page = Page::find($pid);

            $is_update = true;

        } else {
            // create
            $props['user_id'] = Auth::id();
            $this->page = Page::create($props);
            session()->flash('info','Page has been created successfully.');
        }

        $node = ['id'=> $this->page->id,'name' => $this->ptitle];

        $this->dispatch('updateTreeOnBrowser',parent_node_id:$parent_node_id,node:$node,is_update:$is_update);
        $this->action = 'page-view';
        $this->setPageProps();
    }


    #[On('updateTocInDB')]
    public function updateTocInDB($toc) {
        Document::find($this->uid)->update(['toc' => json_encode($toc)]);
    }




    #[On('viewPage')]
    public function viewPage($pid,$pnode_id,$nnode_id) {
        $this->page = Page::find($pid);
        $this->action = 'page-view';

        $this->pnode_id = $pnode_id;
        $this->nnode_id = $nnode_id;
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
        $this->toc = json_decode($d->toc);
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
