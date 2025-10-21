@extends('layouts.backend.index')
@section('title', 'Laporan Penjualan Harian')
@section('content')

    {{-- Toolbar (Tidak Berubah) --}}
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Laporan Penjualan Harian
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted"><a class="text-muted text-hover-primary">Home</a></li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">Laporan</li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-gray-900">Penjualan Harian</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div class="card">
            {{-- Filter (Tidak Berubah) --}}
            <div class="card-header border-0 pt-6">
                <div class="card-title flex-column">
                    <h3 class="fw-semibold mb-1">Data Laporan Penjualan Harian</h3>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-primary btn-export d-none" data-bs-toggle="modal"
                            data-bs-target="#btn-export">
                            <i class="ki-outline ki-printer fs-2 me-2"></i> Export
                        </button>
                        <div class="position-relative">
                            <select class="form-select form-select-sm" name="filter_jenis_pembayaran"
                                id="filter_jenis_pembayaran">
                                <option value="">Semua Pembayaran</option>
                                @foreach ($jenisPembayaran as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="position-relative">
                            <input class="form-control form-control-sm" placeholder="Pilih tanggal" name="filter_tanggal"
                                id="filter_tanggal" autocomplete="off" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body py-4">
                {{-- Statistik Box (Tidak Berubah) --}}
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
                            {{-- =================================== --}}
                            {{-- PERUBAHAN: Thead diubah (lebih sedikit kolom) --}}
                            {{-- =================================== --}}
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="chimox">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-25px"></th> {{-- Kolom untuk tombol expander --}}
                                        <th class="min-w-100px">Tanggal</th>
                                        <th class="min-w-125px">No. Transaksi</th>
                                        <th class="min-w-100px">Jenis Pembayaran</th>
                                        <th class="min-w-50px text-end">Total Item</th>
                                        <th class="min-w-100px text-end">Sub Total</th>
                                        <th class="min-w-100px text-end">Potongan</th>
                                        <th class="min-w-100px text-end">Total Akhir</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-semibold"></tbody>
                                {{-- =================================== --}}
                                {{-- PERUBAHAN: tfoot disesuaikan --}}
                                {{-- =================================== --}}
                                <tfoot class="fw-bold fs-6">
                                    <tr class="table-light">
                                        <th colspan="4" class="text-end">Total</th>
                                        <th class="text-end" id="footer-total-item">0</th>
                                        <th class="text-end" id="footer-subtotal">Rp 0</th>
                                        <th class="text-end" id="footer-potongan">Rp 0</th>
                                        <th class="text-end" id="footer-total-akhir">Rp 0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{-- Summary Box Bawah (Kita masih bisa menampilkan semua data) --}}
                        <div class="d-flex justify-content-end mt-10">
                            <div class="mw-350px w-100">
                                <div class="d-flex flex-stack fs-6">
                                    <div class="fw-semibold text-gray-600">Jumlah Item Terjual:</div>
                                    <div class="fw-bold text-gray-800" id="summary-total-item">0</div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack fs-6">
                                    <div class="fw-semibold text-gray-600">Sub Total :</div>
                                    <div class="fw-bold text-gray-800" id="summary-subtotal">Rp 0</div>
                                </div>
                                <div class="d-flex flex-stack fs-6 mt-1">
                                    <div class="fw-semibold text-gray-600">Potongan :</div>
                                    <div class="fw-bold text-gray-800" id="summary-potongan">Rp 0</div>
                                </div>
                                {{-- Pajak & Biaya Lain bisa disembunyikan jika selalu 0 --}}
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack fs-5">
                                    <div class="fw-bold text-gray-800">Total Akhir :</div>
                                    <div class="fw-bold text-dark fs-4" id="summary-total-akhir">Rp 0</div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack fs-6">
                                    <div class="fw-semibold text-info">Bayar Tunai :</div>
                                    <div class="fw-bold text-info" id="summary-bayar-tunai">Rp 0</div>
                                </div>
                                <div class="d-flex flex-stack fs-6 mt-1">
                                    <div class="fw-semibold text-danger">Bayar Kredit :</div>
                                    <div class="fw-bold text-danger" id="summary-bayar-kredit">Rp 0</div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack fs-6">
                                    <div class="fw-semibold text-success">Total Profit :</div>
                                    <div class="fw-bold text-success" id="summary-profit">Rp 0</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Export (Tidak Berubah) --}}
        <div class="modal fade" tabindex="-1" id="btn-export">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Export Laporan Penjualan</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                    class="path2"></span></i>
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
                                    {{-- <option value="portrait">Portrait</option> --}}
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

    @push('stylesheets')
        <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

        <script>
            $(document).ready(function() {
                let table;
                const formatRupiah = (number) => 'Rp ' + (Number(number) || 0).toLocaleString('id-ID');

                // Inisialisasi DataTable
                table = $('#chimox').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [
                        [1, 'desc'] // Urutkan berdasarkan tanggal
                    ],
                    ajax: {
                        url: "{{ route('laporan.penjualan-harian.data') }}",
                        data: function(d) {
                            const flatpickr = document.querySelector("#filter_tanggal")._flatpickr;
                            if (flatpickr && flatpickr.selectedDates[0]) {
                                const selectedDate = moment(flatpickr.selectedDates[0]).format(
                                    'YYYY-MM-DD');
                                d.filter_tanggal_start = selectedDate;
                                d.filter_tanggal_end = selectedDate;
                            }
                            d.filter_jenis_pembayaran = $('#filter_jenis_pembayaran').val();
                        },
                        dataSrc: function(json) {
                            // --- Statistik Box Atas ---
                            $('#stat-total-transaksi').text(json.total_transaksi ?? 0);
                            $('#stat-total-penjualan').text(formatRupiah(json.total_penjualan));
                            $('#stat-total-produk').text(json.jumlah_produk_terjual ?? 0);

                            // --- Footer Tabel (tfoot) ---
                            $('#footer-total-item').text(json.footer_total_item ?? 0);
                            $('#footer-subtotal').text(formatRupiah(json.footer_subtotal));
                            $('#footer-potongan').text(formatRupiah(json.footer_potongan));
                            $('#footer-total-akhir').text(formatRupiah(json.footer_total_akhir));

                            // --- Summary Box Bawah (Masih menampilkan semua data) ---
                            $('#summary-total-item').text(json.footer_total_item ?? 0);
                            $('#summary-subtotal').text(formatRupiah(json.footer_subtotal));
                            $('#summary-potongan').text(formatRupiah(json.footer_potongan));
                            $('#summary-pajak').text(formatRupiah(json.footer_pajak));
                            $('#summary-biaya-lain').text(formatRupiah(json.footer_biaya_lain));
                            $('#summary-total-akhir').text(formatRupiah(json.footer_total_akhir));
                            $('#summary-bayar-tunai').text(formatRupiah(json.footer_bayar_tunai));
                            $('#summary-bayar-kredit').text(formatRupiah(json.footer_bayar_kredit));
                            $('#summary-profit').text(formatRupiah(json.footer_profit));

                            return json.data;
                        }
                    },
                    // ===================================
                    // PERUBAHAN: Definisi kolom diubah
                    // ===================================
                    columns: [{
                            data: 'expander',
                            name: 'expander',
                            orderable: false,
                            searchable: false,
                            className: 'dt-control'
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal_penjualan'
                        },
                        {
                            data: 'kode_transaksi',
                            name: 'kode_transaksi'
                        },
                        {
                            data: 'jenis_pembayaran',
                            name: 'pembayaran.nama',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'total_item',
                            name: 'total_item',
                            className: 'text-end'
                        },
                        {
                            data: 'sub_total_fmt',
                            name: 'sub_total_fmt', // Ini kalkulasi, tidak bisa di-sort
                            className: 'text-end',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'potongan_fmt',
                            name: 'potongan', // Bisa di-sort berdasarkan 'potongan'
                            className: 'text-end text-danger'
                        },
                        {
                            data: 'total_akhir_fmt',
                            name: 'total_harga', // Bisa di-sort berdasarkan 'total_harga'
                            className: 'text-end fw-bold'
                        },
                    ]
                });

                // Inisialisasi Flatpickr (Tidak Berubah)
                $("#filter_tanggal").flatpickr({
                    dateFormat: "Y-m-d",
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates[0]) {
                            $('#statistik-total-transaksi-wrapper, #statistik-total-penjualan-wrapper, #statistik-total-produk-wrapper')
                                .removeClass('d-none');
                            $('#table-wrapper, .btn-export').removeClass('d-none');
                            table.ajax.reload();
                        }
                    }
                });

                // Filter jenis pembayaran (Tidak Berubah)
                $('#filter_jenis_pembayaran').on('change', function() {
                    const flatpickr = document.querySelector("#filter_tanggal")._flatpickr;
                    if (flatpickr && flatpickr.selectedDates[0]) {
                        table.ajax.reload();
                    }
                });

                // ===================================
                // JAVASCRIPT BARU: Handle Child Row
                // ===================================
                $('#chimox tbody').on('click', 'button.btn-expand', function() {
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);
                    var $btn = $(this);
                    var id = $btn.data('id');

                    if (row.child.isShown()) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                        $btn.html('<i class="ki-outline ki-plus-square fs-3"></i>'); // Icon Plus
                    } else {
                        // Open this row
                        $btn.html('<span class="spinner-border spinner-border-sm"></span>'); // Loading

                        $.get("{{ route('laporan.penjualan-harian.detail-items') }}", {
                                id: id
                            })
                            .done(function(response) {
                                // Tampilkan child row dengan HTML dari controller
                                row.child(response.html).show();
                                tr.addClass('shown');
                                $btn.html('<i class="ki-outline ki-minus-square fs-3"></i>'); // Icon Minus
                            })
                            .fail(function() {
                                row.child('Error: Gagal memuat detail item.').show();
                                tr.addClass('shown');
                                $btn.html(
                                    '<i class="ki-outline ki-arrows-circle fs-3"></i>'
                                    ); // Icon Error/Refresh
                            });
                    }
                });


                // Fungsi Tombol Print (Tidak Berubah, tapi PDF-nya masih item-based)
                $('#btn-print-laporan').on('click', function() {
                    const ukuran = $('#ukuran_kertas').val();
                    const orientasi = $('#orientasi_kertas').val();
                    const tipe = $('input[name="tipe_laporan"]:checked').val();
                    const tanggal = $('#filter_tanggal').val();
                    const jenisPembayaran = $('#filter_jenis_pembayaran').val();

                    if (!tanggal) return Swal.fire('Perhatian',
                        'Silakan pilih tanggal terlebih dahulu.', 'warning');
                    if (!ukuran || !orientasi || !tipe) return Swal.fire('Perhatian',
                        'Semua opsi export wajib dipilih.', 'warning');

                    const start = tanggal;
                    const end = tanggal;

                    const url = new URL("{{ route('laporan.penjualan-harian.export') }}");
                    url.searchParams.set('ukuran', ukuran);
                    url.searchParams.set('orientasi', orientasi);
                    url.searchParams.set('tipe', tipe);
                    url.searchParams.set('start', start);
                    url.searchParams.set('end', end);
                    url.searchParams.set('jenis_pembayaran', jenisPembayaran);

                    window.open(url.toString(), '_blank');
                });
            });
        </script>
    @endpush
@endsection
