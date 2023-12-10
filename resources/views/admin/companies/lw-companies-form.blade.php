<script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Companies</h1>
    <h2 class="subtitle has-text-weight-light">{{ $cid ? 'Edit Company Attributes' : 'Add New Company' }}</h2>
</header>

<form method="POST" enctype="multipart/form-data">
    @csrf

    <div class="field">

        <label class="label">Company Name (Short)</label>
        <div class="control">

            <input
                class="input"
                wire:model="name"
                type="text"
                placeholder="Enter company short name ..." required>
        </div>

        @error('name')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">

        <label class="label">Company Fullname</label>
        <div class="control">

            <input
                class="input"
                wire:model="fullname"
                type="text"
                placeholder="Enter company fullname ..." required>
        </div>

        @error('fullname')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <livewire:ck-editor
        wire:model="remarks"
        label='Notes and Remarks'
        placeholder='Any kind of remarks/notes about part/product.'
        :content="$remarks"/>

    @error('remarks')
    <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
    @enderror

    <div class="buttons is-right">
        <button wire:click.prevent="storeUpdateItem()" class="button is-dark">
            {{ $cid ? 'Update Company' : 'Add Company' }}
        </button>
    </div>

</form>

