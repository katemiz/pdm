<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Company;

use Mail;
use App\Mail\AppMail;



class UserForm extends Form
{
    public ?User $user;

    // RECORD ID
    public $uid;

    // NAME and LASTNAME
    #[Validate('required', message: 'Please add user name')]
    #[Validate('min:2', message: 'Name is too short. At least 2 characters')]
    public String $name = '';

    #[Validate('required', message: 'Please add user lastname')]
    #[Validate('min:3', message: 'Lastname is too short. At least 3 characters')]
    public String $lastname = '';

    // EMAIL
    #[Validate('required|email', message: 'Please add user email')]
    public String $email = '';


    // COMPANY
    #[Validate('required', message: 'Please select user company')]
    public Int $company_id;
    public $company;
    public $companies = [];


    // NOTES
    public $notes;


    // STATUS
    public $status;
    public $statusArr = [
        'active' => 'Active',
        'inactive' => 'Inactive'
    ];


    // FILES
    public $files = [];


    public function setRelatedProps() {

        foreach (Company::all() as $c) {
            $this->companies[$c->id] = $c->name;
        }

        $this->company_id =  Auth::user()->company_id;
        $this->company =  Company::find($this->company_id);

        $this->status = 'active';
    }



    public function setUser(Int $id)
    {
        $this->uid = $id;
        $this->user = User::find($id);
        $this->name = $this->user->name;
        $this->lastname = $this->user->lastname;
        $this->email = $this->user->email ? $this->user->email:'';
        $this->password = $this->user->password;
        $this->status = $this->user->status;
        $this->notes = $this->user->notes;
    }

    public function store()
    {
        $this->validate();

        $props['user_id'] = Auth::id();
        $props['name'] = $this->name;
        $props['lastname'] = $this->lastname;
        $props['email'] = $this->email;
        $props['password'] = $this->preparePassword();
        $props['company_id'] = $this->company_id;
        $props['notes'] = $this->notes;

        $id = User::create($props)->id;

        session()->flash('msg',[
            'type' => 'success',
            'text' => 'User has been created successfully.'
        ]);

        return $id;
    }


    public function update($id)
    {
        $this->validate();

        $props['user_id'] = Auth::id();
        $props['name'] = $this->name;
        $props['lastname'] = $this->lastname;
        $props['email'] = $this->email;
        $props['company_id'] = $this->company_id;
        $props['notes'] = $this->notes;
        $props['status'] = $this->status;

        $user = User::findOrFail($id);

        $user->update($props);

        session()->flash('msg',[
            'type' => 'success',
            'text' => 'User has been updated successfully.'
        ]);

        return true;
    }


    public function preparePassword() {

        $new_password = Str::password(6);
        return Hash::make($new_password);
    }
}