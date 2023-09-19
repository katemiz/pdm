<?php

use function Livewire\Volt\{state};

//

?>

<div class="block">
    <table class="table is-fullwidth is-size-6">
        <thead>
            <tr>
                <th colspan="4" class="has-text-centered">Toleranslandırma / Tolerances (mm)</th>
            </tr>
            <tr>
                <th colspan="2" class="has-text-centered">Doğrusal / Linear (mm)</th>
                <th colspan="2" class="has-text-centered">Açısal / Angular</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="is-size-6 has-text-grey">X</td>
                <td>&plusmn;2</td>
                <td>X</td>
                <td>&plusmn;2&deg;</td>
            </tr>

            <tr>
                <td>X.X</td>
                <td>&plusmn;0.8</td>
                <td>X.X</td>
                <td>&plusmn;30&#8242; [0.5&deg;]</td>
            </tr>

            <tr>
                <td>X.XX</td>
                <td>&plusmn;0.2</td>
                <td>X.XX</td>
                <td>&plusmn;15&#8242; [0.25&deg;]</td>
            </tr>
        </tbody>
    </table>



    <nav class="level">
        <div class="level-item has-text-centered">
          <div>
            <p class="heading">X</p>
            <p class="title">&plusmn;2</p>
          </div>
        </div>
        <div class="level-item has-text-centered">
          <div>
            <p class="heading">X.X</p>
            <p class="title">&plusmn;0.8</p>
          </div>
        </div>
        <div class="level-item has-text-centered">
          <div>
            <p class="heading">X.XX</p>
            <p class="title">456K</p>
          </div>
        </div>
        <div class="level-item has-text-centered">
          <div>
            <p class="heading">Likes</p>
            <p class="title">789</p>
          </div>
        </div>
    </nav>



</div>
