<div>

    <script>

        window.addEventListener('runConfirmDialog11',function(e) {

            Swal.fire({
                title: e.detail.title,
                text: e.detail.text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Ooops ...',

            }).then((result) => {
                if (result.isConfirmed) {
                    this.Livewire.dispatch('runDelete11')
                } else {
                    return false
                }
            })
        });

        window.addEventListener('infoDeleted11',function(e) {

            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Item has been deleted',
                showConfirmButton: false,
                timer: 1500
            })
        })

    </script>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">{{ $configs['list']['title'] }}</h1>

        @if ( $configs['list']['subtitle'] )
            <h2 class="subtitle has-text-weight-light">{{ $configs['list']['subtitle'] }}</h2>
        @endif
    </header>


    @if(session('message'))
    <div class="notification is-info is-light">{{ session('message') }}</div>
    @endif

    <nav class="level my-6">

        <!-- Left side -->
        <div class="level-left">

            {{-- @if (isset($params['roles']['w']))
            @role($params['roles']['w']) --}}
                <div class="level-item  has-text-centered">
                    <a href="{{ $configs['list']['addButton']['route'] }}" class="button is-dark">
                        <span class="icon is-small"><x-carbon-add /></span>
                        <span>{{ $configs['list']['addButton']['text'] }}</span>
                    </a>
                </div>
            {{-- @endrole
            @endif --}}

            @if (isset($configs['perms']['w']))
            @can($configs['perms']['w'])
                <div class="level-item  has-text-centered">
                    <a href="{{ $configs['list']['addButton']['route'] }}" class="button is-dark">
                        <span class="icon is-small"><x-carbon-add /></span>
                        <span>{{ $configs['list']['addButton']['text'] }}</span>
                    </a>
                </div>
            @endcan
            @endif

        </div>


        <!-- Right side -->
        <div class="level-right">

            <div class="field has-addons">
                <div class="control">
                  <input class="input is-small" type="text" wire:model.live="search" placeholder="Search ...">
                </div>
                <div class="control">
                <a class="button is-link is-light is-small">
                    @if ( strlen($search) > 0)
                        <span class="icon is-small is-left" wire:click="resetFilter">
                            <x-carbon-close />
                        </span>
                    @else
                        <span class="icon is-small"><x-carbon-search /></span>
                    @endif
                </a>
                </div>
            </div>

        </div>

    </nav>












    @if ($items->count() > 0)
    <table class="table is-fullwidth">

        @if ($configs['list']['listCaption'])
            <caption>{{ $configs['list']['listCaption'] }}</caption>
        @endif

        <thead>
            <tr>
                @foreach ($configs['list']['headers'] as $col_name => $headerParams)
                    <th class="has-text-{{ $headerParams['align'] }}">
                        {{ $headerParams['title'] }}

                        @if ($headerParams['sortable'])

                            <a class="{{ $headerParams['direction'] == 'asc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                <span class="icon has-text-link">
                                    <x-carbon-chevron-sort-up />
                                </span>
                            </a>

                            <a class="{{ $headerParams['direction'] == 'desc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('{{$col_name}}')">
                                <span class="icon has-text-link">
                                    <x-carbon-chevron-sort-down />
                                </span>
                            </a>

                        @endif
                    </th>
                @endforeach

                @if ( isset($configs['list']['actions']) )
                    <th class="has-text-right"><span class="icon"><x-carbon-user-activity /></span></th>
                @endif

            </tr>
        </thead>

        <tbody>

            @foreach ($items as $record)
            <tr>

                @foreach (array_keys($configs['list']['headers']) as $col_name)
                    <td>
                        @if (isset($configs['list']['headers'][$col_name]['is_html']) && $configs['list']['headers'][$col_name]['is_html'])
                            {!! $record[$col_name] !!}
                        @else
                            {{ $record[$col_name] }}
                        @endif
                    </td>
                @endforeach


                @if ( isset($configs['list']['actions']) )
                <td class="has-text-right">
                    @foreach ($configs['list']['actions'] as $act => $route)

                        @switch($act)
                            @case('r')
                                <a href="{{ $route}}{{ $record->id}}">
                                <span class="icon"><x-carbon-view/></span>
                                </a>
                                @break
                            @case('w')

                                @if (isset($configs['roles']['w']))
                                    @role($configs['roles']['w'])
                                        <a href="{{ $route }}{{ $record->id}}">
                                        <span class="icon"><x-carbon-edit /></span>
                                        </a>
                                    @endrole
                                @endif

                                @if (isset($configs['perms']['w']))
                                    @can($configs['perms']['w'])
                                        <a href="{{ $route }}{{ $record->id}}">
                                        <span class="icon"><x-carbon-edit /></span>
                                        </a>
                                    @endcan
                                @endif

                                @break
                            @case('x')

                                @if (isset($configs['roles']['w']))
                                @role($configs['roles']['w'])
                                    <a wire:click.prevent="deleteConfirm({{$record->id}})">
                                    <span class="icon has-text-danger-dark"><x-carbon-trash-can /></span>
                                    </a>
                                @endrole
                                @endif

                                @if (isset($configs['perms']['w']))
                                @can($configs['perms']['w'])
                                    <a wire:click.prevent="deleteConfirm({{$record->id}})">
                                    <span class="icon has-text-danger-dark"><x-carbon-trash-can /></span>
                                    </a>
                                @endcan
                                @endif

                                @break
                        @endswitch

                    @endforeach
                </td>
                @endif

            </tr>
            @endforeach

        </tbody>
    </table>


    {{ $items->links('components.pagination.bulma') }}

    @else
        <div class="notification is-warning is-light">{{ $configs['list']['noitem'] }}</div>
    @endif
</div>
