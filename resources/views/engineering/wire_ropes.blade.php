<section class="section container">

  <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
    <ul>
      <li><a href='/engineering/home'>Engineering</a></li>
      <li class="is-active"><a href="#" aria-current="page">Steel Wire Rope Minimum Breaking Load Table</a></li>
    </ul>
  </nav>

  <header class="mb-6">
    <h1 class="title has-text-weight-light is-size-1">Steel Wire Rope Minimum Breaking Load Table</h1>
    <h2 class="subtitle has-text-weight-light">Use for Analysis Only</h2>
  </header>







  {{-- WIRE ROPE CALCULATIONS--}}
  <div class="card p-4">

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

            <table class="table is-fullwidth">

            <tr>
                <td class="is-1/2">
                    <div class="tags has-addons">
                    <span class="tag">Fill Factor</span>
                    <span class="tag is-primary">{{$fillFactor["min"]}} - {{$fillFactor["max"]}}</span>
                    </div>
                </td>
    
                <td class="is-1/2">
                    <div class="tags has-addons is-pulled rigth">
                    <span class="tag">Spinning Load Factor</span>
                    <span class="tag is-primary">{{$spinningLoadFactor["min"]}} - {{$spinningLoadFactor["max"]}}</span>
                    </div>
                </td>

            </tr>
            </table>

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