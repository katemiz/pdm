<div>
    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">{{ $constants['list']['title'] }}</h1>

        @if ( $constants['list']['subtitle'] )
            <h2 class="subtitle has-text-weight-light">{{ $constants['list']['subtitle'] }}</h2>
        @endif
    </header>

    @if(session('message'))
        <div class="notification is-info is-light">{{ session('message') }}</div>
    @endif

    <nav class="level my-6">

        <!-- Left side -->
        <div class="level-left">

            @if ($canEdit)
                <div class="level-item has-text-centered">
                    <a href="{{ $constants['list']['addButton']['route'] }}" class="button is-dark">
                        <span class="icon is-small"><x-carbon-add /></span>
                        <span>{{ $constants['list']['addButton']['text'] }}</span>
                    </a>
                </div>
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

        <caption>{{ $items->total() }} {{ $items->total() > 1 ? ' Records' :' Record' }}</caption>

        <thead>
            <tr>
                @foreach ($constants['list']['headers'] as $col_name => $headerParams)
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

                @if ( isset($constants['list']['actions']) )
                    <th class="has-text-right"><span class="icon"><x-carbon-user-activity /></span></th>
                @endif

            </tr>
        </thead>

        <tbody>

            @foreach ($items as $record)
            <tr wire:key="{{ $record->id }}">

                @foreach (array_keys($constants['list']['headers']) as $col_name)
                    <td>
                        @if (isset($constants['list']['headers'][$col_name]['is_html']) && $constants['list']['headers'][$col_name]['is_html'])
                            {!! $record[$col_name] !!}
                        @else
                            {{ $record[$col_name] }}
                        @endif
                    </td>
                @endforeach

                <td class="has-text-right">

                    <a wire:click="viewItem({{ $record->id}})">
                        <span class="icon"><x-carbon-view/></span>
                    </a>

                    @role(['EngineeringDept'])
                    @if ($record->status == 'wip' )
                        <a href="/cr/form/{{ $record->id}}"><span class="icon"><x-carbon-edit /></span></a>

                        <a wire:click.prevent="startCRDelete({{$record->id}})">
                            <span class="icon has-text-danger-dark"><x-carbon-trash-can /></span>
                        </a>
                    @endif
                    @endrole

                </td>

            </tr>
            @endforeach

        </tbody>
    </table>

    {{ $items->links('components.pagination.bulma') }}

    @else
        <div class="notification is-warning is-light">{{ $constants['list']['noitem'] }}</div>
    @endif
</div>
