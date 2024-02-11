<section class="section container">

    <div class="columns">

        <div class="column is-8">

            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">MOMs - Minutes of Meetings</h1>
                <h2 class="subtitle has-text-weight-light">List of All Minutes of Meetings</h2>
            </header>

        </div>

        <div class="column has-text-right">
            <input type="checkbox" wire:model="show_my_moms" wire:click="$toggle('show_my_moms')"> Show My MOMs Only
        </div>

    </div>



    @if(session('message'))
        <div class="notification is-info is-light">{{ session('message') }}</div>
    @endif

    <nav class="level my-6">

        <!-- Left side -->
        <div class="level-left">

            <div class="level-item has-text-centered">
                <a href="/moms/form" class="button is-dark">
                    <span class="icon is-small"><x-carbon-add /></span>
                    <span>Add MOM</span>
                </a>
            </div>

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

    @if ($moms->count() > 0)

    <table class="table is-fullwidth">

        <caption>{{ $moms->total() }} {{ $moms->total() > 1 ? ' Records' :' Record' }}</caption>

        <thead>
            <tr>
                <th class="has-text-left">
                    MOM No

                    <a class="{{ $mom_no_direction == 'asc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('mom_no')">
                        <span class="icon has-text-link"><x-carbon-chevron-sort-up /></span>
                    </a>

                    <a class="{{ $mom_no_direction == 'desc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('mom_no')">
                        <span class="icon has-text-link"><x-carbon-chevron-sort-down /></span>
                    </a>
                </th>

                <th class="has-text-left">
                    Subject

                    <a class="{{ $subject_direction == 'asc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('subject')">
                        <span class="icon has-text-link"><x-carbon-chevron-sort-up /></span>
                    </a>

                    <a class="{{ $subject_direction == 'desc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('subject')">
                        <span class="icon has-text-link"><x-carbon-chevron-sort-down /></span>
                    </a>
                </th>

                <th class="has-text-left">
                    Date Prepared

                    <a class="{{ $updated_at_direction == 'asc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('updated_at')">
                        <span class="icon has-text-link"><x-carbon-chevron-sort-up /></span>
                    </a>

                    <a class="{{ $updated_at_direction == 'desc' ? 'is-hidden': '' }}" wire:click="changeSortDirection('updated_at')">
                        <span class="icon has-text-link"><x-carbon-chevron-sort-down /></span>
                    </a>
                </th>

                <th class="has-text-right"><span class="icon"><x-carbon-user-activity /></span></th>

            </tr>
        </thead>

        <tbody>

            @foreach ($moms as $record)
            <tr wire:key="{{ $record->id }}">



                <td>MOM-{{ $record->mom_no }}</td>
                <td>{{ $record->subject }}</td>
                <td>{{ $record->updated_at }}</td>








                <td class="has-text-right">

                    <a wire:click="viewItem({{ $record->id }})">
                        <span class="icon"><x-carbon-view/></span>
                    </a>


                    @role(['EngineeringDept'])

                        @if ( !in_array($record->status,['Frozen','Released']) )
                            <a href="/moms/form/{{ $record->id }}">
                                <span class="icon"><x-carbon-edit /></span>
                            </a>
                        @endif

                    @endrole

                </td>

            </tr>
            @endforeach

        </tbody>
    </table>

    {{ $moms->links('components.pagination.bulma') }}

    @else
        <div class="notification is-warning is-light">No MOM exists yet.</div>
    @endif
</section>


