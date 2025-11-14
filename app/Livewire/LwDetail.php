<?php

namespace App\Livewire;

use App\Models\Attachment;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

use App\Models\CNotice;
use App\Models\Counter;
use App\Models\Fnote;
use App\Models\Malzeme;
use App\Models\Item;
use App\Models\Sfamily;
use App\Models\NoteCategory;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Mail;
use App\Mail\AppMail;

use Carbon\Carbon;



class LwDetail extends Component
{
    public $part_type = 'Detail';

    public $page_view_title = 'Detail Parts';
    public $page_view_subtitle = 'Detail Part Properties';

    public $list_all_url = '/parts/list';
    public $item_edit_url;
    public $item_view_url = '/details/Detail/view';

    public $has_material = true;
    public $has_bom = false;
    public $has_notes = true;
    public $has_flag_notes = true;
    public $has_vendor = false;

    public $action = 'LIST'; // LIST,FORM,VIEW

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $uid = false;

    public $canUserAdd = true;
    public $canUserEdit = true;
    public $canUserDelete = true;

    public $part_number;
    public $config_number;

    public $makefrom_part_id;
    public $makefrom_part_item;

    public $has_mirror = false;
    public $is_mirror_of = false;

    public $mirror_part_number =  false;
    public $mirror_part_version =  false;
    public $mirror_part_description =  false;

    public $is_mirror_of_part_number =  false;
    public $is_mirror_of_part_version =  false;
    public $is_mirror_of_part_description =  false;


    public $constants;

    public $mat_family = false;
    public $mat_form = false;

    public $material_definition;
    public $family;
    public $form;

    public $is_latest;

    public $sfamilies;
    public $standard_family;
    public $standard_number;
    public $standard_family_id;
    public $std_params;

    public $materials = [];
    public $ncategories = [];
    public $notes_id_array = [];

    // Item Props
    #[Validate('required|numeric', message: 'Please select material')]
    public $malzeme_id;

    #[Validate('required', message: 'Please write part name/title')]
    public $description;

    #[Validate('required|numeric', message: 'Please select ECN')]
    public $c_notice_id;

    public $isItemEditable = false;
    public $isItemDeleteable = false;

    public $version;
    public $status;
    public $unit = 'mm';

    public $weight;

    public $created_by;
    public $updated_by;
    public $checked_by;
    public $approvedBy;

    public $created_at;
    public $updated_at;
    public $req_reviewed_at;
    public $eng_reviewed_at;

    public $fno     = [];
    public $fnotes  = [];
    public $notes = [];

    public $all_revs = [];

    public $remarks;

    public $togglePartSelect = false;

    public $release_errors = false;
    public $parts_list = false;

    public $release_integrity_ok = false;


    public $approved_by;

    public $check_reviewed_at;
    public $app_reviewed_at;

    public $parents = [];

    public $configurationsCount = 3;
    public $configurations = [
       [ 'config_number' =>'','description' => '' ],
       [ 'config_number' =>'','description' => '' ],
       [ 'config_number' =>'','description' => '' ],
    ];

    public $availableConfigurations;

    public $multiplePartsHaveSameMaterial = true;
    public $base_part = false;

    public function mount()
    {
        if (!request('part_type')) {
            dd('no part_type defined');
        }

        $this->part_type = request('part_type');
        $this->item_edit_url = '/details/'.$this->part_type.'/form';

        if (request('id')) {

            $this->uid = request('id');
            $this->getProps();

            foreach (Fnote::where('item_id',$this->uid)->get() as $r) {
                $this->fnotes[] = ['no' => $r->no,'text_tr' => $r->text_tr,'text_en' => $r->text_en];
            }
        }

        $this->action = strtoupper(request('action'));

        $this->constants = config('product');
        $this->ncategories = NoteCategory::orderBy('text_tr')->get();
    }

    #[Title('Products')]
    #[On('refreshAttachments')]
    public function render()
    {
        $ecns = CNotice::where('status','wip')->get();
        $items = false;

        if ( $this->part_type == 'Standard') {
            $this->getStandardFamilies();
        }


        if ( $this->action === 'LIST') {

            $this->sortDirection = $this->constants['list']['headers'][$this->sortField]['direction'];

            $items = Item::where('part_number', 'LIKE', "%".$this->query."%")
                        ->orWhere('description', 'LIKE', "%".$this->query."%")
                        ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));

            foreach ($items as $key => $item) {
                $items[$key]['isItemEditable'] = false;
                $items[$key]['isItemDeleteable'] = false;

                if ($item->status == 'wip') {
                    $items[$key]['isItemEditable'] = true;
                    $items[$key]['isItemDeleteable'] = true;
                }
            }
        }

        return view('products.details.details',[
            'items' => $items,
            'ecns' => $ecns,
            'nodes' => $this->getNodes()
        ]);
    }




    public function getStandardFamilies()  {
        $this->sfamilies = Sfamily::orderBy('standard_number','ASC')->get();
    }



    public function getMaterialList() {

        if ($this->mat_family && $this->mat_form) {
            $this->materials = Malzeme::where('family', $this->mat_family)
            ->where('form', $this->mat_form)
            ->orderBy($this->sortField,'asc')->get();
        }
    }



    public function getNodes() {

        if ($this->part_type == 'MakeFrom') {

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

        } else {
            return false;
        }
    }


    public function getProps() {

        $item = Item::find($this->uid);

        $this->malzeme_id = $item->malzeme_id;
        $this->part_type = $item->part_type;

        switch ($item->part_type) {

            case 'MakeFrom':
                $item_view_url = '/details/MakeFrom/view';
                break;

            case 'Buyable':
                $item_view_url = '/details/Buyable/view';
                break;

            case 'Standard':
                $item_view_url = '/details/Standard/view';
                break;

            case 'Detail':
            case 'MultipleConfigured':
                $item_view_url = '/details/Detail/view';
                break;

            case 'Assy':
                $item_view_url = '/products-assy/view';
                break;
        }

        if ($item->status == 'WIP') {
            $this->isItemEditable = true;
            $this->isItemDeleteable = true;
        }

        $this->part_number = $item->part_number;
        $this->config_number = $item->config_number > 0 ? $item->config_number:false;
        $this->version = $item->version;
        $this->weight = $item->weight;
        $this->unit = $item->unit;

        $malzeme =  Malzeme::find($item->malzeme_id);

        if ( in_array($this->part_type,['MakeFrom','Standard']) ) {

            if ($this->part_type == 'MakeFrom') {
                $this->material_definition = 'See Source Part Material';
            }

            if ($this->part_type == 'Standard') {
                $this->material_definition = 'See Standard Documentation';
            }

        } elseif ($malzeme) {

            $this->material_definition = $malzeme->material_definition;

            $this->family = $malzeme->family;
            $this->form = $malzeme->form;

            $this->mat_family = $malzeme->family;
            $this->mat_form = $malzeme->form;
        }


        if ($item->hasConfigurations) {

            $this->availableConfigurations = Item::where('basePartId', $this->uid)->get();
            $this->configurations = [];

            foreach (Item::where('basePartId', $this->uid)->get() as $confPart) {
                $this->configurations[] = ['config_number' => $confPart->config_number, 'description' => $confPart->description,'id' => $confPart->id];
            }
        }

        if ($item->basePartId) {
            $this->base_part = Item::find($item->basePartId);
        }

        $this->getMaterialList();

        $this->standard_family_id = $item->standard_family_id;
        $this->standard_number = $item->standard_number;
        $this->description = $item->description;
        $this->c_notice_id = $item->c_notice_id;
        $this->remarks = $item->remarks;

        $this->status = $item->status;

        $this->is_latest = $item->is_latest;

        $this->makefrom_part_id = $item->makefrom_part_id;


        if ($this->part_type == 'MakeFrom' && $item->makefrom_part_id) {
            $this->makefrom_part_item = Item::find($item->makefrom_part_id);
        }

        $this->std_params = $item->std_params;

        $this->created_by = User::find($item->user_id);
        $this->created_at = $item->created_at;
        $this->updated_by = User::find($item->updated_uid);
        $this->updated_at = $item->updated_at;
        $this->checked_by = User::find($item->checker_id);
        $this->approved_by = User::find($item->approver_id);

        $this->check_reviewed_at = $item->check_reviewed_at;
        $this->app_reviewed_at = $item->app_reviewed_at;

        $this->has_mirror = $item->has_mirror > 0 ? $item->has_mirror : false;
        $this->is_mirror_of = $item->is_mirror_of > 0 ? $item->is_mirror_of : false;

        if ($item->has_mirror > 0) {
            $mirror_part = Item::find($item->has_mirror);

            $this->mirror_part_number =  $mirror_part->part_number;
            $this->mirror_part_version =  $mirror_part->version;
            $this->mirror_part_description =  $mirror_part->description;
        }


        if ($item->is_mirror_of > 0) {
            $is_mirror_of_part = Item::find($item->is_mirror_of);

            $this->is_mirror_of_part_number =  $is_mirror_of_part->part_number;
            $this->is_mirror_of_part_version =  $is_mirror_of_part->version;
            $this->is_mirror_of_part_description =  $is_mirror_of_part->description;
        }

        $this->notes_id_array = [];

        $this->notes = $item->pnotes;

        foreach ($item->pnotes as $note) {
            array_push($this->notes_id_array,$note->id);
        }

        $this->standard_family = Sfamily::find($this->standard_family_id);

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


    public function resetFilter() {
        $this->query = '';
    }

    public function viewItem($idItem) {
        $this->uid = $idItem;
        $this->action = 'VIEW';
        $this->getProps();
    }


    public function storeItem()
    {
        if ($this->part_type == 'MakeFrom') {
            $this->malzeme_id = 0 ;
        }

        //$this->validate();

        $this->standard_family = Sfamily::find($this->standard_family_id);

        switch ($this->part_type) {

            case 'Detail':
            case 'MakeFrom':

                $props = $this->validate([
                    'c_notice_id' => 'required',
                    'description' => 'required|min:6',
                    'malzeme_id' => 'required'
                ]);

                $props['part_type']  = $this->part_type;
                $props['user_id']  = Auth::id();
                $props['updated_uid']  = Auth::id();
                $props['weight']  = $this->weight;
                $props['remarks']  = $this->remarks;

                $props['part_number']  = $this->getProductNo();
                $props['makefrom_part_id']  = $this->makefrom_part_id;
                $props['c_notice_id']  = $this->c_notice_id;
                $props['unit']  = $this->unit;

                break;

            case 'Standard':

                $props = $this->validate([
                    'standard_family_id' => 'required',
                    'std_params' => 'required'
                ]);

                $props['part_type']  = $this->part_type;
                $props['user_id']  = Auth::id();
                $props['updated_uid']  = Auth::id();
                $props['weight']  = $this->weight;
                $props['remarks']  = $this->remarks;

                $props['standard_family_id']  = $this->standard_family_id;
                $props['standard_number']  = $this->standard_family->standard_number;
                $props['part_number']  = 0;
                $props['description'] = $this->standard_family->description;

                break;

            case 'MultipleConfigured':

                $props = $this->validate([
                    'c_notice_id' => 'required',
                    'description' => 'required|min:6'
                ]);

                if ($this->multiplePartsHaveSameMaterial) {

                    $props = $this->validate([
                        'c_notice_id' => 'required',
                        'description' => 'required|min:6',
                        'malzeme_id' => 'required'
                    ]);

                } else {
                    $props = $this->validate([
                        'c_notice_id' => 'required',
                        'description' => 'required|min:6',
                        'malzeme_id' => 'required'
                    ]);
                }

                $props['part_type']  = $this->part_type;
                $props['user_id']  = Auth::id();
                $props['updated_uid']  = Auth::id();
                $props['remarks']  = $this->remarks;

                $props['part_number']  = $this->getProductNo();
                $props['makefrom_part_id']  = $this->makefrom_part_id;
                $props['c_notice_id']  = $this->c_notice_id;
                $props['unit']  = $this->unit;

                $configurationsArray = [];

                //dd($this->configurations);

                foreach ($this->configurations as $key => $value) { 

                    if (!empty($value)) {

                        if ($this->configurationsTitle[$key]) {
                            $cTitle = $this->configurationsTitle[$key];
                        } else {
                            $cTitle =$this->description. ': '.$value;
                        }
                        
                        $configurationsArray[] = [ $value, $cTitle ];
                    }
                }

                break;
        }

        try {

            if ($this->part_type == 'MultipleConfigured') {

                $props['hasConfigurations'] = true; 
                $props['basePartId'] = false; 
            }

            $item = Item::create($props);
            $this->uid = $item->id;

            session()->flash('success',$this->part_type.' Part has been created successfully!');

            // Attach Notes to Product
            $item->pnotes()->attach($this->notes_id_array);

            // Flag Notes (Special Notes)
            foreach ($this->fnotes as $fnote) {

                $props['item_id'] = $this->uid;
                $props['no'] = $fnote['no'];
                $props['text_tr'] = $fnote['text_tr'];

                Fnote::create($props);
            }

            $this->dispatch('triggerAttachment', modelId: $this->uid);
            $this->action = 'VIEW';


            // When Part is MultipleConfigured
            // *****************************************

            if ($this->part_type == 'MultipleConfigured') {

                if (count($configurationsArray) > 0) {

                    foreach ($configurationsArray as $confNoTitle) {

                        $configuredProps = $props;

                        $configuredProps['description'] = $confNoTitle[1];
                        $configuredProps['config_number'] = $confNoTitle[0];
                        $configuredProps['hasConfigurations'] = false; 
                        $configuredProps['basePartId'] = $item->id; 
                        $configuredProps['part_type'] = 'Detail'; 

                        try {
                            $sonuc = Item::create($configuredProps);

                        } catch (\Exception $e) {
                            dd($e->getMessage());
                        }
                    }
                }
            }

            // **************************
            $this->getProps();

        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!'.$ex);
        }
    }



    public function updateItem()
    {
        if ($this->part_type == 'MakeFrom') {
            $this->malzeme_id = 0 ;
        }

        $this->standard_family = Sfamily::find($this->standard_family_id);

        switch ($this->part_type) {

            case 'Detail':
            case 'MakeFrom':
            case 'MultipleConfigured': // Just like Detail

                $props = $this->validate([
                    'c_notice_id' => 'required',
                    'description' => 'required|min:6',
                    'malzeme_id' => 'required'
                ]);

                $props['updated_uid']  = Auth::id();
                $props['makefrom_part_id']  = $this->makefrom_part_id;
                $props['weight']  = $this->weight;
                $props['unit']  = $this->unit;
                $props['remarks']  = $this->remarks;

                break;

            case 'Standard':

                $props = $this->validate([
                    'standard_family_id' => 'required',
                    'std_params' => 'required'
                ]);

                $props['standard_family_id']  = $this->standard_family_id;
                $props['part_type']  = $this->part_type;
                $props['updated_uid']  = Auth::id();
                $props['standard_number']  = $this->standard_family->standard_number;
                $props['weight']  = $this->weight;
                $props['remarks']  = $this->remarks;
                $props['user_id']  = Auth::id();

                $props['description'] = $this->standard_family->description;

                break;
        }

        try {

            //dd($this->part_type);

            $aaa = Item::find($this->uid);

            $aaa->update($props);

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

            session()->flash('message','Product has been updated successfully!');

            $this->dispatch('triggerAttachment',
                modelId: $this->uid
            );

            $this->action = 'VIEW';

            // When Part is MultipleConfigured
            // *****************************************

            if ($this->part_type == 'MultipleConfigured') {

                if (count($this->configurations) > 0) {

                    //dd($this->configurations);

                    $basePartProps = $props; 

                    foreach ($this->configurations as $configuration) {

                        if ( !empty($configuration['id'])) {

                            // Update Existing Configuration Part
                            $configuredPart = Item::find($configuration['id']);
                            $configuredPart->update([
                                'description' => $configuration['description'],
                                'config_number' => $configuration['config_number'],
                            ]);

                            continue;

                        } else {

                           

                            // Create New Configuration 
                            $configuredProps =$basePartProps;

                            $configuredProps['description'] = $configuration['description'];
                            $configuredProps['config_number'] = $configuration['config_number'];
                            $configuredProps['hasConfigurations'] = false; 
                            $configuredProps['basePartId'] = $item->id; 
                            $configuredProps['part_type'] = 'Detail'; 

                            if ( !Item::create($configuredProps) ) {
                                dd('Error Creating New Configuration Part', $configuredProps);
                             dd('Creating New Configuration Part', $configuredProps);
                            }

                            // try {
                            //     $sonuc = Item::create($configuredProps);

                            //                                 dd($configuration);

                            // } catch (\Exception $e) {
                            //     dd($e->getMessage());
                            // }
                        }
                    }
                }
            }

            $this->getProps();

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


    public function integrityCheck() {
        return true;
    }




    public function addSourcePart($makefrom_part_id,$full_part_number) {

        $this->makefrom_part_id = $makefrom_part_id;
        $this->makefrom_part_item = Item::find($makefrom_part_id);
    }





    public function addSNote() {
        $this->fnotes[] = [];
    }










    public function deleteSNote($key) {
        unset($this->fnotes[$key]);
    }


    public function releaseStart() {

        dd('Release Start');

        if ($this->integrityCheck()) {
            $this->js("console.log('m10true')");
            $this->dispatch('show-select-approvers',
                modelId: $this->uid
            );

        } else {
            $this->js("showModal('m10')");
            $this->js("console.log('m10false')");
        }
    }



    public function releaseConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'part_release');
    }


    #[On('onReleaseConfirmed')]
    public function doRelease() {

        $this->release_errors = false;

        $this->checkDetailIntegrity($this->uid);

        if ( !$this->release_errors ) {

            $this->releaseDetail($this->uid);

            $this->action = 'VIEW';

            session()->flash('message','Part has been released and email has been sent to PDM users successfully.');

            $this->getProps();

            // Send EMails
            $this->sendReleaseMail();
        }
    }

    public function checkIntegrity($id) {
       $this->checkDetailIntegrity($id);
    }


    public function checkDetailIntegrity($id) {

        $d = Item::find($id);

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

        if (!$this->release_errors) {
            $this->release_integrity_ok = true;
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



    public function sendReleaseMail() {

        $msgdata['blade'] = 'emails.dataset_released';  // Blade file to be used
        $msgdata['subject'] = 'Teknik Veri Yayınlanma Bildirimi / Dataset Release Notification';
        $msgdata['url'] = url('/').'/Detail/view/'.$this->uid;
        $msgdata['url_title'] = 'Ürün Verisi Bağlantısı / Dataset Link';

        $msgdata['part_number'] = $this->part_number;
        $msgdata['description'] = $this->description;
        $msgdata['version'] = $this->version;
        $msgdata['remarks'] = $this->remarks;

        $msgdata['parts_list'] = $this->parts_list;


        //$this->company_id =  Auth::user()->company_id;


        $allCompanyUsers = User::where('company_id',Auth::user()->company_id)->get();

        $toArr = [];

        foreach ($allCompanyUsers as $key => $u) {
            array_push($toArr, $u->email);
        }

        Mail::to($toArr)->send(new AppMail($msgdata));
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

        $this->getProps();

        // This refreshes new item attachments
        $this->dispatch('triggerAttachment',modelId: $this->uid);
    }






    public function freezeConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'freeze');
    }


    #[On('onFreezeConfirmed')]
    public function doFreeze() {
        Item::find($this->uid)->update(['status' =>'Frozen']);
        $this->action = 'VIEW';
        $this->getProps();
    }




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

        // If this DELETED part is mirror of somepart, update base pat props
        if ( $current_item->is_mirror_of > 0 ) {

            $org_part_props['has_mirror']  = null;
            $org_part_props['updated_uid']  = Auth::id();

            Item::whereId($current_item->is_mirror_of)->update($org_part_props);

            $current_item->delete();

            session()->flash('message','Only mirror part has been deleted successfully!');

            redirect('/details/Detail/view/'.$current_item->is_mirror_of);
            return true;
        }

        $current_item->delete();

        // If part has mirror part also, delete mirror part as well
        if ($current_item->has_mirror > 0 ) {

            Item::whereId($current_item->is_mirror_of)->delete();
            session()->flash('info','Item and its mirror part have been deleted successfully!');

        } else{
            session()->flash('info','Item has been deleted successfully!');
        }

        redirect('/parts/list');
    }






    public function mirrorConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'mirror');
    }





    #[On('onMirrorConfirmed')]
    public function makeMirror() {

        $current_item = Item::find($this->uid);

        // Create New Mirror Part

        $mpart_props['description']  = 'Mirror Part of '.$current_item->part_number.'-'.$current_item->version;
        $mpart_props['part_type']  = $current_item->part_type;
        $mpart_props['user_id']  = Auth::id();
        $mpart_props['updated_uid']  = Auth::id();
        $mpart_props['weight']  = $current_item->weight;
        $mpart_props['remarks']  = $current_item->remarks;
        $mpart_props['malzeme_id']  = $current_item->malzeme_id;

        $mpart_props['part_number']  = $this->getProductNo();
        $mpart_props['makefrom_part_id']  = $current_item->makefrom_part_id;
        $mpart_props['c_notice_id']  = $current_item->c_notice_id;
        $mpart_props['unit']  = $current_item->unit;

        $mpart_props['is_mirror_of']  = $this->uid;

        $mpart = Item::create($mpart_props);

        // Add Mirror Parameters to the Original Part
        $org_part_props['has_mirror']  = $mpart->id;
        $org_part_props['updated_uid']  = Auth::id();

        Item::whereId($this->uid)->update($org_part_props);

        session()->flash('message','Mirror part has been created successfully!');

        redirect('/details/Detail/view/'.$mpart->id);
    }






    public function replicateConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'replicate');
    }


    #[On('onReplicateConfirmed')]
    public function makeReplicate() {

        $base_part = Item::find($this->uid);

        $new_part = $base_part->replicate();

        $new_part->part_number  = $this->getProductNo();
        $new_part->user_id  = Auth::id();
        $new_part->updated_uid  = Auth::id();
        $new_part->created_at = Carbon::now();

        $new_part->has_mirror = null;


        $new_part->save();


        // FLAG NOTES

       $available_fnotes = [];

        foreach (Fnote::where('item_id',$this->uid)->get() as $r) {
            $available_fnotes[] = ['no' => $r->no,'text_tr' => $r->text_tr,'text_en' => $r->text_en];
        }


        foreach ($available_fnotes as $fnote) {

            $props['item_id'] = $new_part->id;
            $props['no'] = $fnote['no'];
            $props['text_tr'] = $fnote['text_tr'];

            Fnote::create($props);
        }

        // PART NOTES
        $part_notes =[];

        foreach ($base_part->pnotes as $note) {
            array_push($part_notes,$note->id);
        }

        $new_part->pnotes()->attach(array_unique($part_notes));


        session()->flash('message','A new part has been created successfully!');

        redirect('/details/Detail/form/'.$new_part->id);
    }



    public function addConfiguration()
    {
        $this->configurations[$this->configurationsCount] =['config_number' =>'','description' => '' , 'id' => ''];
        $this->configurationsCount++;
    }



    public function removeConfiguration($key)
    {
        unset($this->configurations[$key]);
    }



}
