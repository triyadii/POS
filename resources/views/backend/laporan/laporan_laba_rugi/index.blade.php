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
                    <div class="col-xl-4 d-none" id="statistik-pendapatan-wrapper">
                        <div class="card bg-light-info hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="text-info fw-bold fs-2 mb-2 mt-5" id="stat-pendapatan">-</div>
                                <div class="fw-semibold text-info mb-5">Total Pendapatan</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-pengeluaran-wrapper">
                        <div class="card bg-light-danger hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="text-danger fw-bold fs-2 mb-2 mt-5" id="stat-pengeluaran">-</div>
                                <div class="fw-semibold text-danger mb-5">Total Pengeluaran (HPP)</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 d-none" id="statistik-laba-bersih-wrapper">
                        <div class="card bg-light-primary hoverable card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div class="text-primary fw-bold fs-2 mb-2 mt-5" id="stat-laba-bersih">-</div>
                                <div class="fw-semibold text-primary mb-5">Profit / Laba Bersih</div>
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
                                <th>Total Pendapatan</th>
                                <th>Pengeluaran (HPP)</th>
                                <th>Laba Bersih</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Body akan diisi oleh DataTables --}}
                        </tbody>
                        <tfoot class="fw-semibold">
                            <tr>
                                <th>Total</th>
                                <th class="text-end" id="tfoot-total-pendapatan">Rp0</th>
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
                        success: function(response) {
                            renderData(response);
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal mengambil data.', 'error');
                        }
                    });
                }

                function renderData(data) {
                    $('#statistik-pendapatan-wrapper, #statistik-pengeluaran-wrapper, #statistik-laba-bersih-wrapper')
                        .removeClass('d-none');
                    $('#chart-wrapper, #table-wrapper').removeClass('d-none');

                    let totalPendapatan = data.reduce((sum, item) => sum + Number(item.total_pendapatan), 0);
                    let totalPengeluaran = data.reduce((sum, item) => sum + Number(item.pengeluaran), 0);
                    let totalLaba = data.reduce((sum, item) => sum + Number(item.laba_bersih), 0);

                    $('#tfoot-total-pendapatan, #stat-pendapatan').text(formatRupiah(totalPendapatan));
                    $('#tfoot-total-pengeluaran, #stat-pengeluaran').text(formatRupiah(totalPengeluaran));
                    $('#tfoot-total-laba, #stat-laba-bersih').text(formatRupiah(totalLaba));

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
                                data: 'pengeluaran'
                            }, {
                                data: 'laba_bersih'
                            }
                        ],
                        columnDefs: [{
                                targets: 0,
                                render: (data) => moment(data).format('DD-MM-YYYY')
                            },
                            {
                                targets: [1, 2, 3],
                                className: 'text-end',
                                render: (data) => formatRupiah(data)
                            }
                        ],
                        searching: false,
                        paging: false,
                        info: false,
                        ordering: true,
                        order: [
                            [0, 'asc']
                        ]
                    });

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
                                data: data.map(item => item.pengeluaran)
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
                            width: [0, 0, 2],
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
