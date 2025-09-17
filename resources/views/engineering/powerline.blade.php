<section class="section container">

  <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
    <ul>
      <li><a href='/engineering/home'>Engineering</a></li>
      <li class="is-active"><a href="#" aria-current="page">Powerline Calculations</a></li>
    </ul>
  </nav>

  <header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Powerline Calculations</h1>
    <h2 class="subtitle has-text-weight-light">Motor - GearBox - Cable Drum - Load</h2>
  </header>


  {{-- EXPLANATORY PICTURES AND TABS --}}
  <div class="card p-4">

    <div class="tabs is-centered">
      <ul>
        <li class="is-active">
          <a wire:click="setPulleyType(1)">
            <span>Direct Lifting</span>
          </a>
        </li>
        
        <li>
          <a wire:click="setPulleyType(2)">
            <span>Load Divided By 2</span>
          </a>
        </li>
      </ul>
    </div>


    <figure class="image {{ $pulleyType === 1 ? '' : ' is-hidden' }}">
    <img src="{{ asset('images/Powerline1.png') }}" />
    </figure>


    <figure class="image {{ $pulleyType === 2 ? '' : ' is-hidden' }}">
    <img src="{{ asset('images/Powerline2.png') }}" />
    </figure>

  </div>



  {{-- PARAMETERS INPUTS --}}
  <div class="card p-6">

    <h1 class="title">Powerline Parameters</h1>

    <div class="columns">

      <div class="column field is-3">

        <span class="tag is-large is-warning">Motor</span>

        <div class="field mt-4">

          <label class="label">Motor Power [W]</label>
          <div class="control">
            <input class="input" type="number" placeholder="Powerin Watts" wire:model.live="motor_power">
          </div>
        </div>

        <div class="field">
          <label class="label">Motor rpm</label>
          <div class="control">
            <input class="input" type="number" placeholder="Tube Lengths" wire:model.live="motor_rpm">
          </div>
        </div>


        <div class="field">

          <label class="label">Motor Type</label>

          <div class="control">

            <div class="select is-fullwidth">
              <select wire:model.live="startTubeNo">

                @foreach ($motor_types as $motor)

                  <option value="{{ $motor["id"] }}">{{ $motor["name"] }}</option>

                @endforeach

              </select>
            </div>

          </div>

        </div>

      </div>


      <div class="column field is-3">


        <span class="tag is-large is-warning">Gearbox</span>

        <div class="field mt-4">
          <label class="label">Reduction Ratio, i</label>
          <div class="control">
            <input class="input" type="number" placeholder="Tube Lengths" wire:model.live="gearbox_reduction_ratio">
          </div>
        </div>

        <div class="field">
          <label class="label">Max Allowable Output Torque [Nm]</label>
          <div class="control">
            <input class="input" type="number" placeholder="Max Torque"
              wire:model.live="gearbox_allowable_max_torque">
          </div>
        </div>

        <div class="field">
          <label class="label">Efficiency [%]</label>
          <div class="control">
            <input class="input" type="number" placeholder="Max Torque" wire:model.live="gearbox_efficiency" min="0"
              max="100" step="1">
          </div>
        </div>

      </div>


      <div class="column field is-3">

        <span class="tag is-large is-warning">Drum</span>

        <div class="field mt-4">
          <input type="checkbox" wire:model="drum_has_gearbox" wire:click="$toggle('drum_has_gearbox')"> Drum Has
          {{ $drum_has_gearbox ? '' : ' No ' }}
          GearBox
        </div>

        <div class="field">
          <label class="label">Drum Diameter [mm]</label>
          <div class="control">
            <input class="input" type="number" placeholder="Drum Diameter" wire:model.live="drum_diameter">
          </div>
        </div>

        <div class="field">
          <label class="label">Drum Wire Diameter [mm]</label>
          <div class="control">
            <input class="input" type="number" placeholder="Wire Diameter" wire:model.live="drum_wire_diameter">
          </div>
        </div>

        @if ($drum_has_gearbox)
          <div class="field">
            <label class="label">Drum GearBox Reduction Ratio, i</label>
            <div class="control">
              <input class="input" type="number" placeholder="Tube Lengths"
                wire:model.live="drum_gearbox_reduction_ratio">
            </div>
          </div>

          <div class="field">
            <label class="label">Drum GearBox Max Allowable Output Torque [Nm]</label>
            <div class="control">
              <input class="input" type="number" placeholder="Max Torque"
                wire:model.live="drum_gearbox_allowable_max_torque">
            </div>
          </div>

          <div class="field">
            <label class="label">Efficiency [%]</label>
            <div class="control">
              <input class="input" type="number" placeholder="Max Torque" wire:model.live="drum_gearbox_efficiency"
                min="0" max="100" step="1">
            </div>
          </div>

        @endif

      </div>


      <div class="column field is-3">

        <span class="tag is-large is-warning">Load</span>

        <div class="field mt-4">
          <label class="label">Weight [kg]</label>
          <div class="control">
            <input class="input" type="number" placeholder="Weight" wire:model.live="load">
          </div>
        </div>

        <div class="field">
          <label class="label">Lift Speed [m/s]</label>
          <div class="control">
            <input class="input" type="number" placeholder="Lift Speed" wire:model.live="lift_speed_target" min="0"
              step="0.1">
          </div>
        </div>

        <div class="field">
          <label class="label">Overall Safety Factor</label>
          <div class="control">
            <input class="input" type="number" placeholder="Safety Factor" wire:model.live="safety_factor" min="1"
              step="0.1">
          </div>
        </div>

      </div>

    </div>

  </div>


  {{-- RESULTS --}}
  <div class="fixed-grid has-4-cols card has-background-white py-3 my-2">

    <div class="grid p-4">

      <div class="cell">

        <table class="table is-fullwidth">

          <tr>
            <td>Motor Output Torque</td>
            <td class="has-text-right">{{ round($motor_max_torque, 1) }} Nm</td>
          </tr>

          <tr>
            <td>Output Angular Velocity</td>
            <td class="has-text-right">{{ round($motor_angular_velocity, 1) }} rad/s</td>
          </tr>

          <tr>
            <td>Output Angular Velocity</td>
            <td class="has-text-right">{{ round($motor_rpm, 1) }} rpm</td>
          </tr>

          <tr>
            <td>Output Power</td>
            <td class="has-text-right">{{ round($motor_power, 1) }} W</td>
          </tr>

        </table>

      </div>

      <div class="cell">


        <table class="table is-fullwidth">

          <tr>
            <td>GearBox Output Torque</td>
            <td
              class="has-text-right {{ $gearbox_output_torque > $gearbox_allowable_max_torque ? 'has-text-danger' : '' }}">
              {{ round($gearbox_output_torque, 1) }} Nm
            </td>
          </tr>

          <tr>
            <td>GearBox Angular Velocity</td>
            <td class="has-text-right">{{ round($gearbox_angular_velocity_rad, 1) }} rad/s</td>
          </tr>

          <tr>
            <td>GearBox Angular Velocity </td>
            <td class="has-text-right">{{ round($gearbox_angular_velocity_rpm, 1) }} rpm</td>
          </tr>

          <tr>
            <td>GearBox Output Power </td>
            <td class="has-text-right">{{ round($gearbox_output_power, 1) }} W</td>
          </tr>

          @if ($gearbox_output_torque > $gearbox_allowable_max_torque)

            <tr>
              <td class="has-text-danger" colspan="2">
                <div class="notification is-danger">
                  Output torque is <strong>greater</strong> than maximum <strong>allowable</strong>
                  torque of gearbox
                </div>
              </td>
            </tr>

          @endif

        </table>


      </div>

      <div class="cell">
        <table class="table is-fullwidth">

          <tr>
            <td>Drum Output Torque</td>
            <td
              class="has-text-right {{ $drum_has_gearbox && $drum_output_torque > $drum_gearbox_allowable_max_torque ? 'has-text-danger' : '' }}">
              {{ round($drum_output_torque, 1) }} Nm
            </td>
          </tr>

          <tr>
            <td>Drum Angular Velocity</td>
            <td class="has-text-right">{{ round($drum_angular_velocity_rad, 1) }} rad/s</td>
          </tr>

          <tr>
            <td>Drum Angular Velocity </td>
            <td class="has-text-right">{{ round($drum_angular_velocity_rpm, 1) }} rpm</td>
          </tr>

          <tr>
            <td>Drum Output Power </td>
            <td class="has-text-right">{{ round($drum_output_power, 1) }} W</td>
          </tr>



          <tr>
            <td>Pull Force<br>Pull Velocity<br>[Wound 1]</td>
            <td class="has-text-right">
              {{ round($drum_pull_force_wound1, 0) }}
              N<br>{{ round($drum_pull_velocity_wound1, 3) }} m/s
            </td>
          </tr>

          <tr>
            <td>Pull Force<br>Pull Velocity<br>[Wound 2]</td>
            <td class="has-text-right">
              {{ round($drum_pull_force_wound2, 0) }} N<br>
              {{ round($drum_pull_velocity_wound2, 3) }} m/s
            </td>
          </tr>
          <tr>
            <td>Pull Force<br>Pull Velocity<br>[Wound 3]</td>
            <td class="has-text-right">
              {{ round($drum_pull_force_wound3, 0) }} N<br>
              {{ round($drum_pull_velocity_wound3, 3) }} m/s
            </td>
          </tr>
          <tr>
            <td>Pull Force<br>Pull Velocity<br>[Wound 4]</td>
            <td class="has-text-right">
              {{ round($drum_pull_force_wound4, 0) }} N<br>
              {{ round($drum_pull_velocity_wound4, 3) }} m/s
            </td>
          </tr>


          @if ($drum_has_gearbox && $drum_output_torque > $drum_gearbox_allowable_max_torque)

            <tr>
              <td class="has-text-danger" colspan="2">
                <div class="notification is-danger">
                  Output torque is <strong>greater</strong> than maximum <strong>allowable</strong>
                  torque of drum gearbox
                </div>
              </td>
            </tr>

          @endif

        </table>
      </div>

      <div class="cell">

          <table class="table is-fullwidth">

            <tr>
              <td class="heading has-text-grey-light">Power Required</td>
              <td class="heading has-text-grey-light has-text-right">Power Available</td>
            </tr>

            <tr>
              <td class="">
                  {{ round($power_required, 0) }} W
              </td>
              <td class="is-pulled-right">
                  <div class="cell tags has-addons">
                    <span class="tag">{{ round($drum_output_power, 0) }} W</span>
                    <span class="tag {{ $drum_output_power > $power_required ? 'is-success' : 'is-danger' }}">{{ $drum_output_power > $power_required ? 'OK' : 'X' }}</span>
                  </div>
              </td>
            </tr>

          </table>

          <table class="table is-fullwidth">

            <tr>
              <td class="heading has-text-grey-light">Force Required</td>
              <td class="heading has-text-grey-light has-text-right">Force Available</td>
            </tr>

            <tr>
              <td class="">
                  {{ round($force_required, 0) }} N
              </td>
              <td class="is-pulled-right">
                  <div class="cell tags has-addons">
                    <span class="tag">{{ round($lift_force_1, 0) }} N</span>
                    <span class="tag {{ $lift_force_1 > $force_required ? 'is-success' : 'is-danger' }}">{{ $lift_force_1 > $force_required ? 'OK' : 'X' }}</span>
                  </div>

                  <div class="cell tags has-addons">
                    <span class="tag">{{ round($lift_force_2, 0) }} N</span>
                    <span class="tag {{ $lift_force_1 > $force_required ? 'is-success' : 'is-danger' }}">{{ $lift_force_2 > $force_required ? 'OK' : 'X' }}</span>
                  </div>

                  <div class="cell tags has-addons">
                    <span class="tag">{{ round($lift_force_3, 0) }} N</span>
                    <span class="tag {{ $lift_force_1 > $force_required ? 'is-success' : 'is-danger' }}">{{ $lift_force_3 > $force_required ? 'OK' : 'X' }}</span>
                  </div>

                  <div class="cell tags has-addons">
                    <span class="tag">{{ round($lift_force_4, 0) }} N</span>
                    <span class="tag {{ $lift_force_1 > $force_required ? 'is-success' : 'is-danger' }}">{{ $lift_force_4 > $force_required ? 'OK' : 'X' }}</span>
                  </div>

              </td>
            </tr>

          </table>
      </div>

  </div>





  {{-- WIRE ROPE CALCULATIONS--}}
  <div class="card p-4">

    <header class="mb-6">
      <h1 class="title has-text-weight-light is-size-1">Steel Wire Rope Minimum Breaking Load Table</h1>
      <h2 class="subtitle has-text-weight-light">Use for Analysis Only</h2>
    </header>

    <table class="table is-fullwidth">

      <tr>
          <td class="is-1/4">
            <div class="message is-info">
              <div class="message-body">
                <p>This table is to be used for structural analysis only. For actual data use the vendor supplied data</p>
                <p>Reference : <a href="www.diepa.de">www.diepa.de</a> </p>
              </div>
            </div>
          </td>

          <td class="is-3/4">

            <p>Following parameters are used to calculate estimated load capacities:</p>

            <div class="tags has-addons">
              <span class="tag">Fill Factor</span>
              <span class="tag is-primary">{{$fillFactor["min"]}} - {{$fillFactor["max"]}}</span>
            </div>

            <div class="tags has-addons">
              <span class="tag">Spinning Load Factor</span>
              <span class="tag is-primary">{{$spinningLoadFactor["min"]}} - {{$spinningLoadFactor["max"]}}</span>
            </div>
          </td>

      </tr> 
    </table>





    <table class="table is-fullwidth">

      <tr>
          <th class="" rowspan="2">Diameter</th>
          <th class="has-text-centered" colspan="{{count($ropeGrades)}}">Rope Grades<br>Minimum Breaking Loads [N] </th>
      </tr>


      <tr>
          @foreach($ropeGrades as $grade)
              <th class="has-text-centered">{{$grade}} N/mm<sup>2</sup></th>
          @endforeach 
      </tr>

      @foreach($ropeLoadCapacity as $diameter => $capacityPerGrades)
          <tr>
              <td >{{ sprintf('%2d', $diameter) }} mm</td>
              @foreach($capacityPerGrades as $capacity)
                  <td class="has-text-centered">{{ $capacity }} N</td>
              @endforeach
          </tr>
      @endforeach

    </table>




  </div>


</section>