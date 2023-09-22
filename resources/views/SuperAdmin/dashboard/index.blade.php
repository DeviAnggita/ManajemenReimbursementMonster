<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <title>Dashboard</title>

    @include('template.head')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('template.left-sidebar-SuperAdmin')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('template.navbar-SuperAdmin')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center mb-4">
                            <h2 class="h5 mb-0 text-gray-1000">Dashboard - {{ $tahun_terpilih }}</h2>
                            <form method="GET" action="{{ route('superadmin.dashboard') }}" class="ml-3">
                                <select name="tahun" onchange="this.form.submit()" aria-controls="dataTable"
                                    class="custom-select custom-select-sm form-control form-control-sm">
                                    @foreach ($tahun_options as $tahun_option)
                                        <option value="{{ $tahun_option }}"
                                            {{ $tahun_terpilih == $tahun_option ? 'selected' : '' }}>
                                            {{ $tahun_option }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <div>
                            <a href="/superadmin/export-excel?tahun={{ $tahun_terpilih }}"
                                class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download Laporan Excel
                            </a>
                        </div>
                    </div>


                    <!-- Content Row -->
                    <div class="row">

                        <!-- Medical Card -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="/superadmin/medical" style="text-decoration: none;">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Reimbursment Medical</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $totalReimbursementMedical }} Reimbursement</div>

                                                <div class="mb-0 font-weight-bold text-xs">
                                                    <span style="color: blue;">{{ $totalMenungguReimbursementMedical }}
                                                        Menunggu</span>

                                                </div>
                                                <div class="mb-0 font-weight-bold text-xs">
                                                    <span style="color: green;">{{ $totalSetujuReimbursementMedical }}
                                                        Setuju</span>

                                                </div>
                                                <div class="mb-0 font-weight-bold text-xs">
                                                    <span style="color: #FFD700;">{{ $totalRevisiReimbursementMedical }}
                                                        Revisi</span>

                                                </div>
                                                <div class="mb-0 font-weight-bold text-xs">
                                                    <span style="color: red;">{{ $totalTolakReimbursementMedical }}
                                                        Tolak</span>

                                                </div>
                                                <div class="mb-0 font-weight-bold text-xs">
                                                    <span style="color: gray;">{{ $totalSelesaiReimbursementMedical }}
                                                        Selesai</span>
                                                </div>


                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Reimbursement Perjalanan Bisnis -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="/superadmin/perjalanan-bisnis" style="text-decoration: none;">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Reimbursement Perjalanan Bisnis </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $totalReimbursementPerjalananBisnis }} Reimbursement</div>

                                                <div class="mb-0 font-weight-bold text-xs">
                                                    <span
                                                        style="color: blue;">{{ $totalMenungguReimbursementPerjalananBisnis }}
                                                        Menunggu</span>

                                                </div>
                                                <div class="mb-0 font-weight-bold text-xs">
                                                    <span
                                                        style="color: green;">{{ $totalSetujuReimbursementPerjalananBisnis }}
                                                        Setuju</span>

                                                </div>
                                                <div class="mb-0 font-weight-bold text-xs">
                                                    <span
                                                        style="color: #FFD700;">{{ $totalRevisiReimbursementPerjalananBisnis }}
                                                        Revisi</span>

                                                </div>
                                                <div class="mb-0 font-weight-bold text-xs">
                                                    <span
                                                        style="color: red;">{{ $totalTolakReimbursementPerjalananBisnis }}
                                                        Tolak</span>
                                                </div>
                                                <div class="mb-0 font-weight-bold text-xs">
                                                    <span
                                                        style="color: gray;">{{ $totalSelesaiReimbursementPerjalananBisnis }}
                                                        Selesai</span>
                                                </div>


                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>



                        <!-- Reimbursement Penunjang Kantor -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="/superadmin/penunjang-kantor" style="text-decoration: none;">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Reimbursement Penunjang Kantor
                                                </div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                            {{ $totalReimbursementPenunjangKantor }}
                                                            Reimbursement
                                                        </div>

                                                        <div class="mb-0 font-weight-bold text-xs">
                                                            <span
                                                                style="color: blue;">{{ $totalMenungguReimbursementPenunjangKantor }}
                                                                Menunggu</span>

                                                        </div>
                                                        <div class="mb-0 font-weight-bold text-xs">
                                                            <span
                                                                style="color: green;">{{ $totalSetujuReimbursementPenunjangKantor }}
                                                                Setuju</span>

                                                        </div>
                                                        <div class="mb-0 font-weight-bold text-xs">
                                                            <span
                                                                style="color: #FFD700;">{{ $totalRevisiReimbursementPenunjangKantor }}
                                                                Revisi</span>

                                                        </div>
                                                        <div class="mb-0 font-weight-bold text-xs">
                                                            <span
                                                                style="color: red;">{{ $totalTolakReimbursementPenunjangKantor }}
                                                                Tolak</span>
                                                        </div>
                                                        <div class="mb-0 font-weight-bold text-xs">
                                                            <span
                                                                style="color: gray;">{{ $totalSelesaiReimbursementPenunjangKantor }}
                                                                Selesai</span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>


                    </div>



                    <!-- Content Row -->

                    <div class="row">


                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-gray-800">Total Pengajuan Reimbursement</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">

                                    <div class="chart-bar">
                                        <canvas id="myBarReimbursementChart"></canvas>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-gray-800">Jenis Reimbursement</h6>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">

                                    <div class="chart-pie pt-2 pb-2">
                                        <canvas id="myPieReimbursementChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <span class="mr-2 small text-xs">
                                            <i class="fas fa-circle text-primary"></i> Medical
                                        </span>
                                        <span class="mr-2 small text-xs">
                                            <i class="fas fa-circle text-warning"></i> Perjalanan Bisnis
                                        </span>
                                        <span class="mr-2 small text-xs">
                                            <i class="fas fa-circle text-info"></i> Penunjang Kantor
                                        </span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->






            <!-- Footer -->
            @include('template.footer')

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    @include('template.script')
    @include('sweetalert::alert')


</body>

</html>

<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    (Chart.defaults.global.defaultFontFamily = "Nunito"),
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = "#858796";

    function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    // Tooltip
    $(function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'manual'
        }).tooltip('show');
    });

    // $( window ).scroll(function() {   
    // if($( window ).scrollTop() > 10){  // scroll down abit and get the action   
    $(".progress-bar").each(function() {
        each_bar_width = $(this).attr('aria-valuenow');
        $(this).width(each_bar_width + '%');
    });

    //  }  
    // });


    // Bar Chart Example
    var ctx = document.getElementById("myBarReimbursementChart");
    var myBarChart = new Chart(ctx, {
        type: 'bar', // Mengubah jenis grafik menjadi stacked bar
        data: {
            labels: ["Jan", "Feb", "March", "Apr", "May", "June", "July", "Augst", "Sept", "Oct", "Nov", "Dec"],
            datasets: [{
                    label: "Reimbursement Medical",
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: [
                        <?= $totalReimbursementJanMedical ?>,
                        <?= $totalReimbursementFebMedical ?>,
                        <?= $totalReimbursementMarMedical ?>,
                        <?= $totalReimbursementAprMedical ?>,
                        <?= $totalReimbursementMayMedical ?>,
                        <?= $totalReimbursementJunMedical ?>,
                        <?= $totalReimbursementJulMedical ?>,
                        <?= $totalReimbursementAugMedical ?>,
                        <?= $totalReimbursementSepMedical ?>,
                        <?= $totalReimbursementOctMedical ?>,
                        <?= $totalReimbursementNovMedical ?>,
                        <?= $totalReimbursementDecMedical ?>
                    ],
                },
                {
                    label: "Reimbursement Perjalanan Bisnis",
                    backgroundColor: "#f6c23e",
                    hoverBackgroundColor: "#dda20a",
                    borderColor: "#f6c23e",
                    data: [
                        <?= $totalReimbursementJanPB ?>,
                        <?= $totalReimbursementFebPB ?>,
                        <?= $totalReimbursementMarPB ?>,
                        <?= $totalReimbursementAprPB ?>,
                        <?= $totalReimbursementMayPB ?>,
                        <?= $totalReimbursementJunPB ?>,
                        <?= $totalReimbursementJulPB ?>,
                        <?= $totalReimbursementAugPB ?>,
                        <?= $totalReimbursementSepPB ?>,
                        <?= $totalReimbursementOctPB ?>,
                        <?= $totalReimbursementNovPB ?>,
                        <?= $totalReimbursementDecPB ?>
                    ],
                },
                {
                    label: "Reimbursement Penunjang Kantor",
                    backgroundColor: "#e74a3b",
                    hoverBackgroundColor: "#c72114",
                    borderColor: "#e74a3b",
                    data: [
                        <?= $totalReimbursementJanPK ?>,
                        <?= $totalReimbursementFebPK ?>,
                        <?= $totalReimbursementMarPK ?>,
                        <?= $totalReimbursementAprPK ?>,
                        <?= $totalReimbursementMayPK ?>,
                        <?= $totalReimbursementJunPK ?>,
                        <?= $totalReimbursementJulPK ?>,
                        <?= $totalReimbursementAugPK ?>,
                        <?= $totalReimbursementSepPK ?>,
                        <?= $totalReimbursementOctPK ?>,
                        <?= $totalReimbursementNovPK ?>,
                        <?= $totalReimbursementDecPK ?>
                    ],
                },
            ],
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
                    stacked: true, // Mengaktifkan pengelompokan data pada sumbu x
                    ticks: {
                        beginAtZero: true
                    },
                    maxBarThickness: 25,
                }],
                yAxes: [{
                    stacked: true, // Mengaktifkan pengelompokan data pada sumbu y
                    ticks: {
                        min: 0,
                        max: <?= $highestReimbursement ?>,
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value, index, values) {
                            return number_format(value)
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
                display: true,
                labels: {
                    filter: function(legendItem, chartData) {
                        return chartData.datasets[legendItem.datasetIndex].data.reduce((a, b) => a + b, 0) >
                            0;
                    }
                }
            },
            tooltips: {
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + " : " + number_format(tooltipItem.yLabel);
                    }
                }
            },
            onClick: function(event, elements) {
                if (elements.length > 0) {
                    var index = elements[0].index;
                    var labels = myBarChart.data.labels;
                    var datasets = myBarChart.data.datasets;

                    var total = 0;
                    var labelCounts = {};

                    for (var i = 0; i < datasets.length; i++) {
                        var datasetLabel = datasets[i].label;
                        var dataValue = datasets[i].data[index];
                        total += dataValue;

                        if (labelCounts[datasetLabel]) {
                            labelCounts[datasetLabel] += dataValue;
                        } else {
                            labelCounts[datasetLabel] = dataValue;
                        }
                    }

                    var tooltipContent = [];
                    tooltipContent.push(labels[index] + ":");

                    for (var label in labelCounts) {
                        var count = labelCounts[label];
                        tooltipContent.push(label + " : " + number_format(count));
                    }
                    console.log(tooltipContent);
                    // Lakukan sesuatu dengan tooltipContent, misalnya tampilkan dalam modal atau elemen HTML lainnya
                }
            }
        }
    });



    // Pie Chart Example
    var ctx = document.getElementById("myPieReimbursementChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Medical ", "Perjalanan Bisnis ", "Penunjang Kantor "],
            datasets: [{
                data: [<?= $percentageMedical ?>, <?= $percentagePerjalananBisnis ?>,
                    <?= $percentagePenunjangKantor ?>
                ],
                backgroundColor: ['#4e73df', '#FFC82B', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#FFC82B', '#2c9faf'],
                hoverBorderColor: "rgba(234, 255, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 10,
                yPadding: 10,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, data) {
                        var indice = tooltipItem.index;
                        return data.labels[indice] + ': ' + data.datasets[0].data[indice] + ' %';
                    }
                },
            },
            legend: {
                display: false
            },
            plugins: {
                datalabels: {
                    color: 'black',
                    font: {
                        weight: 'bold',
                        size: 10,
                    },
                    formatter: function(value, context) {
                        return Math.round(value) + '%';
                    }
                },
            }
        },
    });
</script>
