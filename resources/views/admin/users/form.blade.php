<section class="container mx-auto p-4">

    <livewire:header 
    type="Hero" 
    title="{{ $this->form->uid ? config('conf_users.form_edit.title') : config('conf_users.form_add.title') }}" 
    subtitle="{{ $this->form->uid ? config('conf_users.form_edit.subtitle') : config('conf_users.form_add.subtitle') }}"
    />


    <form wire:submit="{{ $this->form->uid ? 'update' : 'save' }}" action="post">

        @csrf

        @if ($this->form->uid)
        @method('patch')
        @endif

        <x-radio label="Select Company" name="company_id" :options="$this->form->companies" 
            wire:model="form.company_id" />

        <x-input-text wire:model="form.name" name="name" label="User Name"
            placeholder="Enter user name ..." />

        <x-input-text wire:model="form.lastname" name="lastname" label="User Lastname"
            placeholder="Enter User Lastname ..." />

        <x-input-text wire:model="form.email" name="email" label="User E-Mail"
            placeholder="Enter user e-mail ..." />

        <x-quill wire:model="form.notes" label="Notes" name="notes" :value="$this->form->notes" />

        <x-radio label="Status" name="status" :options="config('conf_users.statusArr')" :selected="$this->form->status"
            wire:model="form.status" />

        @if ($this->form->uid)
        <livewire:file-list :model="$this->form->user" collection="User" label="Files" is_editable="true"/>
        @endif

        <x-file-upload :files="$files" name="files" is_multiple="true" />

        <div class="flex justify-end my-4">

            <a href="{{ $this->form->uid ? '/usrs/'.$this->form->uid : '/usrs' }}" class="text-white focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium text-sm px-5 py-2.5 me-2 mb-2 bg-red-700 hover:bg-red-800 p-2 rounded inline-flex items-center">
                Cancel
            </a>

            <button type="submit"
                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                {{ $this->form->uid ? 'Update User' : 'Add User' }}
            </button>
        </div>

    </form>







    {{-- @foreach ($errors->getMessages() as $error)
    {{ print_r($error) }}<br/>
    @endforeach --}}

</section>
