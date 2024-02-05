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

class LwMom extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW

    public $uid = false;

    public $show_my_moms;

    public $limit_by_company = true;
    public $limit_by_project = false;
    public $limit_by_user = false;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $mom_start_date;
    public $mom_end_date;
    public $place;
    public $subject;
    public $minutes;




    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));

            if ( in_array($this->action,['LIST','FORM','VIEW']) ) {
                $this->is_html = false;
            }

            if ( in_array($this->action,['CFORM','CVIEW','PFORM','PVIEW']) ) {
                $this->is_html = true;
            }
        }

        if (request('id')) {

            if ( in_array($this->action,['LIST','FORM','VIEW','CFORM','CVIEW']) ) {
                $this->uid = request('id');
            }

            if ( in_array($this->action,['PFORM','PVIEW']) ) {
                $this->pid = request('id');
            }
        }

        $this->constants = config('documents');

        $this->setCompanyProps();

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







}
