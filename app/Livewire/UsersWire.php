<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;





class UsersWire extends Component
{
    use WithPagination;

    public $isAdd = false;
    public $isEdit = false;
    public $isList = true;
    public $isView = false;
    public $isRelease = false;

    public $title;
    public $subtitle;

    public $search = '';
    public $sortField = 'lastname';
    public $sortDirection = 'asc';



    public function render()
    {

        $this->initialize();

        $users = [];

        if (request('idUser')) {
            $this->viewUser(request('idUser'));
        } else {

            $users = User::where('name', 'LIKE', "%$this->search%")
            ->orWhere('lastname', 'LIKE', "%$this->search%")
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }


        return view('admin.users.usr-list',[
            'users' => $users
        ]);
    }


    public function initialize()
    {

        $this->title = config('users.list.title');
        $this->subtitle = config('users.list.subtitle');
    }


}
