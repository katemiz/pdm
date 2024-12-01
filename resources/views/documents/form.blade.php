<section class="container mx-auto p-4">

    <livewire:header
        type="Hero"
        title="{{ $this->form->uid ? config('conf_documents.formEdit.title') : config('conf_documents.formCreate.title') }}"
        subtitle="{{ $this->form->uid ? config('conf_documents.formEdit.subtitle') : config('conf_documents.formCreate.subtitle') }}"
        />

    <form wire:submit="{{ $this->form->docNo ? 'update' : 'save' }}" action="post">

        @csrf

        @if ($this->form->docNo)
        @method('patch')
        @endif

        @if ($this->form->docNo)
        <h1 class="text-5xl font-light my-6">{{ $this->form->docNo }}</h1>
        @endif

        <x-radio label="Select Company" name="company_id" :options="$this->form->companies" :selected="$this->form->company_id"
            wire:model="form.company_id" />

        <x-radio label="Select Document Language" name="doc_type" :options="config('conf_documents.docTypes')" :selected="$this->form->doc_type"
            wire:model="form.doc_type" />

        <x-radio label="Select Document Type" name="language" :options="config('conf_documents.languages')" :selected="$this->form->language"
            wire:model="form.language" />

        <x-input-text wire:model="form.title" name="title" label="Document Title"
            placeholder="Enter document title ..." />

        <x-quill wire:model="form.synopsis" label="Document Synopsis" name="synopsis" :value="$this->form->synopsis" />

        @if ($this->form->docNo)
        <livewire:file-list :model="$this->form->document" collection="Doc" label="Files" is_editable="true"/>
        @endif

        <x-file-upload :files="$files" name="files" is_multiple="true" />

        <div class="flex justify-end my-4">

            <a href="{{ $this->form->docNo ? '/docs/'.$this->form->uid : '/docs' }}" class="text-white focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium text-sm px-5 py-2.5 me-2 mb-2 bg-red-700 hover:bg-red-800 p-2 rounded inline-flex items-center">
                Cancel
            </a>

            <button type="submit"
                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                {{ $this->form->docNo ? 'Update Document' : 'Add Document' }}
            </button>
        </div>

    </form>

</section>
