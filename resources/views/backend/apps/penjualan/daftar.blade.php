@extends('layouts.backend.index')
@section('title', 'Daftar Penjualan')
@section('content')

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
    <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                Daftar Penjualan
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted"><a class="text-muted text-hover-primary">Home</a></li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-gray-900">Penjualan</li>
            </ul>
        </div>
        <div class="d-flex align-items-center pt-4 pb-7 pt-lg-1 pb-lg-2">
            <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-primary">
                <i class="ki-outline ki-plus fs-2"></i> Tambah Penjualan
            </a>
        </div>
    </div>
</div>
<!--end::Toolbar-->

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div class="card border-top-accent shadow-sm mb-xl-10 mb-5">
        <div class="card-header d-flex justify-content-between align-items-center border-gray-400">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                    <input type="text" id="search" class="form-control w-250px ps-13" placeholder="Cari transaksi..." />
                </div>
            </div>
            <div class="card-toolbar">
                <button type="button" id="refresh-table-btn" class="btn btn-sm btn-primary">
                    <i class="ki-outline ki-arrows-loop me-2"></i> Refresh
                </button>
            </div>
        </div>

        <div class="card-body py-4">
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 w-100" id="tabel-penjualan">
                <thead>
                    <tr class="fw-bold text-muted fs-7 text-uppercase gs-0">
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Metode Pembayaran</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th>Catatan</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Penjualan -->
<div class="modal fade" id="modalDetailPenjualan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">Detail Penjualan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="detail-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('stylesheets')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.css') }}" />
<style>
    .card.border-top-accent {
        border-top: 3px solid #0d6efd;
        border-radius: 0.475rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, .075);
    }
</style>
@endpush

@push('scripts')
<script src="{{ URL::to('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    $(function() {
        // Pastikan variabel global untuk DataTable
        window.penjualanTable = $('#tabel-penjualan').DataTable({
            processing: true,
            ajax: {
                url: "{{ route('penjualan.daftar.data') }}",
                type: "GET",
                dataSrc: function(json) {
                    // Pastikan array dikembalikan, bukan objek
                    return Array.isArray(json) ? json : json.data ?? [];
                }
            },
            ordering: false,
            columns: [{
                    data: 'kode_transaksi'
                },
                {
                    data: 'tanggal_penjualan',
                    render: function(data) {
                        if (!data) return '-';
                        return new Date(data).toLocaleDateString('id-ID');
                    }
                },
                {
                    data: 'customer_nama',
                    defaultContent: '-'
                },
                {
                    data: 'jenis_pembayaran.nama',
                    defaultContent: '-',
                    render: function(data) {
                        return data ? data : '<span class="text-muted">-</span>';
                    }
                },
                {
                    data: 'total_item'
                },
                {
                    data: 'total_harga',
                    render: function(data) {
                        return 'Rp ' + parseInt(data || 0).toLocaleString('id-ID');
                    }
                },
                {
                    data: 'catatan',
                    defaultContent: '-'
                },
                {
                    data: null,
                    className: 'text-end',
                    render: function(data) {
                        return `
                        <button class="btn btn-sm btn-light-primary" onclick="lihatDetail('${data.id}')">
                            <i class="fas fa-eye"></i> Lihat
                        </button>`;
                    }
                }
            ],
            language: {
                zeroRecords: "Tidak ada data penjualan",
                processing: "Memuat data...",
            }
        });

        // ✅ Fungsi Pencarian
        $('#search').on('keyup', function() {
            window.penjualanTable.search(this.value).draw();
        });

        // ✅ Tombol Refresh (FIXED)
        $('#refresh-table-btn').on('click', function() {
            const btn = $(this);
            btn.prop('disabled', true);
            const originalHTML = btn.html();
            btn.html(`<span class="spinner-border spinner-border-sm me-2"></span> Memuat...`);

            window.penjualanTable.ajax.reload(function() {
                btn.prop('disabled', false);
                btn.html(originalHTML);
            }, false);
        });
    });


    // ✅ Fungsi untuk menampilkan detail transaksi
    function lihatDetail(id) {
        $('#detail-body').html('<tr><td colspan="4" class="text-center">Memuat...</td></tr>');

        $.ajax({
            url: "{{ route('penjualan.daftar.data') }}",
            type: "GET",
            success: function(res) {
                const data = res.find(p => p.id === id);
                if (!data || !data.detail || !data.detail.length) {
                    $('#detail-body').html(
                        '<tr><td colspan="4" class="text-center text-muted">Tidak ada detail barang</td></tr>'
                    );
                } else {
                    let rows = data.detail.map(d => `
                    <tr>
                        <td>${d.barang?.nama ?? '-'}</td>
                        <td>${d.qty}</td>
                        <td>Rp ${parseInt(d.harga_jual).toLocaleString('id-ID')}</td>
                        <td>Rp ${parseInt(d.subtotal).toLocaleString('id-ID')}</td>
                    </tr>
                `);
                    $('#detail-body').html(rows.join(''));
                }
                new bootstrap.Modal('#modalDetailPenjualan').show();
            },
            error: function() {
                $('#detail-body').html(
                    '<tr><td colspan="4" class="text-center text-danger">Gagal memuat data</td></tr>');
            }
        });
    }
</script>
@endpush
@endsection