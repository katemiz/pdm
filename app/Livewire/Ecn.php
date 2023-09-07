<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

use App\Models\CRequest;
use App\Models\CNotice;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Ecn extends Component
{

    use WithPagination;

    public $model = 'CR';
    public $tag = false;
    public $action = 'LIST'; // LIST,FORM,VIEW

    public $itemId = false;
    public $item = false;

    public $isAdd = false;
    public $isEdit = false;
    public $isList = true;
    public $isView = false;

    public $canAdd = true;
    public $canEdit = true;
    public $canDelete = true;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection;

    public $constants;

    // Item Props
    public $c_notice_id;
    public $pre_description;
    public $is_for_ecn = 0;
    public $createdBy;
    public $created_at;


    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->itemId = request('id');
        }
        $this->constants = config('ecns');
    }

    #[Title('ECN - Engineering Change Notice')]
    #[On('refreshAttachments')]
    public function render()
    {
        return view('ECN.ecn');
    }
}
