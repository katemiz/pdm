<section class="container mx-auto p-4 bg-yellow-100">


    <livewire:header type="Page" title="Documents" subtitle="Create a New Document"/>




    <form wire:submit="save">

        
        <x-input-text name="title" wire:model="title" /> 
    
        <x-input-text name="content" wire:model="content" /> 
    
        <button type="submit">Save</button>
    </form>

</section>