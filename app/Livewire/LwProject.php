<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Company;
use App\Models\Gate;
use App\Models\Moc;
use App\Models\Phase;
use App\Models\Poc;
use App\Models\Project;
use App\Models\User;
use App\Models\Witness;



class LwProject extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW
    public $constants;

    public $companies;

    public $uid = false;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $logged_user;

    #[Rule('required', message: 'Please select company')]
    public $company_id;

    #[Rule('required', message: 'Please enter project short code')]
    public $code;

    #[Rule('required', message: 'Please enter project full title')]
    public $title;

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

        $this->constants = config('projects');
    }


    public function render()
    {
        $this->logged_user = $this->checkUserRoles(Auth::user());
        $this->getCompaniesList();

        return view('admin.projects.lw-projects',[
            'projects' => $this->getProjectsList(),
            'populate_defaults' => $this->getPopulateDefaults()
        ]);
    }


    public function getProjectsList()  {

        if ($this->logged_user->is_admin) {

            $projects = Project::where('code', 'LIKE', "%".$this->query."%")
            ->orWhere('title','LIKE',"%".$this->query."%")
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));

        } elseif ($this->logged_user->is_company_admin) {

            $projects = Project::where([
                ['company_id', '=', $this->logged_user->company_id],
                ['code', 'LIKE', "%".$this->query."%"],
            ])
            ->orwhere([
                ['company_id', '=', $this->logged_user->company_id],
                ['title', 'LIKE', "%".$this->query."%"],
            ])
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));

        } else {

            $usr_prj_ids = [];

            foreach ($this->logged_user->projects as $prj) {
                array_push($usr_prj_ids,$prj->id);
            }

            $projects = Project::whereIn('id',$usr_prj_ids)->paginate(env('RESULTS_PER_PAGE'));
        }

        return $projects;
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

    public function resetFilter() {
        $this->query = '';
    }

    public function viewItem($uid) {
        $this->uid = $uid;
        $this->action = 'VIEW';

        $this->setProps();
    }

    public function editItem($uid) {
        $this->uid = $uid;
        $this->action = 'FORM';

        $this->setProps();
    }

    public function addItem() {
        $this->uid = false;
        $this->action = 'FORM';

        $this->reset('code','title');
    }

    public function populate($uid) {
        $this->uid = $uid;
        $this->action = 'POPULATE';
    }


    public function getPopulateDefaults() {

        if ($this->action != 'POPULATE') {
            return false;
        }

        // PHASES
        $predefinedPhases = Phase::where([
            ['company_id',1],
            ['project_id',1],
        ])
        ->orderBy('code','asc')
        ->get();

        // MILESTONES
        $predefinedMilestones = Gate::where([
            ['company_id',1],
            ['project_id',1],
        ])
        ->orderBy('code','asc')
        ->get();

        // MOCS
        $predefinedMocs = Moc::where([
            ['company_id',1],
            ['project_id',1],
        ])
        ->orderBy('code','asc')
        ->get();

        // POCS

        $predefinedPocs = Poc::where([
            ['company_id',1],
            ['project_id',1],
        ])
        ->orderBy('code','asc')
        ->get();

        return [
            'phases' => $predefinedPhases,
            'milestones' => $predefinedMilestones,
            'mocs' => $predefinedMocs,
            'pocs' => $predefinedPocs
        ];
    }





    public function doPopulate($uid) {

        $currentProject = Project::find($uid);

        $props['user_id'] = Auth::id();
        $props['updated_uid'] = Auth::id();
        $props['company_id'] = $currentProject->company->id;
        $props['project_id'] = $uid;
        $props['endproduct_id'] = 0;

        $definitions = $this->getPopulateDefaults();

        // PHASES
        foreach ($definitions['phases'] as $phase) {
            $props['code'] = $phase->code;
            $props['name'] = $phase->name;
            $props['description'] = $phase->description;
            Phase::create($props);
        }

        // MILESTONES
        foreach ($definitions['milestones'] as $milestone) {
            $props['code'] = $milestone->code;
            $props['name'] = $milestone->name;
            $props['purpose'] = $milestone->purpose;
            $props['timing'] = $milestone->timing;
            Gate::create($props);
        }

        // MOC
        foreach ($definitions['mocs'] as $moc) {
            $props['code'] = $moc->code;
            $props['name'] = $moc->name;
            $props['description'] = $moc->description;
            Moc::create($props);
        }

        // POC
        foreach ($definitions['pocs'] as $poc) {
            $props['code'] = $poc->code;
            $props['name'] = $poc->name;
            $props['description'] = $poc->description;
            Poc::create($props);
        }

        // WITNESS . ADD OWN COMPANY TO WITNESS LIST
        $cmp = Company::find($currentProject->company->id);

        $props['code'] = $cmp->name;
        $props['name'] = $cmp->fullname;
        $props['description'] = '';

        Witness::create($props);

        $this->uid = $uid;

        session()->flash('message','Predefined definitions have been added to project.');
        $this->action = 'VIEW';
    }


    public function setProps() {

        $c = Project::find($this->uid);

        $this->code = $c->code;
        $this->company_id = $c->company_id;
        $this->title = $c->title;
        $this->created_at = $c->created_at;
        $this->updated_at = $c->updated_at;
        $this->created_by = $c->user_id;
        $this->updated_by = $c->updated_uid;
        $this->created_by = User::find($c->user_id)->fullname;
        $this->updated_by = User::find($c->updated_uid)->fullname;
    }


    public function triggerDelete($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmDelete');
    }


    #[On('onDeleteConfirmed')]
    public function deleteRole()
    {
        Project::find($this->uid)->delete();
        session()->flash('message','Project has been deleted successfully.');
        $this->action = 'LIST';
        $this->resetPage();
    }


    public function storeUpdateItem () {

        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['company_id'] = $this->company_id;
        $props['code'] = $this->code;
        $props['title'] = $this->title;

        if ( $this->uid ) {
            // update
            Project::find($this->uid)->update($props);
            session()->flash('message','Project has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $c = Project::create($props);
            $this->uid = $c->id;

            session()->flash('message','Project has been created successfully.');
        }

        $this->action = 'VIEW';
    }




    public function checkUserRoles($usr) {

        $usr->is_admin = false;
        $usr->is_company_admin = false;

        if ($usr->hasRole('admin')) {
            $usr->is_admin = true;
        }

        if ($usr->hasRole('company_admin')) {
            $usr->is_company_admin = true;
        }

        return $usr;
    }



    public function getCompaniesList() {

        if ($this->logged_user->is_admin) {
            $this->companies = Company::all();
        }

        if ($this->logged_user->is_company_admin) {
            $this->companies = Company::where('id',$this->logged_user->company_id)->get();
            $this->company_id = $this->logged_user->company_id;
        }
    }










}
