<section class="section container">

    @if (session()->has('message'))
    <div class="notification is-info is-light">
        {{ session('message') }}
    </div>
    @endif

    <header class="my-6">
        <h1 class="title has-text-weight-light is-size-3">{{ __('Change Password') }}</h1>
        <h2 class="subtitle has-text-weight-light">{{ __("Ensure your account is using a long, random password to stay secure.") }}</h2>
    </header>


    <div class="field">
        <label class="label">Current Password</label>
        <div class="control">
            <input
                class="input"
                id="current_password"
                wire:model="current_password"
                type="password"
                placeholder="Enter your current password" required>
        </div>

        @error('current_password')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>



    <div class="field">
        <label class="label">New Password</label>
        <div class="control">
            <input
                class="input"
                id="new_password1"
                wire:model="new_password1"
                type="password"
                placeholder="Enter your new password" required>
        </div>

        @error('new_password1')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">
        <label class="label">New Password, Confirm</label>
        <div class="control">
            <input
                class="input"
                id="new_password2"
                wire:model="new_password2"
                type="password"
                placeholder="Enter your new password to confirm" required>
        </div>

        @error('new_password2')
        <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
        @enderror

    </div>


    <div class="buttons is-right">
        <button wire:click.prevent="passwordChange()" class="button is-dark">Change Password</button>
    </div>




    {{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif --}}

</section>