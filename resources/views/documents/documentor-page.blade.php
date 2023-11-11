<div>


    @switch($action)
        @case('VIEW')

        <p>view</p>
            
            @break
        @case('FORM')




            <div class="field">
                <label class="label">Page Title</label>
                <div class="control">
                    <input class="input" type="text" wire:model='title' placeholder="Document title/description ...">
                </div>
        
                @error('title')
                    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
                @enderror
        
            </div>
        
        
        
            <livewire:ck-editor
                edId="ed10"
                wire:model="content"
                label='Page Contents'
                placeholder='Write page content here'
                :content="$content"/>
        
            @error('remarks')
                <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        
        
            <div class="buttons is-right">
                <button wire:click.prevent="storeUpdateItem()" class="button is-dark">
                    @if ($pid)
                        Update
                    @else
                        Add Page
                    @endif
                </button>
            </div>
    
















            
            @break
            
    @endswitch







</div>
