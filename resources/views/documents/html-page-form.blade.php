<h2 class="subtitle has-text-weight-light has-text-info">{{ $pid ? 'Edit Page' : 'Add New Page' }}</h2>

<form method="POST" enctype="multipart/form-data">
    @csrf

    <div class="field">
        <label class="label">Page Title</label>
        <div class="control">
            <input class="input" type="text" wire:model='ptitle' placeholder="Document title/description ...">
        </div>

        @error('title')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>


    <livewire:ck-editor
        wire:model="pcontent"
        label='Page Content'
        placeholder='page content ....'
        :content="$remarks"/>

    @error('pcontent')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
    @enderror

    <div class="buttons is-right">
        <button wire:click.prevent="storeUpdatePage({{ $parent_node_id ? $parent_node_id : 0 }},{{ $pid ? $pid : 0 }})" class="button is-dark">
            {{ $pid ? 'Update Page' : 'Add Page'}}
        </button>
    </div>




</form>




