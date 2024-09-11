<section class="container mx-auto p-4 bg-yellow-100">

    <livewire:header type="Page" title="Documents" subtitle="{{ $this->form->docNo ? 'Update Existing Document Parameters' : 'Create a New Document' }}" />

    <form wire:submit="{{ $this->form->docNo ? 'update' : 'save' }}">


        @if ($this->form->docNo)
        <h1 class="text-5xl font-light my-6">{{ $this->form->docNo }}</h1>
        @endif

        <x-radio label="Select Company" name="company_id" :options="$this->form->companies" :selected="$this->form->company_id"
            wire:model="form.company_id" />

        <x-radio label="Select Document Language" name="doc_type" :options="$this->form->doc_types" :selected="$this->form->doc_type"
            wire:model="form.doc_type" />

        <x-radio label="Select Document Type" name="language" :options="$this->form->languages" :selected="$this->form->language"
            wire:model="form.language" />

        <x-input-text wire:model="form.title" name="title" label="Document Title"
            placeholder="Enter document title ..." />

        <x-quill wire:model="form.synopsis" label="Document Synopsis" name="synopsis" :value="$this->form->synopsis" />

        <x-quill wire:model="form.synopsis2" label="Document Synopsis" name="synopsis2" :value="$this->form->synopsis2" />

        <livewire:file-upload model_name="Document" multiple="{{true}}" />

        <div class="text-right">
            <button type="submit"
                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                {{ $this->form->docNo ? 'Update Document' : 'Add Document' }}
            </button>
        </div>

    </form>







    {{-- @foreach ($errors->getMessages() as $error)
    {{ print_r($error) }}<br/>
    @endforeach --}}

</section>
