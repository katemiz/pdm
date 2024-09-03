<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

use App\Livewire\FileList;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Attachment;
use App\Models\Counter;
use App\Models\Company;
use App\Models\Document;
use App\Models\User;

use Mail;
use App\Mail\AppMail;


class LwDocument extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW,CFORM,CVIEW,PFORM,PVIEW

    public $datatable_props;

    public $hasActions = true;

    public $constants;

    public $show_latest = true; /// Show only latest revisions

    public $uid = false;
    public $pid = false;

    public $query = false;
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $logged_user;

    public $all_revs = [];

    public $document_no;
    public $revision;
    public $toc = [];    /// Table of Contents
    public $is_latest;

    public $company;
    public $companies = [];

    #[Validate('required', message: 'Please select company')]
    public $company_id;

    #[Validate('required', message: 'Document title is missing')]
    public $title;

    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;

    public $remarks;
    public $status;

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










    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));


        }

        if (request('id')) {

            if ( in_array($this->action,['LIST','FORM','VIEW','CFORM','CVIEW']) ) {
                $this->uid = request('id');
            }

            if ( in_array($this->action,['PFORM','PVIEW']) ) {
                $this->pid = request('id');
            }
        }

        $this->constants = config('documents');

        $this->setCompanyProps();

    }


    public function render()
    {
        $this->datatable_props = Document::getTableModel();

        $this->setProps();



        return view('documents.docs',[
            'documents' => $this->getDocumentsList()
        ]);
    }


    #[On('startQuerySearch')]
    public function querySearch($query)
    {
        $this->query = $query;
    }




    public function setCompanyProps()
    {
        //$this->companies = Company::all();

        foreach (Company::all() as $c) {
            $this->companies[$c->id] = $c->name;
        }


        $this->company_id =  Auth::user()->company_id;
        $this->company =  Company::find($this->company_id);
    }

    public function checkSessionVariables() {

        return true;

        // if (session('current_project_id')) {
        //     $this->project_id = session('current_project_id');
        //     $this->company_id = Project::find($this->project_id)->company_id;
        // }

        // if (session('current_eproduct_id')) {
        //     $this->endproduct_id = session('current_eproduct_id');
        // }
    }









    public function getDocumentsList()  {

        // session()->flash('msg',[
        //     'type' => 'default',
        //     'text' =>'Document have been deleted successfullyrtryty.'
        // ]);


        if ($this->query) {

            return Document::when($this->show_latest, function ($query) {
                $query->where('is_latest', true);
            })
            ->whereAny([
                'title',
                'remarks',
                'document_no',
            ], 'LIKE', "%".$this->query."%")
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));

        } else {

            if ($this->show_latest) {

                return Document::where('is_latest', true)
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));

            } else {

                return Document::all()
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
            }
        }
    }


    public function checkCurrentProduct() {

        /*
        session('current_project_id');
        session('current_project_name');

        session('current_eproduct_id');
        session('current_eproduct_name');
        */

        if (!session('current_project_id') && !session('current_product_id')) {
            return redirect('/product-selector/rl');
        }
    }


    public function getCompaniesList()  {

        if ($this->is_user_admin) {
            $this->companies = Company::all();
        } else {
            $this->companies = Company::where('id',$this->logged_user->company_id)->get();
            $this->company_id = $this->logged_user->company_id;
        }
    }




    public function changeSortDirection ($key) {

        $this->sortField = $key;

        if ($this->constants['list']['headers'][$key]['direction'] == 'asc') {
            $this->constants['list']['headers'][$key]['direction'] = 'desc';
        } else {
            $this->constants['list']['headers'][$key]['direction'] = 'asc';
        }

        $this->sortDirection = $this->constants['list']['headers'][$key]['direction'];
    }


    public function resetFilter() {
        $this->query = '';
    }


    public function viewItem($uid) {
        $this->action = 'VIEW';
        $this->uid = $uid;
    }


    public function editItem($uid) {
        $this->action = 'FORM';
        $this->uid = $uid;
    }


    public function addItem() {
        $this->uid = false;
        $this->action = 'FORM';

        $this->reset('code','name');
    }

    #[On('addContent')]
    public function addContentPage() {

        //$this->paction = 'PFORM';

        dd($this->uid);
    }


    public function setProps() {

        if ($this->uid && in_array($this->action,['VIEW','FORM','CVIEW','CFORM']) ) {

            $c = Document::find($this->uid);

            $this->document_no = $c->document_no;
            $this->revision = $c->revision;
            $this->doc_type = $c->doc_type;
            $this->language = $c->language;
            $this->company_id = $c->company_id;
            $this->title = $c->title;
            $this->is_latest = $c->is_latest;
            $this->remarks = $c->remarks;
            $this->status = $c->status;
            $this->created_at = $c->created_at;
            $this->updated_at = $c->updated_at;
            $this->created_by = User::find($c->user_id)->email;
            $this->updated_by = User::find($c->updated_uid)->email;


            // Revisions
            foreach (Document::where('document_no',$this->document_no)->get() as $doc) {
                $this->all_revs[$doc->revision] = $doc->id;
            }
        }

        if ($this->pid && in_array($this->action,['PVIEW','PFORM']) ) {

            // $p = Page::find($this->pid);

            // $this->uid = $p->document_id;
            // $this->ptitle = $p->title;
            // $this->pcontent = $p->content;
            // $this->pcreated_at = $p->created_at;
            // $this->pupdated_at = $p->updated_at;
            // $this->pcreated_by = User::find($p->user_id);
            // $this->pupdated_by = User::find($p->updated_uid);

            $c = Document::find($this->uid);

            $this->toc = $c->toc;
        }
    }


    public function triggerDelete($uid) {

        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'delete');
    }


    #[On('onDeleteConfirmed')]
    public function deleteItem()
    {
        Document::find($this->uid)->delete();
        session()->flash('message','Document have been deleted successfully.');

        $this->action = 'LIST';
        $this->resetPage();
    }


    public function storeUpdateItem () {

        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['doc_type'] = $this->doc_type;
        $props['language'] = $this->language;
        $props['company_id'] = $this->company_id;
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
            $props['document_no'] = $this->getDocumentNo();
            $this->uid = Document::create($props)->id;
            session()->flash('message','Document has been created successfully.');
        }

        // ATTACHMENTS, TRIGGER ATTACHMENT COMPONENT
        $this->dispatch('triggerAttachment',modelId: $this->uid);


        $this->action = 'VIEW';

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


    public function freezeConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'freeze');

        session()->flash('message','Document has been frozen successfully.');
    }


    public function releaseConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'doc_release');
    }



    #[On('onFreezeConfirmed')]
    public function doFreeze() {
        $this->action = 'VIEW';
        Document::find($this->uid)->update(['status' =>'Frozen']);
    }


    public function reviseConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'revise');
    }


    #[On('onReviseConfirmed')]
    public function doRevise() {

        $original_doc = Document::find($this->uid);

        $revised_doc = $original_doc->replicate();
        $revised_doc->status = 'Verbatim';
        $revised_doc->revision = $original_doc->revision+1;
        $revised_doc->save();

        // Do not Copy files!
        // Delibrate decision

        $original_doc->update(['is_latest' => false]);
        $this->uid = $revised_doc->id;

        $this->dispatch('refreshFileListNewId', modelId:$this->uid);
        $this->action = 'VIEW';
    }


    #[On('onReleaseConfirmed')]
    public function doRelease() {

        $doc = Document::find($this->uid);

        $props['status'] = 'Released';
        $props['approver_id'] = Auth::id();
        $props['app_revised_at'] = time();

        $doc->update($props);

        $this->setProps();

        $this->action = 'VIEW';

        // Send EMails
        $this->sendMail();
    }


    public function sendMail() {

        $msgdata['blade'] = 'emails.document_released';  // Blade file to be used
        $msgdata['subject'] = 'D'.$this->document_no.' R'.$this->revision.' Belge Yayınlanma Bildirimi / Document Release Notification';
        $msgdata['url'] = url('/').'/documents/view/'.$this->uid;
        $msgdata['url_title'] = 'Belge Bağlantısı / Document Link';

        $msgdata['document_no'] = $this->document_no;
        $msgdata['title'] = $this->title;
        $msgdata['revision'] = $this->revision;
        $msgdata['remarks'] = $this->remarks;

        $allCompanyUsers = User::where('company_id',$this->company_id)->get();

        $toArr = [];

        foreach ($allCompanyUsers as $key => $u) {
            array_push($toArr, $u->email);
        }

        if (count($toArr) > 0) {
            session()->flash('message','Document has been released and email has been sent to PDM users successfully.');
            Mail::to($toArr)->send(new AppMail($msgdata));
        } else {
            session()->flash('message','Document has been <b>released</b> but NO email been sent since no users found!');
        }
    }












}
