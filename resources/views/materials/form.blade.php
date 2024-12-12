<section class="container mx-auto p-4">

    <livewire:header
        type="Hero"
        title="{{ $this->form->uid ? $conf['formEdit']['title'] : $conf['formCreate']['title'] }}"
        subtitle="{{ $this->form->uid ? $conf['formEdit']['subtitle'] : $conf['formCreate']['subtitle'] }}"
    />

    <form wire:submit="{{ $this->form->uid ? 'update' : 'save' }}" action="post">

        @csrf

        @if ($this->form->uid)
        @method('patch')
        @endif

        @if ($this->form->uid)
        <h1 class="text-5xl font-light my-6">{{ $this->form->uid }}</h1>
        @endif

        <div class="grid grid-cols-3 grid-rows-1 gap-4">
            <div >
                <livewire:select
                    label="Material Family"
                    name="family"
                    :options="$conf['families']"
                    :selected="$this->form->family"
                    wire:model="form.family"
                />
            </div>
            <div >
                <x-input-text
                    wire:model="form.description"
                    name="title"
                    label="Material Description/Name"
                    placeholder="Enter material name/description ..."
                />
            </div>
            <div >
                <x-input-text
                    wire:model="form.specification"
                    name="title"
                    label="Material Specification"
                    placeholder="Enter material specification ..."
                />
            </div>
        </div>


        <x-quill
            wire:model="form.remarks"
            label="Remarks/Notes"
            name="remarks"
            :value="$this->form->remarks"
        />

        @if ($this->form->uid)
        <livewire:file-list :model="$this->form->document" collection="Material" label="Files" is_editable="true"/>
        @endif

        <x-file-upload :files="$files" name="files" is_multiple="true" />

        <div class="flex justify-end my-4">

            <a href="{{ $this->form->uid ? '/materials/'.$this->form->uid : '/materials' }}" class="text-white focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium text-sm px-5 py-2.5 me-2 mb-2 bg-red-700 hover:bg-red-800 p-2 rounded inline-flex items-center">
                Cancel
            </a>

            <button type="submit"
                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                {{ $this->form->uid ? 'Update Material' : 'Add Material' }}
            </button>
        </div>

@if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif

    </form>

</section>
