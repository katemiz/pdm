<header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">End Products</h1>
    <h2 class="subtitle has-text-weight-light">View End Product Properties</h2>
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
                    <a href="/endproducts/list">
                        <span class="icon is-small"><x-carbon-table /></span>
                        <span>List All</span>
                    </a>
                </p>

                <p class="level-item">
                    <a href="/endproducts/form/">
                        <span class="icon is-small"><x-carbon-add-large /></span>
                        <span>Add</span>
                    </a>
                </p>

            </div>

            <!-- Right side -->
            <div class="level-right">

                @role(['admin','company_admin','requirement_engineer'])

                @if ($status == 'Frozen')

                    @if ($is_latest)
                    <p class="level-item">
                        <a wire:click='reviseConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-version /></span>
                            <span>Revise</span>
                        </a>
                    </p>
                    @endif

                @else

                    <p class="level-item">
                        <a href='/endproducts/form/{{ $uid }}'>
                            <span class="icon"><x-carbon-edit /></span>
                        </a>
                    </p>

                    <p class="level-item">
                        <a wire:click='freezeConfirm({{ $uid }})'>
                            <span class="icon"><x-carbon-stamp /></span>
                        </a>
                    </p>

                    <p class="level-item">
                        <a wire:click="triggerDelete('requirement',{{ $uid }})">
                            <span class="icon has-text-danger"><x-carbon-trash-can /></span>
                        </a>
                    </p>
                @endif


                @endrole

            </div>
        </nav>

        <div class="column">
            <div class="columns">

                <div class="column is-8">
                    <p class="title has-text-weight-light is-size-2">{{$part_number}}-{{$version}}</p>
                    <p class="subtitle has-text-weight-light is-size-6"><strong>{{$nomenclature}}</strong></p>

                    {{-- @if (count($all_revs) > 1)
                    <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
                        <ul>
                        @foreach ($all_revs as $key => $revId)
                            @if ($key != $revision)
                            <li><a href="/requirements/view/{{$revId}}">R{{$key}}</a></li>
                            @endif
                        @endforeach
                        </ul>
                    </nav>
                    @endif --}}
                </div>

                <div class="column has-text-right is-4">


                    <table class="table is-fullwidth">
                        <tr>
                            <th>End Product Type</th>
                            <td>{{$product_type}}</td>
                        </tr>
                        <tr>
                            <th>Requirement Source</th>
                            <td>{{$product_type}}</td>
                        </tr>
                        <tr>
                            <th>Cross Ref No</th>
                            <td>{{$product_type}}</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>








        <div class="column">
            <div class="columns is-vcentered">

              <div class="column is-half">
                <p class="has-text-weight-light is-size-6">Project</p>
                <span class="tag is-black">{{ $product_type }}</span>
              </div>

              <div class="column is-half has-text-right">
                <p class="has-text-weight-light is-size-6">End Product</p>

                <span class="tag is-dark">{{ $uid > 0 ? $uid : '----' }}</span>

              </div>

            </div>
        </div>


        <div class="column">
            <strong>Requirement Text</strong>
            {!! $description !!}
        </div>


        <div class="column">
            <strong>Attachments</strong>
            @livewire('file-list', [
                'canDelete' => false,
                'model' => 'Requirement',
                'modelId' => $uid,
                'tag' => 'support',                          // Any tag other than model name
            ])
        </div>













        @if (strlen(trim($remarks)) > 0)
        <div class="column has-text-grey">
            <strong>Remarks/Notes</strong>
            {!! $remarks !!}
        </div>
        @endif



        {{-- INTERFACES --}}
        <div class="column">
            <div class="columns is-vcentered">

                <div class="column is-half">
                    <strong>Mechanical Interfaces</strong>
                </div>

                <div class="column has-text-right is-2">

                    <strong>Electrical Interfaces</strong>


                </div>

            </div>
        </div>















        {{-- VERIFICATIONS --}}
        <div class="column">
            <div class="columns is-vcentered">

                <div class="column is-10">
                    <strong>Verifications</strong>
                </div>

                <div class="column has-text-right is-2">
                    @if ($status != 'Frozen')
                    @role(['admin','company_admin','requirement_engineer'])
                    <a href="/verifications/{{$uid}}/form" class="button is-link is-small">
                        <span class="icon is-small">
                            <x-carbon-add />
                        </span>
                        <span>Add</span>
                    </a>
                    @endrole
                    @endif
                </div>

            </div>
        </div>




        <div class="columns is-size-7 has-text-grey mt-6">

            <div class="column">
                <p>{{ $created_at }}</p>
                <p>{{ $created_at }}</p>
            </div>

            <div class="column has-text-right">
                <p>{{ $updated_at }}</p>
                <p>{{ $updated_at }}</p>
            </div>

        </div>

    </div>

</div>
