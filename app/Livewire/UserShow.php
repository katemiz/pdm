<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Auth;

use App\Models\Company;
use App\Models\User;


use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserShow extends Component
{
    public $uid;
    public $user;
    public $moreMenu = [];
    public $permissions;
    public $modelTitle;

    public $company;

    public function mount() {

        $this->modelTitle = config('conf_users.modelTitle');

        if (request('id')) {
            $this->uid = request('id');
        } else {

            dd('Ooops ...');
            return false;
        }
    }


    public function render()
    {
        $this->user = User::findOrFail($this->uid );
        $this->company =  Company::find($this->user->company_id)->name;

        $this->setPermissions();

        return view('admin.users.show');
    }


    public function edit() {
        $redirect = Str::replace('{id}',$this->uid,config('conf_users.form_edit.route'));
        return $this->redirect($redirect);
    }


    public function add() {
        return $this->redirect(config('conf_users.form_create.route'));
    }


    public function setPermissions() {

        $this->permissions = (object) [
            "show" => true,
            "edit" => false,
            "delete" => false,
            "freeze" => false,
            "release" => false,
            "revise" => false
        ];

        // SHOW/READ
        $this->permissions->show = true;

        // EDIT
        if ( in_array($this->user->status,['Active','Inactive']) ) {
            $this->permissions->edit = true;
        }
    }
}
