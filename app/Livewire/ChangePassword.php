<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ChangePassword extends Component
{

    #[Rule('required', message: 'Please enter your current passord')]
    public $current_password;

    #[Rule('required|min:6', message: 'Your new password should be at least 6 characters long')]
    public $new_password1;

    #[Rule('required|same:new_password1', message: 'Your new passwords do not match')]
    public $new_password2;


    public function render()
    {
        return view('profile.change-password');
    }



    public function passwordChange() {

        $this->validate();

        $current_user = Auth::user();

        if( !Hash::check($this->current_password, $current_user->password) ) {
            $this->addError('current_password', 'your current password not correct');
        }

        User::find($current_user->id)->update(['password' => Hash::make($this->new_password1)]);

        session()->flash('message','Password has been updated successfully.');

        $this->reset();
    }
}
