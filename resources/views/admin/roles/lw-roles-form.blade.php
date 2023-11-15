<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Roles</h1>
    <h2 class="subtitle has-text-weight-light">{{ $rid ? 'Update Role Attributes' : 'Add New Role' }}</h2>
</header>

<form method="POST" enctype="multipart/form-data">
    @csrf

    <div class="field">

        <label class="label">Application Role Name</label>
        <div class="control">

            <input
                class="input"
                wire:model="name"
                type="text"
                placeholder="Enter Role Name ..." required>
        </div>

        @error('name')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>


    <div class="buttons is-right">
        <button wire:click.prevent="storeUpdateRole()" class="button is-dark">
            @if ($rid)
                {{ $constants['update']['submitText'] }}
            @else
                {{ $constants['create']['submitText'] }}
            @endif
        </button>
    </div>

</form>

