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
                        {{-- MODIFIKASI: Tombol export langsung tampil --}}
                        <button type="button" class="btn btn-sm btn-primary btn-export" data-bs-toggle="modal"
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

                {{-- KONTEN LAPORAN --}}
                {{-- MODIFIKASI: Hapus 'd-none' dan cetak $laporanHtml --}}
                <div id="laporan-wrapper">
                    {!! $laporanHtml !!}
                </div>
                {{-- END KONTEN LAPORAN --}}

                {{-- Tampilan Awal (Loading & Placeholder) --}}
                {{-- MODIFIKASI: Tambahkan 'd-none' agar tersembunyi di awal --}}
                <div id="loading-wrapper" class="text-center py-10 d-none">
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span> Loading...
                </div>
                <div id="placeholder-wrapper" class="text-center text-muted py-10 d-none">
                    Silakan pilih tanggal untuk menampilkan laporan detail.
                </div>
            </div>
        </div> {{-- Ini penutup untuk div.card --}}

        {{-- Modal Export (Tidak berubah) --}}
        <div class="modal fade" tabindex="-1" id="btn-export">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Export Laporan Laba Rugi Harian</h3>
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
    </div> {{-- Ini penutup untuk kt_app_content --}}

    @push('stylesheets')
        <link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}">
    @endpush

    @push('scripts')
        {{-- Pastikan plugins.bundle.js memuat moment.js --}}
        <script src="{{ URL::to('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

        <script>
            $(document).ready(function() {
                // Sembunyikan wrapper yang tidak perlu saat load
                $('#loading-wrapper').hide();
                $('#placeholder-wrapper').hide();

                // Inisialisasi Flatpickr
                $("#filter_tanggal").flatpickr({
                    dateFormat: "Y-m-d",
                    defaultDate: new Date(), // Set default ke hari ini
                    onChange: function(selectedDates, dateStr, instance) {
                        // Hanya panggil AJAX jika tanggal dipilih
                        if (selectedDates[0]) {
                            fetchAndRenderData(dateStr);
                        }
                    }
                });

                // MODIFIKASI: Hapus trigger AJAX saat load
                // Data hari ini sudah di-render oleh server.
                /*
                if (typeof moment === 'function') {
                    fetchAndRenderData(moment().format('YYYY-MM-DD'));
                } else {
                    console.error('Moment.js tidak ter-load. Menggunakan tanggal hari ini.');
                    fetchAndRenderData(new Date().toISOString().split('T')[0]);
                }
                */

                /**
                 * Fungsi ini sekarang HANYA digunakan saat tanggal diubah.
                 */
                function fetchAndRenderData(selectedDate) {
                    // Tampilkan loading, sembunyikan data lama dan placeholder
                    $('#loading-wrapper').show();
                    $('#laporan-wrapper').hide().empty(); // Kosongkan wrapper lama
                    $('#placeholder-wrapper').hide();

                    $.ajax({
                        url: "{{ route('laporan.laba-rugi-harian.get-data') }}",
                        method: "GET",
                        data: {
                            filter_tanggal: selectedDate
                        },
                        success: function(response) {
                            // Masukkan HTML yang sudah jadi
                            $('#laporan-wrapper').html(response.html);

                            // Tampilkan hasilnya
                            $('#loading-wrapper').hide();
                            $('#laporan-wrapper').show(); // Ganti dari removeClass('d-none')
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal mengambil data laporan.', 'error');
                            $('#loading-wrapper').hide();
                            $('#placeholder-wrapper').show();
                        }
                    });
                }

                // Fungsi Tombol Print (Export PDF) - Tidak berubah
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
