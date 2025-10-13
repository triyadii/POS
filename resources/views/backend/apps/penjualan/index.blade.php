@extends('layouts.backend.index')
@section('title', 'Kasir Penjualan')
@section('content')

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
                        <a href="#" class="btn btn-sm btn-light-primary">
                            <i class="ki-outline ki-plus fs-2 me-2"></i>Customer
                        </a>
                    </div>
                </div>

                <div class="card-body p-9 pt-5">
                    <form id="form-penjualan">
                        @csrf
                        <div class="row gx-6 gx-xl-9 mb-2">
                            <div class="col-lg-6 mb-2">
                                <input type="date" class="form-control" name="tanggal" id="tanggal"
                                    value="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="col-lg-6 mb-2">
                                <input type="text" class="form-control form-control-solid" name="no_penjualan"
                                    id="no_penjualan" value="{{ $no_penjualan }}" readonly />
                            </div>
                        </div>

                        <div class="row gx-6 gx-xl-9 align-items-end mb-6">
                            <div class="col-lg-12 mb-2">
                                <select class="form-select" id="customer_id">
                                    <option value="">Pilih Customer</option>
                                </select>
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
                                <input type="text" class="form-control" id="uang-diterima-penjualan" placeholder="0">
                                <label class="mt-3">Kembalian</label>
                                <input type="text" class="form-control form-control-solid" id="kembalian-penjualan"
                                    readonly>
                            </div>
                            <div class="col-lg-6">
                                <label>Total</label>
                                <input type="text" class="form-control form-control-solid" id="total-penjualan"
                                    readonly>
                                <label class="mt-3">Pembayaran</label>
                                <select class="form-select" id="pembayaran-penjualan">
                                    <option value="cash">Cash</option>
                                    <option value="mandiri">Bank Mandiri</option>
                                    <option value="bca">Bank BCA</option>
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
<div class="modal fade" id="modalPenjualanSelesai" tabindex="-1">
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
                    <div class="d-flex justify-content-between"><span>Total</span><span id="modal-total"></span></div>
                    <div class="d-flex justify-content-between"><span>Tunai</span><span id="modal-uang-diterima"></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold"><span>Kembalian</span><span
                            id="modal-kembalian"></span></div>
                </div>

                <button class="btn btn-secondary mt-4 w-100" data-bs-dismiss="modal">Selesai</button>
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
                                <th>Total Item</th>
                                <th>Total Harga</th>
                                <th>Catatan</th>
                                <th>Detail</th>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <td>${p.total_item}</td>
                    <td>Rp ${parseInt(p.total_harga).toLocaleString('id-ID')}</td>
                    <td>${p.catatan ?? '-'}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-light-primary" onclick="lihatDetail('${p.id}')">
                            <i class="fas fa-eye"></i> Lihat
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
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const produkData = @json($produk);

        // ✅ Data dummy customer
        const customerDummy = ["Andi", "Budi", "Citra"];
        customerDummy.forEach((c, i) => {
            $('#customer_id').append(`<option value="${i+1}">${c}</option>`);
        });

        // Render produk dari database
        function renderProduk(data) {
            const container = document.querySelector('.daftar-produk');
            container.innerHTML = '';
            data.forEach(p => {
                const card = document.createElement('div');
                card.className = 'col-lg-6 mb-3';
                card.innerHTML = `
                <div class="card card-flush p-2 text-center produk-item" data-id="${p.id}">
                    <div class="fw-bold">${p.nama}</div>
                    <div class="text-muted">${p.kategori ? p.kategori.nama : '-'}</div>
                    <div class="text-success">Rp ${parseInt(p.harga_jual).toLocaleString('id-ID')}</div>
                </div>`;
                container.appendChild(card);
            });

            document.querySelectorAll('.produk-item').forEach(item => {
                item.addEventListener('click', function() {
                    const produk = produkData.find(p => p.id == this.dataset.id);
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
            <td>Rp ${parseInt(produk.harga_jual).toLocaleString('id-ID')}</td>
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
            const harga = parseInt(tr.children[2].textContent.replace(/[^\d]/g, ''));
            const qty = parseInt(input.value);
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
            const hasil = produkData.filter(p =>
                p.nama.toLowerCase().includes(search) &&
                (kategori === '' || (p.kategori && p.kategori.nama === kategori))
            );
            renderProduk(hasil);
        }, 300));

        renderProduk(produkData);

        // Simulasi submit
        $('#form-penjualan').on('submit', function(e) {
            e.preventDefault();

            const rows = $('#purchase_cart_list tr');
            if (rows.length === 0) return Swal.fire('Oops!', 'Belum ada produk yang dipilih', 'warning');

            // Ambil semua item
            const items = [];
            rows.each(function() {
                const id = $(this).attr('id').replace('row-', '');
                const qty = parseInt($(this).find('.qty').val());
                const harga = parseInt($(this).find('td:nth-child(3)').text().replace(/[^\d]/g,
                    ''));
                const subtotal = harga * qty;
                items.push({
                    barang_id: id,
                    qty: qty,
                    harga_jual: harga,
                    subtotal: subtotal
                });
            });

            const payload = {
                _token: $('input[name="_token"]').val(),
                no_penjualan: $('#no_penjualan').val(),
                tanggal: $('#tanggal').val(),
                customer_nama: $('#customer_id option:selected').text(),
                total_item: items.length,
                total_harga: parseInt($('#total-penjualan').val().replace(/[^\d]/g, '')),
                catatan: $('#catatan').val(),
                items: items
            };

            $.ajax({
                url: "{{ route('penjualan.store') }}",
                method: "POST",
                data: payload,
                success: function(res) {
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
                            $('#form-penjualan')[0].reset();
                            $('#purchase_cart_list').html('');
                            updateTotal();
                        });
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire('Error', 'Gagal menyimpan transaksi', 'error');
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
    });
</script>
@endpush
@endsection