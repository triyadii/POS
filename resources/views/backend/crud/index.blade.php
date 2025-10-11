@extends('layouts.backend.index_kasir')
@section('title', 'Penjualan')
@section('content')
{{-- <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
        <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Barang
                    Masuk List</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Resources</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Barang Masuk</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-gray-900">Barang Masuk List</li>
                </ul>
            </div>
            <div class="d-flex align-items-center pt-4 pb-7 pt-lg-1 pb-lg-2">

                <button type="button" class="btn btn-sm btn-primary me-2">
                    <i class="ki-outline ki-plus fs-2"></i>Kalkulator</button>
                <button type="button" class="btn btn-sm btn-primary me-2">
                    <i class="ki-outline ki-plus fs-2"></i>Daftar Produk</button>


            </div>
        </div>
    </div>
    <!--end::Toolbar--> --}}
<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column flex-row-fluid">
    <div class="row gx-6 gx-xl-9">
        <!--begin::Col-->
        <div class="col-lg-7">
            <!--begin::Summary-->
            <div class="card card-flush h-lg-100 ">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 bg-primary ">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bold mb-1 text-white">List Penjualan</h3>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar d-flex gap-2">
                        @if ($kas && $kas->kasir_tutup_at == null)
                        <form id="form-tutup-kasir" action="{{ route('kasir.close') }}" method="POST">
                            @csrf
                            <button type="button" id="btn-tutup-kasir" class="btn btn-sm btn-light-danger">
                                Tutup Kasir
                            </button>
                        </form>
                        @endif





                        <a href="{{ route('data-penjualan.index') }}" class="btn btn-light-info btn-sm">
                            History Penjualan
                        </a>
                        <a href="{{ route('customer.index') }}" class="btn btn-sm btn-light-primary">
                            <i class="ki-outline ki-plus fs-2 me-2"></i>Customer
                        </a>
                    </div>

                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9 pt-5">
                    <form id="form-penjualan">
                        @csrf
                        <div class="row gx-6 gx-xl-9 mb-2">
                            <div class="col-lg-6 mb-2">
                                <div class="fv-row">
                                    <input type="text" class="form-control " name="tanggal" id="tanggal" />
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="fv-row">
                                    <input type="text" class="form-control form-control-solid" name="no_penjualan"
                                        id="no_penjualan" value="{{ $no_penjualan }}" placeholder="nomor penjualan"
                                        readonly />
                                </div>
                            </div>
                        </div>

                        <div class="row gx-6 gx-xl-9 align-items-end mb-6">
                            <div class="col-lg-9 mb-2">
                                <div class="fv-row">
                                    <select class="form-select mb-3 mb-lg-0" data-control="select2" name="customer_id"
                                        id="customer_id" data-placeholder="pilih customer"
                                        data-allow-clear="true"></select>
                                </div>
                            </div>
                            <div class="col-lg-3 text-end mb-2">
                                <div class="fv-row">
                                    <select class="form-select mb-3 mb-lg-0" data-control="select2" name="meja_id"
                                        id="meja_id" data-placeholder="pilih meja" data-allow-clear="true"></select>
                                </div>
                            </div>
                        </div>
                        <div class="cart-payment mb-5">
                            <div class="table-responsive mb-6">
                                <table class="table table-bordered">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th class="border table-background">Nama Produk</th>
                                            <th class="border table-background">SKU</th>
                                            <th class="border table-background">Harga</th>
                                            <th class="border table-background">Qty</th>
                                            <th class="border table-background">Sub Total</th>
                                            <th class="border table-background text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-start" id="purchase_cart_list">
                                    </tbody>
                                </table>
                            </div>

                            <div class="hr-container">
                                <hr>
                            </div>

                        </div>

                        <div class="row gx-6 gx-xl-9 align-items-end mb-6">
                            <div class="col-lg-6">
                                <div class="fv-row mb-2">
                                    <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Uang Diterima</label>
                                    <input type="tel" class="form-control" name="uang_diterima"
                                        id="uang-diterima-penjualan" placeholder="0" autocomplete="off" />

                                    {{-- <input type="tel" class="form-control" name="uang_diterima"
                                            id="uang-diterima-penjualan" placeholder="0" inputmode="numeric"
                                            pattern="[0-9]*" autocomplete="off" /> --}}
                                </div>
                                <div class="fv-row mb-2">
                                    <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Kembalian</label>
                                    <input type="text" class="form-control form-control-solid" name="kembalian"
                                        id="kembalian-penjualan" placeholder="0" readonly />
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="fv-row mb-2">
                                    <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Total</label>
                                    <input type="text" class="form-control form-control-solid" name="total"
                                        id="total-penjualan" placeholder="0" readonly />
                                </div>
                                <div class="fv-row mb-2">
                                    <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Pembayaran</label>
                                    <select class="form-select" name="pembayaran" id="pembayaran-penjualan">
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="hutang">Hutang</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="exampleFormControlTextarea1" class="form-label">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="2"></textarea>
                        </div>

                        <div class="row gx-6 gx-xl-9 align-items-end mb-6">
                            <div class="col-lg-6 mb-2">
                                <button type="button" class="btn btn-sm btn-light-danger w-100"
                                    id="btn-batal-penjualan">
                                    Batal
                                </button>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" id="btn-simpan-penjualan"
                                    class="btn btn-sm btn-light-primary w-100">
                                    Simpan
                                </button>
                            </div>
                        </div>
                </div>
                </form>
                <!--end::Card body-->
            </div>
            <!--end::Summary-->
        </div>
        <!--end::Col-->



        <!--begin::Col-->
        <div class="col-lg-5">
            <!--begin::Card-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header align-items-center bg-primary">
                    <div class="row align-items-center gx-2 w-100">
                        <div class="col-lg-6 mb-3 mb-lg-0">
                            <input type="text" class="form-control form-control-sm" id="filter-cari-daftar-produk"
                                placeholder="Cari Produk" />
                        </div>

                        <div class="col-lg-5 mb-3 mb-lg-0">
                            <select class="form-select form-select-sm" data-control="select2"
                                id="filter-kategori-daftar-produk" data-placeholder="Pilih Kategori"
                                data-allow-clear="true"></select>
                        </div>

                        <div class="col-lg-1 text-end">
                            <a id="btnFullscreen" class=" btn btn-sm  fs-2 w-100">
                                <i class="fas fa-expand text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>


                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9 pt-3">

                    <!--begin::Produk list-->
                    <div class="row daftar-produk"></div>


                    <!--end::Produk list-->
                </div>
                <!--end::Card body-->
                <div class="card-footer">
                    <div class="d-flex justify-content-center mt-4">
                        <ul class="pagination" id="produk-pagination"></ul>
                    </div>
                </div>
            </div>
            <!--end::Card-->

        </div>
        <!--end::Col-->

    </div>
</div>
<!--end::Content-->


<div class="modal fade" id="modalPenjualanSelesai" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-350px">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            {{-- <div class="modal-body text-center p-5" style="min-height: 480px;"> --}}
            <div class="modal-body text-center p-5">

                <!-- Ikon sukses -->
                <div class="mb-4">
                    <div
                        style="width: 60px; height: 60px; border-radius: 50%; background: #e9fbee; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check text-success fs-2x"></i>
                    </div>
                    <h4 class="mt-3 fw-bold text-dark">Sukses!</h4>
                </div>

                <!-- Info transaksi -->
                <div class="bg-white text-dark rounded p-4 w-100 text-start shadow-sm" style="font-size: 15px;">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Total Tagihan</span>
                        <span id="modal-total" class="fw-semibold"></span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Tunai</span>
                        <span id="modal-uang-diterima" class="fw-semibold"></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Kembalian</span>
                        <span id="modal-kembalian" class="fw-semibold"></span>
                    </div>
                </div>

                <!-- Spasi -->
                <div class="my-4"></div>


            </div>

            <!-- Tombol Selesai -->
            <div class="modal-footer border-0">

                <!-- Tombol Bagikan & Cetak (2 kolom sejajar) -->
                <div class="row g-2 w-100 px-1 mb-3">
                    <div class="col-6">
                        <a href="#" id="btn-share-struk"
                            class="btn btn-outline btn-outline-dashed btn-outline-success btn-active-light-success w-100">
                            <i class="fas fa-share-alt me-1"></i> Bagikan
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" id="btn-print-struk" target="_blank"
                            class="btn btn-outline btn-outline-dashed btn-outline-success btn-active-light-success w-100">
                            <i class="fas fa-print me-1"></i> Cetak
                        </a>
                    </div>
                </div>


                <button type="button" class="btn btn-secondary w-100 py-3 rounded-3" data-bs-dismiss="modal">
                    Selesai
                </button>

            </div>
        </div>
    </div>
</div>





{{-- <!-- Modal Kas Awal -->
    <div class="modal fade" id="kasAwalModal" tabindex="-1" aria-labelledby="kasAwalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('kas.awal.store') }}" method="POST">
@csrf
<input type="hidden" name="tanggal" value="{{ \Carbon\Carbon::today()->toDateString() }}">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="kasAwalLabel">Input Kas Awal</h5>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="kas_awal">Kas Awal Hari Ini</label>
            <input type="number" step="0.01" name="kas_awal" class="form-control" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</div>
</form>
</div>
</div> --}}


<!-- Modal Kas Awal (Gojek-style) -->
{{-- <div class="modal fade" id="kasAwalModal" tabindex="-1" aria-labelledby="kasAwalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-350px">
            <form action="{{ route('kas.awal.store') }}" method="POST" autocomplete="off">
@csrf
<input type="hidden" name="tanggal" value="{{ \Carbon\Carbon::today()->toDateString() }}">
<div class="modal-content" style="border-radius: 15px; overflow: hidden;">
    <div class="modal-body text-center p-5" style="min-height: 420px;">

        <!-- Icon -->
        <div class="mb-4">
            <div
                style="width: 60px; height: 60px; border-radius: 50%; background: #f3f4f6; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-wallet text-success fs-2x"></i>
            </div>
            <h4 class="mt-3 fw-bold text-dark">Input Kas Awal</h4>
            <p class="text-muted fs-6 mb-0">Masukkan jumlah kas di awal shift hari ini</p>
        </div>

        <!-- Input Kas Awal -->
        <div class="my-4">
            <!-- Input yang dimask -->
            <input type="text" id="kasAwalInputMasked"
                class="form-control text-center fs-2 fw-bold border-0 border-bottom border-2 border-success rounded-0"
                placeholder="0" required style="max-width: 250px; margin: 0 auto; background: transparent;" />

            <!-- Hidden input untuk value bersih -->
            <input type="hidden" name="kas_awal" id="kasAwalInput">

        </div>

        <p class="text-muted small mb-0">
            Input hanya boleh angka tanpa titik/koma. Contoh: <b>50000</b>
        </p>
    </div>

    <!-- Tombol Simpan -->
    <div class="modal-footer border-0">
        <button type="submit" class="btn btn-success w-100 py-3 rounded-3">
            Simpan Kas Awal
        </button>
    </div>
</div>
</form>
</div>
</div> --}}

<div class="modal fade" id="kasAwalModal" tabindex="-1" aria-labelledby="kasAwalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-350px">
        <form action="{{ route('kas.awal.store') }}" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" name="tanggal" value="{{ \Carbon\Carbon::today()->toDateString() }}">

            <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
                <div class="modal-body text-center p-5" style="min-height: 420px;">

                    <!-- Icon -->
                    <div class="mb-4">
                        <div
                            style="width: 60px; height: 60px; border-radius: 50%; background: #f3f4f6; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-wallet text-success fs-2x"></i>
                        </div>
                        <h4 class="mt-3 fw-bold text-dark">
                            {{ $kas ? 'Buka Kembali Kasir' : 'Input Kas Awal' }}
                        </h4>
                        <p class="text-muted fs-6 mb-0">
                            {{ $kas ? 'Kasir telah ditutup. Anda bisa melanjutkan kembali transaksi hari ini.' : 'Masukkan jumlah kas di awal shift hari ini' }}
                        </p>
                    </div>

                    <!-- Input Kas Awal (hanya jika kas belum ada) -->
                    @if (!$kas)
                    <div class="my-4">
                        <input type="text" id="kasAwalInputMasked"
                            class="form-control text-center fs-2 fw-bold border-0 border-bottom border-2 border-success rounded-0"
                            placeholder="0" required
                            style="max-width: 250px; margin: 0 auto; background: transparent;" />
                        <input type="hidden" name="kas_awal" id="kasAwalInput">
                        <p class="text-muted small mb-0 mt-2">Input hanya angka tanpa titik/koma. Contoh:
                            <b>50000</b>
                        </p>
                    </div>
                    @endif

                </div>

                <!-- Tombol Simpan -->
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-success w-100 py-3 rounded-3">
                        {{ $kas ? 'Buka Kembali Kasir' : 'Simpan Kas Awal' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


@php
$user = $kas?->user;
$kasirTutup = $kas?->kasirTutup;

$defaultAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Kasir');
$avatarPath = $user && $user->avatar ? public_path('uploads/user/avatar/' . $user->avatar) : null;
$avatarUrl =
$avatarPath && file_exists($avatarPath) ? asset('uploads/user/avatar/' . $user->avatar) : $defaultAvatar;

$tutupAvatar =
$kasirTutup && $kasirTutup->avatar && file_exists(public_path('uploads/user/avatar/' . $kasirTutup->avatar))
? asset('uploads/user/avatar/' . $kasirTutup->avatar)
: 'https://ui-avatars.com/api/?name=' . urlencode($kasirTutup->name ?? 'Kasir');
@endphp


@if ($kas && $kas->kasir_tutup_at !== null)
<div class="modal fade" id="kasirDitutupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-350px">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-body text-center p-5" style="min-height: 480px;">

                <!-- Ikon sukses -->
                <div class="mb-4">
                    <div
                        style="width: 60px; height: 60px; border-radius: 50%; background: #e9fbee; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-lock text-success fs-2x"></i>
                    </div>
                    <h4 class="mt-3 fw-bold text-dark">Kasir Ditutup</h4>
                    <p class="text-muted mb-0 fs-6">Transaksi tidak dapat dilakukan</p>
                </div>

                <!-- Info Kasir -->
                <div class="bg-white text-dark rounded p-4 w-100 text-start shadow-sm" style="font-size: 15px;">
                    <!-- Info Kasir Buka -->
                    <div class="mb-3">
                        <div class="fw-bold mb-1">Kasir Dibuka Oleh:</div>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-35px me-3">
                                <img src="{{ $avatarUrl }}" alt="avatar" class="rounded-circle" />
                            </div>
                            <div>
                                <strong>{{ $user->name ?? '-' }}</strong><br>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($kas->created_at)->translatedFormat('H:i, d M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>


                    <!-- Info Kasir Tutup -->
                    @if ($kas->kasir_tutup_id)
                    <div class="mb-3">
                        <div class="fw-bold mb-1">Kasir Ditutup Oleh:</div>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-35px me-3">
                                <img src="{{ $tutupAvatar }}" alt="avatar" class="rounded-circle" />
                            </div>
                            <div>
                                <strong>{{ $kasirTutup->name ?? '-' }}</strong><br>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($kas->kasir_tutup_at)->translatedFormat('H:i, d M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endif

                    <hr class="my-2" />

                    <!-- Rincian Uang -->
                    <div class="d-flex justify-content-between mb-1">
                        <span>Kas Awal</span>
                        <span class="fw-semibold">Rp {{ number_format($kas->kas_awal, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Uang Masuk</span>
                        <span class="fw-semibold">Rp {{ number_format($kas->kas_masuk, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Pengeluaran</span>
                        <span class="fw-semibold">Rp {{ number_format($kas->kas_keluar, 0) }}</span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-bold">Kas Akhir</span>
                        <span class="fw-bold text-success">Rp {{ number_format($kas->kas_akhir, 0) }}</span>
                    </div>
                </div>

                <div class="my-4"></div>

            </div>

            <!-- Tombol bawah -->
            <div class="modal-footer border-0">

                <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100 py-3 rounded-3">
                    Kembali ke Dashboard
                </a>
                {{-- Tombol Buka Kas --}}
                @if ($kas && $kas->kasir_tutup_at)
                <button class="btn btn-success w-100 py-3 rounded-3" data-bs-toggle="modal"
                    data-bs-target="#kasAwalModal">
                    <i class="fas fa-wallet me-1"></i> Buka Kembali Kasir
                </button>
                @endif




            </div>
        </div>
    </div>
</div>
@endif






@push('stylesheets')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}">
@endpush
@push('scripts')
<script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!-- Tambahkan ini di awal -->
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        $('#kasAwalInputMasked').mask('000.000.000.000', {
            reverse: true
        });

        // Sinkron ke hidden input
        $('#kasAwalInputMasked').on('input', function() {
            let maskedValue = $(this).val();
            let cleanValue = maskedValue.replace(/\./g, '');
            $('#kasAwalInput').val(cleanValue);
        });
    });
</script>


@if (!$kas)
<script>
    $(document).ready(function() {
        $('#kasAwalModal').modal({
            backdrop: 'static',
            keyboard: false
        }).modal('show');
    });
</script>
@endif
<script>
    document.getElementById('btn-tutup-kasir')?.addEventListener('click', function() {
        Swal.fire({
            icon: 'warning',
            title: 'Tutup Kasir Hari Ini?',
            html: `
                <div style="text-align: left;">
                    <p class="mb-1">Menutup kasir akan:</p>
                    <ul style="padding-left: 1rem; margin-bottom: 1rem;">
                        <li>🔒 Mengunci semua transaksi hari ini</li>
                        <li>📊 Menyimpan ringkasan kas harian</li>
                        <li>🕑 Membuka kasir kembali hanya esok hari</li>
                    </ul>
                    <p class="text-muted mb-0">Pastikan semua transaksi sudah selesai sebelum melanjutkan.</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Tutup Sekarang',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-3',
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary me-2'
            },
            buttonsStyling: false,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-tutup-kasir').submit();
            }
        });
    });
</script>


@if ($kas && $kas->kasir_tutup_at !== null)
<script>
    $(function() {
        $('#kasirDitutupModal').modal({
            backdrop: 'static',
            keyboard: false
        }).modal('show');
    });
</script>
@endif



<script>
    // Generate template URL seperti /penjualan/__ID__/struk
    const strukPrintUrl = "{{ route('penjualan.cetak', ['id' => '__ID__']) }}";
</script>
<script>
    $("#tanggal").flatpickr({
        defaultDate: new Date(), // ⬅️ ini untuk default hari ini
        dateFormat: "Y-m-d" // opsional: format ke "2025-06-14"
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // document.addEventListener('visibilitychange', function() {
        //     if (!document.hidden) {
        //         loadProduk();
        //     }
        // });
        const getProdukUrl = "{{ route('get-daftar-produk') }}";

        function loadProduk(search = '', kategori_id = '') {
            fetch(
                    `${getProdukUrl}?filter-cari-daftar-produk=${search}&filter-kategori-daftar-produk=${kategori_id}`
                )
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        renderProduk(res.data);
                    }
                });
        }

        function renderProduk(data) {
            const container = document.querySelector('.daftar-produk');
            container.innerHTML = ''; // Kosongkan

            const defaultImg = "{{ asset('assets/media/svg/files/blank-image.svg') }}";
            const baseImgPath = "{{ asset('uploads/produk') }}";

            data.forEach(produk => {
                const card = document.createElement('div');
                card.className = 'col-lg-4 mb-3';

                const imgSrc = produk.foto ? `${baseImgPath}/${produk.foto}` : defaultImg;

                card.innerHTML = `
        <div class="card card-flush p-2 text-center produk-item" data-produk='${JSON.stringify(produk)}'>
            <img src="${imgSrc}"
                class="rounded-3 mb-4 w-100px h-100px mx-auto" alt="${produk.nama}" />
            <h4 class="text-gray-800 fw-bold fs-7 mb-1">${produk.nama}</h4>
            <div class="text-gray-500 fs-8 mb-2">${produk.kategori?.nama ?? ''}</div>
<div class="text-success fw-bold fs-7">Rp ${parseFloat(produk.harga_jual).toLocaleString('id-ID')}</div>
        </div>`;

                container.appendChild(card);
            });

            // Tambahkan listener
            document.querySelectorAll('.produk-item').forEach(item => {
                item.addEventListener('click', function() {
                    const data = JSON.parse(this.dataset.produk);
                    tambahKeTabel(data);
                });
            });
        }

        function tambahKeTabel(produk) {
            const tbody = document.getElementById('purchase_cart_list');
            const id = `row-${produk.id}`;
            const harga_jual = parseFloat(produk.harga_jual);

            const qty = 1;
            const subtotal = harga_jual * qty;

            // Cek apakah produk sudah ada
            if (document.getElementById(id)) {
                const qtyInput = document.querySelector(`#${id} input.qty`);
                qtyInput.value = parseInt(qtyInput.value) + 1;
                updateSubtotal(qtyInput);
                return;
            }

            const tr = document.createElement('tr');
            tr.id = id;
            tr.innerHTML = `
        <td>${produk.nama}</td>
        <td>${produk.sku}</td>
        <td>Rp ${harga_jual.toLocaleString('id-ID')}</td>
        <td><input type="number" class="form-control qty" value="${qty}" min="1" style="width: 80px;">
                       
</td>
        <td class="subtotal">Rp ${subtotal.toLocaleString('id-ID')}</td>
       <td class="text-end">
            <a class="btn btn-sm hapus-item">
                <i class="ki-duotone text-danger ki-trash fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
            </a>
        </td>
    `;

            tbody.appendChild(tr);
            updateTotalKeseluruhan();


            // Tambahkan event ke qty dan hapus
            tr.querySelector('.qty').addEventListener('input', function() {
                updateSubtotal(this);
            });

            tr.querySelector('.hapus-item').addEventListener('click', function() {
                tr.remove();
                updateTotalKeseluruhan();

            });
        }

        function updateSubtotal(input) {
            const tr = input.closest('tr');
            const hargaText = tr.children[2].textContent.replace('Rp', '').replace(/\./g, '').replace(',', '')
                .trim();
            const harga_jual = parseFloat(hargaText);
            const qty = parseInt(input.value);
            const subtotal = harga_jual * qty;
            tr.querySelector('.subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            updateTotalKeseluruhan();

        }

        function updateTotalKeseluruhan() {
            const subtotalEls = document.querySelectorAll('#purchase_cart_list .subtotal');
            let total = 0;

            subtotalEls.forEach(el => {
                const num = parseInt(el.textContent.replace('Rp', '').replace(/\./g, '').replace(',',
                    '').trim());
                total += isNaN(num) ? 0 : num;
            });

            document.getElementById('total-penjualan').value = `Rp ${total.toLocaleString('id-ID')}`;
            updateKembalian(); // otomatis update kembalian juga
        }



        function updateKembalian() {
            const totalText = document.getElementById('total-penjualan').value.replace(/[^\d]/g, '');
            const uangDiterimaText = document.getElementById('uang-diterima-penjualan').value.replace(/[^\d]/g,
                '');

            const total = parseInt(totalText) || 0;
            const uangDiterima = parseInt(uangDiterimaText) || 0;

            const kembalian = uangDiterima - total;

            document.getElementById('kembalian-penjualan').value = `Rp ${kembalian.toLocaleString('id-ID')}`;
        }




        // ⬅️ Panggil setelah semua fungsi dan variabel siap
        loadProduk();
        document.getElementById('uang-diterima-penjualan').addEventListener('input', function() {
            let value = e.target.value.replace(/\D/g, ''); // Hapus semua karakter non-digit
            e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Format ribuan (opsional)
            updateKembalian();
        });


        document.getElementById('filter-cari-daftar-produk').addEventListener('input',
            _.debounce(function() {
                const search = this.value;
                const kategori_id = $('#filter-kategori-daftar-produk').val();
                currentPage = 1;
                loadProduk(search, kategori_id, currentPage);
            }, 400)
        );

        $('#filter-kategori-daftar-produk').on('change', function() {
            const search = document.getElementById('filter-cari-daftar-produk').value;
            const kategori_id = $(this).val();
            currentPage = 1;
            loadProduk(search, kategori_id, currentPage);
        });


        let currentPage = 1;

        function loadProduk(search = '', kategori_id = '', page = 1) {
            fetch(
                    `${getProdukUrl}?filter-cari-daftar-produk=${search}&filter-kategori-daftar-produk=${kategori_id}&page=${page}`
                )
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        renderProduk(res.data);
                        renderPagination(res.pagination, search, kategori_id);
                    }
                });
        }


        function renderPagination(pagination, search, kategori_id) {
            const container = document.getElementById('produk-pagination');
            container.innerHTML = ''; // Kosongkan dulu

            const {
                current_page,
                last_page
            } = pagination;

            for (let page = 1; page <= last_page; page++) {
                const li = document.createElement('li');
                li.className = `page-item ${page === current_page ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${page}</a>`;

                li.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentPage = page;
                    loadProduk(search, kategori_id, currentPage);
                });

                container.appendChild(li);
            }
        }


        const uangInput = document.getElementById('uang-diterima-penjualan');

        uangInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // hapus semua non-digit
            if (value === '') {
                e.target.value = '';
                updateKembalian();
                return;
            }

            // Format ke rupiah
            const formatted = parseInt(value).toLocaleString('id-ID');
            e.target.value = formatted;

            updateKembalian();
        });

        const tanggalPicker = flatpickr("#tanggal", {
            defaultDate: new Date(),
            dateFormat: "Y-m-d"
        });


        function formatRupiah(angka) {
            angka = angka.toString().replace(/[^\d]/g, '');
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }


        document.getElementById('btn-batal-penjualan').addEventListener('click', function() {
            // Hapus semua baris di tabel cart
            document.getElementById('purchase_cart_list').innerHTML = '';

            // Reset input uang diterima
            document.getElementById('uang-diterima-penjualan').value = '';

            // Reset input kembalian
            document.getElementById('kembalian-penjualan').value = '';

            // Reset total
            document.getElementById('total-penjualan').value = '';

            // Reset pilihan metode pembayaran ke default (misalnya cash)
            document.getElementById('pembayaran-penjualan').value = 'cash';

            // Panggil ulang updateKembalian agar aman
            updateKembalian();

            // ✅ Reset select2
            $('#customer_id').val(null).trigger('change');

            // ✅ Reset flatpickr (tanggal)
            tanggalPicker.setDate(new Date());
        });



        // document.getElementById('form-penjualan').addEventListener('submit', function(e) {
        //     e.preventDefault();

        //     const btn = $('#btn-simpan-penjualan');
        //     btn.attr('disabled', true).text('Menyimpan...');

        //     const rows = document.querySelectorAll('#purchase_cart_list tr');
        //     if (rows.length === 0) {
        //         Swal.fire({
        //             title: 'Oops!',
        //             text: 'Belum ada produk yang dipilih.',
        //             icon: 'warning'
        //         });
        //         btn.attr('disabled', false).text('Simpan');
        //         return;
        //     }

        //     const data = {
        //         _token: "{{ csrf_token() }}",
        //         tanggal: document.getElementById('tanggal').value,
        //         no_penjualan: document.getElementById('no_penjualan').value,
        //         pembayaran: document.getElementById('pembayaran-penjualan').value,
        //         uang_diterima: document.getElementById('uang-diterima-penjualan').value.replace(
        //             /[^\d]/g, ''),
        //         total: document.getElementById('total-penjualan').value.replace(/[^\d]/g, ''),
        //         kembalian: document.getElementById('kembalian-penjualan').value.replace(/[^\d]/g,
        //             ''),
        //         catatan: document.getElementById('catatan').value,
        //         customer_id: document.getElementById('customer_id').value,
        //         meja_id: document.getElementById('meja_id').value,

        //         produk: []
        //     };


        //     // 🚫 Cegah jika cash tapi uang diterima < total
        //     if ((data.pembayaran === 'cash' || data.pembayaran === 'transfer') && parseInt(data
        //             .uang_diterima) < parseInt(data.total)) {

        //         Swal.fire({
        //             title: 'Pembayaran Tidak Valid',
        //             text: 'Uang diterima tidak boleh kurang dari total pembayaran.',
        //             icon: 'warning'
        //         });
        //         btn.attr('disabled', false).text('Simpan');
        //         return;
        //     }

        //     rows.forEach(row => {
        //         const produk_id = row.id.replace('row-', '');
        //         const qty = parseInt(row.querySelector('.qty').value);
        //         const harga_jual = parseInt(row.children[2].textContent.replace(/[^\d]/g, ''));

        //         const subtotal = harga_jual * qty;

        //         data.produk.push({
        //             produk_id: produk_id,
        //             quantity: qty,
        //             harga_jual: harga_jual,
        //             subtotal: subtotal
        //         });
        //     });

        //     fetch("{{ route('penjualan.store') }}", {
        //             method: "POST",
        //             headers: {
        //                 "Content-Type": "application/json",
        //                 "X-CSRF-TOKEN": "{{ csrf_token() }}"
        //             },
        //             body: JSON.stringify(data)
        //         })
        //         .then(async res => {
        //             const json = await res.json();
        //             if (res.ok) {


        //                 Swal.fire({
        //                     title: json.judul ?? 'Berhasil!',
        //                     text: json.success,
        //                     icon: 'success',
        //                     timer: 2000,
        //                     showConfirmButton: false
        //                 }).then(() => {
        //                     // ✅ Reset form
        //                     document.getElementById('form-penjualan').reset();

        //                     // ✅ Kosongkan tabel produk
        //                     document.getElementById('purchase_cart_list').innerHTML =
        //                         '';

        //                     // ✅ Kosongkan total, kembalian, uang diterima
        //                     document.getElementById('total-penjualan').value = '0';
        //                     document.getElementById('uang-diterima-penjualan').value =
        //                         '';
        //                     document.getElementById('kembalian-penjualan').value = '0';
        //                     tanggalPicker.setDate(new Date());


        //                     // Tampilkan modal info struk
        //                     const total = formatRupiah(json.total ?? data.total);
        //                     const diterima = formatRupiah(json.uang_diterima ?? data
        //                         .uang_diterima);
        //                     const kembali = formatRupiah(json.kembalian ?? data
        //                         .kembalian);

        //                     document.getElementById('modal-total').innerText = total;
        //                     document.getElementById('modal-uang-diterima').innerText =
        //                         diterima;
        //                     document.getElementById('modal-kembalian').innerText =
        //                         kembali;

        //                     const noPenjualan = json
        //                         .no_penjualan; // Pasti benar ini yang disimpan barusan

        //                     const urlStruk = strukPrintUrl.replace('__ID__',
        //                         noPenjualan);
        //                     document.getElementById('btn-print-struk').href = urlStruk;


        //                     const modal = new bootstrap.Modal(document.getElementById(
        //                         'modalPenjualanSelesai'));
        //                     modal.show();



        //                     // ✅ Ambil no penjualan baru via AJAX
        //                     fetch("{{ route('generate-no-penjualan') }}")
        //                         .then(res => res.json())
        //                         .then(data => {
        //                             document.getElementById('no_penjualan').value =
        //                                 data.no_penjualan;
        //                         });





        //                     // // ✅ Tampilkan notifikasi toastr
        //                     // toastr.options = {
        //                     //     "closeButton": true,
        //                     //     "debug": false,
        //                     //     "newestOnTop": true,
        //                     //     "progressBar": true,
        //                     //     "positionClass": "toastr-top-right",
        //                     //     "preventDuplicates": false,
        //                     //     "onclick": null,
        //                     //     "showDuration": "300",
        //                     //     "hideDuration": "1000",
        //                     //     "timeOut": "5000",
        //                     //     "extendedTimeOut": "1000",
        //                     //     "showEasing": "swing",
        //                     //     "hideEasing": "linear",
        //                     //     "showMethod": "fadeIn",
        //                     //     "hideMethod": "fadeOut"
        //                     // };
        //                     // toastr.success(json.success, json.judul ?? "Sukses!");


        //                     // ✅ Opsional: Refresh produk (untuk update stok)
        //                     btn.attr('disabled', false).text('Simpan');
        //                     loadProduk();
        //                 });

        //             } else {
        //                 let message = json?.error ?? 'Gagal menyimpan penjualan.';
        //                 if (json.errors) {
        //                     message = Object.values(json.errors).flat().join('\n');
        //                 }

        //                 Swal.fire({
        //                     title: json.judul ?? 'Gagal!',
        //                     text: message,
        //                     icon: 'error'
        //                 });
        //                 btn.attr('disabled', false).text('Simpan');
        //             }
        //         })
        //         .catch(err => {
        //             console.error(err);
        //             Swal.fire({
        //                 title: 'Terjadi Kesalahan!',
        //                 text: 'Server tidak merespon atau ada error pada sistem.',
        //                 icon: 'error'
        //             });
        //             btn.attr('disabled', false).text('Simpan');
        //         });
        // });



        document.getElementById('form-penjualan').addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = $('#btn-simpan-penjualan');
            btn.attr('disabled', true).text('Menyimpan...');

            const rows = document.querySelectorAll('#purchase_cart_list tr');
            if (rows.length === 0) {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Belum ada produk yang dipilih.',
                    icon: 'warning'
                });
                btn.attr('disabled', false).text('Simpan');
                return;
            }

            const data = {
                _token: "{{ csrf_token() }}",
                tanggal: document.getElementById('tanggal').value,
                no_penjualan: document.getElementById('no_penjualan').value,
                pembayaran: document.getElementById('pembayaran-penjualan').value,
                uang_diterima: document.getElementById('uang-diterima-penjualan').value.replace(
                    /[^\d]/g, ''),
                total: document.getElementById('total-penjualan').value.replace(/[^\d]/g, ''),
                kembalian: document.getElementById('kembalian-penjualan').value.replace(/[^\d]/g,
                    ''),
                catatan: document.getElementById('catatan').value,
                customer_id: document.getElementById('customer_id').value,
                meja_id: document.getElementById('meja_id').value,

                produk: []
            };


            // 🚫 Cegah jika cash tapi uang diterima < total
            if ((data.pembayaran === 'cash' || data.pembayaran === 'transfer') && parseInt(data
                    .uang_diterima) < parseInt(data.total)) {

                Swal.fire({
                    title: 'Pembayaran Tidak Valid',
                    text: 'Uang diterima tidak boleh kurang dari total pembayaran.',
                    icon: 'warning'
                });
                btn.attr('disabled', false).text('Simpan');
                return;
            }

            rows.forEach(row => {
                const produk_id = row.id.replace('row-', '');
                const qty = parseInt(row.querySelector('.qty').value);
                const harga_jual = parseInt(row.children[2].textContent.replace(/[^\d]/g, ''));

                const subtotal = harga_jual * qty;

                data.produk.push({
                    produk_id: produk_id,
                    quantity: qty,
                    harga_jual: harga_jual,
                    subtotal: subtotal
                });
            });

            fetch("{{ route('penjualan.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(data)
                })
                .then(async res => {
                    const json = await res.json();
                    if (res.ok) {


                        // ✅ Reset form
                        document.getElementById('form-penjualan').reset();

                        // ✅ Kosongkan tabel produk
                        document.getElementById('purchase_cart_list').innerHTML =
                            '';

                        // ✅ Kosongkan total, kembalian, uang diterima
                        document.getElementById('total-penjualan').value = '0';
                        document.getElementById('uang-diterima-penjualan').value =
                            '';
                        document.getElementById('kembalian-penjualan').value = '0';
                        tanggalPicker.setDate(new Date());


                        // Tampilkan modal info struk
                        const total = formatRupiah(json.total ?? data.total);
                        const diterima = formatRupiah(json.uang_diterima ?? data
                            .uang_diterima);
                        const kembali = formatRupiah(json.kembalian ?? data
                            .kembalian);

                        document.getElementById('modal-total').innerText = total;
                        document.getElementById('modal-uang-diterima').innerText =
                            diterima;
                        document.getElementById('modal-kembalian').innerText =
                            kembali;

                        const noPenjualan = json
                            .no_penjualan; // Pasti benar ini yang disimpan barusan

                        const urlStruk = strukPrintUrl.replace('__ID__',
                            noPenjualan);
                        document.getElementById('btn-print-struk').href = urlStruk;


                        const modal = new bootstrap.Modal(document.getElementById(
                            'modalPenjualanSelesai'));
                        modal.show();



                        // ✅ Ambil no penjualan baru via AJAX
                        fetch("{{ route('generate-no-penjualan') }}")
                            .then(res => res.json())
                            .then(data => {
                                document.getElementById('no_penjualan').value =
                                    data.no_penjualan;
                            });





                        // // ✅ Tampilkan notifikasi toastr
                        // toastr.options = {
                        //     "closeButton": true,
                        //     "debug": false,
                        //     "newestOnTop": true,
                        //     "progressBar": true,
                        //     "positionClass": "toastr-top-right",
                        //     "preventDuplicates": false,
                        //     "onclick": null,
                        //     "showDuration": "300",
                        //     "hideDuration": "1000",
                        //     "timeOut": "5000",
                        //     "extendedTimeOut": "1000",
                        //     "showEasing": "swing",
                        //     "hideEasing": "linear",
                        //     "showMethod": "fadeIn",
                        //     "hideMethod": "fadeOut"
                        // };
                        // toastr.success(json.success, json.judul ?? "Sukses!");


                        // ✅ Opsional: Refresh produk (untuk update stok)
                        btn.attr('disabled', false).text('Simpan');
                        loadProduk();

                    } else {
                        let message = json?.error ?? 'Gagal menyimpan penjualan.';
                        if (json.errors) {
                            message = Object.values(json.errors).flat().join('\n');
                        }

                        Swal.fire({
                            title: json.judul ?? 'Gagal!',
                            text: message,
                            icon: 'error'
                        });
                        btn.attr('disabled', false).text('Simpan');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        title: 'Terjadi Kesalahan!',
                        text: 'Server tidak merespon atau ada error pada sistem.',
                        icon: 'error'
                    });
                    btn.attr('disabled', false).text('Simpan');
                });
        });



    });
</script>

<script>
    $(document).ready(function() {

        $('#filter-kategori-daftar-produk').select2({
            ajax: {
                url: "{{ route('kategori.select') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nama,
                                id: item.id
                            }
                        })
                    };
                }
            },

        })


        $('#customer_id').select2({
            ajax: {
                url: "{{ route('customer.select') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nama,
                                id: item.id
                            }
                        })
                    };
                }
            },

        });


        $('#meja_id').select2({
            ajax: {
                url: "{{ route('meja.select') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nomor_meja,
                                id: item.id
                            }
                        })
                    };
                }
            },

        });



    });
</script>
<script>
    const btn = document.getElementById("btnFullscreen");
    if (btn) {
        btn.addEventListener("click", function() {
            const elem = document.documentElement;
            if (!document.fullscreenElement) {
                elem.requestFullscreen?.() || elem.webkitRequestFullscreen?.() || elem.msRequestFullscreen?.();
            } else {
                document.exitFullscreen?.() || document.webkitExitFullscreen?.() || document.msExitFullscreen?.
                    ();
            }
        });

        document.addEventListener("fullscreenchange", () => {
            const icon = btn.querySelector("i");
            if (document.fullscreenElement) {
                icon.classList.replace("fa-expand", "fa-compress");
            } else {
                icon.classList.replace("fa-compress", "fa-expand");
            }
        });
    }
</script>
@endpush
@endsection