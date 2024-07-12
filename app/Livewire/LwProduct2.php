<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

use App\Models\CNotice;
use App\Models\Counter;
use App\Models\Fnote;
use App\Models\Malzeme;
use App\Models\Urun;
use App\Models\NoteCategory;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class LwProduct2 extends Component
{
    use WithPagination;


    public function render()
    {


        return view('products.product-view');
    }








}
