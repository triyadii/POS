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
                    <li class="breadcrumb-item text-muted"><a class="text-muted text-hover-primary">Home</a></li>
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
                    <h3 class="fw-semibold mb-1">Data Laporan Penjualan</h3>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-primary btn-export d-none" data-bs-toggle="modal"
                            data-bs-target="#btn-export">
                            <i class="ki-outline ki-printer fs-2 me-2"></i> Export
                        </button>
                        <div class="position-relative">
                            <input type="text" class="form-control form-control-sm" placeholder="Pilih Tanggal"
                                name="filter_tanggal" id="filter_tanggal" autocomplete="off" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body py-4">
                {{-- Statistik Box --}}
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-4 d-none" id="statistik-total-transaksi-wrapper">
                        <div class="card bg-light-info hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-info fw-bold fs-2 mb-2 mt-5" id="stat-total-transaksi">-</div>
                                <div class="fw-semibold text-info">Total Transaksi</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-total-penjualan-wrapper">
                        <div class="card bg-light-success hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-success fw-bold fs-2 mb-2 mt-5" id="stat-total-penjualan">-</div>
                                <div class="fw-semibold text-success">Total Penjualan</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-total-produk-wrapper">
                        <div class="card bg-light-primary hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-primary fw-bold fs-2 mb-2 mt-5" id="stat-total-produk">-</div>
                                <div class="fw-semibold text-primary">Jumlah Produk Terjual</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chart --}}
                <div class="row my-10 d-none" id="chart-wrapper">
                    <div class="position-relative" style="height: 300px;">
                        <canvas id="penjualanChart"></canvas>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="card border border-dashed border-dark card-flush h-xl-100 d-none mt-5" id="table-wrapper">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Detail Data Penjualan</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-6">Berdasarkan periode tanggal terpilih</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="chimox">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-150px">Tanggal</th>
                                        <th class="min-w-125px">No. Transaksi</th>
                                        <th class="min-w-125px">Customer</th>
                                        <th class="min-w-125px">Kasir</th>
                                        <th class="min-w-350px">Detail Barang</th>
                                        <th class="min-w-125px">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-semibold"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="btn-export">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Export Laporan Penjualan</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-wrap gap-5 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Ukuran Kertas</label>
                                <select class="form-select" name="ukuran_kertas" id="ukuran_kertas">
                                    <option value="">Pilih ukuran kertas</option>
                                    <option value="A4">A4</option>
                                    <option value="F4">F4</option>
                                </select>
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Orientasi Kertas</label>
                                <select class="form-select" name="orientasi_kertas" id="orientasi_kertas">
                                    <option value="">Pilih orientasi kertas</option>
                                    <option value="portrait">Portrait</option>
                                    <option value="landscape">Landscape</option>
                                </select>
                            </div>
                        </div>
                        <div class="fv-row">
                            <label class="required form-label">Tipe Laporan</label>
                            <label class="d-flex flex-stack mb-5 cursor-pointer">
                                <span class="d-flex align-items-center me-2">
                                    <span class="symbol symbol-50px me-6"><span class="symbol-label bg-light-primary"><i
                                                class="ki-outline ki-chart-simple fs-1 text-primary"></i></span></span>
                                    <span class="d-flex flex-column">
                                        <span class="fw-bold fs-6">Statistik Saja</span>
                                        <span class="fs-7 text-muted">Hanya menampilkan ringkasan statistik dan
                                            chart.</span>
                                    </span>
                                </span>
                                <span class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="tipe_laporan" value="statistik"
                                        checked />
                                </span>
                            </label>
                            <label class="d-flex flex-stack mb-5 cursor-pointer">
                                <span class="d-flex align-items-center me-2">
                                    <span class="symbol symbol-50px me-6"><span class="symbol-label bg-light-danger"><i
                                                class="ki-outline ki-tablet-book fs-1 text-danger"></i></span></span>
                                    <span class="d-flex flex-column">
                                        <span class="fw-bold fs-6">Data Saja</span>
                                        <span class="fs-7 text-muted">Hanya menampilkan tabel data transaksi secara
                                            detail.</span>
                                    </span>
                                </span>
                                <span class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="tipe_laporan"
                                        value="datatable" />
                                </span>
                            </label>
                            <label class="d-flex flex-stack cursor-pointer">
                                <span class="d-flex align-items-center me-2">
                                    <span class="symbol symbol-50px me-6"><span class="symbol-label bg-light-success"><i
                                                class="ki-outline ki-tablet-ok fs-1 text-success"></i></span></span>
                                    <span class="d-flex flex-column">
                                        <span class="fw-bold fs-6">Statistik & Data</span>
                                        <span class="fs-7 text-muted">Menampilkan ringkasan statistik dan juga tabel
                                            data.</span>
                                    </span>
                                </span>
                                <span class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="tipe_laporan"
                                        value="gabungan" />
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary" id="btn-print-laporan">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('stylesheets')
        <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            $(document).ready(function() {
                let table, chartInstance;
                const formatRupiah = (number) => 'Rp ' + (Number(number) || 0).toLocaleString('id-ID');

                // Inisialisasi DataTable
                table = $('#chimox').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [
                        [0, 'desc']
                    ],
                    ajax: {
                        url: "{{ route('laporan.penjualan.data') }}",
                        data: function(d) {
                            if ($('#filter_tanggal').val() !== "") {
                                d.filter_tanggal_start = $('#filter_tanggal').data('daterangepicker')
                                    .startDate.format('YYYY-MM-DD');
                                d.filter_tanggal_end = $('#filter_tanggal').data('daterangepicker').endDate
                                    .format('YYYY-MM-DD');
                            }
                        },
                        dataSrc: function(json) {
                            // Update statistik
                            $('#stat-total-transaksi').text(json.total_transaksi ?? 0);
                            $('#stat-total-penjualan').text(formatRupiah(json.total_penjualan));
                            $('#stat-total-produk').text(json.jumlah_produk_terjual ?? 0);
                            return json.data;
                        }
                    },
                    columns: [{
                            data: 'tanggal',
                            name: 'tanggal_penjualan'
                        },
                        {
                            data: 'kode_transaksi',
                            name: 'kode_transaksi'
                        },
                        {
                            data: 'customer',
                            name: 'customer_nama'
                        },
                        {
                            data: 'user',
                            name: 'user.name'
                        },
                        {
                            data: 'detail_barang',
                            name: 'detail_barang',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'total',
                            name: 'total_harga'
                        },
                    ]
                });

                // Inisialisasi Date Range Picker
                $('#filter_tanggal').daterangepicker({
                    ranges: {
                        'Hari Ini': [moment(), moment()],
                        'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                        '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                        'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                        'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    "alwaysShowCalendars": true,
                    "autoUpdateInput": false,
                    "opens": "left",
                    "locale": {
                        "format": "YYYY-MM-DD",
                        "separator": " to "
                    }
                }, function(start, end, label) {
                    const range = start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD');
                    $('#filter_tanggal').val(range);

                    // Tampilkan semua wrapper
                    $('#statistik-total-transaksi-wrapper, #statistik-total-penjualan-wrapper, #statistik-total-produk-wrapper')
                        .removeClass('d-none');
                    $('#chart-wrapper, #table-wrapper, .btn-export').removeClass('d-none');

                    // Reload data
                    table.ajax.reload();
                    fetchChart(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                });

                // Fungsi untuk Chart
                function fetchChart(startDate, endDate) {
                    $.get("{{ route('laporan.penjualan.chart') }}", {
                        filter_tanggal_start: startDate,
                        filter_tanggal_end: endDate
                    }, function(data) {
                        const labels = data.map(row => row.tanggal);
                        const totals = data.map(row => row.total);
                        renderChart(labels, totals);
                    });
                }

                function renderChart(labels, data) {
                    const ctx = document.getElementById('penjualanChart').getContext('2d');
                    if (chartInstance) chartInstance.destroy();
                    chartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Penjualan',
                                data: data,
                                borderColor: '#009ef7',
                                backgroundColor: 'rgba(0, 158, 247, 0.2)',
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: value => formatRupiah(value)
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: ctx => formatRupiah(ctx.raw)
                                    }
                                }
                            }
                        }
                    });
                }

                // Fungsi untuk Tombol Print
                $('#btn-print-laporan').on('click', function() {
                    const ukuran = $('#ukuran_kertas').val();
                    const orientasi = $('#orientasi_kertas').val();
                    const tipe = $('input[name="tipe_laporan"]:checked').val();
                    const tanggal = $('#filter_tanggal').val();

                    if (!tanggal) return alert('Silakan pilih rentang tanggal terlebih dahulu.');
                    if (!ukuran || !orientasi || !tipe) return alert('Semua opsi export wajib dipilih.');

                    const [start, end] = tanggal.split(' to ');
                    const url = new URL("{{ route('laporan.penjualan.export') }}");
                    url.searchParams.set('ukuran', ukuran);
                    url.searchParams.set('orientasi', orientasi);
                    url.searchParams.set('tipe', tipe);
                    url.searchParams.set('start', start);
                    url.searchParams.set('end', end);

                    window.open(url.toString(), '_blank');
                });
            });
        </script>
    @endpush
@endsection
