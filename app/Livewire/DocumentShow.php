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

    public $moreMenu = [];

    public $permissions;

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
        $this->setPermissions();
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








    public function setPermissions() {

        $this->permissions = (object) [
            "show" => true,
            "edit" => false,
            "delete" => false,
            "freeze" => false,
            "release" => false,
            "revise" => false
        ];

        // SHOW/READ
        $this->permissions->show = true;

        // EDIT
        if ( in_array($this->document->status,['Verbatim']) ) {
            $this->permissions->edit = true;
        }

        // DELETE
        if ( in_array($this->document->status,['Verbatim']) ) {
            $this->permissions->delete = true;
        }

        // FREEZE
        if ( in_array($this->document->status,['Verbatim']) ) {
            $this->permissions->freeze = true;
        }

        // RELEASE
        if ( in_array($this->document->status,['Verbatim']) ) {
            $this->permissions->release = true;
        }

        // REVISE
        if ( in_array($this->document->status,['Released']) ) {
            $this->permissions->revise = true;
        }
    }





    public function setMoreMenu() {

        // FREEZE DOCUMENT
        if ( $this->permissions->freeze ) {
            $this->moreMenu[] = [
                'title' =>'Freeze Document',
                'wireclick'=> "freezeConfirm()",
                'icon' => 'Freeze'
            ];
        };

        // RELEASE DOCUMENT
        if ( $this->permissions->release ) {
            $this->moreMenu[] = [
                'title' =>'Release Document',
                'href'=> '/aa/b/',
                'icon' => 'Release'
            ];
        };

        // REVISE DOCUMENT
        if ( $this->permissions->revise ) {
            $this->moreMenu[] = [
                'title' =>'Revise Document',
                'href'=> '/aa/b/',
                'icon' => 'Revise'
            ];
        };


        // DELETE DOCUMENT
        if ( $this->permissions->delete ) {
            $this->moreMenu[] = [
                'title' =>'Delete Document',
                'href'=> 'javascript:confirmDelete()',
                'icon' => 'Delete'
            ];
        };


        $this->moreMenu = (object) $this->moreMenu;

    }















































    /*
    FREEZE
    */

    public function freezeConfirm() {

        $this->dispatch('ConfirmModal', type:'freeze',name:'Document');
        session()->flash('msg',[
            'type' => 'success',
            'text' => 'Document has been frozen successfully.'
        ]);
    }

    #[On('onFreezeConfirmed')]
    public function doFreeze() {

        Document::find($this->id)->update(['status' =>'Frozen']);
    }



    /*
    RELEASE
    */

    public function releaseConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'doc_release');
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



    /*
    REVISE
    */

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


    /*
    DELETE
    */



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





    /*
    SEND MAIL on ACTION COMPLETED
    */

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
