<table class="table is-fullwidth my-6">


    <thead>
        <tr>
            <th class="has-text-left font-bold">#</th>
            <th class="has-text-right">OD</th>
            <th class="has-text-right">Length</th>
            <th class="has-text-right">Wind Load (N)</th>


        </tr>
    </thead>


    <tbody id="tableBody">

        @foreach ($tubeData as $i => $tube)

            <tr>
                <th>
                    <a wire:click="GetMore({{ $i }})" >MT-{{ sprintf("%02d",$i+1) }}</a>
                </th>
                <td class="has-text-right">{{ sprintf("%.2f",round($tube["od"],2)) }} mm</td>
                <td class="has-text-right">{{ sprintf("%.2f",round($tube["length"],2)) }} mm</td>
                <td class="has-text-right">{{ sprintf("%.2f",round($tube["windForce"],2)) }} N</td>

            </tr>

        @endforeach

    </tbody>


</table>

