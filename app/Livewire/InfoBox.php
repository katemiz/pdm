<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

use App\Models\User;






class InfoBox extends Component
{
    public $modelname;
    public $id;

    public $author;
    public $modifier;
    public $status;
    public $created_at;
    public $modified_at;

    public $checker = false;
    public $approver = false;
    public $check_reviewed_at = false;
    public $app_reviewed_at = false;


    public function mount(String $modelname, Int $id) {

        $model_full_path = '\\App\\Models\\'.$modelname;
        $model = new $model_full_path;

        $item = $model->find($id);


        $this->author = User::find($item->user_id);
        $this->modifier = User::find($item->updated_uid);

        $this->created_at = $item->created_at;
        $this->modified_at = $item->updated_at;

        $this->status = $item->status;

        if ($item->checker_id !='') {
            $this->checker_id = $item->checker_id;
        }

        if ($item->check_reviewed_at != '') {
            $this->check_reviewed_at = $item->check_reviewed_at;
        }

        if ($item->approver_id !='') {
            $this->approver_id = $item->approver_id;
        }

        if ($item->app_reviewed_at !='') {
            $this->app_reviewed_at = $item->app_reviewed_at;
        }
    }


    public function render()
    {
        return view('livewire.info-box');
    }







}
