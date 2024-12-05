@extends('layouts.app')

@section('body')
<header class="mb-5">
    <x-main-header title="Rekap Absent" />

    @include('includes.alert')
</header>

<section class="mb-5">
    <div class="grid grid-cols-1 md:grid-cols-2">
      <div class="w-full flex justify-center items-center">
        <div id="chart-rekap-all-type"></div>
      </div>
      <div id="chart-rekap-tahun"></div>
    </div>
</section>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg">
    @livewire('reports.list-absents')
</section>
@endsection


@push('script')
<script>
var options = {
  series: @json(array_values($rekaps)),
  chart: {
    width: 380,
    type: 'pie',
  },
  labels: @json(array_keys($rekaps)),
  responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
};

var chart = new ApexCharts(document.querySelector("#chart-rekap-all-type"), options);
chart.render();
</script>
<script>
var options = {
    series: @json($results),
    chart: {
    type: 'bar',
    height: 350,
    stacked: true,
  },
  plotOptions: {
    bar: {
      horizontal: true,
      dataLabels: {
        total: {
          enabled: true,
          offsetX: 0,
          style: {
            fontSize: '13px',
            fontWeight: 900
          }
        }
      }
    },
  },
  stroke: {
    width: 1,
    colors: ['#fff']
  },
  xaxis: {
    categories: @json($categories)
  },
  yaxis: {
    title: {
      text: undefined
    },
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val + " kasus"
      }
    }
  },
  fill: {
    opacity: 1
  },
  legend: {
    position: 'top',
    horizontalAlign: 'left',
    offsetX: 40
  }
  };

  var chart = new ApexCharts(document.querySelector("#chart-rekap-tahun"), options);
  chart.render();
</script>
@endpush