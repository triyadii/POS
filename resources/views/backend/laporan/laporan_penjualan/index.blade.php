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
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="text-info fw-bold fs-2 mb-2 mt-5" id="stat-total-transaksi">-</div>
                                <div class="fw-semibold text-info mb-5">Total Transaksi</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-total-penjualan-wrapper">
                        <div class="card bg-light-success hoverable card-xl-stretch">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="text-success fw-bold fs-2 mb-2 mt-5" id="stat-total-penjualan">-</div>
                                <div class="fw-semibold text-success mb-5">Total Penjualan</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-total-produk-wrapper">
                        <div class="card bg-light-primary hoverable card-xl-stretch">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="text-primary fw-bold fs-2 mb-2 mt-5" id="stat-total-produk">-</div>
                                <div class="fw-semibold text-primary mb-5">Jumlah Produk Terjual</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chart (diganti dari canvas ke div) --}}
                <div class="row my-10 d-none" id="chart-wrapper">
                    <div id="penjualanChart" style="height: 350px;"></div>
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
                                        <th class="min-w-150px">Jenis Pembayaran</th> {{-- KOLOM BARU --}}
                                        <th class="min-w-125px text-end">Total</th>
                                        <th class="min-w-100px text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-semibold"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Export tidak berubah --}}
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
                                    <span class="symbol symbol-50px me-6"><span class="symbol-label bg-light-danger"><i
                                                class="ki-outline ki-tablet-book fs-1 text-danger"></i></span></span>
                                    <span class="d-flex flex-column">
                                        <span class="fw-bold fs-6">Data Saja</span>
                                        <span class="fs-7 text-muted">Hanya menampilkan tabel data transaksi.</span>
                                    </span>
                                </span>
                                <span class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="tipe_laporan" value="datatable"
                                        checked />
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

    {{-- Letakkan kode ini sebelum @push('scripts') --}}
    <div class="modal fade" tabindex="-1" id="kt_modal_detail_penjualan">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"></h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body">
                    {{-- Konten detail akan dimasukkan di sini oleh JavaScript --}}
                    <div id="detail-content-container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('stylesheets')
        <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        {{-- Script Chart.js sudah tidak diperlukan --}}

        <script>
            $(document).ready(function() {
                let table, chart; // Ganti nama variabel chart
                const formatRupiah = (number) => 'Rp ' + (Number(number) || 0).toLocaleString('id-ID');

                // Inisialisasi DataTable (TIDAK BERUBAH)
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
                            data: 'jenis_pembayaran',
                            name: 'jenis_pembayaran',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'total',
                            name: 'total_harga'
                        },
                        { // Ganti kolom 'detail_barang' dengan 'action'
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                    ]
                });

                // Inisialisasi Date Range Picker (TIDAK BERUBAH)
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
                    $('#statistik-total-transaksi-wrapper, #statistik-total-penjualan-wrapper, #statistik-total-produk-wrapper')
                        .removeClass('d-none');
                    $('#chart-wrapper, #table-wrapper, .btn-export').removeClass('d-none');
                    table.ajax.reload();
                    fetchChart(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                });

                $('#kt_modal_detail_penjualan').on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget); // Tombol yang diklik
                    const transactionCode = button.data('kode'); // Ambil kode transaksi dari data-kode
                    const details = button.data('details'); // Ambil JSON detail dari data-details

                    const modal = $(this);
                    modal.find('.modal-title').text('Detail Transaksi: ' + transactionCode);

                    let contentHtml = `<div class="table-responsive">
                                    <table class="table table-row-dashed table-row-gray-300 gy-4">
                                        <thead>
                                            <tr class="fw-bold fs-6 text-gray-800">
                                                <th>Nama Barang</th>
                                                <th>Qty</th>
                                                <th class="text-end">Harga Jual</th>
                                                <th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;

                    if (Array.isArray(details) && details.length > 0) {
                        details.forEach(item => {
                            contentHtml += `<tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-800 fw-bold">${item.nama_barang}</span>
                                                    <small class="text-muted">${item.kode_barang}</small>
                                                </div>
                                            </td>
                                            <td>${item.qty}</td>
                                            <td class="text-end">${formatRupiah(item.harga_jual)}</td>
                                            <td class="text-end fw-semibold">${formatRupiah(item.subtotal)}</td>
                                        </tr>`;
                        });
                    } else {
                        contentHtml +=
                            '<tr><td colspan="4" class="text-center">Tidak ada data detail.</td></tr>';
                    }

                    contentHtml += `</tbody></table></div>`;
                    modal.find('#detail-content-container').html(contentHtml);
                });

                // ===================================
                // FUNGSI CHART DIUBAH KE APEXCHARTS
                // ===================================
                function fetchChart(startDate, endDate) {
                    $.get("{{ route('laporan.penjualan.chart') }}", {
                        filter_tanggal_start: startDate,
                        filter_tanggal_end: endDate
                    }, function(data) {
                        renderApexChart(data); // Panggil fungsi ApexCharts
                    });
                }

                function renderApexChart(data) {
                    const chartElement = document.getElementById('penjualanChart');
                    if (!chartElement) return;
                    if (chart) chart.destroy(); // Hancurkan chart lama

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

                // Fungsi Tombol Print (TIDAK BERUBAH)
                $('#btn-print-laporan').on('click', function() {
                    const ukuran = $('#ukuran_kertas').val();
                    const orientasi = $('#orientasi_kertas').val();
                    const tipe = $('input[name="tipe_laporan"]:checked').val();
                    const tanggal = $('#filter_tanggal').val();

                    if (!tanggal) return Swal.fire('Perhatian',
                        'Silakan pilih rentang tanggal terlebih dahulu.', 'warning');
                    if (!ukuran || !orientasi || !tipe) return Swal.fire('Perhatian',
                        'Semua opsi export wajib dipilih.', 'warning');

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
