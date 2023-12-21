<section class="section container">

    <script>
        function toggleDropdown() {

            let dd = document.getElementById('dmenu')

            if (dd.classList.contains('is-active')) {
                dd.classList.remove('is-active')
            } else {
                dd.classList.add('is-active')
            }

            console.log(event.target)

            // !elem.contains(event.target);

        }

        // window.onclick = function(e){
        //     document.getElementById('dmenu').classList.remove('is-active')

        // }
    </script>

    <div class="columns">

        <div class="column is-8">

            <header class="mb-6">
                <h1 class="title has-text-weight-light is-size-1">List of Products</h1>
                <h2 class="subtitle has-text-weight-light">List of all products/items ['Detail','Assy','Buyable']</h2>
            </header>

        </div>

        <div class="column has-text-right">
            <input type="checkbox" wire:model="show_latest" wire:click="$toggle('show_latest')"> Show only latest revisions
        </div>

    </div>


    @if(session('message'))
        <div class="notification is-info is-light">{{ session('message') }}</div>
    @endif

    <nav class="level my-6">

        <!-- Left side -->
        <div class="level-left">

            @role(['admin','EngineeringDepartment'])
            {{-- <div class="level-item has-text-centered">
                    <a href="/parts-menu" class="button is-dark">
                        <span class="icon is-small"><x-carbon-add /></span>
                        <span>Add Product</span>
                    </a>
                </div> --}}


                <div class="dropdown" id="dmenu">
                    <div class="dropdown-trigger">
                      <button class="button is-dark" aria-haspopup="true" aria-controls="dropdown-menu" onclick="toggleDropdown()">
                        <span class="icon is-small"><x-carbon-add /></span>
                        <span>Add Product</span>
                        <span class="icon is-small"><x-carbon-chevron-down /></span>
                      </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu" role="menu">
                      <div class="dropdown-content">

                        <a href="/products-assy/form" class="dropdown-item">
                            <span class="icon"><x-carbon-asset /></span>
                            <span>Assembled Product</span>
                        </a>

                        <a href="/details/form" class="dropdown-item">
                            <span class="icon"><x-carbon-qr-code /></span>
                            <span>Detail (Make) Part</span>
                        </a>

                        <a href="/buyables/form" class="dropdown-item">
                            <span class="icon"><x-carbon-shopping-cart-arrow-down /></span>
                            <span>Buyable Part</span>
                        </a>

                        <a href="/parts-menu" class="dropdown-item">
                            <span class="icon"><x-carbon-change-catalog /></span>
                            <span>Make-From Part</span>
                        </a>

                        <a href="/parts-menu" class="dropdown-item">
                            <span class="icon"><x-carbon-catalog /></span>
                            <span>Standard Parts</span>
                        </a>

                        <a href="/parts-menu" class="dropdown-item">
                            <span class="icon"><x-carbon-chemistry /></span>
                            <span>Chemical Items</span>
                        </a>

                      </div>
                    </div>
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

                <th class="has-text-right"><span class="icon"><x-carbon-user-activity /></span></th>

            </tr>
        </thead>

        <tbody>

            @foreach ($items as $record)
            <tr wire:key="{{ $record->id }}">

                @foreach (array_keys($constants['list']['headers']) as $col_name)
                    <td class="has-text-{{ $constants['list']['headers'][$col_name]['align'] ? $constants['list']['headers'][$col_name]['align'] : 'left' }}">
                        @if (isset($constants['list']['headers'][$col_name]['is_html']) && $constants['list']['headers'][$col_name]['is_html'])
                            {!! $record[$col_name] !!}
                        @else
                            {{ $record[$col_name] }}
                        @endif
                    </td>
                @endforeach

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

                        @case('Detail')
                            <a href="/details/view/{{ $record->id}}">
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

                            @case('Detail')
                                <a href="/details/form/{{ $record->id}}">
                                    <span class="icon"><x-carbon-edit /></span>
                                </a>
                                @break

                            @default
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
        <div class="notification is-warning is-light">No Sellable Products found in database</div>
    @endif
</section>


