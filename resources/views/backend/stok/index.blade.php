@extends('layouts.backend.index')
@section('title', 'Laporan Stok Barang')
@section('content')

    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Laporan Stok Barang
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted"><a class="text-muted text-hover-primary">Home</a></li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">Laporan</li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-gray-900">Stok Barang</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title flex-column">
                    <h3 class="fw-semibold mb-1">Data Stok Barang Saat Ini</h3>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#btn-export">
                            <i class="ki-outline ki-printer fs-2 me-2"></i> Export
                        </button>
                        {{-- FILTERS --}}
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

                    </div>
                </div>
            </div>

            <div class="card-body py-4">
                {{-- Statistik Box --}}
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-4">
                        <div class="card bg-light-primary hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-primary fw-bold fs-2 mb-2 mt-5" id="stat-total-stok">-</div>
                                <div class="fw-semibold text-primary">Total Stok</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card bg-light-info hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-info fw-bold fs-2 mb-2 mt-5" id="stat-total-barang">-</div>
                                <div class="fw-semibold text-info">Total Jenis Barang</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card bg-light-danger hoverable card-xl-stretch">
                            <div class="card-body">
                                <div class="text-danger fw-bold fs-2 mb-2 mt-5" id="stat-stok-kritis">-</div>
                                <div class="fw-semibold text-danger">Stok Hampir Habis (<= 10)</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Chart --}}
                    {{-- <div class="row my-10">
                        <div id="stokChart" style="height: 350px;"></div>
                    </div> --}}

                    {{-- Tabel Data --}}
                    <div class="table-responsive mt-5">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="stok_table">
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Size</th>
                                    <th>Stok</th>
                                    <th>Brand</th>
                                    <th>Kategori</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" id="btn-export">
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Export Laporan Stok</h3>
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"><i
                                    class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                        class="path2"></span></i></div>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-wrap gap-5">
                                <div class="fv-row w-100 flex-md-root"><label class="required form-label">Ukuran
                                        Kertas</label><select class="form-select" name="ukuran_kertas" id="ukuran_kertas">
                                        <option value="A4">A4</option>
                                        <option value="F4">F4</option>
                                    </select></div>
                                <div class="fv-row w-100 flex-md-root"><label class="required form-label">Orientasi
                                        Kertas</label><select class="form-select" name="orientasi_kertas"
                                        id="orientasi_kertas">
                                        <option value="portrait">Portrait</option>
                                        <option value="landscape">Landscape</option>
                                    </select></div>
                            </div>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Close</button><button type="button"
                                class="btn btn-sm btn-primary" id="btn-print-laporan">Print</button></div>
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

                    table = $('#stok_table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('stok.data') }}",
                            data: function(d) {
                                d.filter_kategori = $('#filter_kategori').val();
                                d.filter_brand = $('#filter_brand').val();
                            },
                            dataSrc: function(json) {
                                $('#stat-total-stok').text(json.total_stok ?? 0);
                                $('#stat-total-barang').text(json.total_jenis_barang ?? 0);
                                $('#stat-stok-kritis').text(json.stok_kritis ?? 0);
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
                                name: 'kode_barang'
                            },
                            {
                                data: 'nama',
                                name: 'nama'
                            },
                            {
                                data: 'size',
                                name: 'size'
                            },
                            {
                                data: 'stok',
                                name: 'stok',
                                className: 'text-left'
                            },
                            {
                                data: 'brand',
                                name: 'brand.nama'
                            },
                            {
                                data: 'kategori',
                                name: 'kategori.nama'
                            },
                        ],
                        order: [
                            [6, 'asc']
                        ]
                    });

                    function reloadData() {
                        table.ajax.reload();
                        fetchChart();
                    }

                    $('#filter_kategori, #filter_brand').on('change', function() {
                        reloadData();
                    });

                    function fetchChart() {
                        $.get("{{ route('stok.chart') }}", {
                            filter_kategori: $('#filter_kategori').val(),
                            filter_brand: $('#filter_brand').val(),
                        }, function(data) {
                            renderApexChart(data);
                        });
                    }

                    function renderApexChart(data) {
                        const chartElement = document.getElementById('stokChart');
                        if (!chartElement) return;
                        if (chart) chart.destroy();
                        const options = {
                            series: [{
                                name: 'Stok',
                                data: Object.values(data)
                            }],
                            chart: {
                                type: 'bar',
                                height: 350,
                                toolbar: {
                                    show: false
                                }
                            },
                            plotOptions: {
                                bar: {
                                    borderRadius: 4,
                                    horizontal: true,
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                formatter: val => val,
                                style: {
                                    colors: ['#fff']
                                }
                            },
                            xaxis: {
                                categories: Object.keys(data),
                                labels: {
                                    show: false
                                }
                            },
                            colors: [KTUtil.getCssVariableValue('--bs-danger')],
                            title: {
                                text: '10 Barang dengan Stok Terendah',
                                align: 'center'
                            },
                            tooltip: {
                                y: {
                                    formatter: (val) => val + ' Pcs'
                                }
                            }
                        };
                        chart = new ApexCharts(chartElement, options);
                        chart.render();
                    }

                    fetchChart(); // Load chart for the first time

                    // index.blade.php

                    // Ganti dengan fungsi 'async' untuk menunggu proses pembuatan gambar chart
                    $('#btn-print-laporan').on('click', async function() {
                        const button = $(this);
                        // Tambahkan indikator loading untuk user experience yang lebih baik
                        button.attr('data-kt-indicator', 'on').prop('disabled', true);

                        try {

                            // 2. Buat URL seperti sebelumnya
                            const url = new URL("{{ route('stok.export') }}");
                            url.searchParams.set('ukuran', $('#ukuran_kertas').val());
                            url.searchParams.set('orientasi', $('#orientasi_kertas').val());
                            url.searchParams.set('kategori_id', $('#filter_kategori').val());
                            url.searchParams.set('brand_id', $('#filter_brand').val());

                            // 4. Buka URL di tab baru
                            window.open(url.toString(), '_blank');

                        } catch (error) {
                            console.error("Gagal membuat gambar chart:", error);
                            // Anda bisa menambahkan notifikasi error di sini jika perlu
                            Swal.fire('Error', 'Gagal memproses laporan.', 'error');
                        } finally {
                            // Hapus indikator loading setelah selesai (baik berhasil maupun gagal)
                            button.removeAttr('data-kt-indicator').prop('disabled', false);
                        }
                    });
                });
            </script>
        @endpush
    @endsection
