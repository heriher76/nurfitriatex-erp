@extends('layouts.admin')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@push('script-page')
    <script>
        (function() {

            var optionsCost = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total Cost',
                    data: {!! json_encode(array_values($home_data['totalCostByMonth'])) !!}
                }, ],
                xaxis: {
                    categories: {!! json_encode(array_keys($home_data['totalCostByMonth'])) !!},
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartCost = new ApexCharts(document.querySelector("#chart_cost"), optionsCost);
            chartCost.render();

            var optionsHargaKains = {
                chart: {
                    height: 380,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total ',
                    data: {!! json_encode(array_values($home_data['harga_kains'])) !!}
                }, ],
                xaxis: {
                    categories: {!! json_encode(array_keys($home_data['harga_kains'])) !!},
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartHargaKains = new ApexCharts(document.querySelector("#chart_harga_kains"), optionsHargaKains);
            chartHargaKains.render();

            var optionsHargaTintas = {
                chart: {
                    height: 380,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total ',
                    data: {!! json_encode(array_values($home_data['harga_tintas'])) !!}
                }, ],
                xaxis: {
                    categories: {!! json_encode(array_keys($home_data['harga_tintas'])) !!},
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartHargaTintas = new ApexCharts(document.querySelector("#chart_harga_tintas"), optionsHargaTintas);
            chartHargaTintas.render();

            var optionsHargaKertass = {
                chart: {
                    height: 380,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total ',
                    data: {!! json_encode(array_values($home_data['harga_kertass'])) !!}
                }, ],
                xaxis: {
                    categories: {!! json_encode(array_keys($home_data['harga_kertass'])) !!},
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartHargaKertass = new ApexCharts(document.querySelector("#chart_harga_kertass"), optionsHargaKertass);
            chartHargaKertass.render();

            var optionsBudget = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total Budget',
                    data: {!! json_encode(array_values($home_data['totalBudgetByMonth'])) !!}
                }, ],
                xaxis: {
                    categories: {!! json_encode(array_keys($home_data['totalBudgetByMonth'])) !!},
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartBudget = new ApexCharts(document.querySelector("#chart_budget"), optionsBudget);
            chartBudget.render();

            var optionsEfisiensi = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total Efisiensi',
                    data: {!! json_encode(array_values($home_data['totalEfisiensiByMonth'])) !!}
                }, ],
                xaxis: {
                    categories: {!! json_encode(array_keys($home_data['totalEfisiensiByMonth'])) !!},
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartEfisiensi = new ApexCharts(document.querySelector("#chart_efisiensi"), optionsEfisiensi);
            chartEfisiensi.render();

            var optionsKains = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total ',
                    data: {!! json_encode(array_values($home_data['kainsByMonth'])) !!}
                }, ],
                xaxis: {
                    categories: {!! json_encode(array_keys($home_data['kainsByMonth'])) !!},
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartKains = new ApexCharts(document.querySelector("#chart_kains"), optionsKains);
            chartKains.render();

            var optionsTintas = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total ',
                    data: {!! json_encode(array_values($home_data['tintasByMonth'])) !!}
                }, ],
                xaxis: {
                    categories: {!! json_encode(array_keys($home_data['tintasByMonth'])) !!},
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartTintas = new ApexCharts(document.querySelector("#chart_tintas"), optionsTintas);
            chartTintas.render();

            var optionsKertass = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Total ',
                    data: {!! json_encode(array_values($home_data['kertassByMonth'])) !!}
                }, ],
                xaxis: {
                    categories: {!! json_encode(array_keys($home_data['kertassByMonth'])) !!},
                },
                colors: ['#fff'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chartKertass = new ApexCharts(document.querySelector("#chart_kertass"), optionsKertass);
            chartKertass.render();

            @foreach ($home_data['pertintasByMonth'] as $key => $tinta)
                var optionsTintas{{ str_replace(' ', '', $key) }} = {
                    chart: {
                        height: 180,
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: [{
                        name: 'Total ',
                        data: {!! json_encode(array_values($home_data['pertintasByMonth'][$key])) !!}
                    }, ],
                    xaxis: {
                        categories: {!! json_encode(array_keys($home_data['pertintasByMonth'][$key])) !!},
                    },
                    colors: ['#fff'],
                    fill: {
                        type: 'solid',
                    },
                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'right',
                    },
                    // markers: {
                    //     size: 4,
                    //     colors: ['#3ec9d6', '#FF3A6E',],
                    //     opacity: 0.9,
                    //     strokeWidth: 2,
                    //     hover: {
                    //         size: 7,
                    //     }
                    // }
                };
                var chartTintas{{ str_replace(' ', '', $key) }} = new ApexCharts(document.querySelector(
                        "#chart_penggunaan_tintas{{ str_replace(' ', '', $key) }}"),
                    optionsTintas{{ str_replace(' ', '', $key) }});
                chartTintas{{ str_replace(' ', '', $key) }}.render();
            @endforeach

            @foreach ($home_data['perkertassByMonth'] as $key => $kertas)
                var optionsKertass{{ str_replace(' ', '', $key) }} = {
                    chart: {
                        height: 180,
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: [{
                        name: 'Total ',
                        data: {!! json_encode(array_values($home_data['perkertassByMonth'][$key])) !!}
                    }, ],
                    xaxis: {
                        categories: {!! json_encode(array_keys($home_data['perkertassByMonth'][$key])) !!},
                    },
                    colors: ['#fff'],
                    fill: {
                        type: 'solid',
                    },
                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'right',
                    },
                    // markers: {
                    //     size: 4,
                    //     colors: ['#3ec9d6', '#FF3A6E',],
                    //     opacity: 0.9,
                    //     strokeWidth: 2,
                    //     hover: {
                    //         size: 7,
                    //     }
                    // }
                };
                var chartKertass{{ str_replace(' ', '', $key) }} = new ApexCharts(document.querySelector(
                        "#chart_penggunaan_kertass{{ str_replace(' ', '', $key) }}"),
                    optionsKertass{{ str_replace(' ', '', $key) }});
                chartKertass{{ str_replace(' ', '', $key) }}.render();
            @endforeach

            @foreach ($home_data['perkainsByMonth'] as $key => $kains)
                var optionsKains{{ preg_replace('/[^a-zA-Z0-9\s]/', '', str_replace(' ', '', $key)) }} = {
                    chart: {
                        height: 180,
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: [{
                        name: 'Total ',
                        data: {!! json_encode(array_values($home_data['perkainsByMonth'][$key])) !!}
                    }, ],
                    xaxis: {
                        categories: {!! json_encode(array_keys($home_data['perkainsByMonth'][$key])) !!},
                    },
                    colors: ['#fff'],
                    fill: {
                        type: 'solid',
                    },
                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'right',
                    },
                    // markers: {
                    //     size: 4,
                    //     colors: ['#3ec9d6', '#FF3A6E',],
                    //     opacity: 0.9,
                    //     strokeWidth: 2,
                    //     hover: {
                    //         size: 7,
                    //     }
                    // }
                };
                var chartKains{{ preg_replace('/[^a-zA-Z0-9\s]/', '', str_replace(' ', '', $key)) }} = new ApexCharts(
                    document.querySelector(
                        "#chart_penggunaan_kains{{ preg_replace('/[^a-zA-Z0-9\s]/', '', str_replace(' ', '', $key)) }}"
                    ),
                    optionsKains{{ preg_replace('/[^a-zA-Z0-9\s]/', '', str_replace(' ', '', $key)) }});
                chartKains{{ preg_replace('/[^a-zA-Z0-9\s]/', '', str_replace(' ', '', $key)) }}.render();
            @endforeach
        })();
    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Material') }}</li>
@endsection
@section('content')
    <div class="row">
        <h5>
            <span class="float-end">
                <form action="{{ url('material-dashboard') }}" method="GET" id="formProjectDashboard">
                    <select name="filter-pcs" id="filter-pcs" class="form-control"
                        onchange="$('#formProjectDashboard').submit();">
                        <option value="tahunan" @if (request()->get('filter-pcs') == 'tahunan') selected @endif>Tahunan
                        </option>
                        <option value="bulanan" @if (request()->get('filter-pcs') == 'bulanan') selected @endif>Bulanan
                        </option>
                        <option value="mingguan" @if (request()->get('filter-pcs') == 'mingguan') selected @endif>Mingguan
                        </option>
                    </select>
                </form>
            </span>
        </h5>
        <hr>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Kain') }}</h5>
                </div>
                <div class="card-body project_table">

                    <div id="chart_kains"></div>
                    <br>
                    <div class="table-responsive">
                        <div id="chart_harga_kains"></div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Kertas') }}</h5>
                </div>
                <div class="card-body project_table">

                    <div id="chart_kertass"></div>
                    <br>
                    <div class="table-responsive">
                        <div id="chart_harga_kertass"></div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Tinta') }}</h5>
                </div>
                <div class="card-body project_table">

                    <div id="chart_tintas"></div>
                    <br>
                    <div class="table-responsive">
                        <div id="chart_harga_tintas"></div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Penggunaan Kain') }}</h5>
                </div>
                <div class="card-body project_table">

                    @foreach ($home_data['perkainsByMonth'] as $key => $kain)
                        <b>{{ $key }}</b>
                        <div
                            id="chart_penggunaan_kains{{ preg_replace('/[^a-zA-Z0-9\s]/', '', str_replace(' ', '', $key)) }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Penggunaan Kertas') }}</h5>
                </div>
                <div class="card-body project_table">

                    @foreach ($home_data['perkertassByMonth'] as $key => $kertas)
                        <b>{{ $key }}</b>
                        <div id="chart_penggunaan_kertass{{ str_replace(' ', '', $key) }}"></div>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Penggunaan Tinta') }}</h5>
                </div>
                <div class="card-body project_table">

                    @foreach ($home_data['pertintasByMonth'] as $key => $tinta)
                        <b>{{ $key }}</b>
                        <div id="chart_penggunaan_tintas{{ str_replace(' ', '', $key) }}"></div>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Total Cost (Rp/Monthly)') }}
                    </h5>

                </div>
                <div class="card-body">
                    <div id="chart_cost"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Total Income (Rp/Monthly)') }}
                    </h5>

                </div>
                <div class="card-body">
                    <div id="chart_budget"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Total Efisiensi (Rp/Monthly)') }}
                    </h5>

                </div>
                <div class="card-body">
                    <div id="chart_efisiensi"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
        </div>
    </div>
@endsection
