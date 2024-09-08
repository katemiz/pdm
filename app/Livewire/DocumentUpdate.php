<?php

namespace App\Livewire;

use App\Livewire\Forms\PostForm;
use Livewire\Component;
use App\Models\Post;

class DocumentUpdate extends Component
{
    public PostForm $form;

    public function mount(Post $post)
    {
        $this->form->setPost($post);
    }

    public function save()
    {

        $this->form->update();

        return $this->redirect('/posts');
    }

    public function render()
    {
        dd('fff');

        return view('livewire.create-document');
    }
}
