<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

use App\Livewire\FileList;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Attachment;
use App\Models\Counter;
use App\Models\Company;
use App\Models\Mom;
use App\Models\User;

use Carbon\Carbon;

class LwMom extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW

    public $uid = false;
    public $company_id;
    public $project_id;

    public $show_my_moms;

    public $companies;
    public $company;

    public $limit_by_company = true;
    public $limit_by_project = false;
    public $limit_by_user = false;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $mom_date = [];
    public $mom_start_date;
    public $mom_end_date;
    public $mom_no;
    public $revision;
    public $is_latest;
    public $place;
    public $subject;
    public $minutes;
    public $remarks;
    public $status;

    public $meeting_type = 'GN';

    public $meeting_types = [
        'GN' => 'General'
    ];

    public $all_revs = [];


    public $mom_no_direction = 'asc';
    public $subject_direction = 'asc';
    public $updated_at_direction = 'desc';


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
            $this->setProps();
        }

        $this->setCompanyProps();

        $this->mom_start_date = Carbon::now()->format('Y-m-d');
    }




    public function render()
    {

        return view('mom.moms',[
            'moms' => $this->getMoms()
        ]);
    }


    public function getMoms() {

        return  Mom::when($this->limit_by_company, function ($query) {
                    $query->where('company_id', $this->limit_by_company);
                })
                ->when($this->show_my_moms, function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->when($this->query, function ($query) {
                    $query->orWhere('title', 'LIKE', "%".$this->query."%")
                        ->orWhere('remarks','LIKE',"%".$this->query."%")
                        ->orWhere('document_no','LIKE',"%".$this->query."%");
                })
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
    }


    public function setCompanyProps()
    {
        $this->companies = Company::all();
        $this->company_id =  Auth::user()->company_id;
        $this->company =  Company::find($this->company_id);
    }


    public function storeUpdateItem () {

        //$this->validate();

        $props['updated_uid'] = Auth::id();
        $props['company_id'] = $this->company_id;
        $props['project_id'] = $this->project_id;
        $props['mom_start_date'] = $this->mom_start_date;
        $props['mom_end_date'] = $this->mom_end_date;
        $props['place'] = $this->place;
        $props['subject'] = $this->subject;
        $props['meeting_type'] = $this->meeting_type;
        $props['minutes'] = $this->minutes;
        $props['remarks'] = $this->remarks;

        if ( $this->uid ) {
            // update
            Mom::find($this->uid)->update($props);
            session()->flash('message','MOM has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $props['mom_no'] = $this->getMomNo();
            $this->uid = Mom::create($props)->id;
            session()->flash('message','Document has been created successfully.');
        }

        // ATTACHMENTS, TRIGGER ATTACHMENT COMPONENT
        $this->dispatch('triggerAttachment',modelId: $this->uid);

        $this->action = 'VIEW';
        $this->setProps();

    }


    public function setProps() {

        if ($this->uid && in_array($this->action,['VIEW','FORM']) ) {

            $c = Mom::find($this->uid);

            $this->mom_no = $c->mom_no;
            $this->revision = $c->revision;
            $this->company_id = $c->company_id;
            $this->subject = $c->subject;
            $this->place = $c->place;
            $this->minutes = $c->minutes;
            $this->is_latest = $c->is_latest;
            $this->remarks = $c->remarks;
            $this->status = $c->status;
            $this->created_at = $c->created_at;
            $this->updated_at = $c->updated_at;
            $this->created_by = User::find($c->user_id)->email;
            $this->updated_by = User::find($c->updated_uid)->email;

            $this->mom_start_date = $c->mom_start_date;
            $this->mom_end_date = $c->mom_end_date;

            if ($c->mom_start_date) {
                $this->mom_date[] = $c->mom_start_date;
            }

            if ($c->mom_end_date) {
                $this->mom_date[] = $c->mom_end_date;
            }

            // Revisions
            foreach (Mom::where('mom_no',$this->mom_no)->get() as $mom) {
                $this->all_revs[$mom->revision] = $mom->id;
            }
        }
    }


    public function viewItem($uid) {
        $this->action = 'VIEW';
        $this->uid = $uid;

        $this->setProps();

    }











    #[On('onCalendarClicked')]
    public function getDates($meeting_dates) {

        $this->mom_start_date = null;
        $this->mom_end_date = null;

        if ($meeting_dates) {

            $start  = explode('-',$meeting_dates['0']);
            $this->mom_start_date = $start['2'].'-'.$start['1'].'-'.$start['0'];

            if (count($meeting_dates) > 1) {
                $end    = explode('-',$meeting_dates['1']);
                $this->mom_end_date = $end['2'].'-'.$end['1'].'-'.$end['0'];
            }

        } else {

            $this->mom_start_date = Carbon::now()->format('Y-m-d');
        }
    }



    public function getMomNo() {

        $parameter = 'mom_no';
        $initial_no = config('appconstants.counters.mom_no');
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

}
