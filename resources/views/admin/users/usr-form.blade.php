<x-pdm-layout>

    <script src="{{ asset('/ckeditor5/ckeditor.js') }}"></script>

    <div class="section container">

        @if ($user)


            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">{{ config('users.update.title') }}</h1>

                @if ( config('users.update.subtitle') )
                    <h2 class="subtitle has-text-weight-light">{{ config('users.update.subtitle') }}</h2>
                @endif
            </header>


        @else
            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">{{ config('users.create.title') }}</h1>

                @if ( config('users.create.subtitle') )
                    <h2 class="subtitle has-text-weight-light">{{ config('users.create.subtitle') }}</h2>
                @endif
            </header>
        @endif

        <form action="{{ config('users.cu_route') }}{{ $user ? $user->id : '' }}" method="POST" enctype="multipart/form-data">
        @csrf


        @if ($user)
        <div class="title">
            {{ $user->number }}-{{ sprintf('%02d', $user->version) }}
        </div>
        @endif

        <div class="field">

            <label class="label" for="name">Name</label>
        
            <div class="control has-icons-right">
        
                <input
                    class="input"
                    name="name"
                    id="name"
                    type="text"
                    value="{{ $user ? $user->name : ''}}"
                    placeholder="Name" required>
            </div>

            @error('name')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">

            <label class="label" for="lastname">Lastname</label>
        
            <div class="control has-icons-right">
        
                <input
                    class="input"
                    name="lastname"
                    id="lastname"
                    type="text"
                    value="{{ $user ? $user->lastname : ''}}"
                    placeholder="Lastame" required>
            </div>

            @error('lastname')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>



        <div class="field">

            <label class="label" for="email">E-Mail</label>
        
            <div class="control has-icons-right">
        
                <input
                    class="input"
                    name="email"
                    id="email"
                    type="email"
                    value="{{ $user ? $user->email : ''}}"
                    placeholder="e-mail" required>
            </div>

            @error('email')
            <div class="notification is-danger is-light is-size-7 p-1 mt-1">{{ $message }}</div>
            @enderror
        </div>



        <div class="columns">

            <div class="column is-half">

            <div class="field">
                <label class="label">User Roles</label>
            
                <div class="control">

                    @if ( count($roles) > 0)
                    
                    @foreach ($roles as $role)
        
                        <label class="checkbox is-block">
                            <input type="checkbox" name="role{{$role->id}}" value="{{$role->id}}" 
                            @checked(in_array($role->id,$available_usr_roles))> {{ $role->name }}
                        </label>
        
                    @endforeach
        
                    @else  
                        <p>{{ config('roles.list.noitem') }}</p>
                    @endif                                       
                                
                </div>
            </div>

            </div>


            <div class="column is-half">

                <div class="field">
                    <label class="label">User Permissions</label>
                
                    <div class="control">
                
                        @if ( count($permissions) > 0)
                    
                        @foreach ($permissions as $perm)
            
                            <label class="checkbox is-block">
                                <input type="checkbox" name="perm{{$perm->id}}" value="{{$perm->id}}" 
                                @checked(in_array($perm->id,$available_usr_perms))> {{ $perm->name }}
                            </label>
            
                        @endforeach
            
                        @else  
                            <p>{{ config('permissions.list.noitem') }}</p>
                        @endif          
                                    
                    </div>
                </div>

            </div>

        </div>

        <x-editor :params="config('users.form.remarks')" value="{{ $user ? $user->remarks : '' }}"/>






        
        <div class="buttons is-right">
            @if ($user)
            <button class="button is-dark">{{ config('users.update.submitText') }}</button>
            @else
            <button class="button is-dark">{{ config('users.create.submitText') }}</button>
            @endif
        </div>
    
        </form>



    </div>
</x-pdm-layout>