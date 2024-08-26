<section class="flex flex-col mx-auto gap-4">

  <livewire:header type="Section" title="Stats" subtitle="Let the numbers speak"/>

  <div class="flex flex-col md:flex-row gap-4 w-full">

    <div class="w-full md:w-1/3">
        <livewire:stat-card :title="$stat_data[0]['title']" :data="$stat_data[0]['data']" :img="$stat_data[0]['img']" :content="$stat_data[0]['content']"/>
    </div>

    <div class="w-full md:w-1/3">
        <livewire:stat-card :title="$stat_data[1]['title']" :data="$stat_data[1]['data']" :img="$stat_data[1]['img']" :content="$stat_data[1]['content']"/>
    </div>

    <div class="w-full md:w-1/3">
        <livewire:stat-card :title="$stat_data[2]['title']" :data="$stat_data[2]['data']" :img="$stat_data[2]['img']" :content="$stat_data[2]['content']"/>
    </div>

  </div>


  <div class="flex flex-col md:flex-row gap-4 w-full md:w-2/3 mx-auto">

    <div class="w-full md:w-1/2">
        <livewire:stat-card :title="$stat_data[3]['title']" :data="$stat_data[3]['data']" :img="$stat_data[3]['img']" :content="$stat_data[3]['content']"/>
    </div>

    <div class="w-full md:w-1/2">
        <livewire:stat-card :title="$stat_data[4]['title']" :data="$stat_data[4]['data']" :img="$stat_data[4]['img']" :content="$stat_data[4]['content']"/>
    </div>

  </div>


  <div class="p-6 bg-lime-50 shadow-lg rounded-lg">
    <canvas id="myChart" ></canvas>
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
          borderColor: '#7f1d1d',
          backgroundColor: '#ef4444',
        },
        {
          label: 'Sellables',
          data: @json($data['sellable']),
          borderColor: '#3f6212',
          backgroundColor: '#22c55e',
        },
        {
          label: 'Documents',
          data: @json($data['docs']),
          borderColor: '#1e40af',
          backgroundColor: '#6366f1',
        }
      ]
    };

    new Chart(ctx, {
      type: 'line',
        data: data
    });
  </script>
</section>
