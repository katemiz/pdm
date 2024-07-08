<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Attachment;
use App\Models\Counter;
use App\Models\Company;
use App\Models\Sfamily;
use App\Models\User;

class LwStandardFamily extends Component
{

    use WithPagination;

    public $uid = false;
    public $action = 'LIST'; // LIST,FORM,VIEW

    public $constants;

    public $query = '';
    public $sortField = 'standard_number';
    public $sortDirection = 'ASC';

    //#[Validate('required|unique:standard_families' , message: 'Attention, this standard family already exists!')]
    public $standard_number;

    //#[Validate('required', message: 'Please add description of standard!')]
    public $description;
    public $remarks;

    public $status;

    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;

    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->uid = request('id');
            $this->getProps();
        }

        $this->constants = config('stdfamilies');
    }


    public function render()
    {
        $this->getProps();

        return view('products.standard.families',[
            'sfamilies' => $this->getFamiliesList()
        ]);
    }


    public function getFamiliesList()  {


        if (strlen($this->query) > 2){

            return Sfamily::where('status', 'Active')->where(function($query) {
                $query->where('description', 'LIKE', "%".$this->query."%")->orWhere('standard_number','LIKE',"%".$this->query."%")->orWhere('remarks','LIKE',"%".$this->query."%");
            })
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));

        } else {

            return Sfamily::where('status', 'Active')
                    ->orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));
        } 

        // return  Sfamily::where('status', 'Active')
        
        //     ->when( strlen($this->query) > 2, function ($query) {
        //         $query->where('description', 'LIKE', "%".$this->query."%")
        //         ->orWhere('standard_number','LIKE',"%".$this->query."%")
        //         ->orWhere('remarks','LIKE',"%".$this->query."%");

        //     })
            
        //     ->orderBy($this->sortField,$this->sortDirection)
        //     ->paginate(env('RESULTS_PER_PAGE'));
    }












    public function getProps() {

        if ($this->uid && in_array($this->action,['VIEW','FORM']) ) {

            $s = Sfamily::find($this->uid);

            $this->standard_number = $s->standard_number;
            $this->description = $s->description;
            $this->remarks = $s->remarks;
            $this->status = $s->status;
            $this->created_at = $s->created_at;
            $this->updated_at = $s->updated_at;
            $this->created_by = User::find($s->user_id)->email;
            $this->updated_by = User::find($s->updated_uid)->email;
        }
    }


    public function viewItem($uid) {
        $this->action = 'VIEW';
        $this->uid = $uid;
    }


    public function editItem($uid) {
        $this->action = 'FORM';
        $this->uid = $uid;
    }


    public function storeUpdateItem () {

        if ( $this->uid ) {
            // update
            $props = $this->validate([
                'standard_number' => 'required',
                'description' => 'required|min:6',
            ]);

            $props['updated_uid'] = Auth::id();
            $props['remarks'] = $this->remarks;

            Sfamily::find($this->uid)->update($props);
            session()->flash('message','Standard family has been updated successfully.');

        } else {
            // create
            $props = $this->validate([
                'standard_number' => 'required|unique:standard_families',
                'description' => 'required|min:6',
            ]);

            $props['updated_uid'] = Auth::id();
            $props['remarks'] = $this->remarks;

            $props['user_id'] = Auth::id();
            $this->uid = Sfamily::create($props)->id;
            session()->flash('message','Standard family has been created successfully.');
        }

        // ATTACHMENTS, TRIGGER ATTACHMENT COMPONENT
        $this->dispatch('triggerAttachment',modelId: $this->uid);

        $this->action = 'VIEW';
    }

    public function resetFilter() {
        $this->query = '';
    }

}
