<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

use App\Livewire\FileList;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Attachment;
use App\Models\Counter;
use App\Models\Company;
use App\Models\Document;
use App\Models\User;

use Mail;
use App\Mail\AppMail;


class DocumentView extends Component
{
    public $id;
    public $document;

    public function render()
    {
        if (request('id')) {
            $this->id = request('id');

            $this->document = Document::find(request('id'));
        } else {

            dd('Ooops ...');
            return false;
        }

        return view('documents.docs-view');
    }

}
