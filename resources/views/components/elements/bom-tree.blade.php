<div>

    @if (count($this->components) > 0)

        <table class="table is-fullwidth">

            @foreach ($this->components as $component)

                <tr>
                    <td>
                        @if ($component->part_type == 'Standard')
                            <a href="/details/Standard/view/{{$component->id}}" target="_blank">
                                {{ $component->standard_number }}<br>
                                <span class="is-size-7 has-text-grey">{{ $component->std_params }} </span>
                            </a>
                        @else
                            <a href="/details/{{ $component->part_type }}/view/{{$component->id}}" target="_blank">
                                {{ $component->part_number }} {{ $component->version }}
                            </a>
                        @endif

                    </td>
                    <td>[{{ $component->pivot->quantity }}]</td>
                    <td>
                        @if ($component->pivot->quantity > 1)
                            <a class="icon is-small has-text-link" wire:click="decreaseQty({{ $component->id }})">
                                <x-carbon-subtract-alt />
                            </a>
                        @else
                            <a class="icon is-small has-text-link" wire:click="removeComponent({{ $component->id }})">
                                <x-carbon-trash-can class="has-text-danger" />
                            </a>
                        @endif

                        <a class="icon is-small has-text-link"
                            wire:click="increaseQty({{ $component->id }})"><x-carbon-add-alt /></a>
                    </td>
                </tr>

            @endforeach

        </table>
    @else

        <div class="notification is-warning is-light">
            No components yet.
        </div>

    @endif

</div>