@extends('layouts.backend.index')
@section('title', 'Laporan Laba/Rugi')
@section('content')

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
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title flex-column">
                    <h3 class="fw-semibold mb-1">Data Laporan</h3>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
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
                    <div class="col-xl-3 d-none" id="statistik-pendapatan-wrapper">
                        <div class="card bg-light-success hoverable card-xl-stretch">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="text-success fw-bold fs-2 mb-3" id="stat-pendapatan">-</div>
                                <div class="fw-semibold text-success">Total Pendapatan</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 d-none" id="statistik-pembelian-wrapper">
                        <div class="card bg-light-warning hoverable card-xl-stretch">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="text-warning fw-bold fs-2 mb-3" id="stat-pembelian">-</div>
                                <div class="fw-semibold text-warning">Total Pembelian Barang</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 d-none" id="statistik-pengeluaran-wrapper">
                        <div class="card bg-light-danger hoverable card-xl-stretch">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="text-danger fw-bold fs-2 mb-3" id="stat-pengeluaran">-</div>
                                <div class="fw-semibold text-danger">Total Biaya Operasional</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 d-none" id="statistik-laba-bersih-wrapper">
                        <div class="card bg-light-primary hoverable card-xl-stretch">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="text-primary fw-bold fs-2 mb-3" id="stat-laba-bersih">-</div>
                                <div class="fw-semibold text-primary">Profit / Laba Bersih</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chart Container --}}
                <div class="row mb-10 d-none" id="chart-wrapper">
                    <div id="labaRugiChart" style="height: 350px;"></div>
                </div>

                {{-- Tabel Data --}}
                <div class="table-responsive mt-5 d-none" id="table-wrapper">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                        id="laba_rugi_datatable">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th>Tanggal</th>
                                <th class="text-end">Pendapatan</th>
                                <th class="text-end">Pembelian Barang</th>
                                <th class="text-end">Biaya Operasional</th>
                                <th class="text-end">Laba Bersih</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot class="fw-semibold">
                            <tr>
                                <th>Total</th>
                                <th class="text-end" id="tfoot-total-pendapatan">Rp0</th>
                                <th class="text-end" id="tfoot-total-pembelian">Rp0</th>
                                <th class="text-end" id="tfoot-total-pengeluaran">Rp0</th>
                                <th class="text-end" id="tfoot-total-laba">Rp0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="btn-export">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Export Laporan Laba Rugi</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-wrap gap-5 mb-xl-10 mb-5">
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Ukuran Kertas</label>
                                <select class="form-select mb-2" name="ukuran_kertas" id="ukuran_kertas">
                                    <option value="A4">A4</option>
                                    <option value="F4">F4</option>
                                </select>
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Orientasi Kertas</label>
                                <select class="form-select mb-2" name="orientasi_kertas" id="orientasi_kertas">
                                    <option value="portrait">Portrait</option>
                                    <option value="landscape">Landscape</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary" id="btn-print-laporan">Print</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" tabindex="-1" id="modal_detail_laporan">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"></h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i
                                class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                    class="path2"></span></i></div>
                    </div>
                    <div class="modal-body" id="detail-content-container">
                        <div class="text-center py-10"><span
                                class="spinner-border spinner-border-sm align-middle ms-2"></span>Loading...</div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Tutup</button></div>
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
                let chart;
                let datatable;

                const formatRupiah = (number) => 'Rp ' + (Number(number) || 0).toLocaleString('id-ID');

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
                        "cancelLabel": "Batal"
                    }
                }, function(start, end, label) {
                    $('#filter_tanggal').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                    $('.btn-export').removeClass('d-none');
                    fetchAndRenderData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                });

                function fetchAndRenderData(startDate, endDate) {
                    $.ajax({
                        url: "{{ route('laporan.laba-rugi.chart') }}",
                        method: "GET",
                        data: {
                            filter_tanggal_start: startDate,
                            filter_tanggal_end: endDate
                        },
                        success: (response) => renderData(response),
                        error: () => Swal.fire('Error', 'Gagal mengambil data.', 'error')
                    });
                }

                function renderData(data) {
                    // Tampilkan semua wrapper
                    $('#statistik-pendapatan-wrapper, #statistik-pembelian-wrapper, #statistik-pengeluaran-wrapper, #statistik-laba-bersih-wrapper')
                        .removeClass('d-none');
                    $('#chart-wrapper, #table-wrapper').removeClass('d-none');

                    // Kalkulasi total (pastikan nama properti sudah benar)
                    let totalPendapatan = data.reduce((sum, item) => sum + Number(item.total_pendapatan), 0);
                    let totalPembelian = data.reduce((sum, item) => sum + Number(item.pembelian_barang), 0);
                    let totalPengeluaran = data.reduce((sum, item) => sum + Number(item.pengeluaran_operasional),
                    0); // Pastikan ini benar
                    let totalLaba = data.reduce((sum, item) => sum + Number(item.laba_bersih), 0);

                    // Update statistik & footer (pastikan ID elemen sudah benar)
                    $('#tfoot-total-pendapatan, #stat-pendapatan').text(formatRupiah(totalPendapatan));
                    $('#tfoot-total-pembelian, #stat-pembelian').text(formatRupiah(totalPembelian));
                    $('#tfoot-total-pengeluaran, #stat-pengeluaran').text(formatRupiah(totalPengeluaran));
                    $('#tfoot-total-laba, #stat-laba-bersih').text(formatRupiah(totalLaba));

                    // Inisialisasi DataTables (tidak ada perubahan di sini)
                    if ($.fn.DataTable.isDataTable('#laba_rugi_datatable')) {
                        datatable.destroy();
                    }
                    datatable = $('#laba_rugi_datatable').DataTable({
                        data: data,
                        columns: [{
                                data: 'tanggal'
                            }, {
                                data: 'total_pendapatan'
                            },
                            {
                                data: 'pembelian_barang'
                            }, {
                                data: 'pengeluaran_operasional'
                            },
                            {
                                data: 'laba_bersih'
                            }
                        ],
                        columnDefs: [{
                                targets: 0,
                                render: (data) => moment(data).format('DD MMMM YYYY')
                            },
                            {
                                targets: [3, 4],
                                className: 'text-end',
                                render: (data) => formatRupiah(data)
                            },
                            {
                                targets: 1,
                                className: 'text-end',
                                render: function(data, type, row) {
                                    if (data > 0)
                                    return `<button class="btn btn-link p-0 btn-show-detail" data-tipe="pendapatan" data-tanggal="${row.tanggal}">${formatRupiah(data)}</button>`;
                                    return formatRupiah(data);
                                }
                            },
                            {
                                targets: 2,
                                className: 'text-end',
                                render: function(data, type, row) {
                                    if (data > 0)
                                    return `<button class="btn btn-link p-0 btn-show-detail" data-tipe="pembelian" data-tanggal="${row.tanggal}">${formatRupiah(data)}</button>`;
                                    return formatRupiah(data);
                                }
                            }
                            // Anda bisa menambahkan render button untuk kolom pengeluaran jika perlu
                        ],
                        searching: false,
                        paging: false,
                        info: false,
                        ordering: true,
                        order: [
                            [0, 'asc']
                        ]
                    });

                    // Inisialisasi Chart (dengan perbaikan)
                    const chartElement = document.getElementById('labaRugiChart');
                    if (chart) chart.destroy();
                    const options = {
                        series: [{
                                name: 'Pendapatan',
                                type: 'column',
                                data: data.map(item => item.total_pendapatan)
                            },
                            {
                                name: 'Pengeluaran',
                                type: 'column',
                                data: data.map(item => item.pengeluaran_operasional) // <-- PERBAIKAN DI SINI
                            },
                            {
                                name: 'Laba Bersih',
                                type: 'line',
                                data: data.map(item => item.laba_bersih)
                            }
                        ],
                        chart: {
                            fontFamily: 'inherit',
                            type: 'line',
                            height: 350,
                            toolbar: {
                                show: false
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                borderRadius: 5
                            }
                        },
                        legend: {
                            position: 'top'
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: [0, 0, 2, 2],
                            curve: 'smooth'
                        },
                        xaxis: {
                            categories: data.map(item => moment(item.tanggal).format('DD MMM')),
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
                        fill: {
                            opacity: 1
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
                        colors: [KTUtil.getCssVariableValue('--bs-success'), KTUtil.getCssVariableValue(
                            '--bs-danger'), KTUtil.getCssVariableValue('--bs-primary')],
                        grid: {
                            borderColor: KTUtil.getCssVariableValue('--bs-gray-200'),
                            strokeDashArray: 4,
                            yaxis: {
                                lines: {
                                    show: true
                                }
                            }
                        }
                    };
                    chart = new ApexCharts(chartElement, options);
                    chart.render();
                }

                $('#laba_rugi_datatable tbody').on('click', '.btn-show-detail', function() {
                    // Mengambil data dari tombol yang diklik
                    const tipe = $(this).data('tipe');
                    const tanggal = $(this).data('tanggal');
                    const modal = $('#modal_detail_laporan');

                    // Mengatur judul modal dan menampilkan spinner loading
                    modal.find('.modal-title').text(
                        `Detail ${tipe.charAt(0).toUpperCase() + tipe.slice(1)} - ${moment(tanggal).format('DD MMMM YYYY')}`
                    );
                    modal.find('#detail-content-container').html(
                        '<div class="text-center py-10"><span class="spinner-border spinner-border-sm"></span> Loading...</div>'
                    );
                    modal.modal('show');

                    // Mengambil data detail dari server via AJAX
                    $.ajax({
                        url: "{{ route('laporan.laba-rugi.detail') }}",
                        data: {
                            tanggal: tanggal,
                            tipe: tipe
                        },
                        success: function(response) {
                            let html =
                                '<div class="alert alert-secondary text-center">Tidak ada data detail untuk tanggal ini.</div>';

                            if (response && response.length > 0) {

                                // ==========================================================
                                //  LOGIKA UNTUK MENAMPILKAN DETAIL PENDAPATAN (PENJUALAN)
                                // ==========================================================
                                if (tipe === 'pendapatan') {
                                    html = `<div class="table-responsive">
                                <table class="table table-sm table-row-dashed fs-6 gy-4">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th>Barang</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                                    response.forEach(d => {
                                        html += `<tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-800 fw-bold">${d.barang?.nama ?? 'N/A'}</span>
                                            <small class="text-muted">${d.barang?.kode_barang ?? ''}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">${d.qty}</td>
                                    <td class="text-end">${formatRupiah(d.subtotal)}</td>
                                 </tr>`;
                                    });
                                    html += '</tbody></table></div>';
                                }

                                // ==========================================================
                                //  LOGIKA UNTUK MENAMPILKAN DETAIL PEMBELIAN (BARANG MASUK)
                                // ==========================================================
                                else if (tipe === 'pembelian') {
                                    html = ''; // Reset html
                                    response.forEach(trx => {
                                        html += `<div class="mb-5">
                                    <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom">
                                        <span class="fw-bold fs-6 text-gray-800">${trx.kode_transaksi}</span>
                                        <span class="text-muted fs-7">Supplier: ${trx.supplier?.nama ?? 'N/A'}</span>
                                    </div>
                                    <table class="table table-sm fs-6">
                                        <tbody>`;
                                        trx.detail.forEach(item => {
                                            html += `<tr>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800">${item.barang?.nama ?? 'N/A'}</span>
                                                <small class="text-muted">${item.qty} Pcs</small>
                                            </div>
                                        </td>
                                        <td class="text-end">${formatRupiah(item.subtotal)}</td>
                                     </tr>`;
                                        });
                                        html += `</tbody></table></div>`;
                                    });
                                }

                                // ==========================================================
                                //  LOGIKA UNTUK MENAMPILKAN DETAIL BIAYA OPERASIONAL
                                // ==========================================================
                                else if (tipe === 'pengeluaran') {
                                    html = ''; // Reset html
                                    response.forEach(trx => {
                                        html += `<div class="mb-5">
                                    <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom">
                                        <span class="fw-bold fs-6 text-gray-800">${trx.kode_transaksi}</span>
                                        <span class="text-muted fs-7">${trx.catatan ?? ''}</span>
                                    </div>
                                    <table class="table table-sm fs-6">
                                        <tbody>`;
                                        trx.details.forEach(detail => {
                                            html += `<tr>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800">${detail.nama}</span>
                                                <small class="text-muted">Kategori: ${detail.kategori?.nama ?? 'N/A'}</small>
                                            </div>
                                        </td>
                                        <td class="text-end">${formatRupiah(detail.jumlah)}</td>
                                     </tr>`;
                                        });
                                        html += `</tbody></table></div>`;
                                    });
                                }
                            }
                            // Masukkan HTML yang sudah dibuat ke dalam modal
                            modal.find('#detail-content-container').html(html);
                        },
                        error: function() {
                            // Tampilkan pesan error jika AJAX gagal
                            modal.find('#detail-content-container').html(
                                '<div class="alert alert-danger text-center">Gagal memuat data detail.</div>'
                            );
                        }
                    });
                });

                $('#btn-print-laporan').on('click', function() {
                    const ukuran = $('#ukuran_kertas').val();
                    const orientasi = $('#orientasi_kertas').val();
                    const tanggal = $('#filter_tanggal').val();

                    if (!tanggal) {
                        Swal.fire('Perhatian', 'Harap pilih rentang tanggal terlebih dahulu!', 'warning');
                        return;
                    }

                    const [start, end] = tanggal.split(' to ');
                    const url = new URL("{{ route('laporan.laba-rugi.export-pdf') }}", window.location.origin);
                    url.searchParams.append('filter_tanggal_start', start);
                    url.searchParams.append('filter_tanggal_end', end);
                    url.searchParams.append('ukuran_kertas', ukuran);
                    url.searchParams.append('orientasi_kertas', orientasi);

                    window.open(url.toString(), '_blank');
                });
            });
        </script>
    @endpush
@endsection
