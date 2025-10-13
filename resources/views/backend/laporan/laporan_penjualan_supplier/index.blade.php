@extends('layouts.backend.index')
@section('title', 'Laporan Penjualan (Supplier Alternatif)')
@section('content')

    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Laporan Penjualan (Supplier Alternatif)
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Laporan</li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-gray-900">Penjualan by Supplier (Alt.)</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        {{-- <div class="alert alert-info d-flex align-items-center mb-5">
            <i class="ki-outline ki-information-5 fs-2 me-4 text-info"></i>
            <div class="d-flex flex-column">
                <span>Laporan ini menampilkan daftar **barang yang terjual** dan diatribusikan ke **supplier terakhir** yang
                    tercatat pada sistem barang masuk.</span>
            </div>
        </div> --}}
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title flex-column">
                    <h3 class="fw-semibold mb-1">Data Laporan</h3>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-primary btn-export d-none" data-bs-toggle="modal"
                            data-bs-target="#btn-export"><i class="ki-outline ki-printer fs-2 me-2"></i> Export</button>
                        <div class="position-relative min-w-150px">
                            <select class="form-select form-select-sm" data-control="select2" data-hide-search="true"
                                id="filter_kategori" data-placeholder="Pilih Kategori">
                                <option></option>
                                <option value="all">Semua Kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="position-relative min-w-150px">
                            <select class="form-select form-select-sm" data-control="select2" data-hide-search="true"
                                id="filter_brand" data-placeholder="Pilih Brand">
                                <option></option>
                                <option value="all">Semua Brand</option>
                                @foreach ($brands as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="position-relative">
                            <input type="text" class="form-control form-control-sm" placeholder="Pilih Tanggal"
                                name="filter_tanggal" id="filter_tanggal" autocomplete="off" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body py-4">
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-4 d-none" id="statistik-total-penjualan-wrapper">
                        <div class="card bg-light-success hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-success fw-bold fs-2 mb-2 mt-5" id="stat-total-penjualan">-</div>
                                <div class="fw-semibold text-success">Total Pendapatan</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-jenis-produk-wrapper">
                        <div class="card bg-light-info hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-info fw-bold fs-2 mb-2 mt-5" id="stat-jenis-produk">-</div>
                                <div class="fw-semibold text-info">Total Jenis Produk Terjual</div>
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

                <div class="row my-10 d-none" id="chart-wrapper">
                    <div id="penjualanChart" style="height: 350px;"></div>
                </div>

                <div class="table-responsive mt-5 d-none" id="table-wrapper">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                        id="supplier_report_table">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Supplier Terakhir</th>
                                <th class="text-end">Total Terjual</th>
                                <th class="text-end">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="btn-export">
            {{-- Modal Export tidak berubah dan sudah benar --}}
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

                table = $('#supplier_report_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('laporan.penjualan.supplier.data') }}",
                        data: function(d) {
                            if ($('#filter_tanggal').val() !== "") {
                                d.filter_tanggal_start = $('#filter_tanggal').data('daterangepicker')
                                    .startDate.format('YYYY-MM-DD');
                                d.filter_tanggal_end = $('#filter_tanggal').data('daterangepicker').endDate
                                    .format('YYYY-MM-DD');
                            }
                            d.filter_kategori = $('#filter_kategori').val();
                            d.filter_brand = $('#filter_brand').val();
                        },
                        dataSrc: function(json) {
                            $('#stat-total-penjualan').text(formatRupiah(json.total_pendapatan));
                            $('#stat-jenis-produk').text(json.total_jenis_produk ?? 0);
                            $('#stat-total-produk').text((json.total_produk_terjual ?? 0) + ' Pcs');
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
                            data: 'kode_barang',
                            name: 'barang.kode_barang'
                        },
                        {
                            data: 'nama',
                            name: 'barang.nama'
                        },
                        {
                            data: 'supplier',
                            name: 'supplier_terakhir',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'total_item',
                            name: 'total_qty_terjual',
                            className: 'text-end'
                        },
                        {
                            data: 'total_penjualan',
                            name: 'total_pendapatan',
                            className: 'text-end'
                        },
                    ],
                    order: [
                        [5, 'desc']
                    ]
                });

                function reloadData() {
                    const tanggal = $('#filter_tanggal').val();
                    if (tanggal) {
                        const [start, end] = tanggal.split(' to ');
                        table.ajax.reload();
                        fetchChart(start, end);
                    }
                }

                $('#filter_kategori, #filter_brand').on('change', function() {
                    reloadData();
                });

                // ===================================
                // UBAH BAGIAN DATERANGEPICKER DI BAWAH INI
                // ===================================
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
                            "separator": " to ",
                            "applyLabel": "Terapkan",
                            "cancelLabel": "Batal",
                        }
                    },
                    function(start, end, label) {
                        $('#filter_tanggal').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                        $('#statistik-total-penjualan-wrapper, #statistik-jenis-produk-wrapper, #statistik-total-produk-wrapper')
                            .removeClass('d-none');
                        $('#table-wrapper, #chart-wrapper, .btn-export').removeClass('d-none');
                        reloadData();
                    });

                function fetchChart(startDate, endDate) {
                    $.get("{{ route('laporan.penjualan.supplier.chart') }}", {
                        filter_tanggal_start: startDate,
                        filter_tanggal_end: endDate,
                        filter_kategori: $('#filter_kategori').val(),
                        filter_brand: $('#filter_brand').val(),
                    }, function(data) {
                        renderApexChart(data);
                    });
                }

                function renderApexChart(data) {
                    const chartElement = document.getElementById('penjualanChart');
                    if (!chartElement) return;
                    if (chart) chart.destroy();

                    const options = {
                        series: [{
                            name: 'Total Penjualan',
                            data: data.map(row => row.total)
                        }],
                        chart: {
                            fontFamily: 'inherit',
                            type: 'area',
                            height: 350,
                            toolbar: {
                                show: false
                            }
                        },
                        plotOptions: {},
                        legend: {
                            show: false
                        },
                        dataLabels: {
                            enabled: false
                        },
                        fill: {
                            type: 'solid',
                            opacity: 0.3
                        },
                        stroke: {
                            curve: 'smooth',
                            show: true,
                            width: 3,
                            colors: [KTUtil.getCssVariableValue('--bs-primary')]
                        },
                        xaxis: {
                            categories: data.map(row => moment(row.tanggal).format('DD MMM')),
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            labels: {
                                style: {
                                    colors: KTUtil.getCssVariableValue('--bs-gray-500'),
                                    fontSize: '12px'
                                }
                            },
                            crosshairs: {
                                position: 'front',
                                stroke: {
                                    color: KTUtil.getCssVariableValue('--bs-primary'),
                                    width: 1,
                                    dashArray: 3
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: (val) => formatRupiah(val),
                                style: {
                                    colors: KTUtil.getCssVariableValue('--bs-gray-500'),
                                    fontSize: '12px'
                                }
                            }
                        },
                        states: {
                            normal: {
                                filter: {
                                    type: 'none',
                                    value: 0
                                }
                            },
                            hover: {
                                filter: {
                                    type: 'none',
                                    value: 0
                                }
                            },
                            active: {
                                allowMultipleDataPointsSelection: false,
                                filter: {
                                    type: 'none',
                                    value: 0
                                }
                            }
                        },
                        tooltip: {
                            style: {
                                fontSize: '12px'
                            },
                            y: {
                                formatter: (val) => formatRupiah(val)
                            }
                        },
                        colors: [KTUtil.getCssVariableValue('--bs-primary')],
                        grid: {
                            borderColor: KTUtil.getCssVariableValue('--bs-gray-200'),
                            strokeDashArray: 4,
                            yaxis: {
                                lines: {
                                    show: true
                                }
                            }
                        },
                        markers: {
                            strokeColor: KTUtil.getCssVariableValue('--bs-primary'),
                            strokeWidth: 3
                        }
                    };

                    chart = new ApexCharts(chartElement, options);
                    chart.render();
                }

                $('#btn-print-laporan').on('click', function() {
                    const ukuran = $('#ukuran_kertas').val();
                    const orientasi = $('#orientasi_kertas').val();
                    const tipe = $('input[name="tipe_laporan"]:checked').val();
                    const tanggal = $('#filter_tanggal').val();
                    const brandId = $('#filter_brand').val(); // Ambil filter brand

                    if (!tanggal) return Swal.fire('Perhatian',
                        'Rentang tanggal wajib dipilih.', 'warning');

                    const [start, end] = tanggal.split(' to ');
                    const url = new URL("{{ route('laporan.penjualan.brand.export') }}");
                    url.searchParams.set('ukuran', ukuran);
                    url.searchParams.set('orientasi', orientasi);
                    url.searchParams.set('tipe', tipe);
                    url.searchParams.set('start', start);
                    url.searchParams.set('end', end);
                    url.searchParams.set('brand_id', brandId); // Kirim filter brand
                    window.open(url.toString(), '_blank');
                });
            });
        </script>
    @endpush
@endsection
