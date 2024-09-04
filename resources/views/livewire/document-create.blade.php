<section class="container mx-auto p-4 bg-yellow-100">

    <livewire:header type="Page" title="Documents" subtitle="Create a New Document"/>

    <form wire:submit="save">

        <x-radio 
            label="Select Company"
            name="company_id" 
            :options="$this->form->companies" 
            :selected="$this->form->company_id" 
            wire:model="form.company_id" 
        />

        <x-radio 
            label="Select Document Type"
            name="doc_type" 
            :options="$this->form->doc_types" 
            :selected="$this->form->doc_type" 
            wire:model="form.doc_type" 
        />          

        <x-input-text
            wire:model="form.title"
            name="title"
            label="Document Title"
            placeholder="placeholder"
        /> 
    

        <x-quill
            wire:model="form.synopsis" 
            label="Document Synopsis"
            name="synopsis" 
            :value="$this->form->synopsis" 
        />

    
        <div class="text-right">
            <button type="submit" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Add Document</button>
        </div>


        <p>synopsis = {{$form->synopsis}}
    </form>




</section>