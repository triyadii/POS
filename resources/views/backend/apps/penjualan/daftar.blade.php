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
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center border-gray-400 gap-3">
            <div class="card-title d-flex flex-wrap align-items-center gap-3">
                <div class="input-group input-group-sm" style="width: 260px;">
                    <input type="text" id="search" class="form-control" placeholder="Ketik kode / customer..." />
                    <button class="btn btn-success" id="btn-cari-global" title="Cari Transaksi">
                        <i class="ki-outline ki-search-list fs-5"></i>
                    </button>
                </div>
                <div class="input-group input-group-sm" style="width: 240px;">
                    <input type="text" id="filter-barang" class="form-control" placeholder="Cari nama barang..." />
                    <button class="btn btn-primary" id="btn-cari-barang" title="Cari Barang">
                        <i class="ki-outline ki-magnifier fs-5"></i>
                    </button>
                </div>
            </div>
            <div class="card-toolbar">
                <button type="button" id="refresh-table-btn" class="btn btn-sm btn-light-primary">
                    <i class="ki-outline ki-arrows-loop me-2"></i> Refresh
                </button>
            </div>

        </div>

        <div class="card-body py-4">
            <!-- FILTER -->
            <div class="row mb-5">
                <div class="col-md-4">
                    <label for="filter-pembayaran" class="form-label fw-semibold">Metode Pembayaran</label>
                    <select id="filter-pembayaran" class="form-select form-select-sm">
                        <option value="">Semua Metode</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filter-start" class="form-label fw-semibold">Dari Tanggal</label>
                    <input type="date" id="filter-start" class="form-control form-control-sm" />
                </div>
                <div class="col-md-4">
                    <label for="filter-end" class="form-label fw-semibold">Sampai Tanggal</label>
                    <input type="date" id="filter-end" class="form-control form-control-sm" />
                </div>
            </div>

            <!-- TABLE -->
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 w-100" id="tabel-penjualan">
                <thead>
                    <tr class="fw-bold text-muted fs-7 text-uppercase gs-0">
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Item Barang</th>
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

<!-- Modal Edit Penjualan -->
<!-- Modal Edit Penjualan -->
<div class="modal fade" id="modalEditPenjualan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Edit Penjualan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit-penjualan">
                    @csrf
                    <input type="hidden" id="edit-id">

                    <!-- Informasi Umum -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Customer</label>
                            <input type="text" id="edit-customer" class="form-control form-control-sm" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Metode Pembayaran</label>
                            <select id="edit-pembayaran" class="form-select form-select-sm"></select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Catatan</label>
                            <input type="text" id="edit-catatan" class="form-control form-control-sm" />
                        </div>
                    </div>

                    <!-- Daftar Barang -->
                    <div class="table-responsive mb-3">
                        <table class="table table-sm table-bordered align-middle" id="edit-barang-table">
                            <thead class="bg-light fw-semibold">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th class="text-center" style="width:90px;">Qty</th>
                                    <th class="text-center" style="width:140px;">Harga</th>
                                    <th class="text-center" style="width:150px;">Subtotal</th>
                                    <th class="text-center" style="width:80px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-light-danger btn-sm" id="btn-tambah-barang">
                            <i class="ki-outline ki-plus-circle fs-4 me-1"></i> Tambah Barang
                        </button>
                        <div>
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
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
        // === 1️⃣ Inisialisasi DataTable ===
        window.penjualanTable = $('#tabel-penjualan').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('penjualan.daftar.data') }}",
                type: "GET",
                cache: false,
                data: function() {
                    return {
                        metode_pembayaran: $('#filter-pembayaran').val() || '',
                        start_date: $('#filter-start').val() || '',
                        end_date: $('#filter-end').val() || '',
                        barang: $('#filter-barang').val() || '',
                        search: $('#search').val() || ''
                    };
                },
                dataSrc: function(json) {
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
                    data: 'nama_barang',
                    defaultContent: '-',
                    render: d => d || '-'
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
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-sm btn-light-primary" onclick="lihatDetail('${data.id}')">
                                <i class="fas fa-eye"></i> Lihat
                            </button>
                            <button class="btn btn-sm btn-light-warning" onclick="editPenjualan('${data.id}')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-light-danger" onclick="hapusPenjualan('${data.id}')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                        `;
                    }
                }
            ],
            language: {
                zeroRecords: "Tidak ada data penjualan",
                processing: "Memuat data..."
            }
        });

        // === 2️⃣ Ambil daftar metode pembayaran ===
        $.ajax({
            url: "{{ route('jenis-pembayaran.list') }}",
            type: "GET",
            success: function(res) {
                if (Array.isArray(res)) {
                    res.forEach(jp => {
                        $('#filter-pembayaran').append(
                            `<option value="${jp.nama}">${jp.nama}</option>`);
                    });
                }
            }
        });

        // === 3️⃣ Event Filter ===
        $('#filter-pembayaran, #filter-start, #filter-end').on('change', function() {
            console.log('Filter berubah, reload DataTable...');
            window.penjualanTable.ajax.reload(null, false); // false = tetap di halaman aktif
        });
        $('#btn-cari-barang').on('click', function() {
            window.penjualanTable.ajax.reload(null, false);
        });

        // === 4️⃣ Pencarian ===
        $('#btn-cari-global').on('click', function() {
            window.penjualanTable.ajax.reload(null, false);
        });

        // === 5️⃣ Refresh Button ===
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

        // === Simpan perubahan ===
        $('#form-edit-penjualan').off('submit').on('submit', function(e) {
            e.preventDefault();

            const id = $('#edit-id').val();
            const items = [];

            $('#edit-barang-table tbody tr').each(function() {
                const row = $(this);
                items.push({
                    id: row.data('id') || null, // id detail (null jika baris baru)
                    barang_id: row.data('barang-id') || null, // wajib ada untuk update stok
                    qty: parseInt(row.find('.edit-qty').val() || 0, 10),
                    hapus: row.attr('data-hapus') === 'true'
                });
            });

            const data = {
                id,
                customer: $('#edit-customer').val(),
                jenis_pembayaran_id: $('#edit-pembayaran').val(),
                catatan: $('#edit-catatan').val(),
                items,
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "{{ route('penjualan.updateBarang') }}",
                type: "POST",
                data,
                success: function(res) {
                    if (res.status === 'success') {
                        $('#modalEditPenjualan').modal('hide');
                        Swal.fire('Berhasil', res.message, 'success');
                        window.penjualanTable.ajax.reload(null, false);
                    } else {
                        Swal.fire('Gagal', res.message || 'Terjadi kesalahan', 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message ||
                        'Tidak dapat menyimpan data', 'error');
                }
            });
        });


    });

    // === 6️⃣ Detail Penjualan ===
    function lihatDetail(id) {
        $('#detail-body').html('<tr><td colspan="4" class="text-center">Memuat...</td></tr>');

        $.ajax({
            url: "{{ route('penjualan.detail') }}", // buat route baru untuk ambil detail by ID
            type: "GET",
            data: {
                id
            },
            success: function(res) {
                if (!res || !res.detail || !res.detail.length) {
                    $('#detail-body').html(
                        '<tr><td colspan="4" class="text-center text-muted">Tidak ada detail barang</td></tr>'
                    );
                } else {
                    let rows = res.detail.map(d => `
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

    // === 6️⃣ Edit Penjualan ===
    function editPenjualan(id) {
        $('#form-edit-penjualan')[0].reset();
        $('#edit-id').val(id);

        $.ajax({
            url: "{{ route('penjualan.detail') }}",
            type: "GET",
            data: {
                id
            },
            success: function(res) {
                if (!res) return;

                $('#edit-customer').val(res.customer_nama || '');
                $('#edit-catatan').val(res.catatan || '');

                // Isi dropdown pembayaran
                $.get("{{ route('jenis-pembayaran.list') }}", function(list) {
                    $('#edit-pembayaran').empty();
                    list.forEach(j => {
                        $('#edit-pembayaran').append(
                            `<option value="${j.id}" ${j.id === res.jenis_pembayaran_id ? 'selected' : ''}>${j.nama}</option>`
                        );
                    });
                });

                // === Tampilkan barang di tabel ===
                let rows = '';
                if (res.detail && res.detail.length > 0) {
                    res.detail.forEach(d => {
                        rows += `
                        <tr data-id="${d.id}" data-barang-id="${d.barang_id}">
                            <td>${d.barang?.nama ?? '-'}</td>
                            <td class="text-center">
                                <input type="number" min="1" class="form-control form-control-sm text-center edit-qty" value="${d.qty}">
                            </td>
                            <td class="text-center">Rp ${parseInt(d.harga_jual).toLocaleString('id-ID')}</td>
                            <td class="text-center subtotal">Rp ${parseInt(d.subtotal).toLocaleString('id-ID')}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-light-danger btn-hapus-barang">
                                    <i class="ki-outline ki-trash fs-5"></i>
                                </button>
                            </td>
                        </tr>`;
                    });
                } else {
                    rows = `<tr><td colspan="5" class="text-center text-muted">Tidak ada barang</td></tr>`;
                }

                $('#edit-barang-table tbody').html(rows);
                new bootstrap.Modal('#modalEditPenjualan').show();
            },
            error: function() {
                Swal.fire('Gagal', 'Tidak dapat memuat data penjualan', 'error');
            }
        });
    }

    // === Hapus barang ===
    $(document).on('click', '.btn-hapus-barang', function() {
        const row = $(this).closest('tr');
        row.attr('data-hapus', 'true').addClass('table-danger');
        row.find('input, button').prop('disabled', true);
    });

    // === Update subtotal saat qty berubah ===
    $(document).on('input', '.edit-qty', function() {
        const row = $(this).closest('tr');
        const hargaText = row.find('td:nth-child(3)').text().replace(/[^\d]/g, '');
        const harga = parseInt(hargaText || 0);
        const qty = parseInt($(this).val() || 0);
        const subtotal = harga * qty;
        row.find('.subtotal').text('Rp ' + subtotal.toLocaleString('id-ID'));
    });

    // === Tambah barang baru ===
    $('#btn-tambah-barang').on('click', function() {
        const newRow = `
        <tr data-id="new-${Date.now()}" data-barang-id="">
            <td>
                <input type="text" class="form-control form-control-sm nama-baru" placeholder="Nama barang baru">
            </td>
            <td class="text-center">
                <input type="number" class="form-control form-control-sm text-center edit-qty" value="1" min="1">
            </td>
            <td class="text-center">
                <input type="number" class="form-control form-control-sm text-center harga-baru" value="0">
            </td>
            <td class="text-center subtotal">Rp 0</td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-light-danger btn-hapus-barang">
                    <i class="ki-outline ki-trash fs-5"></i>
                </button>
            </td>
        </tr>`;
        $('#edit-barang-table tbody').append(newRow);
    });

    // === Simpan perubahan ===
    $('#form-edit-penjualan').on('submit', function(e) {
        e.preventDefault();

        const id = $('#edit-id').val();
        const items = [];

        $('#edit-barang-table tbody tr').each(function() {
            const row = $(this);
            const hapusAttr = row.attr('data-hapus');
            const hapus = hapusAttr === 'true'; // default false kalau atribut tidak ada

            const isNew = (row.data('id') + '').startsWith('new-');
            const qty = parseInt(row.find('.edit-qty').val() || 0, 10);

            // harga existing di data-harga-jual / harga baru di input
            const hargaExisting = parseInt(row.data('harga-jual') || 0, 10);
            const hargaBaruInput = parseInt(row.find('.harga-baru').val() || 0, 10);
            const hargaKirim = isNew ? hargaBaruInput : hargaExisting;

            items.push({
                id: isNew ? row.data('id') : (row.data('id') || null),
                barang_id: isNew ? (row.find('.barang-id-baru').val() || null) : (row.data(
                    'barang-id') || null),
                qty: qty,
                harga_jual: hargaKirim,
                hapus: hapus
            });
        });

        const data = {
            id,
            customer: $('#edit-customer').val(),
            jenis_pembayaran_id: $('#edit-pembayaran').val(),
            catatan: $('#edit-catatan').val(),
            items,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            url: "{{ route('penjualan.updateBarang') }}",
            type: "POST",
            data,
            success: function(res) {
                if (res.status === 'success') {
                    $('#modalEditPenjualan').modal('hide');
                    Swal.fire('Berhasil', res.message, 'success');
                    window.penjualanTable.ajax.reload(null, false);
                } else {
                    Swal.fire('Gagal', res.message || 'Terjadi kesalahan', 'error');
                }
            },
            error: function(xhr) {
                const msg = xhr?.responseJSON?.message || 'Tidak dapat menyimpan data';
                Swal.fire('Error', msg, 'error');
            }
        });
    });


    function hapusPenjualan(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data penjualan dan stok barang akan dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('penjualan.hapus') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire('Berhasil', res.message, 'success');
                            window.penjualanTable.ajax.reload(null, false);
                        } else {
                            Swal.fire('Gagal', res.message || 'Terjadi kesalahan', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Tidak dapat menghapus data', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
@endsection