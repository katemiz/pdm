<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\Attributes\Rule;


use App\Models\Page;

class LwPage extends Component
{

    public $pid = false;

    #[Rule('required', message: 'Page title needed')]

    public $title;
    public $content;

    public $action = 'FORM';


    public function mount($pid)
    {

        $this->pid = $pid;

    }



    public function render()
    {
        $this->getPageProps();

        return view('documents.documentor-page');
    }


    public function getPageProps()  {

        if ($this->pid) {
            $p = Page::find($this->pid);

            $this->title = $p->title;
            $this->content = $p->content;
        }


    }





    public function storeUpdateItem () {

        $this->validate();

        $props['document_id'] = 100;
        $props['title'] = $this->title;
        $props['content'] = $this->content;

        if ( $this->pid ) {
            // update
            //$props['updated_pid'] = Auth::id();
            Page::find($this->pid)->update($props);
            session()->flash('message','End Product / Sellable Item has been updated successfully.');

        } else {
            // create
            //$props['user_id'] = Auth::id();
            //$props['updated_pid'] = Auth::id();
            $this->pid = Page::create($props)->id;
            session()->flash('message','End Product / Sellable Item has been created successfully.');
        }

        // ATTACHMENTS, TRIGGER ATTACHMENT COMPONENT
        $this->dispatch('triggerAttachment',modelId: $this->pid);
        $this->action = 'VIEW';
    }











}
