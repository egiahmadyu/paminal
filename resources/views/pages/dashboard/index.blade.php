@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        #chartdiv, #chartDonat {
            width: 100%;
            height: 500px;
            color: #ffffff
        }

        #chartBubble {
            width: 100%;
            max-width: 100%;
            height: 550px;
            #ffffff
        }

        /* #chartdiv, #chartDonat, #chartBubble {
            
        } */
    </style>
@endprepend


@section('content')
    {{-- <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active"><a href="/">DASHBOARD</a></li>
        </ol>
    </nav> --}}

    <center>
        <span class="logo-lg">
            <img src="/assets/images/Tagline-Propam.png" alt="" height="50">
        </span>
    </center>

    <div class="row mb-3">
        <div class="col-lg-4 col-sm-6">
            <div class="card-box bg-gradient" style="background: #011a7d">
                <div class="inner">
                    <h1 style="color: white"> {{ isset($pelanggar) ? count($pelanggar) : 0 }} </h1>
                    <h5 style="color: white"> TOTAL DUMAS </h5>
                </div>
                <div class="icon">
                    <i class="fa fa-gavel f-left" aria-hidden="true"></i>
                </div>
                <a href="/data-kasus" class="card-box-footer"><h6 style="color: white">Lihat Selengkapnya <i class="fa fa-arrow-circle-right"></i></h6></a>
            </div>
        </div>
        
        <div class="col-lg-4 col-sm-6">
            <div class="card-box bg-gradient" style="background: #fab005">
                <div class="inner">
                    <h1 style="color: white"> {{ $pengaduan_diproses }} </h1>
                    <h5 style="color: white"> TOTAL PENGADUAN DIPROSES </h5>
                </div>
                <div class="icon">
                    <i class="fa fa-sync-alt fa-spin" aria-hidden="true"></i>
                </div>
                <a href="/data-kasus" class="card-box-footer"> <h6 style="color: white"> Lihat Selengkapnya <i class="fa fa-arrow-circle-right"></i> </h6></a>
            </div>
        </div>

        <div class="col-lg-4 col-sm-6">
            <div class="card-box bg-gradient" style="background: #fa3605">
                <div class="inner">
                    <h1 style="color: white"> {{ isset($poldas) ? count($poldas) : 0 }} </h1>
                    <h5 style="color: white"> JUMLAH POLDA </h5>
                </div>
                <div class="icon">
                    <i class="fa fa-landmark"></i>
                </div>
                <a href="#" class="card-box-footer"> <h6 style="color: white"> Lihat Selengkapnya <i class="fa fa-arrow-circle-right"></i> </h6></a>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-4 col-sm-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1" id="count_status_dumas">
                            <p class="text-uppercase fw-medium text-muted text-truncate fs-13">STATUS DUMAS</p>
                            <h4 class="fs-22 fw-bold mb-3"><span class="counter-value" data-target="{{$dumas_terbukti}}">0</span></h4>
                        </div>
                        <div class="avatar-sm flex-grow-0">
                            <span class="avatar-title bg-gradient border-success rounded fs-3 mb-3" style="background: #011a7d">
                                <i class="far fa-clipboard-list"></i>
                            </span>
                        </div>
                    </div>
                    <select class="form-select" id="status_dumas" data-placeholder="Bulanan" style="border:none;">
                        <option value="terbukti">TERBUKTI</option>
                        <option value="tidak_terbukti">TIDAK TERBUKTI</option>
                        <option value="rj">RESTORATIVE JUSTICE (RJ)</option>
                        <option value="diproses">DIPROSES</option>
                    </select>
                </div><!-- end card body -->
                <div class="animation-effect-6 opacity-25 fs-18">
                    <i class="far fa-star"></i>
                </div>
                <div class="animation-effect-4 opacity-25 fs-18">
                    <i class="far fa-thumbtack"></i>
                </div>
                <div class="animation-effect-3 opacity-25 fs-18">
                    <i class="far fa-book"></i>
                </div>
            </div><!-- end card -->
        </div>

        <div class="col-lg-4 col-sm-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1" id="count_limpah_polda">
                            <p class="text-uppercase fw-medium text-muted text-truncate fs-13">LIMPAH POLDA</p>
                            <h4 class="fs-22 fw-bold mb-3"><span class="counter-value" data-target="{{$limpah_polda}}">0</span></h4>
                        </div>
                        <div class="avatar-sm flex-grow-0">
                            <span class="avatar-title bg-gradient border-success rounded fs-3 mb-3" style="background: #fab005">
                                <i class="far fa-landmark"></i>
                            </span>
                        </div>
                    </div>
                    <select class="form-select" id="limpah_polda" data-placeholder="Bulanan" style="border:none">
                        @foreach ( $poldas as $polda)
                            <option value="{{ $polda->id }}">{{ $polda->name }}</option>
                        @endforeach
                    </select>
                </div><!-- end card body -->
                <div class="animation-effect-6 opacity-25 fs-18">
                    <i class="far fa-share-alt"></i>
                </div>
                <div class="animation-effect-4 opacity-25 fs-18">
                    <i class="far fa-pencil-alt"></i>
                </div>
                <div class="animation-effect-3 opacity-25 fs-18">
                    <i class="fas fa-sync-alt"></i>
                </div>
            </div><!-- end card -->
        </div>

        <div class="col-lg-4 col-sm-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1" id="count_limpah_den">
                            <p class="text-uppercase fw-medium text-muted text-truncate fs-13">JUMLAH PELIMPAHAN</p>
                            <h4 class="fs-22 fw-bold mb-3"><span class="counter-value" data-target="{{ $pelimpahan }}">0</span></h4>
                        </div>
                        <div class="avatar-sm flex-grow-0">
                            <span class="avatar-title bg-gradient border-success rounded fs-3 mb-3" style="background: #fa3605">
                                <i class="far fa-share-square"></i>
                            </span>
                        </div>
                    </div>
                    <select class="form-select" id="limpah_den">
                        @foreach ($bid_binpam as $bb)
                            <option value="{{$bb['name']}}">{{ $bb['name'] }}</option>
                        @endforeach
                    </select>
                </div><!-- end card body -->
                <div class="animation-effect-6 opacity-25 fs-18">
                    <i class="far fa-dice-d6"></i>
                </div>
                <div class="animation-effect-4 opacity-25 fs-18">
                    <i class="far fa-toolbox"></i>
                </div>
                <div class="animation-effect-3 opacity-25 fs-18">
                    <i class="far fa-fan"></i>
                </div>
            </div><!-- end card -->
        </div>
    </div>

    <div class="row mb-3">
        

        <div class="col-lg-12">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-header">
                    <h3>
                        REKAP DUMAS TRIWULAN
                    </h3>
                </div>
                <div class="card-body">
                    {{-- <select class="form-select mb-4" id="rekap_dumas" select-one>
                        <option value="q">Triwulan</option>
                        <option value="s">Semester</option>
                    </select> --}}
                    <div class="row">
                        <div class="col-3">
                            <div class="flex-grow-1">
                                <div id="chartDonatDumas"></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="flex-grow-1">
                                <div id="chartDonatDumas1"></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="flex-grow-1">
                                <div id="chartDonatDumas2"></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="flex-grow-1">
                                <div id="chartDonatDumas3"></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            <div class="card card-animate">
                <div class="card-header">
                    <h3>
                        REKAP DUMAS SEMESTER
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="flex-grow-1">
                                <div id="chartSemester1"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="flex-grow-1">
                                <div id="chartSemester2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <div class="col-lg-12">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-header">
                    <h3>REKAP DUMAS TAHUNAN</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <div id="chartDumas"></div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>

    <!-- Line Chart -->
    <div class="row mb-3">
        

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card card-animate">
                <div class="card-header">
                    <h2>GRAFIK DUMAS</h2>
                </div>
                <div class="card-body">
                    <div id="chartTrend"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card card-animate">
                <div class="card-header">
                    <h2>STATISTIK DUMAS PERBULAN</h2>
                </div>
                <div class="card-body">
                    <div id="chartKolom"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card card-animate">
                <div class="card-header">
                    <h2>GRAFIK PENYELESAIAN DUMAS</h2>
                </div>
                <div class="card-body">
                    <div id="chartKolomPenyelesaian"></div>
                </div>
            </div>
        </div>
        
    </div>
    
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Resources -->
    
    <script>
        $(document).ready(function() {
            getChartAjax('rekap_dumas')
            getChartAjax('trend_dumas')
            getChartAjax('statistik_bulanan')

            $('#rekap_dumas').on('change', function() {
                getChartAjax('rekap_dumas', this.value)
            });

            $('#status_dumas').on('change', function() {
                getDataAjax('status_dumas', this.value)
            });

            $('#limpah_polda').on('change', function() {
                getDataAjax('limpah_polda', this.value)
            });

            $('#limpah_den').on('change', function() {
                getDataAjax('limpah_den', this.value)
            });
            
        });

        async function getChartAjax(tipe,value) {
            return $.ajax({
                url : '/get-chart/'+tipe,
                type: 'GET',
                dataType: 'json',
                data : {
                    value: value
                },
                beforeSend: function () {
                    $('.loading').css('display', 'block')
                }, 
                success: function (data, status, xhr) {
                    $('.loading').css('display', 'none')
                    if (tipe == 'trend_dumas') {
                        chartTrend(data.data)
                    } else if (tipe == 'statistik_bulanan') {
                        chartKolom(data.data)
                        chartKolomPenyelesaian(data.data)
                    } else if (tipe == 'rekap_dumas') {
                        chartDumas(data.data.tahunan)
                        chartDonatDumas(data.data)
                    }
                    
                },
                error: function (jqXhr, textStatus, errorMessage) { // error callback
                    $('.loading').css('display', 'none')
                    var option = {
                        title: 'Error',
                        text: 'Terjadi Kesalahan Sistem...',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }
                    Swal.fire(option) 
                    // window[onerror](errorMessage);
                }
            })
        }

        async function getDataAjax(tipe, value) {
            return $.ajax({
                url : 'get-data/'+tipe,
                type: 'GET',
                dataType: 'json',
                data : {
                    value: value
                },
                beforeSend: function () {
                    $('.loading').css('display', 'block')
                }, 
                success: function (data, status, xhr) {
                    $('.loading').css('display', 'none')
                    let html = '<h4 class="fs-22 fw-bold mb-3"><span class="counter-value">'+data.data+'</span></h4>'
                    if (tipe == 'status_dumas') {
                        $('#count_status_dumas > h4').remove()
                        $('#count_status_dumas').append(html)
                    } else if (tipe == 'limpah_polda') {
                        $('#count_limpah_polda > h4').remove()
                        $('#count_limpah_polda').append(html)
                    } else {
                        $('#count_limpah_den > h4').remove()
                        $('#count_limpah_den').append(html)
                    }
                },
                error: function (jqXhr, textStatus, errorMessage) { // error callback
                    $('.loading').css('display', 'none')
                    var option = {
                        title: 'Error',
                        text: 'Terjadi Kesalahan Sistem...',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }
                    Swal.fire(option) 
                }
            })
        }

        async function postDataAjax(url) {
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: form,
                beforeSend: function () {
                    $('.loading').css('display', 'block')
                }, success: function (data, status, xhr) {   // success callback function
                    $('.loading').css('display', 'none')
                    // window[onsuccess](data);
                    // $('p').append(data.firstName + ' ' + data.middleName + ' ' + data.lastName);
                },
                error: function (jqXhr, textStatus, errorMessage) { // error callback
                    $('.loading').css('display', 'none')
                    var option = {
                        text: "Terjadi Kesalahan Pada Sistem!",
                        pos: 'top-center',
                        backgroundColor: '#e7515a'
                    }
                    Snackbar.show(option);
                    window[onerror](errorMessage);
                }
            })
        }

        function chartTrend(data) {

            let res = []
            for (let i in data) {
                let res_temp = []
                for (let x in data[i]) {
                    res_temp.push(data[i][x]);
                }
                res.push(res_temp)
            }

            var options = {
                series: [
                    {
                        name: "Kode Etik",
                        data: res[0]
                    },
                    {
                        name: "Disiplin",
                        data: res[1]
                    },
                ],
                chart: {
                    height: 350,
                    type: 'bar',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: true
                    }
                },
                colors: ['#2056d4', '#e3b40b'],
                dataLabels: {
                    enabled: true,
                },
                stroke: {
                    curve: 'monotoneCubic',
                    lineCap: 'butt',
                },
                title: {
                    text: 'TREND PELANGGARAN DUMAS',
                    align: 'center'
                },
                grid: {
                    // borderColor: '#e7e7e7',
                    row: {
                        // colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                markers: {
                    size: 1
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    title: {
                        text: 'Bulan'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Dumas'
                    },
                    min: 0,
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'left',
                    // floating: false,
                    offsetY: 10,
                }
            };

            var chart = new ApexCharts(document.querySelector("#chartTrend"), options);
            chart.render();
        }

        function chartDumas(data) {

            let value = Object.values(data[0]);
            let label = Object.values(data[1]);

            var options = {
                series: [
                    {
                        data: value
                    },
                ],
                chart: {
                    type: 'bar',
                    height: 350
                },
                title: {
                    text: 'REKAP DUMAS',
                    align: 'center'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
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
                    categories: label,
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Dumas'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " dumas"
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chartDumas"), options);
            chart.render();
        }

        function chartKolom(data) {
            let res = []
            for (let i in data) {
                let res_temp = []
                for (let x in data[i]) {
                    res_temp.push(data[i][x]);
                }
                res.push(res_temp)
            }
            
            var options = {
                series: [
                    {
                        name: 'DITERIMA',
                        data: res[1]
                    }, 
                    {
                        name: 'DIPROSES',
                        data: res[0]
                    }, 
                    {
                        name: 'SELESAI',
                        data: res[2]
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
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
                    categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov', 'Des'],
                },
                yaxis: {
                    title: {
                        text: 'JUMLAH DUMAS'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chartKolom"), options);
            chart.render();
        }

        function chartKolomPenyelesaian(data) {
            let res = []
            for (let i in data) {
                let res_temp = []
                for (let x in data[i]) {
                    res_temp.push(data[i][x]);
                }
                res.push(res_temp)
            }

            let value = Object.values(data.selesai);

            console.log(value)
            
            var options = {
                series: [
                    {
                        name: 'SELESAI',
                        data: value
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
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
                    categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov', 'Des'],
                },
                yaxis: {
                    title: {
                        text: 'JUMLAH DUMAS'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chartKolomPenyelesaian"), options);
            chart.render();
        }

        function chartDonatDumas(data) {
            $('#chartDonatDumas').html('');

            showSemester(data.semester)
            showTriwulan(data.triwulan)

        }

        function showSemester(data) {

            let value = Object.values(data[0]);
            let label = Object.values(data[1]);

            var optSemester1 = {
                series: [value[0],value[1]],
                labels: [label[0],label[1]],
                colors: ['#fca103','#635b4c'],
                noData: {
                    text: 'Loading...'
                },
                chart: {
                    type: 'donut',
                    animate: true,
                    height: 500
                },
                legend: {
                    show: false
                },
                title: {
                    text: 'SEMESTER 1',
                    align: 'center'
                },
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
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    label:'TOTAL SEMESTER 1',
                                    showAlways: true,
                                    show: true,
                                    formatter: function () {
                                        return value[0] == 0 ? 0 : value[0]
                                    }
                                }
                            }
                        }
                    }
                },

            };

            var chartSemester1 = new ApexCharts(document.querySelector("#chartSemester1"), optSemester1);
            chartSemester1.render();

            var optSemester2 = {
                series: [value[1],value[0]],
                labels: [label[1],label[0]],
                colors: ['#fca103','#635b4c'],
                noData: {
                    text: 'Loading...'
                },
                chart: {
                    type: 'donut',
                    animate: true,
                    height: 500
                },
                legend: {
                    show: false
                },
                title: {
                    text: 'SEMESTER 2',
                    align: 'center'
                },
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
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    label:'TOTAL SEMESTERr 2',
                                    showAlways: true,
                                    show: true,
                                    formatter: function () {
                                        return value[1] == 0 ? 0 : value[1]
                                    }
                                }
                            }
                        }
                    }
                },

            };
            var chartSemester2 = new ApexCharts(document.querySelector("#chartSemester2"), optSemester2);
            chartSemester2.render();
        }

        function showTriwulan(data) {
            let value = Object.values(data[0]);
            let label = Object.values(data[1]);

            let valQ  = value[0] + value[1] + value[2] + value[3]

            let labelQ1 = [label[0], label[1] +', '+ label[2]+', ' + label[3]]
            let labelQ2 = [label[1], label[0] +', '+ label[2]+', ' + label[3]]
            let labelQ3 = [label[2], label[1] +', '+ label[0]+', ' + label[3]]
            let labelQ4 = [label[3], label[1] +', '+ label[2]+', ' + label[0]]

            var optQ1 = {
                series: [value[0], valQ-value[0]],
                labels: labelQ1,
                colors: ['#036cff','#364559'],
                noData: {
                    text: 'Loading...'
                },
                chart: {
                    type: 'donut',
                    animate: true,
                    height: 330
                },
                title: {
                    text: 'TRIWULAN 1',
                    align: 'center'
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'left',
                    floating: false,
                },
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
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    label:'Total Triwulan 1',
                                    showAlways: true,
                                    show: true,
                                    formatter: function () {
                                        return value[0] == 0 ? 0 : value[0]
                                    }
                                }
                            }
                        }
                    }
                },
            };

            var optQ2 = {
                series: [value[1], valQ-value[1]],
                labels: labelQ2,
                colors: ['#036cff','#364559'],
                noData: {
                    text: 'Loading...'
                },
                chart: {
                    type: 'donut',
                    animate: true,
                    height: 330
                },
                title: {
                    text: 'TRIWULAN 2',
                    align: 'center'
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'left',
                    floating: false,
                },
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
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    label:'Total Triwulan 2',
                                    showAlways: true,
                                    show: true,
                                    formatter: function () {
                                        return value[1] == 0 ? 0 : value[1]
                                    }
                                }
                            }
                        }
                    }
                },
            };

            var optQ3 = {
                series: [value[2], valQ-value[2]],
                labels: labelQ3,
                colors: ['#036cff','#364559'],
                noData: {
                    text: 'Loading...'
                },
                chart: {
                    type: 'donut',
                    animate: true,
                    height: 330
                },
                title: {
                    text: 'TRIWULAN 3',
                    align: 'center'
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'left',
                    floating: false,
                },
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
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    label:'Total Triwulan 3',
                                    showAlways: true,
                                    show: true,
                                    formatter: function () {
                                        return value[2] == 0 ? 0 : value[2]
                                    }
                                }
                            }
                        }
                    }
                },
            };

            var optQ4 = {
                series: [value[3], valQ-value[3]],
                labels: labelQ4,
                colors: ['#036cff','#364559'],
                noData: {
                    text: 'Loading...'
                },
                chart: {
                    type: 'donut',
                    animate: true,
                    height: 330
                },
                title: {
                    text: 'TRIWULAN 4',
                    align: 'center'
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'left',
                    floating: false,
                },
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
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    label:'Total Triwulan 4',
                                    showAlways: true,
                                    show: true,
                                    formatter: function () {
                                        return value[3] == 0 ? 0 : value[3]
                                    }
                                }
                            }
                        }
                    }
                },
            };


            var chartDonatDumas = new ApexCharts(document.querySelector("#chartDonatDumas"), optQ1);
            chartDonatDumas.render();

            var chartDonatDumas1 = new ApexCharts(document.querySelector("#chartDonatDumas1"), optQ2);
            chartDonatDumas1.render();

            var chartDonatDumas2 = new ApexCharts(document.querySelector("#chartDonatDumas2"), optQ3);
            chartDonatDumas2.render();

            var chartDonatDumas3 = new ApexCharts(document.querySelector("#chartDonatDumas3"), optQ4);
            chartDonatDumas3.render();
        }

    </script>
@endsection
