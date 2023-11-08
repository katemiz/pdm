<nav class="navbar is-dark">

    <div class="navbar-brand">

        <a  href="/" class="navbar-item has-text-white has-background-warning">
            <span class="icon has-text-dark">
                <x-carbon-model-alt />
            </span>
        </a>

        <a  href="/" class="navbar-item has-text-white has-background-link-dark">
            <span class="ml-2">{{ config('appconstants.app.code') }}</span>
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar_ana">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>

    </div>

    <div id="navbar_ana" class="navbar-menu">

        <div class="navbar-start" id="navstart">

            @if(Auth::check())

                {{-- <a href="/companies" class="navbar-item icon-text">
                    <span class="icon has-text-warning">
                        <x-carbon-letter-cc />
                    </span>
                    <span>Companies</span>
                </a> --}}



                <div class="navbar-item has-dropdown is-hoverable">

                    <a class="navbar-link">
                        <span class="icon has-text-warning">
                            <x-carbon-letter-aa />
                        </span>
                        <span class="ml-2">Admin</span>
                    </a>

                    <div class="navbar-dropdown">
                        <a href="/admin/users" class="navbar-item">Users</a>
                        <a href="/admin/roles" class="navbar-item">Roles</a>
                        <a href="/admin/permissions" class="navbar-item">Permissions</a>
                        <a href="/admin/companies" class="navbar-item">Companies</a>
                        <a href="/admin/projects" class="navbar-item">Projects</a>
                    </div>
                </div>


                <div class="navbar-item has-dropdown is-hoverable">

                    <a class="navbar-link">
                        <span class="icon has-text-warning">
                            <x-carbon-intent-request-scale-in />
                        </span>
                        <span class="ml-2">Requests</span>
                    </a>

                    <div class="navbar-dropdown">
                        <a href="/cr/list" class="navbar-item">Change Requests</a>
                        <a href="/ecn/list" class="navbar-item">ECNs</a>
                    </div>
                </div>


                <a href="/endproducts/list" class="navbar-item">
                    <span class="icon has-text-warning">
                        <x-carbon-box />
                    </span>
                    <span class="ml-2">End Products</span>
                </a>


                <a href="/products/list" class="navbar-item">
                    <span class="icon has-text-warning">
                        <x-carbon-barcode />
                    </span>
                    <span class="ml-2">Products</span>
                </a>

                <a href="/documents/list" class="navbar-item">
                    <span class="icon has-text-warning">
                        <x-carbon-document-attachment />
                    </span>
                    <span class="ml-2">Documents</span>
                </a>






                <div class="navbar-item has-dropdown is-hoverable">

                    <a class="navbar-link">
                        <span class="icon has-text-warning">
                            <x-carbon-industry />
                        </span>
                        <span class="ml-2">Materials & Processes</span>
                    </a>

                    <div class="navbar-dropdown">
                        <a href="/material/list" class="navbar-item">Materials</a>
                        <a href="/process/list" class="navbar-item">Processes</a>
                        <a href="/notes/list" class="navbar-item">Product Notes</a>

                    </div>
                </div>


                <a href="/engineering/home" class="navbar-item">
                    <span class="icon has-text-warning">
                        <x-carbon-function-math />
                    </span>
                    <span class="ml-2">Engineering</span>
                </a>




                {{-- <a href="/admin/users" class="navbar-item icon-text">
                    <span class="icon has-text-warning">
                        <x-carbon-group-access />
                    </span>
                    <span>Admin</span>
                </a>

                <a href="/mocs" class="navbar-item icon-text">
                    <span class="icon has-text-warning">
                        <x-carbon-user-role />
                    </span>
                    <span>Roles</span>
                </a>

                <a href="/pocs" class="navbar-item icon-text">
                    <span class="icon has-text-warning">
                        <x-carbon-add-comment />
                    </span>
                    <span>Permissions</span>
                </a> --}}






                {{-- <div class="navbar-item has-dropdown is-hoverable">
                    <p class="navbar-link" href="/Admin">Export</p>
                    <div class="navbar-dropdown">

                        <a href="/all-requirements" class="navbar-item">All Requirements</a>
                        <a href="/pocs-vs-requirements" class="navbar-item">POCs vs Requirements</a>
                        <a href="/dgates-vs-pocs" class="navbar-item">Decision Gates vs POCs</a>
                        <a href="/compliance-matrix" class="navbar-item">Compliance Matrix</a>



                    </div>
                </div> --}}


                {{-- <div class="navbar-item has-dropdown is-hoverable">

                    <a href="/projects" class="navbar-link">
                        <span class="icon has-text-warning">
                            <x-carbon-letter-aa />
                        </span>
                        <span class="ml-2">Adm</span>
                    </a>

                    <div class="navbar-dropdown">
                        <a href="/admin/users" class="navbar-item">Users</a>
                        <a href="/admin/roles" class="navbar-item">Roles</a>
                        <a href="/admin/permissions" class="navbar-item">Permissions</a>
                    </div>
                </div> --}}

            @endif

        </div>


        <div class="navbar-end">

            @if(Auth::check())

                <div class="navbar-item has-dropdown is-hoverable">

                    <p class="navbar-link">
                        <span class="mx-3 has-text-right">
                            {{ Auth::user()->name }} {{ Auth::user()->lastname }}
                        </span>
                    </p>



                    <div class="navbar-dropdown">

                        <a href="/profile" class="navbar-item">Profile</a>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a :href="route('logout')" class="navbar-item"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('ui.links.logout.text') }}
                            </a>
                        </form>

                    </div>
                </div>
            @else

                <div class="navbar-item">
                    {{-- <a href="{{route('login')}}" class="icon-text"> --}}
                        <a href="/logware/login" class="icon-text">

                        <span class="icon has-text-info">
                            <x-carbon-login />
                        </span>
                        <span class="ml-1">{{ __('ui.links.login.text')}}</span>
                    </a>
                </div>

            @endif

        </div>

    </div>

</nav>


@if (session('current_project_id') && session('current_project_name'))

<section class="hero has-background-grey-lighter has-text-right">

    <p class="is-size-7 p-1">
      Current Project : {{ session('current_project_name') }}
    </p>
</section>

@endif

