<section class="section container">

    <div class="column">
        <header class="mb-6">
            <h1 class="title has-text-weight-light is-size-1">Standard Families</h1>
            <h2 class="subtitle has-text-weight-light">List of all Standard Families</h2>
        </header>
    </div>


    @if(session('message'))
        <div class="notification is-info is-light">{{ session('message') }}</div>
    @endif

    <nav class="level my-6">

        <!-- Left side -->
        <div class="level-left">

            @role(['EngineeringDept'])
            <div class="level-item has-text-centered">
                <a href="/std-family/form" class="button is-dark">
                    <span class="icon is-small"><x-carbon-add /></span>
                    <span>Add Standard Family</span>
                </a>
            </div>
            @endrole

        </div>

        <!-- Right side -->
        <div class="level-right">

            <div class="field has-addons">
                <div class="control">
                  <input class="input is-small" type="text" wire:model.live="query" placeholder="Search ...">
                </div>
                <div class="control">
                <a class="button is-link is-light is-small">
                    @if ( strlen($query) > 0)
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

    @if ($sfamilies->count() > 0)

    <table class="table is-fullwidth">

        <caption>{{ $sfamilies->total() }} {{ $sfamilies->total() > 1 ? ' Records' :' Record' }}</caption>

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

                <th class="has-text-right"><span class="icon"><x-carbon-user-activity /></span></th>

            </tr>
        </thead>

        <tbody>

            @foreach ($sfamilies as $record)
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

                        @if ( !in_array($record->status,['Frozen','Released']) )

                            <a href="/std-family/form/{{ $record->id }}">
                                <span class="icon"><x-carbon-edit /></span>
                            </a>

                        @endif

                    @endrole

                </td>

            </tr>
            @endforeach

        </tbody>
    </table>

    {{ $sfamilies->links('components.pagination.bulma') }}

    @else
        <div class="notification is-warning is-light">No Standard Families found in database yet!</div>
    @endif
</section>
