<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Auth;

use App\Models\Company;
use App\Models\User;


use Illuminate\Support\Carbon;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RoleShow extends Component
{
    public $uid;
    public $user;
    public $moreMenu = [];
    public $permissions;
    public $modelTitle = 'User';

    public $company;

    public function mount() {

        if (request('id')) {
            $this->uid = request('id');
        } else {

            dd('Ooops ...');
            return false;
        }
    }


    public function render()
    {
        $this->user = User::findOrFail($this->uid );
        $this->company =  Company::find($this->user->company_id)->name;

        $this->setPermissions();
        $this->setMoreMenu();

        return view('admin.users.show');
    }


    public function edit() {
        return $this->redirect('/usrs/form/'.$this->uid);
    }


    public function add() {
        return $this->redirect('/usrs/form');
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
        if ( in_array($this->user->status,['Active','Inactive']) ) {
            $this->permissions->edit = true;
        }
        
    }


    public function setMoreMenu() {

        // FREEZE DOCUMENT
        if ( $this->permissions->freeze ) {
            $this->moreMenu[] = [
                'title' =>'Freeze Document',
                'wireclick'=> "triggerModal('freeze','$this->modelTitle')",
                'icon' => 'Freeze'
            ];
        };

        // RELEASE DOCUMENT
        if ( $this->permissions->release ) {
            $this->moreMenu[] = [
                'title' =>'Release Document',
                'wireclick'=> "triggerModal('release','$this->modelTitle')",
                'icon' => 'Release'
            ];
        };

        // REVISE DOCUMENT
        if ( $this->permissions->revise ) {
            $this->moreMenu[] = [
                'title' =>'Revise Document',
                'wireclick'=> "triggerModal('revise','$this->modelTitle')",
                'icon' => 'Revise'
            ];
        };


        // DELETE DOCUMENT
        if ( $this->permissions->delete ) {
            $this->moreMenu[] = [
                'title' =>'Delete Document',
                'wireclick'=> "triggerModal('delete','$this->modelTitle')",
                'icon' => 'Delete'
            ];
        };
    }


    /*
    WHEN FREEZE CONFIRMED
    */
    #[On('onFreezeConfirmed')]
    public function freezeConfirm() {

        $props['status'] = 'Frozen';
        $props['approver_id'] = Auth::id();
        $props['app_reviewed_at'] = Carbon::now()->toDateTimeString();

        Document::find($this->uid)->update($props);

        session()->flash('msg',[
            'type' => 'success',
            'text' => 'User has been frozen successfully.'
        ]);

        return redirect('/usrs/'.$this->uid);
    }


    /*
    WHEN RELEASE CONFIRMED
    */
    #[On('onReleaseConfirmed')]
    public function doRelease() {

        $doc = Document::find($this->uid);

        $props['status'] = 'Released';
        $props['approver_id'] = Auth::id();
        $props['app_revised_at'] = time();

        $doc->update($props);

        // Send EMails
        $this->sendMail($doc);

        return redirect('/usrs/'.$this->uid);
    }


    /*
    WHEN REVISE CONFIRMED
    */
    #[On('onReviseConfirmed')]
    public function doRevise($type,$withFiles) {

        $msgtext = 'User has been revised (without files) successfully.';

        $original_doc = Document::find($this->uid);

        $revised_doc = $original_doc->replicate();
        $revised_doc->status = 'Verbatim';
        $revised_doc->revision = $original_doc->revision+1;
        $revised_doc->approver_id = null;
        $revised_doc->app_reviewed_at = null;

        $revised_doc->save();

        $this->uid = $revised_doc->id;

        if ($withFiles) {

            // COPY FILES TO NEW REVISION
            $orgMedia = $original_doc->getMedia('Doc');
            
            $revised_doc = Document::find($this->uid);
            
            foreach ($orgMedia as $mediaItem) {

                $newMediaItem = new Media();
                $mediaItem->copy($revised_doc, 'Doc');
            }

            $msgtext = 'Document has been revised with files successfully.';
        }

        $original_doc->update(['is_latest' => false]);

        session()->flash('msg',[
            'type' => 'success',
            'text' => $msgtext
        ]);

        return redirect('/docs/'.$this->uid);
    }


    /*
    WHEN DELETE CONFIRMED
    */
    #[On('onDeleteConfirmed')]
    public function doDelete()
    {
        $doc = Document::find($this->uid);

        $allMedia = $doc->getMedia('Doc');
            
        foreach ($allMedia as $media) {
            $media->delete();
        }

        // Do we have previous revision?  If so make it latest
        if ($doc->revision > 1) {

            $prevDoc = Document::where([
                ['document_no','=',$doc->document_no],
                ['revision','=',$doc->revision - 1]
            ])->first();
    
            $prevDoc->update(['is_latest' => true]);
        }

        // Attached Media is deleted. Previous Rev made latest. Delete Doc
        $doc->delete();

        session()->flash('msg',[
            'type' => 'success',
            'text' => 'Document and media has been deleted successfully.'
        ]);

        if ( isset($prevDoc) ) {
            return $this->redirect('/docs/'.$prevDoc->id);
        }

        return $this->redirect('/docs');
    }


    /*
    SEND MAIL on ACTION COMPLETED
    */

    public function sendMail($doc) {

        $msgdata['blade'] = 'emails.document_released';  // Blade file to be used
        $msgdata['subject'] = 'D'.$doc->document_no.' R'.$doc->revision.' Belge Yayınlanma Bildirimi / Document Release Notification';
        $msgdata['url'] = url('/').'/document/view/'.$this->uid;
        $msgdata['url_title'] = 'Belge Bağlantısı / Document Link';

        $msgdata['document_no'] = $doc->document_no;
        $msgdata['title'] = $doc->title;
        $msgdata['revision'] = $doc->revision;
        $msgdata['remarks'] = $doc->remarks;

        $allCompanyUsers = User::where('company_id',$doc->company_id)->get();

        $toArr = [];

        foreach ($allCompanyUsers as $usr) {
            if ($usr->status == 'active') {
                array_push($toArr, $usr->email);
            }
        }

        if (count($toArr) > 0) {

            session()->flash('msg',[
                'type' => 'success',
                'text' => 'Document has been released and email has been sent to PDM users successfully.'
            ]);

            Mail::to($toArr)->send(new AppMail($msgdata));

        } else {

            session()->flash('msg',[
                'type' => 'warning',
                'text' => 'Document has been <b>released</b> but NO email been sent since no users found!'
            ]);
        }
    }

}
