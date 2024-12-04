@extends('layouts.app')

@section('body')
<header class="mb-5">
    <x-main-header title="Rekap Absent" />

    @include('includes.alert')
</header>

<section>
    <div id="chart"></div>
</section>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg">
    @livewire('reports.list-absents')
</section>
@endsection


@push('script')
<script>
var options = {
    series: @json($results),
    chart: {
        height: 350,
        type: 'line',
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'straight'
    },
    grid: {
        row: {
        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
        opacity: 0.5
        },
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', "Nov", "Des"],
    }
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();
</script>
@endpush