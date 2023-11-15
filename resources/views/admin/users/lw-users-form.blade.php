
<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Users</h1>
    <h2 class="subtitle has-text-weight-light">{{ $uid ? 'Update User Attributes' : 'Add New User' }}</h2>
</header>

<form method="POST" enctype="multipart/form-data">
    @csrf

    <div class="field">
        <label class="label">User Company</label>
        <div class="control">
            <div class="select">
            <select wire:model='company_id' wire:change='getProjects'>
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

        <label class="label">Name</label>
        <div class="control">

            <input
                class="input"
                wire:model="name"
                type="text"
                placeholder="Enter Name of User" required>
        </div>

        @error('name')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">

        <label class="label">Lastname</label>
        <div class="control">

            <input
                class="input"
                wire:model="lastname"
                type="text"
                placeholder="Enter Lastname of User" required>
        </div>

        @error('lastname')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">

        <label class="label">E-Mail</label>
        <div class="control">

            <input
                class="input"
                wire:model="email"
                type="text"
                placeholder="Enter user e-mail" required>
        </div>

        @error('email')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>




    <div class="field ">


        <div class="field-body">

            <div class="field">
                <label class="label">User Projects</label>

                <div class="control">

                    @if ( count($allprojects) > 0)

                        @foreach ($allprojects as $project)
                            <label class="checkbox is-block">
                                <input type="checkbox" wire:model="user_projects" value="{{$project->id}}"> {{ $project->code }}
                            </label>
                        @endforeach

                    @else
                        <p>No projects</p>
                    @endif

                </div>
            </div>


            <div class="field">
                <label class="label">User Roles</label>

                <div class="control">

                    @if ( count($allroles) > 0)

                        @foreach ($allroles as $role)
                            <label class="checkbox is-block">
                                <input type="checkbox" wire:model="user_roles" value="{{$role->id}}"> {{ $role->name }}
                            </label>
                        @endforeach

                    @else
                        <p>{{ config('roles.list.noitem') }}</p>
                    @endif

                </div>
            </div>

            <div class="field">
                <label class="label">User Permissions</label>

                <div class="control">

                    @if ( count($permissions) > 0)

                        @foreach ($permissions as $perm)
                            <label class="checkbox is-block">
                                <input type="checkbox" wire:model='user_permissions' value="{{$perm->id}}" > {{ $perm->name }}
                            </label>
                        @endforeach

                    @else
                        <p>{{ config('permissions.list.noitem') }}</p>
                    @endif

                </div>
            </div>

        </div>
    </div>











    <div class="buttons is-right">
        <button wire:click.prevent="storeUpdateUser()" class="button is-dark">
            @if ($user)
                {{ config('users.update.submitText') }}
            @else
                {{ config('users.create.submitText') }}
            @endif
        </button>
    </div>

</form>

