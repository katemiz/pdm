<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

use App\Models\User;

class InfoBox extends Component
{
    public $model;
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

    public function mount($model) {

        $this->id = $model->id;

        $this->author = User::find($model->user_id);
        $this->modifier = User::find($model->updated_uid);

        $this->created_at = $model->created_at;
        $this->modified_at = $model->updated_at;

        $this->status = $model->status;

        if ($model->checker_id !='') {
            $this->checker = User::find($model->checker_id);
        }

        if ($model->check_reviewed_at != '') {
            $this->check_reviewed_at = $model->check_reviewed_at;
        }

        if ($model->approver_id !='') {
            $this->approver = User::find($model->approver_id);
        }

        if ($model->app_reviewed_at !='') {
            $this->app_reviewed_at = $model->app_reviewed_at;
        }
    }


    public function render()
    {
        return view('livewire.info-box');
    }
}
