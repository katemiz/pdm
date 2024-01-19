@if ($manuals->count() > 0)


    <div class="box has-background-white-ter">


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

    <table class="table is-fullwidth">

        <caption>{{ $manuals->total() }} {{ $manuals->total() > 1 ? ' Records' :' Record' }}</caption>

        <thead>
            <tr>


                <th class="is-narrow">

                    Manual Number

                    <a class="{{ $sortDirManualNo == 'asc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('document_no')">
                        <span class="icon has-text-link"><x-carbon-chevron-sort-up /></span>
                    </a>

                    <a class="{{ $sortDirManualNo == 'desc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('document_no')">
                        <span class="icon has-text-link"><x-carbon-chevron-sort-down /></span>
                    </a>

                </th>



                <th>

                    Manual Title

                    <a class="{{ $sortDirManualTitle == 'asc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('title')">
                        <span class="icon has-text-link"><x-carbon-chevron-sort-up /></span>
                    </a>

                    <a class="{{ $sortDirManualTitle == 'desc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('title')">
                        <span class="icon has-text-link"><x-carbon-chevron-sort-down /></span>
                    </a>

                </th>



                <th class="has-text-right"><span class="icon"><x-carbon-user-activity /></span></th>

            </tr>
        </thead>

        <tbody>

            @foreach ($manuals as $record)
            <tr wire:key="{{ $record->id }}">


                <td class="is-narrow">{{ $record->document_no }} {{ $record->version }}</td>
                <td>{{ $record->title }}</td>


                <td class="has-text-right">
                    <a wire:click="addManual( {{ $record->id }} )"><span class="icon"><x-carbon-checkmark /></span></a>
                </td>

            </tr>
            @endforeach

        </tbody>
    </table>

    {{ $manuals->links('components.pagination.bulma') }}

    </div>

@else
    <div class="notification is-warning is-light">{{ $constants['list']['noitem'] }}</div>
@endif
