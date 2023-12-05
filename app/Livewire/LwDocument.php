<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

use App\Livewire\FileList;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Attachment;
use App\Models\Counter;
use App\Models\Document;
use App\Models\User;



class LwDocument extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW,CFORM,CVIEW,PFORM,PVIEW


    public $constants;

    public $show_latest = true; /// Show only latest revisions
    public $is_html = false;

    public $uid = false;
    public $pid = false;


    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $logged_user;

    public $all_revs = [];

    public $document_no;
    public $revision;
    public $toc = [];    /// Table of Contents
    public $is_latest;


    #[Rule('required', message: 'Document title is missing')]
    public $title;

    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;

    public $remarks;
    public $status;

    public $doc_types = [
        'GR' => 'General Report',
        'TR' => 'Test Report',
        'AR' => 'Analysis Report',
        'MN' => 'Product Manual',
        'PR' => 'Presentation'
    ];

    #[Rule('required', message: 'Please select document type')]
    public $doc_type = 'GR';

    public $languages = [
        'EN' => 'English',
        'TR' => 'Türkçe'
    ];

    #[Rule('required', message: 'Please select document language')]
    public $language = 'TR';


    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));

            if ( in_array($this->action,['LIST','FORM','VIEW']) ) {
                $this->is_html = false;
            }

            if ( in_array($this->action,['CFORM','CVIEW','PFORM','PVIEW']) ) {
                $this->is_html = true;
            }
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
    }


    public function render()
    {
        $this->setProps();

        if ($this->is_html) {
            return view('documents.documentor');
        }

        return view('documents.docs',[
            'documents' => $this->getDocumentsList()
        ]);
    }


    public function checkUserRoles() {

        $this->logged_user = Auth::user();
        $this->company_id = $this->logged_user->company_id;

        if ($this->logged_user->hasRole('admin')) {
            $this->is_user_admin = true;
        }

        if ($this->logged_user->hasRole('company_admin')) {
            $this->is_user_company_admin = true;
        }
    }


    public function checkSessionVariables() {

        if (session('current_project_id')) {
            $this->project_id = session('current_project_id');
            $this->company_id = Project::find($this->project_id)->company_id;
        }

        if (session('current_eproduct_id')) {
            $this->endproduct_id = session('current_eproduct_id');
        }
    }


    public function getDocumentsList()  {

        $documents = Document::when($this->show_latest, function ($query) {
                            $query->where('is_latest', true);
        })
        ->orderBy($this->sortField,$this->sortDirection)
        ->paginate(env('RESULTS_PER_PAGE'));

        return $documents;
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


    public function getProjectsList()  {

        if ($this->is_user_admin && $this->company_id) {
            if (session('current_project_id')) {
                $this->project_id = session('current_project_id');
                $this->projects = Project::find($this->project_id)->get();

            } else {
                $this->projects = Project::where('company_id',$this->company_id)->get();
            }
        } else {
            $this->projects = Project::where('company_id',$this->logged_user->company_id)->get();
        }

        if (count($this->projects) == 1) {
            $this->project_id = $this->projects['0']->id;
        }

        $this->getEndProductsList();
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


    public function viewItem($uid,$is_html) {
        $this->is_html = $is_html;
        $this->action = $is_html ? 'CVIEW':'VIEW';
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

        $this->paction = 'PFORM';

        dd($this->uid);
    }


    public function setProps() {

        if ($this->uid && in_array($this->action,['VIEW','FORM','CVIEW','CFORM']) ) {

            $c = Document::find($this->uid);

            $this->document_no = $c->document_no;
            $this->revision = $c->revision;
            $this->doc_type = $c->doc_type;
            $this->language = $c->language;
            $this->title = $c->title;
            $this->is_html = $c->is_html;
            $this->is_latest = $c->is_latest;
            $this->remarks = $c->remarks;
            $this->status = $c->status;
            $this->created_at = $c->created_at;
            $this->updated_at = $c->updated_at;
            $this->created_by = User::find($c->user_id)->email;
            $this->updated_by = User::find($c->updated_uid)->email;

            if ($c->is_html) {
                $this->fileOrHtml = 'HTML';
            }

            // Revisions
            foreach (Document::where('document_no',$this->document_no)->get() as $doc) {
                $this->all_revs[$doc->revision] = $doc->id;
            }
        }

        if ($this->pid && in_array($this->action,['PVIEW','PFORM']) ) {

            $p = Page::find($this->pid);

            $this->uid = $p->document_id;
            $this->ptitle = $p->title;
            $this->pcontent = $p->content;
            $this->pcreated_at = $p->created_at;
            $this->pupdated_at = $p->updated_at;
            $this->pcreated_by = User::find($p->user_id);
            $this->pupdated_by = User::find($p->updated_uid);

            $c = Document::find($this->uid);

            $this->toc = $c->toc;
        }

    }


    public function triggerDelete($type, $uid) {

        if ($type === 'document') {
            $this->uid = $uid;
        }

        if ($type === 'verification') {
            $this->vid = $uid;
        }

        $this->dispatch('ConfirmModal', type:$type);
    }


    #[On('onDeleteConfirmed')]
    public function deleteItem($type)
    {
        if ($type === 'document') {
            Document::find($this->uid)->delete();
            session()->flash('message','Document have been deleted successfully.');

            $this->action = 'LIST';
            $this->resetPage();
        }

    }


    public function storeUpdateItem () {

        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['doc_type'] = $this->doc_type;
        $props['language'] = $this->language;
        $props['is_html'] = $this->is_html;
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

        if ($this->is_html) {
            $this->action = 'CVIEW';
        } else {
            $this->action = 'VIEW';
        }
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
}
