{{-- Statistik Box (Ini tidak berubah) --}}
<div class="row g-5 g-xl-8 mb-10">
    <div class="col-xl-3">
        <div class="card bg-light-success hoverable card-xl-stretch">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <div class="text-success fw-bold fs-2 mb-3">Rp {{ number_format($total_penjualan, 0, ',', '.') }}</div>
                <div class="fw-semibold text-success">Total Penjualan</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card bg-light-warning hoverable card-xl-stretch">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <div class="text-warning fw-bold fs-2 mb-3">Rp {{ number_format($total_pembelian, 0, ',', '.') }}</div>
                <div class="fw-semibold text-warning">Total Pembelian</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card bg-light-danger hoverable card-xl-stretch">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <div class="text-danger fw-bold fs-2 mb-3">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</div>
                <div class="fw-semibold text-danger">Total Pengeluaran</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card bg-light-primary hoverable card-xl-stretch">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <div class="text-primary fw-bold fs-2 mb-3">Rp {{ number_format($laba_rugi, 0, ',', '.') }}</div>
                <div class="fw-semibold text-primary">Laba / Rugi</div>
            </div>
        </div>
    </div>
</div>
{{-- End Statistik Box --}}


{{-- BARIS 1: Detail Penjualan --}}
<div class="row g-5 g-xl-8">
    <div class="col-lg-12">
        <div class="card card-flush">
            <div class="card-header">
                <h3 class="card-title">Detail Penjualan (Pendapatan)</h3>
            </div>
            {{-- MODIFIKASI: Hapus p-0 untuk padding --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted">
                                {{-- MODIFIKASI: Tambah text-center --}}
                                <th class="text-center">Nama Barang</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($detail_penjualan as $item)
                                <tr>
                                    <td>{{ $item->barang->nama ?? 'N/A' }}</td>
                                    <td class="text-end">{{ $item->qty }}</td>
                                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada penjualan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BARIS 2: Detail Pembelian --}}
<div class="row g-5 g-xl-8">
    <div class="col-lg-12">
        <div class="card card-flush">
            <div class="card-header">
                <h3 class="card-title">Detail Pembelian (Barang Masuk)</h3>
            </div>
            {{-- MODIFIKASI: Hapus p-0 untuk padding --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted">
                                {{-- MODIFIKASI: Tambah text-center --}}
                                <th class="text-center">No. Transaksi</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($detail_pembelian as $item)
                                <tr>
                                    <td>{{ $item->barangMasuk->kode_transaksi ?? '-' }}</td>
                                    <td>{{ $item->barang->nama ?? 'N/A' }}</td>
                                    <td class="text-end">{{ $item->qty }}</td>
                                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada pembelian</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BARIS 3: Detail Pengeluaran --}}
<div class="row g-5 g-xl-8">
    <div class="col-lg-12">
        <div class="card card-flush">
            <div class="card-header">
                <h3 class="card-title">Detail Pengeluaran (Biaya)</h3>
            </div>
            {{-- MODIFIKASI: Hapus p-0 untuk padding --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted">
                                {{-- MODIFIKASI: Tambah text-center --}}
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($detail_pengeluaran as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->kategori->nama ?? 'N/A' }}</td>
                                    <td class="text-end">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada pengeluaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BARIS 4: Komparasi Profit --}}
<div class="row g-5 g-xl-8">
    <div class="col-lg-12">
        <div class="card card-flush">
            <div class="card-header">
                <h3 class="card-title">Komparasi Profit Item Terjual</h3>
            </div>
            {{-- MODIFIKASI: Hapus p-0 untuk padding --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted">
                                {{-- MODIFIKASI: Tambah text-center --}}
                                <th class="text-center">Nama Barang</th>
                                <th class="text-end">Hrg. Beli</th>
                                <th class="text-end">Hrg. Jual</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($detail_penjualan as $item)
                                @php
                                    $profit = $item->subtotal - $item->harga_beli * $item->qty;
                                @endphp
                                <tr>
                                    <td>{{ $item->barang->nama ?? 'N/A' }}</td>
                                    <td class="text-end">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                    <td class="text-end">{{ $item->qty }}</td>
                                    <td class="text-end">Rp {{ number_format($profit, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada penjualan</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="fw-semibold">
                            <tr class="table-light">
                                <th colspan="4" class="text-end">Total Profit Kotor</th>
                                <th class="text-end">Rp {{ number_format($total_profit_kotor, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
