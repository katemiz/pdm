<?php

namespace App\Livewire;

use Illuminate\Http\Request;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Document;



class DocumentShow extends Component
{
    public $id;
    public $document;


    public $dd_menu = [];



    public function mount() {

        if (request('id')) {
            $this->id = request('id');
        } else {

            dd('Ooops ...');
            return false;
        }

    }


    public function render()
    {
        $this->document = Document::findOrFail($this->id );
        $this->setMoreMenu();

        return view('documents.show');
    }


    // #[On('showRevision')]
    // public function showNewRevision(Int $id) {

    //     dd('showingNewRevision');

    //     $this->id = $id;
    //     $this->document = Document::find(request('id'));
    // }


    public function edit() {
        return $this->redirect('/docs/form/'.$this->id);
    }


    public function add() {
        return $this->redirect('/docs/form');
    }



    #[On('onDeleteConfirmed')]
    public function deleteItem()
    {
        Document::find($this->id)->delete();

        session()->flash('msg',[
            'type' => 'success',
            'text' => 'Document has been deleted successfully.'
        ]);

        return $this->redirect('/document/list');
    }



    public function setMoreMenu() {

        // FREEZE DOCUMENT
        if ( in_array($this->document->status,['Verbatim']) ) {
            $this->dd_menu[] = [
                'title' =>'Freeze Document',
                'href'=> '/aa/b/',
                'icon' => 'overflow-menu-vertical'

            ];
        };

        // RELEASE DOCUMENT
        if ( in_array($this->document->status,['Verbatim']) ) {
            $this->dd_menu[] = [
                'title' =>'Release Document',
                'href'=> '/aa/b/',
                'icon' => 'overflow-menu-vertical'
            ];
        };

        // REVISE DOCUMENT
        if ( in_array($this->document->status,['Frozen','Released']) ) {
            $this->dd_menu[] = [
                'title' =>'Revise Document',
                'href'=> '/aa/b/',
                'icon' => 'overflow-menu-vertical'
            ];
        };
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
        $msgdata['url'] = url('/').'/document/view/'.$this->uid;
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
