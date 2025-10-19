@extends('layouts.backend.index')
@section('title', 'Laporan Laba Rugi Harian')
@section('content')

    {{-- Toolbar (Bisa disesuaikan) --}}
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Laporan Laba Rugi Harian (Detail)
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Laporan</li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-gray-900">Laba Rugi Harian</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title flex-column">
                    <h3 class="fw-semibold mb-1">Pilih Tanggal Laporan</h3>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <button type="button" class="btn btn-sm btn-primary btn-export d-none" data-bs-toggle="modal"
                            data-bs-target="#btn-export">
                            <i class="ki-outline ki-printer fs-2 me-2"></i> Export PDF
                        </button>
                        <div class="position-relative">
                            {{-- GANTI DENGAN FLATPCIKR --}}
                            <input class="form-control form-control-sm form-control-solid" placeholder="Pilih tanggal"
                                name="filter_tanggal" id="filter_tanggal" autocomplete="off" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body py-4">

                {{-- KONTEN LAPORAN (AWALNYA DI-SEMBUNYIKAN) --}}
                <div id="laporan-wrapper" class="d-none">

                    {{-- Statistik Box --}}
                    <div class="row g-5 g-xl-8 mb-10">
                        <div class="col-xl-3">
                            <div class="card bg-light-success hoverable card-xl-stretch">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div class="text-success fw-bold fs-2 mb-3" id="stat-total-penjualan">-</div>
                                    <div class="fw-semibold text-success">Total Penjualan</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card bg-light-warning hoverable card-xl-stretch">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div class="text-warning fw-bold fs-2 mb-3" id="stat-total-pembelian">-</div>
                                    <div class="fw-semibold text-warning">Total Pembelian</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card bg-light-danger hoverable card-xl-stretch">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div class="text-danger fw-bold fs-2 mb-3" id="stat-total-pengeluaran">-</div>
                                    <div class="fw-semibold text-danger">Total Pengeluaran</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card bg-light-primary hoverable card-xl-stretch">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div class="text-primary fw-bold fs-2 mb-3" id="stat-laba-rugi">-</div>
                                    <div class="fw-semibold text-primary">Laba / Rugi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Statistik Box --}}

                    <div class="row g-5 g-xl-8">
                        {{-- KOLOM KIRI (PENJUALAN & PEMBELIAN) --}}
                        <div class="col-lg-6">
                            <div class="card card-flush mb-8">
                                <div class="card-header">
                                    <h3 class="card-title">Detail Penjualan (Pendapatan)</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                            <thead>
                                                <tr class="fw-bold text-muted">
                                                    <th>Nama Barang</th>
                                                    <th class="text-end">Qty</th>
                                                    <th class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel-detail-penjualan">
                                                {{-- Diisi oleh JS --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-flush">
                                <div class="card-header">
                                    <h3 class="card-title">Detail Pembelian (Barang Masuk)</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                            <thead>
                                                <tr class="fw-bold text-muted">
                                                    <th>No. Transaksi</th>
                                                    <th>Nama Barang</th>
                                                    <th class="text-end">Qty</th>
                                                    <th class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel-detail-pembelian">
                                                {{-- Diisi oleh JS --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- <-- INI PERBAIKANNYA (PENUTUP div.col-lg-6 KIRI) --}}


                        {{-- KOLOM KANAN (PENGELUARAN & KOMPARASI PROFIT) --}}
                        <div class="col-lg-6">
                            <div class="card card-flush mb-8">
                                <div class="card-header">
                                    <h3 class="card-title">Detail Pengeluaran (Biaya)</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                            <thead>
                                                <tr class="fw-bold text-muted">
                                                    <th>Keterangan</th>
                                                    <th>Kategori</th>
                                                    <th class="text-end">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel-detail-pengeluaran">
                                                {{-- Diisi oleh JS --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-flush">
                                <div class="card-header">
                                    <h3 class="card-title">Komparasi Profit Item Terjual</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                            <thead>
                                                <tr class="fw-bold text-muted">
                                                    <th>Nama Barang</th>
                                                    <th class="text-end">Hrg. Beli</th>
                                                    <th class="text-end">Hrg. Jual</th>
                                                    <th class="text-end">Qty</th>
                                                    <th class="text-end">Profit</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabel-komparasi-profit">
                                                {{-- Diisi oleh JS --}}
                                            </tbody>
                                            <tfoot class="fw-semibold">
                                                <tr class="table-light">
                                                    <th colspan="4" class="text-end">Total Profit Kotor</th>
                                                    <th class="text-end" id="tfoot-total-profit-kotor">Rp0</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> {{-- Ini penutup untuk div.row.g-5.g-xl-8 --}}

                </div>
                {{-- END KONTEN LAPORAN --}}

                {{-- Tampilan Awal (Loading) --}}
                <div id="loading-wrapper" class="text-center py-10">
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span> Loading...
                </div>
                <div id="placeholder-wrapper" class="text-center text-muted py-10">
                    Silakan pilih tanggal untuk menampilkan laporan detail.
                </div>
            </div>
        </div> {{-- Ini penutup untuk div.card --}}

        {{-- Modal Export (Tidak berubah signifikan) --}}
        <div class="modal fade" tabindex="-1" id="btn-export">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Export Laporan Laba Rugi Harian</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </div>
                    </div>
                    <div class="modal-body">
                        {{-- ... (Pilihan Kertas & Orientasi) ... --}}
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
    </div> {{-- Ini penutup untuk kt_app_content --}}

    @push('stylesheets')
        <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}">
    @endpush

    @push('scripts')
        {{-- SAYA TAMBAHKAN INI UNTUK MOMENT.JS --}}
        <script src="{{ URL::to('assets/plugins/global/plugins.bundle.js') }}"></script>

        <script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script>
            $(document).ready(function() {
                const formatRupiah = (number) => 'Rp ' + (Number(number) || 0).toLocaleString('id-ID');

                // Sembunyikan wrapper saat load
                $('#loading-wrapper').hide();
                $('#laporan-wrapper').hide();

                // Inisialisasi Flatpickr
                $("#filter_tanggal").flatpickr({
                    dateFormat: "Y-m-d",
                    defaultDate: new Date(), // Set default ke hari ini
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates[0]) {
                            $('.btn-export').removeClass('d-none');
                            fetchAndRenderData(dateStr);
                        }
                    }
                });

                // Trigger load data untuk hari ini saat halaman pertama kali dibuka
                // Pastikan moment.js sudah di-load
                if (typeof moment === 'function') {
                    fetchAndRenderData(moment().format('YYYY-MM-DD'));
                } else {
                    console.error('Moment.js tidak ter-load. Menggunakan tanggal hari ini.');
                    fetchAndRenderData(new Date().toISOString().split('T')[0]);
                }

                function fetchAndRenderData(selectedDate) {
                    // Tampilkan loading, sembunyikan data lama dan placeholder
                    $('#loading-wrapper').show();
                    $('#laporan-wrapper').hide();
                    $('#placeholder-wrapper').hide();

                    $.ajax({
                        url: "{{ route('laporan.laba-rugi-harian.get-data') }}",
                        method: "GET",
                        data: {
                            filter_tanggal: selectedDate
                        },
                        success: function(response) {
                            renderData(response);
                            $('#loading-wrapper').hide();
                            $('#laporan-wrapper').removeClass('d-none');
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal mengambil data laporan.', 'error');
                            $('#loading-wrapper').hide();
                            $('#placeholder-wrapper').show();
                        }
                    });
                }

                function renderData(data) {
                    // 1. Isi Statistik Box
                    $('#stat-total-penjualan').text(formatRupiah(data.total_penjualan));
                    $('#stat-total-pembelian').text(formatRupiah(data.total_pembelian));
                    $('#stat-total-pengeluaran').text(formatRupiah(data.total_pengeluaran));
                    $('#stat-laba-rugi').text(formatRupiah(data.laba_rugi));

                    // 2. Isi Tabel Detail Penjualan
                    let htmlPenjualan = '';
                    if (data.detail_penjualan.length > 0) {
                        data.detail_penjualan.forEach(item => {
                            htmlPenjualan += `
                                <tr>
                                    <td>${item.barang?.nama ?? 'N/A'}</td>
                                    <td class="text-end">${item.qty}</td>
                                    <td class="text-end">${formatRupiah(item.subtotal)}</td>
                                </tr>
                            `;
                        });
                    } else {
                        htmlPenjualan =
                            '<tr><td colspan="3" class="text-center text-muted">Tidak ada penjualan</td></tr>';
                    }
                    $('#tabel-detail-penjualan').html(htmlPenjualan);

                    // 3. Isi Tabel Detail Pembelian
                    let htmlPembelian = '';
                    if (data.detail_pembelian.length > 0) {
                        data.detail_pembelian.forEach(item => {
                            htmlPembelian += `
                                <tr>
                                    <td>${item.barang_masuk?.kode_transaksi ?? '-'}</td>
                                    <td>${item.barang?.nama ?? 'N/A'}</td>
                                    <td class="text-end">${item.qty}</td>
                                    <td class="text-end">${formatRupiah(item.subtotal)}</td>
                                </tr>
                            `;
                        });
                    } else {
                        htmlPembelian =
                            '<tr><td colspan="4" class="text-center text-muted">Tidak ada pembelian</td></tr>';
                    }
                    $('#tabel-detail-pembelian').html(htmlPembelian);

                    // 4. Isi Tabel Detail Pengeluaran
                    let htmlPengeluaran = '';
                    if (data.detail_penjualan.length > 0) { // <-- INI BUG DARI KODE ASLI, SAYA PERBAIKI
                        data.detail_pengeluaran.forEach(item => { // <-- Seharusnya data.detail_pengeluaran
                            htmlPengeluaran += `
                                <tr>
                                    <td>${item.nama}</td>
                                    <td>${item.kategori?.nama ?? 'N/A'}</td>
                                    <td class="text-end">${formatRupiah(item.jumlah)}</td>
                                </tr>
                            `;
                        });
                    } else {
                        htmlPengeluaran =
                            '<tr><td colspan="3" class="text-center text-muted">Tidak ada pengeluaran</td></tr>';
                    }
                    $('#tabel-detail-pengeluaran').html(htmlPengeluaran);

                    // 5. Isi Tabel Komparasi Profit
                    let htmlKomparasi = '';
                    if (data.detail_penjualan.length > 0) {
                        data.detail_penjualan.forEach(item => {
                            let profit = item.subtotal - (item.harga_beli * item.qty);
                            htmlKomparasi += `
                                <tr>
                                    <td>${item.barang?.nama ?? 'N/A'}</td>
                                    <td class="text-end">${formatRupiah(item.harga_beli)}</td>
                                    <td class="text-end">${formatRupiah(item.harga_jual)}</td>
                                    <td class="text-end">${item.qty}</td>
                                    <td class="text-end">${formatRupiah(profit)}</td>
                                </tr>
                            `;
                        });
                    } else {
                        htmlKomparasi =
                            '<tr><td colspan="5" class="text-center text-muted">Tidak ada penjualan</td></tr>';
                    }
                    $('#tabel-komparasi-profit').html(htmlKomparasi);
                    $('#tfoot-total-profit-kotor').text(formatRupiah(data.total_profit_kotor));
                }

                // Fungsi Tombol Print (Export PDF)
                $('#btn-print-laporan').on('click', function() {
                    const ukuran = $('#ukuran_kertas').val();
                    const orientasi = $('#orientasi_kertas').val();
                    const tanggal = $('#filter_tanggal').val();

                    if (!tanggal) {
                        Swal.fire('Perhatian', 'Harap pilih tanggal terlebih dahulu!', 'warning');
                        return;
                    }

                    const url = new URL("{{ route('laporan.laba-rugi-harian.export-pdf') }}", window.location
                        .origin);
                    url.searchParams.set('ukuran_kertas', ukuran);
                    url.searchParams.set('orientasi_kertas', orientasi);
                    url.searchParams.set('filter_tanggal', tanggal); // Kirim tanggal tunggal

                    window.open(url.toString(), '_blank');
                });
            });
        </script>
    @endpush
@endsection
