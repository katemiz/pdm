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
    #[Validate('required', message: 'Please select status')]
    public $status;

    // FILES
    public $files = [];


    public function setRelatedProps() {

        foreach (Company::all() as $c) {
            $this->companies[$c->id] = $c->name;
        }

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
        $this->company_id = $this->user->company_id;
        $this->status = $this->user->status;
        $this->notes = $this->user->notes;
        $this->company =  Company::find($this->company_id);
    }

    public function store()
    {
        $this->validate();

        $props['user_id'] = Auth::id();
        $props['updated_uid'] = Auth::id();
        $props['name'] = $this->name;
        $props['lastname'] = $this->lastname;
        $props['email'] = $this->email;
        $props['password'] = $this->preparePassword()->hashed;
        $props['company_id'] = $this->company_id;
        $props['notes'] = $this->notes;

        $id = User::create($props)->id;

        // INFORM USER WITH E-MAIL
        $this->informUserWithMail($id,$this->preparePassword()->plain);

        session()->flash('msg',[
            'type' => 'success',
            'text' => 'User has been created and and information mail sent successfully.'
        ]);

        return $id;
    }


    public function update($id)
    {
        $this->validate();

        $props['updated_uid'] = Auth::id();
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

        $password = Str::password(6);

        $passwd = [
            'plain' => $password,
            'hashed' => Hash::make($password)
        ];

        return (object) $passwd;
    }


    public function informUserWithMail($id,$passwdPlain)
    {
        $newUser = User::findOrFail($id);

        $msgData = [
            'blade' => 'emails.user_created',                                       // Blade Mail Template
            'from_name' => env('MAIL_FROM_NAME'),                                   // PDM Mail Sender
            'title' => 'New User Created / Yeni Kullanıcı Hesabı',                  // Mail Title
            'subject' => 'PDM Account Created / PDM Hesabınız Oluşturulmuştur',     // Mail Subject
            'email' => $newUser->email,                                             // User's Mail
            'name' => $newUser->name,                                               // User's Name
            'lastname' => strtoupper($newUser->lastname),                           // User's Lastname
            'password' => $passwdPlain,                                             // User's password [readable]
            'body' => 'Your account has been created with the following password.',
            'signature' => env('MAIL_SIGNATURE'),                                   // PDM Signature
            'action_title' => 'Go to App / Giriş',                                  // Clickable link title
            'action_url' => url('/')                                                // Clickable link
        ];

        Mail::to($msgData['email'])->send(new AppMail($msgData));
        //Mail::to('katemiz@masttech.com')->send(new AppMail($msgData));
    }

}