<section class="mx-auto bg-white-100">

  <livewire:header type="Hero" title="Stats" subtitle="Let the numbers speak"/>

  <div class="grid grid-cols-3 gap-4">
    @foreach ($stat_data as $item)
      <livewire:stat-card :title="$item['title']" :data="$item['data']" :img="$item['img']" :content="$item['content']"/>
    @endforeach
  </div>

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
</section>