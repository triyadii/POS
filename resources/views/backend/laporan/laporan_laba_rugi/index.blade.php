@extends('layouts.backend.index')
@section('title', 'Laporan Laba/Rugi')
@section('content')

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Laporan Laba Rugi
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted"><a class="text-muted text-hover-primary">Home</a></li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">Laporan</li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-gray-900">Laba Rugi</li>
                </ul>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">



        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h3 class="fw-semibold  mb-1">Data Laporan</h3>
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">

                    <!--begin::Filter + Refresh-->
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2" data-kt-user-table-toolbar="base">


                        <!--begin::Button Refresh-->
                        <button type="button" class="btn btn-sm btn-primary btn-export d-none" data-bs-toggle="modal"
                            data-bs-target="#btn-export">
                            <i class="ki-outline ki-printer fs-2 me-2"></i> Export

                        </button>
                        <!--end::Button Refresh-->


                        <!--begin::Filter Tanggal-->
                        <div class="position-relative">
                            <input type="text" class="form-control form-control-sm" placeholder="Pilih Tanggal"
                                name="filter_tanggal" id="filter_tanggal" autocomplete="off" />
                        </div>
                        <!--end::Filter Tanggal-->


                    </div>
                    <!--end::Filter + Refresh-->

                </div>

                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">


                <div class="row g-5 g-xl-8">
                    <div class="col-xl-4 d-none " id="statistik-pendapatan">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card bg-light-info hoverable card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="text-info fw-bold fs-2 mb-2 mt-5"><span id="stat-pendapatan">-</span>
                                </div>
                                <div class="fw-semibold text-info">Pendapatan</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-pengeluaran">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card bg-light-success hoverable card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="text-success fw-bold fs-2 mb-2 mt-5"> <span id="stat-pengeluaran">-</span>
                                </div>
                                <div class="fw-semibold text-success">Pengeluaran</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-laba-bersih">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card bg-light-primary hoverable card-xl-stretch mb-5 mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="text-primary fw-bold fs-2 mb-2 mt-5"><span id="stat-laba-bersih">-</span></div>
                                <div class="fw-semibold text-primary">Profit / Laba Bersih</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                </div>


                <div class="row mb-10 d-none" id="chart-wrapper">
                    <div class="position-relative" style="height: 300px;">
                        <canvas id="labaRugiChart"></canvas>
                    </div>
                </div>


                <div class="table-responsive mt-5 d-none" id="table-wrapper">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="bg-light fw-bold">
                            <tr>
                                <th class="text-nowrap">Tanggal</th>
                                <th class="text-nowrap">Pendapatan Penjualan</th>
                                <th class="text-nowrap">Pendapatan Tiket</th>
                                <th class="text-nowrap">Pengeluaran</th>
                                <th class="text-nowrap">Laba Bersih</th>
                            </tr>
                        </thead>
                        <tbody id="table-laba-rugi-body">
                            <!-- Data akan diisi via JS -->
                        </tbody>
                        <tfoot class="fw-semibold bg-secondary text-white">
                            <tr>
                                <td>Total</td>
                                <td class="text-end" id="tfoot-total-penjualan">Rp0</td>
                                <td class="text-end" id="tfoot-total-tiket">Rp0</td>
                                <td class="text-end" id="tfoot-total-pengeluaran">Rp0</td>
                                <td class="text-end" id="tfoot-total-laba">Rp0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>





            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        <div class="modal fade" tabindex="-1" id="btn-export">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Export Laporan Laba Rugi</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">


                        <!--begin::Tax-->
                        <div class="d-flex flex-wrap gap-5 mb-xl-10 mb-5">
                            <!--begin::Input group-->
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required form-label">Ukuran Kertas</label>
                                <!--end::Label-->
                                <!--begin::Select2-->
                                <select class="form-select mb-2 " name="ukuran_kertas" id="ukuran_kertas"
                                    data-placeholder="pilih ukuran kertas" tabindex="-1" aria-hidden="true">
                                    <option value="">pilih ukuran kertas</option>
                                    <option value="A4">A4</option>
                                    <option value="F4">F4</option>
                                </select>
                                <!--end::Select2-->


                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row w-100 flex-md-root">
                                <!--begin::Label-->
                                <label class="form-label">Orientasi Kertas</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select mb-2 " name="orientasi_kertas" id="orientasi_kertas"
                                    data-placeholder="pilih orientasi kertas" tabindex="-1" aria-hidden="true">
                                    <option value="">pilih orientasi kertas</option>
                                    <option value="landscape">Landscape</option>
                                    <option value="Portrait">Portrait</option>
                                </select> <!--end::Input-->

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end:Tax-->




                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-primary" id="btn-print-laporan">Print</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!--end::Content-->












        @push('stylesheets')
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}">
            {{-- <style>
            #penjualanChart {
                height: 100% !important;
            }
        </style> --}}
        @endpush

        @push('scripts')
            <script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                $(document).ready(function() {


                    $('#filter_tanggal').daterangepicker({
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                                'month').endOf('month')]
                        },
                        "alwaysShowCalendars": true,
                        "autoUpdateInput": false, // Agar tidak otomatis mengisi input saat dipilih
                        "opens": "left"
                    }, function(start, end, label) {
                        $('#filter_tanggal').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                        // Reload DataTable dengan data filter
                        // Tampilkan chart dan tabel
                        $('#chart-wrapper').removeClass('d-none');
                        $('#stat-pendapatan').removeClass('d-none');
                        $('#stat-pengeluaran').removeClass('d-none');
                        $('#stat-laba-bersih').removeClass('d-none');


                        $('.btn-export').removeClass('d-none');

                        // Panggil fungsi render chart
                        fetchChart(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                    });


                    // Ambil dan render data chart
                    function fetchChart(startDate, endDate) {
                        $.ajax({
                            url: "{{ route('laporan.laba-rugi.chart') }}",
                            method: "GET",
                            data: {
                                filter_tanggal_start: startDate,
                                filter_tanggal_end: endDate
                            },
                            success: function(response) {
                                // Langsung kirim data response ke fungsi render
                                renderLabaRugiChart(response);
                            }
                        });
                    }







                    let labaRugiChart;

                    function renderLabaRugiChart(data) {
                        const labels = data.map(item => item.tanggal);
                        const pendapatan = data.map(item => item.total_pendapatan);
                        const pengeluaran = data.map(item => item.pengeluaran);
                        const laba = data.map(item => item.laba_bersih);


                        // Tampilkan wrapper
                        $('#chart-wrapper').removeClass('d-none');
                        $('#table-wrapper').removeClass('d-none');

                        // Hapus chart sebelumnya jika ada
                        if (labaRugiChart) {
                            labaRugiChart.destroy();
                        }

                        // =========================
                        // Hitung Total dan Isi Tabel
                        // =========================
                        let tableHTML = '';
                        let totalPenjualan = 0;
                        let totalTiket = 0;
                        let totalPengeluaran = 0;
                        let totalLaba = 0;

                        data.forEach(item => {
                            totalPenjualan += Number(item.pendapatan_penjualan);
                            totalTiket += Number(item.pendapatan_tiket);
                            totalPengeluaran += Number(item.pengeluaran);
                            totalLaba += Number(item.laba_bersih);

                            tableHTML += `
            <tr>
                <td>${item.tanggal}</td>
                <td class="text-end">Rp. ${Number(item.pendapatan_penjualan).toLocaleString('id-ID')}</td>
                <td class="text-end">Rp. ${Number(item.pendapatan_tiket).toLocaleString('id-ID')}</td>
                <td class="text-end">Rp. ${Number(item.pengeluaran).toLocaleString('id-ID')}</td>
                <td class="text-end fw-bold">Rp. ${Number(item.laba_bersih).toLocaleString('id-ID')}</td>
            </tr>
        `;
                        });

                        $('#table-laba-rugi-body').html(tableHTML);

                        $('#tfoot-total-penjualan').text('Rp. ' + totalPenjualan.toLocaleString('id-ID'));
                        $('#tfoot-total-tiket').text('Rp. ' + totalTiket.toLocaleString('id-ID'));
                        $('#tfoot-total-pengeluaran').text('Rp. ' + totalPengeluaran.toLocaleString('id-ID'));
                        $('#tfoot-total-laba').text('Rp. ' + totalLaba.toLocaleString('id-ID'));

                        // =========================
                        // Statistik Atas
                        // =========================
                        $('#stat-pendapatan').text('Rp. ' + (totalPenjualan + totalTiket).toLocaleString('id-ID'));
                        $('#stat-pengeluaran').text('Rp. ' + totalPengeluaran.toLocaleString('id-ID'));
                        $('#stat-laba-bersih').text('Rp. ' + totalLaba.toLocaleString('id-ID'));

                        $('#statistik-pendapatan').removeClass('d-none');
                        $('#statistik-pengeluaran').removeClass('d-none');
                        $('#statistik-laba-bersih').removeClass('d-none');

                        const ctx = document.getElementById('labaRugiChart').getContext('2d');
                        labaRugiChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                        label: 'Pendapatan',
                                        data: pendapatan,
                                        backgroundColor: '#50cd89', // Metronic green
                                        stack: 'combined'
                                    },
                                    {
                                        label: 'Pengeluaran',
                                        data: pengeluaran,
                                        backgroundColor: '#f1416c', // Metronic red
                                        stack: 'combined'
                                    },
                                    {
                                        label: 'Laba Bersih',

                                        data: laba,
                                        type: 'line',
                                        borderColor: '#009ef7', // Metronic blue
                                        borderWidth: 2,
                                        fill: false,
                                        tension: 0.4,
                                        yAxisID: 'y'
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                interaction: {
                                    mode: 'index',
                                    intersect: false
                                },
                                plugins: {
                                    legend: {
                                        labels: {
                                            color: '#7E8299' // Metronic gray text
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                let val = context.raw;
                                                return context.dataset.label + ': Rp' + Number(val)
                                                    .toLocaleString('id-ID');
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        ticks: {
                                            color: '#A1A5B7'
                                        },
                                        grid: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            color: '#A1A5B7',
                                            callback: function(value) {
                                                return 'Rp' + value.toLocaleString('id-ID');
                                            }
                                        },
                                        grid: {
                                            color: '#eff2f5'
                                        }
                                    }
                                }
                            }
                        });

                        // Tampilkan wrapper chart jika sebelumnya disembunyikan
                        document.getElementById('chart-wrapper').classList.remove('d-none');
                    }


                });
            </script>


            <script>
                $('#btn-print-laporan').on('click', function() {
                    const ukuran = $('#ukuran_kertas').val();
                    const orientasi = $('#orientasi_kertas').val();

                    const tanggal = $('#filter_tanggal').val().split(' to ');
                    const start = tanggal[0];
                    const end = tanggal[1];

                    if (!ukuran || !orientasi) {
                        alert('Harap pilih ukuran dan orientasi kertas terlebih dahulu!');
                        return;
                    }

                    const url = new URL("{{ route('laporan.laba-rugi.export-pdf') }}", window.location.origin);
                    url.searchParams.append('filter_tanggal_start', start);
                    url.searchParams.append('filter_tanggal_end', end);
                    url.searchParams.append('ukuran_kertas', ukuran);
                    url.searchParams.append('orientasi_kertas', orientasi);

                    window.open(url, '_blank');
                });
            </script>
        @endpush
    @endsection
