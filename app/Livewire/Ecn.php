<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

use App\Models\CRequest;
use App\Models\CNotice;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Ecn extends Component
{

    use WithPagination;

    public $model = 'CR';
    public $tag = false;
    public $action = 'LIST'; // LIST,FORM,VIEW

    public $itemId = false;
    public $item = false;

    public $isAdd = false;
    public $isEdit = false;
    public $isList = true;
    public $isView = false;

    public $canAdd = true;
    public $canEdit = true;
    public $canDelete = true;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection;

    public $constants;

    // Item Props
    public $c_notice_id;
    public $pre_description;
    public $createdBy;
    public $status;
    public $created_at;
    public $updated_at;


    public $isForNewProduct = false; // Is this ECN for NEW or for CHANGE


    protected $rules = [
        'pre_description' => 'required|min:10'
    ];


    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->itemId = request('id');
        }
        $this->constants = config('ecn');
    }

    #[Title('ECN - Engineering Change Notice')]
    #[On('refreshAttachments')]
    public function render()
    {
        $items = false;

        if ( $this->action === 'VIEW') {
            $this->setUnsetProps();
        }

        if ( $this->action === 'FORM' && $this->itemId) {
            $this->setUnsetProps();
        }

        if ( $this->action === 'LIST') {

            $this->sortDirection = $this->constants['list']['headers'][$this->sortField]['direction'];

            $items = CNotice::where('pre_description', 'LIKE', "%".$this->search."%")
            ->orWhere('c_notice_id', 'LIKE', "%".$this->search."%")
            // ->orWhere('rej_reason_req', 'LIKE', "%".$this->search."%")
            // ->orWhere('rej_reason_eng', 'LIKE', "%".$this->search."%")
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));

            foreach ($items as $key => $item) {
                $items[$key]['canEdit'] = false;
                $items[$key]['canDelete'] = false;

                if ($item->status == 'wip') {
                    $items[$key]['canEdit'] = true;
                    $items[$key]['canDelete'] = true;
                }
            }
        }

        return view('ECN.ecn',[
            'items' => $items
        ]);
    }



    public function setUnsetProps($opt = 'set') {

        if ($opt === 'set') {
            $this->item = CNotice::find($this->itemId);

            $this->createdBy = User::find($this->item->user_id);
            $this->engBy = User::find($this->item->eng_app_id);

            $this->c_notice_id = $this->item->c_notice_id;
            $this->pre_description = $this->item->pre_description;
            $this->status = $this->item->status;

            $this->created_at = $this->item->created_at;
            $this->updated_at = $this->item->updated_at;



            $cr = CRequest::find($this->item->c_notice_id);

            if ($cr->is_for_ecn) {
                $this->isForNewProduct = true;
            }

        } else {
            $this->topic = '';
            $this->description = '';
            $this->is_for_ecn = false;
            $this->rejectReason = false;
            $this->status = false;
        }
    }


    public function viewItem($idItem) {
        $this->itemId = $idItem;
        $this->action = 'VIEW';
    }




    public function updateItem()
    {
        $this->validate();

        try {
            CNotice::whereId($this->itemId)->update([
                'pre_description' => $this->pre_description,
            ]);
            session()->flash('message','ECN has been updated successfully!');

            $this->dispatch('triggerAttachment',
                modelId: $this->itemId
            );

            $this->action = 'VIEW';

        } catch (\Exception $ex) {
            session()->flash('success','Something goes wrong!!');
        }
    }


    public function closeECN($idECN) {

        $this->itemId = $idECN;

        CNotice::whereId($this->itemId)->update([
            'status' => 'complete',
        ]);


        $this->action = 'VIEW';

        session()->flash('message','ECN has been completed and closed successfully!');

    }





}
