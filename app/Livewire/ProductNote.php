<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

use App\Models\NoteCategory;
use App\Models\Pnote;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProductNote extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW

    public $itemId = false;
    public $item = false;

    public $canAdd = true;
    public $canEdit = true;

    public $search = '';
    public $sortField = 'text_tr';
    public $sortDirection = 'ASC';

    public $categories;
    public $constants;

    // Item Props
    public $category_id;
    public $category_tr;
    public $category_en;
    public $text_tr;
    public $text_en;
    public $remarks;
    public $status="A";
    public $created_at;
    public $createdBy;


    protected $rules = [
        'category_id' => 'required',
        'text_tr' => 'required',
        'text_en' => 'required',
    ];


    public function mount()
    {
        if (request('id')) {
            $this->itemId = request('id');
        }

        $this->action = strtoupper(request('action'));
        $this->constants = config('notes');
        $this->categories = NoteCategory::all();
    }

    #[Title('Product Notes')]
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

            if (strlen($this->search) > 0) {

                $items = Pnote::where('text_tr', 'LIKE', "%".$this->search."%")
                ->orWhere('text_en', 'LIKE', "%".$this->search."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));

            } else {
                $items = Pnote::orderBy($this->sortField,$this->sortDirection)->paginate(env('RESULTS_PER_PAGE'));
            }
        }

        return view('Notes.notes',[
            'items' => $items,
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
            $this->item = Pnote::find($this->itemId);

            $this->item->canEdit = true;

            $this->category_id = $this->item->note_category_id;
            $this->category_tr = $this->item->noteCategory->text_tr;
            $this->category_en = $this->item->noteCategory->text_en;
            $this->text_tr = $this->item->text_tr;
            $this->text_en = $this->item->text_en;
            $this->remarks = $this->item->remarks;
            $this->status = $this->item->status;
            $this->created_at = $this->item->created_at;
            $this->createdBy = User::find($this->item->user_id);


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









    public function storeItem()
    {
        $this->validate();
        try {
            $this->item = Pnote::create([
                'user_id' => Auth::id(),
                'text_tr' => $this->text_tr,
                'text_en' => $this->text_en,
                'note_category_id' => $this->category_id,
                'remarks' => $this->remarks,
            ]);
            session()->flash('success','Material has been created successfully!');

            $this->itemId = $this->item->id;

            $this->dispatch('triggerAttachment',
                modelId: $this->itemId
            );

            $this->action = 'VIEW';

        } catch (\Exception $ex) {
            session()->flash('error','Something goes wrong!!'.$ex);
        }
    }




    public function updateItem()
    {

        $this->validate();

        try {

            $this->item = Pnote::whereId($this->itemId)->update([
                'user_id' => Auth::id(),
                'note_category_id' => $this->category_id,
                'text_tr' => $this->text_tr,
                'text_en' => $this->text_en,
                'remarks' => $this->remarks,
                'status' => $this->status,
            ]);


            session()->flash('message','Product Note has been updated successfully!');

            $this->dispatch('triggerAttachment',
                modelId: $this->itemId
            );

            $this->action = 'VIEW';

        } catch (\Exception $ex) {
            session()->flash('success','Something goes wrong!!');
        }
    }












}
