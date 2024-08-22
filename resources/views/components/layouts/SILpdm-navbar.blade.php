<nav class="navbar is-dark">

    <div class="navbar-brand">

        <a href="/" class="navbar-item has-text-white has-background-warning" aria-label="Home">
            <span class="icon has-text-dark">
                <x-carbon-model-alt />
            </span>
        </a>

        <a href="/" class="navbar-item has-text-white has-background-link-dark" aria-label="PDM">
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

                @role(['admin'])
                <div class="navbar-item has-dropdown is-hoverable">

                    <a class="navbar-link">
                        <span class="icon has-text-warning">
                            <x-carbon-letter-aa />
                        </span>
                        <span class="ml-2">Admin</span>
                    </a>

                    <div class="navbar-dropdown">
                        <a href="/admin-users/list" class="navbar-item">Users</a>
                        <a href="/admin-roles/list" class="navbar-item">Roles</a>
                        <a href="/admin-permissions/list" class="navbar-item">Permissions</a>
                        <a href="/admin-companies/list" class="navbar-item">Companies</a>
                        <a href="/admin-projects/list" class="navbar-item">Projects</a>
                    </div>
                </div>
                @endrole


                <div class="navbar-item has-dropdown is-hoverable">

                    <a class="navbar-link">
                        <span class="icon has-text-warning">
                            <x-carbon-intent-request-scale-in />
                        </span>
                        <span class="ml-2">Requests</span>
                    </a>

                    <div class="navbar-dropdown">

                        <a href="/cr/list" class="navbar-item">
                            <span class="icon has-text-link">
                                <x-carbon-change-catalog />
                            </span>
                            <span class="ml-2">Change Requests</span>
                        </a>

                        <a href="/ecn/list" class="navbar-item">
                            <span class="icon has-text-link">
                                <x-carbon-scis-control-tower />
                            </span>
                            <span class="ml-2">ECNs</span>
                        </a>

                    </div>
                </div>

                <div class="navbar-item has-dropdown is-hoverable">

                    <a class="navbar-link">
                        <span class="icon has-text-warning">
                            <x-carbon-industry />
                        </span>
                        <span class="ml-2">Products</span>
                    </a>

                    <div class="navbar-dropdown">
                        <a href="/endproducts/list" class="navbar-item">
                            <span class="icon has-text-link">
                                <x-carbon-box />
                            </span>
                            <span class="ml-2">Sellable Parts</span>
                        </a>

                        {{-- <a href="/products/list" class="navbar-item">
                            <span class="icon has-text-info">
                                <x-carbon-barcode />
                            </span>
                            <span class="ml-2">Make Parts</span>
                        </a>

                        <a href="/buyables/list" class="navbar-item">
                            <span class="icon has-text-info">
                                <x-carbon-radio />
                            </span>
                            <span class="ml-2">Buyable Parts</span>
                        </a> --}}

                        <a href="/parts/list" class="navbar-item">
                            <span class="icon has-text-link">
                                <x-carbon-radio />
                            </span>
                            <span class="ml-2">Components</span>
                        </a>

                    </div>
                </div>

                <a href="/documents/list" class="navbar-item">
                    <span class="icon has-text-warning">
                        <x-carbon-document-attachment />
                    </span>
                    <span class="ml-2">Documents</span>
                </a>

                <div class="navbar-item has-dropdown is-hoverable">

                    <a class="navbar-link">
                        <span class="icon has-text-warning">
                            <x-carbon-function-math />
                        </span>
                        <span class="ml-2">Engineering</span>
                    </a>

                    <div class="navbar-dropdown">

                        <a href="/engineering/home" class="navbar-item">
                            <span class="icon has-text-link">
                                <x-carbon-sigma />
                            </span>
                            <span class="ml-2">Engineering Utilities</span>
                        </a>

                        <hr class="navbar-divider">

                        <a href="/material/list" class="navbar-item">
                            <span class="icon has-text-link">
                                <x-carbon-cube />
                            </span>
                            <span class="ml-2">Materials</span>
                        </a>

                        <a href="/notes/list" class="navbar-item">
                            <span class="icon has-text-link">
                                <x-carbon-pen-fountain />
                            </span>
                            <span class="ml-2">Product Notes</span>
                        </a>

                        <a href="/std-family/list" class="navbar-item">
                            <span class="icon has-text-link">
                                <x-carbon-catalog />
                            </span>
                            <span class="ml-2">Standard Families</span>
                        </a>

                    </div>
                </div>

                <a href="/moms/list" class="navbar-item">
                    <span class="icon has-text-warning">
                        <x-carbon-report-data />
                    </span>
                    <span class="ml-2">MOM</span>
                </a>

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

                        <a href="/profile" class="navbar-item">Change Password</a>

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
                        <a href="/logware/login" class="icon-text">

                        <span class="icon has-text-link">
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

