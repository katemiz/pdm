<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Projects</h1>
    <h2 class="subtitle has-text-weight-light">View Project Attributes</h2>
</header>

@if (session()->has('message'))
    <div class="notification">
        {{ session('message') }}
    </div>
@endif

<div class="card">

    <div class="card-content">

        <nav class="level mb-6">
            <!-- Left side -->
            <div class="level-left">

                <p class="level-item">
                    <a href="/admin-projects/list">
                        <span class="icon is-small"><x-carbon-table /></span>
                        <span>List All</span>
                    </a>
                </p>

                <p class="level-item">
                    <a href="/admin-projects/form/">
                        <span class="icon is-small"><x-carbon-add /></span>
                        <span>Add</span>
                    </a>
                </p>

            </div>

            <!-- Right side -->
            <div class="level-right">


                {{-- <p class="level-item">
                    <a wire:click='populate({{ $uid }})'>
                        <abbr title="Populate with MOCs and POCs">
                        <span class="icon"><x-carbon-port-input /></span>
                        </abbr>
                    </a>
                </p> --}}



                <p class="level-item">
                    <a href='/admin-projects/form/{{ $uid }}'>
                        <span class="icon"><x-carbon-edit /></span>
                    </a>
                </p>

                <p class="level-item">
                    <a wire:click='triggerDelete({{ $uid }})'>
                        <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                    </a>
                </p>

            </div>
        </nav>

        <div class="media">
            <div class="media-left has-text-centered">
                <figure class="image is-48x48"><x-carbon-building /></figure>
            </div>
            <div class="media-content">
                <p class="title is-4"> PRJ-{{ $uid }}</p>
                <p class="subtitle is-6">{{ $code}}</p>
            </div>
        </div>

        <p class="subtitle is-6">{{ $title}}</p>

        <div class="columns is-size-7 has-text-grey mt-6">

            <div class="column">
                <p>{{ $created_by }}</p>
                <p>{{ $created_at }}</p>
            </div>

            <div class="column has-text-right">
                <p>{{ $updated_by }}</p>
                <p>{{ $updated_at }}</p>
            </div>

        </div>

    </div>

</div>

