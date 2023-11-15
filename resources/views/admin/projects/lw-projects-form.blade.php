<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Projects</h1>
    <h2 class="subtitle has-text-weight-light">{{ $uid ? 'Edit Project Attributes' : 'Add Project Company' }}</h2>
</header>

<form method="POST" enctype="multipart/form-data">
    @csrf

    <div class="field">
        <label class="label">Company</label>
        <div class="control">
            <div class="select">
            <select wire:model='company_id'>
                <option>Select a company...</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
            </div>
        </div>

        @error('company_id')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>






    <div class="field">

        <label class="label">Project Code</label>
        <div class="control">

            <input
                class="input"
                wire:model="code"
                type="text"
                placeholder="Enter project code ... (eg RLS)" required>
        </div>

        @error('code')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>


    <div class="field">

        <label class="label">Project Title/Description</label>
        <div class="control">

            <input
                class="input"
                wire:model="title"
                type="text"
                placeholder="Enter Project Title/Description ..." required>
        </div>

        @error('title')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>


    <div class="buttons is-right">
        <button wire:click.prevent="storeUpdateItem()" class="button is-dark">
            @if ($uid)
                {{ $constants['update']['submitText'] }}
            @else
                {{ $constants['create']['submitText'] }}
            @endif
        </button>
    </div>

</form>

