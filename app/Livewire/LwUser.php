<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Mail;
use App\Mail\AppMail;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class LwUser extends Component
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
    public $user;

    #[Rule('required', message: 'Please select company')]
    public $company_id;

    #[Rule('required|min:2')]
    public $name;

    #[Rule('required|min:2')]
    public $lastname;

    #[Rule('required|email', onUpdate: false)]
    public $email;

    public $allroles;
    public $allprojects = [];
    public $permissions;

    public $user_roles = [];
    public $user_permissions = [];
    public $user_projects = [];


    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->uid = request('id');
        }

        $this->constants = config('users');

        $this->allroles = Role::all();
        $this->permissions = Permission::all();
    }


    public function render()
    {
        $this->logged_user = $this->checkUserRoles(Auth::user());

        $this->getCompaniesList();
        $this->getProjects();

        $this->setProps();

        return view('admin.users.lw-users',[
            'users' => $this->getUsersList()
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




    public function getUsersList() {

        if ($this->action != 'LIST') {
            return false;
        }

        if ($this->logged_user->is_admin) {

            $users = User::where([
                ['lastname', 'LIKE', "%".$this->query."%"],
            ])
            ->orwhere([
                ['name', 'LIKE', "%".$this->query."%"],
            ])
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }

        if ($this->logged_user->is_company_admin) {

            $users = User::where([
                ['company_id', '=', $this->logged_user->company_id],
                ['lastname', 'LIKE', "%".$this->query."%"],
            ])
            ->orwhere([
                ['company_id', '=', $this->logged_user->company_id],
                ['name', 'LIKE', "%".$this->query."%"],
            ])
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }

        return $users;
    }


    public function resetFilter() {
        $this->query = '';
    }


    public function viewItem($uid) {
        $this->uid = $uid;
        $this->action = 'VIEW';

        $this->user = User::find($uid);
    }


    public function editItem($uid) {
        $this->uid = $uid;
        $this->action = 'FORM';

        $this->user = User::find($uid);
        $this->setProps();
    }

    public function addUser() {
        $this->uid = false;
        $this->action = 'FORM';
    }

    public function getProjects() {

        if ($this->company_id > 0) {
            $this->allprojects = Project::where('company_id',$this->company_id)->get();
        }
    }


    public function setProps() {

        if ($this->uid && in_array($this->action,['VIEW','FORM'])) {

            $this->user = User::find($this->uid);

            $this->name = $this->user->name;
            $this->lastname = $this->user->lastname;
            $this->email = $this->user->email;
            $this->company_id = $this->user->company_id;

            // User Roles
            foreach ($this->user->roles as $role) {
                array_push($this->user_roles,$role->id);
            }

            // User Permissions
            foreach ($this->user->permissions as $permission) {
                array_push($this->user_permissions,$permission->id);
            }

            // User Projects
            foreach ($this->user->projects as $project) {
                array_push($this->user_projects,$project->id);
            }
        }
    }



    public function storeUpdateUser () {

        $this->validate();

        $props['company_id'] = $this->company_id;
        $props['name'] = $this->name;
        $props['lastname'] = $this->lastname;
        $props['email'] = $this->email;

        if ( $this->uid ) {
            // update
            User::find($this->uid)->update($props);
            $user = User::find($this->uid);

        } else {
            // create
            $new_password = Str::password(6);
            $props['password'] = Hash::make($new_password);
            $user = User::create($props);
            $this->uid = $user->id;

            $msgdata = $props;
            $msgdata['password'] = $new_password;

            $this->mailUserCreated($msgdata);

            //dd($msgdata);
        }

        if ( count($this->user_roles) > 0) {
            $user->syncRoles($this->user_roles);
        }

        if ( count($this->user_permissions) > 0 ) {
            $user->syncPermissions($this->user_permissions);
        }

        $user->projects()->detach();
        $user->projects()->attach($this->user_projects);

        $this->action = 'VIEW';
    }











    public function mailUserCreated($msgdata)
    {
        $msgdata['blade'] = 'emails.user_created';  // Blade file to be used
        $msgdata['subject'] = 'Account Created / Hesabınız Oluşturulmuştur';
        $msgdata['action_url'] = url('/');
        $msgdata['action_title'] = 'Go to App / Giriş';


        // $msgdata = [
        //     'from_name' => env('MAIL_FROM_NAME'),
        //     'blade' => 'emails.user_created',
        //     'title' => 'New User Created / Yeni Kullanıcı Hesabı',
        //     'subject' => 'New User Created / Yeni Kullanıcı Hesabı',
        //     'greeting' => 'Dear '.$props['name'].' '.$props['lastname'],
        //     'salute' => 'Best Regards',
        //     'body' => 'Your account has been created with the following password.',
        //     'signature' => env('MAIL_SIGNATURE'),
        //     'password' => $props['password']
        // ];




        Mail::to($msgdata['email'])->send(new AppMail($msgdata));

        //dd("Email is sent successfully 2222.");
    }




    public function sendTestMail() {

        $msgdata['blade'] = 'emails.user_created';  // Blade file to be used
        $msgdata['subject'] = 'Test EMail';
        $msgdata['action_url'] = url('/');
        $msgdata['action_title'] = 'Go to App / Giriş';

        Mail::to('katemiz@masttech.com')->send(new AppMail($msgdata));
    }





}
