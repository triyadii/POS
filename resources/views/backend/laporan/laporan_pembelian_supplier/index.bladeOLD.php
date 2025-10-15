@extends('layouts.backend.index')
@section('title', 'Laporan Pembelian per Supplier')
@section('content')

    {{-- Judul Halaman & Breadcrumb (Tidak Berubah) --}}
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Laporan Pembelian per Supplier
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Laporan</li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-gray-900">Pembelian per Supplier</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div class="card">
            {{-- Bagian Header Card dengan Filter (Tidak Berubah) --}}
            <div class="card-header border-0 pt-6">
                <div class="card-title flex-column">
                    <h3 class="fw-semibold mb-1">Data Laporan</h3>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-primary btn-export d-none" data-bs-toggle="modal"
                            data-bs-target="#modal_export_laporan"><i class="ki-outline ki-printer fs-2 me-2"></i>
                            Export</button>
                        <div class="position-relative">
                            <input type="text" class="form-control form-control-sm" placeholder="Pilih Tanggal"
                                name="filter_tanggal" id="filter_tanggal" autocomplete="off" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Body Card (Tidak Berubah) --}}
            <div class="card-body py-4">
                {{-- Kartu Statistik --}}
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-4 d-none" id="statistik-total-pembelian-wrapper">
                        <div class="card bg-light-success hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-success fw-bold fs-2 mb-2 mt-5" id="stat-total-pembelian">-</div>
                                <div class="fw-semibold text-success">Total Pembelian</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-total-supplier-wrapper">
                        <div class="card bg-light-info hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-info fw-bold fs-2 mb-2 mt-5" id="stat-total-supplier">-</div>
                                <div class="fw-semibold text-info">Total Supplier</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-barang-diterima-wrapper">
                        <div class="card bg-light-primary hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-primary fw-bold fs-2 mb-2 mt-5" id="stat-barang-diterima">-</div>
                                <div class="fw-semibold text-primary">Jumlah Barang Diterima</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chart --}}
                <div class="row my-10 d-none" id="chart-wrapper">
                    <div id="pembelianChart" style="height: 350px;"></div>
                </div>

                {{-- Tabel Data --}}
                <div class="table-responsive mt-5 d-none" id="table-wrapper">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                        id="supplier_report_table">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th class="text-end">Jumlah Barang Diterima</th>
                                <th class="text-end">Total Pembelian</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold"></tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- PERBAIKAN 2: Kode Modal Diletakkan Langsung di Sini --}}
        {{-- ====================================================== --}}
        <div class="modal fade" id="modal_export_laporan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Export Laporan Pembelian per Supplier</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required fs-6 fw-semibold form-label mb-2">Ukuran Kertas</label>
                                    <select id="ukuran_kertas" class="form-select form-select-solid">
                                        <option value="A4">A4</option>
                                        <option value="F4">F4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required fs-6 fw-semibold form-label mb-2">Orientasi Kertas</label>
                                    <select id="orientasi_kertas" class="form-select form-select-solid">
                                        <option value="portrait">Portrait</option>
                                        <option value="landscape">Landscape</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="fv-row">
                            <label class="required form-label">Tipe Laporan</label>
                            <label class="d-flex flex-stack mb-5 cursor-pointer">
                                <span class="d-flex align-items-center me-2">
                                    <span class="d-flex flex-column">
                                        <span class="fw-bold text-gray-800 text-hover-primary fs-5">Data Saja</span>
                                        <span class="fs-7 text-muted">Hanya menampilkan tabel data pembelian per
                                            supplier.</span>
                                    </span>
                                </span>
                                <span class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="tipe_laporan" value="datatable"
                                        checked />
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="btn-print-laporan" class="btn btn-primary">
                            <span class="indicator-label">Print</span>
                        </button>
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
        <script>
            $(document).ready(function() {
                let table, chart;
                const formatRupiah = (number) => 'Rp ' + (Number(number) || 0).toLocaleString('id-ID');

                // DataTable (Tidak Berubah)
                table = $('#supplier_report_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('laporan.pembelian.supplier.data') }}",
                        data: function(d) {
                            if ($('#filter_tanggal').val() !== "") {
                                d.filter_tanggal_start = $('#filter_tanggal').data('daterangepicker')
                                    .startDate.format('YYYY-MM-DD');
                                d.filter_tanggal_end = $('#filter_tanggal').data('daterangepicker').endDate
                                    .format('YYYY-MM-DD');
                            }
                        },
                        dataSrc: function(json) {
                            $('#stat-total-pembelian').text(formatRupiah(json.total_pembelian));
                            $('#stat-total-supplier').text(json.total_supplier ?? 0);
                            $('#stat-barang-diterima').text((json.total_barang_diterima ?? 0) + ' Pcs');
                            return json.data;
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama',
                            name: 'suppliers.nama'
                        },
                        {
                            data: 'total_item',
                            name: 'total_qty_masuk',
                            className: 'text-end',
                            searchable: false
                        },
                        {
                            data: 'total_pembelian',
                            name: 'total_harga_beli',
                            className: 'text-end',
                            searchable: false
                        },
                    ],
                    order: [
                        [3, 'desc']
                    ]
                });

                function reloadData() {
                    if ($('#filter_tanggal').val()) {
                        table.ajax.reload();
                        fetchChart();
                    }
                }

                // ======================================================
                // PERBAIKAN 1: Tambahkan Opsi 'ranges' pada Date Picker
                // ======================================================
                $('#filter_tanggal').daterangepicker({
                    ranges: {
                        'Hari Ini': [moment(), moment()],
                        'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                        '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                        'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                        'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment()
                            .subtract(1, 'month').endOf('month')
                        ]
                    },
                    "alwaysShowCalendars": true,
                    "autoUpdateInput": false,
                    "opens": "left",
                    "locale": {
                        "format": "YYYY-MM-DD",
                        "separator": " to "
                    }
                }, function(start, end, label) {
                    $('#filter_tanggal').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                    $('#statistik-total-pembelian-wrapper, #statistik-total-supplier-wrapper, #statistik-barang-diterima-wrapper')
                        .removeClass('d-none');
                    $('#table-wrapper, #chart-wrapper, .btn-export').removeClass('d-none');
                    reloadData();
                });

                // Chart & Export Logic (Tidak Berubah)
                function fetchChart() {
                    const picker = $('#filter_tanggal').data('daterangepicker');
                    $.get("{{ route('laporan.pembelian.supplier.chart') }}", {
                        filter_tanggal_start: picker.startDate.format('YYYY-MM-DD'),
                        filter_tanggal_end: picker.endDate.format('YYYY-MM-DD'),
                    }, function(data) {
                        renderBarChart(data);
                    });
                }

                function renderBarChart(data) {
                    const chartElement = document.getElementById('pembelianChart');
                    if (!chartElement) return;
                    if (chart) chart.destroy();
                    const options = {
                        series: [{
                            name: 'Total Pembelian',
                            data: Object.values(data).reverse()
                        }],
                        chart: {
                            fontFamily: 'inherit',
                            type: 'bar',
                            height: 350,
                            toolbar: {
                                show: false
                            }
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                horizontal: true
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: Object.keys(data).reverse(),
                            labels: {
                                formatter: (val) => formatRupiah(val)
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: KTUtil.getCssVariableValue('--bs-gray-500'),
                                    fontSize: '12px'
                                }
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: (val) => formatRupiah(val)
                            }
                        },
                        colors: [KTUtil.getCssVariableValue('--bs-primary')],
                    };
                    chart = new ApexCharts(chartElement, options);
                    chart.render();
                }

                $('#btn-print-laporan').on('click', function() {
                    const tanggal = $('#filter_tanggal').val();
                    if (!tanggal) return Swal.fire('Perhatian', 'Rentang tanggal wajib dipilih.', 'warning');

                    const [start, end] = tanggal.split(' to ');
                    const url = new URL("{{ route('laporan.pembelian.supplier.export') }}");
                    url.searchParams.set('ukuran', $('#ukuran_kertas').val());
                    url.searchParams.set('orientasi', $('#orientasi_kertas').val());
                    url.searchParams.set('tipe', $('input[name="tipe_laporan"]:checked').val());
                    url.searchParams.set('start', start);
                    url.searchParams.set('end', end);
                    window.open(url.toString(), '_blank');
                });
            });
        </script>
    @endpush
@endsection
