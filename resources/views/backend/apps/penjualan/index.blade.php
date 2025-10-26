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
                                    <input type="text" class="form-control form-control-solid fw-bold" name="tanggal"
                                        id="tanggal" readonly />
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <input type="text" class="form-control form-control-solid" name="no_penjualan"
                                        id="no_penjualan" value="{{ $no_penjualan }}" readonly />
                                </div>
                            </div>

                            <div class="row gx-6 gx-xl-9 align-items-end mb-6">
                                <div class="col-lg-12 mb-2">
                                    <label for="barcode" class="form-label fw-semibold text-gray-700 mb-1">
                                        <i class="fas fa-barcode fs-3 me-1 text-primary"></i> Scan / Masukkan Kode
                                        Barcode
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="barcode"
                                        placeholder="Scan barcode atau ketik kode barang lalu tekan Enter..." autofocus>
                                </div>
                            </div>


                            <div class="cart-payment mb-5">
                                <div class="table-responsive mb-6">
                                    <table class="table table-bordered align-middle">
                                        <thead class="bg-secondary">
                                            <tr>
                                                <th>Nama Artikel</th>
                                                <th>Kode Produk</th>
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

                            <div class="row gx-6 gx-xl-9 mb-6 align-items-start">
                                <!-- Kolom kiri: uang & potongan -->
                                <div class="col-lg-6">
                                    <div class="card border shadow-sm mb-4">
                                        <div class="card-body py-4 px-5">
                                            <div class="d-flex flex-column gap-3">
                                                <div>
                                                    <label class="form-label fw-semibold text-gray-700">
                                                        <i class="fas fa-money-bill-wave me-1 text-success"></i> Uang
                                                        Diterima
                                                    </label>
                                                    <input type="text"
                                                        class="form-control form-control-lg text-end fw-bold fs-5"
                                                        id="uang-diterima-penjualan" placeholder="0">
                                                </div>

                                                <div>
                                                    <label class="form-label fw-semibold text-gray-700">
                                                        <i class="fas fa-percent me-1 text-warning"></i> Potongan
                                                    </label>
                                                    <input type="text"
                                                        class="form-control form-control-lg text-end fw-bold fs-5"
                                                        id="potongan-penjualan" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card bg-light mb-3">
                                        <div
                                            class="card-body py-3 px-5 d-flex justify-content-between align-items-center">
                                            <span class="fw-semibold text-gray-700 fs-5">Kembalian</span>
                                            <span id="kembalian-penjualan" class="fw-bold text-success fs-4 text-end">Rp
                                                0</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kolom kanan: total & pembayaran -->
                                <div class="col-lg-6">
                                    <div class="card border shadow-sm mb-4">
                                        <div class="card-body py-4 px-5">
                                            <div class="d-flex flex-column gap-3">
                                                <div>
                                                    <label class="form-label fw-semibold text-gray-700">
                                                        <i class="fas fa-calculator me-1 text-primary"></i> Total Akhir
                                                    </label>
                                                    <input type="text"
                                                        class="form-control form-control-lg text-end fw-bold fs-5"
                                                        id="total-penjualan" readonly>
                                                </div>

                                                <div>
                                                    <label class="form-label fw-semibold text-gray-700">
                                                        <i class="fas fa-credit-card me-1 text-info"></i> Metode
                                                        Pembayaran
                                                    </label>
                                                    <select class="form-select form-select-lg fw-semibold"
                                                        id="pembayaran-penjualan" name="pembayaran">
                                                        <option value="">Pilih Metode Pembayaran</option>
                                                        @foreach($pembayaran as $p)
                                                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <label>Catatan</label>
                            <textarea class="form-control mb-3" id="catatan" rows="2"></textarea>

                            <div class="row gx-6 gx-xl-9">
                                <div class="col-lg-4 mb-2">
                                    <button type="button" class="btn btn-light-danger w-100" id="btn-batal-penjualan">
                                        <i class="fas fa-times me-1"></i> Batal
                                    </button>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <button type="button" class="btn btn-light-primary w-100" id="btn-simpan-penjualan">
                                        <i class="fas fa-save me-1"></i> Simpan
                                    </button>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <button type="button" class="btn btn-light-success w-100" id="btn-bayar-penjualan">
                                        <i class="fas fa-cash-register me-1"></i> Bayar & Cetak
                                    </button>
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
                                    <th>Kategori Penjualan</th> <!-- 🔹 ubah -->
                                    <th>Metode Pembayaran</th>
                                    <th>Total Item</th>
                                    <th>Total Harga</th>
                                    <th>Potongan</th> <!-- 🔹 kolom baru -->
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
                    <button type="button" class="btn-close " data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Size</th>
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

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /* =========================
   VARIABEL GLOBAL & UTIL
   ========================= */
    window.produkData = @json($produk); // sumber data awal dari server
    window.transaksiTerakhir = null; // untuk cetak struk

    // Format angka Rp 1.234
    function numToId(n) {
        return (parseInt(n) || 0).toLocaleString('id-ID');
    }
    // Ambil integer dari "Rp 1.234"
    function parseId(str) {
        return parseInt(String(str || '').replace(/[^\d]/g, '')) || 0;
    }

    /* =========================
       RENDER PRODUK (SATU-SATU)
       ========================= */
    window.renderProduk = function(data = window.produkData) {
        const container = document.querySelector('.daftar-produk');
        if (!container) return;

        container.innerHTML = '';
        if (!data || data.length === 0) {
            container.innerHTML = `
            <div class="text-center text-muted py-10">
                <i class="fas fa-box-open fs-2hx mb-3 d-block text-gray-400"></i>
                <div class="fw-semibold fs-5">Tidak ada produk ditemukan</div>
            </div>`;
            return;
        }

        const frag = document.createDocumentFragment();
        data.forEach(p => {
            const stok = parseInt(p.stok ?? 0);
            const habis = stok <= 0;

            // ✅ Fallback aman
            const kategoriNama = p.kategori?.nama ?? p.kategori_nama ?? '-';
            const kodeBarang = p.kode_barang ?? '-';

            const col = document.createElement('div');
            col.className = 'col-xl-3 col-lg-4 col-md-6 mb-4';
            col.innerHTML = `
          <div class="card shadow-sm produk-item border-0 h-100 ${habis ? 'bg-light-secondary' : ''}"
               data-id="${p.id}"
               style="cursor:${habis ? 'not-allowed' : 'pointer'};opacity:${habis ? 0.6 : 1};transition:.2s;">
            <div class="card-body p-3 d-flex flex-column align-items-center justify-content-between">
                <div class="text-center">
                    <div class="fw-bold fs-6 text-dark mb-1">${p.nama ?? '-'}</div>
                    <div class="text-muted small mb-1">${kategoriNama}</div>
                    <div class="text-muted small mb-1">Brand: <span class="fw-semibold text-dark">${p.brand?.nama ?? '-'}</span></div>
                    <div class="text-muted small mb-1">Size: <span class="fw-semibold text-dark">${p.size ?? '-'}</span></div>
                    <div class="badge badge-light-primary fw-semibold mb-2 px-3 py-1">
                        <i class="fas fa-barcode me-1"></i> ${kodeBarang}
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <div class="fw-bold text-success fs-6">Rp ${numToId(p.harga_jual ?? 0)}</div>
                    <div class="small mt-1 ${habis ? 'text-danger fw-bold' : 'text-muted'}">
                        ${habis ? 'Stok Habis' : 'Stok: ' + stok}
                    </div>
                </div>
            </div>
          </div>`;
            frag.appendChild(col);
        });
        container.appendChild(frag);

        container.querySelectorAll('.produk-item').forEach(item => {
            item.addEventListener('click', function() {
                const id = this.dataset.id;
                const produk = window.produkData.find(x => String(x.id) === String(id));
                if (!produk) return;
                const stok = parseInt(produk.stok ?? 0);
                if (stok <= 0) {
                    Swal.fire('⚠️ Stok Habis', 'Produk ini sudah tidak tersedia', 'warning');
                    return;
                }
                tambahKeTabel(produk);
            });
        });
    };



    /* =========================
       KERANJANG & PERHITUNGAN
       ========================= */
    function tambahKeTabel(produk) {
        const tbody = document.getElementById('purchase_cart_list');
        const id = `row-${produk.id}`;
        const exists = document.getElementById(id);

        if (exists) {
            const qtyInput = exists.querySelector('input.qty');
            qtyInput.value = (parseInt(qtyInput.value) || 0) + 1;
            updateSubtotal(qtyInput);
            return;
        }

        const tr = document.createElement('tr');
        tr.id = id;
        tr.innerHTML = `
      <td>
        <div class="fw-semibold">${produk.nama}</div>
        <small class="text-muted d-block">Brand: ${produk.brand?.nama ?? '-'}</small>
        <small class="text-muted d-block">Size: ${produk.size ?? '-'}</small>
      </td>
      <td>${produk.kode_barang}</td>
      <td>
        Rp ${numToId(produk.harga_jual)}
        <input type="hidden" class="harga-beli" value="${produk.harga_beli ?? 0}">
      </td>
      <td><input type="number" class="form-control qty" value="1" min="1" style="width:80px"></td>
      <td class="subtotal">Rp ${numToId(produk.harga_jual)}</td>
      <td class="text-end">
        <button class="btn btn-sm text-danger hapus-item"><i class="fas fa-trash"></i></button>
      </td>`;
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
        const produk = window.produkData.find(p => String(p.id) === String(produkId));
        const stok = parseInt(produk?.stok ?? 0);
        let qty = parseInt(input.value) || 1;

        if (qty > stok) {
            qty = stok;
            input.value = stok;
            Swal.fire('⚠️ Stok Tidak Cukup', `Stok ${produk?.nama ?? ''} hanya ${stok}`, 'warning');
        }

        const harga = parseId(tr.children[2].textContent);
        const subtotal = harga * qty;
        tr.querySelector('.subtotal').textContent = `Rp ${numToId(subtotal)}`;
        updateTotal();
    }

    function updateTotal() {
        // Hitung total semua item
        const subtotalEls = document.querySelectorAll('#purchase_cart_list .subtotal');
        let total = 0;
        subtotalEls.forEach(el => total += parseId(el.textContent));

        // Ambil potongan (kosong = 0)
        const potongan = parseId($('#potongan-penjualan').val()) || 0;
        const totalAkhir = Math.max(total - potongan, 0);

        // Update input total
        $('#total-penjualan').val(`Rp ${numToId(totalAkhir)}`);

        // Hitung ulang kembalian
        updateKembalian();
    }

    function updateKembalian() {
        const total = parseId($('#total-penjualan').val());
        const uang = parseId($('#uang-diterima-penjualan').val());
        const kembalian = uang - total;

        // Ganti warna otomatis jika uang kurang
        const kembalianEl = $('#kembalian-penjualan');
        if (kembalian < 0) {
            kembalianEl.removeClass('text-success').addClass('text-danger');
            kembalianEl.text(`Rp ${numToId(Math.abs(kembalian))} (Kurang)`);
        } else {
            kembalianEl.removeClass('text-danger').addClass('text-success');
            kembalianEl.text(`Rp ${numToId(kembalian)}`);
        }
    }
    /* =========================
       TANGGAL REALTIME
       ========================= */
    function updateTanggalRealtime() {
        const now = new Date();
        const y = now.getFullYear();
        const m = String(now.getMonth() + 1).padStart(2, '0');
        const d = String(now.getDate()).padStart(2, '0');
        const h = String(now.getHours()).padStart(2, '0');
        const i = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        const tampil = `${d}-${m}-${y} ${h}:${i}:${s}`;
        const raw = `${y}-${m}-${d} ${h}:${i}:${s}`;
        $('#tanggal').val(tampil).data('raw', raw);
    }
    setInterval(updateTanggalRealtime, 1000);
    updateTanggalRealtime();

    /* =========================
       SUBMIT / SIMPAN / CETAK
       ========================= */
    function kumpulkanItems() {
        const rows = $('#purchase_cart_list tr');
        const items = [];
        rows.each(function() {
            const id = $(this).attr('id').replace('row-', '');
            const nama = $(this).find('td:nth-child(1)').text();
            const qty = parseInt($(this).find('.qty').val());
            const harga = parseId($(this).find('td:nth-child(3)').text());
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
        return items;
    }

    function optimisticKurangiStok(items) {
        // Kurangi stok di window.produkData agar UI langsung berubah
        items.forEach(i => {
            const p = window.produkData.find(x => String(x.id) === String(i.barang_id));
            if (p) {
                p.stok = Math.max(0, (parseInt(p.stok) || 0) - (parseInt(i.qty) || 0));
            }
        });
        window.renderProduk(window.produkData);
    }

    function refetchProduk() {
        // Sync ulang dari server
        $.get(`{{ route('penjualan.produk.data') }}?t=${Date.now()}`, function(newProduk) {
            window.produkData = newProduk;
            window.renderProduk(newProduk);
        }).fail(() => console.warn('⚠️ Gagal refresh stok produk'));
    }

    function generateStrukHTML(payload) {
        const numToId = (v) => {
            if (v === null || v === undefined) return '0';
            const clean = String(v).replace(/[^\d]/g, '');
            const num = parseInt(clean || '0', 10);
            return num.toLocaleString('id-ID');
        };
        const tanggalCetak = new Date(payload.tanggal_raw || payload.tanggal_penjualan || payload.tanggal).toLocaleString(
            'id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

        const items = payload.items || payload.detail || [];
        let itemRows = '';
        items.forEach(i => {
            const nama = i.barang_nama ?? i.barang?.nama ?? '-';
            const harga = numToId(i.harga_jual ?? 0);
            const subtotal = numToId(i.subtotal ?? 0);
            const qty = i.qty ?? 1;
            itemRows += `
        <tr>
            <td colspan="2">${nama}</td>
            <td style="text-align:right;"></td>
        </tr>
        <tr>
            <td></td>
            <td>${qty} x Rp ${harga}</td>
            <td style="text-align:right;">Rp ${subtotal}</td>
        </tr>`;
        });

        const namaToko = document.title || 'TOKO MAJU JAYA';
        const potongan = payload.potongan ?? 0;
        const potonganStr = potongan > 0 ? `- Rp ${numToId(potongan)}` : `Rp ${numToId(0)}`;

        // Ambil logo dinamis dari backend Laravel
        const logoUrl = "{{ asset('storage/' . ($appSetting->logo_black ?? 'settings/logo_black_1761010416.svg')) }}";

        return `
    <div style="font-family: monospace; font-size: 13px; width: 58mm; margin: 0 auto;">
        <div style="text-align:center;">
            <img src="${logoUrl}" alt="Logo"
                style="display:block; margin:0 auto 8px auto; width:140px; height:auto; object-fit:contain;">
            <div style="font-size:13px; line-height:1.3;">
                Jl. KL. Yos Sudarso Pajak Sore Km 9.5, Mabar<br>
                Medan Deli, Kota Medan<br>
                Telp: 0812-1000-3014
            </div>
            <hr style="border-top:1px dashed #000; margin-top:6px;">
        </div>

        <div style="line-height:1.3;margin-bottom:5px;">
            <div>Tanggal : ${tanggalCetak}</div>
            <div>Kode    : ${payload.no_penjualan ?? payload.kode_transaksi ?? '-'}</div>
            <div>Kasir   : {{ Auth::user()->name }}</div>
            <div>Pembayaran : ${payload.pembayaran_nama ?? payload.pembayaran?.nama ?? '-'}</div>
            <div>Kategori : Offline</div>
        </div>

        <hr style="border-top:1px dashed #000;">
        <table style="width:100%;border-collapse:collapse;">
            <tbody>${itemRows}</tbody>
        </table>
        <hr style="border-top:1px dashed #000;">

        <div style="display:flex;justify-content:space-between;">
            <span>Potongan</span>
            <span>Rp ${numToId(payload.potongan ?? 0)}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
            <span>Total</span>
            <span>Rp ${numToId(payload.total ?? payload.total_harga ?? 0)}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
            <span>Bayar</span>
            <span>Rp ${numToId(payload.uang)}</span>
        </div>
        <div style="display:flex;justify-content:space-between;">
            <span>Kembalian</span>
            <span>Rp ${numToId(payload.kembalian ?? 0)}</span>
        </div>


        <hr style="border-top:1px dashed #000;">
        <div style="text-align:center;font-size:14px;margin-top:4px;">
            Terima Kasih 😊<br>
            --- Struk Non Pajak ---
        </div>
    </div>`;
    }

    function cetakStruk(payload) {
        const strukHTML = generateStrukHTML(payload);

        const printWindow = window.open('', '', 'width=400,height=800');
        printWindow.document.write(`
      <html>
      <head>
        <title>Struk Penjualan</title>
        <style>
          body {
            font-family: monospace;
            font-size: 13px;
            margin: 0;
            padding: 4px;
            width: 58mm;
            color: #000;
          }
          hr { border: 1px dashed #000; margin: 4px 0; }
          table { width: 100%; border-collapse: collapse; }
          td { padding: 1px 0; vertical-align: top; }
          div, td, span { line-height: 1.3; }
          @page { size: 58mm auto; margin: 0; }
          @media print {
            html, body { width: 58mm; height: auto; overflow: visible !important; }
            table, tr, td, div, p { page-break-inside: avoid; }
          }
        </style>
      </head>
      <body onload="window.print(); setTimeout(() => window.close(), 500);">
        ${strukHTML}
      </body>
      </html>
    `);
        printWindow.document.close();
    }


    function cetakStrukHistory(id) {
        $.get("{{ route('penjualan.history.data') }}", function(res) {
            const trx = res.find(x => String(x.id) === String(id));
            if (!trx) {
                Swal.fire('⚠️', 'Data transaksi tidak ditemukan', 'warning');
                return;
            }

            const detail = Array.isArray(trx.detail) ? trx.detail : [];

            // Hitung total harga dari detail
            const total_harga = detail.reduce((sum, d) => {
                const subtotal = parseInt(d.subtotal ?? (d.harga_jual * d.qty) ?? 0);
                return sum + (isNaN(subtotal) ? 0 : subtotal);
            }, 0);

            // Ambil nilai sesuai database
            const potongan = parseInt(trx.potongan ?? trx.diskon ?? 0);
            const pembayaran = parseInt(trx.pembayaran ?? trx.uang_diterima ?? 0);

            // Perhitungan akhir
            const total = total_harga - potongan; // total bayar setelah potongan
            const kembalian = pembayaran - total; // uang kembalian

            // Payload untuk cetak struk
            const payload = {
                ...trx,
                detail,
                total_harga,
                potongan,
                total,
                pembayaran,
                kembalian
            };

            // Cetak struk
            cetakStruk(payload);
        });
    }





    function prosesTransaksi({
        cetak = false
    } = {}) {
        const rows = $('#purchase_cart_list tr');
        const btnSimpan = $('#btn-simpan-penjualan');
        const btnBayar = $('#btn-bayar-penjualan');

        if (rows.length === 0) {
            Swal.fire('Oops!', 'Belum ada produk yang dipilih', 'warning');
            return;
        }

        const total = parseId($('#total-penjualan').val());
        const uangDiterima = parseId($('#uang-diterima-penjualan').val());
        const kembalian = uangDiterima - total;

        const pembayaran = $('#pembayaran-penjualan').val();
        if (!pembayaran) {
            Swal.fire('Oops!', 'Silakan pilih jenis pembayaran terlebih dahulu.', 'warning');
            return;
        }
        if (cetak && kembalian < 0) {
            Swal.fire('⚠️', 'Nominal uang diterima belum cukup.', 'warning');
            return;
        }

        const items = kumpulkanItems();

        const payload = {
            _token: $('input[name="_token"]').val(),
            no_penjualan: $('#no_penjualan').val(),
            tanggal: $('#tanggal').val(),
            tanggal_raw: $('#tanggal').data('raw'),
            potongan: parseId($('#potongan-penjualan').val()) || 0,
            customer: $('#customer_id option:selected').text(),
            total_item: items.length,
            total: total, // angka murni
            uang: uangDiterima, // angka murni
            kembalian: kembalian, // angka murni
            catatan: $('#catatan').val(),
            jumlahPembayaran: parseId($('#uang-diterima-penjualan').val()) || 0,
            pembayaran: pembayaran,
            pembayaran_nama: $('#pembayaran-penjualan option:selected').text(),
            items
        };

        const btnTarget = cetak ? btnBayar : btnSimpan;
        btnTarget.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Memproses...');

        $.ajax({
            url: "{{ route('penjualan.store') }}",
            method: "POST",
            data: payload,
            success: function(res) {
                btnTarget.prop('disabled', false).html(cetak ?
                    '<i class="fas fa-cash-register me-1"></i> Bayar & Cetak' :
                    '<i class="fas fa-save me-1"></i> Simpan');

                if (res.status === 'success') {
                    // 1) Optimistic update stok -> UI langsung turun
                    optimisticKurangiStok(items);

                    // 2) Simpan transaksi terakhir (buat cetak)
                    window.transaksiTerakhir = payload;

                    // 3) Isi modal sukses
                    $('#modal-total').text(`Rp ${numToId(total)}`);
                    $('#modal-uang-diterima').text(`Rp ${numToId(uangDiterima)}`);
                    $('#modal-kembalian').text(`Rp ${numToId(kembalian)}`);

                    const modalSukses = new bootstrap.Modal('#modalPenjualanSelesai');
                    modalSukses.show();

                    // 4) Saat klik Selesai -> reset, ambil no transaksi baru, refetch stok
                    $('#modalPenjualanSelesai .btn-secondary').off('click').one('click', function() {
                        modalSukses.hide();

                        // reset form
                        $('#form-penjualan')[0].reset();
                        $('#purchase_cart_list').html('');
                        updateTotal();
                        $('#barcode').focus();

                        // nomor transaksi baru
                        $.get("{{ route('penjualan.no_otomatis') }}", function(r) {
                            if (r.no_penjualan) $('#no_penjualan').val(r.no_penjualan);
                        });

                        // sinkron ulang stok ke server (jaga-jaga)
                        setTimeout(refetchProduk, 350);
                    });

                    // 5) Kalau user pilih "Bayar & Cetak", langsung cetak
                    if (cetak) cetakStruk(payload);
                } else {
                    Swal.fire('Gagal', res.message ?? 'Gagal menyimpan transaksi', 'error');
                    // fallback: refetch stok biar aman kalau backend update tapi UI gagal
                    refetchProduk();
                }
            },
            error: function() {
                btnTarget.prop('disabled', false).html(cetak ?
                    '<i class="fas fa-cash-register me-1"></i> Bayar & Cetak' :
                    '<i class="fas fa-save me-1"></i> Simpan');
                Swal.fire('Error', 'Terjadi kesalahan di server', 'error');
            }
        });
    }

    /* =========================
       EVENT BINDINGS
       ========================= */
    $(document).ready(function() {

        // Render awal
        window.renderProduk(window.produkData);

        // Input uang diterima → format & kembalian
        $('#uang-diterima-penjualan').on('input', function(e) {
            const onlyNum = this.value.replace(/[^\d]/g, '');
            this.value = onlyNum.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            updateKembalian();
        });
        $('#potongan-penjualan').on('input', function() {
            const onlyNum = this.value.replace(/[^\d]/g, '');
            this.value = onlyNum.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            updateTotal();
        });

        // Filter cari produk
        $('#filter-cari-daftar-produk').on('input', _.debounce(function() {
            const search = this.value.toLowerCase();
            const kategori = $('#filter-kategori-daftar-produk').val();
            const hasil = window.produkData.filter(p => {
                const namaMatch = p.nama?.toLowerCase().includes(search);
                const kodeMatch = p.kode_barang?.toLowerCase().includes(search);
                const kategoriMatch = kategori === '' || (p.kategori && p.kategori.nama ===
                    kategori);
                return (namaMatch || kodeMatch) && kategoriMatch;
            });
            window.renderProduk(hasil);
        }, 250));

        // Filter kategori
        $('#filter-kategori-daftar-produk').on('change', function() {
            const kategori = $(this).val();
            const search = $('#filter-cari-daftar-produk').val().toLowerCase();
            const hasil = window.produkData.filter(p => {
                const namaMatch = p.nama?.toLowerCase().includes(search);
                const kodeMatch = p.kode_barang?.toLowerCase().includes(search);
                const kategoriMatch = kategori === '' || (p.kategori && p.kategori.nama ===
                    kategori);
                return (namaMatch || kodeMatch) && kategoriMatch;
            });
            window.renderProduk(hasil);
        });

        // Barcode enter
        $('#barcode').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                const kode = $(this).val().trim().toLowerCase();
                if (!kode) return;
                const produk = window.produkData.find(p => (p.kode_barang && p.kode_barang.toLowerCase() ===
                    kode));
                if (produk) {
                    const stok = parseInt(produk.stok ?? 0);
                    if (stok <= 0) {
                        Swal.fire('⚠️ Stok Habis', 'Produk ini sudah tidak tersedia', 'warning');
                        return;
                    }
                    tambahKeTabel(produk);
                    $(this).val('');
                } else {
                    Swal.fire('😕 Tidak ditemukan', 'Kode barcode tidak cocok dengan produk manapun.',
                        'info');
                }
            }
        });

        // Tombol simpan
        $('#btn-simpan-penjualan').off('click').on('click', function() {
            prosesTransaksi({
                cetak: false
            });
        });
        // Tombol bayar & cetak
        $('#btn-bayar-penjualan').off('click').on('click', function() {
            prosesTransaksi({
                cetak: true
            });
        });

        // Tombol batal
        $('#btn-batal-penjualan').off('click').on('click', function() {
            Swal.fire({
                title: 'Batalkan Transaksi?',
                text: 'Semua item akan dihapus dari keranjang!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tidak'
            }).then(res => {
                if (res.isConfirmed) {
                    $('#form-penjualan')[0].reset();
                    $('#purchase_cart_list').html('');
                    updateTotal();
                    Swal.fire('Dibatalkan', 'Transaksi telah dikosongkan.', 'success');
                    $('#barcode').focus();
                }
            });
        });

        // Fullscreen
        const fullscreenBtn = document.getElementById('btnFullscreen');
        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', function() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().catch(console.error);
                    fullscreenBtn.innerHTML = '<i class="fas fa-compress text-white"></i>';
                } else {
                    document.exitFullscreen().catch(console.error);
                    fullscreenBtn.innerHTML = '<i class="fas fa-expand text-white"></i>';
                }
            });
            document.addEventListener('fullscreenchange', () => {
                if (!document.fullscreenElement) {
                    fullscreenBtn.innerHTML = '<i class="fas fa-expand text-white"></i>';
                }
            });
        }

        /* =========================
           HISTORY & DETAIL & CETAK
           ========================= */
        $('.btn-light-info').off('click').on('click', function(e) {
            e.preventDefault();
            loadHistoryPenjualan();
            new bootstrap.Modal('#modalHistoryPenjualan').show();
        });

        window.loadHistoryPenjualan = function() {
            const tbody = $('#table-history tbody');
            tbody.html('<tr><td colspan="8" class="text-center">Memuat data...</td></tr>');
            $.get("{{ route('penjualan.history.data') }}", function(res) {
                if (!res.length) {
                    tbody.html(
                        '<tr><td colspan="8" class="text-center text-muted">Belum ada transaksi</td></tr>'
                    );
                    return;
                }
                tbody.html('');
                res.forEach(p => {
                    tbody.append(`
                <tr>
                    <td>${p.kode_transaksi}</td>
                    <td>${new Date(p.tanggal_penjualan).toLocaleDateString('id-ID')}</td>
                    <td>${p.kategori_penjualan ?? 'Offline'}</td> <!-- 🔹 Ubah dari customer -->
                    <td>${p.pembayaran ? p.pembayaran.nama : '-'}</td>
                    <td>${p.total_item}</td>
                    <td>Rp ${numToId(p.total_harga)}</td>
                    <td>Rp ${numToId(p.potongan ?? 0)}</td> <!-- 🔹 Tambah kolom potongan -->
                    <td class="text-center">
                    <button class="btn btn-sm btn-light-primary" onclick="lihatDetail('${p.id}')">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-light-success" onclick="cetakStrukHistory('${p.id}')">
                        <i class="fas fa-print"></i>
                    </button>
                    </td>
                </tr>
                `);
                });
            }).fail(() => tbody.html(
                '<tr><td colspan="8" class="text-center text-danger">Gagal memuat data</td></tr>'));
        };

        window.lihatDetail = function(id) {
            $('#detail-body').html('<tr><td colspan="4" class="text-center">Memuat...</td></tr>');
            $.get("{{ route('penjualan.history.data') }}", function(res) {
                const trx = res.find(x => String(x.id) === String(id));
                if (!trx || !trx.detail || trx.detail.length === 0) {
                    $('#detail-body').html(
                        '<tr><td colspan="4" class="text-center text-muted">Tidak ada detail</td></tr>'
                    );
                } else {
                    const rows = trx.detail.map(d => `
                  <tr>
                    <td>${d.barang?.kode_barang ?? '-'}</td>
                    <td>${d.barang?.nama ?? '-'}</td>
                    <td>${d.barang?.size ?? '-'}</td>
                    <td>${d.qty}</td>
                    <td>Rp ${numToId(d.harga_jual)}</td>
                    <td>Rp ${numToId(d.subtotal)}</td>
                  </tr>`);
                    $('#detail-body').html(rows.join(''));
                }
                new bootstrap.Modal('#modalDetailPenjualan').show();
            });
        };



    });
</script>
@endpush

@endsection