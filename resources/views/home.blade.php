@extends('master.master')

{{-- @section('page_title','::Beranda') --}}

@section('konten')
<style type="text/css">
    canvas {
      height:250px !important;
    }
</style>

<div class="content-panel-toggler">
  </div>
  <div class="content-i">
    <div class="content-box">
      <div class="row">
        <div class="col-sm-12">

            <div class="row mb-4">
                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="container app-content">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <select class="form-control" name="tahun" onchange="getYear()">
                                            <?= $tahun ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row"><div class="col-11">
                                <h5><center>Event By Month</center></h5>
                            </div>
                            <div class="col-1">
                                <a href="javascript:eventByMonth()" title="Refresh Data"><i class="feather-refresh-cw"></i></a>
                            </div></div>
                        </div>
                        <div class="card-body">
                            <div class="container app-content">
                                <div class="row mt-4 mb-4">
                                    <canvas id="event-month"></canvas>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row"><div class="col-11">
                                <h5><center>Event By Region</center></h5>
                            </div>
                            <div class="col-1">
                                <a href="javascript:eventByRegion()" title="Refresh Data"><i class="feather-refresh-cw"></i></a>
                            </div></div>
                        </div>
                        <div class="card-body">
                            <div class="container app-content">
                                <div class="row mt-4 mb-4">
                                    <canvas id="event-region"></canvas>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>

        </div>
      </div>

    </div>
    <!--------------------
    START - Sidebar
    -------------------->

    <!--------------------
    END - Sidebar
    -------------------->
  </div>
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
@endsection

@section('my-script')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.2.0/dist/chartjs-plugin-datalabels.min.js"></script>

    <script type="text/javascript">
        getYear();
        function getYear() {
            var tahun = $('select[name="tahun"]').val();
            eventByMonth(tahun);
            eventByRegion(tahun);
        }

        var totalEventByMonth = 0;
        var ctxEventMonth = document.getElementById('event-month').getContext('2d');
        var barEventMonth = new Chart(ctxEventMonth, {
            type: 'pie',
            data: {
                labels: ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'],
                datasets: [{
                    label: '',
                    backgroundColor: [],
                    data: []
                }]
            },
            options: {
                tooltips: {
                    enabled: true,
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var labelChartMonth = data.labels[tooltipItem.index];
                            var valChartMonth = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return labelChartMonth + ': ' + valChartMonth + ' (' + (100 * valChartMonth / totalEventByMonth).toFixed(1) + '%)';
                        }
                    }
                },
                plugins: {
                    datalabels: {
                        color: "#ffffff",
                        font: {
                            weight: 'bold',
                            size: 14,
                        },
                        formatter: (val) => {
                            let persen = (100 * val / totalEventByMonth).toFixed(1);
                            return val+' ('+persen+'%)';
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        function eventByMonth(tahun) {
            $.ajax({
                type: "POST",
                url: '{{ route('home.eventByMonth') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    tahun: tahun
                },
                dataType: 'json',
                success: function(data) {
                    let dataChart = [];
                    let colorChart = [];
                    totalEventByMonth = 0;
                    for(let i=0; i<data.length; i++) {
                        dataChart.push(data[i]);
                        totalEventByMonth += data[i];
                        colorChart.push(getRandomColor(i));
                    }
                    barEventMonth.data.datasets[0].data = dataChart;
                    barEventMonth.data.datasets[0].backgroundColor = colorChart;
                    barEventMonth.update();
                }
            });
        }

        var totalEventByRegion = 0;
        var ctxEventRegion = document.getElementById('event-region').getContext('2d');
        var barEventRegion = new Chart(ctxEventRegion, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    backgroundColor: [],
                    data: []
                }]
            },
            options: {
                tooltips: {
                    enabled: true,
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var labelChartRegion = data.labels[tooltipItem.index];
                            var valChartRegion = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return labelChartRegion + ': ' + valChartRegion + ' (' + (100 * valChartRegion / totalEventByRegion).toFixed(1) + '%)';
                        }
                    }
                },
                plugins: {
                    datalabels: {
                        color: "#ffffff",
                        font: {
                            weight: 'bold',
                            size: 14,
                        },
                        formatter: (val) => {
                            let persen = (100 * val / totalEventByRegion).toFixed(1);
                            return val+' ('+persen+'%)';
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        function eventByRegion(tahun) {
            $.ajax({
                type: "POST",
                url: '{{ route('home.eventByRegion') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    tahun: tahun
                },
                dataType: 'json',
                success: function(data) {
                    let labelChart = [];
                    let dataChart = [];
                    let colorChart = [];
                    totalEventByRegion = 0;
                    for(let i=0; i<data.length; i++) {
                        labelChart.push(data[i][0]);
                        dataChart.push(data[i][1]);
                        totalEventByRegion += data[i][1];
                        colorChart.push(getRandomColor(i));
                    }
                    barEventRegion.data.labels = labelChart;
                    barEventRegion.data.datasets[0].data = dataChart;
                    barEventRegion.data.datasets[0].backgroundColor = colorChart;
                    barEventRegion.update();
                }
            });
        }

        function getRandomColor(index) {
            let color = ['#FA8C05','#AA00FF','#2962FF','#00C853','#C6FF00','#FFD600','#00E5FF','#A3A19E','#FF00E6','#FF0000','#FF1493','#E6E6FA'];

            return color[index];
        }
    </script>
@endsection
