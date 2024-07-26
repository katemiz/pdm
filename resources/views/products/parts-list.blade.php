<section class="section container has-background-white">

    <div class="columns">

        <div class="column is-8">

            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">{{$title}}</h1>
                <h2 class="subtitle has-text-weight-light">{{$subtitle}}</h2>
            </header>

        </div>

        <div class="column has-text-right">
            <input type="checkbox" wire:model="show_latest" wire:click="$toggle('show_latest')"> Show only latest revisions
        </div>

    </div>



    @if (session()->has('message'))
    <div class="notification">
        {{ session('message') }}
    </div>
    @endif



    @if(session('info'))
        <div class="notification is-info is-light">{{ session('info') }}</div>
    @endif

    <nav class="level my-6">

        <!-- Left side -->
        <div class="level-left">
            <x-add-button class="has-background-link-light"/>
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

    @if ($items->count() > 0)
    <table class="table is-fullwidth has-background-lighter">

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

                <th class="has-text-right"><span class="icon"><x-carbon-user-activity /></span></th>

            </tr>
        </thead>

        <tbody>

            @foreach ($items as $record)
            <tr wire:key="{{ $record->id }}">

                <td>{{ $record->full_part_number }}</td>
                <td>{{ $record->part_type }}</td>
                <td>
                    <a href="/parts/list?parts_by_ecn={{$record->c_notice_id}}" target="_blank">
                        {{ $record->c_notice_id }}
                    </a>               
                </td>
                <td>{{ $record->description }}</td>
                <td>{{ $record->created_at }}</td>
{{--
                @foreach (array_keys($constants['list']['headers']) as $col_name)
                    <td class="has-text-{{ $constants['list']['headers'][$col_name]['align'] ? $constants['list']['headers'][$col_name]['align'] : 'left' }}">
                        @if (isset($constants['list']['headers'][$col_name]['is_html']) && $constants['list']['headers'][$col_name]['is_html'])
                            {!! $record[$col_name] !!}
                        @else
                            {{ $record[$col_name] }}
                        @endif
                    </td>
                @endforeach --}}

                <td class="has-text-right">

                    @switch($record->part_type)
                        @case('Buyable')
                            <a href="/buyables/view/{{ $record->id}}">
                                <span class="icon"><x-carbon-view/></span>
                            </a>
                            @break

                        @case('Assy')
                            <a href="/products-assy/view/{{ $record->id}}">
                                <span class="icon"><x-carbon-view/></span>
                            </a>
                            @break

                        @case('Detail')
                        @case('MakeFrom')
                        @case('Standard')

                            <a href="/details/{{ $record->part_type }}/view/{{ $record->id}}">
                                <span class="icon"><x-carbon-view/></span>
                            </a>
                            @break

                        @default

                    @endswitch


                    @if (in_array($record->status,['WIP']))
                    @role(['admin','EngineeringDepartment'])

                        @switch($record->part_type)

                            @case('Buyable')
                                <a href="/buyables/form/{{ $record->id}}">
                                    <span class="icon"><x-carbon-edit /></span>
                                </a>
                                @break

                            @case('Assy')
                                <a href="/products-assy/form/{{ $record->id}}">
                                    <span class="icon"><x-carbon-edit /></span>
                                </a>
                                @break

                            @case('Detail')
                            @case('MakeFrom')
                            @case('Standard')

                                <a href="/details/{{ $record->part_type }}/form/{{ $record->id}}">
                                    <span class="icon"><x-carbon-edit /></span>
                                </a>
                                @break

                        @endswitch

                    @endrole
                    @endif

                </td>

            </tr>
            @endforeach

        </tbody>
    </table>

    {{ $items->withQueryString()->links('components.pagination.bulma') }}

    @else
        <div class="notification is-warning is-light">No parts found in database</div>
    @endif
</section>


