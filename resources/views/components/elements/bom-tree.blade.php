<table class="table is-fullwidth">

    @foreach ($components as $component)

        <tr>
            <td>{{ $component->part_number }}-{{ $component->version }}</td>
            <td>[{{ $component->pivot->quantity }}]</td>
            <td>
                <a class="icon is-small has-text-link"
                    wire:click="decreaseQty({{ $component->id }})"><x-carbon-subtract-alt /></a>
                <a class="icon is-small has-text-link"
                    wire:click="increaseQty({{ $component->id }})"><x-carbon-add-alt /></a>
            </td>
        </tr>

    @endforeach

</table>