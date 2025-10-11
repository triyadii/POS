@extends('layouts.backend.index')
@section('title', 'Laporan Penjualan')
@section('content')

    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Laporan Penjualan
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted"><a>Home</a></li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">Laporan</li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-gray-900">Penjualan</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title flex-column">
                    <h3 class="fw-semibold mb-1">Filter Laporan Penjualan</h3>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <button type="button" class="btn btn-sm btn-primary btn-export d-none" data-bs-toggle="modal"
                            data-bs-target="#modal-export">
                            <i class="ki-outline ki-printer fs-2 me-2"></i> Export PDF
                        </button>
                        <div class="position-relative">
                            <input type="text" class="form-control form-control-sm" placeholder="Pilih Rentang Tanggal"
                                name="filter_tanggal" id="filter_tanggal" autocomplete="off" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body py-4">
                {{-- STATISTIK --}}
                <div class="row g-5 g-xl-8 d-none" id="statistik-wrapper">
                    <div class="col-xl-4">
                        <div class="card bg-light-info hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-info fw-bold fs-2 mb-2 mt-5" id="stat-total-transaksi">-</div>
                                <div class="fw-semibold text-info">Total Transaksi</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card bg-light-success hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-success fw-bold fs-2 mb-2 mt-5" id="stat-total-penjualan">-</div>
                                <div class="fw-semibold text-success">Total Penjualan</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card bg-light-primary hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-primary fw-bold fs-2 mb-2 mt-5" id="stat-item-terjual">-</div>
                                <div class="fw-semibold text-primary">Jumlah Item Terjual</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CHART --}}
                <div class="row my-10 d-none" id="chart-wrapper">
                    <div class="position-relative" style="height: 300px;">
                        <canvas id="penjualanChart"></canvas>
                    </div>
                </div>

                {{-- TABEL DATA --}}
                <div class="table-responsive d-none" id="table-wrapper">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="table-penjualan">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px"></th> {{-- Untuk tombol expand --}}
                                <th>Tanggal</th>
                                <th>Kode Transaksi</th>
                                <th>Customer</th>
                                <th>Kasir</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="modal-export">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Export Laporan</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i
                            class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row g-9 mb-7">
                        <div class="col-md-6">
                            <label class="required form-label">Ukuran Kertas</label>
                            <select class="form-select" id="ukuran_kertas">
                                <option value="A4">A4</option>
                                <option value="F4">F4</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="required form-label">Orientasi</label>
                            <select class="form-select" id="orientasi_kertas">
                                <option value="portrait">Portrait</option>
                                <option value="landscape">Landscape</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-sm btn-primary" id="btn-print-laporan">Export</button>
                </div>
            </div>
        </div>
    </div>
    @push('stylesheets')
        <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}">
        <style>
            td.details-control {
                background: url('{{ asset('assets/media/icons/details_open.png') }}') no-repeat center center;
                cursor: pointer;
            }

            tr.details td.details-control {
                background: url('{{ asset('assets/media/icons/details_close.png') }}') no-repeat center center;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            $(document).ready(function() {
                let table, chart;

                // Inisialisasi Date Range Picker
                $('#filter_tanggal').daterangepicker({
                    autoUpdateInput: false,
                    ranges: {
                        'Hari Ini': [moment(), moment()],
                        'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                        'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                    },
                    locale: {
                        cancelLabel: 'Batal',
                        applyLabel: 'Terapkan',
                        format: 'YYYY-MM-DD'
                    }
                });

                // Event handler saat tanggal dipilih
                $('#filter_tanggal').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                        'DD/MM/YYYY'));

                    // Tampilkan semua elemen laporan
                    $('#statistik-wrapper, #chart-wrapper, #table-wrapper, .btn-export').removeClass('d-none');

                    // Hancurkan tabel jika sudah ada, lalu inisialisasi ulang
                    if ($.fn.DataTable.isDataTable('#table-penjualan')) {
                        table.destroy();
                    }
                    initializeDataTable(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format(
                        'YYYY-MM-DD'));
                    fetchChartData(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
                });

                function initializeDataTable(startDate, endDate) {
                    table = $('#table-penjualan').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('laporan.penjualan.data') }}",
                            data: {
                                filter_tanggal_start: startDate,
                                filter_tanggal_end: endDate
                            },
                            dataSrc: function(json) {
                                // Update statistik
                                $('#stat-total-transaksi').text(json.total_transaksi.toLocaleString(
                                    'id-ID'));
                                $('#stat-total-penjualan').text('Rp ' + json.total_penjualan.toLocaleString(
                                    'id-ID'));
                                $('#stat-item-terjual').text(json.jumlah_item_terjual.toLocaleString(
                                    'id-ID'));
                                return json.data;
                            }
                        },
                        columns: [{
                                className: 'details-control',
                                orderable: false,
                                data: null,
                                defaultContent: ''
                            },
                            {
                                data: 'tanggal_penjualan',
                                name: 'tanggal_penjualan'
                            },
                            {
                                data: 'kode_transaksi',
                                name: 'kode_transaksi'
                            },
                            {
                                data: 'customer_nama',
                                name: 'customer_nama'
                            },
                            {
                                data: 'kasir',
                                name: 'user.name',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'total_harga',
                                name: 'total_harga',
                                className: 'text-end'
                            }
                        ],
                        order: [
                            [1, 'desc']
                        ]
                    });
                }

                // Event listener untuk expand/collapse child row
                $('#table-penjualan tbody').on('click', 'td.details-control', function() {
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);
                    var data = row.data();

                    if (row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('details');
                    } else {
                        // Tampilkan loading
                        row.child('<div>Loading...</div>').show();
                        tr.addClass('details');

                        // Ambil data detail via AJAX
                        $.get("{{ url('laporan-penjualan/detail') }}/" + data.id, function(response) {
                            row.child(response.html).show();
                        });
                    }
                });

                function fetchChartData(startDate, endDate) {
                    $.ajax({
                        url: "{{ route('laporan.penjualan.chart') }}",
                        data: {
                            filter_tanggal_start: startDate,
                            filter_tanggal_end: endDate
                        },
                        success: function(data) {
                            const labels = data.map(item => moment(item.tanggal).format('DD MMM'));
                            const totals = data.map(item => item.total);
                            renderChart(labels, totals);
                        }
                    });
                }

                function renderChart(labels, data) {
                    if (chart) chart.destroy();
                    const ctx = document.getElementById('penjualanChart').getContext('2d');
                    chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Penjualan',
                                data: data,
                                borderColor: '#50cd89',
                                backgroundColor: 'rgba(80, 205, 137, 0.1)',
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    ticks: {
                                        callback: value => 'Rp ' + value.toLocaleString('id-ID')
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: context => 'Rp ' + context.parsed.y.toLocaleString('id-ID')
                                    }
                                }
                            }
                        }
                    });
                }

                // Export PDF
                $('#btn-print-laporan').on('click', function() {
                    const picker = $('#filter_tanggal').data('daterangepicker');
                    if (!picker.startDate) {
                        alert('Silakan pilih rentang tanggal terlebih dahulu.');
                        return;
                    }

                    const url = new URL("{{ route('laporan.penjualan.export-pdf') }}");
                    url.searchParams.set('start', picker.startDate.format('YYYY-MM-DD'));
                    url.searchParams.set('end', picker.endDate.format('YYYY-MM-DD'));
                    url.searchParams.set('ukuran', $('#ukuran_kertas').val());
                    url.searchParams.set('orientasi', $('#orientasi_kertas').val());

                    window.open(url.toString(), '_blank');
                });
            });
        </script>
    @endpush
@endsection
