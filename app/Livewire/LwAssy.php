<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Auth;

use App\Models\Attachment;
use App\Models\CNotice;
use App\Models\Counter;
use App\Models\Fnote;
use App\Models\Item;
use App\Models\NoteCategory;
use App\Models\User;

use Mail;
use App\Mail\AppMail;

use Carbon\Carbon;


class LwAssy extends Component
{
    use WithPagination;

    public $part_type = 'Assy';

    public $page_view_title = 'Assembled Products';
    public $page_view_subtitle = 'Assembled Products Properties';

    public $list_all_url = '/parts/list';
    public $item_edit_url = '/products-assy/form';
    public $item_view_url = '/products-assy/view';

    public $has_material = false;
    public $has_notes = true;
    public $has_flag_notes = true;
    public $has_vendor = false;

    public $uid;

    public $query = '';
    public $sortField = 'part_number';
    public $sortDirection = 'DESC';

    public $action;
    public $showSelectComponentsDiv = false;

    public $showFirstLevelBOM = true;
    public $constants;

    #[Validate('required', message: 'Please enter description')]
    public $description;

    #[Validate('required|numeric', message: 'Please select ECN')]
    public $c_notice_id;

    public $item;

    public $part_number;
    public $remarks;

    public $isSellable = false;

    public $has_mirror = false;
    public $is_mirror_of = false;

    public $mirror_part_number =  false;
    public $mirror_part_version =  false;
    public $mirror_part_description =  false;

    public $is_mirror_of_part_number =  false;
    public $is_mirror_of_part_version =  false;
    public $is_mirror_of_part_description =  false;

    public $is_latest;

    public $status;

    public $unit = 'mm';
    public $version;
    public $weight;

    public $ecns;

    public $fnotes  = [];
    public $notes  = [];
    public $ncategories = [];
    public $notes_id_array = [];

    public $all_revs = [];

    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;

    public $company_id;

    public $release_errors = false;
    public $parts_list = false;

    public $release_integrity_ok = false;

    // public $parents = [];

    public $config_number;
    public $config_description; 

    public $currentConfigId = false;
    public $currentConfig = false;
    public $base_part = false;


    public $conf_modal_show = false;

    public $hasConfigurations = false;
    public $configurations = [];





    public function mount()
    {
        if (request('id')) {
            $this->uid = request('id');
            $this->setFlagNotes();
        }

        $this->action = strtoupper(request('action'));

        $this->setNotes();
        $this->setECNs();

        $this->constants = config('assy_nodes');

        $this->setCompanyProps();
    }


    public function render()
    {
        $this->setProps();

        return view('products.assy.assy',[
            'nodes' => $this->getNodes()
        ]);
    }


    public function setECNs() {
        $this->ecns =  CNotice::where('status','wip')->get();
    }


    public function setNotes() {
        $this->ncategories = NoteCategory::orderBy('text_tr')->get();
    }


    public function setFlagNotes() {
        foreach (Fnote::where('item_id',$this->uid)->orderBy('text_tr')->get() as $r) {
            $this->fnotes[] = ['no' => $r->no,'text_tr' => $r->text_tr,'text_en' => $r->text_en];
        }
    }


    public function setCompanyProps()
    {
        $this->company_id =  Auth::user()->company_id;
        //$this->company =  Company::find($this->company_id);
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


    public function getNodes() {

        if ( strlen($this->query) > 2 ) {

            return Item::where('part_number', 'LIKE', "%".$this->query."%")
                ->orWhere('standard_number', 'LIKE', "%".$this->query."%")
                ->orWhere('description', 'LIKE', "%".$this->query."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));

        } else {

            return Item::orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
        }
    }




    public function addNode($idNode) {

        $p = Item::find($idNode);
        $this->dispatch('refreshTree',id: $p->id,name: $p->description);
    }



    public function setProps() {

        if ( !$this->uid || !in_array($this->action,['VIEW','FORM']) ) {
            return true;
        }

        $this->item = Item::find($this->uid);

        //dd($item->components);

        // if ($item->status == 'WIP') {
        //     $this->isItemEditable = true;
        //     $this->isItemDeleteable = true;
        // }

        $this->part_number = $this->item->part_number;
        $this->version = $this->item->version;
        $this->weight = $this->item->weight;
        $this->unit = $this->item->unit;
        $this->hasConfigurations = $this->item->hasConfigurations;
        $this->isSellable = $this->item->isSellable;
        $this->description = $this->item->description;
        $this->c_notice_id = $this->item->c_notice_id;
        $this->remarks = $this->item->remarks;
        $this->status = $this->item->status;
        $this->is_latest = $this->item->is_latest;

        // $this->treeData =[];

        // if ($item->bom) {

        //     $children = json_decode($item->bom);

        //     foreach ($children as $i) {
        //         $child = Item::find($i->id);
        //         $i->part_type = $child->part_type;
        //         $i->description = $child->description;

        //         array_push($this->treeData, $i);
        //     }
        // }

        // $this->setTreeData($this->item);   

        $this->created_by = User::find($this->item->user_id);
        $this->created_at = $this->item->created_at;
        $this->updated_by = User::find($this->item->updated_uid);
        $this->updated_at = $this->item->updated_at;
        // $this->checked_by = User::find($this->item->checker_id);
        // $this->approved_by = User::find($this->item->approver_id);

        // $this->check_reviewed_at = $this->item->check_reviewed_at;
        // $this->app_reviewed_at = $this->item->app_reviewed_at;

        $this->notes_id_array = [];
        $this->notes = $this->item->pnotes;

        foreach ($this->item->pnotes as $note) {
            array_push($this->notes_id_array,$note->id);
        }

        // Get Configurations
        $this->getConfigurations();

        // Revisions
        foreach (Item::where('part_number',$this->part_number)->get() as $i) {
            $this->all_revs[$i->version] = $i->id;
        }

        // Get Parents
        $parents = Item::whereJsonContains('bom',['id' => (int) $this->uid])->get();
        if ($parents) {
            $this->parents = $parents;
        }
    }







    public function addChild($idAssy,$idChild) {

        // Check if child already exists in the same assy
        $existing = Item::find($idAssy)->components()->where('child_id',$idChild)->first();

        if ($existing) {
            // Increase Quantity
            Item::find($this->uid)
                ->components()
                ->updateExistingPivot($existing->id, [
                    'quantity' => DB::raw('quantity + 1'),
                ]);

            // Refresh Tree
            $this->dispatch('components-updated');
            return;
        }

        $this->item = Item::find($idAssy);

        // Attach components
        $this->item->components()->attach($idChild, [
            'quantity' => 1,
        ]);

        // Refresh entire model (reloads all relationships)
        $this->item->refresh();

        // Refresh Tree
        $this->dispatch('components-updated');
    }


    public function getConfigurations() {
        $this->configurations = Item::where('basePartId',$this->uid)->get();
    }


    public function storeItem()
    {
        $this->validate();

        try {
            $this->item = Item::create([
                'part_type' => $this->part_type,
                'description' => $this->description,
                'part_number' => $this->getProductNo(),
                'c_notice_id' => $this->c_notice_id,
                'weight' => $this->weight,
                'hasConfigurations' => $this->hasConfigurations,
                'isSellable' => $this->isSellable,
                'unit' => $this->unit,
                'remarks' => $this->remarks,
                'user_id' => Auth::id(),
                'updated_uid' => Auth::id()
            ]);

            session()->flash('success','Assy has been created successfully!');

            // Attach Notes to Product
            $this->item->pnotes()->attach($this->notes_id_array);

            $this->uid = $this->item->id;

            // Flag Notes
            foreach ($this->fnotes as $fnote) {
                $props['item_id'] = $this->uid;
                $props['no'] = $fnote['no'];
                $props['text_tr'] = $fnote['text_tr'];
                Fnote::create($props);
            }

            $this->dispatch('triggerAttachment', modelId: $this->uid);
            $this->dispatch('saveTree',idAssy: $this->item->id);

            $this->action = 'VIEW';

        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!'.$ex);
        }
    }



    public function updateItem()
    {
        $this->validate();

        try {

            Item::whereId($this->uid)->update([
                'description' => $this->description,
                'c_notice_id' => $this->c_notice_id,
                'weight' => $this->weight,
                'hasConfigurations' => $this->hasConfigurations,
                'isSellable' => $this->isSellable,
                'unit' => $this->unit,
                'remarks' => $this->remarks,
                'updated_uid' => Auth::id()
            ]);

            $aaa = Item::find($this->uid);

            // Update Notes to Product
            $aaa->pnotes()->detach();
            $aaa->pnotes()->attach(array_unique($this->notes_id_array));

            // Flag Notes (Special Notes)
            Fnote::where('item_id',$this->uid)->delete();

            foreach ($this->fnotes as $fnote) {
                $props['item_id'] = $this->uid;
                $props['no'] = $fnote['no'];
                $props['text_tr'] = $fnote['text_tr'];
                Fnote::create($props);
            }

            session()->flash('message','Assy part has been updated successfully!');

            $this->dispatch('triggerAttachment',
                modelId: $this->uid
            );

            $this->action = 'VIEW';

        } catch (\Exception $ex) {
            session()->flash('success','Something goes wrong!!');
        }
    }





    public function getProductNo() {

        $parameter = 'product_no';
        $initial_no = config('appconstants.counters.product_no');
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


    public function addSNote() {
        $this->fnotes[] = [];
    }


    public function deleteSNote($key) {
        unset($this->fnotes[$key]);
    }



    // #[On('addTreeToDB')]
    // public function addTreeToDB($bomData) {

    //     if ($this->uid) {

    //         $props['bom'] = $bomData;

    //         $i = Item::find($this->uid);
    //         $sonuc = $i->update($props);

    //         // Log::info($i);
    //         // Log::info($props);
    //     }
    // }









    public function deleteConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'delete');
    }


    #[On('onDeleteConfirmed')]
    public function doDelete() {

        $current_item = Item::find($this->uid);

        if ($current_item->version > 0) {

            $previous_item = Item::where("part_number",$current_item->part_number)
            ->where("version",$current_item->version-1)->first();

            $previous_item->update(['is_latest' => true]);
        }

        $current_item->delete();

        session()->flash('info','Item has been deleted successfully!');

        redirect('/parts/list');
    }




    public function freezeConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'freeze');
    }


    #[On('onFreezeConfirmed')]
    public function doFreeze() {
        Item::find($this->uid)->update(['status' =>'Frozen']);
        $this->action = 'VIEW';
        $this->setProps();
    }






    public function reviseConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'revise');
    }


    #[On('onReviseConfirmed')]
    public function doRevise() {

        $original_part = Item::find($this->uid);
        $revised_part = $original_part->replicate();

        $revised_part->status = 'WIP';
        $revised_part->version = $original_part->version+1;

        $revised_part->save();

        // Do not Copy files!
        // Delibrate decision

        $original_part->update(['is_latest' => false]);

        $this->uid = $revised_part->id;
        $this->action = 'VIEW';

        $this->setProps();

        // This refreshes new item attachments
        $this->dispatch('triggerAttachment',modelId: $this->uid);
    }




    public function resetFilter() {
        $this->query = '';
    }

    public function releaseConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'assy_release');
    }












    #[On('onReleaseConfirmed')]
    public function doRelease() {

        $this->release_errors = false;

        $this->checkAssyIntegrity($this->uid);

        if ( !$this->release_errors ) {

            $this->parts_list = [];

            $this->releaseAssy($this->uid);

            $this->setProps();

            $this->action = 'VIEW';

            session()->flash('message','Product Dataset has been released and email has been sent to PDM users successfully.');

            // Send EMails

            $this->sendReleaseMail();
        }
    }



    public function checkIntegrity($id) {
        $this->checkAssyIntegrity($id);
    }





    public function checkAssyIntegrity($idItem) {

        $item = Item::find($idItem);

        $attachments = Attachment::where('model_name','Product')
            ->where('model_item_id',$idItem)->get();


        $has_step = false;
        $has_dwg = false;

        foreach ($attachments as $dosya) {

            $ext = substr(strrchr($dosya->original_file_name, '.'), 1);

            if ($dosya->tag == 'DWG-BOM' && in_array($ext, ['pdf','PDF'])) {
                $has_dwg = true;
            }
        }


        if ( !$has_dwg ) {

            $this->release_errors[$item->part_number][] = [
                'id' => $item->id,
                'part_number' => $item->part_number,
                'error' => 'Drawing file (pdf) not attached'
            ];
        }


        if ( count($item->components) < 1 ) {

            $this->release_errors[$item->part_number][] = [
                'id' => $item->id,
                'part_number' => $item->part_number,
                'error' => 'Assembly has no children parts'
            ];

        } else {

            foreach ( $item->components as $children) {

                switch ($children->part_type) {

                    case 'Detail':
                        $this->checkDetailIntegrity($children->id);
                        break;

                    case 'Buyable':
                        $this->checkBuyableIntegrity($children->id);
                        break;

                    case 'Assy':
                        $this->checkAssyIntegrity($children->id);
                        break;
                }
            }
        }


        if (!$this->release_errors) {
            $this->release_integrity_ok = true;
        }

    }


    public function checkDetailIntegrity($id) {

        $d = Item::find($id);


        if ($d->is_mirror_of != NULL && is_numeric($d->is_mirror_of)) {
            return true;
        }

        if ( $d->c_notice_id == NULL ) {

            $this->release_errors[$d->part_number][] = [
                'id' => $d->id,
                'part_number' => $d->part_number,
                'error' => 'No ECN defined'
            ];
        }


        if ( $d->weight == NULL || $d->weight < 0 ) {

            $this->release_errors[$d->part_number][] = [
                'id' => $d->id,
                'part_number' => $d->part_number,
                'error' => 'Weight not defined'
            ];
        }


        $attachments = Attachment::where('model_name','Product')
            ->where('model_item_id',$id)->get();


        $has_step = false;
        $has_dxf = true;
        $has_dwg = false;

        foreach ($attachments as $dosya) {

            $ext = substr(strrchr($dosya->original_file_name, '.'), 1);

            if ($dosya->tag == 'STEP' && in_array($ext, ['STEP','stp','step'])) {
                $has_step = true;
            }

            // if ($dosya->tag == 'STEP' && in_array($ext, ['DXF','dxf'])) {
            //     $has_dxf = true;
            // }

            if ($dosya->tag == 'DWG-BOM' && in_array($ext, ['pdf','PDF'])) {
                $has_dwg = true;
            }
        }



        if ( !$has_step ) {

            $this->release_errors[$d->part_number][] = [
                'id' => $d->id,
                'part_number' => $d->part_number,
                'error' => 'STEP file not attached'
            ];
        }

        if ( !$has_dxf ) {

            $this->release_errors[$d->part_number][] = [
                'id' => $d->id,
                'part_number' => $d->part_number,
                'error' => 'DXF file not attached'
            ];
        }

        if ( !$has_dwg ) {

            $this->release_errors[$d->part_number][] = [
                'id' => $d->id,
                'part_number' => $d->part_number,
                'error' => 'Drawing file (pdf) not attached'
            ];
        }
    }


    public function checkBuyableIntegrity($id) {

        $b = Item::find($id);

        if ( $b->c_notice_id == NULL ) {

            $this->release_errors[$b->part_number][] = [
                'id' => $b->id,
                'part_number' => $b->part_number,
                'error' => 'No ECN defined'
            ];
        }


        if ( $b->weight == NULL || $b->weight < 0 ) {

            $this->release_errors[$b->part_number][] = [
                'id' => $b->id,
                'part_number' => $b->part_number,
                'error' => 'Weight not defined'
            ];
        }


        if ( $b->vendor == NULL ) {

            $this->release_errors[$b->part_number][] = [
                'id' => $b->id,
                'part_number' => $b->part_number,
                'error' => 'Vendor name not defined'
            ];
        }


        if ( $b->vendor_part_no == NULL ) {

            $this->release_errors[$b->part_number][] = [
                'id' => $b->id,
                'part_number' => $b->part_number,
                'error' => 'Vendor part number not defined'
            ];
        }

        if ( $b->url == NULL ) {

            $this->release_errors[$b->part_number][] = [
                'id' => $b->id,
                'part_number' => $b->part_number,
                'error' => 'Buyable part URL not defined'
            ];
        }



    }



    public function confModalToggle() {
        $this->conf_modal_show = !$this->conf_modal_show;
    }   


    public function saveConfiguration($configurationId = false) {  


        $this->validate([
            'config_number' => 'required|string|max:255',
        ]);


        if ($configurationId) {
            // Update Existing Configuration

            $props['config_number'] = $this->config_number;
            $props['description'] = $this->config_description;

            $configItem = Item::find($configurationId);
            $configItem->update($props);

            $this->currentConfigId = $configItem->id;
        } else {
            // Create New Configuration
            $props['hasConfigurations'] = false;
            $props['config_number'] = $this->config_number;
            $props['description'] = $this->config_description;
            $props['basePartId'] = $this->uid;
            $props['part_type'] = $this->part_type;
            $props['part_number'] = $this->part_number;
            $props['description'] = $this->description.' - '.$this->config_description;
            $props['c_notice_id'] = $this->c_notice_id;
            $props['weight'] = $this->weight;
            $props['unit'] = $this->unit;
            $props['remarks'] = $this->remarks;
            $props['user_id'] = Auth::id();
            $props['updated_uid'] = Auth::id();
            $props['version'] = $this->version;
            $props['is_latest'] = true;

            $this->configItem =Item::create($props); 
            $this->currentConfigId = $this->configItem->id;
  

        }






        $this->getConfigurations();

        $this->confModalToggle();

        //dd($props);





    }


    public function setCurrentConfig($id) {

        $this->setCurrentConfigId($id);
        $this->confModalToggle();
    }



    public function setCurrentConfigId($id) {
        $this->currentConfigId = $id;

        $this->currentConfig = Item::find($id);

        $this->config_number = $this->currentConfig->config_number;
        $this->config_description = $this->currentConfig->description;
    }


    public function releaseAssy($id) {

        $rel = Item::find($id);

        $props['status'] = 'Released';
        $props['approver_id'] = Auth::id();
        $props['app_reviewed_at'] = time();

        $this->parts_list[] = [$rel->id,$rel->part_number,$rel->description];

        $props['status'] = 'Released';
        $props['approver_id'] = Auth::id();
        $props['app_reviewed_at'] = Carbon::now();

        $rel->update($props);

        foreach ( $rel->components as $children) {

            switch ($children->part_type) {

                case 'Detail':
                    $this->releaseDetail($children->id);
                    break;

                case 'Buyable':
                    $this->releaseBuyable($children->id);
                    break;

                case 'Assy':
                    $this->releaseAssy($children->id);
                    break;
            }
        }



    }



    public function releaseDetail($id) {

        $rel = Item::find($id);

        $this->parts_list[] = [$rel->id,$rel->part_number,$rel->description];


        $props['status'] = 'Released';
        $props['approver_id'] = Auth::id();
        $props['app_reviewed_at'] = Carbon::now();

        $rel->update($props);

    }

    public function releaseBuyable($id) {

        $rel = Item::find($id);

        $this->parts_list[] = [$rel->id,$rel->part_number,$rel->description];


        $props['status'] = 'Released';
        $props['approver_id'] = Auth::id();
        $props['app_reviewed_at'] = Carbon::now();

        $rel->update($props);

    }









    public function sendReleaseMail() {

        $msgdata['blade'] = 'emails.dataset_released';  // Blade file to be used
        $msgdata['subject'] = 'Teknik Veri Yayınlanma Bildirimi / Dataset Release Notification';
        $msgdata['url'] = url('/').'/products-assy/view/'.$this->uid;
        $msgdata['url_title'] = 'Ürün Verisi Bağlantısı / Dataset Link';

        $msgdata['part_number'] = $this->part_number;
        $msgdata['description'] = $this->description;
        $msgdata['version'] = $this->version;
        $msgdata['remarks'] = $this->remarks;

        $msgdata['parts_list'] = $this->parts_list;

        $allCompanyUsers = User::where('company_id',$this->company_id)->get();

        $toArr = [];

        foreach ($allCompanyUsers as $key => $u) {
            array_push($toArr, $u->email);
        }

        Mail::to($toArr)->send(new AppMail($msgdata));
    }



}
