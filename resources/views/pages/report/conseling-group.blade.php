@extends('layouts.app')

@section('body')
<header class="mb-5">
    <x-main-header title="Rekap Bimbingan Konseling Kelompok" />

    @include('includes.alert')
</header>

<div id="chart"></div>


<section class="w-full p-4 border border-gray-100 shadow rounded-lg">
    @livewire('reports.list-conselings-group')
</section>
@endsection

@push('script')
<script>
var options = {
    series: @json($results),
        chart: {
        type: 'bar',
        height: 350
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            borderRadius: 5,
            borderRadiusApplication: 'end'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', "Nov", "Des"],
    },
    fill: {
        opacity: 1
    },
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();
</script>
@endpush