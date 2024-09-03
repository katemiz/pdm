<section class="container mx-auto p-4 bg-yellow-100">


    <livewire:header type="Page" title="Documents" subtitle="Create a New Document"/>




    <form wire:submit="save">

        <x-radio name="company_id" wire:model="form.company_id" options="{{ $options }}"/> 

        
        <x-input-text name="title" wire:model="form.title" /> 
    
        <x-input-text name="content" wire:model="form.content" /> 
    
        <button type="submit">Save</button>
    </form>

</section>