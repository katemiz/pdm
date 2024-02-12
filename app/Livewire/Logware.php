<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;

use Illuminate\Http\RedirectResponse;

class Logware extends Component
{

    /* Actions:
        login : Ususal login action,
        register : New user add,
        forgot: Password Renewal
        change: Password Change
        reset: Password Reset
        logout:
    */

    public $lang= 'EN';
    public $action = 'login';
    public $app_title = 'App Title';

    public $email = '';
    public $name = '';
    public $lastname = '';
    public $password = '';
    public $cpassword ='';


    public function render()
    {
        if (request('action')) {
            $this->action = request('action');
        }

        return view('admin.log-wire');
    }


    public function switchLang($lang)
    {
        App::setLocale($lang);
    }


    public function changeAction($opt)
    {
        $this->action = $opt;
    }


    public function loginUsr(Request $request)
    {
        $credentials = $this->validate([
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $is_user_active = true;

        if ( User::where('email',$this->email)->sole()->status == 'inactive') {
            $credentials['password'] = 'thisisnotactiveanymore';
            $is_user_active = false;
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        if ($is_user_active) {
            $this->addError('email', 'The provided credentials do not match our records.');
        } else {
            $this->addError('email', 'This account is not active');
        }
    }


    public function registerUsr(Request $request): RedirectResponse
    {

        $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'min:6'],
        ]);

        $user = User::create([
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);


        //event(new Registered($user));

        // Bu nasıl çalışıyor? Kişi kayıt olduktan sonra bir event başlatılıyor galiba : email göndermek için

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }


    public function resetPwd($opt)
    {
    }


    public function changePwd($opt)
    {
    }


    public function sendResetLink($opt)
    {
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}
