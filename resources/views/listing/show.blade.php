@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title">
                @if($game->banner_image !== null)
                    <div class="text-center mb-3">
                        <img src="{{ asset('images/uploads/' . $game->banner_image) }}" class="img-fluid" style="max-height: 60px;" />
                    </div>
                @endif
                <h2>{{ $game->name }} @if(auth()->user() && $game->created_by === auth()->id()) <span class="float-right"><a href="{{ route('front.game.edit', $game) }}" class="btn btn-info">Edit</a> </span> @endif</h2>
                <h4 class="text-muted"><a href="{{ route('listing.out', $game->slug) }}">{{ $game->url }}</a></h4>
            </div>

            <hr>

            <p class="lead">
                {{ $game->description }}
            </p>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h2>Screenshots</h2>

            <div class="text-center">
                @foreach($game->images as $image)
                    <a href="{{ asset('images/uploads/' . $image->filename) }}" data-lightbox="screenshots">
                        <img src="{{ asset('images/uploads/' . $image->filename) }}" class="img-fluid" style="max-height: 90px; max-width: 150px;" />
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart" style="height: 400px;"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('javascript')


    <!-- Core plugin JavaScript-->
    <script src="{{ asset("js/jquery.easing.min.js") }}"></script>
    <script src="{{ asset("js/lightbox.min.js") }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('js/Chart.min.js') }}"></script>

    <script>
        $(document).ready(function () {

            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';
// Area Chart Example
            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($votesIn['labels']),
                    datasets: [{
                        label: "Votes In",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: @json($votesIn['data']),
                    },
                        {
                            label: "Votes Out",
                            lineTension: 0.3,
                            backgroundColor: "rgba(223,38,66,0.05)",
                            borderColor: "rgb(223,38,50)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgb(223,38,50)",
                            pointBorderColor: "rgb(223,38,50)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgb(223,38,50)",
                            pointHoverBorderColor: "rgb(223,38,50)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: @json($votesOut['data']),
                        }]
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: true
                            },
                            ticks: {
                                maxTicksLimit: 20
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 6,
                                padding: 10,
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return number_format(value);
                                }
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: true
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                        callbacks: {
                            label: function (tooltipItem, chart) {
                                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                            }
                        }
                    }
                }
            });
        })
    </script>
@endsection
