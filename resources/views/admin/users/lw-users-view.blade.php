
<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Users</h1>
    <h2 class="subtitle has-text-weight-light">View User Attributes</h2>
</header>

<div class="card">

    <div class="card-content">
        <div class="media">
            <div class="media-left">
            <figure class="image is-48x48">
                <a href="/admin-users/list"><x-carbon-list /></a>
            </figure>
            </div>

            <div class="media-content">
            <p class="title is-4">{{ $user->name }} {{ $user->lastname }}</p>
            <p class="subtitle is-6">@ {{ $user->company_name }}</p>
            </div>
        </div>

        <table class="table is-fullwidth">

            <tbody>
            <tr>
                <th>User Projects</th>
                <th>User Roles</th>
                <th>User Permissions</th>
            </tr>

            <tr>
                <td>
                    @if ( count($user->projects) > 0)
                        @foreach ($user->projects as $project)
                            <p>{{ $project->code}}</p>
                        @endforeach
                    @else
                        None
                    @endif
                </td>

                <td>
                    @if ( count($user->roles) > 0)
                        @foreach ($user->roles as $role)
                            <p>{{ $role->name}}</p>
                        @endforeach
                    @else
                        None
                    @endif
                </td>

                <td>
                    @if ( count($user->permissions) > 0)
                        @foreach ($user->permissions as $perm)
                            <p>{{ $perm->name}}</p>
                        @endforeach
                    @else
                        None
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <footer class="card-footer">

        <a href="/admin-users/form/{{ $user->id}}" class="card-footer-item">
            <span class="icon"><x-carbon-edit /></span>
        </a>

        <a href="javascript:confirmDelete('{{ $user->id}}')" class="card-footer-item">
            <span class="icon has-text-danger"><x-carbon-trash-can /></span>
        </a>
    </footer>
</div>


<div class="columns m-2">

    <div class="column is-size-7 has-text-grey-light is-half">
        Created by {{ $user['user_id'] }}<br>
        @ {{ $user['created_at'] }}
    </div>

    <div class="column is-size-7 has-text-right has-text-grey-light">
        Updated by {{ $user['updated_uid'] }}<br>
        @ {{ $user['updated_at'] }}
    </div>

</div>
