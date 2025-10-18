@extends('layouts.backend.index')
@section('title', 'Kasir Penjualan')
@section('content')
<div class="position-relative" style="left:50%; width:99vw; margin-left:-50vw; padding-left:2vw; padding-right:2vw;">
    <div id="kt_app_content" class="app-content flex-column flex-row-fluid">
        <div class="row gx-6 gx-xl-9">
            <!-- Kolom Kiri -->
            <div class="col-lg-7">
                <div class="card card-flush h-lg-100">
                    <div class="card-header align-items-center py-5 bg-primary">
                        <div class="card-title flex-column">
                            <h3 class="fw-bold mb-1 text-white">Kasir Penjualan</h3>
                        </div>
                        <div class="card-toolbar d-flex gap-2">
                            <a href="#" class="btn btn-light-info btn-sm">History Penjualan</a>
                        </div>
                    </div>

                    <div class="card-body p-9 pt-5">
                        <form id="form-penjualan">
                            @csrf
                            <div class="row gx-6 gx-xl-9 mb-2">
                                <div class="col-lg-6 mb-2">
                                    <input type="date" class="form-control" name="tanggal" id="tanggal"
                                        value="{{ date('Y-m-d') }}" disabled />
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <input type="text" class="form-control form-control-solid" name="no_penjualan"
                                        id="no_penjualan" value="{{ $no_penjualan }}" readonly />
                                </div>
                            </div>

                            <div class="row gx-6 gx-xl-9 align-items-end mb-6">
                                <div class="col-lg-10 mb-2">
                                    <label for="customer_id" class="form-label fw-semibold text-gray-700 mb-1">
                                        <i class="ki-duotone ki-user fs-3 me-1 text-primary"></i> Customer
                                    </label>
                                    <select class="form-select form-select-solid" id="customer_id" name="customer_id"
                                        data-control="select2" data-placeholder="🔍 Cari atau pilih customer..."
                                        data-allow-clear="true">
                                        <option value="">Pilih Customer</option>
                                    </select>
                                </div>

                                <div class="col-lg-2 mb-2 d-flex align-items-end justify-content-end">
                                    <button type="button"
                                        class="btn btn-light-success w-100 d-flex align-items-center justify-content-center gap-1"
                                        id="btnTambahCustomer" data-bs-toggle="modal"
                                        data-bs-target="#modalTambahCustomer">
                                        <i class="ki-duotone ki-user-plus fs-3"></i>
                                        <span class="fw-semibold">Baru</span>
                                    </button>
                                </div>
                            </div>


                            <div class="cart-payment mb-5">
                                <div class="table-responsive mb-6">
                                    <table class="table table-bordered align-middle">
                                        <thead class="bg-secondary">
                                            <tr>
                                                <th>Nama Produk</th>
                                                <th>SKU</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Sub Total</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="purchase_cart_list"></tbody>
                                    </table>
                                </div>
                                <hr>
                            </div>

                            <div class="row gx-6 gx-xl-9 mb-6">
                                <div class="col-lg-6">
                                    <label>Uang Diterima</label>
                                    <input type="text" class="form-control" id="uang-diterima-penjualan"
                                        placeholder="0">
                                    <label class="mt-3">Kembalian</label>
                                    <input type="text" class="form-control form-control-solid" id="kembalian-penjualan"
                                        readonly>
                                </div>
                                <div class="col-lg-6">
                                    <label>Total</label>
                                    <input type="text" class="form-control form-control-solid" id="total-penjualan"
                                        readonly>
                                    <label class="mt-3">Pembayaran</label>
                                    <select class="form-select" id="pembayaran-penjualan" name="pembayaran">
                                        <option value="">Pilih Metode Pembayaran</option>
                                        @foreach($pembayaran as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <label>Catatan</label>
                            <textarea class="form-control mb-3" id="catatan" rows="2"></textarea>

                            <div class="row gx-6 gx-xl-9">
                                <div class="col-lg-6 mb-2">
                                    <button type="button" class="btn btn-light-danger w-100"
                                        id="btn-batal-penjualan">Batal</button>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" class="btn btn-light-primary w-100"
                                        id="btn-simpan-penjualan">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-5">
                <div class="card card-flush h-lg-100">
                    <div class="card-header align-items-center bg-primary">
                        <div class="row gx-2 w-100 align-items-center">
                            <div class="col-6">
                                <input type="text" class="form-control form-control-sm" id="filter-cari-daftar-produk"
                                    placeholder="Cari Produk" />
                            </div>
                            <div class="col-5">
                                <select class="form-select form-select-sm" id="filter-kategori-daftar-produk">
                                    <option value="">Semua Kategori</option>
                                    @php
                                    $kategoriUnik = $produk->pluck('kategori.nama')->unique()->filter()->values();
                                    @endphp
                                    @foreach($kategoriUnik as $k)
                                    <option value="{{ $k }}">{{ $k }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-1 text-end">
                                <a id="btnFullscreen" class="btn btn-sm fs-2 w-100">
                                    <i class="fas fa-expand text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-9 pt-3">
                        <div class="row daftar-produk"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Transaksi Selesai -->
    <div class="modal fade" id="modalPenjualanSelesai" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered mw-350px">
            <div class="modal-content rounded-3 overflow-hidden">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <div class="rounded-circle bg-light-success d-inline-flex align-items-center justify-content-center"
                            style="width:60px;height:60px;">
                            <i class="fas fa-check text-success fs-2x"></i>
                        </div>
                        <h4 class="mt-3 fw-bold">Transaksi Sukses!</h4>
                    </div>

                    <div class="text-start bg-light p-3 rounded">
                        <div class="d-flex justify-content-between"><span>Total</span><span id="modal-total"></span>
                        </div>
                        <div class="d-flex justify-content-between"><span>Tunai</span><span
                                id="modal-uang-diterima"></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold"><span>Kembalian</span><span
                                id="modal-kembalian"></span></div>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <button class="btn btn-success w-100" id="btn-cetak-struk">
                            <i class="fas fa-print me-2"></i>Cetak Struk
                        </button>
                        <button class="btn btn-secondary w-100" data-bs-dismiss="modal">Selesai</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal History Penjualan -->
    <div class="modal fade" id="modalHistoryPenjualan" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">History Penjualan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="table-history">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Total Item</th>
                                    <th>Total Harga</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Penjualan -->
    <div class="modal fade" id="modalDetailPenjualan" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">Detail Penjualan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
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

    <!-- Template Struk (disembunyikan, hanya untuk dicetak) -->
    <div id="print-area" style="display:none;font-family:monospace;">
        <div style="text-align:center;">
            <h4 style="margin-bottom:0;">TOKO MAJU JAYA</h4>
            <small>Jl. Contoh No. 123, Deli Serdang</small>
            <hr>
        </div>
        <div id="print-detail"></div>
        <hr>
        <div style="text-align:center;">Terima Kasih 😊<br>--- Struk Non Pajak ---</div>
    </div>

    <!-- Modal Tambah Customer -->
    <div class="modal fade" id="modalTambahCustomer" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Customer Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahCustomer">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Customer</label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan nama customer"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" class="form-control" name="no_wa" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSimpanCustomer">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '#modalPenjualanSelesai .btn-secondary', function() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalPenjualanSelesai'));
            modal.hide();

            // 🔁 Ambil nomor transaksi baru dari server
            $.get("{{ route('penjualan.no_otomatis') }}", function(res) {
                if (res.no_penjualan) {
                    $('#no_penjualan').val(res.no_penjualan);
                }
            }).fail(() => {
                Swal.fire('⚠️', 'Gagal memperbarui nomor transaksi', 'warning');
            });
        });

        // ✅ Inisialisasi Select2 AJAX
        $('#customer_id').select2({
            placeholder: '🔍 Cari atau pilih customer...',
            allowClear: true,
            ajax: {
                url: "{{ route('customer.select') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.nama
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
            width: '100%',
            dropdownParent: $('#customer_id').closest('.col-lg-10')
        });

        // 💾 Tambah Customer - UX Improvement
        $('#btnSimpanCustomer').off('click').on('click', function() {
            const form = $('#formTambahCustomer');
            const btn = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menambah...');

            $.ajax({
                url: "{{ route('customer.store') }}",
                type: 'POST',
                data: form.serialize(),
                success: function(res) {
                    btn.prop('disabled', false).html(
                        '<i class="ki-duotone ki-check fs-3 me-1"></i> Simpan');

                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: res.judul,
                            text: res.success,
                            timer: 1200,
                            showConfirmButton: false
                        });

                        $('#modalTambahCustomer').modal('hide');
                        form[0].reset();

                        // 🔁 Auto-refresh dropdown customer dan pilih yang baru
                        $('#customer_id').append(new Option(res.nama ?? form.find(
                            '[name="nama"]').val(), res.id ?? '', true, true)).trigger(
                            'change');
                    } else if (res.errors) {
                        let pesan = Object.values(res.errors).flat().join('<br>');
                        Swal.fire('Validasi Gagal', pesan, 'warning');
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html(
                        '<i class="ki-duotone ki-check fs-3 me-1"></i> Simpan');
                    Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
                }
            });
        });

    });
</script>
<script>
    // Tombol History Penjualan
    $('.btn-light-info').on('click', function(e) {
        e.preventDefault();
        loadHistoryPenjualan();
        new bootstrap.Modal('#modalHistoryPenjualan').show();
    });

    function loadHistoryPenjualan() {
        const tbody = $('#table-history tbody');
        tbody.html('<tr><td colspan="7" class="text-center">Memuat data...</td></tr>');

        $.get("{{ route('penjualan.history.data') }}", function(res) {
            if (!res.length) {
                tbody.html('<tr><td colspan="7" class="text-center text-muted">Belum ada transaksi</td></tr>');
                return;
            }
            console.log(res);
            tbody.html('');
            res.forEach(p => {
                const row = `
        <tr>
            <td>${p.kode_transaksi}</td>
            <td>${new Date(p.tanggal_penjualan).toLocaleDateString('id-ID')}</td>
            <td>${p.customer_nama ?? '-'}</td>
            <td>${p.pembayaran ? p.pembayaran.nama : '-'}</td>
            <td>${p.total_item}</td>
            <td>Rp ${parseInt(p.total_harga).toLocaleString('id-ID')}</td>
            <td>${p.catatan ?? '-'}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-light-primary" onclick="lihatDetail('${p.id}')">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-light-success" onclick="cetakStrukHistory('${p.id}')">
                    <i class="fas fa-print"></i>
                </button>
            </td>
        </tr>
    `;
                tbody.append(row);
            });

        }).fail(() => {
            tbody.html('<tr><td colspan="7" class="text-center text-danger">Gagal memuat data</td></tr>');
        });
    }

    // Menampilkan detail transaksi
    function lihatDetail(id) {
        $('#detail-body').html('<tr><td colspan="4" class="text-center">Memuat...</td></tr>');

        $.get("{{ route('penjualan.history.data') }}", function(res) {
            const transaksi = res.find(x => x.id === id);
            if (!transaksi || !transaksi.detail || transaksi.detail.length === 0) {
                $('#detail-body').html(
                    '<tr><td colspan="4" class="text-center text-muted">Tidak ada detail</td></tr>');
            } else {
                const rows = transaksi.detail.map(d => `
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
        });
    }

    function cetakStrukHistory(id) {
        $.get("{{ route('penjualan.history.data') }}", function(res) {
            const transaksi = res.find(x => x.id === id);
            if (!transaksi) {
                Swal.fire('⚠️', 'Data transaksi tidak ditemukan', 'warning');
                return;
            }

            // Buat item rows
            let itemRows = '';
            transaksi.detail.forEach(i => {
                itemRows += `
                <tr>
                    <td colspan="2">${i.barang?.nama ?? '-'}</td>
                    <td style="text-align:right;">Rp ${parseInt(i.harga_jual).toLocaleString('id-ID')}</td>
                </tr>
                <tr>
                    <td style="width:10%;"></td>
                    <td>${i.qty} x Rp ${parseInt(i.harga_jual).toLocaleString('id-ID')}</td>
                    <td style="text-align:right;">Rp ${parseInt(i.subtotal).toLocaleString('id-ID')}</td>
                </tr>
            `;
            });
            const logoPath = document.querySelector('.theme-light-show')?.getAttribute('src') ||
                "{{ asset('assets/media/logos/keenthemes.svg') }}";
            const strukHTML = `
        <div style="font-family: monospace; font-size: 12px; width: 260px; margin: auto;">
   <div style="text-align:center;">
        <img src="${logoPath}" style="width:100%;height:60px;object-fit:contain;">
        <div>Jl. KL. Yos Sudarso PAJAK SORE km 9,5, M A B A R, Kec. Medan Deli, Kota Medan, Sumatera Utara 20242 Telp: 081210003014</div>
        <hr style="border-top:1px dashed #000;">
    </div>

            <div style="line-height:1.4;">
                <div>Tanggal : ${new Date(transaksi.tanggal_penjualan).toLocaleDateString('id-ID')}</div>
                <div>Kode    : ${transaksi.kode_transaksi}</div>
                <div>Customer: ${transaksi.customer_nama ?? '-'}</div>
                <div>Kasir   : Kasir</div>
                <hr style="border-top:1px dashed #000;">
            </div>

            <table style="width:100%;border-collapse:collapse;">
                <tbody>${itemRows}</tbody>
            </table>

            <hr style="border-top:1px dashed #000;">
            <div style="display:flex;justify-content:space-between;"><span>Total</span><span>Rp ${parseInt(transaksi.total_harga).toLocaleString('id-ID')}</span></div>
            <div style="display:flex;justify-content:space-between;"><span>Pembayaran</span><span>${transaksi.pembayaran?.nama ?? '-'}</span></div>
            <hr style="border-top:1px dashed #000;">
            <div style="text-align:center;margin-top:5px;">Terima Kasih Atas Kunjungan Anda</div>
        </div>
        `;

            const printWindow = window.open('', '', 'width=400,height=600');
            printWindow.document.write(`
        <html>
        <head>
            <title>Struk Penjualan</title>
            <style>
                body { font-family: monospace; margin: 0; padding: 10px; font-size: 12px; }
                hr { border: 1px dashed #000; }
                table { width: 100%; border-collapse: collapse; }
                td { padding: 2px 0; vertical-align: top; }
            </style>
        </head>
        <body>${strukHTML}</body>
        </html>
        `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        });
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const produkData = @json($produk);

        // 🔄 Load daftar customer dari database
        function loadCustomerList(selectedId = null) {
            $.get("{{ route('customer.select') }}", function(data) {
                const select = $("#customer_id");
                select.html('<option value="">Pilih Customer</option>');
                data.forEach(function(c) {
                    select.append(`<option value="${c.id}">${c.nama}</option>`);
                });
                if (selectedId) select.val(selectedId);
            });
        }

        // 🔁 Panggil saat halaman pertama kali dibuka
        loadCustomerList();

        // 💾 Tambah customer baru
        $("#btnSimpanCustomer").on("click", function() {
            const form = $("#formTambahCustomer");
            const payload = form.serialize();

            $.ajax({
                url: "{{ route('customer.store') }}",
                method: "POST",
                data: payload,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: "success",
                            title: res.judul,
                            text: res.success,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // 🔄 Reload daftar customer dan pilih yang baru
                        $("#modalTambahCustomer").modal("hide");
                        form[0].reset();

                        loadCustomerList(); // muat ulang
                    } else if (res.errors) {
                        let pesan = Object.values(res.errors).flat().join("<br>");
                        Swal.fire("Validasi Gagal", pesan, "warning");
                    } else {
                        Swal.fire("Gagal", "Tidak dapat menyimpan data", "error");
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire("Error", "Terjadi kesalahan di server", "error");
                }
            });
        });

        // // Render produk dari database
        // function renderProduk(data) {
        //     const container = document.querySelector('.daftar-produk');
        //     container.innerHTML = '';
        //     data.forEach(p => {
        //         const stok = parseInt(p.stok ?? 0);
        //         const habis = stok <= 0;

        //         const card = document.createElement('div');
        //         card.className = 'col-lg-6 mb-3';
        //         card.innerHTML = `
        //     <div class="card card-flush p-2 text-center produk-item ${habis ? 'bg-light-secondary' : ''}" 
        //          data-id="${p.id}" style="cursor:${habis ? 'not-allowed' : 'pointer'};opacity:${habis ? 0.5 : 1}">
        //         <div class="fw-bold">${p.nama}</div>
        //         <div class="text-muted">${p.kategori ? p.kategori.nama : '-'}</div>
        //         <div class="text-success">Rp ${parseInt(p.harga_jual).toLocaleString('id-ID')}</div>
        //         <div class="mt-1 ${habis ? 'text-danger fw-bold' : 'text-muted small'}">
        //             ${habis ? 'Stok Habis' : 'Stok: ' + stok}
        //         </div>
        //     </div>`;
        //         container.appendChild(card);
        //     });

        //     document.querySelectorAll('.produk-item').forEach(item => {
        //         item.addEventListener('click', function() {
        //             const produk = produkData.find(p => p.id == this.dataset.id);
        //             const stok = parseInt(produk.stok ?? 0);
        //             if (stok <= 0) {
        //                 Swal.fire('⚠️ Stok Habis', 'Produk ini sudah tidak tersedia', 'warning');
        //                 return;
        //             }
        //             tambahKeTabel(produk);
        //         });
        //     });
        // }

        function renderProduk(data) {
            const container = document.querySelector('.daftar-produk');
            container.innerHTML = '';

            if (!data || data.length === 0) {
                container.innerHTML = `
            <div class="text-center text-muted py-10">
                <i class="fas fa-box-open fs-2hx mb-3 d-block text-gray-400"></i>
                <div class="fw-semibold fs-5">Tidak ada produk ditemukan</div>
            </div>`;
                return;
            }

            data.forEach(p => {
                const stok = parseInt(p.stok ?? 0);
                const habis = stok <= 0;

                const card = document.createElement('div');
                card.className = 'col-xl-3 col-lg-4 col-md-6 mb-4';
                card.innerHTML = `
        <div class="card shadow-sm produk-item border-0 h-100 ${habis ? 'bg-light-secondary' : ''}"
             data-id="${p.id}"
             style="cursor:${habis ? 'not-allowed' : 'pointer'};opacity:${habis ? 0.6 : 1};
                    transition: all 0.2s ease-in-out;">
            <div class="card-body p-3 d-flex flex-column align-items-center justify-content-between">

                <div class="text-center">
                    <div class="fw-bold fs-6 text-dark mb-1">${p.nama ?? '-'}</div>
                    <div class="text-muted small mb-1">
                        ${p.kategori ? p.kategori.nama : '-'}
                    </div>
                    <div class="badge badge-light-primary fw-semibold mb-2 px-3 py-1">
                        <i class="fas fa-barcode me-1"></i> ${p.kode_barang ?? '-'}
                    </div>
                </div>

                <div class="mt-2 text-center">
                    <div class="fw-bold text-success fs-6">
                        Rp ${parseInt(p.harga_jual ?? 0).toLocaleString('id-ID')}
                    </div>
                    <div class="small mt-1 ${habis ? 'text-danger fw-bold' : 'text-muted'}">
                        ${habis ? 'Stok Habis' : 'Stok: ' + stok}
                    </div>
                </div>

            </div>
        </div>`;

                container.appendChild(card);
            });

            // ✨ Efek hover (zoom-in ringan)
            document.querySelectorAll('.produk-item').forEach(item => {
                item.addEventListener('mouseenter', () => {
                    if (!item.classList.contains('bg-light-secondary')) {
                        item.style.transform = 'scale(1.03)';
                        item.style.boxShadow = '0 6px 12px rgba(0,0,0,0.1)';
                    }
                });
                item.addEventListener('mouseleave', () => {
                    item.style.transform = 'scale(1)';
                    item.style.boxShadow = '';
                });

                // 🛒 Klik produk
                item.addEventListener('click', function() {
                    const produk = produkData.find(p => p.id == this.dataset.id);
                    const stok = parseInt(produk.stok ?? 0);
                    if (stok <= 0) {
                        Swal.fire('⚠️ Stok Habis', 'Produk ini sudah tidak tersedia', 'warning');
                        return;
                    }
                    tambahKeTabel(produk);
                });
            });
        }



        // fungsi-fungsi perhitungan
        function tambahKeTabel(produk) {
            const tbody = document.getElementById('purchase_cart_list');
            const id = `row-${produk.id}`;
            if (document.getElementById(id)) {
                const qtyInput = document.querySelector(`#${id} input.qty`);
                qtyInput.value = parseInt(qtyInput.value) + 1;
                updateSubtotal(qtyInput);
                return;
            }

            const tr = document.createElement('tr');
            tr.id = id;
            tr.innerHTML =
                `
            <td>${produk.nama}</td>
            <td>${produk.kode_barang}</td>
            <td>
            Rp ${parseInt(produk.harga_jual).toLocaleString('id-ID')}
                    <input type="hidden" class="harga-beli" value="${produk.harga_beli ?? 0}">
            </td>
            <td><input type="number" class="form-control qty" value="1" min="1" style="width:80px"></td>
            <td class="subtotal">Rp ${parseInt(produk.harga_jual).toLocaleString('id-ID')}</td>
            <td class="text-end"><button class="btn btn-sm text-danger hapus-item"><i class="fas fa-trash"></i></button></td>`;
            tbody.appendChild(tr);

            tr.querySelector('.qty').addEventListener('input', function() {
                updateSubtotal(this);
            });
            tr.querySelector('.hapus-item').addEventListener('click', function() {
                tr.remove();
                updateTotal();
            });

            updateTotal();
        }

        function updateSubtotal(input) {
            const tr = input.closest('tr');
            const produkId = tr.id.replace('row-', '');
            const produk = produkData.find(p => p.id == produkId);
            const stok = parseInt(produk.stok ?? 0);
            let qty = parseInt(input.value);

            if (qty > stok) {
                qty = stok;
                input.value = stok;
                Swal.fire('⚠️ Stok Tidak Cukup', `Stok ${produk.nama} hanya ${stok}`, 'warning');
            }

            const harga = parseInt(tr.children[2].textContent.replace(/[^\d]/g, ''));
            const subtotal = harga * qty;
            tr.querySelector('.subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            updateTotal();
        }


        function updateTotal() {
            const subtotalEls = document.querySelectorAll('#purchase_cart_list .subtotal');
            let total = 0;
            subtotalEls.forEach(el => total += parseInt(el.textContent.replace(/[^\d]/g, '')) || 0);
            document.getElementById('total-penjualan').value = `Rp ${total.toLocaleString('id-ID')}`;
            updateKembalian();
        }

        function updateKembalian() {
            const total = parseInt(document.getElementById('total-penjualan').value.replace(/[^\d]/g, '')) || 0;
            const uang = parseInt(document.getElementById('uang-diterima-penjualan').value.replace(/[^\d]/g, '')) ||
                0;
            const kembalian = uang - total;
            document.getElementById('kembalian-penjualan').value = `Rp ${kembalian.toLocaleString('id-ID')}`;
        }

        document.getElementById('uang-diterima-penjualan').addEventListener('input', e => {
            e.target.value = e.target.value.replace(/[^\d]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            updateKembalian();
        });

        // Filter produk
        document.getElementById('filter-cari-daftar-produk').addEventListener('input', _.debounce(function() {
            const search = this.value.toLowerCase();
            const kategori = $('#filter-kategori-daftar-produk').val();

            // 🔍 Pencarian bisa berdasarkan nama ATAU kode_barang
            const hasil = produkData.filter(p => {
                const namaMatch = p.nama?.toLowerCase().includes(search);
                const kodeMatch = p.kode_barang?.toLowerCase().includes(search);
                const kategoriMatch = kategori === '' || (p.kategori && p.kategori.nama ===
                    kategori);
                return (namaMatch || kodeMatch) && kategoriMatch;
            });

            renderProduk(hasil);
        }, 300));

        // 🎯 Filter produk berdasarkan kategori dropdown
        $('#filter-kategori-daftar-produk').on('change', function() {
            const kategori = $(this).val();
            const search = $('#filter-cari-daftar-produk').val().toLowerCase();

            const hasil = produkData.filter(p => {
                const namaMatch = p.nama?.toLowerCase().includes(search);
                const kodeMatch = p.kode_barang?.toLowerCase().includes(search);
                const kategoriMatch = kategori === '' || (p.kategori && p.kategori.nama ===
                    kategori);
                return (namaMatch || kodeMatch) && kategoriMatch;
            });

            renderProduk(hasil);
        });


        renderProduk(produkData);

        // Simulasi submit
        $('#form-penjualan').off('submit').on('submit', function(e) {
            e.preventDefault();

            const rows = $('#purchase_cart_list tr');
            const btn = $('#btn-simpan-penjualan');

            // Blok klik ganda
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

            if (rows.length === 0) {
                Swal.fire('Oops!', 'Belum ada produk yang dipilih', 'warning');
                btn.prop('disabled', false).html('Simpan');
                return;
            }

            const total = parseInt($('#total-penjualan').val().replace(/[^\d]/g, '')) || 0;
            const uangDiterima = parseInt($('#uang-diterima-penjualan').val().replace(/[^\d]/g, '')) || 0;
            const kembalian = uangDiterima - total;

            const customer = $('#customer_id').val();
            const pembayaran = $('#pembayaran-penjualan').val();

            if (kembalian < 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Uang Kurang!',
                    text: 'Nominal uang yang diterima tidak mencukupi untuk membayar total pembelian.'
                });
                btn.prop('disabled', false).html('Simpan');
                return;
            }

            // ✅ Validasi: Customer harus dipilih
            if (!customer || customer === '') {
                Swal.fire('Oops!', 'Silakan pilih customer terlebih dahulu.', 'warning');
                btn.prop('disabled', false).html('Simpan');
                return;
            }

            // ✅ Validasi: Jenis pembayaran harus dipilih
            if (!pembayaran || pembayaran === '') {
                Swal.fire('Oops!', 'Silakan pilih jenis pembayaran terlebih dahulu.', 'warning');
                btn.prop('disabled', false).html('Simpan');
                return;
            }

            // Ambil semua item
            const items = [];
            rows.each(function() {
                const id = $(this).attr('id').replace('row-', '');
                const nama = $(this).find('td:nth-child(1)').text();
                const qty = parseInt($(this).find('.qty').val());
                const harga = parseInt($(this).find('td:nth-child(3)').text().replace(/[^\d]/g,
                    ''));
                const hargaBeli = parseInt($(this).find('.harga-beli').val()) || 0;
                const subtotal = harga * qty;
                items.push({
                    barang_id: id,
                    barang_nama: nama,
                    qty,
                    harga_beli: hargaBeli,
                    harga_jual: harga,
                    subtotal
                });
            });

            const pembayaranId = $('#pembayaran-penjualan').val();
            const pembayaranNama = $('#pembayaran-penjualan option:selected').text();

            const payload = {
                _token: $('input[name="_token"]').val(),
                no_penjualan: $('#no_penjualan').val(),
                tanggal: $('#tanggal').val(),
                customer: $('#customer_id option:selected').text(),
                total_item: items.length,
                total: `Rp ${total.toLocaleString('id-ID')}`,
                uang: `Rp ${uangDiterima.toLocaleString('id-ID')}`,
                kembalian: `Rp ${kembalian.toLocaleString('id-ID')}`,
                catatan: $('#catatan').val(),
                pembayaran: pembayaranId,
                pembayaran_nama: pembayaranNama,
                items: items
            };

            $.ajax({
                url: "{{ route('penjualan.store') }}",
                method: "POST",
                data: payload,
                success: function(res) {
                    btn.prop('disabled', false).html('Simpan');

                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaksi Berhasil Disimpan!',
                            timer: 1200,
                            showConfirmButton: false
                        }).then(() => {
                            $('#modal-total').text($('#total-penjualan').val());
                            $('#modal-uang-diterima').text($('#uang-diterima-penjualan')
                                .val());
                            $('#modal-kembalian').text($('#kembalian-penjualan').val());
                            new bootstrap.Modal('#modalPenjualanSelesai').show();

                            // Simpan transaksi terakhir untuk cetak struk
                            window.transaksiTerakhir = payload;

                            // Reset form
                            $('#form-penjualan')[0].reset();
                            $('#purchase_cart_list').html('');
                            updateTotal();

                            // Refresh produk
                            $.get("{{ route('penjualan.produk.data') }}", function(
                                newProduk) {
                                renderProduk(newProduk);
                            });
                        });
                    } else {
                        Swal.fire('Gagal', res.message ?? 'Gagal menyimpan transaksi', 'error');
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('Simpan');
                    Swal.fire('Error', 'Terjadi kesalahan di server', 'error');
                    console.error(xhr.responseText);
                }
            });
        });



        $('#btn-batal-penjualan').on('click', () => {
            $('#purchase_cart_list').html('');
            $('#uang-diterima-penjualan').val('');
            $('#total-penjualan').val('');
            $('#kembalian-penjualan').val('');
        });
        const fullscreenBtn = document.getElementById('btnFullscreen');

        fullscreenBtn.addEventListener('click', function() {
            if (!document.fullscreenElement) {
                // Masuk mode fullscreen
                document.documentElement.requestFullscreen().catch(err => {
                    console.error(`Gagal masuk fullscreen: ${err.message}`);
                });
                fullscreenBtn.innerHTML =
                    '<i class="fas fa-compress text-white"></i>'; // ubah ikon jadi "keluar"
            } else {
                // Keluar fullscreen
                document.exitFullscreen().catch(err => {
                    console.error(`Gagal keluar fullscreen: ${err.message}`);
                });
                fullscreenBtn.innerHTML =
                    '<i class="fas fa-expand text-white"></i>'; // ubah ikon jadi "masuk"
            }
        });

        // Deteksi jika user tekan ESC
        document.addEventListener('fullscreenchange', () => {
            if (!document.fullscreenElement) {
                fullscreenBtn.innerHTML = '<i class="fas fa-expand text-white"></i>';
            }
        });

        $(document).on('click', '#btn-cetak-struk', function() {
            const t = window.transaksiTerakhir;
            if (!t) {
                Swal.fire('⚠️', 'Data transaksi tidak ditemukan.', 'warning');
                return;
            }

            // Format daftar item
            let itemRows = '';
            t.items.forEach(i => {
                const nama = i.barang_nama ?? i.barang_id;
                const harga = i.harga_jual?.toLocaleString('id-ID') ?? '0';
                const subtotal = i.subtotal?.toLocaleString('id-ID') ?? '0';
                itemRows += `
            <tr>
                <td colspan="2">${nama}</td>
                <td style="text-align:right;">Rp ${harga}</td>
            </tr>
            <tr>
                <td style="width:10%;"></td>
                <td>${i.qty} x Rp ${harga}</td>
                <td style="text-align:right;">Rp ${subtotal}</td>
            </tr>
        `;
            });
            const logoPath = document.querySelector('.theme-light-show')?.getAttribute('src') ||
                "{{ asset('assets/media/logos/keenthemes.svg') }}";
            // Template Struk
            const strukHTML = `
    <div style="font-family: monospace; font-size: 12px; width: 260px; margin: auto;">
   <div style="text-align:center;">
        <img src="${logoPath}" style="width:100%;height:60px;object-fit:contain;">
        <div>Jl. KL. Yos Sudarso PAJAK SORE km 9,5, M A B A R, Kec. Medan Deli, Kota Medan, Sumatera Utara 20242 Telp: 081210003014</div>
        <hr style="border-top:1px dashed #000;">
    </div>
        <div style="line-height:1.4;">
            <div>Tanggal : ${new Date(t.tanggal).toLocaleDateString('id-ID')}</div>
            <div>Kode    : ${t.no_penjualan}</div>
            <div>Customer: ${t.customer ?? '-'}</div>
            <div>Kasir   : {{ Auth::user()->name }}</div>
            <hr style="border-top:1px dashed #000;">
        </div>

        <table style="width:100%;border-collapse:collapse;">
            <tbody>${itemRows}</tbody>
        </table>

        <hr style="border-top:1px dashed #000;">

        <div style="display:flex;justify-content:space-between;">
            <span>Total</span><span>${t.total ?? '-'}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
            <span>Bayar</span><span>${t.uang ?? '-'}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
            <span>Kembalian</span><span>${t.kembalian ?? '-'}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
            <span>Metode</span><span>${t.pembayaran_nama ?? '-'}</span>
        </div>

        <hr style="border-top:1px dashed #000;">
        <div style="text-align:center;margin-top:5px;">
            Terima Kasih Atas Kunjungan Anda
        </div>
    </div>
    `;

            // Cetak struk ke window baru
            const printWindow = window.open('', '', 'width=400,height=600');
            printWindow.document.write(`
        <html>
        <head>
            <title>Struk Penjualan</title>
            <style>
                body { font-family: monospace; margin: 0; padding: 10px; font-size: 12px; }
                hr { border: 1px dashed #000; }
                table { width: 100%; border-collapse: collapse; }
                td { padding: 2px 0; vertical-align: top; }
            </style>
        </head>
        <body>
            ${strukHTML}
        </body>
        </html>
    `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        });

    });
</script>
@endpush
@endsection