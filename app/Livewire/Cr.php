<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

use App\Models\CRequest;
use App\Models\Company;
use App\Models\CNotice;
use App\Models\Project;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Cr extends Component
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

    public $cr_approvers = [];
    public $cr_approver = false;

    // Item Props
    public $topic;
    public $description;
    public $is_for_ecn = 0;
    public $status;
    public $rejectReason;
    public $createdBy;
    public $engBy;

    public $created_at;
    public $req_reviewed_at;
    public $eng_reviewed_at;


    protected $rules = [
        'topic' => 'required|min:5',
        'description' => 'required|min:10'
    ];


    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->itemId = request('id');
        }
        $this->constants = config('crs');
    }



    public function updatedSearch () {
        $this->resetPage(); // Resets the page to 1
    }


    #[Title('Değişiklik Talebi - Change Request')]
    // #[On('refreshAttachments')]
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

            $items = CRequest::where('topic', 'LIKE', "%".$this->search."%")
                ->orWhere('description', 'LIKE', "%".$this->search."%")
                ->orWhere('rej_reason_req', 'LIKE', "%".$this->search."%")
                ->orWhere('rej_reason_eng', 'LIKE', "%".$this->search."%")
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

        return view('CR.cr',[
            'items' => $items
        ]);
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



    public function setUnsetProps($opt = 'set') {

        if ($opt === 'set') {
            $this->item = CRequest::find($this->itemId);

            $this->createdBy = User::find($this->item->user_id);
            $this->engBy = User::find($this->item->eng_app_id);

            $this->topic = $this->item->topic;
            $this->description = $this->item->description;
            $this->is_for_ecn = $this->item->is_for_ecn;
            $this->rejectReason = $this->item->rej_reason_eng;
            $this->status = $this->item->status;

            $this->created_at = $this->item->created_at;
            $this->req_reviewed_at = $this->item->req_reviewed_at;
            $this->eng_reviewed_at = $this->item->eng_reviewed_at;

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


    public function editItem($idItem)
    {
        $this->itemId = $idItem;
        $this->action = 'FORM';
    }

    public function addNew()
    {
        $this->itemId = false;
        $this->action = 'FORM';
    }


    public function acceptCR($idItem)
    {
        CRequest::whereId($this->itemId)->update([
            'status' => $this->topic,
            'eng_app_id' => Auth::id(),
            'status' => 'accepted'
        ]);

        $ecn = CNotice::create([
            'user_id' => Auth::id(),
            'c_notice_id' => $this->itemId,
            'pre_description' => 'ECN için yapılması gerekenlerin ayrıntılı bir şekilde açıklanması gerekmektedir.',
        ]);

        session()->flash('message','Change Request has been accepted and a new ECN has been created.');

        redirect('/ecn/view/'.$ecn->id);
    }


    public function rejectCR()
    {
        CRequest::whereId($this->itemId)->update([
            'status' => $this->topic,
            'eng_app_id' => Auth::id(),
            'rej_reason_eng' => $this->rejectReason,
            'status' => 'rejected'
        ]);
        session()->flash('message','Change Request has been rejected!');
        $this->action = 'VIEW';
    }




    public function startCRDelete($idItem)
    {
        $this->item = CRequest::find($idItem);
        $this->dispatch('ConfirmDelete', type:'cr');
    }


    #[On('deleteCR')]
    public function deleteCR()
    {
        $this->item->delete();
        session()->flash('message','Değişiklik Talebi başarıyla silinmiştir.');
        $this->action = 'LIST';
        $this->resetPage();
    }




    public function storeItem()
    {
        $this->validate();
        try {
            $this->item = CRequest::create([
                'topic' => $this->topic,
                'description' => $this->description,
                'is_for_ecn' => $this->is_for_ecn,
                'user_id' => Auth::id()
            ]);
            session()->flash('success','Change Request Created Successfully!');

            $this->itemId = $this->item->id;

            $this->dispatch('triggerAttachment',
                modelId: $this->itemId
            );

            $this->action = 'VIEW';

            //return redirect('/cr/view/'.$this->itemId);

        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!'.$ex);
        }
    }





    public function updateItem()
    {
        $this->validate();

        try {

            CRequest::whereId($this->itemId)->update([
                'topic' => $this->topic,
                'description' => $this->description,
                'is_for_ecn' => $this->is_for_ecn,
                'user_id' => Auth::id()
            ]);

            session()->flash('message','Change Request has been updated successfully!');

            $this->dispatch('triggerAttachment',
                modelId: $this->itemId
            );

            $this->action = 'VIEW';

            //return redirect('/cr/view/'.$this->itemId);


        } catch (\Exception $ex) {
            session()->flash('success','Something goes wrong!!');
        }
    }





    #[On('refreshAttachments')]
    public function deneme() {
        dd('dee');
    }



}
