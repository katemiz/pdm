<div>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">Stats</h1>
        <h2 class="subtitle has-text-weight-light">Let the numbers speak</h2>
    </header>

    <nav class="level">
        <div class="level-item has-text-centered">
          <div>
            <p class="heading">Active Users</p>
            <p class="title">{{ $no_of_users }}</p>
          </div>
        </div>
        <div class="level-item has-text-centered">
          <div>
            <p class="heading">ECNs<br>WIP / Completed</p>
            <p class="title">{{ $no_of_ecns["wip"] .'/'.$no_of_ecns["completed"]}}</p>
          </div>
        </div>
        <div class="level-item has-text-centered">
          <div>
            <p class="heading">Customer Drawings / Sellables</p>
            <p class="title">{{$no_of_sellables}}</p>
          </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
              <p class="heading">Documents</p>
              <p class="title">{{$no_of_documents}}</p>
            </div>
          </div>
        <div class="level-item has-text-centered">
          <div>
            <p class="heading">Components</p>
            <p class="title">{{$no_of_items}}</p>
          </div>
        </div>
      </nav>

      <div>
        <canvas id="myChart" class="card m-6 p-6 has-background-white"></canvas>
      </div>
      
      <script src="{{ asset('/js/charts.js') }}"></script>
      
      <script>
        const ctx = document.getElementById('myChart');

        const data = {
          labels: @json($labels),
          datasets: [
            {
              label: 'Components',
              data: @json($data["item"]),
              borderColor: '#36A2EB',
              backgroundColor: '#36A2EB',
            },
            {
              label: 'Sellables',
              data: @json($data['sellable']),
              borderColor: '#FF6384',
              backgroundColor: '#FF6384',
            },
            {
              label: 'Documents',
              data: @json($data['docs']),
              borderColor: '#CCDDCC',
              backgroundColor: '#CCDDCC',
            }
          ]
        };

        new Chart(ctx, {
          type: 'line',
            data: data
        });
      </script>
</div>
