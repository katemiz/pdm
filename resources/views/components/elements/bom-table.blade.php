<div>

    @if ( count($item->components) > 0 )

        @if ($item->getHasAssyComponent())

            <div class="tabs">
            <ul>
                <li 
                    class="{{ $showFirstLevelBOM ? 'is-active':'' }}" 
                    wire:click="$toggle('showFirstLevelBOM')">
                    <a>Bill of Materials - First Level</a>
                </li>
                <li 
                    class="{{ !$showFirstLevelBOM ? 'is-active':'' }}" 
                    wire:click="$toggle('showFirstLevelBOM')">
                    <a>Bill of Materials - All Levels</a>
                </li>
            </ul>
            </div>
            
        @endif


        {{-- FIRST LEVEL BOM --}}
        <div class="column {{ $showFirstLevelBOM ? '':'is-hidden' }}">

            <table class="table is-fullwidth has-background-light">

                <caption>
                    Bill of Materials for 
                    <span class="has-text-weight-extrabold has-text-danger">{{$item->part_number }}-{{$item->config_number }}-{{$item->version }}</span>
                </caption>


                @if ($item->components->count() > 0)
                <thead>
                    <tr>
                        <th>Part Number</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Quantity</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($item->components as $component)
                        <tr>
                            <td class="is-narrow">

                                @switch($component->part_type)

                                    @case('Detail')
                                        <a href="/details/Detail/view/{{$component->id}}" target="_blank">
                                            {{ $component->part_number }}-{{ $component->config_number ?  $component->config_number .'-':''}} {{ $component->version }} 
                                        </a>
                                        @break

                                    @case('Assy')
                                        <a href="/products-assy/view/{{$component->id}}" target="_blank">
                                            {{ $component->part_number }}-{{ $component->config_number ?  $component->config_number .'-':''}}{{ $component->version }} 
                                        </a>
                                        @break

                                    @case('Buyable')
                                        <a href="/buyables/view/{{$component->id}}" target="_blank">
                                            {{ $component->part_number }}-{{ $component->version }} 
                                        </a>
                                        @break

                                    @case('MakeFrom')
                                        <a href="/details/MakeFrom/view/{{$component->id}}" target="_blank">
                                            {{ $component->part_number }}-{{ $component->version }} 
                                        </a>
                                        @break

                                    @case('Standard')
                                        <a href="/details/Standard/view/{{$component->id}}" target="_blank">
                                            {{ $component->standard_number }} {{ $component->std_params }} 
                                        </a>
                                        @break

                                        

                                @endswitch
                                
                            </td>
                            <td>{{ $component->part_type }}</td>
                            <td>{{ $component->description }}</td>
                            <td class="is-narrow has-text-right">{{ $component->pivot->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
                @endif

            </table>

        </div>

        {{-- CASCADED BOM - ALL COMPONENTS --}}
        @if ($item->getHasAssyComponent())
            
            <div class="column {{ !$showFirstLevelBOM ? '':'is-hidden' }}">

                <table class="table is-fullwidth has-background-light">

                    <caption>Bill of Materials - All Cascaded Levels
                        <span class="has-text-weight-extrabold has-text-danger">{{$item->part_number }}-{{$item->config_number }}-{{$item->version }}</span>
                    </caption>

                    <thead>
                        <tr>
                            <th>Part Number</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Total Quantity</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($item->getAllComponents() as $part)
                            <tr>
                                <td class="is-narrow">

                                    @switch($part['part_type'])
                                                                        
                                        @case('Detail')
                                            <a href="/details/Detail/view/{{$part['id']}}" target="_blank">
                                                {{ $part['part_number'] }}-{{ $part['version'] }} 
                                            </a>
                                            @break

                                        @case('Assy')
                                            <a href="/products-assy/view/{{$part['id']}}" target="_blank">
                                                {{ $part['part_number'] }}-{{ $part['version'] }} 
                                            </a>
                                            @break

                                        @case('Buyable')
                                            <a href="/buyables/view/{{$part['id']}}" target="_blank">
                                                {{ $part['part_number'] }}-{{ $part['version'] }} 
                                            </a>
                                            @break

                                        @case('MakeFrom')
                                            <a href="/details/MakeFrom/view/{{$part['id']}}" target="_blank">
                                                {{ $part['part_number'] }}-{{ $part['version'] }} 
                                            </a>
                                            @break

                                        @case('Standard')
                                            <a href="/details/Standard/view/{{$part['id']}}" target="_blank">
                                                {{ $part['standard_number'] }} {{ $part['std_params'] }} 
                                            </a>
                                            @break

                                    @endswitch
                                </td>
                                <td>{{ $part['part_type'] }}</td>
                                <td>{{ $part['description'] }}</td>
                                <td class="is-narrow has-text-right">{{ $part['total_quantity'] }}</td>
                            </tr>   
                        @endforeach
                    </tbody>
                </table>

            </div>
        @endif

    @endif

</div>