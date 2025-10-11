@extends('layouts.backend.index')
@section('title', 'Laporan Penjualan')
@section('content')

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Laporan Penjualan
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted"><a class="text-muted text-hover-primary">Home</a></li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">Laporan</li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-gray-900">Penjualan</li>
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
                    <h3 class="fw-semibold  mb-1">List Data Penjualan</h3>
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
                    <div class="col-xl-4 d-none " id="statistik-total-transaksi">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card bg-light-info hoverable card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="text-info fw-bold fs-2 mb-2 mt-5"><span id="stat-total-transaksi">-</span>
                                </div>
                                <div class="fw-semibold text-info">Total Transaksi</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-total-penjualan">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card bg-light-success hoverable card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="text-success fw-bold fs-2 mb-2 mt-5"> <span id="stat-total-penjualan">-</span>
                                </div>
                                <div class="fw-semibold text-success">Total Penjualan</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-total-produk">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card bg-light-primary hoverable card-xl-stretch mb-5 mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="text-primary fw-bold fs-2 mb-2 mt-5"><span id="stat-total-produk">-</span></div>
                                <div class="fw-semibold text-primary">Jumlah Produk Terjual</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                </div>


                <div class="row mb-10 d-none" id="chart-wrapper">
                    <div class="position-relative" style="height: 300px;">
                        <canvas id="penjualanChart"></canvas>
                    </div>
                </div>






                <div id="laporan-summary" class="mb-10 d-none">
                    <div class="row mb-xl-10 mb-5">
                        <!-- Metode Pembayaran -->
                        <div class="col-md-4">
                            <div class="card border border-dashed border-dark card-flush h-xl-100">
                                <div class="card-header pt-7">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-gray-800">Transaksi</span>
                                        <span class="text-gray-500 mt-1 fw-semibold fs-6">Metode Pembayaran</span>
                                    </h3>
                                </div>
                                <div class="card-body pt-5">
                                    <div id="stat-metode-pembayaran"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Penjualan per Meja -->
                        <div class="col-md-8">
                            <div class="card border border-dashed border-dark card-flush h-xl-100">
                                <div class="card-header pt-7">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-gray-800">Penjualan</span>
                                        <span class="text-gray-500 mt-1 fw-semibold fs-6">Per Meja Customer</span>
                                    </h3>
                                </div>
                                <div class="card-body pt-5">
                                    <div class="row" id="stat-penjualan-meja"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card border border-dashed border-dark card-flush h-xl-100 d-none mb-xl-10- mb-10"
                    id="table-penjualan-pertanggal">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Total Penjualan</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-6">Berdasarkan periode tanggal terpilih</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <div class="table-responsive">
                            <table class="table table-striped table-flush table-row-dashed table-row-gray-300">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th style="background: #F1F1F1; padding: 6px 8px;">Tanggal</th>
                                        <th style="background: #F1F1F1; padding: 6px 8px; text-align: right;">Total
                                            Penjualan</th>
                                    </tr>
                                </thead>
                                <tbody id="table-tanggal-body">
                                    {{-- Akan diisi dengan JavaScript --}}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="py-2 px-3 text-start" style="background: #F1F1F1;">Total</th>
                                        <th id="footer-total-penjualan" class="py-2 px-3 text-end"
                                            style="background: #F1F1F1;">Rp0</th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>






                <div class="card border border-dashed border-dark card-flush h-xl-100 d-none" id="table-wrapper">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Data Penjualan</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-6">Berdasarkan periode tanggal terpilih</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <!-- TABEL -->
                        <div class="table-responsive ">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 chimox" id="chimox">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Tanggal</th>
                                        <th class="min-w-125px">No. Penjualan</th>
                                        <th class="min-w-125px">Meja</th>
                                        <th class="min-w-125px">Customer</th>
                                        <th class="min-w-125px">Total</th>
                                        <th class="min-w-125px">Pembayaran</th>
                                        <th class="min-w-125px">Dibuat Oleh</th>
                                        <th class="min-w-125px">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-semibold"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        <div class="modal fade" tabindex="-1" id="btn-export">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Export Laporan Penjualan</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                    class="path2"></span></i>
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

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row fv-plugins-icon-container">


                            <!--begin::Label-->
                            <label class="required form-label">Tipe Laporan</label>
                            <!--end::Label-->



                            <!--begin:Option-->
                            <label class="d-flex flex-stack mb-5 cursor-pointer">
                                <!--begin:Label-->
                                <span class="d-flex align-items-center me-2">
                                    <!--begin:Icon-->
                                    <span class="symbol symbol-50px me-6">
                                        <span class="symbol-label bg-light-primary">
                                            <i class="ki-outline ki-tablet-book fs-1 text-primary"></i>
                                        </span>
                                    </span>
                                    <!--end:Icon-->

                                    <!--begin:Info-->
                                    <span class="d-flex flex-column">
                                        <span class="fw-bold fs-6">Statistik Saja</span>
                                        <span class="fs-7 text-muted">Pilihan ini hanya menampilkan data statistik dan
                                            chart</span>
                                    </span>
                                    <!--end:Info-->
                                </span>
                                <!--end:Label-->

                                <!--begin:Input-->
                                <span class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="category" value="statistik" />
                                </span>
                                <!--end:Input-->
                            </label>
                            <!--end::Option-->

                            <!--begin:Option-->
                            <label class="d-flex flex-stack mb-5 cursor-pointer">
                                <!--begin:Label-->
                                <span class="d-flex align-items-center me-2">
                                    <!--begin:Icon-->
                                    <span class="symbol symbol-50px me-6">
                                        <span class="symbol-label bg-light-danger">
                                            <i class="ki-outline ki-questionnaire-tablet fs-1 text-danger"></i>
                                        </span>
                                    </span>
                                    <!--end:Icon-->

                                    <!--begin:Info-->
                                    <span class="d-flex flex-column">
                                        <span class="fw-bold fs-6">Data Saja</span>
                                        <span class="fs-7 text-muted">Pilihan ini hanya menampilkan data pada tabel
                                            saja</span>
                                    </span>
                                    <!--end:Info-->
                                </span>
                                <!--end:Label-->

                                <!--begin:Input-->
                                <span class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="category" value="datatable" />
                                </span>
                                <!--end:Input-->
                            </label>
                            <!--end::Option-->

                            <!--begin:Option-->
                            <label class="d-flex flex-stack cursor-pointer">
                                <!--begin:Label-->
                                <span class="d-flex align-items-center me-2">
                                    <!--begin:Icon-->
                                    <span class="symbol symbol-50px me-6">
                                        <span class="symbol-label bg-light-success">
                                            <i class="ki-outline ki-tablet-ok fs-1 text-success"></i>
                                        </span>
                                    </span>
                                    <!--end:Icon-->

                                    <!--begin:Info-->
                                    <span class="d-flex flex-column">
                                        <span class="fw-bold fs-6">Statistik & Data</span>
                                        <span class="fs-7 text-muted">Pilihan ini menampilkan statistik, chart, dan data
                                            dalam tabel</span>
                                    </span>
                                    <!--end:Info-->
                                </span>
                                <!--end:Label-->

                                <!--begin:Input-->
                                <span class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="category" value="gabungan" />
                                </span>
                                <!--end:Input-->
                            </label>
                            <!--end::Option-->
                        </div>



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

                    function getColor(method) {
                        switch (method) {
                            case 'cash':
                                return 'success';
                            case 'transfer':
                                return 'info';
                            case 'hutang':
                                return 'warning';
                            default:
                                return 'secondary';
                        }
                    }

                    var table = $('.chimox').DataTable({
                        processing: true,
                        serverSide: true,
                        order: false,
                        language: {
                            processing: "Please Wait ...",
                            loadingRecords: false,
                            zeroRecords: "Tidak ada data yang ditemukan",
                            emptyTable: "Tidak ada data yang tersedia di tabel ini",
                            search: "Cari:",
                        },
                        ajax: {
                            url: "{{ route('laporan.penjualan.data') }}",
                            type: 'GET',
                            data: function(d) {



                                if ($('#filter_tanggal').val() !== "") {
                                    d.filter_tanggal_start = $('#filter_tanggal').data('daterangepicker')
                                        .startDate.format('YYYY-MM-DD');
                                    d.filter_tanggal_end = $('#filter_tanggal').data('daterangepicker')
                                        .endDate.format('YYYY-MM-DD');
                                }



                            },
                            dataSrc: function(json) {
                                // ⬇️ Update statistik


                                $('#stat-total-transaksi').text(json.total_transaksi ?? 0);
                                $('#stat-total-penjualan').text('Rp ' + (parseFloat(json.total_penjualan) ||
                                        0)
                                    .toLocaleString());
                                $('#stat-total-produk').text(json.jumlah_produk_terjual ?? 0);

                                let metodeHTML = '';
                                if (json.metode_pembayaran) {
                                    Object.entries(json.metode_pembayaran).forEach(([key, val]) => {
                                        metodeHTML += `
        <div class=" mb-4">
            <div class="card border border-dashed border-${getColor(key)} h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-gray-700 fw-bold text-capitalize">${key}</div>
                            <div class="text-muted small">${val.jumlah}x transaksi</div>
                        </div>
                        <div class="text-end fw-bold text-gray-800">
                            Rp${parseFloat(val.total).toLocaleString()}
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
                                    });
                                }
                                $('#stat-metode-pembayaran').html(metodeHTML);




                                let mejaHTML = '';
                                if (json.penjualan_per_meja) {
                                    json.penjualan_per_meja.forEach(item => {
                                        mejaHTML += `
        <div class="col-md-6 col-lg-4 mb-4 ">
            <div class="card border border-dashed border-dark h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-gray-700 fw-bold"> ${item.nomor_meja}</div>
                        </div>
                        <div class="text-end fw-bold text-gray-800">
                            Rp${parseFloat(item.total).toLocaleString()}
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
                                    });
                                }
                                $('#stat-penjualan-meja').html(mejaHTML);


                                let tanggalHTML = '';
                                let totalSemuaTanggal = 0;

                                if (json.penjualan_per_tanggal && json.penjualan_per_tanggal.length > 0) {
                                    json.penjualan_per_tanggal.forEach(item => {
                                        const total = parseFloat(item.total);
                                        totalSemuaTanggal += total;

                                        tanggalHTML += `
            <tr>
                <td class="py-2 px-3">${item.tanggal}</td>
                <td class="py-2 px-3 text-end">Rp. ${total.toLocaleString('id-ID')}</td>
            </tr>
        `;
                                    });

                                    $('#table-tanggal-body').html(tanggalHTML);
                                    $('#footer-total-penjualan').text('Rp. ' + totalSemuaTanggal.toLocaleString(
                                        'id-ID'));
                                }




                                // ⬇️ Kembalikan data untuk tabel
                                return json.data;
                            }
                        },
                        columns: [{
                                data: 'tanggal',
                                name: 'tanggal'
                            },
                            {
                                data: 'no_penjualan',
                                name: 'no_penjualan'
                            },
                            {
                                data: 'meja_id',
                                name: 'meja_id'
                            },
                            {
                                data: 'customer_id',
                                name: 'customer_id'
                            },

                            {
                                data: 'total',
                                name: 'total'
                            },

                            {
                                data: 'pembayaran',
                                name: 'pembayaran'
                            },

                            {
                                data: 'user_id',
                                name: 'user_id'
                            },

                            {
                                data: 'catatan',
                                name: 'catatan'
                            },

                        ]
                    });



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
                        $('#table-wrapper').removeClass('d-none');
                        $('#statistik-total-transaksi').removeClass('d-none');
                        $('#statistik-total-penjualan').removeClass('d-none');
                        $('#statistik-total-produk').removeClass('d-none');
                        $('#laporan-summary').removeClass('d-none');
                        $('#table-penjualan-pertanggal').removeClass('d-none');

                        $('.btn-export').removeClass('d-none');

                        // Reload DataTable
                        table.ajax.reload(null, false);

                        // Panggil fungsi render chart
                        fetchChart(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                    });


                    // Ambil dan render data chart
                    function fetchChart(startDate, endDate) {
                        $.ajax({
                            url: "{{ route('laporan.penjualan.chart') }}",
                            method: "GET",
                            data: {
                                filter_tanggal_start: startDate,
                                filter_tanggal_end: endDate
                            },
                            success: function(response) {
                                const labels = response.map(row => row.tanggal);
                                const penjualan = response.map(row => row.total);
                                renderChart(labels, penjualan);
                            }
                        });
                    }


                    function renderChart(labels, data) {
                        const ctx = document.getElementById('penjualanChart').getContext('2d');
                        //const canvas = document.getElementById('penjualanChart');

                        if (window.penjualanChartInstance) {
                            window.penjualanChartInstance.destroy();
                        }

                        //canvas.height = 200;


                        window.penjualanChartInstance = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Total Penjualan (Rp)',
                                    data: data,
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 4,
                                    pointBackgroundColor: '#ccc',
                                    segment: {
                                        borderColor: ctx => {
                                            const {
                                                p0,
                                                p1
                                            } = ctx;
                                            if (p1.parsed.y > p0.parsed.y)
                                                return '#00c851'; // naik: hijau
                                            if (p1.parsed.y < p0.parsed.y)
                                                return '#ff4444'; // turun: merah
                                            return '#999999'; // tetap: abu-abu
                                        },
                                        backgroundColor: ctx => {
                                            const {
                                                p0,
                                                p1
                                            } = ctx;
                                            if (p1.parsed.y > p0.parsed.y)
                                                return 'rgba(0, 200, 81, 0.1)';
                                            if (p1.parsed.y < p0.parsed.y)
                                                return 'rgba(255, 68, 68, 0.1)';
                                            return 'rgba(153, 153, 153, 0.1)'; // tetap: abu-abu transparan
                                        }
                                    }


                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return 'Rp. ' + value.toLocaleString();
                                            }
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return 'Rp. ' + context.parsed.y.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }


                });
            </script>


            <script>
                $('#btn-print-laporan').on('click', function() {
                    const ukuran = $('#ukuran_kertas').val();
                    const orientasi = $('#orientasi_kertas').val();
                    const tipe = $('input[name="category"]:checked').val();

                    const tanggal = $('#filter_tanggal').val(); // "2024-06-01 to 2024-06-22"
                    if (!tanggal) return alert('Silakan pilih rentang tanggal.');

                    const [start, end] = tanggal.split(' to ');

                    if (!ukuran || !orientasi || !tipe) {
                        return alert('Semua opsi export wajib dipilih.');
                    }

                    const url = new URL("{{ route('laporan.penjualan.export') }}");
                    url.searchParams.set('ukuran', ukuran);
                    url.searchParams.set('orientasi', orientasi);
                    url.searchParams.set('tipe', tipe);
                    url.searchParams.set('start', start);
                    url.searchParams.set('end', end);

                    window.open(url.toString(), '_blank');
                });
            </script>
        @endpush
    @endsection
