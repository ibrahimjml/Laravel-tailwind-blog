<x-layout>
<main class="admin w-screen  grid grid-cols-[25%,75%] overflow-hidden transition-all ease-in-out duration-300 p-5">
<x-admin-sidebar/>
  <section id="main-section" class=" p-5 transition-all ease-in-out duration-300 ">
  
    <div class="top-section flex gap-5">
      <span id="spn" class="text-4xl text-gray-400  cursor-pointer">&leftarrow;</span>
      <h2 id="title-body" class="text-black text-2xl font-bold p-3">Admin Panel</h2>
    </div>
    {{-- widgets sections --}}
    <div class="flex flex-wrap gap-2 md:flex-nowrap items-center ">
      <x-widgets-posts 
      :posts="$post" 
      :hashtags="$hashtags"
      :likes="$likes"
      :comments="$comments"/>
      <x-widgets-users :users="$user" :blocked="$blocked"/>
    </div>
{{-- filter by year --}}
<div class="flex justify-end mt-2">
  <form method="GET" action="{{ route('admin-page') }}" class="mb-4">
      <label for="year" class="font-bold text-gray-700">Filter by Year:</label>
      <select name="year" id="year" onchange="this.form.submit()" class="p-2 border rounded-md ml-2">
          @for ($i = now()->year; $i >= 2020; $i--)
              <option value="{{ $i }}" {{ request('year', now()->year) == $i ? 'selected' : '' }}>
                  {{ $i }}
              </option>
          @endfor
      </select>
  </form>
</div>

{{-- chart  container --}}
<div class="flex gap-4">
  <div id="container1"></div>
  <div id="container2"></div>
</div>

  </section>
</main>
@push('scripts')
<script>
var datakeys = @json(array_keys($registeredusers));
var datavalues = @json(array_values($registeredusers));
var selectedYear = @json(request('year', now()->year));

  Highcharts.chart('container1', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Number of Registered Users '+ selectedYear
    },
  
    xAxis: {
        categories: datakeys,
        crosshair: true,
        accessibility: {
            description: 'Months'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Users'
        }
    },
    tooltip: {
        valueSuffix: ' Users'
    },
    plotOptions: {
        column: {
          pointPadding: 0, 
          borderWidth: 0,
          pointWidth: 50      
        }
    },
    series: [
        {
            name: 'Users',
            data: datavalues,
            color: '#6B7280'
        }
      
    ]
});
</script>

<script>
var datakeys = @json(array_keys($numberofposts));
var datavalues = @json(array_values($numberofposts));
var selectedYear = @json(request('year', now()->year));

  Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Number of Posts '+ selectedYear
    },
  
    xAxis: {
        categories: datakeys,
        crosshair: true,
        accessibility: {
            description: 'Months'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Posts'
        }
    },
    tooltip: {
        valueSuffix: ' Posts'
    },
    plotOptions: {
        column: {
          pointPadding: 0, 
          borderWidth: 0,
          pointWidth: 50      
        }
    },
    series: [
        {
            name: 'Posts',
            data: datavalues,
            color: '#6B7280'
        }
      
    ]
});
</script>
@endpush
</x-layout>
