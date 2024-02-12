<?php

use function Livewire\Volt\{state};

state('notesArray');


//$addNote = fn () => array_push('fn')$this->count++;


?>

<div class="field ">

    <label class="label">Special Part Notes (Flag Notes)</label>


    @foreach ($collection as $index => $item)

      <div class="field-body">

        <div class="field is-narrow">
          <label class="label has-text-weight-normal">Flag Note No</label>
          <p class="control">
            <input class="input" type="text" placeholder="No">
          </p>
        </div>

        <div class="field">
          <label class="label has-text-weight-normal">Flag Note</label>

          <p class="control">
            <input class="input" type="email" placeholder="Specific part note">
          </p>
        </div>

      </div>

    @endforeach



</div>
