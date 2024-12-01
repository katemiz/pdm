<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Auth;

use App\Models\Material;
use App\Models\User;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MaterialShow extends Component
{
    public $uid;
    public $material;
    public $moreMenu = [];
    public $permissions;

    public $conf;


    public function mount() {

        $this->conf = config('conf_materials');

        if (request('id')) {
            $this->uid = request('id');
        } else {

            dd('Ooops ...');
            return false;
        }
    }


    public function render()
    {
        $this->material = Material::findOrFail($this->uid );
        $this->setPermissions();
        $this->setMoreMenu();

        return view('materials.show');
    }


    public function edit() {
        $redirect = Str::replace('{id}',$this->uid,$this->conf['formEdit']['route']);
        return $this->redirect($redirect);
    }


    public function add() {
        return $this->redirect($this->conf['formCreate']['route']);
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
        if ( in_array($this->material->status,['Active','Inactive']) ) {
            $this->permissions->edit = true;
        }

        // DELETE
        if ( in_array($this->material->status,['Verbatim']) ) {
            $this->permissions->delete = true;
        }

        // FREEZE
        if ( in_array($this->material->status,['Verbatim']) ) {
            $this->permissions->freeze = true;
        }

        // RELEASE
        if ( in_array($this->material->status,['Verbatim','Frozen']) ) {
            $this->permissions->release = true;
        }

        // REVISE
        if ( in_array($this->material->status,['Released','Frozen']) ) {

            // Do we have already revised version?

            $revised = Document::where([
                ["material_no",'=',$this->material->document_no],
                ["revision", '>', $this->material->revision]
            ])->first();

            if ($revised == null) {
                $this->permissions->revise = true;
            }

        }
    }



    public function setMoreMenu() {

        $mtitle = $this->conf['modelTitle'];

        // FREEZE DOCUMENT
        if ( $this->permissions->freeze ) {
            $this->moreMenu[] = [
                'title' =>'Freeze Document',
                'wireclick'=> "triggerModal('freeze','$mtitle')",
                'icon' => 'Freeze'
            ];
        };

        // RELEASE DOCUMENT
        if ( $this->permissions->release ) {
            $this->moreMenu[] = [
                'title' =>'Release Document',
                'wireclick'=> "triggerModal('release','$mtitle')",
                'icon' => 'Release'
            ];
        };

        // REVISE DOCUMENT
        if ( $this->permissions->revise ) {
            $this->moreMenu[] = [
                'title' =>'Revise Document',
                'wireclick'=> "triggerModal('revise','$mtitle')",
                'icon' => 'Revise'
            ];
        };


        // DELETE DOCUMENT
        if ( $this->permissions->delete ) {
            $this->moreMenu[] = [
                'title' =>'Delete Document',
                'wireclick'=> "triggerModal('delete','$mtitle')",
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
            'text' => 'Document has been frozen successfully.'
        ]);

        $redirect = Str::replace('{id}',$this->uid,$this->conf['show']['route']);
        return redirect($redirect);
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

        $redirect = Str::replace('{id}',$this->uid,$this->conf['show']['route']);
        return redirect($redirect);
    }


    /*
    WHEN REVISE CONFIRMED
    */
    #[On('onReviseConfirmed')]
    public function doRevise($type,$withFiles) {

        $msgtext = 'Document has been revised (without files) successfully.';

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

        $redirect = Str::replace('{id}',$this->uid,$this->conf['show']['route']);
        return redirect($redirect);
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
            $redirect = Str::replace('{id}',$prevDoc->id,$this->conf['show']['route']);
            return $this->redirect($redirect);
        }

        return $this->redirect($this->conf['index']['route']);
    }


    /*
    SEND MAIL on ACTION COMPLETED
    */

    public function sendMail($doc) {

        $msgdata['blade'] = 'emails.document_released';  // Blade file to be used
        $msgdata['subject'] = 'D'.$doc->document_no.' R'.$doc->revision.' Belge Yayınlanma Bildirimi / Document Release Notification';
        $msgdata['url'] = url('/').'/materials/'.$this->uid;
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
