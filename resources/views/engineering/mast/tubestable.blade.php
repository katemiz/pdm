<table class="table is-fullwidth my-6">


    <thead>
        <tr>
            <th class="has-text-left font-bold">#</th>
            <th class="has-text-right">OD</th>
            <th class="has-text-right">ID</th>
            <th class="has-text-right">THK</th>
            <th class="has-text-right">Mass</th>
            <th class="has-text-right">Moment<br>Capacity</th>
            <th class="has-text-centered has-background-white-ter" colspan="2">Pneumatic<br>Load Capacity<sup>(1)</sup>
                <br><br>

                <a class="" wire:click='decreasePressure'>
                    <i class="icon "><x-carbon-arrow-down /></i>
                </a>

                <span class="tag is-info">{{ $pressure }} Bars</span>
                <a class="" wire:click='increasePressure'>
                    <i class="icon "><x-carbon-arrow-up /></i>
                </a>
            </th>

            <th class="has-text-centered">P<sub>cr</sub><sup>(2)</sup>

                <br><br>
                <br>

                <a class="" wire:click='decreaseBucklingLength'>
                    <i class="icon "><x-carbon-arrow-down /></i>
                </a>

                <span class="tag is-info">{{ $tubeBucklingLength }} mm</span>
                <a class="" wire:click='increaseBucklingLength'>
                    <i class="icon "><x-carbon-arrow-up /></i>
                </a>
            </th>

        </tr>
    </thead>


    <tbody id="tableBody">

        @foreach ($tubeData as $i => $tube)

            <tr>
                <th>
                    <a wire:click="GetMore({{ $i }})" >MT-{{ sprintf("%02d",$i+1) }}</a>
                </th>
                <td class="has-text-right">{{ sprintf("%.2f",round($tube["od"],2)) }} mm</td>
                <td class="has-text-right">{{ sprintf("%.2f",round($tube["id"],2)) }} mm</td>
                <td class="has-text-right">{{ sprintf("%.2f",round($tube["thk"],2)) }} mm</td>
                <td class="has-text-right">{{ round($tube["mass"],1) }} kg/m</td>
                <td class="has-text-right">{{ round($tube["moment"],0) }} Nm</td>
                <td class="has-text-right has-background-white-ter">{{ round($tube["pressureLoad"],0) }} N</td>
                <td class="has-text-right has-background-white-ter">{{ round($tube["pressureLoad"] / 9.81, 0) }} kg</td>
                <td class="has-text-right">{{ round($tube["criticalLoad"],0) }} N</td>
            </tr>

        @endforeach

    </tbody>


</table>

