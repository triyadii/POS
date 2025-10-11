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
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2" data-kt-user-table-toolbar="base">
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
                    <div class="col-xl-4 d-none" id="statistik-pendapatan-wrapper">
                        <div class="card bg-light-info hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body">
                                <div class="text-info fw-bold fs-2 mb-2 mt-5" id="stat-pendapatan">-</div>
                                <div class="fw-semibold text-info">Total Pendapatan</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-pengeluaran-wrapper">
                        <div class="card bg-light-danger hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body">
                                <div class="text-danger fw-bold fs-2 mb-2 mt-5" id="stat-pengeluaran">-</div>
                                <div class="fw-semibold text-danger">Total Pengeluaran (HPP)</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-laba-bersih-wrapper">
                        <div class="card bg-light-primary hoverable card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-body">
                                <div class="text-primary fw-bold fs-2 mb-2 mt-5" id="stat-laba-bersih">-</div>
                                <div class="fw-semibold text-primary">Profit / Laba Bersih</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chart --}}
                <div class="row mb-10 d-none" id="chart-wrapper">
                    <div class="position-relative" style="height: 300px;">
                        <canvas id="labaRugiChart"></canvas>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="table-responsive mt-5 d-none" id="table-wrapper">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="bg-light fw-bold">
                            <tr>
                                <th class="text-nowrap">Tanggal</th>
                                <th class="text-nowrap">Total Pendapatan</th>
                                <th class="text-nowrap">Pengeluaran (HPP)</th>
                                <th class="text-nowrap">Laba Bersih</th>
                            </tr>
                        </thead>
                        <tbody id="table-laba-rugi-body">
                        </tbody>
                        <tfoot class="fw-semibold bg-secondary text-white">
                            <tr>
                                <td>Total</td>
                                <td class="text-end" id="tfoot-total-pendapatan">Rp0</td>
                                <td class="text-end" id="tfoot-total-pengeluaran">Rp0</td>
                                <td class="text-end" id="tfoot-total-laba">Rp0</td>
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
    </div>
    @push('stylesheets')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            $(document).ready(function() {
                let labaRugiChart;

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
                        success: function(response) {
                            renderData(response);
                        },
                        error: function() {
                            alert('Gagal mengambil data. Silakan coba lagi.');
                        }
                    });
                }

                function renderData(data) {
                    // Tampilkan semua wrapper
                    $('#statistik-pendapatan-wrapper, #statistik-pengeluaran-wrapper, #statistik-laba-bersih-wrapper')
                        .removeClass('d-none');
                    $('#chart-wrapper, #table-wrapper').removeClass('d-none');

                    if (labaRugiChart) {
                        labaRugiChart.destroy();
                    }

                    // =========================
                    // Hitung Total dan Isi Tabel
                    // =========================
                    let tableHTML = '';
                    let totalPendapatan = 0;
                    let totalPengeluaran = 0;
                    let totalLaba = 0;

                    data.forEach(item => {
                        totalPendapatan += Number(item.total_pendapatan);
                        totalPengeluaran += Number(item.pengeluaran);
                        totalLaba += Number(item.laba_bersih);

                        tableHTML += `
                        <tr>
                            <td>${moment(item.tanggal).format('DD-MM-YYYY')}</td>
                            <td class="text-end">Rp ${Number(item.total_pendapatan).toLocaleString('id-ID')}</td>
                            <td class="text-end">Rp ${Number(item.pengeluaran).toLocaleString('id-ID')}</td>
                            <td class="text-end fw-bold">Rp ${Number(item.laba_bersih).toLocaleString('id-ID')}</td>
                        </tr>
                    `;
                    });

                    $('#table-laba-rugi-body').html(tableHTML);
                    $('#tfoot-total-pendapatan').text('Rp ' + totalPendapatan.toLocaleString('id-ID'));
                    $('#tfoot-total-pengeluaran').text('Rp ' + totalPengeluaran.toLocaleString('id-ID'));
                    $('#tfoot-total-laba').text('Rp ' + totalLaba.toLocaleString('id-ID'));

                    // =========================
                    // Statistik Atas
                    // =========================
                    $('#stat-pendapatan').text('Rp ' + totalPendapatan.toLocaleString('id-ID'));
                    $('#stat-pengeluaran').text('Rp ' + totalPengeluaran.toLocaleString('id-ID'));
                    $('#stat-laba-bersih').text('Rp ' + totalLaba.toLocaleString('id-ID'));

                    // =========================
                    // Render Chart
                    // =========================
                    const labels = data.map(item => moment(item.tanggal).format('DD MMM'));
                    const pendapatan = data.map(item => item.total_pendapatan);
                    const pengeluaran = data.map(item => item.pengeluaran);
                    const laba = data.map(item => item.laba_bersih);

                    const ctx = document.getElementById('labaRugiChart').getContext('2d');
                    labaRugiChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Pendapatan',
                                data: pendapatan,
                                backgroundColor: '#50cd89',
                            }, {
                                label: 'Pengeluaran',
                                data: pengeluaran,
                                backgroundColor: '#f1416c',
                            }, {
                                label: 'Laba Bersih',
                                data: laba,
                                type: 'line',
                                borderColor: '#009ef7',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4,
                            }]
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
                                    position: 'top'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let val = context.raw;
                                            return `${context.dataset.label}: Rp ${Number(val).toLocaleString('id-ID')}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    stacked: true
                                },
                                y: {
                                    stacked: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + value.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                $('#btn-print-laporan').on('click', function() {
                    const ukuran = $('#ukuran_kertas').val();
                    const orientasi = $('#orientasi_kertas').val();
                    const tanggal = $('#filter_tanggal').val();

                    if (!tanggal) {
                        alert('Harap pilih rentang tanggal terlebih dahulu!');
                        return;
                    }

                    const dateParts = tanggal.split(' to ');
                    const start = dateParts[0];
                    const end = dateParts[1];

                    const url = new URL("{{ route('laporan.laba-rugi.export-pdf') }}", window.location.origin);
                    url.searchParams.append('filter_tanggal_start', start);
                    url.searchParams.append('filter_tanggal_end', end);
                    url.searchParams.append('ukuran_kertas', ukuran);
                    url.searchParams.append('orientasi_kertas', orientasi);

                    window.open(url, '_blank');
                });
            });
        </script>
    @endpush
@endsection
