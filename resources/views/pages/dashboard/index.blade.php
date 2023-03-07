@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
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
    {{-- Title --}}
    <div class="row">
        <div class="col">
            <div class="card mb-1 p-1">
                <h1>DASHBOARD</h1>
            </div>
        </div>
    </div>
    <!-- STAT -->

    <div class="row">
        <div class="col-lg-4 col-sm-6">
            <div class="card-box bg-blue">
                <div class="inner">
                    <h1> {{ isset($pelanggar) ? count($pelanggar) : 0 }} </h1>
                    <h5> Total Pelanggar </h5>
                </div>
                <div class="icon">
                    <i class="fa fa-gavel f-left" aria-hidden="true"></i>
                </div>
                <a href="#" class="card-box-footer"><h6>Lihat Selengkapnya <i class="fa fa-arrow-circle-right"></i></h6></a>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card-box bg-orange">
                <div class="inner">
                    <h1> {{ isset($pengaduan_diproses) ? count($pengaduan_diproses) : 0 }} </h1>
                    <h5> Total Pengaduan Diproses </h5>
                </div>
                <div class="icon">
                    <i class="fa fa-sync-alt fa-spin" aria-hidden="true"></i>
                </div>
                <a href="#" class="card-box-footer"> <h6> Lihat Selengkapnya <i class="fa fa-arrow-circle-right"></i> </h6></a>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card-box bg-red">
                <div class="inner">
                    <h1> {{ isset($polda) ? count($polda) : 0 }} </h1>
                    <h5> Jumlah POLDA </h5>
                </div>
                <div class="icon">
                    <i class="fa fa-landmark"></i>
                </div>
                <a href="#" class="card-box-footer"> <h6> Lihat Selengkapnya <i class="fa fa-arrow-circle-right"></i> </h6></a>
            </div>
        </div>
    </div>

    <!-- Line Chart -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Grafik Pelanggaran</h2>
                </div>
                <div class="card-body">
                    <div id="chartdiv"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Grafik Donat</h2>
                </div>
                <div class="card-body">
                    <div id="chartDonat"></div>
                </div>
            </div>
            
        </div>

    </div>

    <!-- Bubble Chart -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>POLDA DI INDONESIA</h2>
                </div>
                <div class="card-body">
                    <div id="chartBubble"></div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- DataTable list pelanggar -->
    <div class="row mb-5">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">List Pelanggar</h4>

            </div><!-- end card header -->

            <div class="card-body">
                <div class="table-responsive table-card px-3">
                    <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">No Nota Dinas</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Pelapor</th>
                                <th scope="col">Terlapor</th>
                                <th scope="col">Pangkat</th>
                                <th scope="col">Nama Korban</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/hierarchy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script>
        $(document).ready(function() {
            getData();
            lineChartPelanggar();
            chartDonat();
            lineChartDashboard();
            bubbleChart();
        });

        function bubbleChart() {
            am5.ready(function() {

            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("chartBubble");

            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
            am5themes_Animated.new(root)
            ]);

            var data = {
            value: 0,
            children: [
                {
                    name: "Metro Jaya",
                    children: [
                        {
                            name: "Jakarta Pusat",
                            value: 1
                        },
                        {
                            name: "Jakarta Barat",
                            value: 1
                        },
                        {
                            name: "Jakarta Utara",
                            value: 1
                        },
                        {
                            name: "Jakarta Timur",
                            value: 1
                        },
                        {
                            name: "Tangerang",
                            value: 1
                        },
                    ]
                },
                {
                    name: "Jabar",
                    children: [
                        {
                            name: "Kota Bandung",
                            value: 1
                        },
                        {
                            name: "Cimahi",
                            value: 1
                        },
                        {
                            name: "Kab. Bandung",
                            value: 1
                        },
                        {
                            name: "Bandung Barat",
                            value: 2
                        },
                        {
                            name: "Sumedang",
                            value: 1
                        },
                    ]
                },
                {
                    name: "Jateng",
                    children: [
                        {
                            name: "Kota Semarang",
                            value: 1
                        },
                        {
                            name: "Kota Solo",
                            value: 1
                        },
                        {
                            name: "Jepara",
                            value: 1
                        },
                        {
                            name: "Cilacap",
                            value: 1
                        },
                        {
                            name: "Purwokerto",
                            value: 1
                        },
                    ]
                },
                {
                    name: "Jatim",
                    children: [
                        {
                            name: "Kota Malang",
                            value: 1
                        },
                        {
                            name: "Kota Surabaya",
                            value: 1
                        },
                        {
                            name: "Madura",
                            value: 1
                        },
                        {
                            name: "Kediri",
                            value: 1
                        },
                        {
                            name: "Lamongan",
                            value: 1
                        },
                    ]
                },
            ]
            };

            // Create wrapper container
            var container = root.container.children.push(am5.Container.new(root, {
                width: am5.percent(100),
                height: am5.percent(100),
                layout: root.verticalLayout
            }));

            // Create series
            // https://www.amcharts.com/docs/v5/charts/hierarchy/#Adding
            var series = container.children.push(am5hierarchy.ForceDirected.new(root, {
                singleBranchOnly: false,
                downDepth: 2,
                topDepth: 1,
                initialDepth: 1,
                valueField: "value",
                categoryField: "name",
                childDataField: "children",
                idField: "name",
                linkWithField: "linkWith",
                manyBodyStrength: -10,
                centerStrength: 0.8
            }));

            series.get("colors").setAll({
                step: 2
            });

            series.links.template.set("strength", 0.5);

            series.data.setAll([data]);

            series.set("selectedDataItem", series.dataItems[0]);


            // Make stuff animate on load
            series.appear(1000, 100);

            }); // end am5.ready()
        }

        function lineChartDashboard() {
            am5.ready(function() {

            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("chartdiv");

            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            // Create chart
            // https://www.amcharts.com/docs/v5/charts/xy-chart/
            var chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                wheelX: "panX",
                wheelY: "zoomX",
                layout: root.verticalLayout,
                pinchZoomX:true
            }));

            // Add cursor
            // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                behavior: "none"
            }));
            cursor.lineY.set("visible", false);

            var colorSet = am5.ColorSet.new(root, {});

            // The data
            var data = [
            {
                year: "2014",
                value: 23.5,
                strokeSettings: {
                stroke: colorSet.getIndex(0)
                },
                fillSettings: {
                fill: colorSet.getIndex(0),
                },
                bulletSettings: {
                fill: colorSet.getIndex(0)
                }
            },
            {
                year: "2015",
                value: 26,
                bulletSettings: {
                fill: colorSet.getIndex(0)
                }
            },
            {
                year: "2016",
                value: 30,
                bulletSettings: {
                fill: colorSet.getIndex(0)
                }
            },
            {
                year: "2017",
                value: 20,
                bulletSettings: {
                fill: colorSet.getIndex(0)
                }
            },
            {
                year: "2018",
                value: 30,
                strokeSettings: {
                stroke: colorSet.getIndex(3)
                },
                fillSettings: {
                fill: colorSet.getIndex(3),
                },
                bulletSettings: {
                fill: colorSet.getIndex(3)
                }
            },
            {
                year: "2019",
                value: 30,
                bulletSettings: {
                fill: colorSet.getIndex(3)
                }
            },
            {
                year: "2020",
                value: 31,
                bulletSettings: {
                fill: colorSet.getIndex(3)
                }
            },
            {
                year: "2021",
                value: 34,
                strokeSettings: {
                stroke: colorSet.getIndex(6)
                },
                fillSettings: {
                fill: colorSet.getIndex(6),
                },
                bulletSettings: {
                fill: colorSet.getIndex(6)
                }
            },
            {
                year: "2022",
                value: 33,
                bulletSettings: {
                fill: colorSet.getIndex(6)
                }
            },
            {
                year: "2023",
                value: 34,
                bulletSettings: {
                fill: colorSet.getIndex(6)
                }
            },
            {
                year: "2024",
                value: 36,
                bulletSettings: {
                fill: colorSet.getIndex(6)
                }
            }
            ];

            // Create axes
            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var xRenderer = am5xy.AxisRendererX.new(root, {});
            xRenderer.grid.template.set("location", 0.5);
            xRenderer.labels.template.setAll({
                location: 0.5,
                multiLocation: 0.5
            });

            var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                categoryField: "year",
                renderer: xRenderer,
                tooltip: am5.Tooltip.new(root, {})
            }));

            xAxis.data.setAll(data);

            var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                maxPrecision: 0,
                renderer: am5xy.AxisRendererY.new(root, {})
            }));

            var series = chart.series.push(am5xy.LineSeries.new(root, {
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                categoryXField: "year",
                tooltip: am5.Tooltip.new(root, {
                    labelText: "{valueY}",
                    dy:-5
                })
            }));

            series.strokes.template.setAll({
                templateField: "strokeSettings",
                strokeWidth: 2
            });

            series.fills.template.setAll({
                visible: true,
                fillOpacity: 0.5,
                templateField: "fillSettings"
            });


            series.bullets.push(function() {
                return am5.Bullet.new(root, {
                        sprite: am5.Circle.new(root, {
                        templateField: "bulletSettings",
                        radius: 5
                    })
                });
            });

            series.data.setAll(data);
            series.appear(1000);

            // Add scrollbar
            // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
            chart.set("scrollbarX", am5.Scrollbar.new(root, {
                orientation: "horizontal",
                marginBottom: 20
            }));

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            chart.appear(1000, 100);

            }); // end am5.ready()
        }

        function lineChartPelanggar() {
            var labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des', ''];
            var users = [100, 50, 11, 34, 86, 56, 2, 36, 50, 20, 10, 150];

            const data = {
                labels: labels,
                datasets: [{
                    label: 'Statistik Jumlah Pelanggar tahun 2022',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: users,
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {}
            };

            const myChart = new Chart(
                document.getElementById('lineChartPelanggar'),
                config
            );
        }

        function chartDonat() {
            am5.ready(function() {

            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("chartDonat");

            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            // Create chart
            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
            var chart = root.container.children.push(am5percent.PieChart.new(root, {
                radius: am5.percent(90),
                innerRadius: am5.percent(50),
                layout: root.horizontalLayout
            }));

            // Create series
            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
            var series = chart.series.push(am5percent.PieSeries.new(root, {
                name: "Series",
                valueField: "sales",
                categoryField: "country"
            }));

            // Set data
            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
            series.data.setAll([{
                    country: "Lithuania",
                    sales: 501.9
                }, {
                    country: "Czechia",
                    sales: 301.9
                }, {
                    country: "Ireland",
                    sales: 201.1
                }, {
                    country: "Germany",
                    sales: 165.8
                }, {
                    country: "Australia",
                    sales: 139.9
                }, {
                    country: "Austria",
                    sales: 128.3
                }, {
                    country: "UK",
                    sales: 99
                }, {
                    country: "Belgium",
                    sales: 60
                }, {
                    country: "The Netherlands",
                    sales: 50
            }]);

            // Disabling labels and ticks
            series.labels.template.set("visible", false);
            series.ticks.template.set("visible", false);

            // Adding gradients
            series.slices.template.set("strokeOpacity", 0);
            series.slices.template.set("fillGradient", am5.RadialGradient.new(root, {
                stops: [{
                    brighten: -0.8
                }, {
                    brighten: -0.8
                }, {
                    brighten: -0.5
                }, {
                    brighten: 0
                }, {
                    brighten: -0.5
                }]
            }));

            // Create legend
            // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
            var legend = chart.children.push(am5.Legend.new(root, {
                centerY: am5.percent(50),
                y: am5.percent(50),
                layout: root.verticalLayout
            }));
            // set value labels align to right
            legend.valueLabels.template.setAll({ textAlign: "right" })
            // set width and max width of labels
            legend.labels.template.setAll({ 
                maxWidth: 140,
                width: 140,
                oversizedBehavior: "wrap"
            });

            legend.data.setAll(series.dataItems);


            // Play initial series animation
            // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
            series.appear(1000, 100);

            }); // end am5.ready()
        }

        function getData() {
            var table = $('#data-data').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('kasus.data') }}",
                    method: "post",
                    data: function(data) {
                        data._token = '{{ csrf_token() }}'
                        // data.polda = $('#polda').val(),
                        // data.jenis_kelamin = $('#jenis_kelamin').val(),
                        // data.jenis_pelanggaran = $('#jenis_pelanggaran').val(),
                        // data.pangkat = $('#pangkat').val(),
                        // data.wujud_perbuatan = $('#wujud_perbuatan').val()
                    }
                },
                columns: [
                    // {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'no_nota_dinas',
                        name: 'no_nota_dinas'
                    },
                    {
                        data: 'tanggal_kejadian',
                        name: 'tanggal_kejadian'
                    },
                    {
                        data: 'pelapor',
                        name: 'pelapor'
                    },
                    {
                        data: 'terlapor',
                        name: 'terlapor'
                    },
                    {
                        data: 'pangkat',
                        name: 'pangkat'
                    },
                    {
                        data: 'nama_korban',
                        name: 'nama_korban'
                    },
                    {
                        data: 'status.name',
                        name: 'status.name'
                    },
                ]
            });
            $('#kt_search').on('click', function(e) {
                e.preventDefault();
                table.table().draw();
            });
        }
    </script>
@endsection
