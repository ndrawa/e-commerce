@extends('layouts.layout')

@section('css_section')

@endsection

@section('page_title')
Aktivitas
@endsection

@section('breadcrumbs')
{{ Breadcrumbs::render('dashboard.activity') }}
@endsection

@section('url_back', url('dashboard'))

@section('content')
<div class="">
    <div class="content-body">
        <div class="row">
            <div class="col-sm">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            {{-- <h4 class="card-title">Special title treatment</h4> --}}
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i data-feather="chevron-down"></i></a></li>
                                    {{-- <li><a data-action="reload"><i data-feather="rotate-cw"></i></a></li> --}}
                                    <li><a data-action="close"><i data-feather="x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show" aria-expanded="true">
                            <div class="card-body">
                                <div id="bar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            {{-- <h4 class="card-title">Special title treatment</h4> --}}
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i data-feather="chevron-down"></i></a></li>
                                    {{-- <li><a data-action="reload"><i data-feather="rotate-cw"></i></a></li> --}}
                                    <li><a data-action="close"><i data-feather="x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show" aria-expanded="true">
                            <div class="card-body">
                                <div id="pie"></div>
                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm">
            </div>
            <div class="col-sm-5">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            {{-- <h4 class="card-title">Special title treatment</h4> --}}
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i data-feather="chevron-down"></i></a></li>
                                    {{-- <li><a data-action="reload"><i data-feather="rotate-cw"></i></a></li> --}}
                                    <li><a data-action="close"><i data-feather="x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show" aria-expanded="true">
                            <div class="card-body">
                                <div id="donut"></div>
                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i data-feather="chevron-down"></i></a></li>
                                    {{-- <li><a data-action="reload"><i data-feather="rotate-cw"></i></a></li> --}}
                                    <li><a data-action="close"><i data-feather="x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show" aria-expanded="true">
                            <div class="card-body">
                                <div id="bar1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js_section')
<script>
    var options = {
        series: [{
                name: "Penelitian Diterima"
                , type: "column"
                , data: [440, 505, 414, 671, 227, 413]
            }
            , {
                name: "Penelitian Ditolak"
                , type: "line"
                , data: [23, 42, 35, 27, 43, 22]
            }
        ]
        , chart: {
            height: 600
            , type: "line"
        }
        , stroke: {
            curve: 'smooth'
            , width: [0, 4]
        }
        , title: {
            text: "Jumlah Penelitian yang Diajukan"
            , align: 'center'
            , style: {
                fontSize: '16px'
                , fontFamily: 'Montserrat'
            }
        , }
        , dataLabels: {
            enabled: true
            , enabledOnSeries: [1]
        }
        , labels: [
            "2017"
            , "2018"
            , "2019"
            , "2020"
            , "2021"
            , "2022"
        ]
        , yaxis: [{
                title: {
                    text: "Penelitian Diterima"
                }
            }
            , {
                opposite: true
                , title: {
                    text: "Penelitian Ditolak"
                }
            }
        ]
    };

    var bar = new ApexCharts(document.querySelector("#bar"), options);

    bar.render();

    var pieoptions = {
        series: [70]
        , chart: {
            height: 350
            , type: "radialBar"
        }
        , title: {
            text: "Rasio Penelitian Diterima dan Ditolak"
            , align: 'center'
            , style: {
                fontSize: "16px"
                , fontFamily: 'Montserrat'
            }
        }
        , plotOptions: {
            radialBar: {
                hollow: {
                    size: "70%"
                }
            }
        }
        , labels: ["Diterima"]
    };

    var pie = new ApexCharts(document.querySelector("#pie"), pieoptions);
    pie.render();

    var pieoptions1 = {
        series: [90]
        , chart: {
            height: 350
            , type: "radialBar"
        }
        , title: {
            text: "Rasio Penelitian Diterima Per Lab"
            , align: 'center'
            , style: {
                fontSize: "16px"
                , fontFamily: 'Montserrat'
            }
        }
        , plotOptions: {
            radialBar: {
                hollow: {
                    size: "70%"
                }
            }
        }
        , labels: ["Diterima Per Lab"]
    };

    var donut = new ApexCharts(document.querySelector("#donut"), pieoptions1);
    donut.render();

    var options2 = {
        chart: {
            height: 600
            , type: 'bar'
        }
        , title: {
            text: "Jumlah Penelitian Diterima Per Lab"
            , align: 'center'
            , style: {
                fontSize: "16px"
                , fontFamily: 'Montserrat'
            }
        }
        , series: [{
            name: "Penelitian Diterima"
            , data: [50, 100, 150, 130, 180, 100, 180, 100]
        }]
        , labels: [
            "Komputer"
            , "Forensic"
            , "Kedokteran"
            , "Farmasi"
            , "Pertanian"
            , "Fisika"
            , "Kimia"
            , "Bisnis"
        ]
        , yaxis: [{
            title: {
                text: "Penelitian Diterima"
            }
        }]
        , plotOptions: {
            bar: {
                distributed: true
            }
        }
    }

    var bar1 = new ApexCharts(document.querySelector("#bar1"), options2);

    bar1.render();

</script>
@endsection
